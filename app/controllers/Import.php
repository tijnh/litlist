<?php

/**
 * login class
 */
class Import
{
  use Controller;
  use Database;

  public function index()
  {
    $this->csvToDb("../private/books.csv");
  }

  private function csvToDb($filepath)
  {
    
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
      if(empty($book["title"])) {
        show("<span style='color:red'>No book title for row " . $rowNum . ". Book not inserted.</span>");
        continue;
      }



      $book = $this->setInvalidValuesToNull($book, $intCols, $strCols);
     
      // Clean themes
      $book["themes"] = $this->themesToArray($book["themes"]);

      // Escape special characters for SQL statement
      $book = $this->escapeArrayItems($book);
      $book = $this->trimArrayItems($book);
      
      
      



      // Data to go into 'books' table
      //   $booksTableQuery = "
      //   INSERT INTO books (title, image_link, publication_year, pages, blurb, summary, reading_level) 
      //   VALUES (\"{$book['title']}\", \"{$book['image_link']}\", {$book['publication_year']}, {$book['pages']}, \"{$book['blurb']}\", \"{$book['summary']}\", {$book['reading_level']});";
      //   // $this->query($booksTableQuery);

      //   show($booksTableQuery);
      // }
        show("<span style='color:green'>" . $book["title"] . " inserted.</span>");
    }
    fclose($file);
  }
  
  private function setInvalidValuesToNull($book, $intCols, $strCols) {

    // Set empty values to NULL
    foreach ($book as $col => $value) {
      if ($book[$col] === "") {
        $book[$col] = "NULL";
      }
    }
      
  
    // Check for col datatypes. If incorrect, set to NULL
    foreach ($intCols as $col) {
      if (!is_int($book[$col])) {
        $book[$col] = "NULL";
      }
    }
    
    foreach ($strCols as $col) {
      if (!is_string($book[$col])) {
        $book[$col] = "NULL";
      }
    }
    
    return $book;

  }

  
  private function escapeArrayItems(array $arr)
  {
    /* Escapes characters that will causes issues in SQL statement */

    foreach ($arr as $key => $value) 
    {
      if(isset($arr[$key])) {

        if (is_array($arr[$key])) 
        {
          $arr[$key] = $this->escapeArrayItems($arr[$key]);
        } 
        else 
        {
          $arr[$key] = addslashes($arr[$key]);
        }
      }
    }

    return $arr;

  }

  private function trimArrayItems(array $arr)
  {
    foreach ($arr as $key => $value) 
    {
      if(isset($arr[$key])) {

        if (is_array($arr[$key])) 
        {
          $arr[$key] = $this->trimArrayItems($arr[$key]);
        } 
        else 
        {
          $arr[$key] = trim($arr[$key]);
        }
      }
    }

    return $arr;

  }

  private function themesToArray($str)
  {
    $str = str_replace("\"", "", $str);
    $str = str_replace("-", " ", $str);
    $themesArray = explode(",", $str);
    return $themesArray;
  }
}
