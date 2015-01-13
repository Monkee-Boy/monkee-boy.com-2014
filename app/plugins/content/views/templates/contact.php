<?php $aContent = getContent(null, 'contact');
if(!empty($aContent)) {
	$sTitle = $aContent['title'];
	$sSubtitle = $aContent['subtitle'];
} else {
	$sTitle = "Find Us";
	$sSubtitle = "Beware of nerf wars";
}

$this->tplDisplay("inc_header.php", ['menu'=>'contact','sPageTitle'=>$sTitle, 'seo_title'=>$aContent['seo_title'], 'seo_description'=>$aContent['seo_description'], 'seo_keywords'=>$aContent['seo_keywords']]);
?>

<div class="row">
	<div class="page-title">
		<h1><?= $sTitle ?></h1>
		<p class="subtitle"><?= $sSubtitle ?></p>
	</div>
</div>

<div class="row">
	<div class="full" data-text-align="center">
		<h2>9390 Research Blvd. Bldg II, Suite 425, Austin, TX 78759</h2>

		<p><a href="https://maps.google.com?daddr=9390+Research+Blvd.+Bldg+II,+Suite 425,+Austin,+TX+78759" target="_blank">Get Directions to Monkee-Boy World Headquarters</a></p>

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
			<div class="accordion">
				<a href="#" class="trigger">Sales Team</a>
				<div class="content">512-335-2221 &bull; ext. 100</div>
			</div><!-- /.accordion -->
			<div class="accordion">
				<a href="#" class="trigger">Maintenance + Support Team</a>
				<div class="content">512-335-2221 &bull; ext. 110</div>
			</div><!-- /.accordion -->
		</div>
		<div class="half">
			<div class="accordion">
				<a href="#" class="trigger">Marketing Team</a>
				<div class="content">512-335-2221 &bull; ext. 101</div>
			</div><!-- /.accordion -->
			<div class="accordion">
				<a href="#" class="trigger">Management Team</a>
				<div class="content">512-335-2221 &bull; ext. 100</div>
			</div><!-- /.accordion -->
		</div>
	</div>
</div>

<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>

<?php $this->tplDisplay("inc_footer.php"); ?>
