<?php

namespace VkPublisher;

use VkPublisher\PhotoValidator;

/**
 * PhotoUploader Class
 *
 * @author Vladislav Subbotin <subb98@gmail.com>
 * @version 0.1.0-dev
 */
class PhotoUploader
{
    /**
     * Uploads photo to album
     *
     * @param string $file_name
     * @return string
     * @todo add exceptions and tests
     */
    public function uploadPhotoToAlbum(string $file_name): string
    {
        $photo_validator = new PhotoValidator;
        $photo_validator->validatePhoto($file_name);

        $ch = curl_init('https://api.vk.com/method/photos.getUploadServer?');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => [
                'album_id'      => $_ENV['VK_PUBLISHER_ALBUM_ID'],
                'group_id'      => $_ENV['VK_PUBLISHER_GROUP_ID'],
                'access_token'  => $_ENV['VK_PUBLISHER_ACCESS_TOKEN'],
                'v'             => $_ENV['VK_PUBLISHER_API_VERSION'],
            ],
        ]);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);

        $ch = curl_init($response['response']['upload_url']);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => [
                'file1' => new \CURLFile($file_name),
            ],
        ]);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);

        $ch = curl_init('https://api.vk.com/method/photos.save?');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => [
                'server'        => $response['server'],
                'photos_list'   => $response['photos_list'],
                'group_id'      => $response['gid'],
                'album_id'      => $response['aid'],
                'hash'          => $response['hash'],
                'access_token'  => $_ENV['VK_PUBLISHER_ACCESS_TOKEN'],
                'v'             => $_ENV['VK_PUBLISHER_API_VERSION'],
            ],
        ]);

        $response = curl_exec($ch);
        $response = json_decode($response, true);
        curl_close($ch);

        return "photo{$response['response'][0]['owner_id']}_{$response['response'][0]['id']}";
    }
}
