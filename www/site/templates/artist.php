<?php snippet('header') ?>

<div id="artist-medias">
	<div class="row" data-scroller>
		<?php foreach ($medias as $key => $item): ?>
			<?php snippet('artist-image', ['field' => $item]) ?>
		<?php endforeach ?>
	</div>

	<div id="infos-btn" class="uppercase" event-target="panel"><?= l::get('infos-btn') ?></div>
</div>

<div id="artist-panel">

	<div id="artist-infos">
		<div class="row" data-scroller>
			<div class="row uppercase" id="artist-title"><?= $page->title()->html() ?></div>
			<div class="row">
				<div id="artist-description"><?= $page->text()->kt() ?></div>
				<div id="artist-links">
					<?php if ($page->socials()->isNotEmpty()): ?>
						<div class="row uppercase">
							<div><?= l::get('follow') ?></div>
							<div>
								<?php foreach ($page->socials()->toStructure() as $key => $item): ?>
									<a class="row uppercase" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>

					<?php if ($page->listen()->isNotEmpty()): ?>
						<div class="row uppercase">
							<div><?= l::get('listen') ?></div>
							<div>
								<?php foreach ($page->listen()->toStructure() as $key => $item): ?>
									<a class="row" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>

					<?php if ($page->dates()->isNotEmpty()): ?>
						<div class="row uppercase">
							<div><?= l::get('dates') ?></div>
							<div><?= $page->dates()->kt() ?></div>
						</div>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>

	<div id="artist-releases">
		<?php foreach ($releases as $key => $release): ?>
			<div class="release">
				<?php snippet('responsive-image', ['field' => $release->featured()]) ?>
				<div class="release-infos">
					<div class="release-title">
						<span><?= $release->parent()->title()->html() ?></span>
						<span><?= $release->title()->html() ?></span>
					</div>
					<div class="release-year"><?= $release->date('Y') ?></div>
				</div>
			</div>
		<?php endforeach ?>
	</div>

	<div id="panel-close" class="uppercase" event-target="panel"><?= l::get('close') ?></div>
</div>

<?php snippet('footer') ?>