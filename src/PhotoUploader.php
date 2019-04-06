<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;
use Subb98\VkPublisher\Interfaces\PhotoValidatorInterface;
use Subb98\VkPublisher\Interfaces\PhotoUploaderInterface;
use Subb98\VkPublisher\Traits\HttpTrait;

/**
 * Uploads photos
 *
 * @license MIT
 * @package Subb98\VkPublisher
 */
class PhotoUploader implements PhotoUploaderInterface
{
    use HttpTrait;

    /** @var SettingsInterface */
    private $settings;

    /** @var PhotoValidatorInterface */
    private $photoValidator;

    /**
     * Creates a new PhotoUploader instance
     *
     * @param SettingsInterface $settings
     * @param PhotoValidatorInterface $photoValidator
     */
    public function __construct(SettingsInterface $settings, PhotoValidatorInterface $photoValidator)
    {
        $this->settings = $settings;
        $this->photoValidator = $photoValidator;
    }

    /**
     * Uploads photo to album
     *
     * @param string $pathToPhoto Absolute path to photo
     * @return string
     */
    public function uploadPhotoToAlbum(string $pathToPhoto): string
    {
        $this->photoValidator->validate($pathToPhoto);

        $response = $this->httpRequest('https://api.vk.com/method/photos.getUploadServer?', [
            'album_id'      => $this->settings->getAlbumId(),
            'group_id'      => $this->settings->getGroupId(),
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
        ]);

        $response = $this->httpRequest($response['response']['upload_url'], [
            'file1' => new \CURLFile($pathToPhoto),
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
