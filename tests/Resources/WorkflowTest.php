<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Http\StreamResponse;
use Simonetoo\Coze\Resources\Workflow;

class WorkflowTest extends TestCase
{
    private Coze $coze;

    private Workflow $workflow;

    private string $workflowId = '7350583675492300';

    private string $executeId = '7441022717041400';

    protected function setUp(): void
    {
        $this->coze = Coze::fake();
        $this->workflow = $this->coze->workflow();
    }

    public function test_run(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => 'Success',
            'data' => '{"output":"Beijing: altitude 116.4074°E，latitude 39.9042°N。"}',
            'debug_url' => 'https://www.coze.com/work_flow?execute_id=741364789030728&space_id=736142423532160&workflow_id=738958910358870',
        ];

        // 模拟HTTP响应
        $this->coze->mock('v1/workflow/run', $responseData);

        // 调用run方法
        $response = $this->workflow->run($this->workflowId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());

        // 测试带有额外参数的情况
        $this->coze->mock('v1/workflow/run', $responseData);
        $parameters = [
            'user_id' => '12345',
            'user_name' => 'George',
        ];
        $response = $this->workflow->run($this->workflowId, ['parameters' => $parameters]);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_stream(): void
    {
        // 模拟响应数据
        $chunks = [
            'data: {"content":"msg","node_is_finish":false,"node_seq_id":"0","node_title":"Message"}',
            'data: {"content":"Why","node_is_finish":false,"node_seq_id":"1","node_title":"Message"}',
            'data: {"content":"Why don\'t scientists trust atoms?\\nBecause","node_is_finish":false,"node_seq_id":"2","node_title":"Message"}',
            'data: {"content":"they make","node_is_finish":false,"node_seq_id":"3","node_title":"Message"}',
            'data: {"content":" up everything!","node_is_finish":true,"node_seq_id":"4","node_title":"Message"}',
            'data: {"content":"{\\"output\\":\\"Why don\'t scientists trust atoms?\\\\nBecause they make up everything!\\"}","cost":"0.00","node_is_finish":true,"node_seq_id":"0","node_title":"","token":0}',
            'data: {"debug_url":"https://www.coze.com/work_flow?execute_id=744119270952162&space_id=743984899418202&workflow_id=743985075059477"}',
        ];

        // 模拟HTTP响应
        $streamResponse = $this->coze->stream($chunks);
        $this->coze->mock('v1/workflow/stream_run', $streamResponse);

        // 调用streamRun方法
        $response = $this->workflow->stream($this->workflowId);

        // 验证响应
        $this->assertInstanceOf(StreamResponse::class, $response);

        // 测试带有额外参数的情况
        $this->coze->mock('v1/workflow/stream_run', $streamResponse);
        $parameters = [
            'user_id' => '12345',
            'user_name' => 'George',
        ];
        $response = $this->workflow->stream($this->workflowId, ['parameters' => $parameters]);
        $this->assertInstanceOf(StreamResponse::class, $response);
    }

    public function test_resume(): void
    {
        // 模拟响应数据
        $chunks = [
            'data: {"content":"{\\"output\\":[{\\"condition\\":\\"Rain\\",\\"humidity\\":72,\\"predict_date\\":\\"2024-08-20\\",\\"temp_high\\":35,\\"temp_low\\":26,\\"weather_day\\":\\"Rain\\",\\"wind_dir_day\\":\\"wind\\",\\"wind_dir_night\\":\\"wind\\",\\"wind_level_day\\":\\"3\\",\\"wind_level_night\\":\\"3\\"}]}","content_type":"text","cost":"0","node_is_finish":true,"node_seq_id":"0","node_title":"End","token":386}',
        ];

        // 模拟HTTP响应
        $streamResponse = $this->coze->stream($chunks);
        $this->coze->mock('v1/workflow/stream_resume', $streamResponse);

        // 调用resume方法
        $answer = 'Beijing';
        $response = $this->workflow->resume($this->executeId, $answer);

        // 验证响应
        $this->assertInstanceOf(StreamResponse::class, $response);

        // 测试带有额外参数的情况
        $this->coze->mock('v1/workflow/stream_resume', $streamResponse);
        $response = $this->workflow->resume($this->executeId, $answer, ['additional_param' => 'value']);
        $this->assertInstanceOf(StreamResponse::class, $response);
    }

    public function test_chat(): void
    {
        // 模拟响应数据
        $chunks = [
            'event: conversation.chat.created',
            'data: {"id":"120","conversation_id":"456","created_at":1733407180,"last_error":{"code":0,"msg":""},"status":"created","usage":{"token_count":0,"output_count":0,"input_count":0},"section_id":"789"}',
            'event: conversation.chat.in_progress',
            'data: {"id":"121","conversation_id":"456","created_at":1733407180,"last_error":{"code":0,"msg":""},"status":"in_progress","usage":{"token_count":0,"output_count":0,"input_count":0},"section_id":"789"}',
            'event: conversation.message.delta',
            'data: {"id":"122","conversation_id":"456","role":"assistant","type":"answer","content":"What did you eat for lunch","content_type":"text","chat_id":"567","section_id":"789","created_at":1733407182}',
            'event: conversation.message.completed',
            'data: {"id":"124","conversation_id":"456","role":"assistant","type":"answer","content":"What did you eat for lunch","content_type":"text","chat_id":"567","section_id":"789","created_at":1733407182}',
        ];

        // 模拟HTTP响应
        $streamResponse = $this->coze->stream($chunks);
        $this->coze->mock('v1/workflow/chat', $streamResponse);

        // 调用chat方法
        $messages = [
            [
                'role' => 'user',
                'content' => 'Hello, how are you?',
            ],
        ];
        $response = $this->workflow->chat($this->workflowId, [
            'bot_id' => '7484523878849822754',
            'additional_messages' => $messages,
        ]);

        // 验证响应
        $this->assertInstanceOf(StreamResponse::class, $response);
    }
}
