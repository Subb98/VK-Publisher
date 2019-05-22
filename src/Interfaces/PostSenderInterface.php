<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface PostSenderInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 * @license MIT
 */
interface PostSenderInterface
{
    /**
     * PostSenderInterface constructor.
     *
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings);

    /**
     * Sends message to wall
     *
     * @param string $message Message that will be sent to the wall
     * @param array $attachments Photos that will be post on the wall
     * @return int
     */
    public function sendPostToWall(string $message, array $attachments = []): int;
}
