<?php snippet('header') ?>

<div id="press-header" class="uppercase">
  <a href="<?= page('press')->url() ?>">Private Press Area</a>
  <a href="<?= $site->url() ?>"><?= $site->title()->html() ?></a>
  <a href="<?= $site->url() ?>"><?= l::get('back') ?></a>
</div>

<?php snippet('tree1') ?>

<div id="page-files">
  <!-- <div class="breadcrumb uppercase">
    <?php foreach($site->breadcrumb() as $crumb): ?>
    <?php if ($crumb->url() != $site->url()): ?>
      <a href="<?= $crumb->url() ?>"><?= html($crumb->title()) ?></a>
    <?php endif ?>
    <?php endforeach ?>
  </div>
  <br>
  <br> -->
<?php if ($page->hasFiles()): ?>
  <!-- <div class="uppercase"><?= l::get('files') ?></div>
  <br> -->
  <?php snippet('zipdl_form_btn', ['page' => $page]) ?>
  <br>
  <?php foreach ($page->files() as $key => $f): ?>
  	<?php if ($f->type() == 'image'): ?>
    <a class="row mb1 link-hover white" href="<?= $f->url() ?>" download><?= $f->width(200) ?><br><?= $f->filename() ?></a>
  	<?php else: ?>
    <a class="row mb1 link-hover white" href="<?= $f->url() ?>"<?php e($f->type() != 'document', ' download') ?>><?= $f->filename() ?></a>
  	<?php endif ?>
  <?php endforeach ?>
<?php elseif($page->uid() != 'press'): ?>
  <div class="uppercase"><?= l::get('files.empty') ?></div>
<?php endif ?>
</div>



<?php snippet('footer') ?>
