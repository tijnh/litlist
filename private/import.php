<?php


$_SERVER['SERVER_NAME'] = 'localhost';

require 'app/core/config.php';
require 'app/core/Database.php';

//CLI command: php -r "require 'C:/xampp/htdocs/litlist/private/import.php';" 

function run($filepath){
  $importModel = new Import;
  $importModel->csvToDb($filepath);
}

class Import {
  
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
  
    // Find row index for every col e.g. "title is the first column col", so $colIdx["title"] = 0
    foreach ($cols as $col) {
      $colIdx[$col] = array_search($col, $fileCols);
    }
  
    $booksTotal = 0;
    $booksImported = 0;
    $booksFailed = 0;
    // loop over every row (= book)
    while ($bookRow = fgetcsv($file, $length, $separator)) {
      $booksTotal += 1;
      // Create array with info for this book. E.g. $book["title] = 'Reis van flessen', $book["image_link"] 'http://www..." etc.
      $book = [];
  
      foreach ($cols as $col) {
        $book[$col] = $bookRow[$colIdx[$col]];
      }
  
      // If no title, stop and show which book
      if (empty($book["title"])) {
        $rowNum = $booksTotal + 1;
        $this->show_error("BookNotFoundError", "row {$rowNum}");
        $booksFailed += 1;
        continue;
      }
  
  
  
      $book = $this->setInvalidValuesToNull($book, $intCols, $strCols);
  
      // Clean themes
      $book["themes"] = $this->themesToArray($book["themes"]);
  
      // Escape special characters for SQL statement
      $book = $this->trimArrayItems($book);
      $book = $this->escapeArrayItems($book);
  
  
      // Data to go into 'books' table
      $booksTableQuery = "INSERT INTO books (title, image_link, publication_year, audiobook, pages, blurb, summary, reading_level, review_text, review_link, secondary_literature_text, secondary_literature_link) 
      VALUES (\"{$book['title']}\", \"{$book['image_link']}\", {$book['publication_year']}, \"{$book['audiobook']}\", {$book['pages']}, \"{$book['blurb']}\", \"{$book['summary']}\", {$book['reading_level']}, \"{$book['review_text']}\", \"{$book['review_link']}\", \"{$book['secondary_literature_text']}\", \"{$book['secondary_literature_link']}\");";
  
      // $result = $this->query($booksTableQuery);
      // echo $result;
    }
  
  
    fclose($file);
    echo "\n---\nREPORT\n---\n";
    echo "BooksTotal: $booksTotal\n";
    echo "BooksFailed: $booksFailed\n";
    echo "BooksImported: $booksImported\n";
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
  
  function themesToArray($str)
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
}


run("private/books.csv");