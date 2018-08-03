<?php snippet('header') ?>

<div id="press-header" class="uppercase">
  <a href="<?= page('press')->url() ?>">Private Press Area</a>
  <a href="<?= $site->url() ?>"><?= $site->title()->html() ?></a>
  <a href="<?= $site->url() ?>"><?= l::get('back') ?></a>
</div>

<div id="press-tree" class="uppercase">
  <div class="breadcrumb">
    <?php foreach($site->breadcrumb() as $crumb): ?>
    <?php if ($crumb->url() != $site->url()): ?>
      <a href="<?= $crumb->url() ?>"><?= html($crumb->title()) ?></a>
    <?php endif ?>
    <?php endforeach ?>
  </div>
  <br>
  <?php if ($page->hasParent() && $page->parent()->url() != $site->url()): ?>
    <!-- <a href="<?= $page->parent()->url() ?>"><?= l::get('back') ?></a> -->
  <?php endif ?>
  <?php if ($page->hasChildren()): ?>
  <br>
  <?php endif ?>
  <div id="tree"><?php snippet('treemenu') ?></div>
</div>


<div id="page-files">
<?php if ($page->hasFiles()): ?>
  <div class="uppercase"><?= l::get('files') ?></div>
  <br>
  <?php foreach ($page->files() as $key => $f): ?>
    <a class="row" href="<?= $f->url() ?>"<?php e($f->type() != 'document', ' download') ?>><?= $f->filename() ?></a>
  <?php endforeach ?>
  <div>—</div>
  <?php snippet('zipdl_form_btn', ['page' => $page]) ?>
<?php elseif($page->uid() != 'press'): ?>
  <div class="uppercase"><?= l::get('files.empty') ?></div>
<?php endif ?>
</div>



<?php snippet('footer') ?>
