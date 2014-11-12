<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio']); ?>

  <div class="row">
    <div class="page-title">
      <h1>Featured Clients</h1>
      <p class="subtitle">take a look at what we do &amp; for whom</p>
    </div>
  </div>

  <?php foreach($aPortfolio as $aClient) { ?>
  <div class="row">
    <div class="panel">
      <aside class="text-center">
        <img src="/uploads/portfolio/<?php echo $aClient['logo']; ?>" alt="<?php echo $aClient['name']; ?> Logo">
      </aside>

      <div class="panel-content">
        <h4><?php echo $aClient['name']; ?></h4>

        <?php echo $aClient['short_description']; ?>

        <ul class="service-icons">
          <?php foreach($aClient['services'] as $aService) { ?>
          <li><span class="<?php echo $aService['tag']; ?> service-icon"><i></i></span></li>
          <?php } ?>
        </ul>

        <a href="/the-work/<?php echo $aClient['tag']; ?>" title="View The Project" class="button button-alt button-full">View the project!</a>
      </div>
    </div>
  </div>
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
