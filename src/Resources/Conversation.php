<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Conversation extends Resource
{
    /**
     * 创建一个会话。
     *
     * @param  array  $payload  可选参数
     *                          - bot_id: 机器人ID
     *                          - messages: 初始消息数组
     *                          - meta_data: 元数据
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/create_conversation
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_conversation
     */
    public function create(array $payload = []): JsonResponse
    {
        return $this->client->postJson('/v1/conversation/create', $payload);
    }

    /**
     * 获取指定会话的信息。
     *
     * @param  string  $conversationId  会话ID
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/retrieve_conversation
     * @see zh:https://www.coze.cn/open/docs/developer_guides/retrieve_conversation
     */
    public function get(string $conversationId): JsonResponse
    {
        return $this->client->get('/v1/conversation/retrieve', [
            'conversation_id' => $conversationId,
        ]);
    }

    /**
     * 清除指定会话的上下文。
     *
     * @param  string  $conversationId  会话ID
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/clear_conversation_context
     * @see zh:https://www.coze.cn/open/docs/developer_guides/clear_conversation_context
     */
    public function clearContext(string $conversationId): JsonResponse
    {
        return $this->client->post("/v1/conversations/{$conversationId}/clear");
    }

    /**
     * 获取指定机器人的会话列表。
     *
     * @param  array  $payload  可选参数
     *                          - page_num: 页码，默认为1
     *                          - page_size: 每页数量，默认为20
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/m7ub7lgc
     * @see zh:https://www.coze.cn/open/docs/developer_guides/m7ub7lgc
     */
    public function list(array $payload = []): JsonResponse
    {
        return $this->client->get('/v1/conversations', $payload);
    }
}
