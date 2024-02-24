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

  public function csvToDb($filepath)
  {
    // Delete old log
    unlink(LOGFILE);

    $file = fopen("$filepath", "r");
    $length = 0; // 0 = maximum line length unlimited
    $separator = ";";

    $fileHeaders = fgetcsv($file, $length, $separator);

    // Find row index for every col e.g. title is the first column, so $colIndexes["title"] = 0
    // This is done in case a user changes the order of columns in the csv file
    $colIndexes = $this->getColumnIndexes($this->allColumns, $fileHeaders);

    // loop over every row in csv. Each row is a book.
    $rowNum = 1;

    while ($row = fgetcsv($file, $length, $separator)) {

      $rowNum += 1;
      echo "Working on row $rowNum\n";

      // Create array from csv row. This array represents all data for a book 
      $book = $this->rowToArray($row, $colIndexes);

      // If any book columns have invalid values, stop. It will be logged in the function.
      if ($this->hasInvalidValues($book, $rowNum)) {
        continue;
      }

      // Set empty values to NULL for SQL purposes
      $book = $this->setEmptyValuesToNull($book);

      // Separate themes string (e.g. "liefde", "Andere-plaatsen") into an array,
      // like: [0] => liefde, [1] andere plaatsen   
      $book["themes"] = $this->formatThemes($book["themes"]);

      // Remove unnecessary whitespace everywhere
      $book = $this->trimArrayItems($book);

      // Escape special characters everywhere
      $book = $this->escapeArrayItems($book);

      // If book already in database, stop.
      if ($this->getBookId($book)) {
        $this->logFailure("Book [{$book['title']}]: Book already in database.");
        continue;
      }

      // Insert book into database
      try {
        $this->insertIntoBooksTable($book);
        $this->logSuccess("Book [{$book['title']}]: Succesfully inserted.");
      } catch (PDOException $e) {
        $this->logFailure("Book [{$book['title']}]: " . $e->getMessage());
        continue;
      }

      // Handle book themes
      if (isset($book["themes"])) {
        foreach ($book["themes"] as $theme) {

          if(empty($theme)) {
            continue;
          }

          // If theme not in database, insert
          if (!$this->getThemeId($theme)) {
            try {
              $this->insertIntoThemesTable($theme);
              $this->logSuccess("Theme [{$theme}]: Succesfully inserted.");
            } catch (PDOException $e) {
              $this->logFailure("Theme [{$theme}]: " . $e->getMessage());
              continue;
            }
          }
          
          // Connect theme to book in database
          try {
            $this->insertIntoBooksThemesTable($book, $theme);
            $this->logSuccess("Book [{$book['title']}] & Theme [{$theme}]: Succesfully inserted.");
          } catch (PDOException $e) {
            $this->logFailure("Book [{$book['title']}] & Theme [{$theme}]: " . $e->getMessage());
          }
        }
      }
      
      // Handle author
      $author["first_name"] = $book["first_name"];
      $author["infix"] = $book["infix"];
      $author["last_name"] = $book["last_name"];
      
      // If author not in database, insert
      if (!$this->getAuthorId($author)) {
        try {
          $this->insertIntoAuthorsTable($author);
          $this->logSuccess("Author [{$author['last_name']}]: Succesfully inserted.");
        } catch (PDOException $e) {
          $this->logFailure("Author [{$author['last_name']}]: " . $e->getMessage());
        }
      }
      
      // Connect author to book in database
      try {
        $this->insertIntoBooksAuthorsTable($book, $author);
        $this->logSuccess("Book [{$book['title']}] & Author [{$author['last_name']}]: Succesfully inserted.");
      } catch (PDOException $e) {
        $this->logFailure("Book [{$book['title']}] & Author [{$author['last_name']}]: " . $e->getMessage());
      }
    }
    fclose($file);
  }


  function hasInvalidValues($book, $rowNum)
  {

    // If book has no title, return true
    if (empty($book["title"])) {
      $this->logFailure("Row $rowNum: Book has no title.");
      return true;
    }

    // If book has no author last_name, return true
    if (empty($book["last_name"])) {
      $this->logFailure("Book [{$book['title']}]: Book has no author last name.");
      return true;
    }

    // If INT expected, but not given, return true 
    foreach ($this->intColumns as $col) {
      if (!filter_var($book[$col], FILTER_VALIDATE_INT) && !empty($book[$col])) {
        $this->logFailure("Book [{$book['title']}]: INVALID VALUE {$book[$col]} found for [{$col}].");
        return true;
      }
    }

    // If STR expected, but INT given, return true
    foreach ($this->strColumns as $col) {
      if (filter_var($book[$col], FILTER_VALIDATE_INT) && !empty($book[$col])) {
        $this->logFailure("Book [{$book['title']}]: INVALID VALUE {$book[$col]} found for [{$col}].");
        return true;
      }
    }

    return false;
  }

  function insertIntoBooksAuthorsTable($book, $author)
  {
    $bookId = $this->getBookId($book);
    $authorId = $this->getAuthorId($author);

    $query = "INSERT INTO books_authors (book_id, author_id) VALUES ({$bookId}, {$authorId});";

    $this->query($query);
  }
  function insertIntoBooksThemesTable($book, $theme)
  {
    $bookId = $this->getBookId($book);
    $themeId = $this->getThemeId($theme);

    $query = "INSERT INTO books_themes (book_id, theme_id) VALUES ({$bookId}, {$themeId});";

    $this->query($query);
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
    foreach ($columns as $col) {
      $columnIndexes[$col] = array_search($col, $fileHeaders);
    }
    return $columnIndexes;
  }

  function getAuthorId($author)
  {
    $query = "SELECT author_id FROM authors WHERE last_name = \"{$author['last_name']}\";";

    if ($author["first_name"] === NULL) {
      $query .= " AND first_name IS NULL";
    } else {
      $query .= " AND first_name = {$author['first_name']}";
    }

    if ($author["infix"] === NULL) {
      $query .= " AND infix IS NULL";
    } else {
      $query .= " AND infix = {$author['infix']}";
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

  function setEmptyValuesToNull($book)
  {
    foreach ($book as $col => $value) {
      if ($book[$col] === "") {
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

  function logDebug($msg)
  {
    $this->writeToLog($msg, "DEBUG");
  }

  function logInfo($msg)
  {
    $this->writeToLog($msg, "INFO");
  }

  function logWarning($msg)
  {
    $this->writeToLog($msg, "WARNING");
  }

  function logFailure($msg)
  {
    $this->writeToLog($msg, "FAILURE");
  }

  function logError($msg)
  {
    $this->writeToLog($msg, "ERROR");
  }

  function logSuccess($msg)
  {
    $this->writeToLog($msg, "SUCCESS");
  }

  function writeToLog($msg, $infoType)
  {
    $curTime = date("h:i");
    $msg = $curTime . " " . $infoType . " " . $msg . "\n";

    $log = fopen(LOGFILE, "a") or die("Unable to open log file!");
    fwrite($log, $msg);
    fclose($log);
  }
}



run(FILEPATH);
