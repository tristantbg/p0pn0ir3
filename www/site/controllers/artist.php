<?php

return function ($site, $pages, $page) {
	$medias = $page->medias()->toStructure();
  $releases = $page->children()->visible();

  $songs = '[';
  foreach ($releases as $key => $release){
    $tracks = $release->tracklist()->toStructure();
    foreach ($tracks as $key => $track){
      if ($file = $track->audioFile()->toFile()){
         $songs .= esc('{"url": "'.$file->url().'","song_title": "'.$page->title()->html().'&nbsp;&nbsp;'.$track->title()->html().'"}');
      }
    }
  }
  $songs .= ']';

	return array(
		'ptemplate' => $page->intendedTemplate(),
		'artists' => $site->index()->visible()->filterBy('intendedTemplate', 'artist'),
		'medias' => $medias->shuffle(),
    'releases' => $releases,
		'songs' => $songs
	);
}

?>
