<?php

namespace Subb98\VkPublisher\Services;

use InvalidArgumentException;
use RuntimeException;
use Subb98\VkPublisher\Interfaces\PhotoValidatorInterface;

/**
 * Class PhotoValidatorService
 *
 * @package Subb98\VkPublisher\Services
 */
class PhotoValidatorService implements PhotoValidatorInterface
{
    /**
     * Maximum photo size in megabytes.
     */
    const MAX_FILE_SIZE = 50;

    /**
     * Number of bytes in megabytes (1024 bytes * 1024 kB).
     */
    const BYTES_IM_MEGABYTE = 1048576;

    /**
     * Allowed photo formats.
     */
    const ALLOWED_EXTENSIONS = ['jpg', 'png', 'gif'];

    /**
     * Maximum sum of height and width of a photo.
     */
    const MAX_WIDTH_HEIGHT_SUM = 14000;

    /**
     * Maximum aspect ratio (1:20).
     */
    const MAX_WIDTH_HEIGHT_RATIO = 20;

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException if $pathToPhoto is missing
     * @throws RuntimeException if any other check fails
     */
    public static function validate(string $pathToPhoto): void
    {
        if (!$pathToPhoto) {
            throw new InvalidArgumentException('Param $pathToPhoto is missing');
        }

        if (!is_file($pathToPhoto)) {
            throw new RuntimeException("File not found or invalid: $pathToPhoto");
        }

        if (filesize($pathToPhoto) > static::MAX_FILE_SIZE * static::BYTES_IM_MEGABYTE) {
            throw new RuntimeException('File size is more than '
                . static::MAX_FILE_SIZE . " MB: $pathToPhoto");
        }

        $fileParts = pathinfo($pathToPhoto);
        $fileExtension = strtolower($fileParts['extension']);

        if (!in_array($fileExtension, static::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException("Invalid file extension: $fileExtension");
        }

        $photoSizes = getimagesize($pathToPhoto);

        if (!$photoSizes) {
            throw new RuntimeException("Can't get photo size: invalid file: $pathToPhoto");
        }

        $photoWidth = $photoSizes[0];
        $photoHeight = $photoSizes[1];

        if ($photoWidth + $photoHeight > static::MAX_WIDTH_HEIGHT_SUM) {
            throw new RuntimeException('Photo width + height is more than '
                . static::MAX_WIDTH_HEIGHT_SUM . " px: $pathToPhoto");
        }

        $ratio = $photoWidth / $photoHeight;

        if ($ratio > floatval(static::MAX_WIDTH_HEIGHT_RATIO)) {
            throw new RuntimeException("Invalid width to height ratio: 1:$ratio, need less than or equal to 1:"
                . static::MAX_WIDTH_HEIGHT_RATIO . " $pathToPhoto");
        }
    }
}
