<?php

namespace Subb98\VkPublisher\Traits;

/**
 * Trait HttpTrait
 *
 * @package Subb98\VkPublisher\Traits
 * @license MIT
 */
trait HttpTrait
{
    /**
     * Sends HTTP request
     *
     * @param string $url URL
     * @param array $params Request parameters (CURLOPT_POSTFIELDS)
     * @param array $curlOptions cURL options (CURLOPT_* array)
     * @throws \InvalidArgumentException if $url param is not a valid URL
     * @return array
     */
    protected function httpRequest(string $url, array $params = [], array $curlOptions = []): array
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException(
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
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $response = $this->getResponse($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * Gets cURL response
     *
     * @param resource $ch
     * @throws \InvalidArgumentException if $ch param is not a resource
     * @throws \RuntimeException if request failed
     * @return array
     */
    protected function getResponse($ch): array
    {
        if (!is_resource($ch)) {
            throw new \InvalidArgumentException(
                sprintf('Argument "$ch" must be a valid resource type. %s given.', gettype($ch))
            );
        }

        $response = curl_exec($ch);

        if (!$response) {
            throw new \RuntimeException('Request failed');
        }

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            throw new \RuntimeException("Error {$response['error']['error_code']}: {$response['error']['error_msg']}");
        }

        return $response;
    }
}
