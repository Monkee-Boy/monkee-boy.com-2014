<?php $this->tplDisplay("inc_header.php", ['menu'=>'portfolio','sPageTitle'=>$aService['name']." &raquo; ".$aServiceSub['name']." &raquo; Create Item"]); ?>

  <h2><a href="/admin/portfolio/services/"><?php echo $aService['name']; ?></a> &raquo; <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/"><?php echo $aServiceSub['name']; ?></a> &raquo; Create Item</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/<?php echo $aServiceSub['id']; ?>/item/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Item Details</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-name">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="form-name" value="<?php echo $aServiceSubItem['name']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Description</label>
                <div class="controls">
                  <textarea name="description" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aServiceSubItem['description']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <input type="submit" value="Add Item" class="btn btn-primary">
        <a href="/admin/portfolio/services/<?php echo $aService['id']; ?>/sub/<?php echo $aServiceSub['id']; ?>/item/" title="Cancel" class="btn">Cancel</a>
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
