# PHP GetImg.ai SDK 📷🎨

![License](https://img.shields.io/badge/license-MIT-blue.svg)
![PHP Version](https://img.shields.io/badge/php-%5E8.3-blue)
![Composer](https://img.shields.io/badge/composer-compatible-brightgreen)

**nicodemuz/php-getimg.ai** is a modern, lightweight PHP library designed to integrate seamlessly with the [GetImg.ai](https://getimg.ai/) image generation API. Quickly generate stunning AI-powered images for your projects with just a few lines of code.

This package is currently under development. There is only support for text-to-image generation. Pull requests for other features are welcome.

---

## Features 🚀
- **PSR-18 and PSR-17 Compatibility**: Fully compliant with PSR-18 (HTTP Client) and PSR-17 (HTTP Factories) standards, ensuring seamless integration with any compatible HTTP client and factory implementation.
- **Comprehensive API Coverage**: Access all GetImg.ai image generation features.
- **Flexible Configuration**: Customize HTTP client, request factories, and other dependencies to suit your project.
- **Lightweight**: Minimal dependencies for fast and efficient performance.

---

## Installation 💻

Install the package via Composer:

```bash
composer require nicodemuz/php-getimg.ai
```

## Installation 💻

Install the package via Composer:

```bash
composer require nicodemuz/php-getimg.ai
```

### Installing PSR-17 and PSR-18 dependencies

To use this library, you'll need PSR-17 (HTTP Factories) and PSR-18 (HTTP Client) compatible packages. If you don't already have them, you can install popular implementations such as:

1. **Guzzle** (for PSR-18) and **Nyholm/psr7** (for PSR-17):
   ```bash
   composer require guzzlehttp/guzzle nyholm/psr7
   ```

2. **Symfony HTTP Client** (alternative for PSR-18) and **Symfony HTTP Factories** (for PSR-17):
   ```bash
   composer require symfony/http-client symfony/psr-http-message-bridge
   ```

After installation, initialize the required dependencies in your project as shown in the usage example.

---

## Usage 📖

### Basic Example
```php
<?php

require 'vendor/autoload.php';

use Nicodemuz\PhpGetImgAi\GetImgAiClient;
use Nicodemuz\PhpGetImgAi\Request\TextToImageRequest;
use GuzzleHttp\Client as HttpClient;
use Nyholm\Psr7\Factory\Psr17Factory;

// Initialize the required dependencies
$httpClient = new HttpClient();
$requestFactory = new Psr17Factory();
$streamFactory = new Psr17Factory();

// Initialize the GetImgAiClient with your API key
$apiKey = 'your-api-key-here';
$getImgClient = new GetImgAiClient($apiKey, $httpClient, $requestFactory, $streamFactory);

try {
    // Create a request for text-to-image generation
    $textToImageRequest = new TextToImageRequest(
        prompt: 'A futuristic city skyline at sunset, cyberpunk style',
        model: 'flux-schnell',
        width: 1024,
        height: 1024,
        steps: 4,
        seed: null, // Optional seed for reproducibility
        outputFormat: 'jpeg',
        responseFormat: 'url'
    );

    // Generate the image
    $response = $getImgClient->textToImage($textToImageRequest);

    // Output the results
    echo "Image URL: " . $response->getUrl() . PHP_EOL;
    echo "Seed Used: " . $response->getSeed() . PHP_EOL;
    echo "Cost: $" . $response->getCost() . PHP_EOL;

    // Optionally, download the image
    $imageData = file_get_contents($response->getUrl());
    file_put_contents('generated_image.jpeg', $imageData);
    echo "Image saved as 'generated_image.jpeg'." . PHP_EOL;

} catch (Exception $e) {
    // Handle errors
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
```

---

## Requirements 📋
- PHP 8.3 or higher
- Composer

---

## Contributing 🤝
Contributions are welcome! To contribute:
1. Fork the repository.
2. Create a new feature branch.
3. Submit a pull request with a clear description of your changes.

---

## License 📜
This library is open-sourced software licensed under the MIT License.

---

## Support & Feedback ✉️
If you encounter issues or have suggestions, feel free to [open an issue](https://github.com/nicodemuz/php-getimg.ai/issues).

---

### 🌟 Happy Generating!
