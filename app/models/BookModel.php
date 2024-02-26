<?php

class BookModel
{

  use Model;

  protected $table = 'books';

  // protected $allowedColumns = [

  // 	'title',
  // ];

  public function findAll($orderColumn = "books.title", $orderType = "ASC")
  {

    $query = "SELECT
      books.book_id,
      books.title,
      books.blurb,
      books.pages,
      books.audiobook,
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
			$orderColumn $orderType";

    $result = $this->query($query);
    
    if ($result)
      return $result;

    return [];
  }

  public function findWhere($filters, $orderColumn = "books.title", $orderType = "ASC")
  {
    $parameters = [];

    $query = "SELECT
      books.book_id,
      books.title,
      books.image_link,
      books.publication_year,
      books.audiobook,
      books.pages,
      books.blurb,
      books.reading_level,
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
    
    if (isset($filters["minYear"])) {
      $query .= "books.publication_year >= :minYear";
      $query .= " AND ";
      $parameters["minYear"] = $filters["minYear"];
    }
    
    if (isset($filters["maxYear"])) {
      $query .= "books.publication_year <= :maxYear";
      $query .= " AND ";
      $parameters["maxYear"] = $filters["maxYear"];
    }
    
    if (isset($filters["minPages"])) {
      $query .= "books.pages >= :minPages";
      $query .= " AND ";
      $parameters["minPages"] = $filters["minPages"];
    }
    
    if (isset($filters["maxPages"])) {
      $query .= "books.pages <= :maxPages";
      $query .= " AND ";
      $parameters["maxPages"] = $filters["maxPages"];
    }
    
    if (isset($filters["readingLevels"])) {
      $query .= "(";

      $paramNum = 0;
      foreach ($filters["readingLevels"] as $lvl) {
        $paramNum += 1;
        $query .= "books.reading_level = :level$paramNum";
        $parameters["level$paramNum"] = $lvl;
        $query .= " OR ";
      }
      $query = rtrim($query, " OR ");
      $query .=  ")";
      $query .= " AND ";
    }
    
    if (isset($filters["audiobookSources"])) {
      $query .= "(";

      $paramNum = 0;
      foreach ($filters["audiobookSources"] as $src) {
        $paramNum += 1;
        $query .= "books.audiobook = :source$paramNum";
        $parameters["source$paramNum"] = $src;
        $query .= " OR ";
      }
      $query = rtrim($query, " OR ");
      $query .=  ")";
      $query .= " AND ";
      
    }
    
    if (isset($filters["themes"])) {
      $themeCount = count($filters["themes"]);
      $query .= "books.book_id IN (
        SELECT book_id
            FROM books_themes
            JOIN themes ON books_themes.theme_id = themes.theme_id
            WHERE themes.theme IN (";
            
      $paramNum = 0;
      foreach ($filters["themes"] as $src) {
        $paramNum += 1;
        $query .= ":theme$paramNum, ";
        $parameters["theme$paramNum"] = $src;
      }
      $query = rtrim($query, ", ");
      $query .=  ")";
      $query .= "
      GROUP BY book_id
      HAVING COUNT(DISTINCT themes.theme) = :themeCount
      ) AND ";
      $parameters["themeCount"] = $themeCount;
    }

    $query = rtrim($query, " AND ");

    $query .= " ORDER BY $orderColumn $orderType LIMIT $this->limit OFFSET $this->offset";
    $result =  $this->query($query, $parameters);

    if ($result)
      return $result;

    return [];
  }
}
