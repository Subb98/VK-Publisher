<?php

namespace Subb98\VkPublisher\Interfaces;

/**
 * Interface HttpClientInterface
 *
 * @package Subb98\VkPublisher\Interfaces
 */
interface HttpClientInterface
{
    /**
     * Sends HTTP request.
     *
     * @param string $url Resource URL
     * @param array $params Request parameters (CURLOPT_POSTFIELDS)
     * @param array $curlOptions cURL options (CURLOPT_* array)
     * @return array
     */
    public static function sendRequest(string $url, array $params = [], array $curlOptions = []): array;

    /**
     * Gets cURL response.
     *
     * @param resource $ch cURL handler
     * @return array
     */
    public static function getResponse($ch): array;
}
