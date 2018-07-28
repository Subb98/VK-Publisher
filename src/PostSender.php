<?php

namespace VkPublisher;

/**
 * Sends messages to wall
 *
 * @license MIT
 * @package VkPublisher
 */
class PostSender
{
    /**
     * Sends message to wall
     *
     * @param string $message
     * @param array $attachments
     *
     * @return int
     *
     * @todo add tests
     */
    public function sendPostToWall(string $message, array $attachments = []): int
    {
        $ch = curl_init('https://api.vk.com/method/wall.post?');
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);

        $opt_postfields = [
            'owner_id'      => '-'.$_ENV['VK_PUBLISHER_GROUP_ID'],
            'from_group'    => 1,
            'message'       => $message,
            'access_token'  => $_ENV['VK_PUBLISHER_ACCESS_TOKEN'],
            'v'             => $_ENV['VK_PUBLISHER_API_VERSION'],
        ];

        if ($attachments) {
            $attachments = implode(',', $attachments);
            $opt_postfields['attachments'] = $attachments;
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $opt_postfields);

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            throw new \Exception('Request failed');
        }

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            throw new \Exception("Error {$response['error']['error_code']}: {$response['error']['error_msg']}");
        }

        return $response['response']['post_id'];
    }
}
