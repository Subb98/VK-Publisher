<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface PhotoDownloaderInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 */
interface PhotoDownloaderInterface
{
    /**
     * Checks if the path is an external resource.
     *
     * @param string $pathToPhoto External URL or absolute path to photo
     * @return bool
     */
    public static function isExternalPhoto(string $pathToPhoto): bool;

    /**
     * Saves the photo to a temporary directory.
     *
     * @param string $photoUrl External photo URL
     * @return string Absolute path to photo
     */
    public static function downloadPhoto(string $photoUrl): string;

    /**
     * Deletes a photo from a temporary directory.
     *
     * @param string $photoUrl External photo URL
     */
    public static function deleteTmpPhoto(string $photoUrl): void;
}
