<?php

// From terminal run: php -r "require 'C:/xampp/htdocs/litlist/private/import.php'; csvToDb('private/books.csv');"

function printTerminal($str) {
  print_r($str);
  print("\n");
}

function csvToDb($filepath)
{

  printTerminal("STARTING");

  $file = fopen("$filepath", "r");
  $length = 0; // 0 = maximum line length unlimited
  $separator = ";";

  $cols = ["title", "image_link", "first_name", "last_name", "infix", "publication_year", "audiobook", "pages", "blurb", "summary", "genres", "themes", "reading_level", "recommendation_level", "review_text", "review_link", "secondary_literature_text", "secondary_literature_link"];
  $intCols = ["publication_year", "pages", "reading_level", "recommendation_level"];
  $strCols = ["title", "image_link", "first_name", "last_name", "infix", "audiobook", "blurb", "summary", "genres", "themes", "review_text", "review_link", "secondary_literature_text", "secondary_literature_link"];

  $fileCols = fgetcsv($file, $length, $separator);

  // Find row index for every col e.g. "title is the first column col", so $colIdx["title"] = 0
  foreach ($cols as $col) {
    $colIdx[$col] = array_search($col, $fileCols);
  }

  $rowNum = 1;
  // loop over every row (= book)
  while ($bookRow = fgetcsv($file, $length, $separator)) {
    $rowNum += 1;

    // Create array with info for this book. E.g. $book["title] = 'Reis van flessen', $book["image_link"] 'http://www..." etc.
    $book = [];

    foreach ($cols as $col) {
      $book[$col] = $bookRow[$colIdx[$col]];
    }

    // If no title, stop and show which book
    if (empty($book["title"])) {
      printTerminal("ERROR ON ROW {$rowNum}. No title found.");
      continue;
    }
    
    
    
    $book = setInvalidValuesToNull($book, $intCols, $strCols);
    
    // Clean themes
    $book["themes"] = themesToArray($book["themes"]);
    
    // Escape special characters for SQL statement
    $book = escapeArrayItems($book);
    $book = trimArrayItems($book);

    
    // Data to go into 'books' table
    //   $booksTableQuery = "
    //   INSERT INTO books (title, image_link, publication_year, pages, blurb, summary, reading_level) 
    //   VALUES (\"{$book['title']}\", \"{$book['image_link']}\", {$book['publication_year']}, {$book['pages']}, \"{$book['blurb']}\", \"{$book['summary']}\", {$book['reading_level']});";
    //   // query($booksTableQuery);
    
    //   show($booksTableQuery);
    // }
  }
  fclose($file);
  printTerminal("ALL DONE");
}

function setInvalidValuesToNull($book, $intCols, $strCols)
{

  // Set empty values to NULL
  foreach ($book as $col => $value) {
    if ($book[$col] === "") {
      $book[$col] = "NULL";
    }
  }


  // Check for col datatypes. If incorrect, set to NULL
  foreach ($intCols as $col) {
    if (!is_int(intval($book[$col])) && $book[$col] != "NULL") {
      $book[$col] = "NULL";
      printTerminal("Invalid {$col} '{$book[$col]}' for {$book['title']} set to NULL");
    }
  }
  
  foreach ($strCols as $col) {
    if (is_int($book[$col]) && $book[$col] != "NULL") {
      $book[$col] = "NULL";
      printTerminal("Invalid {$col} '{$book[$col]}' for {$book['title']} set to NULL");
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
        $arr[$key] = escapeArrayItems($arr[$key]);
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
        $arr[$key] = trimArrayItems($arr[$key]);
      } else {
        $arr[$key] = trim($arr[$key]);
      }
    }
  }

  return $arr;
}

function themesToArray($str)
{
  $str = str_replace("\"", "", $str);
  $str = str_replace("-", " ", $str);
  $themesArray = explode(",", $str);
  return $themesArray;
}
