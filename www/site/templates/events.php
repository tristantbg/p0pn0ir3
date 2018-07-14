<?php snippet('header') ?>

<div id="dual-content" current-section="left">

	<div id="dual-content-header">
		<div class="section-switch" event-target="left"><?= $page->title()->html() ?></div>
		<div class="section-switch" event-target="right">Archives</div>
	</div>

	<div id="events" class="content-left">
		<?php foreach ($page->children()->visible() as $key => $event): ?>
			<div class="event">
				<div class="event-slider">
					<?php foreach ($event->medias()->toStructure() as $key => $i): ?>
						<div class="slide">
							<?php $image = $i->toFile() ?>
							<img class="lazy" 
							<?php if ($key == 0): ?>
							src="<?= $image->width(1000)->url() ?>" 
							<?php else: ?>
							data-flickity-lazyload="<?= $image->width(1000)->url() ?>" 
							<?php endif ?>
							alt="<?= $event->title() . ' © ' . $site->title()->html() ?>" width="100%" height="auto" />
							<noscript>
								<img class="slide" 
								src="<?= $image->width(1000)->url() ?>" 
								alt="<?= $event->title() . ' © ' . $site->title()->html() ?>" width="100%" height="auto" />
							</noscript>
						</div>
					<?php endforeach ?>
				</div>
				<div class="caption small">
					<div class="date"><?= $event->date("d.m.Y") ?></div>
					<div class="title"><?= e($event->place()->isNotEmpty(), $event->place()->html()." — ") . $event->title()->html() ?></div>
				</div>
				<p></p>
			</div>
		<?php endforeach ?>
	</div>

	<div id="archives" class="content-right uppercase">
		<?= $page->archivesText()->kt() ?>
	</div>

</div>

<?php snippet('footer') ?>