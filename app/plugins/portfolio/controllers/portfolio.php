<?php
class portfolio extends appController {
  function __construct() {
    // Load model when creating appController
    parent::__construct("portfolio");
  }

  function index() {
    $aPortfolio = $this->model->getClients(false, false, true);

    $this->tplAssign('aPortfolio', $aPortfolio);
    $this->tplDisplay('index.php');
  }

  function single() {
    $aClient = $this->model->getClient(null, $this->urlVars->dynamic['tag']);

    if(empty($aClient))
      $this->error('404');

    $this->tplAssign('aClient', $aClient);
    $this->tplDisplay('single.php');
  }

  function services_index() {
    $aServices = $this->model->getServices();

    $this->tplAssign("aServices", $aServices);
    $this->tplDisplay("services/index.php");
  }

  function services_single() {
    $aService = $this->model->getService(null, $this->urlVars->dynamic["tag"], true);

    if(empty($aService))
      $this->error('404');

    $this->tplAssign("aService", $aService);
    $this->tplDisplay("services/single.php");
  }
}