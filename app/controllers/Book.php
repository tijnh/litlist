<?php

/**
 * book class
 */
class Book
{
  use Controller;

  public function index()
  {

    if(!isset($_GET["id"])) {
      redirect('home');
    }
    
    $bookModel = new BookModel;
  
    $book = $bookModel->findBookById($_GET["id"]);
    if (empty($book)) {
      redirect('404');
    }

    // TODO: clean book like in browse.php
    
    $data["pageTitle"] = $book[0]["title"];
    $data["book"] = $book;

    $this->view('book', $data);
  }
}
