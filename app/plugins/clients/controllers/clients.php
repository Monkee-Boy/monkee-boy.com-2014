<?php
class clients extends appController {
  function __construct() {
    // Load model when creating appController
    parent::__construct("clients");

    $this->tplAssign('aContent', $this->model->content);
  }

  function index() {
    $aClients = $this->model->getClients(false, true);

    $this->tplAssign('aClients', $aClients);
    $this->tplDisplay('index.php');
  }
}
