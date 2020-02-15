<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface SettingsInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 */
interface SettingsInterface
{
    /**
     * Gets the value of ownerId
     *
     * @return int|null
     */
    public function getOwnerId(): ?int;

    /**
     * Sets the value of ownerId
     *
     * @param int $ownerId Community or user id
     * @return $this
     */
    public function setOwnerId(int $ownerId): self;

    /**
     * Gets the value of albumId
     *
     * @return int|null
     */
    public function getAlbumId(): ?int;

    /**
     * Sets the value of albumId
     *
     * @param int $albumId Photo album id
     * @return $this
     */
    public function setAlbumId(int $albumId): self;

    /**
     * Gets the value of accessToken
     *
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * Sets the value of accessToken
     *
     * @param string $accessToken User access token
     * @return $this
     */
    public function setAccessToken(string $accessToken): self;

    /**
     * Gets the value of apiVersion
     *
     * @return string|null
     */
    public function getApiVersion(): ?string;

    /**
     * Sets the value of apiVersion
     *
     * @param string $apiVersion Version of VKontakte API
     * @return $this
     */
    public function setApiVersion(string $apiVersion): self;
}
