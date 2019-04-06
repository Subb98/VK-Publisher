<?php

namespace Subb98\VkPublisher\Interfaces;

interface SettingsInterface
{
    /**
     * Gets the value of group_id
     *
     * @return integer|null
     */
    public function getGroupId(): ?int;

    /**
     * Sets the value of group_id
     *
     * @param integer $group_id
     * @return self
     */
    public function setGroupId(int $group_id);

    /**
     * Gets the value of album_id
     *
     * @return integer|null
     */
    public function getAlbumId(): ?int;

    /**
     * Sets the value of album_id
     *
     * @param integer $album_id
     * @return self
     */
    public function setAlbumId(int $album_id);

    /**
     * Gets the value of access_token
     *
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * Sets the value of access_token
     *
     * @param string $access_token
     * @return self
     */
    public function setAccessToken(string $access_token);

    /**
     * Gets the value of api_version
     *
     * @return string|null
     */
    public function getApiVersion(): ?string;

    /**
     * Sets the value of api_version
     *
     * @param string $api_version
     * @return self
     */
    public function setApiVersion(string $api_version);
}
