<?php

/**
 * book class
 */
class Book
{
  use Controller;

  public function index()
  {

    if(!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
      redirect('404');
    }
    
    $bookModel = new BookModel;
  
    $book = $bookModel->findBookById($_GET["id"]);
    if (empty($book)) {
      redirect('404');
    }

    
    $book = cleanBookData($book);
    
    // CleanBookData returns an assoc array, indexed by book id. 
    // Thus, we need this book's id to find index into the correct data
    $book = $book[$_GET["id"]];

    $data["pageTitle"] = $book["title"];
    $data["book"] = $book;
    
    $this->view('book', $data);
  }
}
