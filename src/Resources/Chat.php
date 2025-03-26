<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Chat extends Resource
{
    /**
     * 发送消息到机器人并获取回复
     *
     * @param  string  $botId  机器人ID
     * @param  string  $userId  用户ID
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/chat_v3
     * @see en:https://www.coze.com/open/docs/developer_guides/chat_v3
     */
    public function chat(string $botId, string $userId, array $payload = []): JsonResponse
    {
        $payload['bot_id'] = $botId;
        $payload['user_id'] = $userId;

        return $this->client->postJson('/v3/chat', $payload);
    }

    /**
     * 获取聊天详细信息
     *
     * @param  string  $chatId  聊天ID
     * @param  string  $conversationId  会话ID
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/retrieve_chat
     * @see en:https://www.coze.com/open/docs/developer_guides/retrieve_chat
     */
    public function retrieve(string $chatId, string $conversationId): JsonResponse
    {
        return $this->client->get('/v3/chat/retrieve', [
            'chat_id' => $chatId,
            'conversation_id' => $conversationId,
        ]);
    }

    /**
     * 获取聊天消息列表
     *
     * @param  array  $payload  查询参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_chat_messages
     * @see en:https://www.coze.com/open/docs/developer_guides/list_chat_messages
     */
    public function listMessages(array $payload): JsonResponse
    {
        return $this->client->get('/v3/chat/message/list', $payload);
    }

    /**
     * 提交工具执行结果
     *
     * @param  array  $payload  工具执行结果参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/chat_submit_tool_outputs
     * @see en:https://www.coze.com/open/docs/developer_guides/chat_submit_tool_outputs
     */
    public function submitToolOutputs(array $payload): JsonResponse
    {
        return $this->client->postJson('/v3/chat/submit_tool_outputs', $payload);
    }

    /**
     * 取消正在进行的聊天
     *
     * @param  string  $chatId  聊天ID
     * @param  string  $conversationId  会话ID
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/chat_cancel
     * @see en:https://www.coze.com/open/docs/developer_guides/chat_cancel
     */
    public function cancel(string $chatId, string $conversationId): JsonResponse
    {
        return $this->client->postJson('/v3/chat/cancel', [
            'chat_id' => $chatId,
            'conversation_id' => $conversationId,
        ]);
    }
}
