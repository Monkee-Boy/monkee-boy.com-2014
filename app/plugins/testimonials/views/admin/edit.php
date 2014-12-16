<?php $this->tplDisplay("inc_header.php", ['menu'=>'testimonials','sPageTitle'=>"Testimonials &raquo; Manage Testimonial"]); ?>

<h2>Testimonials &raquo; Manage Testimonial</h2>
<?php $this->tplDisplay('inc_alerts.php'); ?>

<form id="add-form" method="post" action="/admin/testimonials/edit/s/">
	<div class="row-fluid">
		<div class="span8">
			<div class="accordion-group">
				<div class="accordion-heading">
					<span class="accordion-toggle">Client</span>
				</div>
				<div id="pagecontent" class="accordion-body">
					<div class="accordion-inner">
						<div class="controls">
							<input type="text" name="client" id="form-client" value="<?= $aTestimonial['client'] ?>" class="span12 validate[required]">
						</div>
					</div>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading">
					<span class="accordion-toggle">Name</span>
				</div>
				<div id="pagecontent" class="accordion-body">
					<div class="accordion-inner">
						<div class="controls">
							<input type="text" name="name" id="form-name" value="<?= $aTestimonial['name'] ?>" class="span12 validate[required]">
						</div>
					</div>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading">
					<span class="accordion-toggle">Title</span>
				</div>
				<div id="pagecontent" class="accordion-body">
					<div class="accordion-inner">
						<div class="controls">
							<input type="text" name="title" id="form-title" value="<?= $aTestimonial['title'] ?>" class="span12 validate[required]">
						</div>
					</div>
				</div>
			</div>

			<div class="accordion-group">
				<div class="accordion-heading">
					<span class="accordion-toggle">Testimonial</span>
				</div>
				<div class="accordion-body">
					<div class="accordion-inner">
						<div class="controls">
							<textarea name="text" class="span12"><?= $aTestimonial['text'] ?></textarea>
						</div>
					</div>
				</div>
			</div>

			<input type="hidden" name="id" value="<?php echo $aTestimonial['id']; ?>">
			<input type="submit" value="Save Changes" class="btn btn-primary">
			<a href="/admin/testimonials/" title="Cancel" class="btn">Cancel</a>
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
								<input type="checkbox" name="active" value="1"<?php echo (($aTestimonial['active'] == 1)?' checked="checked"':''); ?>>
							</div>
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
	});
</script>
{/footer}
<?php $this->tplDisplay("inc_footer.php"); ?>
