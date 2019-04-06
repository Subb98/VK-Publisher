<?php

namespace Subb98\VkPublisher\Interfaces;

interface ValidatorInterface
{
    /**
     * Validates photo
     *
     * @param string $file_name Absolute path to photo
     * @throws \Exception if any check fails
     * @return void
     */
    public function validatePhoto(string $file_name): void;
}
