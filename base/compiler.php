<?php

header('Content-Type: image/png');
function applyColor($image, $color): void
{
    imagealphablending($image, false);
    imagesavealpha($image, true);
    $width = imagesx($image);
    $height = imagesy($image);
    list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            $originalPixel = imagecolorat($image, $x, $y);
            $alpha = ($originalPixel >> 24) & 0xFF;

            if ($alpha == 127) {
                continue;
            }

            $originalR = ($originalPixel >> 16) & 0xFF;
            $originalG = ($originalPixel >> 8) & 0xFF;
            $originalB = $originalPixel & 0xFF;

            // Skip white pixels
            if ($originalR == 255 && $originalG == 255 && $originalB == 255) {
                continue;
            }

            $newR = (int)($r * $originalR / 255);
            $newG = (int)($g * $originalG / 255);
            $newB = (int)($b * $originalB / 255);
            $newPixel = imagecolorallocatealpha($image, $newR, $newG, $newB, $alpha);
            imagesetpixel($image, $x, $y, $newPixel);
        }
    }
}

// Load the base image and apply skin color
$baseImage = imagecreatefrompng('baseBig.png');
applyColor($baseImage, isset($_GET['skinColor']) ? '#' . $_GET['skinColor'] : '#aa724b');
// Load the eyes image and apply eye color
$eyesImage = imagecreatefrompng('eyes.png');
applyColor($eyesImage, isset($_GET['eyeColor']) ? '#' . $_GET['eyeColor'] : '#4CAF50');
if (isset($_GET['hairVariant']) && isset($_GET['hairColor'])) {
    $hairVariant = intval($_GET['hairVariant']);
    $hairColor = '#' . $_GET['hairColor'];
    $hairImage = imagecreatefrompng("../hairstyles/hair_$hairVariant.png");
    applyColor($hairImage, $hairColor);
    // Merge hair into the base image
    imagealphablending($baseImage, true);
    imagecopy($baseImage, $hairImage, 0, 0, 0, 0, imagesx($hairImage), imagesy($hairImage));
    imagedestroy($hairImage);
}

// Load undergarments
if (isset($_GET['underGarmentVariant'])) {
    $underGarmentVariant = intval($_GET['underGarmentVariant']);
    $underGarment = imagecreatefrompng("../items/underGarment_$underGarmentVariant.png");
    // Merge the undergarments into the base image
    imagealphablending($baseImage, true);
    imagecopy($baseImage, $underGarment, 0, 0, 0, 0, imagesx($underGarment), imagesy($underGarment));
    imagedestroy($underGarment);
}

// Merge eyes into the base image last to make sure eyes are visible on top of hair, like in anime.
imagealphablending($baseImage, true);
imagecopy($baseImage, $eyesImage, 0, 0, 0, 0, imagesx($eyesImage), imagesy($eyesImage));

// Output and free memory
imagepng($baseImage);
imagedestroy($baseImage);
imagedestroy($eyesImage);