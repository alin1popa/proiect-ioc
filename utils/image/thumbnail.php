<?php

/* 	$size is the size of the thumbnail in pixels
*	$name is the name of the file, as the thumbnail will be saved
*	$image_filename is the filename with path to the image
*	$thumbnail_folder is the folder in which the thumbnails will be saved
*
*	EXAMPLE OF USE
*	foreach (file in folder)
*	{
*		if (thumbnail already exists) //do nothing
*		else createThumbnail(parameters);
*	}
*
*
*/


	function createThumbnail($size, $name, $image_filename, $thumbnail_folder)
	{
		list($originalWidth, $originalHeight) = getimagesize($image_filename);
		$ratio = $originalWidth / $originalHeight;
		
		$targetWidth = $targetHeight = min($size, max($originalWidth, $originalHeight));

		if ($ratio < 1) {
			$targetWidth = $targetHeight * $ratio;
		} else {
			$targetHeight = $targetWidth / $ratio;
		}

		$srcWidth = $originalWidth;
		$srcHeight = $originalHeight;
		$srcX = $srcY = 0;
		
		$targetWidth = $targetHeight = min($originalWidth, $originalHeight, $size);

		if ($ratio < 1) {
			$srcX = 0;
			$srcY = ($originalHeight / 2) - ($originalWidth / 2);
			$srcWidth = $srcHeight = $originalWidth;
		} else {
			$srcY = 0;
			$srcX = ($originalWidth / 2) - ($originalHeight / 2);
			$srcWidth = $srcHeight = $originalHeight;
		}
		
		$targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
		$originalImage = imagecreatefromjpeg($image_filename);
		imagecopyresampled($targetImage, $originalImage, 0, 0, $srcX, $srcY, $targetWidth, $targetHeight, $srcWidth, $srcHeight);
		
		imagejpeg($targetImage, $thumbnail_folder.$name);
	}
?>