<?php


$_SERVER['SERVER_NAME'] = 'localhost';

require 'app/core/config.php';
require 'app/core/Database.php';

//CLI command: php -r "require 'C:/xampp/htdocs/litlist/private/import.php';" 

function run($filepath)
{
  $importModel = new Import;
  $importModel->csvToDb($filepath);
}

class Import
{

  use Database;

  public function csvToDb($filepath)
  {

    $file = fopen("$filepath", "r");
    $length = 0; // 0 = maximum line length unlimited
    $separator = ";";

    $cols = ["title", "image_link", "first_name", "last_name", "infix", "publication_year", "audiobook", "pages", "blurb", "summary", "genres", "themes", "reading_level", "recommendation_level", "review_text", "review_link", "secondary_literature_text", "secondary_literature_link"];
    $intCols = ["publication_year", "pages", "reading_level", "recommendation_level"];
    $strCols = ["image_link", "first_name", "last_name", "infix", "audiobook", "blurb", "summary", "genres", "themes", "review_text", "review_link", "secondary_literature_text", "secondary_literature_link"];


    $fileCols = fgetcsv($file, $length, $separator);

    // Find row index for every col e.g. title is the first column, so $colIdx["title"] = 0
    foreach ($cols as $col) {
      $colIdx[$col] = array_search($col, $fileCols);
    }

    $numBooks = 0;
    $errors = [];

    // loop over every row in csv. Each row is a book.
    while ($bookRow = fgetcsv($file, $length, $separator)) {
      
      $numBooks += 1;

      // Create array with info for this book. 
      // E.g. $book["title] = 'Reis van flessen', $book["image_link"] 'http://www..." 
      $book = [];
      foreach ($cols as $col) {
        $book[$col] = $bookRow[$colIdx[$col]];
      }

      // If no title, log error and stop this book
      if (empty($book["title"])) {
        $rowNum = $numBooks + 1;
        $errors[] = $this->log_error("TitleNotFoundError", "row {$rowNum}");
        continue;
      }
      
      // Set invalid values to "NULL"
      $book = $this->setInvalidValuesToNull($book, $intCols, $strCols);
      
      // Separate themes string (e.g. "liefde", "Andere-plaatsen") to an array,
      // like: [0] => liefde, [1] andere plaatsen
      $book["themes"] = $this->formatThemes($book["themes"]);
      
      // Remove unnecessary whitespace everywhere
      $book = $this->trimArrayItems($book);

      // Escape special characters everywhere
      $book = $this->escapeArrayItems($book);

      // If book already in database, log error and stop this book
      if ($this->getBookId($book)) {
        $errors[] = $this->log_error("DublicateBookError", $book["title"]);
        continue;
      } 

      // Try to insert book into database, log error and stop if it fails
      try {
        $this->insertIntoBooksTable($book);
      } catch (PDOException) {
        $errors[] = $this->log_error("InsertError", $book["title"]);
        continue;
      }
      
      // Get book id that has been assigned by database
      $book["book_id"] = $this->getBookId($book);
      
    }

    $numErrors = count($errors);

    fclose($file);
    echo "---\nREPORT\n---\n";
    echo "BooksTotal: $numBooks\n";
    echo "BooksFailed: $numErrors\n";
    foreach($errors as $error) {
      echo $error . "\n";
    }
  }

  function getBookId($book)
  {
    $query = "SELECT book_id FROM books WHERE title = \"{$book['title']}\"";

    if($book["publication_year"] === "NULL") {
     $query .= " AND publication_year IS NULL";
    } else {
      $query .= " AND publication_year = {$book['publication_year']}";
    }
    
    if($book["pages"] === "NULL") {
     $query .= " AND pages IS NULL";
    } else {
      $query .= " AND pages = {$book['pages']}";
    }

    $query .= ";";

    $result = $this->query($query);
    if ($result) {
      return $result[0]["book_id"];
    } else {
      return false; 
    }
  }

