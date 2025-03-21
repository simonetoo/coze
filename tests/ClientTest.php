<?php

namespace Simonetoo\Coze\Tests;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Config;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\HttpClient;

class ClientTest extends TestCase
{
    private string $token = 'test_token';

    private Coze $client;

    protected function setUp(): void
    {
        $this->client = new Coze($this->token);
    }

    public function test_constructor(): void
    {
        $this->assertInstanceOf(Coze::class, $this->client);
        $this->assertInstanceOf(Config::class, $this->client->getConfig());
        $this->assertInstanceOf(HttpClient::class, $this->client->getHttpClient());
    }

    public function test_get_config(): void
    {
        $config = $this->client->getConfig();
        $this->assertInstanceOf(Config::class, $config);
        $this->assertEquals($this->token, $config->getToken());
    }

    public function test_get_http_client(): void
    {
        $httpClient = $this->client->getHttpClient();
        $this->assertInstanceOf(HttpClient::class, $httpClient);
    }
}
