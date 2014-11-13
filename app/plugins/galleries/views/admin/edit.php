<?php $this->tplDisplay("inc_header.php", ['menu'=>'galleries','sPageTitle'=>"Galleries &raquo; Manage Gallery"]); ?>

	<h1>Galleries &raquo; Manage Gallery</h1>
	<?php $this->tplDisplay('inc_alerts.php'); ?>

	<form method="post" action="/admin/galleries/edit/s/" enctype="multipart/form-data">
		<div class="row-fluid">
			<div class="span8">
				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Name</span>
					</div>
					<div id="pagecontent" class="accordion-body">
						<div class="accordion-inner">
							<div class="controls">
								<input type="text" name="name" id="form-name" value="<?= $aGallery['name'] ?>" class="span12 validate[required]">
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
								<textarea name="description" id="form-description" class="span12" style="height:95px;"><?php echo $aGallery['description']; ?></textarea>
							</div>
						</div>
					</div>
				</div>

				<?php if($sUseCategories == true): ?>
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
											<option value="<?= $aCategory['id'] ?>"<?php if(in_array($aCategory['id'], $aGallery['categories'])){ echo ' selected="selected"'; } ?>><?= $aCategory['name'] ?></option>
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
				<?php endif; ?>

				<input type="hidden" name="id" value="<?= $aGallery['id'] ?>">
				<input type="submit" value="Save Changes" class="btn btn-primary">
				<a href="/admin/galleries/" title="Cancel" class="btn">Cancel</a>
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
									<input type="checkbox" name="active" value="1"<?php echo (($aGallery['active'] == 1)?' checked="checked"':''); ?>>
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
	$("form").validateForm([
		"required,name,Gallery name is required"
	]);
});
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
