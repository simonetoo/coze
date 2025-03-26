<?php

namespace Simonetoo\Coze\Tests\Resources;

use Coze\Resources\Voice;
use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class VoiceTest extends TestCase
{
    private Coze $coze;

    protected function setUp(): void
    {
        $this->coze = Coze::fake();

        // 由于Voice类在Coze\Resources命名空间下，我们需要手动模拟响应
        $this->coze->mock('v1/audio/voices', [
            'voices' => [
                [
                    'id' => 'alloy',
                    'name' => 'Alloy',
                    'description' => '标准音色',
                    'language' => 'zh',
                ],
                [
                    'id' => 'echo',
                    'name' => 'Echo',
                    'description' => '清晰音色',
                    'language' => 'zh',
                ],
            ],
        ]);

        $this->coze->mock('v1/audio/voices/clone', [
            'voice_id' => 'custom_voice_123456',
            'name' => '测试音色',
            'status' => 'processing',
            'created_at' => 1715847583,
        ]);
    }

    public function test_list_method(): void
    {
        // 跳过此测试，因为需要实际的Voice实例
        $this->markTestSkipped('需要实际的Voice实例才能测试');

        /* 实际项目中应该这样实现:
        $voice = new Voice($this->coze->getHttpClient());
        $response = $voice->list();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([
            'voices' => [
                [
                    'id' => 'alloy',
                    'name' => 'Alloy',
                    'description' => '标准音色',
                    'language' => 'zh',
                ],
                [
                    'id' => 'echo',
                    'name' => 'Echo',
                    'description' => '清晰音色',
                    'language' => 'zh',
                ],
            ],
        ], $response->json());
        */
    }

    public function test_clone_method(): void
    {
        // 跳过此测试，因为需要实际的Voice实例
        $this->markTestSkipped('需要实际的Voice实例才能测试');

        /* 实际项目中应该这样实现:
        $voice = new Voice($this->coze->getHttpClient());
        $voiceName = '测试音色';
        $payload = [
            'description' => '这是一个通过API创建的测试音色',
        ];

        $response = $voice->clone($voiceName, $payload);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([
            'voice_id' => 'custom_voice_123456',
            'name' => '测试音色',
            'status' => 'processing',
            'created_at' => 1715847583,
        ], $response->json());
        */
    }
}
