<?php $aContent = getContent(null, 'contact');
if(!empty($aContent)) {
	$sTitle = $aContent['title'];
	$sSubtitle = $aContent['subtitle'];
} else {
	$sTitle = "Find Us";
	$sSubtitle = "Beware of nerf wars";
}

$this->tplDisplay("inc_header.php", ['menu'=>'contact','sPageTitle'=>$sTitle]);
?>

<div class="row">
	<div class="page-title">
		<h1><?= $sTitle ?></h1>
		<p class="subtitle"><?= $sSubtitle ?></p>
	</div>
</div>

<div class="row">
	<div class="full" data-text-align="center">
		<h2>9390 Research Blvd. Suite 425,</h2>
		<h3>Austin, TX 78759</h3>

		<p><a href="#">Directions</a></p>

		<div id="contact-map"></div>

	</div>
</div>

<div class="phone-directory accordion-section">
	<div class="row">
		<div class="full" data-text-align="center">
			<span class="subtitle">give us a ring</span>
			<h2>phone directory</h2>
		</div>

		<div class="half">
			<h4>Sales Team</h4>
			<p>512-335-2221 &bull; ext. 270</p>
			<hr>
			<h4>Maintenance + Support Team</h4>
			<p>512-335-2221 &bull; ext. 270</p>
			<hr>
		</div>
		<div class="half">
			<h4>Marketing Team</h4>
			<p>512-335-2221 &bull; ext. 270</p>
			<hr>
			<h4>Management Team</h4>
			<p>512-335-2221 &bull; ext. 270</p>
			<hr>
		</div>
	</div>
</div>

<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>

<?php $this->tplDisplay("inc_footer.php"); ?>
