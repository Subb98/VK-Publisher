<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;
use Subb98\VkPublisher\Interfaces\PostSenderInterface;
use Subb98\VkPublisher\Traits\HttpTrait;

/**
 * Class PostSender
 *
 * @package Subb98\VkPublisher
 * @license MIT
 */
class PostSender implements PostSenderInterface
{
    const POST_URL = 'https://api.vk.com/method/wall.post?';

    use HttpTrait;

    /**
     * @var SettingsInterface
     */
    private $settings;

    /**
     * @inheritDoc
     */
    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @inheritDoc
     * @throws \InvalidArgumentException if $message and $attachments are empty
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

        $response = $this->httpRequest(self::POST_URL, $params);

        return $response['response']['post_id'];
    }
}
