<?php snippet('header') ?>

<div id="shop" data-scroll="x">
  <div class="inner-scroll">
    <?php foreach ($products as $key => $product): ?>
      <?php snippet('shop.product', ['product' => $product, 'noMobileScroll' => count($products) == 1]) ?>
    <?php endforeach ?>
  </div>
</div>

<?php snippet('footer') ?>
