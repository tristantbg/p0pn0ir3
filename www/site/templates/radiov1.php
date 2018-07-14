<?php snippet('header') ?>

<div id="dual-content" current-section="left">
	
	<script src="//w.soundcloud.com/player/api.js"></script>

	<div id="dual-content-header">
		<div class="section-switch" event-target="left"><?= $page->titleLeft()->html() ?></div>
		<div class="section-switch" event-target="right"><?= $page->titleRight()->html() ?></div>
	</div>

	<div class="content-left">
		<?php if ($page->playlistLeft()->isNotEmpty()): ?>
		<div id="playlist-left">
			<iframe class="soundcloud-iframe" id="soundcloud-iframe-left" width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?= $page->playlistLeft() ?>&auto_play=false&buying=false&liking=false&download=false&sharing=false&show_artwork=false&show_comments=false&show_playcount=false&show_user=false&hide_related=false&visual=false&start_track=0&callback=true"></iframe>
			<div id="soundcloud-player-left" class="soundcloud-player">
				<?php snippet('soundcloud-player') ?>
			</div>
			<div id="tracklist-left" class="soundcloud-tracklist"></div>
		</div>
		<?php endif ?>
	</div>

	<div class="content-right">
		<?php if ($page->playlistRight()->isNotEmpty()): ?>
		<div id="playlist-right">
			<iframe class="soundcloud-iframe" id="soundcloud-iframe-right" width="100%" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=<?= $page->playlistRight() ?>&auto_play=false&buying=false&liking=false&download=false&sharing=false&show_artwork=false&show_comments=false&show_playcount=false&show_user=false&hide_related=false&visual=false&start_track=0&callback=true"></iframe>
			<div id="soundcloud-player-right" class="soundcloud-player">
				<?php snippet('soundcloud-player') ?>
			</div>
			<div id="tracklist-right" class="soundcloud-tracklist"></div>
		</div>
		<?php endif ?>
	</div>

</div>

<?php snippet('footer') ?>