<?php snippet('header') ?>

<?php $tracksLeft = $page->playlistLeft()->toStructure()->count(); ?>

<div id="dual-content" current-section="left">
	
	<div id="dual-content-header">
		<div class="section-switch" event-target="left"><?= $page->titleLeft()->html() ?></div>
		<div class="section-switch" event-target="right"><?= $page->titleRight()->html() ?></div>
	</div>

	<div class="content-left">
		<?php if ($page->playlistLeft()->isNotEmpty() && $playlist = $page->playlistLeft()->toStructure()): ?>
			
			<div class="playlist">
				<div id="tracklist" class="tracklist">
					<?php foreach ($playlist as $key => $track): ?>
						<?php snippet("radiomix", array("track" => $track, "key" => $key)) ?>
					<?php endforeach ?>
				</div>
			</div>
		<?php endif ?>
		<div id="player">
			<div class="x xjb">
				<div id="play-pause" class="amplitude-play-pause" amplitude-main-play-pause="true"></div>
				<div id="time" class="x xjb">
					<div id="current" class="amplitude-current-time time-container" amplitude-main-current-time="true">00:00</div>
						<div id="progress-container">
							<input type="range" amplitude-main-song-slider="true" class="amplitude-song-slider">
						</div>
					<div id="duration"></div>
				</div>
			</div>
		</div>
	</div>

	<div class="content-right">
		<?php if ($page->playlistRight()->isNotEmpty() && $playlist = $page->playlistRight()->toStructure()): ?>
			
			<div class="playlist">
				<div id="tracklist" class="tracklist">
					<?php foreach ($playlist as $key => $track): ?>
						<?php snippet("radiomix", array("track" => $track, "key" => $key + $tracksLeft)) ?>
					<?php endforeach ?>
				</div>
			</div>

		<?php endif ?>
	</div>

</div>

<script>
	var songs = [
	<?php foreach ($page->playlistLeft()->toStructure() as $key => $track): ?>
	<?php
		$url = "";
		if($track->audioLink()->isNotEmpty()) $url = $track->audioLink()->value();
		if($track->audioFile()->isNotEmpty() && $file = $track->audioFile()->toFile()) $url = $file->url();
	?>
		{ "url": "<?= $url ?>" },	
	<?php endforeach ?>
	<?php foreach ($page->playlistRight()->toStructure() as $key => $track): ?>
	<?php
		$url = "";
		if($track->audioLink()->isNotEmpty()) $url = $track->audioLink()->value();
		if($track->audioFile()->isNotEmpty() && $file = $track->audioFile()->toFile()) $url = $file->url();
	?>
		{ "url": "<?= $url ?>" },	
	<?php endforeach ?>
	]
	var playlists = [];
</script>

<?php snippet('footer') ?>