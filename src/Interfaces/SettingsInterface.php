<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface SettingsInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 * @license MIT
 */
interface SettingsInterface
{
    /**
     * Gets the value of groupId
     *
     * @return int|null
     */
    public function getGroupId(): ?int;

    /**
     * Sets the value of groupId
     *
     * @param int $groupId Community index
     * @return self
     */
    public function setGroupId(int $groupId);

    /**
     * Gets the value of albumId
     *
     * @return int|null
     */
    public function getAlbumId(): ?int;

    /**
     * Sets the value of albumId
     *
     * @param int $albumId Photo album index
     * @return self
     */
    public function setAlbumId(int $albumId);

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
     * @return self
     */
    public function setAccessToken(string $accessToken);

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
     * @return self
     */
    public function setApiVersion(string $apiVersion);
}
