<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface PhotoValidatorInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 */
interface PhotoValidatorInterface
{
    /**
     * Validates photo.
     *
     * @param string $pathToPhoto Absolute path to photo
     * @return void
     */
    public static function validate(string $pathToPhoto): void;
}
