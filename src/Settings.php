<?php

namespace Subb98\VkPublisher;

use Subb98\VkPublisher\Interfaces\SettingsInterface;

/**
 * Manages settings
 *
 * @license MIT
 * @package Subb98\VkPublisher
 */
class Settings implements SettingsInterface
{
    /** @var int Community index */
    private $groupId;

    /** @var int Photo album index */
    private $albumId;

    /** @var string User access token */
    private $accessToken;

    /** @var string Version of VKontakte API */
    private $apiVersion;

    /**
     * Gets the value of groupId
     *
     * @return integer|null
     */
    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    /**
     * Sets the value of groupId
     *
     * @param integer $groupId Community index
     * @return self
     */
    public function setGroupId(int $groupId): self
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * Gets the value of albumId
     *
     * @return integer|null
     */
    public function getAlbumId(): ?int
    {
        return $this->albumId;
    }

    /**
     * Sets the value of albumId
     *
     * @param integer $albumId Photo album index
     * @return self
     */
    public function setAlbumId(int $albumId): self
    {
        $this->albumId = $albumId;
        return $this;
    }

    /**
     * Gets the value of accessToken
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * Sets the value of accessToken
     *
     * @param string $accessToken User access token
     * @return self
     */
    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * Gets the value of apiVersion
     *
     * @return string|null
     */
    public function getApiVersion(): ?string
    {
        return $this->apiVersion;
    }

    /**
     * Sets the value of apiVersion
     *
     * @param string $apiVersion Version of VKontakte API
     * @return self
     */
    public function setApiVersion(string $apiVersion): self
    {
        $this->apiVersion = $apiVersion;
        return $this;
    }
}
