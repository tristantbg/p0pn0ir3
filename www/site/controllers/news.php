<?php

return function ($site, $pages, $page) {

  $gridField = $page->gridLayout()->toStructure()->table();
  $gridLayout = '[';

  if ($page->gridLayout()->isNotEmpty()) {
    foreach ($gridField as $key => $tableRow) {
      $gridLayout .= '[';
      foreach ($tableRow as $key2 => $tableCell) {
        $gridLayout .= $tableCell->int();
        if($key2 < $tableRow->count() - 1) $gridLayout .= ',';
      }
      $gridLayout .= ']';
      if($key < $gridField->count() - 1) $gridLayout .= ',';
    }
  }
  $gridLayout .= ']';

	return array(
		'ptemplate' => $page->intendedTemplate(),
    'artists' => $site->index()->visible()->filterBy('intendedTemplate', 'artist'),
		'gridLayout' => $gridLayout
	);
}

?>
