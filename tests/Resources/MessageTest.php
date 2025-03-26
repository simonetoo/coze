<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class MessageTest extends TestCase
{
    protected Coze $coze;

    protected string $conversationId;

    protected string $messageId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coze = Coze::fake();
        $this->conversationId = '7484881587176734755';
        $this->messageId = '7484881587176734756';

        // 为create方法设置模拟响应
        $createResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->messageId,
                'conversation_id' => $this->conversationId,
                'content' => 'Hello, world!',
                'content_type' => 'text',
                'role' => 'user',
                'type' => 'question',
                'created_at' => 1719371007,
            ],
        ];
        $this->coze->mock('/v1/conversation/message/create', $createResponse);

        // 为list方法设置模拟响应
        $listResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'messages' => [
                    [
                        'id' => $this->messageId,
                        'conversation_id' => $this->conversationId,
                        'content' => 'Hello, world!',
                        'content_type' => 'text',
                        'role' => 'user',
                        'type' => 'question',
                        'created_at' => 1719371007,
                    ],
                ],
                'total_count' => 1,
            ],
        ];
        $this->coze->mock('/v1/conversation/message/list', $listResponse);

        // 为get方法设置模拟响应
        $getResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->messageId,
                'conversation_id' => $this->conversationId,
                'content' => 'Hello, world!',
                'content_type' => 'text',
                'role' => 'user',
                'type' => 'question',
                'created_at' => 1719371007,
            ],
        ];
        $this->coze->mock('/v1/conversation/message/retrieve', $getResponse);

        // 为modify方法设置模拟响应
        $modifyResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->messageId,
                'conversation_id' => $this->conversationId,
                'content' => 'Updated message',
                'content_type' => 'text',
                'role' => 'user',
                'type' => 'question',
                'created_at' => 1719371007,
                'updated_at' => 1719371107,
            ],
        ];
        $this->coze->mock('/v1/conversation/message/modify', $modifyResponse);

        // 为delete方法设置模拟响应
        $deleteResponse = [
            'code' => 0,
            'msg' => 'Success',
        ];
        $this->coze->mock('/v1/conversation/message/delete', $deleteResponse);
    }

    public function test_create(): void
    {
        // 调用create方法
        $response = $this->coze->message()->create(
            $this->conversationId,
            'Hello, world!',
            'text',
            'user',
            'question'
        );

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->messageId, $response->json('data.id'));
        $this->assertEquals($this->conversationId, $response->json('data.conversation_id'));
        $this->assertEquals('Hello, world!', $response->json('data.content'));
        $this->assertEquals('text', $response->json('data.content_type'));
        $this->assertEquals('user', $response->json('data.role'));
        $this->assertEquals('question', $response->json('data.type'));
    }

    public function test_list(): void
    {
        // 调用list方法
        $response = $this->coze->message()->list($this->conversationId, [
            'page_num' => 1,
            'page_size' => 10,
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals(1, $response->json('data.total_count'));
        $this->assertCount(1, $response->json('data.messages'));
        $this->assertEquals($this->messageId, $response->json('data.messages.0.id'));
    }

    public function test_get(): void
    {
        // 调用get方法
        $response = $this->coze->message()->get($this->conversationId, $this->messageId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->messageId, $response->json('data.id'));
        $this->assertEquals($this->conversationId, $response->json('data.conversation_id'));
    }

    public function test_modify(): void
    {
        // 调用modify方法
        $response = $this->coze->message()->modify($this->messageId, [
            'content' => 'Updated message',
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->messageId, $response->json('data.id'));
        $this->assertEquals('Updated message', $response->json('data.content'));
    }

    public function test_delete(): void
    {
        // 调用delete方法
        $response = $this->coze->message()->delete($this->conversationId, $this->messageId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
    }
}
