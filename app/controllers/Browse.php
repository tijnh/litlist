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

      $userFilters = $this->getUserFilters();

      if (!empty($userFilters)) 
      {
        $books = $bookModel->findWhere($userFilters);
        $data["userFilters"] = $userFilters;
      } 
      else 
      {
        $books = $bookModel->findAll();
      }
    } 

    else 
    {
      $books = $bookModel->findAll();
    }

    $data["pageTitle"] = "Zoeken";
    $data["books"] = cleanBookData($books);
    $data["filterMenu"] = $this->getFilterMenu($bookModel, $themeModel);


    $this->view('browse', $data);
  }

  private function getFilterMenu($bookModel, $themeModel) {
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
