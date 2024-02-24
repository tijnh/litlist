<?php

// CLI command: php -r "require 'C:/xampp/htdocs/litlist/private/import.php';" 



// DELETE FROM books;
// DELETE FROM themes;
// DELETE FROM books_themes;
// DELETE FROM authors;
// DELETE FROM books_authors;

// ALTER TABLE books AUTO_INCREMENT = 1;
// ALTER TABLE themes AUTO_INCREMENT = 1;
// ALTER TABLE authors AUTO_INCREMENT = 1;

define("FILEPATH", "private/books.csv");
define("LOGFILE", "private/importLog.log");

$_SERVER['SERVER_NAME'] = 'localhost';

require 'app/core/config.php';
require 'app/core/Database.php';
require 'app/core/functions.php';



function run($filepath)
{
  $importModel = new Import;
  $importModel->csvToDb($filepath);
}

class Import
{
  
  use Database;

  private $allColumns = [
    "title",
    "image_link",
    "first_name",
    "last_name",
    "infix",
    "publication_year",
    "audiobook",
    "pages",
    "blurb",
    "summary",
    "themes",
    "reading_level",
    "recommendation_text",
    "review_text",
    "review_link",
    "secondary_literature_text",
    "secondary_literature_link"
  ];

  private $tableColumns = [
    "books" => [
      "title",
      "image_link",
      "publication_year",
      "audiobook",
      "pages",
      "blurb",
      "summary",
      "reading_level",
      "recommendation_text",
      "review_text",
      "review_link",
      "secondary_literature_text",
      "secondary_literature_link"
    ]
  ];

  private $intColumns =
  [
    "publication_year",
    "pages",
    "reading_level",
  ];

  private $strColumns =
  [
    "image_link",
    "first_name",
    "last_name",
    "infix",
    "audiobook",
    "blurb",
    "summary",
    "themes",
    "recommendation_text",
    "review_text",
    "review_link",
    "secondary_literature_text",
    "secondary_literature_link"
  ];

  private $log = [];

  public function csvToDb($filepath)

  {
    unlink(LOGFILE);
    
    $file = fopen("$filepath", "r");
    $length = 0; // 0 = maximum line length unlimited
    $separator = ";";

    $fileHeaders = fgetcsv($file, $length, $separator);
    $colIndexes = $this->getColumnIndexes($this->allColumns, $fileHeaders);


    $rowNum = 1;

    // loop over every row in csv. Each row is a book.
    while ($row = fgetcsv($file, $length, $separator)) {
      
      $rowNum += 1;
      echo "Working on row $rowNum\n";

      // Create array with info for this book. 
      $book = $this->rowToArray($row, $colIndexes);

      // If no title, log error and stop this book
      if (empty($book["title"])) {
        $this->logFailure("Row $rowNum contains no book title. Aborted.");
        continue;
      }

      // If no author, log error and stop this book
      if (empty($book["last_name"])) {
        $this->logFailure("{$book['title']} has no author last name. Aborted.");
        continue;
      }

      // Set invalid values to NULL
      $book = $this->setInvalidValuesToNull($book);

      // Separate themes string (e.g. "liefde", "Andere-plaatsen") into an array,
      // like: [0] => liefde, [1] andere plaatsen   
      $book["themes"] = $this->formatThemes($book["themes"]);

      // Remove unnecessary whitespace everywhere
      $book = $this->trimArrayItems($book);

      // Escape special characters everywhere
      $book = $this->escapeArrayItems($book);

      // Add book to database if not already in there.
      if ($this->addBookToDatabase($book) === "failed") {
        continue;
      }

      // If book has themes, add them to the database and connect them to the book
      if (isset($book["themes"])) {
        $this->addAndConnectThemes($book);
      }

      // add author to database and connect author to book
      
      $this->addAndConnectAuthor($book);
      
    }

    fclose($file);

    $showLogs = true;
    if ($showLogs) {
      if (isset($this->log["bookErrors"])) {
        var_dump($this->log["bookErrors"]);
      }
      if (isset($this->log["themeErrors"])) {
        var_dump($this->log["themeErrors"]);
      }
      if (isset($this->log["bookThemesErrors"])) {
        var_dump($this->log["bookThemesErrors"]);
      }
      if (isset($this->log["bookAuthorErrors"])) {
        var_dump($this->log["bookAuthorErrors"]);
      }
      if (isset($this->log["authorErrors"])) {
        var_dump($this->log["authorErrors"]);
      }
    }
    // foreach ($bookErrors as $error) {
    //   echo $error . "\n";
    // }
    // echo "---\nREPORT\n---\n";
    // echo "Number of books read: $numBooks\n";
    // echo "Number of book imports failed: $numErrors\n";
  }


