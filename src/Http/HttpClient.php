<?php

namespace Subb98\VkPublisher\Http;

use InvalidArgumentException;
use RuntimeException;
use Subb98\VkPublisher\Interfaces\HttpClientInterface;

/**
 * Class HttpClient
 *
 * @package Subb98\VkPublisher\Http
 */
class HttpClient implements HttpClientInterface
{
    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException if $url param is not a valid URL
     */
    public static function sendRequest(string $url, array $params = [], array $curlOptions = []): array
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new InvalidArgumentException(
                sprintf('Argument "$url" must be a valid URL. "%s" given.', $url)
            );
        }

        $ch = curl_init($url);

        if (!array_key_exists(CURLOPT_RETURNTRANSFER, $curlOptions)) {
            $curlOptions[CURLOPT_RETURNTRANSFER] = true;
        }

        if (!array_key_exists(CURLOPT_SSL_VERIFYPEER, $curlOptions)) {
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        }

        if (!array_key_exists(CURLOPT_SSL_VERIFYHOST, $curlOptions)) {
            $curlOptions[CURLOPT_SSL_VERIFYHOST] = false;
        }

        curl_setopt_array($ch, $curlOptions);

        if ($params) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        }

        $response = static::getResponse($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * {@inheritDoc}
     * @throws InvalidArgumentException if $ch param is not a resource
     * @throws RuntimeException if request failed
     */
    public static function getResponse($ch): array
    {
        if (!is_resource($ch)) {
            throw new InvalidArgumentException(
                sprintf('Argument "$ch" must be a valid resource type. %s given.', gettype($ch))
            );
        }

        $response = curl_exec($ch);

        if (!$response) {
            throw new RuntimeException('Request failed');
        }

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            throw new RuntimeException("Error {$response['error']['error_code']}: {$response['error']['error_msg']}");
        }

        return $response;
    }
}
