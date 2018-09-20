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
  <?php $key = $track->audioFile()->toFile()->trackIndex() ?>
  <div class="track amplitude-play-pause amplitude-paused link-hover black" amplitude-song-index="<?= $key ?>">
  <div><?= $track->title()->html() ?></div>
  <div><?= $track->duration()->html() ?><span class="amplitude-duration-minutes-disable" amplitude-song-index="<?= $key ?>"></span><span class="amplitude-duration-seconds-disable" amplitude-song-index="<?= $key ?>"></span></div>
  <div></div>
  </div>
<?php endif ?>
