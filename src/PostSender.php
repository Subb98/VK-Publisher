<?php

namespace VkPublisher;

use VkPublisher\Traits\HttpTrait;

/**
 * Sends messages to wall
 *
 * @license MIT
 * @package VkPublisher
 */
class PostSender
{
    use HttpTrait;

    /**
     * Sends message to wall
     *
     * @param string $message Message that will be sent to the wall
     * @param array $attachments Photos that will be post on the wall
     * @throws \InvalidArgumentException if $message and $attachments are empty
     * @return int
     * @todo add tests
     */
    public function sendPostToWall(string $message, array $attachments = []): int
    {
        if (trim($message) === '' && empty($attachments)) {
            throw new \InvalidArgumentException('Argument "$message" or "$attachments" should not be empty.');
        }

        $params = [
            'owner_id'      => '-'.$_ENV['VK_PUBLISHER_GROUP_ID'],
            'from_group'    => 1,
            'message'       => $message,
            'access_token'  => $_ENV['VK_PUBLISHER_ACCESS_TOKEN'],
            'v'             => $_ENV['VK_PUBLISHER_API_VERSION'],
        ];

        if ($attachments) {
            $attachments = implode(',', $attachments);
            $params['attachments'] = $attachments;
        }

        $response = $this->httpRequest('https://api.vk.com/method/wall.post?', $params);

        return $response['response']['post_id'];
    }
}
