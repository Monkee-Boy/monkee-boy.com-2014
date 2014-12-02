<?php $this->tplDisplay("inc_header.php", ['menu'=>'clients','sPageTitle'=>"Portfolio &raquo; Create Client"]); ?>

  <h2>Portfolio &raquo; Create Client</h2>
  <?php $this->tplDisplay('inc_alerts.php'); ?>

  <form id="add-form" method="post" action="/admin/portfolio/add/s/" enctype="multipart/form-data">
    <div class="row-fluid">
      <div class="span8">

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Client Details</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-name">Name</label>
                <div class="controls">
                  <input type="text" name="name" id="form-name" value="<?php echo $aClient['name']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-tag">Tag</label>
                <div class="controls">
                  <input type="text" name="tag" id="form-tag" value="<?php echo $aClient['tag']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-subtitle">Subtitle</label>
                <div class="controls">
                  <input type="text" name="subtitle" id="form-subtitle" value="<?php echo $aClient['subtitle']; ?>" class="span12 validate[required]">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">URLs</span>
          </div>
          <div id="pagecontent" class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-website">Website URL</label>
                <div class="controls">
                  <input type="text" name="website" id="form-website" value="<?php echo $aClient['website']; ?>" class="span12">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-website">Case Study URL</label>
                <div class="controls">
                  <input type="text" name="case_study" id="form-website" value="<?php echo $aClient['case_study']; ?>" class="span12">
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
                <label class="control-label" for="form-synopsis">Synopsis</label>
                <div class="controls">
                  <textarea name="synopsis" id="form-synopsis" class="span12" style="height:95px;"><?php echo $aClient['synopsis']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Listing Description</label>
                <div class="controls">
                  <textarea name="short_description" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aClient['short_description']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Other Services (Col 1)</label>
                <div class="controls">
                  <textarea name="other_services_1" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aClient['other_services_1']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->

              <div class="control-group">
                <label class="control-label" for="form-shortdescription">Other Services (Col 2)</label>
                <div class="controls">
                  <textarea name="other_services_2" id="form-shortdescription" class="span12" style="height:95px;"><?php echo $aClient['other_services_2']; ?></textarea>
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Quotes</span>
          </div>
          <div class="accordion-body" id="quote_block_body">
            <div class="accordion-inner">
              <?php
              foreach($aClient["quotes"] as $aQuote) {
                quote_block($aQuote);
              }
              quote_block();
              ?>
              <a href="#" title="Add Quote" id="quote_more" class="btn btn-primary" rel="tooltip" data-placement="bottom">
                <i class="icon-plus icon-white"></i> Add Quote
              </a>
            </div> <!--/.accordion-inner -->
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Services</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
            <?php foreach($aServices as $aService): ?>
              <h5><?php echo $aService['name']; ?></h5>
              <ul>
                <?php foreach($aService['subs'] as $aServiceSub): ?>
                <li><label><input type="checkbox" name="services[]" value="<?php echo $aServiceSub['id']; ?>"<?php echo ((in_array($aServiceSub['id'], $aClient['services']))?' checked="checked"':''); ?>><?php echo $aServiceSub['name']; ?></label></li>
                <?php endforeach; ?>
              </ul>
            <?php endforeach; ?>
            </div>
          </div> <!-- /.accordion-body -->
        </div> <!-- /.accordion-group -->

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Categories</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="controls">
                <?php if(!empty($aCategories)): ?>
                  <select name="categories[]" data-placeholder="Select Categories" class="chzn-select span12" multiple="">
                    <?php foreach($aCategories as $aCategory): ?>
                      <option value="<?= $aCategory['id'] ?>"<?php if(in_array($aCategory['id'], $aClient['categories'])){ echo ' selected="selected"'; } ?>><?= $aCategory['name'] ?></option>
                    <?php endforeach; ?>
                   </select>

                  <p class="help-block">Hold down ctrl (or cmd) to select multiple categories at once.</p>
                <?php else: ?>
                  <p>There are currently no categories.</p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>

        <input type="submit" value="Create Client" class="btn btn-primary">
        <a href="/admin/portfolio/" title="Cancel" class="btn">Cancel</a>
      </div>

      <div class="span4 aside">
        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Options</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <label class="control-label" for="form-logo">Active</label>
                <div class="controls">
                  <input type="checkbox" name="active" value="1"<?php echo (($aClient['active'] == 1)?' checked="checked"':''); ?>>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="form-logo">Featured</label>
                <div class="controls">
                  <input type="checkbox" name="featured" value="1"<?php echo (($aClient['featured'] == 1)?' checked="checked"':''); ?>>
                </div>
              </div>

              <div class="control-group">
                <label class="control-label" for="form-logo">Type</label>
                <div class="controls">
                  <select name="type">
                    <option value="1"<?php if($aClient['type'] == 1){ echo ' selected="selected"'; } ?>>Responsive Site (Desktop, Tablet, Phone)</option>
                    <option value="2"<?php if($aClient['type'] == 2){ echo ' selected="selected"'; } ?>>Non Responsive Site (Desktop)</option>
                    <option value="3"<?php if($aClient['type'] == 3){ echo ' selected="selected"'; } ?>>Web App (Tablet)</option>
                    <option value="4"<?php if($aClient['type'] == 4){ echo ' selected="selected"'; } ?>>Mobile App (Phone)</option>
                    <option value="5"<?php if($aClient['type'] == 5){ echo ' selected="selected"'; } ?>>Marketing</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Media</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <?php if(!empty($aClient['logo'])): ?>
                <div class="control-group photo-show">
                  <img src="<?php echo $imageFolder.$aClient['logo']; ?>" alt="Client Logo" style="max-width: 300px;"><br />
                  <a href="#">Replace Logo</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aClient['logo'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-logo">Upload Logo</label>
                <div class="controls">
                  <input type="file" name="logo" id="form-logo">
                </div>
              </div>

              <?php if(!empty($aClient['listing_image'])): ?>
                <div class="control-group photo-show">
                  <img src="<?php echo $imageFolder.$aClient['listing_image']; ?>" alt="Client Listing Image" style="max-width: 300px;"><br />
                  <a href="#">Replace Listing Image</a>
                </div>
              <?php endif; ?>

              <div class="control-group photo-upload"<?php if(!empty($aClient['listing_image'])){ echo ' style="display: none;"'; } ?>>
                <label class="control-label" for="form-listingimage">Listing Image</label>
                <div class="controls">
                  <input type="file" name="listing_image" id="form-listingimage">
                </div> <!-- /.controls -->
              </div> <!-- /.control-group -->
            </div>
          </div>
        </div>

        <div class="accordion-group">
          <div class="accordion-heading">
            <span class="accordion-toggle">Gallery</span>
          </div>
          <div class="accordion-body">
            <div class="accordion-inner">
              <div class="control-group">
                <div class="controls">
                  <select name="gallery">
                    <option value="">- Select Gallery -</option>
                    <?php foreach($aGalleries as $aGallery): ?>
                      <option value="<?= $aGallery['id'] ?>"<?php if($aGallery['id'] == $aClient['galleryid']){ echo ' selected="selected"'; } ?>><?= $aGallery['name'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
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

  $('#quote_more').on('click', function(e) {
    e.preventDefault();

    blocks = $('.quote_block:not(#quote_block)').length;
    console.log(blocks);

    var block = $('#quote_block').clone();
    block.attr('id', '');
    block.find('#form-quote').attr('id', '').attr('name', 'quotes['+blocks+'][quote]');
    block.find('#form-quote-attribution').attr('id', '').attr('name', 'quotes['+blocks+'][attribution]');

    block.insertBefore('#quote_more');
    block.slideDown();
  });

  $('#quote_block_body').on('click', '.quote_remove', function(e) {
    e.preventDefault();

    $(this).parent().remove();

    var blocks = $('.quote_block:not(#quote_block)'),
        i = 0;

    blocks.each(function() {
      $(this).find('textarea').attr('name', 'quotes['+i+'][quote]');
      $(this).find('input').attr('name', 'quotes['+i+'][attribution]');
      console.log($(this));
      console.log(i);

      i++;
    });
  });
});
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
<?php
function quote_block($aQuote = null) {
  if(!empty($aQuote)) {
    $hide = false;
  } else {
    $aQuote = array(
      "quote" => null,
      "attribution" => null
    );
    $hide = true;
  }

  $html = '<div class="quote_block"'.(($hide==true)?' id="quote_block" style="display: none;"':'').'>';
    $html .= '<a href="#" title="Remove Quote" class="quote_remove btn btn-danger btn-mini pull-right" rel="tooltip" data-placement="bottom">Remove Quote</a>';
    $html .= '<div class="control-group">';
      $html .= '<label class="control-label" for="form-quote">Quote</label>';
      $html .= '<div class="controls">';
        $html .= '<textarea name="" id="form-quote" class="span12" style="height:95px;">'.$aQuote['quote'].'</textarea>';
      $html .= '</div>';
    $html .= '</div>';
    $html .= '<div class="control-group">';
      $html .= '<label class="control-label" for="form-quote-attribution">Quote Attribution</label>';
      $html .= '<div class="controls">';
        $html .= '<input name="" id="form-quote-attribution" class="span12" value="'.$aQuote['attribution'].'">';
      $html .= '</div>';
    $html .= '</div>';
  $html .= '</div>';

  echo $html;
}
?>
