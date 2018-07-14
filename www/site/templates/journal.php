<?php snippet('header') ?>

<?php
	$size = [' xs', ' lg'];
	$position = [' top', ' bottom'];
?>

<div id="journal" class="random-layout">
	<?php foreach ($page->medias()->toStructure()->shuffle() as $key => $item): ?>
		<?php if ($image = $item->toFile()): ?>
			<?php
			$classes = $size[array_rand($size)];
			$classes .= $position[array_rand($position)];
			?>
			<div class="item <?= $image->orientation() ?><?= $classes ?>">
				<?php if ($image->embedUrl()->isNotEmpty()): ?>
					<?= $image->embedUrl()->embed([
						'lazyvideo' => true,
						'thumb' => $image->width(1000)->url()
						])
					?>
				<?php else: ?>
					<?php if ($image->pageLink()->isNotEmpty() && $pageLink = page($image->pageLink()->value())): ?>
						<a href="<?= $pageLink->url() ?>" class="link-overlay" data-target></a>
					<?php elseif ($image->externalUrl()->isNotEmpty()): ?>
						<a href="<?= $image->externalUrl() ?>" class="link-overlay" rel="nofollow noopener"></a>
					<?php endif ?>
					<div class="item-image" style="padding-bottom: <?= 100 / $image->ratio() ?>%">
						<img class="lazy lazyload" 
						data-src="<?= $image->width(1000)->url() ?>" 
						<?php 
						$srcset = '';
						for ($i = 1000; $i <= 3000; $i += 500) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
						?>
						data-srcset="<?= $srcset ?>" 
						data-sizes="auto" 
						data-optimumx="1.5" 
						<?php if ($image->caption()->isNotEmpty()): ?>
						alt="<?= $image->caption().' © ' . site()->title()->html() ?>" 
						<?php else: ?>
						alt="<?= $page->title()->html() .' © ' . site()->title()->html(); ?>" 
						<?php endif ?>
						width="100%" height="auto" />
					</div>
				<?php endif ?>
			</div>
		<?php endif ?>
	<?php endforeach ?>
</div>

<?php snippet('footer') ?>