<?php

namespace Subb98\VkPublisher\Services;

use InvalidArgumentException;
use Subb98\VkPublisher\Interfaces\HttpClientInterface;
use Subb98\VkPublisher\Interfaces\PostSenderInterface;
use Subb98\VkPublisher\Interfaces\SettingsInterface;

/**
 * Class PostSenderService
 *
 * @package Subb98\VkPublisher\Services
 */
class PostSenderService implements PostSenderInterface
{
    /**
     * Resource to send a message.
     */
    const POST_URL = 'https://api.vk.com/method/wall.post?';

    /**
     * @var HttpClientInterface
     */
    public $httpClient = 'Subb98\VkPublisher\Http\HttpClient';

    /**
     * @var SettingsInterface
     */
    protected $settings;

    /**
     * @inheritDoc
     */
    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException if $message and $attachments are empty
     */
    public function sendPostToWall(string $message, array $attachments = []): int
    {
        if (trim($message) === '' && empty($attachments)) {
            throw new InvalidArgumentException('Argument "$message" or "$attachments" should not be empty.');
        }

        $params = [
            'owner_id'      => $this->settings->getOwnerId(),
            'from_group'    => 1,
            'message'       => $message,
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
        ];

        if ($attachments) {
            $attachments = implode(',', $attachments);
            $params['attachments'] = $attachments;
        }

        $response = $this->httpClient::sendRequest(static::POST_URL, $params);

        return $response['response']['post_id'];
    }
}
