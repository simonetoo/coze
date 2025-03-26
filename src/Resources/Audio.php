<?php

namespace Coze\Resources;

use Psr\Http\Message\ResponseInterface;
use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Resource;

class Audio extends Resource
{
    /**
     * 语音合成
     *
     * @param  string  $voiceId  音色ID
     * @param  string  $input  合成语音的文本
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/text_to_speech
     * @see en:https://www.coze.com/open/docs/developer_guides/text_to_speech
     */
    public function speech(string $voiceId, string $input, array $payload = []): ResponseInterface
    {
        $payload['voice_id'] = $voiceId;
        $payload['input'] = $input;

        return $this->client->request('POST', '/v1/audio/speech', [
            'json' => $payload,
        ]);
    }

    /**
     * 语音识别
     *
     * @param  string  $path  语音文件路径
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/audio_transcriptions
     * @see en:https://www.coze.com/open/docs/developer_guides/audio_transcriptions
     */
    public function transcription(string $path): JsonResponse
    {

        return $this->client->post('/v1/audio/transcriptions', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($path, 'r'),
                ],
            ],
        ]);
    }
}
