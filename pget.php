<?php

	$uid = $argv[1];
	$file = $argv[2];

//	$file = 'http://sdo.gsfc.nasa.gov/assets/img/latest/latest_1024_0304.jpg';

	$dir = dirname(__FILE__) . '/';

	$basename = $dir . $uid . '/' . 'img%s.jpg';
	$hash_filename = $dir . $uid . '.hash';
	$temp_filename = $dir . $uid . '.tmp';

//
	$hash = @file_get_contents($hash_filename);

	echo "Downloading $file ...";	
	file_put_contents($temp_filename, file_get_contents($file));
	echo "OK\n";

	$newhash = crc32(file_get_contents($temp_filename));

	if ($newhash != $hash) {
		$filename = sprintf($basename, date('_Ymd_His'));
		echo "Save result as $filename.\n";
		rename($temp_filename, $filename);
		$hash = $newhash;
	}
	else {
		@unlink($temp_filename);
	}
	file_put_contents($hash_filename, $hash);
	
?>