<?php

class Book
{
	
	use Model;

	protected $table = 'books';
  protected $order_column = "book_id";

	// protected $allowedColumns = [

	// 	'title',
	// ];
	
}