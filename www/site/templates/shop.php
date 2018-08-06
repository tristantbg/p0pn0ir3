<?php snippet('header') ?>

<div id="shop" data-scroll="x" data-scrollmobile="x">
  <div class="inner-scroll">
    <?php foreach ($products as $key => $product): ?>
      <?php snippet('shop.product', ['product' => $product]) ?>
    <?php endforeach ?>
  </div>
</div>

<?php snippet('footer') ?>
