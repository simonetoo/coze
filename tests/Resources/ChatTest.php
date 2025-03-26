<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class ChatTest extends TestCase
{
    protected Coze $coze;

    protected string $chatId;

    protected string $conversationId;

    protected string $botId;

    protected string $userId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coze = Coze::fake();
        $this->chatId = '7398048669188123456';
        $this->conversationId = '7397787494399123456';
        $this->botId = '7379462189365198898';
        $this->userId = 'test_user_123';

        // 为chat方法设置模拟响应
        $chatResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->chatId,
                'conversation_id' => $this->conversationId,
                'bot_id' => $this->botId,
                'status' => 'completed',
                'created_at' => 1719371007,
                'completed_at' => 1719371010,
                'token_count' => 298,
                'input_tokens' => 242,
                'output_tokens' => 56,
            ],
        ];
        $this->coze->mock('/v3/chat', $chatResponse);

        // 为retrieve方法设置模拟响应
        $retrieveResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->chatId,
                'conversation_id' => $this->conversationId,
                'bot_id' => $this->botId,
                'status' => 'completed',
                'created_at' => 1719371007,
                'completed_at' => 1719371010,
                'token_count' => 298,
                'input_tokens' => 242,
                'output_tokens' => 56,
                'meta_data' => [],
            ],
        ];
        $this->coze->mock('/v3/chat/retrieve', $retrieveResponse);

        // 为listMessages方法设置模拟响应
        $listMessagesResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'messages' => [
                    [
                        'id' => '738216760624724123',
                        'role' => 'assistant',
                        'content' => '这是一条测试消息',
                        'content_type' => 'text',
                        'conversation_id' => $this->conversationId,
                        'bot_id' => $this->botId,
                        'type' => 'answer',
                    ],
                    [
                        'id' => '738216762080970123',
                        'role' => 'assistant',
                        'content' => '{"msg_type":"generate_answer_finish","data":"","from_module":null,"from_unit":null}',
                        'content_type' => 'text',
                        'conversation_id' => $this->conversationId,
                        'bot_id' => $this->botId,
                        'type' => 'verbose',
                    ],
                ],
            ],
        ];
        $this->coze->mock('/v3/chat/message/list', $listMessagesResponse);

        // 为submitToolOutputs方法设置模拟响应
        $submitToolOutputsResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->chatId,
                'conversation_id' => $this->conversationId,
                'bot_id' => $this->botId,
                'status' => 'completed',
            ],
        ];
        $this->coze->mock('/v3/chat/submit_tool_outputs', $submitToolOutputsResponse);

        // 为cancel方法设置模拟响应
        $cancelResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'id' => $this->chatId,
                'token_count' => 298,
                'input_count' => 242,
                'output_count' => 56,
            ],
        ];
        $this->coze->mock('/v3/chat/cancel', $cancelResponse);
    }

    public function test_chat(): void
    {
        // 调用chat方法
        $response = $this->coze->chat()->chat($this->botId, $this->userId, [
            'query' => '你好，这是一个测试',
            'conversation_id' => $this->conversationId,
            'auto_save_history' => true,
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->chatId, $response->json('data.id'));
        $this->assertEquals($this->conversationId, $response->json('data.conversation_id'));
        $this->assertEquals($this->botId, $response->json('data.bot_id'));
    }

    public function test_retrieve(): void
    {
        // 调用retrieve方法
        $response = $this->coze->chat()->retrieve($this->conversationId, $this->chatId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->chatId, $response->json('data.id'));
        $this->assertEquals($this->conversationId, $response->json('data.conversation_id'));
        $this->assertEquals('completed', $response->json('data.status'));
    }

    public function test_list_messages(): void
    {
        // 调用listMessages方法
        $response = $this->coze->chat()->listMessages($this->conversationId, $this->chatId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertCount(2, $response->json('data.messages'));
        $this->assertEquals($this->conversationId, $response->json('data.messages.0.conversation_id'));
    }

    public function test_submit_tool_outputs(): void
    {
        // 调用submitToolOutputs方法
        $response = $this->coze->chat()->submitToolOutputs($this->conversationId, $this->chatId, [
            [
                'tool_call_id' => 'tool_call_123',
                'output' => '{"result": "success"}',
            ],
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->chatId, $response->json('data.id'));
        $this->assertEquals($this->conversationId, $response->json('data.conversation_id'));
    }

    public function test_cancel(): void
    {
        // 调用cancel方法
        $response = $this->coze->chat()->cancel($this->conversationId, $this->chatId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals($this->chatId, $response->json('data.id'));
        $this->assertEquals(298, $response->json('data.token_count'));
    }
}
