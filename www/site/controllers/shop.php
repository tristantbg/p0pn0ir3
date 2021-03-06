<?php

return function ($site, $pages, $page) {
	$products = $page->grandChildren()->visible();

	return array(
		'ptemplate' => $page->intendedTemplate(),
		'artists' => $site->index()->visible()->filterBy('intendedTemplate', 'artist'),
		'products' => $products->shuffle()
  );
}

?>
