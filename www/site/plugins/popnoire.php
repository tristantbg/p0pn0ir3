<?php

kirby()->hook('panel.page.*', function($page, $oldPage = null) {
  if($page->intendedTemplate() == 'release') {

    $releases = site()->index()->filterBy('intendedTemplate', 'release');

    foreach ($releases as $key => $p) {
      $tracks = $p->tracklist()->toStructure();

      foreach ($tracks as $key => $t) {
        if($file = $t->audioFile()->toFile()) {
          $file->update(['trackIndex' => $index]);
          $index++;
        }
      }
    }

  }
});
