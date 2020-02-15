<?php

namespace Subb98\VkPublisher\Services;

use Subb98\VkPublisher\Interfaces\HttpClientInterface;
use Subb98\VkPublisher\Interfaces\PhotoUploaderInterface;
use Subb98\VkPublisher\Interfaces\PhotoValidatorInterface;
use Subb98\VkPublisher\Interfaces\SettingsInterface;

/**
 * Class PhotoUploaderService
 *
 * @package Subb98\VkPublisher\Services
 */
class PhotoUploaderService implements PhotoUploaderInterface
{
    /**
     * Resource for retrieving upload URL.
     */
    const GET_UPLOAD_SERVER_URL = 'https://api.vk.com/method/photos.getUploadServer?';

    /**
     * Resource for saving photo.
     */
    const SAVE_URL = 'https://api.vk.com/method/photos.save?';

    /**
     * @var HttpClientInterface
     */
    public $httpClient = 'Subb98\VkPublisher\Http\HttpClient';

    /**
     * @var PhotoValidatorInterface
     */
    public $photoValidator = 'Subb98\VkPublisher\Services\PhotoValidatorService';

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
     * @inheritDoc
     */
    public function uploadPhotoToAlbum(string $pathToPhoto): string
    {
        $this->photoValidator::validate($pathToPhoto);

        $response = $this->httpClient::sendRequest(self::GET_UPLOAD_SERVER_URL, [
            'album_id'      => $this->settings->getAlbumId(),
            'group_id'      => $this->settings->getOwnerId(),
            'access_token'  => $this->settings->getAccessToken(),
            'v'             => $this->settings->getApiVersion(),
        ]);

        $response = $this->httpClient::sendRequest($response['response']['upload_url'], [
            'file1' => new \CURLFile($pathToPhoto),
        ]);

        $response = $this->httpClient::sendRequest(self::SAVE_URL, [
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
