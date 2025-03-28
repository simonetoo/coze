<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Http\StreamResponse;

class Workflow extends Resource
{
    /**
     * 运行工作流（非流式响应）
     *
     * @param  string  $workflowId  工作流ID
     * @param  array  $payload  其他可选参数，如parameters、bot_id等
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/workflow_run
     * @see en:https://www.coze.com/open/docs/developer_guides/workflow_run
     */
    public function run(string $workflowId, array $payload = []): JsonResponse
    {
        $payload['workflow_id'] = $workflowId;

        return $this->client->postJson('/v1/workflow/run', $payload)->transform(function ($body) {
            $decoded = json_decode($body, true, JSON_BIGINT_AS_STRING);
            if (isset($decoded['data']) && is_string($decoded['data'])) {
                $decoded['data'] = json_decode($decoded['data'], true, JSON_BIGINT_AS_STRING);
            }

            return $decoded;
        });
    }

    /**
     * 运行工作流（流式响应）
     *
     * @param  string  $workflowId  工作流ID
     * @param  array  $payload  其他可选参数，如parameters、bot_id等
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/workflow_stream_run
     * @see en:https://www.coze.com/open/docs/developer_guides/workflow_stream_run
     */
    public function stream(string $workflowId, array $payload = []): StreamResponse
    {
        $payload['workflow_id'] = $workflowId;

        return $this->client->stream('POST', '/v1/workflow/stream_run', ['json' => $payload]);
    }

    /**
     * 恢复被中断的工作流执行
     *
     * @param  string  $executeId  工作流执行ID
     * @param  string  $answer  用户对问题的回答
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/workflow_resume
     * @see en:https://www.coze.com/open/docs/developer_guides/workflow_resume
     */
    public function resume(string $executeId, string $answer, array $payload = []): StreamResponse
    {
        $payload['execute_id'] = $executeId;
        $payload['answer'] = $answer;

        return $this->client->stream('POST', '/v1/workflow/stream_resume', ['json' => $payload]);
    }

    /**
     * 执行聊天工作流
     *
     * @param  string  $workflowId  聊天工作流ID
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/workflow_chat
     * @see en:https://www.coze.com/open/docs/developer_guides/workflow_chat
     */
    public function chat(string $workflowId, array $payload = []): StreamResponse
    {
        $payload['workflow_id'] = $workflowId;

        return $this->client->stream('POST', '/v1/workflows/chat', ['json' => $payload]);
    }

    /**
     * 查询工作流异步执行结果
     *
     * @param  string  $workflowId  工作流ID
     * @param  string  $executeId  工作流执行ID
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/workflow_history
     * @see en:https://www.coze.com/open/docs/developer_guides/workflow_history
     */
    public function history(string $workflowId, string $executeId): JsonResponse
    {
        return $this->client->get("/v1/workflows/{$workflowId}/run_histories/{$executeId}");
    }
}
