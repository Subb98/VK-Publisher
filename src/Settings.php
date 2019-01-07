<?php

namespace VkPublisher;

use VkPublisher\Interfaces\SettingsInterface;

class Settings implements SettingsInterface
{
    /**
     * Community index
     *
     * @var int
     */
    private $group_id;

    /**
     * Photo album index
     *
     * @var int
     */
    private $album_id;

    /**
     * Community access token
     *
     * @var string
     */
    private $access_token;

    /**
     * API version
     *
     * @var string
     */
    private $api_version;

    /**
     * Gets the value of group_id
     *
     * @return integer|null
     */
    public function getGroupId(): ?int
    {
        return $this->group_id;
    }

    /**
     * Sets the value of group_id
     *
     * @param integer $group_id
     * @return self
     */
    public function setGroupId(int $group_id): self
    {
        $this->group_id = $group_id;
        return $this;
    }

    /**
     * Gets the value of album_id
     *
     * @return integer|null
     */
    public function getAlbumId(): ?int
    {
        return $this->album_id;
    }

    /**
     * Sets the value of album_id
     *
     * @param integer $album_id
     * @return self
     */
    public function setAlbumId(int $album_id): self
    {
        $this->album_id = $album_id;
        return $this;
    }

    /**
     * Gets the value of access_token
     *
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->access_token;
    }

    /**
     * Sets the value of access_token
     *
     * @param string $access_token
     * @return self
     */
    public function setAccessToken(string $access_token): self
    {
        $this->access_token = $access_token;
        return $this;
    }

    /**
     * Gets the value of api_version
     *
     * @return string|null
     */
    public function getApiVersion(): ?string
    {
        return $this->api_version;
    }

    /**
     * Sets the value of api_version
     *
     * @param string $api_version
     * @return self
     */
    public function setApiVersion(string $api_version): self
    {
        $this->api_version = $api_version;
        return $this;
    }
}
