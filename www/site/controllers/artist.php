<?php

return function ($site, $pages, $page) {
	$medias = $page->medias()->toStructure();

	return array(
		'ptemplate' => $page->intendedTemplate(),
		'artists' => $site->index()->visible()->filterBy('intendedTemplate', 'artist'),
		'medias' => $medias,
		'releases' => $page->children()->visible()
	);
}

?>
