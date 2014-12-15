<?php $this->tplDisplay("inc_header.php", ['menu'=>'clients']); ?>

<!-- Page title block, FPO. Change when actual styles are made -->
<div class="row page-title">
  <h1>Featured Clients</h1>
  <!-- <span class="subtitle">we are the monkees...</span> -->
</div>

<ul class="row client-list">
  <?php foreach($aClients as $aClient): ?>
    <li>
      <a href="#" class="trigger">
        <img src="<?= $aClient['logo_url'] ?>" alt="<?= $aClient['name'] ?>" class="default-image">
      </a>
    </li>
  <?php endforeach; ?>
</ul>

<?php $this->tplDisplay("inc_footer.php"); ?>
