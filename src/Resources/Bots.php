<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Bots extends Resource
{
    /**
     * 获取机器人列表
     *
     * @param  string  $spaceId  空间ID
     * @return JsonResponse 机器人列表数据
     *
     * @throws ApiException
     *
     * @see https://www.coze.cn/open/docs/developer_guides/published_bots_list
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
     * @return JsonResponse 机器人详情数据
     *
     * @throws ApiException 请求异常
     *
     * @see https://www.coze.cn/open/docs/developer_guides/get_metadata
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
     * @param  string  $description  机器人描述
     * @param  array  $payload  其他参数
     * @return JsonResponse 创建的机器人数据
     *
     * @throws ApiException 请求异常
     *
     * @see https://www.coze.cn/open/docs/developer_guides/create_bot
     */
    public function create(
        string $spaceId,
        string $name,
        string $description,
        array $payload = []
    ): JsonResponse {
        $payload['space_id'] = $spaceId;
        $payload['name'] = $name;
        $payload['description'] = $description;

        return $this->client->postJson('/v1/bot/create', $payload);
    }

    /**
     * 更新机器人
     *
     * @param  string  $botId  机器人ID
     * @param  array  $payload  其他参数
     * @return JsonResponse 更新后的机器人数据
     *
     * @throws ApiException 请求异常
     *
     * @see https://www.coze.cn/open/docs/developer_guides/update_bot
     */
    public function update(string $botId, array $payload = []): JsonResponse
    {
        $payload['bot_id'] = $botId;

        return $this->client->postJson('/v1/bot/update', $payload);
    }
}
