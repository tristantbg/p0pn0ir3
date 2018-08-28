<?php snippet('header') ?>

<div id="artist-medias" data-scroll="x" data-scrollmobile="x">
	<div class="inner-scroll">
		<?php foreach ($medias as $key => $item): ?>
			<?php snippet('artist-image', ['field' => $item]) ?>
		<?php endforeach ?>
	</div>

	<a id="infos-btn" class="uppercase" event-target="panel"><?= l::get('infos-btn') ?></a>

  <div id="player"
  class="uppercase"
  data-songs="<?= $songs ?>">
    <div id="song-infos">
      <span amplitude-song-info="song_title" amplitude-main-song-info="true"></span>
    </div>
    <div id="controls">
      <span class="amplitude-prev">PREV</span>
      <span class="amplitude-current-time" amplitude-main-current-time="true"></span>
      <span id="play-pause" class="amplitude-play-pause" amplitude-main-play-pause="true"></span>
      <span class="amplitude-stop">STOP</span>
      <span class="amplitude-next">NEXT</span>
    </div>
    <!-- <div id="progress-container">
      <input type="range" amplitude-main-song-slider="true" class="amplitude-song-slider">
    </div> -->
  </div>
</div>

<div id="artist-panel" data-scrollmobile="y">

	<div class="inner-scroll">

  <div id="artist-infos" data-scroll="y">
    <div class="inner-scroll">
			<div class="row uppercase" id="artist-title"><?= $page->title()->html() ?></div>
			<div class="row">
				<div id="artist-description"><?= $page->text()->kt() ?></div>
				<div id="artist-links">
					<?php if ($page->socials()->isNotEmpty()): ?>
						<div class="row uppercase">
							<div><?= l::get('follow') ?></div>
							<div>
								<?php foreach ($page->socials()->toStructure() as $key => $item): ?>
									<a class="uppercase" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
								<?php endforeach ?>
							</div>
						</div>
					<?php endif ?>

					<?php if ($page->listen()->isNotEmpty()): ?>
						<div class="row uppercase">
							<div><?= l::get('listen') ?></div>
							<div>
								<?php foreach ($page->listen()->toStructure() as $key => $item): ?>
									<a class="uppercase" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
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

	<div id="artist-releases" data-scroll="x">
    <div class="inner-scroll">
  		<?php foreach ($releases as $key => $release): ?>
  			<div class="release">
          <?php if ($productLink = page($release->productLink())): ?>
          <a href="<?= $site->index()->filterBy('intendedTemplate', 'shop')->first()->url().'?product='.$productLink->id() ?>">
          <?php endif ?>
  				<?php snippet('responsive-image', ['field' => $release->featured()]) ?>
          <?php if ($productLink = page($release->productLink())): ?>
          </a>
          <?php endif ?>
  				<div class="release-infos">
  					<div class="release-title uppercase">
  						<span><?= $release->parent()->title()->html() ?></span>
  						<span><?= $release->title()->html() ?></span>
  					</div>
  					<div class="release-year"><?= $release->date('Y') ?></div>
            <?php if ($release->tracklist()->isNotEmpty() && $playlist = $release->tracklist()->toStructure()): ?>
              <div class="release-playlist">
                <div class="tracklist">
                  <?php foreach ($playlist as $key => $track): ?>
                    <?php snippet("track", array("track" => $track)) ?>
                  <?php endforeach ?>
                </div>
              </div>
            <?php endif ?>
  				</div>
  			</div>
  		<?php endforeach ?>
    </div>
	</div>

	<a id="panel-close" class="uppercase" event-target="panel"><?= l::get('close') ?></a>

  </div>

</div>

<?php snippet('footer') ?>
