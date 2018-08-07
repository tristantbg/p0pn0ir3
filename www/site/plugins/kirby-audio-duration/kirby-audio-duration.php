<?php


require_once __DIR__ . '/vendor/autoload.php';

// file::$methods['duration'] = function($file) {
// 	if ($file->extension() === 'mp3') {

// 		$getID3 = new getID3();
// 		$info   = $getID3->analyze($file->root());

// 		return $info['playtime_string'];
// 	}
// };

kirby()->hook('panel.file.upload', function($file) {
	if ($file->extension() === 'mp3') {

		$getID3 = new getID3();
		$info   = $getID3->analyze($file->root());
		$play_time = $info['playtime_string'];

		list($mins , $secs) = explode(':' , $play_time);

		$audioData = [
            'duration' => $play_time,
            'durationMinutes' => str_pad($mins, 2, '0', STR_PAD_LEFT),
            'durationSeconds' => str_pad($secs, 2, '0', STR_PAD_LEFT)
        ];

        $file->update($audioData);

	}
});