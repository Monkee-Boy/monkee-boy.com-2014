<?php
class quote extends appController {
  function __construct() {
    // Load model when creating appController
    parent::__construct("quote");

    $this->tplAssign('aContent', $this->model->content);
    $this->tplAssign('aTYContent', $this->model->ty_content);
  }

  function index() {
    if(empty($_SESSION["quote_form"])) {
      $form_data = array();
    } else {
      $form_data = $_SESSION["quote_form"];
    }

    echo "<pre>";
    print_r($form_data);
    echo "</pre>";

    $this->tplAssign('form_data', $form_data);
    $this->tplAssign('aContent', $this->model->content);
    $this->tplDisplay("request_quote.php");
  }
  function thank_you() {
    $this->tplDisplay("thank_you.php");
  }
  function submit_form() {
    $_SESSION["quote_form"] = $_POST;
    $this->forward($this->model->content['url']);

    echo "<br><br>Test<br><br>";

    // $_SESSION["quote_form"] = null;
    // $this->forward($this->model->ty_content);
  }
}
