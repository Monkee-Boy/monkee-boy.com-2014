<?php $this->tplDisplay("inc_header.php", ['menu'=>'clients','sPageTitle'=>"Portfolio &raquo; ".$aClient['name']." &raquo; Create Slide"]); ?>

  <h2>Portfolio &raquo; <?= $aClient['name'] ?> &raquo; Create Slide</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/portfolio/<?= $aClient['id'] ?>/slides/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Media</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <?php
              $images = array(
                "listing_image" => array(
                  "title" => "Listing Image",
                  "max-width" => 100
                ),
                "desktop_image" => array(
                  "title" => "Desktop Image",
                  "max-width" => 100
                ),
                "tablet_image" => array(
                  "title" => "Tablet Image",
                  "max-width" => 100
                ),
                "mobile_image" => array(
                  "title" => "Mobile Image",
                  "max-width" => 100
                ),
              );

              if($aClient['app'] == 1) {
                $images = array('listing_image' => $images['listing_image']);
              }

              $i = 1;
              foreach($images as $key=>$image): ?>
                <?php if(!empty($aSlide[$key])): ?>
                  <div class="control-group photo-show">
                    <img src="<?php echo $imageFolder.$aSlide[$key]; ?>" alt="<?= $image['title'] ?>" style="max-width: <?= $image['max-width'] ?>px;"><br />
                    <a href="#">Replace <?= $image['title'] ?></a>
                  </div>
                <?php endif; ?>

                <div class="control-group photo-upload"<?php if(!empty($aSlide[$key])){ echo ' style="display: none;"'; } ?>>
                  <label class="control-label" for="form-logo">Upload <?= $image['title'] ?></label>
                  <div class="controls">
                    <input type="file" name="<?= $key ?>" id="form-logo">
                  </div>
                </div>

                <?php if($i != count($images)){ echo "<hr>"; } $i++ ?>
              <?php endforeach; ?>
            </div>
          </div>
        </div>

        <input type="submit" value="Create Slide" class="btn btn-primary">
        <a href="/admin/portfolio/<?= $aClient['id'] ?>/slides/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">

      </div>
    </div>
  </form>

{footer}
<style>
.quote_block {
  border: 1px solid #D4D4D4;
  border-radius: 5px;
  margin-bottom: 10px;
  padding: 10px;
}
</style>
<script>
$(function(){
  jQuery('#add-form').validationEngine({ promptPosition: "bottomLeft" });

  $('.photo-show a').on('click', function(e) {
    e.preventDefault();
    $(this).hide();
    $(this).parent().next().show();
  });
});
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
