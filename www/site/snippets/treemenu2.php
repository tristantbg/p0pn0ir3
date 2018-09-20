<?php

// nested menu
$items = page('press')->children()->visible();

// only show the menu if items are available
if($items->count()):

?>
<nav>
  <ul>
    <?php foreach($items as $item): ?>
    <li>
      <a<?php e($item->isOpen(), ' class="active"') ?> href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>

      <?php

      // get all children for the current menu item
      $children = $item->children()->visible();

      // display the submenu if children are available
      if($children->count() > 0):

      ?>
      <ul>
        <?php foreach($children as $child): ?>
        <li><a<?php e($child->isOpen(), ' class="active"') ?> href="<?= $child->url() ?>"><?= $child->title()->html() ?></a></li>
        <?php endforeach ?>
      </ul>
      <?php endif ?>

    </li>
    <?php endforeach ?>
  </ul>
</nav>
<?php endif ?>