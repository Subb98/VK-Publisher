<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;
use Subb98\VkPublisher\Interfaces\PhotoValidatorInterface;
use Subb98\VkPublisher\Interfaces\PhotoUploaderInterface;
use Subb98\VkPublisher\Traits\HttpTrait;

/**
 * Class PhotoUploader
 *
 * @package Subb98\VkPublisher
 * @license MIT
 */
class PhotoUploader implements PhotoUploaderInterface
{
    const GET_UPLOAD_SERVER_URL = 'https://api.vk.com/method/photos.getUploadServer?';
    const SAVE_URL = 'https://api.vk.com/method/photos.save?';

    use HttpTrait;

    /**
     * @var SettingsInterface
     */
    private $settings;

    /**
     * @var PhotoValidatorInterface
     */
    private $photoValidator;

    /**
     * @inheritDoc
     */
    public function __construct(SettingsInterface $settings, PhotoValidatorInterface $photoValidator)
    {
        $this->settings = $settings;
        $this->photoValidator = $photoValidator;
    }

    /**
     * @inheritDoc
     */
    public function uploadPhotoToAlbum(string $pathToPhoto): string
    {
        $this->photoValidator->validate($pathToPhoto);

        $response = $this->httpRequest(self::GET_UPLOAD_SERVER_URL, [
            'album_id'      => $this->settings->getAlbumId(),
            'group_id'      => $this->settings->getGroupId(),
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
        ]);

        $response = $this->httpRequest($response['response']['upload_url'], [
            'file1' => new \CURLFile($pathToPhoto),
        ]);

        $response = $this->httpRequest(self::SAVE_URL, [
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
