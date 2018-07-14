<div id="menu" class="visible">
	<nav id="primary-nav">
		<?php if($ptemplate == 'projects' && param('type')): ?>
			<?php foreach ($site->pages()->visible() as $key => $item): ?>
				<a<?php e($item->isOpen(), ' class="active"') ?> href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
			<?php endforeach ?>
			<a class="active" href="<?= $page->url() ?>"><?= page('categories/'.param('type'))->title()->html() ?></a>
		<?php elseif($ptemplate == 'project'): ?>
			<?php foreach ($site->pages()->visible() as $key => $item): ?>
				<a<?php e($item->is($page->parent()), ' class="active"') ?> href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
			<?php endforeach ?>
			<a class="active" href="<?= $page->parent()->url() ?>"><?= page($page->category()->value())->title()->html() ?></a>
			<a class="active" href="<?= $page->parent()->url().'/type:'.$page->category()->toPage()->uid() ?>"><?= $page->title()->html() ?></a>
		<?php else: ?>
			<?php foreach ($site->pages()->visible() as $key => $item): ?>
				<a<?php e($item->isOpen(), ' class="active"') ?> href="<?php e($item->isOpen(), $site->url(), $item->url()) ?>"><?= $item->title()->html() ?></a>
			<?php endforeach ?>
		<?php endif ?>
	</nav>
	<nav id="secondary-nav">
		<?php if ($ptemplate == 'contact'): ?>
			<?= $page->text()->kt() ?>
		<?php elseif($ptemplate == 'projects'): ?>
			<?php if (param('type')): ?>
				<!-- <?php foreach ($projects as $key => $item): ?>
					<a href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
				<?php endforeach ?> -->
			<?php else: ?>
				<?php foreach (page('categories')->children()->visible() as $key => $item): ?>
					<a href="<?= $page->url().'/type:'.$item->uid() ?>"><?= $item->title()->html() ?></a>
				<?php endforeach ?>
			<?php endif ?>
		<?php elseif($ptemplate == 'project'): ?>
      <?php if ($page->hasPrevVisible() && $prev = $page->prevVisible()): ?>
        <a href="<?= $prev->url() ?>">
          <svg><use xlink:href="<?= url('assets/images/svg-sprite.svg') ?>#arrow-left" /></svg>
        </a>
      <?php else: ?>
        <a href="<?= $projects->last()->url() ?>">
          <svg><use xlink:href="<?= url('assets/images/svg-sprite.svg') ?>#arrow-left" /></svg>
        </a>
      <?php endif ?>
      <?php if ($page->hasNextVisible() && $next = $page->nextVisible()): ?>
        <a href="<?= $next->url() ?>">
          <svg><use xlink:href="<?= url('assets/images/svg-sprite.svg') ?>#arrow-right" /></svg>
        </a>
      <?php else: ?>
        <a href="<?= $projects->first()->url() ?>">
          <svg><use xlink:href="<?= url('assets/images/svg-sprite.svg') ?>#arrow-right" /></svg>
        </a>
      <?php endif ?>
		<?php endif ?>

		<?php foreach($site->languages() as $language): ?>
			<?php if ($site->language() != $language): ?>
				<a class="language" href="<?= $page->url($language->code()) ?>">
					<?= ucfirst(html($language->code())) ?>
				</a>
			<?php endif ?>
		<?php endforeach ?>
	</nav>
</div>
