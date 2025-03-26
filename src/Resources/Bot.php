<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Bot extends Resource
{
    /**
     * 获取机器人列表
     *
     * @param  string  $spaceId  空间ID
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/published_bots_list
     * @see en:https://www.coze.com/open/docs/developer_guides/published_bots_list
     */
    public function list(string $spaceId, array $payload = []): JsonResponse
    {
        $payload['space_id'] = $spaceId;

        return $this->client->get('/v1/space/published_bots_list', $payload);
    }

    /**
     * 获取机器人详情
     *
     * @param  string  $botId  机器人ID
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_metadata
     * @see en:https://www.coze.cn/open/docs/developer_guides/get_metadata
     */
    public function get(string $botId): JsonResponse
    {
        return $this->client->get('/v1/bot/get_online_info', [
            'bot_id' => $botId,
        ]);
    }

    /**
     * 创建机器人
     *
     * @param  string  $spaceId  空间ID
     * @param  string  $name  机器人名称
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_bot
     * @see en:https://www.coze.com/open/docs/developer_guides/create_bot
     */
    public function create(string $spaceId, string $name, array $payload = []): JsonResponse
    {
        $payload['space_id'] = $spaceId;
        $payload['name'] = $name;

        return $this->client->postJson('/v1/bot/create', $payload);
    }

    /**
     * 更新机器人
     *
     * @param  string  $botId  机器人ID
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/update_bot
     * @see en:https://www.coze.com/open/docs/developer_guides/update_bot
     */
    public function update(string $botId, array $payload = []): JsonResponse
    {
        $payload['bot_id'] = $botId;

        return $this->client->postJson('/v1/bot/update', $payload);
    }
}
