<?php

namespace VkPublisher;

/**
 * PostsSender Class
 *
 * @author Vladislav Subbotin <subb98@gmail.com>
 * @version 0.1.0-dev
 */
class PostSender
{
    /**
     * Sends message to wall
     *
     * @param string $message
     * @param array $attachments
     *
     * @return void
     *
     * @todo add exceptions, tests and prepare message
     */
    public static function sendPostToWall(string $message, array $attachments = []): void
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
        $response = json_decode($response, true);
        curl_close($ch);
    }
}
