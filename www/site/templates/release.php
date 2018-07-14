<?php snippet('header') ?>

<div id="release-header">
	<div class="release-artist"><?= $page->artist()->html() ?></div>
	<div class="release-title"><?= $page->title()->html() ?></div>
	<div class="release-number">
		<?php if ($page->hasNextVisible()): ?>
		<a href="<?= $page->nextVisible()->url() ?>" data-target>&larr;&nbsp;</a>
		<?php else: ?>
		<a href="<?= $releases->first()->url() ?>" data-target>&larr;&nbsp;</a>
		<?php endif ?>
		<?= html($page->catalogueNumber()->upper()) ?>
		<?php if ($page->hasPrevVisible()): ?>
		<a href="<?= $page->prevVisible()->url() ?>" data-target>&nbsp;&rarr;</a>
		<?php else: ?>
		<a href="<?= $releases->last()->url() ?>" data-target>&nbsp;&rarr;</a>
		<?php endif ?>
	</div>
</div>

<div id="release-content">
	<div id="release-top">
		<div id="release-image" class="slider">
			<?php if ($featured = $page->featured()->toFile()): ?>
				<div class="slide">
					<img class="lazy" 
					src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
					data-flickity-lazyload="<?= $featured->width(1000)->url() ?>" 
					<?php 
					$srcset = '';
					for ($i = 1000; $i <= 3000; $i += 500) $srcset .= $featured->width($i)->url() . ' ' . $i . 'w,';
					?>
					data-srcset="<?= $srcset ?>" 
					data-sizes="auto" 
					data-optimumx="1.5" 
					alt="<?= $page->copyright() ?>" width="100%" height="auto" />
					<noscript>
						<img class="slide" 
						src="<?= $featured->width(1500)->url() ?>" 
						alt="<?= $page->copyright() ?>" width="100%" height="auto" />
					</noscript>
				</div>
			<?php endif ?>
			<?php foreach ($page->medias()->toStructure() as $key => $i): ?>
				<div class="slide">
					<?php $image = $i->toFile() ?>
					<img class="lazy" 
					src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" 
					data-flickity-lazyload="<?= $image->width(1000)->url() ?>" 
					<?php 
					$srcset = '';
					for ($i = 1000; $i <= 3000; $i += 500) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
					?>
					data-srcset="<?= $srcset ?>" 
					data-sizes="auto" 
					data-optimumx="1.5" 
					alt="<?= $page->copyright() ?>" width="100%" height="auto" />
					<noscript>
						<img class="slide" 
						src="<?= $image->width(1500)->url() ?>" 
						alt="<?= $page->copyright() ?>" width="100%" height="auto" />
					</noscript>
				</div>
			<?php endforeach ?>
		</div>
		<div id="release-tracklist">
			<?php if ($page->tracklist()->isNotEmpty() && $playlist = $page->tracklist()->toStructure()): ?>
				
				<div id="playlist">
					<div id="tracklist" class="tracklist">
						<?php foreach ($playlist as $key => $track): ?>
							<?php snippet("track", array("track" => $track, "key" => $key)) ?>
						<?php endforeach ?>
					</div>
					<div id="player">
						<div class="x xjb">
							<div id="play-pause" class="amplitude-play-pause" amplitude-main-play-pause="true"></div>
							<div id="time" class="x xjb">
								<div id="current" class="amplitude-current-time time-container" amplitude-main-current-time="true">00:00</div>
									<div id="progress-container">
										<input type="range" amplitude-main-song-slider="true" class="amplitude-song-slider">
									</div>
								<div id="duration" class="amplitude-duration-time time-container" amplitude-main-duration-time="true"></div>
							</div>
						</div>
						<div class="x">
							<div class="amplitude-prev">PREV</div>
							<div class="amplitude-next">NEXT</div>
						</div>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
	<div id="release-description">
		<?php if ($page->text()->isNotEmpty()): ?>
			<div id="release-text">
				<?= $page->text()->kt() ?>
			</div>
		<?php endif ?>
		<div id="release-infos">
			<div class="page-left">
				<?php if ($page->date()): ?>
					<div class="subsection">
						<div class="subsection-title column">Date</div>
						<div class="subsection-text"><?= $page->date("F d, Y") ?></div>
					</div>
				<?php endif ?>
				<?php if ($page->composer()->isNotEmpty()): ?>
					<div class="subsection">
						<div class="subsection-title column">Composer</div>
						<div class="subsection-text"><?= $page->composer()->kt() ?></div>
					</div>
				<?php endif ?>
				<?php if ($page->format()->isNotEmpty()): ?>
					<div class="subsection">
						<div class="subsection-title column">Format</div>
						<div class="subsection-text"><?= $page->format()->kt() ?></div>
					</div>
				<?php endif ?>
				<?php if ($page->mastering()->isNotEmpty()): ?>
					<div class="subsection">
						<div class="subsection-title column">Mastering</div>
						<div class="subsection-text"><?= $page->mastering()->kt() ?></div>
					</div>
				<?php endif ?>
				<?php if ($page->distribution()->isNotEmpty()): ?>
					<div class="subsection">
						<div class="subsection-title column">Distribution</div>
						<div class="subsection-text"><?= $page->distribution()->kt() ?></div>
					</div>
				<?php endif ?>
				<?php foreach ($page->additionalText()->toStructure() as $key => $subsection): ?>
					<div class="subsection">
						<div class="subsection-title column"><?= $subsection->title()->html() ?></div>
						<div class="subsection-text"><?= $subsection->text()->kt() ?></div>
					</div>
				<?php endforeach ?>
				<?php if ($page->front()->isNotEmpty()): ?>
					<div class="subsection">
						<div class="subsection-title column">Front cover</div>
						<div class="subsection-text"><?= $page->front()->kt() ?></div>
					</div>
				<?php endif ?>
				<?php if ($page->back()->isNotEmpty()): ?>
					<div class="subsection">
						<div class="subsection-title column">Back</div>
						<div class="subsection-text"><?= $page->back()->kt() ?></div>
					</div>
				<?php endif ?>
			</div>
			<div class="page-right">
				<div class="subsection">
					<div class="subsection-title">Buy</div>
					<div class="subsection-text grow">
						<?php foreach ($page->buy()->toStructure() as $key => $item): ?>
							<?php if ($item->url()->isNotEmpty()): ?>
								<div>
									<a href="<?= $item->url() ?>" rel="nofollow noopener" target="_blank"><?= $item->title() ?></a>
								</div>
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	var songs = [
	<?php foreach ($page->tracklist()->toStructure() as $key => $track): ?>
		<?php if ($file = $track->audioFile()->toFile()): ?>
			{ "url": "<?= $file->url() ?>" },	
		<?php endif ?>
	<?php endforeach ?>
	]
	var playlists = [];
</script>

<?php snippet('footer') ?>