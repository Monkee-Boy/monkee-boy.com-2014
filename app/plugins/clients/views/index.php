<?php
$aContent = getContent(null, 'client-list');
$this->tplDisplay("inc_header.php", ['menu'=>'clients', 'page_title'=>$aContent['title'], 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

<!-- Page title block, FPO. Change when actual styles are made -->
<div class="row page-title">
  <h1><?= $aContent['title'] ?></h1>
  <span class="subtitle"><?= $aContent['subtitle'] ?></span>
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
