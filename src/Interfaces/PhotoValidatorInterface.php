<?php

namespace Subb98\VkPublisher\Interfaces;

interface PhotoValidatorInterface
{
    /**
     * Validates photo
     *
     * @param string $pathToPhoto Absolute path to photo
     * @throws \InvalidArgumentException if $pathToPhoto is missing
     * @throws \RuntimeException if any other check fails
     * @return void
     */
    public function validate(string $pathToPhoto): void;
}
