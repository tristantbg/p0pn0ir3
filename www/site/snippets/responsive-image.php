<?php if($image = $field->toFile()): ?>

	<div class="responsive-image">
		<?php
		if(!isset($maxWidth)) $maxWidth = 3400;
		if (isset($ratio)) {
			$placeholder = $image->crop(10, floor(10/$ratio))->dataURI();
			$src = $image->crop(1000, floor(1000/$ratio))->url();
			$srcset = $image->crop(340, floor(340/$ratio))->url() . ' 340w,';
			for ($i = 680; $i <= $maxWidth; $i += 340) $srcset .= $image->crop($i, floor($i/$ratio))->url() . ' ' . $i . 'w,';
		} else {
			$placeholder = $image->width(10)->dataURI();
			$src = $image->width(1000)->url();
			$srcset = $image->width(340)->url() . ' 340w,';
			for ($i = 680; $i <= $maxWidth; $i += 340) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
		}
		?>
	    <?php if (isset($ratio)): ?>
	    <div class="ph" style="padding-bottom: <?= number_format(100 / $ratio, 5, '.', '') ?>%"></div>
	    <?php else: ?>
	    <div class="ph" style="padding-bottom: <?= number_format(100 / $image->ratio(), 5, '.', '') ?>%"></div>
	    <?php endif ?>
		<img 
		class="lazy lazyload<?php if(isset($preload)) echo ' lazypreload' ?>"
		src="<?= $placeholder ?>"
		data-src="<?= $src ?>"
		data-srcset="<?= $srcset ?>"
		data-sizes="auto"
		data-optimumx="1.5"
		<?php if (isset($caption) && $caption): ?>
		alt="<?= $caption.' - © '.$site->title()->html() ?>"
		<?php elseif ($image->caption()->isNotEmpty()): ?>
		alt="<?= $image->caption().' - © '.$site->title()->html() ?>"
		<?php else: ?>
		alt="<?= $page->title()->html().' - © '.$site->title()->html() ?>"
		<?php endif ?>
		width="100%" height="auto" />
		<noscript>
			<img src="<?= $src ?>"
			<?php if (isset($caption) && $caption): ?>
			alt="<?= $caption.' - © '.$site->title()->html() ?>"
			<?php elseif ($image->caption()->isNotEmpty()): ?>
			alt="<?= $image->caption().' - © '.$site->title()->html() ?>"
			<?php else: ?>
			alt="<?= $page->title()->html().' - © '.$site->title()->html() ?>"
			<?php endif ?>
			width="100%" height="auto" />
		</noscript>
		<?php if (isset($withCaption) && $image->caption()->isNotEmpty()): ?>
			<div class="row caption"><?= $image->caption()->kt() ?></div>
		<?php endif ?>
	</div>

<?php endif ?>
