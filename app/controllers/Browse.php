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
   
    // Delete user filters if reset filter button clicked
    if (isset($_POST["resetUserFilters"])) {
      unset($_POST["resetUserFilters"]);
      unset($_SESSION["userFilters"]);
    } 
    
    // If user used search form, get chosen filters
    if (isset($_POST["searchForm"])) {
      unset($_POST["searchForm"]);
      $_SESSION["userFilters"] = $this->getUserFilters();
      
    }
    
    // If any filters chosen, apply them to the search query, else show all books
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
