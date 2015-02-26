<?php $this->tplDisplay("inc_header.php", ['menu'=>'services','sPageTitle'=>$aService['name']." &raquo; Create Service"]); ?>

  <h2><a href="/admin/portfolio/services/"><?php echo $aService['name']; ?></a> &raquo; Create Service</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Service Details</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-name">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="form-name" value="<?php echo $aServiceSub['name']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-subtitle">Subtitle</label>
                <div class="controls">
                  <input type="text" name="subtitle" id="form-subtitle" value="<?php echo $aServiceSub['subtitle']; ?>" class="span12">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-order">Order</label>
                <div class="controls">
                  <input type="text" name="order" id="form-order" value="<?php echo $aServiceSub['order']; ?>" class="span1">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Content</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Description</label>
                <div class="controls">
                  <textarea name="description" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aServiceSub['description']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-intro">Intro</label>
                <div class="controls">
                  <input type="text" name="intro" id="form-intro" value="<?php echo $aServiceSub['intro']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Quote</label>
                <div class="controls">
                  <textarea name="quote" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aServiceSub['quote']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Quote Attribution</label>
                <div class="controls">
                  <input type="text" name="quote_attribution" id="form-quote_attribution" value="<?php echo $aServiceSub['quote_attribution']; ?>">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <input type="submit" value="Add Service" class="btn btn-primary">
        <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">

      </div>
    </div>
  </form>

{footer}
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
