<?php

namespace Subb98\VkPublisher\Services;

use Subb98\VkPublisher\Interfaces\HttpClientInterface;
use Subb98\VkPublisher\Interfaces\PhotoDownloaderInterface;

/**
 * Class PhotoDownloaderService
 *
 * @package Subb98\VkPublisher\Services
 */
class PhotoDownloaderService implements PhotoDownloaderInterface
{
    /**
     * Directory for saving temporary files.
     */
    const TMP_DIR = '/tmp';

    /**
     * Salt for hashing file names.
     */
    const HASH_SAULT = 'subb98/vk-publisher';

    /**
     * @var HttpClientInterface
     */
    public static $httpClient = 'Subb98\VkPublisher\Http\HttpClient';

    /**
     * @inheritDoc
     */
    public static function isExternalPhoto(string $pathToPhoto): bool
    {
        return (bool)filter_var($pathToPhoto, FILTER_VALIDATE_URL);
    }

    /**
     * @inheritDoc
     */
    public static function downloadPhoto(string $photoUrl): string
    {
        $response = static::$httpClient::sendRequest($photoUrl, [], [CURLOPT_BINARYTRANSFER => true]);
        $path = static::getTmpPhotoPath($photoUrl);

        $fp = fopen($path, 'w');
        fwrite($fp, $response[0]);
        fclose($fp);

        return $path;
    }

    /**
     * @inheritDoc
     */
    public static function deleteTmpPhoto(string $photoUrl): void
    {
        $path = static::getTmpPhotoPath($photoUrl);

        if (is_file($path)) {
            unlink($path);
        }
    }

    /**
     * Returns the absolute path to the photo.
     *
     * @param string $photoUrl External photo URL
     * @return string
     */
    protected static function getTmpPhotoPath(string $photoUrl): string
    {
        $fileParts = pathinfo($photoUrl);
        $fileHash = static::getHash($photoUrl);

        return static::TMP_DIR . "/$fileHash.{$fileParts['extension']}";
    }

    /**
     * Calculates hash by photo url.
     *
     * @param string $photoUrl External photo URL
     * @return string
     */
    protected static function getHash(string $photoUrl): string
    {
        return md5($photoUrl . static::HASH_SAULT);
    }
}
