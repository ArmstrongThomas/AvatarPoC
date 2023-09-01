<?php
// Validate and get the color from the URL parameter, or default to red if invalid
if (isset($_GET['eyeColor']) && preg_match('/^[a-f0-9]{6}$/i', $_GET['eyeColor'])) {
    $hexColor = '#' . $_GET['color'];
} else {
    $hexColor = '#357A38';  // Default to red
}

// Load the original image
$eyesImage = imagecreatefrompng('eyes.png');  // Replace with your image file

// Get the dimensions of the image
$width = imagesx($eyesImage);
$height = imagesy($eyesImage);

// Create a blank canvas for the overlay
$eyesOverlay = imagecreatetruecolor($width, $height);

// Preserve transparency in the overlay image
imagealphablending($eyesOverlay, false);
imagesavealpha($eyesOverlay, true);

// Convert hex color to RGB components
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");

// Iterate through each pixel of the original image
for ($x = 0; $x < $width; $x++) {
    for ($y = 0; $y < $height; $y++) {
        $originalPixel = imagecolorat($eyesImage, $x, $y);
        $alpha = ($originalPixel >> 24) & 0xFF;

        $originalR = ($originalPixel >> 16) & 0xFF;
        $originalG = ($originalPixel >> 8) & 0xFF;
        $originalB = $originalPixel & 0xFF;

        // Calculate blended RGB values using multiply blend mode
        $newR = (int)($r * $originalR / 255);
        $newG = (int)($g * $originalG / 255);
        $newB = (int)($b * $originalB / 255);

        // Create the new pixel with blended RGB values
        $newPixel = imagecolorallocatealpha($eyesOverlay, $newR, $newG, $newB, $alpha);

        // Set the pixel on the overlay canvas
        imagesetpixel($eyesOverlay, $x, $y, $newPixel);
    }
}

// Output the overlay image
header('Content-Type: image/png');
imagepng($eyesOverlay);

// Clean up memory
imagedestroy($eyesImage);
imagedestroy($eyesOverlay);
