</div>

</div>


</div>

</div>

<div id="about-panel">
  <div class="about-close uppercase" event-target="about-panel"><?= l::get('close') ?></div>
  <div data-scroll="y">
    <div class="inner-scroll"><?php snippet('about') ?></div>
  </div>
</div>

<div id="artists-preview">
	<?php foreach ($artists as $key => $artist): ?>
		<?php if ($artist->hero()->isNotEmpty()): ?>
			<div class="artist-preview" data-id="<?= $artist->uid() ?>"><?php snippet('responsive-image', ['field' => $artist->hero(), 'preload' => true]) ?></div>
		<?php elseif ($artist->featured()->isNotEmpty()): ?>
			<div class="artist-preview" data-id="<?= $artist->uid() ?>"><?php snippet('responsive-image', ['field' => $artist->featured(), 'preload' => true]) ?></div>
		<?php endif ?>
	<?php endforeach ?>
</div>

<div id="outdated">
  <div class="inner">
  <p class="browserupgrade">You are using an <strong>outdated</strong> browser.
  <br>Please <a href="http://outdatedbrowser.com" target="_blank">upgrade your browser</a> to improve your experience.</p>
  </div>
</div>


<?php if($site->googleanalytics()->isNotEmpty()): ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-115150448-2"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', '<?= $site->googleanalytics() ?>');
	</script>
<?php endif ?>

<?= js('assets/js/build/app.min.js'); ?>

</body>
</html>
