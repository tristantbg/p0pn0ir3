<div id="menu" class="visible">
	<nav id="primary-nav">
			<?php foreach ($site->pages()->visible() as $key => $item): ?>
				<a<?php e($item->isOpen(), ' class="active"') ?> href="<?php e($item->isOpen(), $site->url(), $item->url()) ?>"><?= $item->title()->html() ?></a>
			<?php endforeach ?>
	</nav>
</div>
