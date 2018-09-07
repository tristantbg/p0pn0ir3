<?php if($image = $product->featured()->toFile()): ?>

  <div class="product" data-id="<?= $product->id() ?>">

    <?php if ($image->mp4()->isNotEmpty() || $image->filemp4()->isNotEmpty()): ?>

      <?php snippet('video-player', ['image' => $image]) ?>

    <?php else: ?>

      <div class="product-image" event-target="product-panel">
        <?php
        $ratio = 1/1;
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

    <div class="product-infos" data-scroll="y" data-scrollmobile="y">
      <div class="inner-scroll">
        <div class="product-title row uppercase"><?= $product->title()->html() ?></div>
        <div class="product-description"><?= $product->text()->kt() ?></div>
        <?php if ($product->shopifyID()->isNotEmpty()): ?>
            <div class="buy uppercase">
              <div id="product-component-<?= $product->shopifyID() ?>" class="row" data-shop="<?= $product->shopifyID() ?>"></div>
            </div>
          <?php endif ?>
          <?php if ($product->listen()->isNotEmpty()): ?>
        	<div class="product-links row uppercase">
                <?php foreach ($product->listen()->toStructure() as $key => $item): ?>
                  <a class="row" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
                <?php endforeach ?>
        	</div>
          <?php endif ?>
        <div class="row">
          <div class="left">
            <?php if ($product->tracklist()->isNotEmpty() && $product->tracklist()->toStructure()->table()->first()->first()->isNotEmpty()): ?>
            <div class="product-tracklist">
              <div class="row uppercase mb1">Tracklist</div>
              <table class="table">
                <tbody>
                  <?php foreach($product->tracklist()->toStructure()->table() as $tableRow): ?>
                      <tr class="table-row">
                        <?php foreach($tableRow as $tableCell): ?>
                          <td class="table-cell"><?= $tableCell ?></td>
                        <?php endforeach ?>
                      </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
            <?php endif ?>
            <?php if ($product->infos()->isNotEmpty() && $product->infos()->toStructure()->table()->first()->first()->isNotEmpty()): ?>
            <div class="product-moreinfos">
              <div class="row uppercase mb1">Infos</div>
              <table class="table">
                <tbody>
                  <?php foreach($product->infos()->toStructure()->table() as $tableRow): ?>
                      <tr class="table-row">
                        <?php foreach($tableRow as $tableCell): ?>
                          <td class="table-cell"><?= $tableCell ?></td>
                        <?php endforeach ?>
                      </tr>
                  <?php endforeach ?>
                </tbody>
              </table>
            </div>
            <?php endif ?>
          </div>
          <div class="right">
            
          </div>

          <?php if ($product->medias()->isNotEmpty()): ?>
          	<div class="product-medias row">
          		<?php foreach ($product->medias()->toStructure() as $key => $m): ?>
          			<?php snippet('responsive-image', ['field' => $m]) ?>
          		<?php endforeach ?>
          	</div>
          <?php endif ?>

          <?php if ($product->buy()->isNotEmpty() && $buy = $product->buy()->toStructure()->first()): ?>
            <div class="buy row">
              <div class="price"><?= $buy->price()->html() ?></div>
              <a href="<?= $buy->link() ?>" class="buy-button uppercase">Buy</a>
            </div>
          <?php endif ?>

        </div>
      </div>
    </div>

    <div class="panel-close" event-target="product-panel"><?= l::get('close') ?></div>
    <div class="panel-open" event-target="product-panel"><?= l::get('buy') ?></div>

  </div>

<?php endif ?>
