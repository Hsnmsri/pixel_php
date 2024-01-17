# Pixel

Optimize and enhance your web application's image performance effortlessly with Pixel, a powerful PHP toolkit for resizing, compressing, and optimizing image quality. Boost your site's loading speed and user experience by seamlessly integrating our efficient image processing functions. Whether you're a developer or a website owner, Pixel simplifies the complex task of image optimization, ensuring your visuals look stunning without compromising performance. Elevate your website's speed and aesthetics with this lightweight and easy-to-use PHP image processing solution.

## Installation

You can install Pixel PHP via [Composer](https://getcomposer.org/):

```bash
composer require hsnmsri/pixel
```

## Resize image tool
Pixel PHP is a lightweight image resizing library for PHP, designed to simplify the process of resizing images while providing flexibility and ease of use.

```php
Pixel::resizeImage(imagePath,resizedImagePath,newWidth, newHeight, createPathIfNotExists = false)
```

### Features

- Resize images with specified dimensions.
- Support for both local file paths and URLs.
- Option to create the destination directory if it doesn't exist.
- Error handling with detailed exceptions.

## Change image quality tool
Pixel PHP is a versatile image processing library for PHP, designed to simplify common image operations. The `changeQuality` function allows you to modify the quality of both JPEG and PNG images.

```php
Pixel::changeQuality(imagePath,resizedImagePath,quality, createPathIfNotExists = false)
```

### Features

- Change the quality of JPEG and PNG images.
- Support for both local file paths and URLs.
- Option to create the destination directory if it doesn't exist.
- Error handling with detailed exceptions.

## Compress Image tool
Pixel PHP is a versatile image processing library for PHP, designed to simplify common image operations. The `compressImage` function allows you to compress and reduce the file size of both JPEG and PNG images without significantly lowering the quality.

```php
Pixel::changeQuality(imagePath,resizedImagePath,compressionLevel = 9, createPathIfNotExists = false)
```

### Features

- Compress and lower the file size of JPEG and PNG images.
- Lossless compression to maintain image quality.
- Support for both local file paths and URLs.
- Option to create the destination directory if it doesn't exist.
- Error handling with detailed exceptions.