<?php
function convertImage($source, $width, $height, $ext) {

	$imageSize = getimagesize($source);
	$ext=strtolower($ext);
	switch($ext) {
		case 'png':
		$imageRessource = imagecreatefrompng($source);
			break;
		case 'jpg':
		$imageRessource = imagecreatefromjpeg($source);
			break;
		case 'jpeg':
		$imageRessource = imagecreatefromjpeg($source);
			break;
	}
	$imageFinal = imagecreatetruecolor($width, $height);
	$final = imagecopyresampled($imageFinal, $imageRessource, 0, 0, 0, 0, $width, $height, $imageSize[0], $imageSize[1]);

	switch($ext) {
		case 'png':
		imagepng($imageFinal, $source);
			break;
		case 'jpg':
		imagejpeg($imageFinal, $source);
			break;
		case 'jpeg':
		imagejpeg($imageFinal, $source);
			break;
	}
}

function upload_image($file_ext,$file_destination,$file_error,$file_size,$file_tmp) {

	$allowed = array("png","jpg","jpeg");

	if(in_array($file_ext, $allowed)){
		if($file_error === 0){
			if($file_size <= 2097152){
				if(move_uploaded_file($file_tmp, $file_destination)){
					convertImage($file_destination, '200', '200', $file_ext);
				}
			}
		}
	}
}
 ?>
