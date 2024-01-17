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

    /**
     * Change the quality of a JPEG or PNG image and save the result to a new file.
     *
     * @param string $imagePath        Path to the original image.
     * @param string $newImagePath     Path to save the new image.
     * @param int    $quality          Image quality (0-100) for JPEG format, compression level (0-9) for PNG format.
     * @param bool   $createPathIfNotExists Whether to create the directory if it doesn't exist (default is false).
     *
     * @return bool Returns true on successful quality change.
     * @throws \ErrorException If an error occurs during the process.
     */
    public static function changeQuality(string $imagePath, string $newImagePath, int $quality, bool $createPathIfNotExists = false): bool
    {
        // Validate quality level
        if (($quality < 0 || $quality > 100) || (pathinfo($imagePath, PATHINFO_EXTENSION) == 'png' && ($quality < 0 || $quality > 9))) {
            throw new \ErrorException('Invalid quality level. The quality parameter should be between 0 and 100 for JPEG, and between 0 and 9 for PNG.');
        }

        try {
            // Check image path type
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $originalImage = imagecreatefromstring(file_get_contents($imagePath));
            } else {
                if (!file_exists($imagePath)) {
                    throw new \ErrorException('Original image file not found.');
                }

                $imageExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                switch ($imageExtension) {
                    case 'jpg':
                    case 'jpeg':
                        $originalImage = imagecreatefromjpeg($imagePath);
                        break;
                    case 'png':
                        $originalImage = imagecreatefrompng($imagePath);
                        break;
                    default:
                        throw new \ErrorException('Unsupported image format.');
                }
            }

            if (!$originalImage) {
                throw new \ErrorException('Failed to create image from the original file or URL.');
            }

            // Check and create the new image directory if needed
            $newImageDirectory = dirname($newImagePath);
            if (!is_dir($newImageDirectory) && $createPathIfNotExists) {
                mkdir($newImageDirectory, 0777, true);
            }

            // Save the new image based on its type
            switch (strtolower(pathinfo($newImagePath, PATHINFO_EXTENSION))) {
                case 'jpg':
                case 'jpeg':
                    imagejpeg($originalImage, $newImagePath, $quality);
                    break;
                case 'png':
                    imagepng($originalImage, $newImagePath, $quality);
                    break;
                default:
                    throw new \ErrorException('Unsupported image format for saving the new image.');
            }

            // Free up memory by destroying the image resources
            imagedestroy($originalImage);
        } catch (\ErrorException $error) {
            throw $error;
        }

        return true;
    }

    /**
     * Compress and lower the file size of a JPEG or PNG image without lowering the quality and save the result to a new file.
     *
     * @param string $imagePath        Path to the original image.
     * @param string $compressedImagePath Path to save the compressed image.
     * @param int    $compressionLevel Image compression level (0-9) for PNG format.
     * @param bool   $createPathIfNotExists Whether to create the directory if it doesn't exist (default is false).
     *
     * @return bool Returns true on successful compression.
     * @throws \ErrorException If an error occurs during the process.
     */
    public static function compressImage(string $imagePath, string $compressedImagePath, int $compressionLevel = 9, bool $createPathIfNotExists = false): bool
    {
        // Validate compression level for PNG
        if (strtolower(pathinfo($imagePath, PATHINFO_EXTENSION)) == 'png' && ($compressionLevel < 0 || $compressionLevel > 9)) {
            throw new \ErrorException('Invalid compression level. The compression parameter should be between 0 and 9 for PNG.');
        }

        try {
            // Check image path type
            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                $originalImage = imagecreatefromstring(file_get_contents($imagePath));
            } else {
                if (!file_exists($imagePath)) {
                    throw new \ErrorException('Original image file not found.');
                }

                $imageExtension = strtolower(pathinfo($imagePath, PATHINFO_EXTENSION));
                switch ($imageExtension) {
                    case 'jpg':
                    case 'jpeg':
                        $originalImage = imagecreatefromjpeg($imagePath);
                        break;
                    case 'png':
                        $originalImage = imagecreatefrompng($imagePath);
                        break;
                    default:
                        throw new \ErrorException('Unsupported image format.');
                }
            }

            if (!$originalImage) {
                throw new \ErrorException('Failed to create image from the original file or URL.');
            }

            // Check and create the compressed image directory if needed
            $compressedImageDirectory = dirname($compressedImagePath);
            if (!is_dir($compressedImageDirectory) && $createPathIfNotExists) {
                mkdir($compressedImageDirectory, 0777, true);
            }

            // Save the compressed image based on its type
            switch (strtolower(pathinfo($compressedImagePath, PATHINFO_EXTENSION))) {
                case 'jpg':
                case 'jpeg':
                    // For JPEG, use quality 100 for lossless compression
                    imagejpeg($originalImage, $compressedImagePath, 100);
                    break;
                case 'png':
                    // For PNG, use the specified compression level (0-9) for lossless compression
                    imagepng($originalImage, $compressedImagePath, $compressionLevel);
                    break;
                default:
                    throw new \ErrorException('Unsupported image format for saving the compressed image.');
            }

            // Free up memory by destroying the image resources
            imagedestroy($originalImage);
        } catch (\ErrorException $error) {
            throw $error;
        }

        return true;
    }

}