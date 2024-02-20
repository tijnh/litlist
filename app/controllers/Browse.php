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

    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
      $userFilters = $this->getUserFilters();

      if (!empty($userFilters)) 
      {
        $books = $bookModel->findWhere($userFilters);
        $data["userFilters"] = $userFilters;
      } 
      else 
      {
        $books = $bookModel->findAll();
      }
    } 

    else 
    {
      $books = $bookModel->findAll();
    }

    
    $data["pageTitle"] = "Zoeken";
    $data["books"] = $this->cleanBookData($books);
    $data["filterMenu"] = $this->getFilterMenu($bookModel);


    $this->view('browse', $data);
  }

  private function getFilterMenu($bookModel) {
    $filterMenu["readingLevels"] = $bookModel->findDistinct("reading_level", "ASC");
    return $filterMenu;
  }

  private function getUserFilters()
  {
    $userFilters = [];
      if (!empty($vlue)) {
        $userFilters[$key] = $value;
      }
    }
    return $userFilters;
  }
  private function cleanBookData(array $books)
  {
    $cleanBookData = array();

    foreach ($books as $book) {
      // Check if the book is already in the array
      if (!isset($cleanBookData[$book["book_id"]])) {

        $cleanBookData[$book["book_id"]] = array(
          "bookId" => $book["book_id"],
          "title" => trim(ucfirst($book["title"])),
          "blurb" => mb_strimwidth(trim(ucfirst($book["blurb"])), 0, BLURBLENGTH, "..."),
          "pages" => $book["pages"],
          "year" => $book["publication_year"],
          "readingLevel" => $book["reading_level"],
          "imageLink" => !empty($book["image_link"]) ? $book["image_link"] : PLACEHOLDERCOVER,
          "authors" => array(),
          "themes" => array()
        );
      }
      // Add the theme to the themes array for the current book
      if (!in_array($book["theme"], $cleanBookData[$book["book_id"]]["themes"])) {
        $cleanBookData[$book["book_id"]]["themes"][] = strtolower(trim($book["theme"]));
      }

      // Add the authors to the authors array for the current book
      $author = ucfirst($book["first_name"]) . " " . strtolower($book["infix"]) . " " . ucfirst($book["last_name"]);
      $author = trim(str_replace("  ", " ", $author));
      if (!in_array($author, $cleanBookData[$book["book_id"]]["authors"])) {
        $cleanBookData[$book["book_id"]]["authors"][] = $author;
      }
    }

    return $cleanBookData;
  }
}
