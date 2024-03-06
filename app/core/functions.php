<?php

function show($stuff)
{
	echo "<pre>";
	print_r($stuff);
	echo "</pre>";
}

function esc($str)
{
	return htmlspecialchars($str);
}

function redirect($path)
{
	header("Location: " . ROOT . "/" . $path);
	die;
}

function abbreviate($string)
{
	// If single word, use first two letters as abbreviation
	if (!strpos($string, " ")) 
	{
		$abbreviation = substr(strtoupper($string), 0, 2);
	} 
	else //If multiple words, use first letter of every word
	{
		$abbreviation = "";
		$string = strtoupper($string);
		$words = explode(" ", "$string");
		foreach ($words as $word) {
			$abbreviation .= $word[0];
		}
	}
	return $abbreviation;
}

function cleanBookData(array $books)
  {
    $cleanBookData = array();

    foreach ($books as $book) {
      // Check if the book is already in the array
      if (!isset($cleanBookData[$book["book_id"]])) {

        $cleanBookData[$book["book_id"]] = array(
          "bookId" => $book["book_id"],
          "title" => isset($book["title"]) ? trim(ucfirst($book["title"])) : NULL,
          "imageLink" => isset($book["image_link"]) ? trim($book["image_link"]) : PLACEHOLDERCOVER,
          "year" => isset($book["publication_year"]) ? $book["publication_year"] : NULL,
          "audiobook" => isset($book["audiobook"]) ? trim(ucfirst($book["audiobook"])) : NULL,
          "pages" => isset($book["pages"]) ? $book["pages"] : NULL,
          "blurb" => isset($book["blurb"]) ? trim(ucfirst($book["blurb"])) : NULL,
          "summary" => isset($book["summary"]) ? trim(ucfirst($book["summary"])) : NULL,
          "readingLevel" => isset($book["reading_level"]) ? $book["reading_level"] : NULL,
          "recommendationText" => isset($book["recommendation_text"]) ? trim(ucfirst($book["recommendation_text"])) : NULL,
          "reviewText" => isset($book["review_text"]) ? trim(ucfirst($book["review_text"])) : NULL,
          "reviewLink" => isset($book["review_link"]) ? trim($book["review_link"]) : NULL,
          "secondaryLiteratureText" => isset($book["secondary_literature_text"]) ? trim(ucfirst($book["secondary_literature_text"])) : NULL,
          "secondaryLiteratureLink" => isset($book["secondary_literature_link"]) ? trim($book["secondary_literature_link"]) : NULL,
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

      sort($cleanBookData[$book["book_id"]]["themes"]);
    }

    return $cleanBookData;
  }