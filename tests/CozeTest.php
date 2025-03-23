<?php

namespace Simonetoo\Coze\Tests;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\HttpClient;

class CozeTest extends TestCase
{
    private string $token = 'test_token';

    private Coze $client;

    protected function setUp(): void
    {
        $this->client = new Coze([
            'token' => $this->token,
        ]);
    }

    public function test_constructor(): void
    {
        $this->assertInstanceOf(Coze::class, $this->client);
        $this->assertInstanceOf(HttpClient::class, $this->client->getHttpClient());
    }

    public function test_get_http_client(): void
    {
        $httpClient = $this->client->getHttpClient();
        $this->assertInstanceOf(HttpClient::class, $httpClient);
    }
}
