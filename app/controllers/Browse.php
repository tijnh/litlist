<?php

/**
 * browse class
 */
class Browse
{
  use Controller;

  public function index()
  {
    $data["pageTitle"] = "Zoeken";
    // $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']->email;
    $bookModel = new BookModel;
    
    $books = $bookModel->findAll("book_id", "ASC");
    $data["books"] = $this->cleanBookData($books);
    $data["filters"]["reading_level"] = $bookModel->findDistinct("reading_level", "ASC");
    
    $this->view('browse', $data);
  }


  private function cleanBookData(array $books)
  {
    $cleanBookData = array();

    foreach ($books as $book) {
      // Check if the book is already in the array
      if (!isset($cleanBookData[$book["book_id"]])) {

        $cleanBookData[$book["book_id"]] = array(
          "book_id" => $book["book_id"],
          "title" => trim(ucfirst($book["title"])),
          "blurb" => mb_strimwidth(trim(ucfirst($book["blurb"])), 0, BLURBLENGTH, "..."),
          "pages" => $book["pages"],
          "year" => $book["publication_year"],
          "reading_level" => $book["reading_level"],
          "image_link" => !empty($book["image_link"]) ? $book["image_link"] : PLACEHOLDERCOVER,
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
