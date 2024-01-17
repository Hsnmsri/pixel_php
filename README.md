# Pixel

Optimize and enhance your web application's image performance effortlessly with Pixel, a powerful PHP toolkit for resizing, compressing, and optimizing image quality. Boost your site's loading speed and user experience by seamlessly integrating our efficient image processing functions. Whether you're a developer or a website owner, Pixel simplifies the complex task of image optimization, ensuring your visuals look stunning without compromising performance. Elevate your website's speed and aesthetics with this lightweight and easy-to-use PHP image processing solution.

## Installation

You can install Pixel PHP via [Composer](https://getcomposer.org/):

```bash
composer require hsnmsri/pixel
```

## Resize image tool

```php
Pixel::resizeImage(imagePath,resizedImagePath,newWidth, newHeight, createPathIfNotExists = false)
```

### Features

- Resize images with specified dimensions.
- Support for both local file paths and URLs.
- Option to create the destination directory if it doesn't exist.
- Error handling with detailed exceptions.