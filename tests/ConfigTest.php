<?php

namespace Simonetoo\Coze\Tests;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Config;

class ConfigTest extends TestCase
{
    private string $token = 'test_token';

    public function testConstructorWithDefaultOptions(): void
    {
        $config = new Config($this->token);

        $this->assertEquals($this->token, $config->getToken());
        $this->assertEquals('https://api.coze.cn', $config->getBaseUrl());
        $this->assertEquals(30, $config->getTimeout());
    }

    public function testConstructorWithCustomOptions(): void
    {
        $options = [
            'baseUrl' => 'https://custom-api.coze.cn',
            'timeout' => 60,
            'debug' => true,
            'allowPersonalAccessTokenInBrowser' => true,
        ];

        $config = new Config($this->token, $options);

        $this->assertEquals($this->token, $config->getToken());
        $this->assertEquals('https://custom-api.coze.cn', $config->getBaseUrl());
        $this->assertEquals(60, $config->getTimeout());
    }

    public function testGetToken(): void
    {
        $config = new Config($this->token);
        $this->assertEquals($this->token, $config->getToken());
    }

    public function testGetBaseUrl(): void
    {
        $config = new Config($this->token);
        $this->assertEquals('https://api.coze.cn', $config->getBaseUrl());

        $config = new Config($this->token, ['baseUrl' => 'https://custom-api.coze.cn']);
        $this->assertEquals('https://custom-api.coze.cn', $config->getBaseUrl());
    }

    public function testGetTimeout(): void
    {
        $config = new Config($this->token);
        $this->assertEquals(30, $config->getTimeout());

        $config = new Config($this->token, ['timeout' => 60]);
        $this->assertEquals(60, $config->getTimeout());
    }

}
