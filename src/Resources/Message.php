<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Message extends Resource
{
    /**
     * 创建消息。
     *
     * @param  string  $conversationId  会话ID
     * @param  string  $content  消息内容
     * @param  string  $contentType  消息类型，可选值：text, object_string
     * @param  string  $role  角色，可选值：user, assistant
     * @param  string  $type  消息类型，可选值：question, answer, function_call, tool_output, tool_response
     * @param  array  $payload  可选参数
     *                          - meta_data: 元数据，Map<String,String>格式
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/create_message
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_message
     */
    public function create(
        string $conversationId,
        string $content,
        string $contentType,
        string $role,
        string $type,
        array $payload = []
    ): JsonResponse {
        return $this->client->postJson('/v1/conversation/message/create?conversation_id='.$conversationId, [
            'role' => $role,
            'content' => $content,
            'content_type' => $contentType,
            'type' => $type,
            ...$payload,
        ]);
    }

    /**
     * 获取消息列表。
     *
     * @param  string  $conversationId  会话ID
     * @param  array  $payload  可选参数
     *                          - page_num: 页码，默认为1
     *                          - page_size: 每页数量，默认为20
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/list_message
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_message
     */
    public function list(string $conversationId, array $payload = []): JsonResponse
    {
        return $this->client->get('/v1/conversation/message/list', [
            'conversation_id' => $conversationId,
            ...$payload,
        ]);
    }

    /**
     * 获取消息详情。
     *
     * @param  string  $conversationId  会话ID
     * @param  string  $messageId  消息ID
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/retrieve_message
     * @see zh:https://www.coze.cn/open/docs/developer_guides/retrieve_message
     */
    public function get(string $conversationId, string $messageId): JsonResponse
    {
        return $this->client->get('/v1/conversation/message/retrieve', [
            'conversation_id' => $conversationId,
            'message_id' => $messageId,
        ]);
    }

    /**
     * 修改消息。
     *
     * @param  string  $messageId  消息ID
     * @param  array  $payload  可选参数
     *                          - meta_data: 元数据，Map<String,String>格式
     *                          - content: 消息内容
     *                          - content_type: 消息类型
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/modify_message
     * @see zh:https://www.coze.cn/open/docs/developer_guides/modify_message
     */
    public function modify(string $messageId, array $payload = []): JsonResponse
    {
        return $this->client->postJson('/v1/conversation/message/modify', [
            'message_id' => $messageId,
            ...$payload,
        ]);
    }

    /**
     * 删除消息。
     *
     * @param  string  $conversationId  会话ID
     * @param  string  $messageId  消息ID
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/delete_message
     * @see zh:https://www.coze.cn/open/docs/developer_guides/delete_message
     */
    public function delete(string $conversationId, string $messageId): JsonResponse
    {
        return $this->client->postJson('/v1/conversation/message/delete?conversation_id='.$conversationId, [
            'message_id' => $messageId,
        ]);
    }
}
