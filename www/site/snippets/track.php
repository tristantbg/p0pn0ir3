<?php if ($track->audioFile()->toFile() || $track->audioLink()->isNotEmpty()): ?>
	<?php

	$minutes = '';
	$seconds = '';
	if ($track->audioFile()->toFile()) {
		$file = $track->audioFile()->toFile();
		$minutes = $file->durationMinutes();
		$seconds = $file->durationSeconds();
	}

	?>
  <?php // $key = $track->audioFile()->toFile()->trackIndex() ?>
  <div class="track amplitude-play-pause amplitude-paused" amplitude-song-index="<?= $key ?>">
  <div><?= $track->title()->html() ?></div>
  <div><span class="amplitude-duration-minutes" amplitude-song-index="<?= $key ?>"><?= $minutes ?></span><span class="amplitude-duration-seconds" amplitude-song-index="<?= $key ?>"><?= $seconds ?></span></div>
  <div></div>
  </div>
<?php endif ?>
