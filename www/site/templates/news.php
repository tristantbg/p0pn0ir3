<?php snippet('header') ?>

<?php
	// $size = [' xs', ' lg'];
	// $position = [' top', ' bottom'];
?>

<div id="news" data-scroll="x" data-grid="<?= $gridLayout ?>">
	<div class="inner-scroll">
    <div class="grid">
      <?php foreach ($page->medias()->toStructure() as $key => $item): ?>
        <?php if ($image = $item->toFile()): ?>
          <?php
          // $classes = $size[array_rand($size)];
          // $classes .= $position[array_rand($position)];
          ?>
          <div class="item <?= $image->orientation() ?>">
            <?php if ($image->embedUrl()->isNotEmpty()): ?>
              <?= $image->embedUrl()->embed([
                'lazyvideo' => true,
                'thumb' => $image->width(1000)->url()
                ])
              ?>
            <?php else: ?>
              <?php if ($image->pageLink()->isNotEmpty() && $pageLink = page($image->pageLink()->value())): ?>
                <a href="<?= $pageLink->url() ?>" class="link-overlay"></a>
              <?php elseif ($image->externalUrl()->isNotEmpty()): ?>
                <a href="<?= $image->externalUrl() ?>" class="link-overlay"></a>
              <?php endif ?>
              <?php snippet('responsive-image', ['field' => $item]) ?>
              <div class="caption"><!--
                 --><?php if ($image->subtitle()->isNotEmpty()): ?>
                  <div class="subtitle uppercase"><?= $image->subtitle()->html() ?></div>
                <?php endif ?><!--
                 --><?php if ($image->date()): ?>
                  <div class="date uppercase"><?= $image->date('d.m.Y') ?></div>
                <?php endif ?><!--
                 --><?php if ($image->caption()->isNotEmpty()): ?>
                  <div class="text"><?= $image->caption()->kt() ?></div>
                <?php endif ?><!--
               --></div>
            <?php endif ?>
          </div>
        <?php endif ?>
      <?php endforeach ?>
    </div>
  </div>
</div>

<?php snippet('footer') ?>
