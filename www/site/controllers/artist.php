<?php

return function ($site, $pages, $page) {
	$medias = $page->medias()->toStructure();

	return array(
		'ptemplate' => $page->intendedTemplate(),
		'medias' => $medias,
	);
}

?>
