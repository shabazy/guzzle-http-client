<?php

namespace GuzzleHttpClientTest;

use GuzzleHttpClient\HttpClient;
use PHPUnit\Framework\TestCase;

class HttpClientTest extends TestCase {

	public function testGetRequest() {
		$client = new HttpClient();
		$response = $client->makeRequest('https://www.google.com/');
		$this->assertEquals(200, $response->getStatusCode());
	}

	public function testGetErrorRequest() {
		$client = new HttpClient();
		$response = $client->makeRequest('http://www.google.com/daddsa');
		$this->assertEquals(404, $response->getStatusCode());
	}

	public function testPostRequest() {
		$client = new HttpClient();
		$response = $client->makeRequest('https://www.google.com/', 'post', ['key' => 'value']);
		$this->assertEquals(405, $response->getStatusCode());
	}

}