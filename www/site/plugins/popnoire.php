<?php

kirby()->hook('panel.page.*', function($page, $oldPage = null) {
  if($page->intendedTemplate() == 'release') {

    $artists = site()->index()->filterBy('intendedTemplate', 'artist');

    foreach ($artists as $key => $a) {
        $index = 0;
        foreach ($a->children()->visible() as $key => $p) {
          $tracks = $p->tracklist()->toStructure();

          foreach ($tracks as $key => $t) {
            if($file = $t->audioFile()->toFile()) {
              $file->update(['trackIndex' => $index]);
              $index++;
            }
          }
        }
    }

  }
});
