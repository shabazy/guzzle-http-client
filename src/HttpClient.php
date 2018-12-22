<?php

namespace GuzzleHttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Exception\ClientException;

class HttpClient {

	public $client;
	public $username;
	public $password;
	public $options;

	public function __construct($options = []) {

		$this->client   = new Client();
		$this->username = $options['username'];
		$this->password = $options['password'];
		$this->options  = [
			RequestOptions::AUTH => [$this->username, $this->password],
		];
	}

	public function setHeaders() {
		$this->options[RequestOptions::HEADERS] = ['Content-Type' => 'application/x-www-form-urlencoded'];
	}

	public function makeRequest($url, $method = 'get', $payload = []) {

		if (empty($url)) {
			throw new \Exception('URL not found');
		}

		if ($method == 'get' && !empty($payload)) {
			$url .= '?' . http_build_query($payload);
		} else if ($method == 'post') {
			$this->options[RequestOptions::FORM_PARAMS] = $payload;
			$this->setHeaders();
		}

		$method = strtolower($method);

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