<?php

namespace VkPublisher;

use VkPublisher\PhotoValidator;

/**
 * Uploads photos
 *
 * @license MIT
 * @package VkPublisher
 */
class PhotoUploader
{
    /**
     * @var PhotoValidator
     */
    private $photo_validator;

    /**
     * Creates a new PhotoUploader instance
     *
     * @param PhotoValidator $photo_validator
     */
    public function __construct(PhotoValidator $photo_validator)
    {
        $this->photo_validator = $photo_validator;
    }

    /**
     * Uploads photo to album
     *
     * @param string $file_name
     * @return string
     * @todo add tests
     */
    public function uploadPhotoToAlbum(string $file_name): string
    {
        $this->photo_validator->validatePhoto($file_name);

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

        $response = $this->getResponse($ch);

        $ch = curl_init($response['response']['upload_url']);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_POSTFIELDS => [
                'file1' => new \CURLFile($file_name),
            ],
        ]);

        $response = $this->getResponse($ch);

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

        $response = $this->getResponse($ch);

        return "photo{$response['response'][0]['owner_id']}_{$response['response'][0]['id']}";
    }

    /**
     * Gets cURL response
     *
     * @param \resource $ch
     * @return array
     */
    private function getResponse($ch): array
    {
        if (!is_resource($ch)) {
            throw new \InvalidArgumentException(
                sprintf('Argument must be a valid resource type. %s given.', gettype($ch))
            );
        }

        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            throw new \Exception('Request failed');
        }

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            throw new \Exception("Error {$response['error']['error_code']}: {$response['error']['error_msg']}");
        }

        return $response;
    }
}
