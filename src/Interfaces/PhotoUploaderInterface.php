<?php

namespace Subb98\VkPublisher\Interfaces;

use Subb98\VkPublisher\Interfaces\SettingsInterface;
use Subb98\VkPublisher\Interfaces\PhotoValidatorInterface;

interface PhotoUploaderInterface
{
    /**
     * Creates a new PhotoUploader instance
     *
     * @param SettingsInterface $settings
     * @param PhotoValidatorInterface $photoValidator
     */
    public function __construct(SettingsInterface $settings, PhotoValidatorInterface $photoValidator);

    /**
     * Uploads photo to album
     *
     * @param string $pathToPhoto Absolute path to photo
     * @return string
     */
    public function uploadPhotoToAlbum(string $pathToPhoto): string;
}
