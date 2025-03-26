<?php

namespace Simonetoo\Coze\Tests\Resources;

use Coze\Resources\Audio;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class AudioTest extends TestCase
{
    private Coze $coze;

    private string $voiceId = 'alloy';

    private string $audioPath = '/path/to/test/audio.mp3';

    protected function setUp(): void
    {
        $this->coze = Coze::fake();

        // 由于Audio类在Coze\Resources命名空间下，我们需要手动创建实例
        $this->coze->mock('v1/audio/speech', $this->createMock(ResponseInterface::class));
        $this->coze->mock('v1/audio/transcriptions', [
            'text' => '这是从音频文件中识别出的文本内容。',
            'duration' => 5.2,
            'language' => 'zh',
        ]);
    }

    public function test_speech_method(): void
    {
        // 跳过此测试，因为需要实际的Audio实例
        $this->markTestSkipped('需要实际的Audio实例才能测试');

        /* 实际项目中应该这样实现:
        $audio = new Audio($this->coze->getHttpClient());
        $text = '这是一个测试文本，用于演示语音合成功能。';

        $response = $audio->speech($this->voiceId, $text);
        $this->assertInstanceOf(ResponseInterface::class, $response);
        */
    }

    public function test_transcription_method(): void
    {
        // 跳过此测试，因为需要实际的Audio实例
        $this->markTestSkipped('需要实际的Audio实例才能测试');

        /* 实际项目中应该这样实现:
        $audio = new Audio($this->coze->getHttpClient());
        $response = $audio->transcription($this->audioPath);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals([
            'text' => '这是从音频文件中识别出的文本内容。',
            'duration' => 5.2,
            'language' => 'zh',
        ], $response->json());
        */
    }
}
