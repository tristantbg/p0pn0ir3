<?php

kirby()->hook('panel.page.*', function($page, $oldPage = null) {
  if($page->intendedTemplate() == 'release') {

    $projects = site()->index()->filterBy('intendedTemplate', 'release');
    $index = 0;

    foreach ($projects as $key => $p) {
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
