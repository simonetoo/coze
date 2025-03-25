<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class ConversationTest extends TestCase
{
    protected Coze $coze;

    protected string $conversationId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coze = Coze::fake();
        $this->conversationId = '7484881587176734755';

        // 为create方法设置模拟响应
        $createResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->conversationId,
                'meta_data' => [
                    'custom_field' => 'test_value',
                ],
            ],
        ];
        $this->coze->mock('/v1/conversation/create', $createResponse);

        // 为get方法设置模拟响应
        $getResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->conversationId,
                'meta_data' => [
                    'custom_field' => 'test_value',
                ],
                'created_at' => 1719371007,
            ],
        ];
        $this->coze->mock('/v1/conversation/retrieve', $getResponse);

        // 为clearContext方法设置模拟响应
        $clearContextResponse = [
            'code' => 0,
            'msg' => 'Success',
        ];
        $this->coze->mock('/v1/conversation/clear_context', $clearContextResponse);

        // 为list方法设置模拟响应
        $listResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'conversations' => [
                    [
                        'id' => $this->conversationId,
                        'meta_data' => [
                            'custom_field' => 'test_value',
                        ],
                        'created_at' => 1719371007,
                    ],
                ],
                'total_count' => 1,
            ],
        ];
        $this->coze->mock('/v1/conversations', $listResponse);
    }

    public function test_create(): void
    {
        // 调用create方法
        $response = $this->coze->conversation()->create([
            'bot_id' => '7484523878849822754',
            'messages' => [
                [
                    'uuid' => 'test_uuid',
                    'role' => 'user',
                    'content' => '测试消息',
                ],
            ],
            'meta_data' => [
                'custom_field' => 'test_value',
            ],
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->conversationId, $response->json('data.id'));
    }

    public function test_get(): void
    {
        // 调用get方法
        $response = $this->coze->conversation()->get($this->conversationId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->conversationId, $response->json('data.id'));
    }

    public function test_clear_context(): void
    {
        // 调用clearContext方法
        $response = $this->coze->conversation()->clearContext($this->conversationId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_list(): void
    {
        // 调用list方法
        $response = $this->coze->conversation()->list([
            'page_num' => 1,
            'page_size' => 10,
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals(1, $response->json('data.total_count'));
        $this->assertCount(1, $response->json('data.conversations'));
    }
}
