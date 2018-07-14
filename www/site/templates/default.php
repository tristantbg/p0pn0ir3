<?php snippet('header') ?>

<?php if ($page->text()->isNotEmpty()): ?>
	<div id="page-text">
		<?= $page->text()->kt() ?>
	</div>
<?php endif ?>
<div id="page-infos">
	<div class="page-left">
		<?php foreach ($page->sectionsLeft()->toStructure() as $key => $subsection): ?>
			<div class="subsection">
				<div class="subsection-title column"><?= $subsection->title()->html() ?></div>
				<div class="subsection-text"><?= $subsection->text()->kt() ?></div>
			</div>
		<?php endforeach ?>
	</div>
	<div class="page-right">
		<?php foreach ($page->sectionsRight()->toStructure() as $key => $subsection): ?>
			<div class="subsection">
				<div class="subsection-title column"><?= $subsection->title()->html() ?></div>
				<div class="subsection-text"><?= $subsection->text()->kt() ?></div>
			</div>
		<?php endforeach ?>
	</div>
</div>

<?php snippet('footer') ?>