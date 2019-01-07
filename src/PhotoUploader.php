<?php

namespace VkPublisher;

use VkPublisher\PhotoValidator;
use VkPublisher\Traits\HttpTrait;

/**
 * Uploads photos
 *
 * @license MIT
 * @package VkPublisher
 */
class PhotoUploader
{
    use HttpTrait;

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
     * @param string $file_name Absolute path to photo
     * @return string
     * @todo add tests
     */
    public function uploadPhotoToAlbum(string $file_name): string
    {
        $this->photo_validator->validatePhoto($file_name);

        $response = $this->httpRequest('https://api.vk.com/method/photos.getUploadServer?', [
            'album_id'      => $_ENV['VK_PUBLISHER_ALBUM_ID'],
            'group_id'      => $_ENV['VK_PUBLISHER_GROUP_ID'],
            'access_token'  => $_ENV['VK_PUBLISHER_ACCESS_TOKEN'],
            'v'             => $_ENV['VK_PUBLISHER_API_VERSION'],
        ]);

        $response = $this->httpRequest($response['response']['upload_url'], [
            'file1' => new \CURLFile($file_name),
        ]);

        $response = $this->httpRequest('https://api.vk.com/method/photos.save?', [
            'server'        => $response['server'],
            'photos_list'   => $response['photos_list'],
            'group_id'      => $response['gid'],
            'album_id'      => $response['aid'],
            'hash'          => $response['hash'],
            'access_token'  => $_ENV['VK_PUBLISHER_ACCESS_TOKEN'],
            'v'             => $_ENV['VK_PUBLISHER_API_VERSION'],
        ]);

        return "photo{$response['response'][0]['owner_id']}_{$response['response'][0]['id']}";
    }
}
