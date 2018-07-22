<?php

namespace VkPublisher;

/**
 * PhotoValidator Class
 * 
 * @author Vladislav Subbotin <subb98@gmail.com>
 * @version 0.1.0-dev
 */
class PhotoValidator
{
    /**
     * Validates photo
     * 
     * @param string $file_name
     * @return void
     * @todo add tests and constants
     */
    public static function validatePhoto(string $file_name): void
    {
        if (!$file_name) {
            throw new \Exception('File name is missing');
        }

        if (!file_exists($file_name)) {
            throw new \Exception("File not found: {$file_name}");
        }

        if (filesize($file_name) > 50000000) {
            throw new \Exception("File size is more than 50 MB: {$file_name}");
        }

        $file_parts = pathinfo($file_name);
        $file_extension = strtolower($file_parts['extension']);

        if ($file_extension !== 'jpg' && $file_extension !== 'png' && $file_extension !== 'gif') {
            throw new \Exception("Invalid file extension: {$file_extension}");
        }

        $photo_sizes = getimagesize($file_name);

        if (!$photo_sizes) {
            throw new \Exception("Can't get photo size: invalid file: {$file_name}");
        }

        $photo_width = $photo_sizes[0];
        $photo_height = $photo_sizes[1];

        if ($photo_width + $photo_height > 14000) {
            throw new \Exception("Photo width + height is more than 14000 px: {$file_name}");
        }

        $ratio = $photo_width / $photo_height;

        if ($ratio > 20.0) {
            throw new \Exception("Invalid width to height ratio: 1:{$ratio}, need less than or equal to 1:20: {$file_name}");
        }
    }
}
