<header>
	<?php if ($page->isHomepage()): ?>
		<h1><?= $site->title()->html() ?></h1>
	<?php else: ?>
		<h1><?= $page->title()->html() ?></h1>
	<?php endif ?>

	<a id="fluid-title" href="<?= $site->url()  ?>">
		<div class="letters">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 199 1000"><path d="M92.4 118.2h106.1V0H92.4v118.2zm-35 881.8c39.4 0 73.3-6.6 99.6-26.3 24.1-19.7 39.4-52.5 39.4-109.4V226.5H94.6v632.4c0 41.6-19.7 56.9-59.1 58-9.8 0-20.8-1.1-31.7-3.3H.5v81c15.3 2.1 35 5.4 56.9 5.4"/></svg>
		</div>
		<div class="letters">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 506 1000"><path d="M386.5 844h119.3L255.2 467.7l224.3-211.2H352.6l-255 250.6c2.2-28.4 4.4-70 4.4-90.8V30H.3v814H102V613.2l83.2-78.8L386.5 844z"/></svg>
		</div>
		<div class="letters">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 668 1000"><path d="M280.4 257.3H179.7v587.5h101.8V487.1c0-94.1 65.6-158.6 156.5-158.6 79.9 0 129.1 42.7 129.1 118.2v398.2h100.7V434.5c0-122.5-75.5-191.5-198-191.5-85.3 0-143.3 38.3-186 97.4h-3.3v-83.1zM.3 844.8h101.8v-814H.3v814z"/></svg>
		</div>
	</a>

	<?php snippet('navigation') ?>
</header>
