<header>
	<?php if ($page->isHomepage()): ?>
		<h1><?= $site->title()->html() ?></h1>
	<?php else: ?>
		<h1><?= $page->title()->html() ?></h1>
	<?php endif ?>

	<?php snippet('navigation') ?>
</header>
