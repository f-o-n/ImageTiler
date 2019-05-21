<?php namespace ProcessWire;

// https://gist.github.com/jamestomasino/5360150
function tileImage($sourceImagePath, $destinationDir, $format = 'jpg', $quality = 80, $tileSize = 256, $fillColor = '#FFFFFF') {
	$format = strtolower($format);
	$sourceExt = pathinfo($sourceImagePath, PATHINFO_EXTENSION);
	
	if($sourceExt == 'jpg' || $sourceExt = 'jpeg') {
		$im = imagecreatefromjpeg($sourceImagePath); 
	} else if ($sourceExt == 'png') {
		$im = imagecreatefrompng($sourceImagePath);
	}

	$sizeArray = getimagesize($sourceImagePath);

	//Set the Image dimensions
	$imageWidth = $sizeArray[0];
	$imageHeight = $sizeArray[1];

	//See how many zoom levels are required for the width and height
	$widthLog = ceil(log($imageWidth / $tileSize, 2));
	$heightLog = ceil(log($imageHeight / $tileSize, 2));
	
	//Find the maximum zoom by taking the higher of the width and height zoom levels
	$maxZoom = $heightLog > $widthLog ? $heightLog : $widthLog;
	
	$fill = hexToRgb($fillColor);
	
	//Go through each zoom level
	for ($z = 0 ; $z < $maxZoom ; $z++ ) {
		$currSize = $tileSize * pow(2,$z);
		for ($y = 0 ; $y * $currSize < $imageHeight ; $y++) {
			//if the current square on the original doesn't have the required height, we need to find the correct ratio to use or the image could be skewed
			if (($imageHeight - $y*$currSize) < $currSize) {
				$heightRatio = ($imageHeight-$y*$currSize)/$currSize;
			} else {
				$heightRatio = 1;
			}
			
			//if the current square on the original doesn't have the required width, we need to find the correct ratio to use or the image could be skewed
			for($x = 0 ; $x * $currSize < $imageWidth ; $x++)
			{
				if (($imageWidth - $x * $currSize) < $currSize) {
					$widthRatio = ($imageWidth - $x * $currSize) / $currSize;
				} else {
					$widthRatio = 1;
				}
				
				//create an image to put this tile in and fill it if it's to small
				$dest = imagecreatetruecolor($tileSize, $tileSize);
				if($format == 'png') {
					imagesavealpha($dest, true);
					imagealphablending($dest, false);
					$colorAllocated = imagecolorallocatealpha($dest, 0, 0, 0, 127);
				} else {
					$colorAllocated = imagecolorallocate( $dest, $fill[0], $fill[1], $fill[2] );
				}
				imagefilledrectangle($dest, 0, 0, $tileSize-1, $tileSize-1, $colorAllocated);

				//take the correct chunk from the original, and rescale it to fit in the tile
				$ret = imagecopyresized($dest, $im, 0, 0, 
					$x * $currSize, $y * $currSize, 
					$tileSize * $widthRatio, $tileSize * $heightRatio, 
					$currSize * $widthRatio, $currSize * $heightRatio);

				//save this image as a jpg, named according to its location and zoom

				$folder = $destinationDir . '/' . ($maxZoom - $z) . '/' . $x . '/';
				createDir($folder);

				if($format == 'png') {
					imagepng($dest, $folder . $y . '.png', $quality); //0-9
				} else {
					imagejpeg($dest, $folder . $y . '.jpg', $quality); //100-0
				}
				
				imagedestroy($dest);
			}
		}
	}
}

function hexToRgb($color) {
	
	if ($color[0] == '#')
		$color = substr($color, 1);

    if (strlen($color) == 6) {
		list($r, $g, $b) = array($color[0].$color[1],
                                 $color[2].$color[3],
                                 $color[4].$color[5]);
	} elseif (strlen($color) == 3) {
		list($r, $g, $b) = array($color[0].$color[0], 
								 $color[1].$color[1], 
								 $color[2].$color[2]);
	} else {
		list($r, $g, $b) = array ('FF', 'FF', 'FF');
	}

    return array(hexdec($r), hexdec($g), hexdec($b));
}

function createDir($dir) {
	if (!is_dir($dir)) {
		return mkdir($dir, 0755, true);
	}
	return true;
}

//https://www.php.net/manual/en/function.rmdir.php#117354
function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
              unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}
