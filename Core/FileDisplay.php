<?php

namespace Core;

class FileDisplay
{
    /** @var string */
    protected static $baseUrl = '';

    /** @var string */
    protected $uploadDir;

    /**
     * Initialize the base URL (Static method)
     *
     * @return void
     */
    public static function initializeBaseUrl()
    {
        if (self::$baseUrl === '') {
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $scriptName = dirname($_SERVER['SCRIPT_NAME']);
            
            self::$baseUrl = $protocol . '://' . $host . $scriptName . 'storage/';
        }
    }

    /**
     * Constructor
     *
     * @param string $uploadDir Directory where files are stored (relative to the public directory)
     */
    public function __construct(string $uploadDir)
    {
        $this->uploadDir = trim($uploadDir, '/');
    }

    /**
     * Generate the URL for the given file
     *
     * @param string $fileName The name of the file
     * @return string The full URL to the file
     */
    public function getFileUrl(string $fileName)
    {
        return self::$baseUrl . '/' . $this->uploadDir . '/' . urlencode($fileName);
    }

    /**
     * Generate an HTML image tag for displaying an image
     *
     * @param string $fileName The name of the image file
     * @param string $altText Alternative text for the image
     * @param string $width The width of the image (CSS-compatible value)
     * @param string $height The height of the image (CSS-compatible value)
     * @return string The HTML image tag
     */
    public function getImageTag(string $fileName, string $altText = 'Image', string $width = '100px', string $height = 'auto')
    {
        $url = $this->getFileUrl($fileName);
        return '<img src="' . htmlspecialchars($url) . '" alt="' . htmlspecialchars($altText) . '" style="width: ' . htmlspecialchars($width) . '; height: ' . htmlspecialchars($height) . ';">';
    }
}
