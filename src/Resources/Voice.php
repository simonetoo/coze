<?php

namespace Simonetoo\Coze\Resources;

use GuzzleHttp\Psr7\Utils;
use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Voice extends Resource
{
    /**
     * 查看音色列表
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_voices
     * @see en:https://www.coze.com/open/docs/developer_guides/list_voices
     */
    public function list(): JsonResponse
    {
        return $this->client->get('/v1/audio/voices');
    }

    /**
     * 复刻音色
     *
     * @param  string  $name  此音色的名称，长度限制为 128 字节。
     * @param  array  $payload  其他参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/clone_voices
     * @see en:https://www.coze.com/open/docs/developer_guides/clone_voices
     */
    public function clone(string $name, string $path, array $payload = []): JsonResponse
    {
        if (! isset($payload['audio_format'])) {
            $payload['audio_format'] = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        }
        $payload['voice_name'] = $name;
        $parts = [
            [
                'name' => 'file',
                'contents' => Utils::tryFopen($path, 'r'),
                'filename' => basename($path),
            ],
        ];
        foreach ($payload as $key => $value) {
            $parts[] = [
                'name' => $key,
                'contents' => $value,
            ];
        }

        return $this->client->post('/v1/audio/voices/clone', [
            'multipart' => $parts,
        ]);
    }
}
