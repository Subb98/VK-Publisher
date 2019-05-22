<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface PhotoValidatorInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 * @license MIT
 */
interface PhotoValidatorInterface
{
    /**
     * Validates photo
     *
     * @param string $pathToPhoto Absolute path to photo
     * @return void
     */
    public function validate(string $pathToPhoto): void;
}
