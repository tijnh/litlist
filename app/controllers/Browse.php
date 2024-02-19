<?php

/**
 * browse class
 */
class Browse
{
  use Controller;

  public function index()
  {
    $book = new Book;
    $books = $book->findAll();
    // $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']->email;
    $data["pageTitle"] = "Zoeken";
    $data["books"] = $this->cleanBookData($books);


    // put this in function
    // for each book, find the authors and add them to the book data
    // for each book, find the themes and add them to the book data

    $this->view('browse', $data);
  }

  private function cleanBookData(array $books)
  {
    $cleanBookData = array();

    foreach ($books as $book) {
      // Check if the book is already in the array
      if (!isset($cleanBookData[$book["book_id"]])) {
        // If not, add the book to the array with an empty array for themes and authors
        $cleanBookData[$book["book_id"]] = array(
          "book_id" => $book["book_id"],
          "title" => trim(ucfirst($book["title"])),
          "blurb" => mb_strimwidth(trim(ucfirst($book["blurb"])), 0, BLURBLENGTH, "..."),
          "pages" => $book["pages"],
          "year" => $book["publication_year"],
          "reading_level" => $book["reading_level"],
          "image_link" => !empty($book["image_link"]) ? $book["image_link"] : PLACEHOLDERCOVER,
        );
      }
    }

    return $cleanBookData;
  }
}
