<?php

return function ($site, $pages, $page) {
	$products = $page->children()->visible();

	return array(
		'ptemplate' => $page->intendedTemplate(),
		'artists' => $site->index()->visible()->filterBy('intendedTemplate', 'artist'),
		'products' => $products
  );
}

?>
