<?php

namespace Simonetoo\Coze\Tests\Resources;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class AudioTest extends TestCase
{
    private Coze $coze;

    protected function setUp(): void
    {
        $this->coze = Coze::fake();

        // 由于Audio类在Coze\Resources命名空间下，我们需要手动创建实例
        $this->coze->mock('v1/audio/speech', function () {
            return new Response(200, [], '');
        });
        $this->coze->mock('v1/audio/transcriptions', [
            'text' => '这是从音频文件中识别出的文本内容。',
            'duration' => 5.2,
            'language' => 'zh',
        ]);
    }

    public function test_speech(): void
    {
        // 跳过此测试，因为需要实际的Audio实例
        $response = $this->coze->audio()->speech('7468518753626800165', '这是从音频文件中识别出的文本内容');
        $this->assertInstanceOf(ResponseInterface::class, $response);
    }

    public function test_transcription(): void
    {

        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'data' => [
                'text' => '测试文本',
            ],
        ];

        // 模拟HTTP响应
        $this->coze->mock('/v1/audio/transcriptions', $responseData);

        // 调用get方法
        $response = $this->coze->audio()->transcription('/path/to/audio.mp3');

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }
}
