<?php $this->tplDisplay("inc_header.php", ['menu'=>'testimonials','page_title'=>'Testimonials']); ?>

<div class="row">
	<div class="page-title">
		<h1>Testimonials</h1>
		<p class="subtitle">we do stuff, in our office &amp; around town</p>
	</div>
</div>

	<?php if(!empty($aTestimonials)): ?>
		<?php foreach($aTestimonials as $aTestimonial): ?>
			<div class="row">
				<div class="full testimonial-item">
					<div class="client"><?= $aTestimonial['client'] ?></span></div>
					<div class="testimonial">
						<div class="text">
							"<?= $aTestimonial['text'] ?>"
						</div>
						<div class="name"><?= $aTestimonial['name'] ?></div>
						<div class="title"><?= $aTestimonial['title'] ?></div>
					</div>
				</div>
				<hr>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

<?php $this->tplDisplay("inc_footer.php"); ?>
