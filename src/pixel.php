<?php

namespace Pixel;

class Pixel
{
    /**
     * Resize an image and save the result to a new file.
     *
     * @param string $imagePath           URL or file path to the original image.
     * @param string $resizedImagePath    Path to save the resized image.
     * @param int    $newWidth            Desired width for the resized image.
     * @param int    $newHeight           Desired height for the resized image.
     * @param bool   $createPathIfNotExists Whether to create the directory if it doesn't exist (default is false).
     *
     * @return bool Returns true on successful resizing.
     * @throws \ErrorException If an error occurs during the resizing process.
     */
    public static function resizeImage(string $imagePath, string $resizedImagePath, int $newWidth, int $newHeight, bool $createPathIfNotExists = false): bool
    {
        // Validate image dimensions
        if ($newWidth <= 0 || $newHeight <= 0) {
            throw new \ErrorException('Image dimensions must be greater than zero.');
        }

        try {
            // Load the original image
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $originalImage = imagecreatefromstring(file_get_contents($imagePath));
            } else {
                if (!file_exists($imagePath)) {
                    throw new \ErrorException('Original image file not found.');
                }

                $originalImage = imagecreatefromjpeg($imagePath);
            }

            // Check and create the resized image directory if needed
            $resizedDirectory = dirname($resizedImagePath);
            if (!is_dir($resizedDirectory) && $createPathIfNotExists) {
                mkdir($resizedDirectory, 0777, true);
            }

            // Create the resized image
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($resizedImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($originalImage), imagesy($originalImage));
            imagejpeg($resizedImage, $resizedImagePath, 100);

            // Free up memory by destroying the image resources
            imagedestroy($originalImage);
            imagedestroy($resizedImage);
        } catch (\ErrorException $error) {
            throw $error;
        }

        return true;
    }
}