  function addAndConnectThemes($book)
  {
    // Add theme to database if not already in there.
    foreach ($book["themes"] as $theme) {
      if ($this->addThemeToDatabase($theme) === "failed") {
        continue;
      }
      // Connect theme to book in database
      foreach ($book["themes"] as $theme) {
        $this->connectThemeToBook($theme, $book);
      }
    }
  }

  function addAndConnectAuthor($book)
  {
    // Add author to database if not already in there.
    $this->addAuthorToDatabase($book);
    // Connect author to book in database
    $this->connectAuthorToBook($book);
  }



  function connectAuthorToBook($book)
  {
    $authorId = $this->getAuthorId($book);
    $bookId = $this->getBookId($book);

    $query = "INSERT INTO books_authors (book_id, author_id) VALUES ({$bookId}, {$authorId});";

    try {
      $this->query($query);
    } catch (PDOException $e) {
      $this->log["bookAuthorErrors"][] = $this->logError("InsertError", "BookID: $bookId Author ID: $authorId") . ": " . $e->getMessage();
    }
  }
  function connectThemeToBook($theme, $book)
  {
    $themeId = $this->getThemeId($theme);
    $bookId = $this->getBookId($book);

    $query = "INSERT INTO books_themes (book_id, theme_id) VALUES ({$bookId}, {$themeId});";

    try {
      $this->query($query);
    } catch (PDOException $e) {
      $this->log["bookThemesErrors"][] = $this->logError("InsertError", "BookID: $bookId Theme ID: $themeId") . ": " . $e->getMessage();
    }
  }

  function addAuthorToDatabase($book)
  {
    // If author already in database, log error and return
    if ($this->getAuthorId($book)) {
      $this->log["authorErrors"][] = $this->logError("DublicateAuthorError", "{$book['first_name']}, {$book['infix']}, {$book['last_name']}");
    } else {
      // Try to insert author into database, log error and return "failed" if it fails
      try {
        $this->insertIntoAuthorsTable($book);
      } catch (PDOException $e) {
        $this->log["authorErrors"][] = $this->logError("InsertError", "{$book['first_name']}, {$book['infix']}, {$book['last_name']}") . ": " . $e->getMessage();
        return "failed";
      }
    }
  }
  function addThemeToDatabase($theme)
  {
    // If theme already in database, log error and return "failed"
    if ($this->getThemeId($theme)) {
      $this->log["themeErrors"][] = $this->logError("DublicateThemeError", $theme);
      return "failed";
    }

    // Try to insert theme into database, log error and return "failed" if it fails
    try {
      $this->insertIntoThemesTable($theme);
    } catch (PDOException $e) {
      $this->log["themeErrors"][] = $this->logError("InsertError", $theme) . ": " . $e->getMessage();
      return "failed";
    }
  }

  function addBookToDatabase($book)
  {
    // If book already in database, log error and return "failed"
    if ($this->getBookId($book)) {
      $this->log["bookErrors"][] = $this->logError("DublicateBookError", $book["title"]);
      return "failed";
    }

    // Try to insert book into database, log error and stop if it fails
    try {
      $this->insertIntoBooksTable($book);
    } catch (PDOException $e) {
      $this->log["bookErrors"][] = $this->logError("InsertError", $book["title"]) . ": " . $e->getMessage();
      return "failed";
    }
  }

  function rowToArray($row, $colIndexes)
  {
    foreach ($this->allColumns as $col) {
      $book[$col] = $row[$colIndexes[$col]];
    }

    return $book;
  }

  function getColumnIndexes($columns, $fileHeaders)
  {
    // Find row index for every col e.g. title is the first column, so $colIdx["title"] = 0
    foreach ($columns as $col) {
      $columnIndexes[$col] = array_search($col, $fileHeaders);
    }
    return $columnIndexes;
  }

