<?php

class BookAuthorModel
{

  use Model;

  protected $table = 'books_authors';
  protected $order_column = "book_id";

  // protected $allowedColumns = [

  // 	'title',
  // ];

}
