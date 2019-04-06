<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\PhotoValidatorInterface;

/**
 * Validates photo before uploading
 *
 * @license MIT
 * @package Subb98\VkPublisher
 */
class PhotoValidator implements PhotoValidatorInterface
{
    const MAX_FILE_SIZE = 50000000; // in kilobytes
    const ALLOWED_EXTENSIONS = ['jpg', 'png', 'gif'];
    const MAX_WIDTH_HEIGHT_SUM = 14000;
    const MAX_WIDTH_HEIGHT_RATIO = 20;

    /**
     * Validates photo
     *
     * @param string $pathToPhoto Absolute path to photo
     * @throws \InvalidArgumentException if $pathToPhoto is missing
     * @throws \RuntimeException if any other check fails
     * @return void
     */
    public function validate(string $pathToPhoto): void
    {
        if (!$pathToPhoto) {
            throw new \InvalidArgumentException('Param $pathToPhoto is missing');
        }

        if (!is_file($pathToPhoto)) {
            throw new \RuntimeException("File not found or invalid: {$pathToPhoto}");
        }

        if (filesize($pathToPhoto) > self::MAX_FILE_SIZE) {
            throw new \RuntimeException('File size is more than '
                . self::MAX_FILE_SIZE / 1000000 . " MB: {$pathToPhoto}");
        }

        $fileParts = pathinfo($pathToPhoto);
        $fileExtension = strtolower($fileParts['extension']);

        if (!in_array($fileExtension, self::ALLOWED_EXTENSIONS, true)) {
            throw new \RuntimeException("Invalid file extension: {$fileExtension}");
        }

        $photoSizes = getimagesize($pathToPhoto);

        if (!$photoSizes) {
            throw new \RuntimeException("Can't get photo size: invalid file: {$pathToPhoto}");
        }

        $photoWidth = $photoSizes[0];
        $photoHeight = $photoSizes[1];

        if ($photoWidth + $photoHeight > self::MAX_WIDTH_HEIGHT_SUM) {
            throw new \RuntimeException('Photo width + height is more than '
                . self::MAX_WIDTH_HEIGHT_SUM . " px: {$pathToPhoto}");
        }

        $ratio = $photoWidth / $photoHeight;

        if ($ratio > floatval(self::MAX_WIDTH_HEIGHT_RATIO)) {
            throw new \RuntimeException("Invalid width to height ratio: 1:{$ratio}, need less than or equal to 1:"
                . self::MAX_WIDTH_HEIGHT_RATIO . " {$pathToPhoto}");
        }
    }
}
