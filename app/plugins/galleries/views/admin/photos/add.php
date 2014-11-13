<?php $this->tplDisplay("inc_header.php", ['menu'=>'galleries','sPageTitle'=>"Galleries &raquo; Add Photo"]); ?>

  <h1>Galleries &raquo; Add Photo</h1>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form method="post" action="/admin/galleries/<?= $aGallery['id'] ?>/photos/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Title</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <input type="text" name="title" id="form-title" value="<?= $aPhoto['title'] ?>" class="span12 validate[required]">
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Description</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <textarea name="description" id="form-description" class="span12" style="height:95px;"><?php echo $aPhoto['description']; ?></textarea>
              </div>
            </div>
          </div>
        </div>

        <input type="submit" value="Create Photo" class="btn btn-primary">
        <a href="/admin/galleries/<?= $aGallery['id'] ?>/photos/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Photo</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aPhoto['photo'])): ?>
                <div class="control-group photo-show">
                  <img src="<?php echo $sImageFolder.$aGallery['id'].'/'.$aPhoto['photo']; ?>" alt="Photo" style="max-width: 300px;"><br />
                  <a href="#">Replace Photo</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aPhoto['photo'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-photo">Upload Photo</label>
                <div class="controls">
                  <input type="file" name="photo" id="form-photo">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>

{footer}
<script type="text/javascript">
$(function(){
  $('.photo-show a').on('click', function(e) {
    e.preventDefault();
    $(this).hide();
    $(this).parent().next().show();
  });

  $("form").validateForm([
    "required,name,Gallery name is required"
  ]);
});
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
