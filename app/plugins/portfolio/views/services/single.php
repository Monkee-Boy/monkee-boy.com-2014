<?php $this->tplDisplay("inc_header.php", ['menu'=>$aService['tag'], 'page_title'=>$aService['name'], 'seo_title'=>$aService['seo_title'], 'seo_description'=>$aService['seo_description'], 'seo_keywords'=>$aService['seo_keywords']]); ?>

  <div class="row">
    <div class="page-title">
      <h1><?php echo $aService['name']; ?></h1>
      <p class="subtitle"><?= $aService['subtitle']; ?></p>
    </div>
  </div> <!-- /.row -->

  <?php foreach($aService['subs'] as $ServiceSub) { ?>
  <div class="row service-section <?= $ServiceSub['tag']; ?>">
    <div class="service-title">
      <div class="<?= $ServiceSub['tag']; ?> service-icon"><i></i></div>
      <span class="title"><?= $ServiceSub['name']; ?></span>
    </div> <!-- /.service-title -->
    <div class="service-content">
      <?= $ServiceSub['description']; ?>

      <blockquote>
        <?= $ServiceSub['quote']; ?>
        <?php if(!empty($ServiceSub['quote_attribution'])) { ?><footer>- <?= $ServiceSub['quote_attribution']; ?></footer><?php } ?>
      </blockquote>
    </div> <!-- /.service-content -->
  </div>

  <div class="accordion-section">
    <div class="row">
      <div class="full" data-text-align="center">
        <span class="subtitle"><?= $ServiceSub['intro']; ?></span>
        <h2><?= $ServiceSub['name']; ?> services</h2>
      </div>

      <div class="half">
        <?php foreach($ServiceSub['first_half_items'] as $FirstHalfItem) { ?>
          <div class="accordion">
            <a href="#" class="trigger"><?= $FirstHalfItem['name']; ?></a>
            <div class="content">
              <?= $FirstHalfItem['description']; ?>
              </div>
          </div><!-- /.accordion -->
        <?php } ?>
      </div> <!-- /.half -->

      <div class="half">
        <?php foreach($ServiceSub['second_half_items'] as $SecondHalfItem) { ?>
          <div class="accordion">
            <a href="#" class="trigger"><?= $SecondHalfItem['name']; ?></a>
            <div class="content">
              <?= $SecondHalfItem['description']; ?>
              </div>
          </div><!-- /.accordion -->
        <?php } ?>
      </div> <!-- /.half -->
    </div> <!-- /.row -->
  </div><!-- /.accordion-section -->
  <?php } ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
