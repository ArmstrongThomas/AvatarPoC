<?php
// Validate and get the color from the URL parameter, or default to red if invalid
if (isset($_GET['skinColor']) && preg_match('/^[a-f0-9]{6}$/i', $_GET['skinColor'])) {
    $skinColor = '#' . $_GET['skinColor'];
} else {
    $skinColor = '#aa724b';  // Default to red
}

// Load the original image
$baseImage = imagecreatefrompng('baseBig.png');  // Replace with your image file

// Get the dimensions of the image
$width = imagesx($baseImage);
$height = imagesy($baseImage);

// Create a blank canvas for the overlay
$baseOverlay = imagecreatetruecolor($width, $height);

// Preserve transparency in the overlay image
imagealphablending($baseOverlay, false);
imagesavealpha($baseOverlay, true);

// Convert hex color to RGB components
list($r, $g, $b) = sscanf($skinColor, "#%02x%02x%02x");

// Iterate through each pixel of the original image
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $originalPixel = imagecolorat($baseImage, $x, $y);
        $alpha = ($originalPixel >> 24) & 0xFF;

        $originalR = ($originalPixel >> 16) & 0xFF;
        $originalG = ($originalPixel >> 8) & 0xFF;
        $originalB = $originalPixel & 0xFF;

        // Calculate blended RGB values using multiply blend mode
        $newR = (int)($r * $originalR / 255);
        $newG = (int)($g * $originalG / 255);
        $newB = (int)($b * $originalB / 255);

        // Create the new pixel with blended RGB values
        $newPixel = imagecolorallocatealpha($baseOverlay, $newR, $newG, $newB, $alpha);

        // Set the pixel on the overlay canvas
        imagesetpixel($baseOverlay, $x, $y, $newPixel);
    }
}

// Output the overlay image
header('Content-Type: image/png');
imagepng($baseOverlay);

// Clean up memory
imagedestroy($baseImage);
imagedestroy($baseOverlay);
