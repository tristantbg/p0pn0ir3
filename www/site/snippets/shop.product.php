<?php if($image = $product->featured()->toFile()): ?>

  <div class="product">

    <?php if ($image->mp4()->isNotEmpty() || $image->filemp4()->isNotEmpty()): ?>

      <?php snippet('video-player', ['image' => $image]) ?>

    <?php else: ?>

      <div class="product-image">
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

    <div class="product-infos" data-scroll="y">
      <div class="inner-scroll">
        <div class="row uppercase" class="product-title"><?= $product->title()->html() ?></div>
        <div class="row">
          <div class="product-description"><?= $product->text()->kt() ?></div>
          <div class="product-links">
            <?php if ($product->socials()->isNotEmpty()): ?>
              <div class="row uppercase">
                <div><?= l::get('follow') ?></div>
                <div>
                  <?php foreach ($product->socials()->toStructure() as $key => $item): ?>
                    <a class="row uppercase" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
                  <?php endforeach ?>
                </div>
              </div>
            <?php endif ?>

            <?php if ($product->listen()->isNotEmpty()): ?>
              <div class="row uppercase">
                <div><?= l::get('listen') ?></div>
                <div>
                  <?php foreach ($product->listen()->toStructure() as $key => $item): ?>
                    <a class="row" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
                  <?php endforeach ?>
                </div>
              </div>
            <?php endif ?>

            <?php if ($product->dates()->isNotEmpty()): ?>
              <div class="row uppercase">
                <div><?= l::get('dates') ?></div>
                <div><?= $product->dates()->kt() ?></div>
              </div>
            <?php endif ?>
          </div>
        </div>
      </div>
    </div>

      <div class="panel-close" event-target="product-panel"><?= l::get('close') ?></div>
      <div class="panel-open" event-target="product-panel"><?= l::get('more') ?></div>

  </div>

<?php endif ?>
