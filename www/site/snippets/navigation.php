<?php
$about = $site->aboutPage()->toPage();
?>

<div id="menu" class="visible">
	<ul id="primary-nav">
			<?php foreach($site->pages()->visible() as $item): ?>
				<?php if ($about && $item->is($about)): ?>
        <?php else: ?>
					<li>
            <?php if (!in_array($item->intendedTemplate(), ['artists'])): ?>
            <a<?php e($item->isOpen(), ' class="active"') ?> href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>
            <?php else: ?>
            <span<?php e($item->isOpen(), ' class="active"') ?>><?= $item->title()->html() ?></span>
            <?php endif ?>

						<?php
						$children = $item->children()->visible();
						if($children->count() > 0):
							?>

							<ul>
								<?php foreach($children as $child): ?>
									<li>
										<a
										<?php e($child->isOpen(), ' class="active"') ?>
										href="<?= $child->url() ?>"
										data-id="<?= $child->uid() ?>"
										data-page="<?= $child->intendedTemplate() ?>"
										>
										<?= $child->title()->html() ?>
										</a>
									</li>
								<?php endforeach ?>
							</ul>
						<?php endif ?>

					</li>
				<?php endif ?>
		<?php endforeach ?>
	</ul>

	<ul id="secondary-nav">
		<div id="languages">
			<?php foreach($site->languages()->flip() as $language): ?>
				<?php if (true || $site->language() != $language): ?>
					<a class="language no-barba" href="<?= $page->url($language->code()) ?>">
						<?= ucfirst(html($language->code())) ?>
					</a>
				<?php endif ?>
			<?php endforeach ?>
		</div>
		<?php if ($about): ?>
		<div event-target="about-panel"><?= $about->title()->html() ?></div>
		<?php endif ?>
	</ul>
</div>
