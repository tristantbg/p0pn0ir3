<?php if(!isset($subpages)) $subpages = page('press')->children() ?>
<ul>
  <?php foreach($subpages->visible() AS $p): ?>
  <li class="depth-<?= $p->depth() ?>">
    <a class="link-hover white<?php e($p->isActive(), ' active') ?>" href="<?= $p->url() ?>"><?= $p->title()->html() ?></a>
    <?php if($p->hasChildren()): ?>
    <?php snippet('treemenu', array('subpages' => $p->children())) ?>
    <?php endif ?>
  </li>
  <?php endforeach ?>
</ul>
