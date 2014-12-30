<?php
$aPluginInfo = array(
	/* Plugin Details */
	"name" => "Posts",
	"version" => "1.0",
	"author" => "Monkee-Boy",
	"website" => "http://monkee-boy.com/",
	"email" => "webmaster@monkee-boy.com",
	"description" => "Keep your visitors up to date with your latest happenings. Includes the ability to schedule posts to publish and unpublish automatically, upload an image for each post, assign to multiple categories, a full editor along with short description and social sharing to auto post to Facebook and Twitter.",

	/* Plugin Configuration */
	"config" => array(
		"useImage" => true,
		"imageFolder" => "/uploads/posts/",
		"useCategories" => true,
		"perPage" => 6,
		"useComments" => true,
		"excerptCharacters" => 500, // character limit for excerpt
		"sortCategory" => "manual-asc" // manual, name, items, random - asc, desc
	)
);
