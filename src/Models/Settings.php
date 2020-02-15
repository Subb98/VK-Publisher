<?php

namespace Subb98\VkPublisher\Models;

use Subb98\VkPublisher\Interfaces\SettingsInterface;

/**
 * Class Settings
 *
 * @package Subb98\VkPublisher\Models
 */
class Settings implements SettingsInterface
{
    /**
     * @var int Community or user id
     */
    protected $ownerId;

    /**
     * @var int Photo album id
     */
    protected $albumId;

    /**
     * @var  string User access token
     */
    protected $accessToken;

    /**
     * @var  string Version of VKontakte API
     */
    protected $apiVersion;

    /**
     * @inheritDoc
     */
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    /**
     * @inheritDoc
     */
    public function setOwnerId(int $ownerId): SettingsInterface
    {
        $this->ownerId = $ownerId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }

    /**
     * @inheritDoc
     */
    public function setAlbumId(int $albumId): SettingsInterface
    {
        $this->albumId = $albumId;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @inheritDoc
     */
    public function setAccessToken(string $accessToken): SettingsInterface
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getApiVersion(): ?string
    {
        return $this->apiVersion;
    }

    /**
     * @inheritDoc
     */
    public function setApiVersion(string $apiVersion): SettingsInterface
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }
}
