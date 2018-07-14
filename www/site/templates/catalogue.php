<?php snippet('header') ?>

<div id="catalogue">
	<div class="inner">
		<?php snippet('catalogue', array('withImages' => true, 'releases' => $releases)) ?>
	</div>
</div>

<?php snippet('footer') ?>