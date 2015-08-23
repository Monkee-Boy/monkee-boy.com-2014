<?php
$this->tplDisplay("inc_header.php", ['menu'=>'testimonials', 'page_title'=>$aContent['title'], 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]); ?>

<div class="row">
	<div class="page-title">
		<h1><?= $aContent['title']; ?></h1>
		<p class="subtitle"><?= $aContent['subtitle']; ?></p>
	</div>
</div>

<?php $this->tplDisplay('inc_subnav.php', array('menu' => 'testimonials', 'nav' => 'work')); ?>

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
