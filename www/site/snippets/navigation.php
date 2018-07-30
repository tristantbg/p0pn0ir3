<?php
$about = $site->aboutPage()->toPage();
?>

<div id="menu" class="visible">
	<ul id="primary-nav">
			<?php foreach($site->pages()->visible() as $item): ?>
				<?php if ($about && $item->is($about)): ?>
        <?php else: ?>
					<li>
						<a<?php e($item->isOpen(), ' class="active"') ?> href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>

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
					<a class="language" href="<?= $page->url($language->code()) ?>">
						<?= ucfirst(html($language->code())) ?>
					</a>
				<?php endif ?>
			<?php endforeach ?>
		</div>
		<?php if ($about): ?>
		<a href="<?= $about->url() ?>" data-target="about"><?= $about->title()->html() ?></a>
		<?php endif ?>
	</ul>
</div>
