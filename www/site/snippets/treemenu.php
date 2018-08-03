<?php if(!isset($subpages)) $subpages = $page->children() ?>
<ul>
  <?php foreach($subpages->visible() AS $p): ?>
  <li class="depth-<?= $p->depth() ?>">
    <a<?php e($p->isActive(), ' class="active"') ?> href="<?= $p->url() ?>"><?= $p->title()->html() ?></a>
    <?php if($p->hasChildren()): ?>
    <?php snippet('treemenu', array('subpages' => $p->children())) ?>
    <?php endif ?>
  </li>
  <?php endforeach ?>
</ul>