  function insertIntoBooksTable($book)
  {
    // Data to go into 'books' table
    $query = "INSERT INTO books (title, image_link, publication_year, audiobook, pages, blurb, summary, reading_level, review_text, review_link, secondary_literature_text, secondary_literature_link) 
      VALUES (\"{$book['title']}\", \"{$book['image_link']}\", {$book['publication_year']}, \"{$book['audiobook']}\", {$book['pages']}, \"{$book['blurb']}\", \"{$book['summary']}\", {$book['reading_level']}, \"{$book['review_text']}\", \"{$book['review_link']}\", \"{$book['secondary_literature_text']}\", \"{$book['secondary_literature_link']}\");";

    $this->query($query);
  }

  function setInvalidValuesToNull($book, $intCols, $strCols)
  {

    // Set empty values to NULL
    foreach ($book as $col => $value) {
      if ($book[$col] === "") {
        $book[$col] = "NULL";
      }
    }

    // If INT expected, but not given -> set value to NULL
    foreach ($intCols as $col) {
      if (!filter_var($book[$col], FILTER_VALIDATE_INT) && $book[$col] !== "NULL") {
        $this->show_error("ValueError", $book["title"], $col, $book[$col], "NULL");
        $book[$col] = "NULL";
      }
    }

    // If STR expected, but INT given -> set value to NULL
    foreach ($strCols as $col) {
      if (filter_var($book[$col], FILTER_VALIDATE_INT) && $book[$col] !== "NULL") {
        $this->show_error("ValueError", $book["title"], $col, $book[$col], "NULL");
        $book[$col] = "NULL";
      }
    }

    return $book;
  }


  function escapeArrayItems(array $arr)
  {
    /* Escapes characters that will causes issues in SQL statement */

    foreach ($arr as $key => $value) {
      if (isset($arr[$key])) {

        if (is_array($arr[$key])) {
          $arr[$key] = $this->escapeArrayItems($arr[$key]);
        } else {
          $arr[$key] = addslashes($arr[$key]);
        }
      }
    }

    return $arr;
  }

  function trimArrayItems(array $arr)
  {

    foreach ($arr as $key => $value) {
      if (isset($arr[$key])) {

        if (is_array($arr[$key])) {
          $arr[$key] = $this->trimArrayItems($arr[$key]);
        } else {
          // Trim: remove leading and trailing whitespace
          // Preg_replace: replace double whitespaces by a single one
          $arr[$key] = trim(preg_replace('/\s{2,}/', ' ', $arr[$key]));
        }
      }
    }

    return $arr;
  }

  function formatThemes($str)
  {
    $str = str_replace("\"", "", $str);
    $str = str_replace("-", " ", $str);
    $str = strtolower($str);
    $themesArray = explode(",", $str);
    return $themesArray;
  }

  function show_error($errorType, $book, $col = NULL, $oldValue = NULL, $newValue = NULL)
  {
    $msg = "\e[33m{$errorType} \e[0m";

    if ($col) {
      $msg .= "{$col} ";
    }
    if ($oldValue) {
      $msg .= "\e[31m{$oldValue}\e[0m set to ";
    }
    if ($newValue) {
      $msg .= "\e[32m{$newValue} \e[0m";
    }

    $msg .= "(\e[36m{$book}\e[0m)";
    print($msg . "\n");
  }

  function log_error($errorType, $book, $col = NULL, $oldValue = NULL, $newValue = NULL)
  {
    $msg = "\e[33m{$errorType} \e[0m";

    if ($col) {
      $msg .= "{$col} ";
    }
    if ($oldValue) {
      $msg .= "\e[31m{$oldValue}\e[0m set to ";
    }
    if ($newValue) {
      $msg .= "\e[32m{$newValue} \e[0m";
    }

    $msg .= "(\e[36m{$book}\e[0m)";
    return $msg;
  }

}


run("private/books.csv");
