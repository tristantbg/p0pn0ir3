<?php if($image = $field->toFile()): ?>

  <?php if ($image->mp4()->isNotEmpty() || $image->filemp4()->isNotEmpty()): ?>

    <?php snippet('video-player', ['image' => $image]) ?>

  <?php else: ?>

    <div class="artist-image">
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
      height="100%" width="auto" />
      <?php if($image->embed()->isNotEmpty()): ?>
        <?= $image->embed()->embed(['thumb' => $image->width(1000)->url()]) ?>
      <?php endif ?>
      <noscript>
        <img src="<?= $src ?>"
        <?php if (isset($caption) && $caption): ?>
        alt="<?= $caption.' - © '.$site->title()->html() ?>"
        <?php elseif ($image->caption()->isNotEmpty()): ?>
        alt="<?= $image->caption().' - © '.$site->title()->html() ?>"
        <?php else: ?>
        alt="<?= $page->title()->html().' - © '.$site->title()->html() ?>"
        <?php endif ?>
        height="100%" width="auto" />
      </noscript>
      <?php if (isset($withCaption) && $image->caption()->isNotEmpty()): ?>
        <div class="row caption"><?= $image->caption()->kt() ?></div>
      <?php endif ?>

    </div>

  <?php endif ?>

<?php endif ?>
