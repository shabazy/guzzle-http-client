<?php

namespace GuzzleHttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;

/**
 * Class HttpClient
 * @package GuzzleHttpClient
 */
class HttpClient
{

    public $client;
    public $username;
    public $password;
    public $options;

    /**
     * HttpClient constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->client = new Client();
        $this->username = $options['username'];
        $this->password = $options['password'];
        $this->options = [
            RequestOptions::AUTH => [$this->username, $this->password],
        ];
    }

    /**
     * @param array $option
     * @return $this
     */
    public function addOption(array $option)
    {
        $this->options = $option;

        return $this;
    }

    /**
     * @param $url
     * @param string $method
     * @param array $payload
     * @return \Psr\Http\Message\ResponseInterface|null
     * @throws \Exception
     */
    public function makeRequest(string $method, string $url, $payload = [])
    {
        if (empty($url)) {
            throw new \Exception('URL not found');
        }

        $method = strtolower($method);

        if ($method == 'get' && !empty($payload)) {
            $url .= '?' . http_build_query($payload);
        } else if (in_array($method, ['post', 'put', 'delete'])) {
            $this->options[RequestOptions::JSON] = $payload;
        } else {
            throw new \Exception('Method not found.');
        }

        try {
            $response = $this->client->$method($url, $this->options);
        } catch (ClientException $e) {
            $response = $e->getResponse();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

        return $response;
    }
}