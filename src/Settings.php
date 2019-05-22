<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;

/**
 * Class Settings
 *
 * @package Subb98\VkPublisher
 * @license MIT
 */
class Settings implements SettingsInterface
{
    /**
     * @var int Community index
     */
    private $groupId;

    /**
     * @var int Photo album index
     */
    private $albumId;

    /**
     * @var  string User access token
     */
    private $accessToken;

    /**
     * @var  string Version of VKontakte API
     */
    private $apiVersion;

    /**
     * @inheritDoc
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * @inheritDoc
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;
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
    public function setAlbumId(int $albumId): self
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
    public function setAccessToken(string $accessToken): self
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
    public function setApiVersion(string $apiVersion): self
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }
}
