<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;
use Subb98\VkPublisher\Interfaces\PostSenderInterface;
use Subb98\VkPublisher\Traits\HttpTrait;

/**
 * Sends messages to wall
 *
 * @license MIT
 * @package Subb98\VkPublisher
 */
class PostSender implements PostSenderInterface
{
    use HttpTrait;

    /** @var SettingsInterface */
    private $settings;

    /**
     * Creates a new PostSender instance
     *
     * @param SettingsInterface $settings
     */
    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * Sends message to wall
     *
     * @param string $message Message that will be sent to the wall
     * @param array $attachments Photos that will be post on the wall
     * @throws \InvalidArgumentException if $message and $attachments are empty
     * @return int
     */
    public function sendPostToWall(string $message, array $attachments = []): int
    {
        if (trim($message) === '' && empty($attachments)) {
            throw new \InvalidArgumentException('Argument "$message" or "$attachments" should not be empty.');
        }

        $params = [
            'owner_id'      => '-'.$this->settings->getGroupId(),
            'from_group'    => 1,
            'message'       => $message,
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
        ];

        if ($attachments) {
            $attachments = implode(',', $attachments);
            $params['attachments'] = $attachments;
        }

        $response = $this->httpRequest('https://api.vk.com/method/wall.post?', $params);

        return $response['response']['post_id'];
    }
}
