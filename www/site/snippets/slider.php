<?php foreach ($medias as $key => $image): ?>

  <?php if($image = $image->toFile()): ?>

    <div class="slide format-<?= $image->extension() ?>"
    data-caption="<?= $image->caption()->kt()->escape() ?>"
    >

      <div class="content image contain">
        <?php
        if(!isset($maxWidth)) $maxWidth = 3400;
        if (isset($ratio)) {
          $src = $image->crop(1000, floor(1000/$ratio))->url();
          $srcset = $image->crop(340, floor(340/$ratio))->url() . ' 340w,';
          for ($i = 680; $i <= $maxWidth; $i += 340) $srcset .= $image->crop($i, floor($i/$ratio))->url() . ' ' . $i . 'w,';
        } else {
          $src = $image->width(1000)->url();
          $srcset = $image->width(340)->url() . ' 340w,';
          for ($i = 680; $i <= $maxWidth; $i += 340) $srcset .= $image->width($i)->url() . ' ' . $i . 'w,';
        }
        ?>
        <img class="media lazy <?php e($key == 0, " lazyload lazypreload") ?>"
        data-flickity-lazyload="<?= $src ?>"
        data-srcset="<?= $srcset ?>"
        data-sizes="auto"
        data-optimumx="1.5"
        alt="<?= $image->page()->title()->html().' - © '.$site->title()->html() ?>" height="100%" width="auto" />
        <noscript>
          <img src="<?= $src ?>" alt="<?= $image->page()->title()->html().' - © '.$site->title()->html() ?>" width="100%" height="auto" />
        </noscript>
      </div>

    </div>

  <?php endif ?>

<?php endforeach ?>

<div class="slider-footer">
	<div class="slide-number"></div>
	<div class="caption"></div>
</div>