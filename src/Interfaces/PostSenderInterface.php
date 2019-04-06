<?php

namespace Subb98\VkPublisher\Interfaces;

use Subb98\VkPublisher\Interfaces\SettingsInterface;

interface PostSenderInterface
{
    /**
     * Creates a new PostSender instance
     *
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings);

    /**
     * Sends message to wall
     *
     * @param string $message Message that will be sent to the wall
     * @param array $attachments Photos that will be post on the wall
     * @throws \InvalidArgumentException if $message and $attachments are empty
     * @return int
     */
    public function sendPostToWall(string $message, array $attachments = []): int;
}
