<?php

namespace Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Resource;

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
    public function clone(string $name, array $payload = []): JsonResponse
    {
        $payload['voice_name'] = $name;

        return $this->client->postJson('/v1/audio/voices/clone', $payload);
    }
}
