<?php

namespace Simonetoo\Coze\Tests\Resources;

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

    public function test_list(): void
    {
        $responseData = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'voice_list' => [
                    [
                        'voice_id' => 'alloy',
                        'name' => 'Alloy',
                        'description' => '标准音色',
                        'language' => 'zh',
                    ],
                    [
                        'voice_id' => 'echo',
                        'name' => 'Echo',
                        'description' => '清晰音色',
                        'language' => 'zh',
                    ],
                ],

            ],
        ];
        $this->coze->mock('v1/audio/voices', $responseData);
        $response = $this->coze->voice()->list();
        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_clone(): void
    {
        $responseData = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'voice_id' => '7486015075111862326',
            ],
        ];
        $this->coze->mock('v1/audio/voices/clone', $responseData);
        $response = $this->coze->voice()->clone('test', '/path/to/voice.mp3');
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }
}
