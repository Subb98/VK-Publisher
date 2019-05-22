<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface PhotoUploaderInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 * @license MIT
 */
interface PhotoUploaderInterface
{
    /**
     * PhotoUploaderInterface constructor.
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
