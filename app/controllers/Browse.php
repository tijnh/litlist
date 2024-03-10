<?php

/**
 * browse class
 */
class Browse
{
  use Controller;

  public function index()
  {
    // $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']->email;
    $bookModel = new BookModel;
    $themeModel = new ThemeModel;

    if ($_SERVER["REQUEST_METHOD"] === "POST") 
    {
      $_SESSION["userFilters"] = $this->getUserFilters();
    } 

    if (!empty($_SESSION["userFilters"])) {
      $books = $bookModel->findWhere($_SESSION["userFilters"]);
      $data["userFilters"] = $_SESSION["userFilters"];
    } else {
      $books = $bookModel->findAll();
    }

    $data["pageTitle"] = "Zoeken";
    $data["books"] = cleanBookData($books);
    $data["filterMenu"] = $this->getFilterMenu($bookModel, $themeModel);

    $this->view('browse', $data);
  }

  private function getFilterMenu($bookModel, $themeModel)
  {
    $filterMenu["readingLevels"] = $bookModel->findDistinct("reading_level");
    $filterMenu["audiobookSources"] = $bookModel->findDistinct("audiobook");
    $filterMenu["themes"] = $themeModel->findDistinct("theme");
    return $filterMenu;
  }

  private function getUserFilters()
  {
    $userFilters = [];
    foreach ($_POST as $key => $value) {
      if (!empty($value)) {
        $userFilters[$key] = $value;
      }
    }
    return $userFilters;
  }
}
