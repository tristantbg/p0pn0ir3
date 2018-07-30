<?php if ($track->audioFile()->toFile() || $track->audioLink()->isNotEmpty()): ?>
  <?php $key = $track->audioFile()->toFile()->trackIndex() ?>
  <div class="track amplitude-play-pause amplitude-paused" amplitude-song-index="<?= $key ?>">
  <div><?= $track->title()->html() ?></div>
  <div><span class="amplitude-duration-minutes" amplitude-song-index="<?= $key ?>"></span>:<span class="amplitude-duration-seconds" amplitude-song-index="<?= $key ?>"></span></div>
  <div></div>
  </div>
<?php endif ?>
