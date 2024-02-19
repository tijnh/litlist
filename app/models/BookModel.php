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
	
	public function findWhere($data, $data_not = [], $order_column = "book_id", $order_type = "ASC")
	{
		$keys = array_keys($data);
		$keys_not = array_keys($data_not);
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


		foreach ($keys as $key) {
			$query .= $key . " = :" . $key . " && ";
		}

		foreach ($keys_not as $key) {
			$query .= $key . " != :" . $key . " && ";
		}

		$query = trim($query, " && ");

		$query .= " ORDER BY $order_column $order_type LIMIT $this->limit OFFSET $this->offset";
		$data = array_merge($data, $data_not);

		return $this->query($query, $data);
	}
	
}