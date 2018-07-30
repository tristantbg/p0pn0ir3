<?php

return function ($site, $pages, $page) {

	return array(
		'ptemplate' => $page->intendedTemplate(),
		'artists' => $site->index()->visible()->filterBy('intendedTemplate', 'artist'),
	);
}

?>
