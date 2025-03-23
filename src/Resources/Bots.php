<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Bots extends Resource
{
    /**
     * 获取机器人列表
     *
     * @param string $spaceId 空间ID
     * @param array $payload 其他可选参数
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/published_bots_list
     */
    public function list(string $spaceId, array $payload = []): JsonResponse
    public function list(string $spaceId, array $payload = []): JsonResponse
    {
        $payload['space_id'] = $spaceId;
        
        return $this->client->get('/v1/bots', $payload);
    }

    /**
     * 获取机器人详情
     *
     * @param string $botId 机器人ID
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/get_metadata
     */
    public function get(string $botId): JsonResponse
    {
        return $this->client->get("/v1/bots/{$botId}");
    }

    /**
     * 创建机器人
     *
     * @param string $spaceId 空间ID
     * @param string $name 机器人名称
     * @param string $description 机器人描述
     * @param array $payload 其他可选参数
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/create_bot
     */
    public function create(string $spaceId, string $name, string $description, array $payload = []): JsonResponse
    {
        $payload['space_id'] = $spaceId;
        $payload['name'] = $name;
        $payload['description'] = $description;
        
        return $this->client->postJson('/v1/bots', $payload);
    }

    /**
     * 更新机器人
     *
     * @param string $botId 机器人ID
     * @param string $name 机器人名称
     * @param array $payload 其他可选参数
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/update_bot
     */
    public function update(string $botId, string $name, array $payload = []): JsonResponse
    {
        $payload['name'] = $name;
        
        return $this->client->patchJson("/v1/bots/{$botId}", $payload);
    }
}