  function writeToLog($msg, $infoType)
  {
    $curTime = date("h:i:sa");
    $msg = $curTime . " [" . $infoType . "] " . $msg . "\n";

    $log = fopen(LOGFILE, "a") or die("Unable to open log file!");
    fwrite($log, $msg);
    fclose($log);
  }

  function logDebug($msg) {
    $this->writeToLog($msg, "DEBUG");
  }
  function logInfo($msg) {
    $this->writeToLog($msg, "INFO");
  }
  function logWarning($msg) {
    $this->writeToLog($msg, "WARNING");
  }
  function logFailure($msg) {
    $this->writeToLog($msg, "FAILURE");
  }
  function logError($msg) {
    $this->writeToLog($msg, "ERROR");
  }

  function getAuthorId($book)
  {
    $query = "SELECT author_id FROM authors WHERE last_name = \"{$book['last_name']}\";";

    if ($book["first_name"] === NULL) {
      $query .= " AND first_name IS NULL";
    } else {
      $query .= " AND first_name = {$book['first_name']}";
    }

    if ($book["infix"] === NULL) {
      $query .= " AND infix IS NULL";
    } else {
      $query .= " AND infix = {$book['infix']}";
    }

    $query .= ";";

    $result = $this->query($query);

    if ($result) {
      return $result[0]["author_id"];
    } else {
      return false;
    }
  }

  function getThemeId($theme)
  {
    $query = "SELECT theme_id FROM themes WHERE theme = \"$theme\";";


    $result = $this->query($query);

    if ($result) {
      return $result[0]["theme_id"];
    } else {
      return false;
    }
  }

  function getBookId($book)
  {
    $query = "SELECT book_id FROM books WHERE title = \"{$book['title']}\"";

    if ($book["publication_year"] === NULL) {
      $query .= " AND publication_year IS NULL";
    } else {
      $query .= " AND publication_year = {$book['publication_year']}";
    }

    if ($book["pages"] === NULL) {
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

  function insertIntoThemesTable($theme)
  {

    $query = "INSERT INTO themes (theme) VALUES (\"$theme\");";

    $this->query($query);
  }

  function insertIntoAuthorsTable($book)
  {

    $query = "INSERT INTO authors (first_name, infix, last_name) VALUES (\"{$book['first_name']}\", \"{$book['infix']}\", \"{$book['last_name']}\");";

    $this->query($query);
  }

  function insertIntoBooksTable($book)
  {

    $query = "INSERT INTO books (";
    $query .= implode(", ", $this->tableColumns["books"]);
    $query .= ") VALUES (";

    foreach ($this->tableColumns["books"] as $col) {
      $values[] = "\"$book[$col]\"";
    }

    $query .= implode(", ", $values);
    $query .= ");";

    $this->query($query);
  }

  function setInvalidValuesToNull($book)
  {

    // Set empty values to NULL
    foreach ($book as $col => $value) {
      if ($book[$col] === "") {
        $this->logInfo("{$book['title']} ({$col}): EMPTY VALUE set to NULL.");
        $book[$col] = NULL;
      }
    }
    
    // If INT expected, but not given -> set value to NULL
    foreach ($this->intColumns as $col) {
      if (!filter_var($book[$col], FILTER_VALIDATE_INT) && $book[$col] !== NULL) {
        $this->logError("{$book['title']} ({$col}): INVALID VALUE {$book[$col]} set to NULL.");
        $book[$col] = NULL;
      }
    }

    // If STR expected, but INT given -> set value to NULL
    foreach ($this->strColumns as $col) {
      if (filter_var($book[$col], FILTER_VALIDATE_INT) && $book[$col] !== NULL) {
        // $this->show_error("ValueError", $book["title"], $col, $book[$col], NULL);
        $book[$col] = NULL;
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
    if ($str == NULL) {
      return;
    }
    $str = str_replace("\"", "", $str);
    $str = str_replace("-", " ", $str);
    $str = strtolower($str);
    $themesArray = explode(",", $str);
    return $themesArray;
  }

}


run(FILEPATH);
