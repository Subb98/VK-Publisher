<?php

namespace VkPublisher\Traits;

trait HttpTrait
{
    /**
     * Sends HTTP request
     *
     * @param string $url URL
     * @param array $params Request parameters (CURLOPT_POSTFIELDS)
     * @param array $curl_options cURL options (CURLOPT_* array)
     * @throws \InvalidArgumentException if $url param is not a valid URL
     * @return array
     */
    protected function httpRequest(string $url, array $params = [], array $curl_options = []): array
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException(
                sprintf('Argument "$url" must be a valid URL. "%s" given.', $url)
            );
        }

        $ch = curl_init($url);

        if (!array_key_exists(CURLOPT_RETURNTRANSFER, $curl_options)) {
            $curl_options[CURLOPT_RETURNTRANSFER] = true;
        }

        if (!array_key_exists(CURLOPT_SSL_VERIFYPEER, $curl_options)) {
            $curl_options[CURLOPT_SSL_VERIFYPEER] = false;
        }

        if (!array_key_exists(CURLOPT_SSL_VERIFYHOST, $curl_options)) {
            $curl_options[CURLOPT_SSL_VERIFYHOST] = false;
        }

        curl_setopt_array($ch, $curl_options);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);

        $response = $this->getResponse($ch);
        curl_close($ch);

        return $response;
    }

    /**
     * Gets cURL response
     *
     * @param \resource $ch
     * @throws \InvalidArgumentException if $ch param is not a resource
     * @throws \Exception if request failed
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
            throw new \Exception('Request failed');
        }

        $response = json_decode($response, true);

        if (isset($response['error'])) {
            throw new \Exception("Error {$response['error']['error_code']}: {$response['error']['error_msg']}");
        }

        return $response;
    }
}
