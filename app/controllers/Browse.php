<?php

/**
 * browse class
 */
class Browse
{
  use Controller;

  public function index()
  {

    $data['username'] = empty($_SESSION['USER']) ? 'User' : $_SESSION['USER']->email;
    $data["pageTitle"] = "Zoeken";

    $this->view('browse', $data);
  }
}
