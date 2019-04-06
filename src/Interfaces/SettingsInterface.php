<?php

namespace Subb98\VkPublisher\Interfaces;

interface SettingsInterface
{
    /**
     * Gets the value of groupId
     *
     * @return integer|null
     */
    public function getGroupId(): ?int;

    /**
     * Sets the value of groupId
     *
     * @param integer $groupId Community index
     * @return self
     */
    public function setGroupId(int $groupId);

    /**
     * Gets the value of albumId
     *
     * @return integer|null
     */
    public function getAlbumId(): ?int;

    /**
     * Sets the value of albumId
     *
     * @param integer $albumId Photo album index
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
