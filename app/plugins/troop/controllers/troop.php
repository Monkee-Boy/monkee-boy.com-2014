<?php
class troop extends appController {
  function __construct() {
    // Load model when creating appController
    parent::__construct("troop");
  }

  function index() {
    $aTroop = $this->model->getTroop(false, false);

    $this->tplAssign('aTroop', $aTroop);
    $this->tplDisplay('index.php');
  }
}
