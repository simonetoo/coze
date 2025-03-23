<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Bot;

class BotTest extends TestCase
{
    private Coze $coze;

    private Bot $bots;

    private string $spaceId = '7484524201249194023';

    private string $botId = '7484523878849822754';

    protected function setUp(): void
    {
        $this->coze = Coze::fake();
        $this->bots = $this->coze->bot();
    }

    public function test_list_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => 0,
            'data' => [
                [
                    'bot_id' => $this->botId,
                    'bot_name' => 'testbot',
                    'description' => 'Test bot description',
                    'icon_url' => 'https://example.com/icon.png',
                    'publish_time' => '1719371007',
                ],
            ],
        ];

        // 模拟HTTP响应
        $this->coze->mock('v1/bots', $responseData);

        // 调用list方法
        $response = $this->bots->list($this->spaceId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());

        // 测试带有额外参数的情况
        $this->coze->mock('v1/bots', $responseData);
        $response = $this->bots->list($this->spaceId, ['page' => 1, 'limit' => 10]);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_get_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'bot_id' => $this->botId,
            'bot_name' => 'testbot',
            'description' => 'Test bot description',
            'icon_url' => 'https://example.com/icon.png',
            'publish_time' => '1719371007',
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/bots/{$this->botId}", $responseData);

        // 调用get方法
        $response = $this->bots->get($this->botId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_create_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'bot_id' => $this->botId,
            ],
        ];

        // 模拟HTTP响应
        $this->coze->mock('v1/bots', $responseData);

        // 调用create方法
        $name = 'New Test Bot';
        $description = 'This is a test bot created via API';
        $response = $this->bots->create($this->spaceId, $name, $description);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());

        // 测试带有额外参数的情况
        $this->coze->mock('v1/bots', $responseData);
        $response = $this->bots->create(
            $this->spaceId,
            $name,
            $description,
            ['avatar' => 'https://example.com/avatar.png']
        );
        $this->assertEquals($responseData, $response->json());
    }

    public function test_update_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => '',
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/bots/{$this->botId}", $responseData);

        // 调用update方法
        $payload = [
            'name' => 'Updated Bot Name',
            'description' => 'Updated bot description',
        ];
        $response = $this->bots->update($this->botId, $payload);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }
}
