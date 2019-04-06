<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;
use Subb98\VkPublisher\Interfaces\ValidatorInterface;
use Subb98\VkPublisher\Traits\HttpTrait;

/**
 * Uploads photos
 *
 * @license MIT
 * @package Subb98\VkPublisher
 */
class PhotoUploader
{
    use HttpTrait;

    /**
     * @var SettingsInterface
     */
    private $settings;

    /**
     * @var ValidatorInterface
     */
    private $photo_validator;

    /**
     * Creates a new PhotoUploader instance
     *
     * @param SettingsInterface $settings
     * @param ValidatorInterface $photo_validator
     */
    public function __construct(SettingsInterface $settings, ValidatorInterface $photo_validator)
    {
        $this->settings = $settings;
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
            'album_id'      => $this->settings->getAlbumId(),
            'group_id'      => $this->settings->getGroupId(),
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
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
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
        ]);

        return "photo{$response['response'][0]['owner_id']}_{$response['response'][0]['id']}";
    }
}
