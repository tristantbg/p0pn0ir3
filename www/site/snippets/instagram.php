<?php if (c::get('plugin.instagram-api.access-token')): ?>
	<?php
	$result = $page->instagramapi(c::get('plugin.instagram-api.access-token'), 'users/self/media/recent');
	if(gettype($result) == 'array' && a::get($result, 'data')) {

			$username = $result['data'][0]['user']['username'];
			$t = brick('a', $username)
				->addClass('insta-username bold')
				->attr('target', '_blank')
				->attr('rel', 'noopener')
				->attr('href', 'https://www.instagram.com/'.$username);

			echo $t;

			foreach($result['data'] as $data) {
				// https://getkirby.com/docs/toolkit/api/helpers/brick

				// $imgurl = $data['images']['low_resolution']['url'];
				$imgurl = $data['images']['standard_resolution']['url'];

				// if you want to cache the image you could
				// use this helper or write your own based on it
				
				if($imgMedia = site()->instagramapiCacheImageToThumbs($imgurl)) {
					$imgurl = $imgMedia->url();
				}
				
				$img = brick('img')
					->attr('data-src', $imgurl)
					->addClass('lazy lazyload lazypreload')
					->attr('width', '100%');

				if($data['caption']) $img->attr('alt', $data['caption']['text']);

				$a = brick('a', $img)
					->addClass('insta-post')
					->attr('target', '_blank')
					->attr('rel', 'noopener')
					->attr('href', $data['link']);

				$likesAndComments = ' (';
				$likesAndComments .= $data['likes']['count'].' like';
				if($data['likes']['count'] > 1) $likesAndComments .= 's ';
				$likesAndComments .= $data['comments']['count'].' comment';
				if($data['comments']['count'] > 1) $likesAndComments .= 's';
				$likesAndComments .= ')';

				$txt = brick('p', html($data['caption']['text'].$likesAndComments));

				$a->append($txt);

				echo $a;
			}

			$t = brick('a', 'Voir la suite…')
				->addClass('bold')
				->attr('target', '_blank')
				->attr('rel', 'noopener')
				->attr('href', 'https://www.instagram.com/'.$username);

			echo $t;
		} else {
			// show error message this plugin provides
			echo brick('code', $result);
		}
	?>
<?php endif ?>