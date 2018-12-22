**Guzzle HTTP Client**

Install for all dependencies;

```composer install```

Run for tests;

```./vendor/bin/phpunit src/tests --colors ```

Usage:

Initialize:

```
# HttpClient((string) username, (string) password', (array) options);
```

Example:

```
$options = ['timeout' => 120, 'headers' => [sprintf('Token %s', '...blablabla...']]
$client = new HttpClient('username', 'password', $options);
```

GET Request:

```
$response = $client->makeRequest('get', 'https:www/google.com/?q=guzzle');
```

POST Request:

```
$params = [
            'key' => 'value',
            'key2' => 'value2',
          ]
$response = $client->makeRequest('post', 'https:www/google.com/', $params);
```

Get Content:

```

$content = $response->getBody()->getContent();

```

