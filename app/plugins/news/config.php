<?php
$aPluginInfo = array(
	/* Plugin Details */
	"name" => "News",
	"version" => "1.0",
	"author" => "Monkee-Boy",
	"website" => "http://monkee-boy.com/",
	"email" => "webmaster@monkee-create.com",
	"description" => "",

	/* Plugin Configuration */
	"config" => array(
		"useCategories" => true,
		"perPage" => 10,
		"excerptCharacters" => 250, // character limit for excerpt
		"sortCategory" => "manual-asc" // manual, name, items, random - asc, desc
	)
);
