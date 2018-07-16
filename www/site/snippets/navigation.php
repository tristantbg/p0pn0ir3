<div id="menu" class="visible">
	<ul id="primary-nav">
			<?php foreach($site->pages()->visible() as $item): ?>
			<li>
				<a<?php e($item->isOpen(), ' class="active"') ?> href="<?= $item->url() ?>"><?= $item->title()->html() ?></a>

				<?php
				$children = $item->children()->visible();
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
</div>
