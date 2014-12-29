<?php $this->tplDisplay("inc_header.php", ['menu'=>'posts','sPageTitle'=>"Posts &raquo; Create Post"]); ?>

	<h1>Posts &raquo; Create Post</h1>
	<?php $this->tplDisplay('inc_alerts.php'); ?>

	<form id="add-form" method="post" action="/admin/posts/add/s/" enctype="multipart/form-data">
		<div class="row-fluid">
			<div class="span8">
				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Title</span>
					</div>
					<div id="pagecontent" class="accordion-body">
						<div class="accordion-inner">
							<div class="controls">
								<input type="text" name="title" id="form-title" value="<?= $aPost['title'] ?>" class="span12 validate[required]">
							</div>
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Content</span>
					</div>
					<div class="accordion-body">
						<div class="accordion-inner">
							<div class="controls">
								<?= html_editor($aPost['content'], "content") ?>
							</div>
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Excerpt</span>
					</div>
					<div class="accordion-body">
						<div class="accordion-inner">
							<div class="controls">
								<textarea name="excerpt" class="span12" style="height:115px;"><?= $aPost['excerpt'] ?></textarea>
								<p class="help-block"><span id="currentCharacters"></span> of <?= $sExcerptCharacters ?> characters</p>
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
											<option value="<?= $aCategory['id'] ?>"<?php if(in_array($aCategory['id'], $aPost['categories'])){ echo ' selected="selected"'; } ?>><?= $aCategory['name'] ?></option>
										<?php endforeach; ?>
	             		</select>

				          <p class="help-block">Hold down ctrl (or cmd) to select multiple categories at once.</p>
								<?php else: ?>
			          	<p>There are currently no categories. Need to <a href="#" title="">add one</a>?</p>
			          <?php endif; ?>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>

			<div class="span4 aside">
				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Publish</span>
					</div>
					<div class="accordion-body">
						<div class="accordion-inner">
							<div class="control-group cf">
								<div class="controls">
									<input type="submit" name="submit-type" value="Save Draft" class="btn pull-left">
									<input type="submit" name="submit-type" value="Publish" class="btn btn-primary pull-right">
								</div>
							</div>

							<div class="control-group">
								<div class="controls">
									<label class="checkbox"><input type="checkbox" name="sticky" id="form-sticky" value="1"<?php if($aPost['sticky'] == 1){ echo ' checked="checked"'; } ?>>Stick this post to the front page.</label>
								</div>

								<?php if($useComments): ?>
								<div class="controls">
									<label class="checkbox"><input type="checkbox" name="allow_comments" id="form-comments" value="1"<?php if($aPost['allow_comments'] == 1){ echo ' checked="checked"'; } ?>>Allow comments.</label>
								</div>
								<?php endif; ?>

								<div class="controls">
									<label class="checkbox"><input type="checkbox" name="allow_sharing" id="form-sharing" value="1"<?php if($aPost['allow_sharing'] == 1){ echo ' checked="checked"'; } ?>>Show social sharing buttons on this post.</label>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Schedule</span>
					</div>
					<div class="accordion-body">
						<div class="accordion-inner">
							<div class="control-group">
								<div class="controls timepicker">
									<input type="input" name="publish_on_date" value="<?= $aPost['publish_on_date'] ?>" id="datepicker" class="span12">
									@ <?= html_select_time($aPost['publish_on'], "publish_on_", 15, false, false); ?>

									<p class="help-block">The post will be pending until this date and time then it will automatically publish.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<?php if($sUseImage): ?>
				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Listing Image</span>
					</div>
					<div id="pageseo" class="accordion-body">
						<div class="accordion-inner">
							<?php if(!empty($aPost['listing_image'])): ?>
								<div class="control-group photo-show">
									<img src="<?= $aPost['listing_image_url'] ?>" alt="Listing Image" style="max-width: 300px;"><br />
									<a href="#">Replace Image</a>
								</div>
							<?php endif; ?>

							<div class="control-group photo-upload"<?php if(!empty($aPost['listing_image'])){ echo ' style="display: none;"'; } ?>>
								<label class="control-label" for="form-tag">Upload Photo</label>
								<div class="controls">
									<input type="file" name="listing_image">
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Header Image</span>
					</div>
					<div id="pageseo" class="accordion-body">
						<div class="accordion-inner">
							<?php if(!empty($aPost['featured_image'])): ?>
								<div class="control-group photo-show">
									<img src="<?= $aPost['featured_image_url'] ?>" alt="Featured Image" style="max-width: 300px;"><br />
									<a href="#">Replace Image</a>
								</div>
							<?php endif; ?>

							<div class="control-group photo-upload"<?php if(!empty($aPost['featured_image'])){ echo ' style="display: none;"'; } ?>>
								<label class="control-label" for="form-tag">Upload Photo</label>
								<div class="controls">
									<input type="file" name="featured_image">
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>

				<!-- <div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Social Sharing</span>
					</div>
					<div class="accordion-body">
						<div class="accordion-inner">
							<div class="control-group">
								<div class="controls">
									<label class="checkbox"><input type="checkbox" name="post_twitter" value="1"<?php if($aPost['post_twitter'] == 1){ echo ' checked="checked"'; } ?>> <img src="/images/admin/social/twitter.png" width="15px"> Share this post to Twitter.</label>
								</div>

								<div class="controls">
									<label class="checkbox"><input type="checkbox" name="post_facebook" value="1"<?php if($aPost['post_facebook'] == 1){ echo ' checked="checked"'; } ?>> <img src="/images/admin/social/facebook_32.png" width="15px"> Share this post to Facebook.</label>
								</div>
							</div>
						</div>
					</div>
				</div> -->

				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Author</span>
					</div>
					<div class="accordion-body">
						<div class="accordion-inner">
							<div class="control-group">
								<div class="controls">
									<select name="authorid" id="form-author">
										<?php foreach($aTroop as $aUser): ?>
											<option value="<?= $aUser['id'] ?>"<?php if($aUser['id'] == $aPost['authorid']){ echo ' selected="selected"'; } ?>><?= $aUser['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="accordion-group">
					<div class="accordion-heading">
						<span class="accordion-toggle">Tags</span>
					</div>
					<div class="accordion-body in collapse">
						<div class="accordion-inner">
							<div class="controls">
								<textarea name="tags" id="form-tags" style="height:115px;" class="span12"><?= $aPost['tags'] ?></textarea>
								<p class="help-block">Comma separated list of keywords.</p>
							</div>
						</div>
					</div>
				</div>
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

	$('#datepicker').datepicker({
		dateFormat: 'DD, MM dd, yy',
		changeMonth: true,
		changeYear: true
	});

	$('#currentCharacters').html($('textarea[name=excerpt]').val().length);
	$('textarea[name=excerpt]').keyup(function() {
		if($(this).val().length > {$sExcerptCharacters})
			$('#currentCharacters').parent().css('color', '#cc0000');
		else
			$('#currentCharacters').parent().css('color', 'inherit');
		$('#currentCharacters').html($(this).val().length);
	});
});
</script>
{/footer}

<?php $this->tplDisplay("inc_footer.php"); ?>
