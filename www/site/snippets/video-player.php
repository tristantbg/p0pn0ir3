<?php
if ($image) {
  $poster = $image->width(1000)->url();
  $videoContainer = Brick('div')->attr('class', 'artist-image video-container');
  $video = null;

  if ($image->stream()->isNotEmpty() ||
    $image->mp4()->isNotEmpty() ||
    $image->webm()->isNotEmpty() ||
    $image->filemp4()->isNotEmpty() ||
    $image->filewebm()->isNotEmpty()) {

    $video = Brick('video')
          ->attr('class', 'video-player')
          ->attr('poster', $poster)
          ->attr('height', '100%')
          ->attr('width', 'auto')
          ->attr('playsinline', 'true')
          ->attr('preload', 'auto');

    if ($image->stream()->isNotEmpty()) $video->attr('data-stream', $image->stream());

    if ($image->mp4()->isNotEmpty()) {

      $video->append('<source src=' . $image->mp4() . ' type="video/mp4">');

      if ($image->webm()->isNotEmpty()) $video->append('<source src=' . $image->webm() . ' type="video/webm">');

    } else if ($file = $image->filemp4()->toFile()){

      $video->append('<source src=' . $file->url() . ' type="video/mp4">');

      if ($file = $image->filewebm()->toFile()) $video->append('<source src=' . $file->url() . ' type="video/webm">');
    }

    $videoContainer->append($video);


    $videoContainer->append('<div class="play-cursor video-cursor"></div>');
    $videoContainer->append('<div class="pause-cursor video-cursor"></div>');
    $videoContainer->append('<div class="seekbar"><div class="thumb"></div></div>');

    echo $videoContainer;
  }
  else {

    snippet('responsive-image', array('field' => $image->thumb()));

  }
}
?>
