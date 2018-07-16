<?php snippet('header') ?>

<div id="artist-medias">
	<?php foreach ($medias as $key => $item): ?>
		<?php snippet('artist-image', ['field' => $item]) ?>
	<?php endforeach ?>
</div>

<?php snippet('footer') ?>