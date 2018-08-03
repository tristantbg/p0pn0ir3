<?php if ($aboutPage = $site->aboutPage()->toPage()): ?>

<div id="about-logo">
  <svg><use xlink:href="<?= url('assets/images/svg-sprite.svg') ?>#logo" /></svg>
</div>

<div id="about-text"><?= $aboutPage->text()->kt() ?></div>

<div id="about-socials">
  <?php if ($aboutPage->socials()->isNotEmpty()): ?>
    <?php foreach ($aboutPage->socials()->toStructure() as $key => $item): ?>
      <a class="row uppercase" href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
    <?php endforeach ?>
  <?php endif ?>
</div>

<?php snippet('newsletter') ?>

<div id="credits">© <?= date('Y').' '.$site->title()->html() ?> — All rights reserved</div>

<?php endif ?>
