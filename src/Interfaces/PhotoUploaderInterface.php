<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface PhotoUploaderInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 */
interface PhotoUploaderInterface
{
    /**
     * PhotoUploaderInterface constructor.
     *
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings);

    /**
     * Uploads photo to album.
     *
     * @param string $pathToPhoto Absolute path to photo
     * @return string
     */
    public function uploadPhotoToAlbum(string $pathToPhoto): string;
}
