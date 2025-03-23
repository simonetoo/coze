<?php

namespace Simonetoo\Coze\Tests;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Resources\Bots;

class BotsTest extends TestCase
{
    private Coze $client;

    protected function setUp(): void
    {
        $this->client = Coze::fake([
            'token' => 'test_token',
        ]);
    }

    public function test_bots_instance(): void
    {
        $bots = $this->client->bots();
        $this->assertInstanceOf(Bots::class, $bots);
    }

    public function test_list_bots(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bots' => [
                    [
                        'bot_id' => 'bot_123',
                        'name' => 'Test Bot 1',
                        'description' => 'This is a test bot',
                    ],
                    [
                        'bot_id' => 'bot_456',
                        'name' => 'Test Bot 2',
                        'description' => 'This is another test bot',
                    ],
                ],
                'total' => 2,
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/space/published_bots_list', $responseData);

        // 调用list方法
        $response = $this->client->bots()->list('space_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertCount(2, $response->json('data.bots'));
        $this->assertEquals('bot_123', $response->json('data.bots.0.bot_id'));
        $this->assertEquals('Test Bot 1', $response->json('data.bots.0.name'));
    }

    public function test_list_bots_with_pagination(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bots' => [
                    [
                        'bot_id' => 'bot_789',
                        'name' => 'Test Bot 3',
                        'description' => 'This is a test bot on page 2',
                    ],
                ],
                'total' => 3,
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/space/published_bots_list', $responseData);

        // 调用list方法，带分页参数
        $response = $this->client->bots()->list('space_123', [
            'page_index' => 2,
            'page_size' => 1
        ]);

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertCount(1, $response->json('data.bots'));
        $this->assertEquals('bot_789', $response->json('data.bots.0.bot_id'));
    }

    public function test_get_bot(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bot_id' => 'bot_123',
                'name' => 'Test Bot 1',
                'description' => 'This is a test bot',
                'created_at' => '2023-01-01T00:00:00Z',
                'updated_at' => '2023-01-02T00:00:00Z',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/bot/get_online_info', $responseData);

        // 调用get方法
        $response = $this->client->bots()->get('bot_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('bot_123', $response->json('data.bot_id'));
        $this->assertEquals('Test Bot 1', $response->json('data.name'));
        $this->assertEquals('This is a test bot', $response->json('data.description'));
    }

    public function test_create_bot(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bot_id' => 'new_bot_123',
                'name' => 'New Test Bot',
                'description' => 'This is a newly created test bot',
                'created_at' => '2023-01-03T00:00:00Z',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/bot/create', $responseData);

        // 调用create方法
        $response = $this->client->bots()->create(
            'space_123',
            'New Test Bot',
            'This is a newly created test bot'
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('new_bot_123', $response->json('data.bot_id'));
        $this->assertEquals('New Test Bot', $response->json('data.name'));
    }

    public function test_create_bot_with_additional_payload(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bot_id' => 'new_bot_456',
                'name' => 'Advanced Bot',
                'description' => 'This is an advanced bot with additional settings',
                'created_at' => '2023-01-04T00:00:00Z',
                'settings' => [
                    'language' => 'zh-CN',
                    'visibility' => 'public',
                ],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/bot/create', $responseData);

        // 准备额外的payload数据
        $additionalPayload = [
            'settings' => [
                'language' => 'zh-CN',
                'visibility' => 'public',
            ],
        ];

        // 调用create方法，带额外payload
        $response = $this->client->bots()->create(
            'space_123',
            'Advanced Bot',
            'This is an advanced bot with additional settings',
            $additionalPayload
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('new_bot_456', $response->json('data.bot_id'));
        $this->assertEquals('zh-CN', $response->json('data.settings.language'));
        $this->assertEquals('public', $response->json('data.settings.visibility'));
    }

    public function test_update_bot(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bot_id' => 'bot_123',
                'name' => 'Updated Bot Name',
                'description' => 'This is a test bot',
                'updated_at' => '2023-01-05T00:00:00Z',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/bot/update', $responseData);

        // 调用update方法
        $response = $this->client->bots()->update('bot_123', 'Updated Bot Name');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('bot_123', $response->json('data.bot_id'));
        $this->assertEquals('Updated Bot Name', $response->json('data.name'));
    }

    public function test_update_bot_with_additional_payload(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'bot_id' => 'bot_123',
                'name' => 'Updated Bot Name',
                'description' => 'Updated description',
                'updated_at' => '2023-01-06T00:00:00Z',
                'settings' => [
                    'visibility' => 'private',
                ],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/bot/update', $responseData);

        // 准备额外的payload数据
        $additionalPayload = [
            'description' => 'Updated description',
            'settings' => [
                'visibility' => 'private',
            ],
        ];

        // 调用update方法，带额外payload
        $response = $this->client->bots()->update(
            'bot_123',
            'Updated Bot Name',
            $additionalPayload
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('bot_123', $response->json('data.bot_id'));
        $this->assertEquals('Updated Bot Name', $response->json('data.name'));
        $this->assertEquals('Updated description', $response->json('data.description'));
        $this->assertEquals('private', $response->json('data.settings.visibility'));
    }
}
