<?php

namespace VkPublisher;

/**
 * Validates photo before uploading
 *
 * @license MIT
 * @package VkPublisher
 */
class PhotoValidator
{
    const MAX_FILE_SIZE = 50000000; // in kilobytes
    const ALLOWED_EXTENSIONS = ['jpg', 'png', 'gif'];
    const MAX_WIDTH_HEIGHT_SUM = 14000;
    const MAX_WIDTH_HEIGHT_RATIO = 20;

    /**
     * Validates photo
     *
     * @param string $file_name
     * @return void
     * @todo add tests
     */
    public function validatePhoto(string $file_name): void
    {
        if (!$file_name) {
            throw new \Exception('File name is missing');
        }

        if (!file_exists($file_name)) {
            throw new \Exception("File not found: {$file_name}");
        }

        if (filesize($file_name) > self::MAX_FILE_SIZE) {
            throw new \Exception('File size is more than ' . self::MAX_FILE_SIZE / 1000000 . " MB: {$file_name}");
        }

        $file_parts = pathinfo($file_name);
        $file_extension = strtolower($file_parts['extension']);

        if (!in_array($file_extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new \Exception("Invalid file extension: {$file_extension}");
        }

        $photo_sizes = getimagesize($file_name);

        if (!$photo_sizes) {
            throw new \Exception("Can't get photo size: invalid file: {$file_name}");
        }

        $photo_width = $photo_sizes[0];
        $photo_height = $photo_sizes[1];

        if ($photo_width + $photo_height > self::MAX_WIDTH_HEIGHT_SUM) {
            throw new \Exception('Photo width + height is more than '
                . self::MAX_WIDTH_HEIGHT_SUM . " px: {$file_name}");
        }

        $ratio = $photo_width / $photo_height;

        if ($ratio > floatval(self::MAX_WIDTH_HEIGHT_RATIO)) {
            throw new \Exception("Invalid width to height ratio: 1:{$ratio}, need less than or equal to 1:"
                . self::MAX_WIDTH_HEIGHT_RATIO . " {$file_name}");
        }
    }
}
