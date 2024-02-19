<?php

/**
 * browse class
 */
class Browse
{
  use Controller;

  public function index()
  {
    // $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']->email;
    $bookModel = new BookModel;
    $books = $bookModel->findAll();

    foreach ($books as $i => $book) {
      $books[$i]["authors"] = $this->getAuthors($book);
      $books[$i]["themes"] = $this->getThemes($book);
    }

    

      $data["books"] = $this->cleanBookData($books);
      $data["pageTitle"] = "Zoeken";

      
      $this->view('browse', $data);
    }

  private function getAuthors(array $book) {

      $arr = [];

      $bookAuthorModel = new BookAuthorModel;
      $authors = $bookAuthorModel->findWhere(["book_id" => $book["book_id"]]);

      foreach ($authors as $author) {
        $authorModel = new AuthorModel;
        $author = $authorModel->findFirst(["author_id" => $author["author_id"]]);
        $authorName = ucfirst($author["first_name"]) . " " . strtolower($author["infix"]) . " " . ucfirst($author["last_name"]);

        array_push($arr, $authorName);
      }
    
    return $arr;
  }
  
  private function getThemes(array $book) {

      $arr = [];

      $bookThemeModel = new BookThemeModel;
      $themes = $bookThemeModel->findWhere(["book_id" => $book["book_id"]]);
      
      if($themes) {

        foreach ($themes as $theme) {
          $themeModel = new ThemeModel;
          $theme = $themeModel->findFirst(["theme_id" => $theme["theme_id"]]);
          array_push($arr, $theme["theme"]);
        }
      }
    
    return $arr;
  }
  private function cleanBookData(array $books)
  {
    $cleanBookData = array();

    foreach ($books as $book) {
      
      $cleanBookData[$book["book_id"]] = array(
        "book_id" => $book["book_id"],
        "title" => trim(ucfirst($book["title"])),
        "blurb" => mb_strimwidth(trim(ucfirst($book["blurb"])), 0, BLURBLENGTH, "..."),
        "pages" => $book["pages"],
        "year" => $book["publication_year"],
        "reading_level" => $book["reading_level"],
        "image_link" => !empty($book["image_link"]) ? $book["image_link"] : PLACEHOLDERCOVER,
      );

        foreach ($book["authors"] as $author) {
          $cleanBookData[$book["book_id"]]["authors"][] = trim(str_replace("  ", " ", $author));
          
        }
        foreach ($book["themes"] as $theme) {
          $cleanBookData[$book["book_id"]]["themes"][] = strtolower(trim($theme));
          
        }
      
    }

    return $cleanBookData;
  }
}