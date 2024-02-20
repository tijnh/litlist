<?php

class BookModel
{

  use Model;

  protected $table = 'books';

  // protected $allowedColumns = [

  // 	'title',
  // ];

  public function findAll($order_column, $order_type)
  {

    $query = "SELECT
      books.book_id,
      books.title,
      books.blurb,
      books.pages,
      books.reading_level,
      books.image_link,
      books.publication_year,
      authors.first_name,
      authors.infix,
      authors.last_name,
      themes.theme
    FROM
      books
      LEFT JOIN books_authors ON books.book_id = books_authors.book_id
      LEFT JOIN authors ON books_authors.author_id = authors.author_id
      LEFT JOIN books_themes ON books.book_id = books_themes.book_id
      LEFT JOIN themes ON books_themes.theme_id = themes.theme_id
    ORDER BY
			$order_column $order_type";

    return $this->query($query);
  }

  public function findWhere($filters, $order_column = "book_id", $order_type = "ASC")
  {
    $parameters = [];

    $query = "SELECT
      books.book_id,
      books.title,
      books.blurb,
      books.pages,
      books.reading_level,
      books.image_link,
      books.publication_year,
      authors.first_name,
      authors.infix,
      authors.last_name,
      themes.theme
    FROM
      books
      LEFT JOIN books_authors ON books.book_id = books_authors.book_id
      LEFT JOIN authors ON books_authors.author_id = authors.author_id
      LEFT JOIN books_themes ON books.book_id = books_themes.book_id
      LEFT JOIN themes ON books_themes.theme_id = themes.theme_id
    WHERE ";

    if (isset($filters["searchterm"])) {
      $query .= "
        (REPLACE(CONCAT_WS(' ',  authors.first_name, authors.infix, authors.last_name), '  ', ' ')
        LIKE :searchterm 
        OR books.title 
        LIKE :searchterm)";
      $query .= " AND ";
      $parameters["searchterm"] = "%" . $filters["searchterm"] . "%";
    }
    
    if (isset($filters["min_year"])) {
      $query .= "books.publication_year >= :min_year";
      $query .= " AND ";
      $parameters["min_year"] = $filters["min_year"];
    }
    
    if (isset($filters["max_year"])) {
      $query .= "books.publication_year <= :max_year";
      $query .= " AND ";
      $parameters["max_year"] = $filters["max_year"];
    }
    
    if (isset($filters["min_pages"])) {
      $query .= "books.pages >= :min_pages";
      $query .= " AND ";
      $parameters["min_pages"] = $filters["min_pages"];
    }
    
    if (isset($filters["max_pages"])) {
      $query .= "books.pages <= :max_pages";
      $query .= " AND ";
      $parameters["max_pages"] = $filters["max_pages"];
    }
    
    if (isset($filters["reading_level"])) {
      $query .= "(";
      foreach ($filters["reading_level"] as $lvl) {
        $query .= "books.reading_level = :level$lvl";
        $parameters["level$lvl"] = $lvl;
        $query .= " OR ";
      }
      $query = trim($query, " OR ");
      $query .=  ")";
    }

    $query = trim($query, " AND ");

    $query .= " ORDER BY $order_column $order_type LIMIT $this->limit OFFSET $this->offset";
    $result =  $this->query($query, $parameters);

    if ($result)
      return $result;

    return false;
  }
}
