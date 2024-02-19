<?php

class AuthorModel
{

  use Model;

  protected $table = 'authors';
  protected $order_column = "author_id";

  // protected $allowedColumns = [

  // 	'title',
  // ];

}
