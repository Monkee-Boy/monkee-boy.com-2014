<?php
class troop extends appController {
  function __construct() {
    // Load model when creating appController
    parent::__construct("troop");

    $this->tplAssign('aContent', $this->model->content);
  }

  function index() {
    $aTroop = $this->model->getTroop(false, false, true);

    $this->tplAssign('aTroop', $aTroop);
    $this->tplDisplay('index.php');
  }
}
