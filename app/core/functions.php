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
	if (!str_contains($string, " ")) 
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
