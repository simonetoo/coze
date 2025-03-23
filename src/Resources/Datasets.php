<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Datasets extends Resource
{
    /**
     * 创建知识库
     *
     * @param  string  $name  知识库名称
     * @param  string  $spaceId  空间ID
     * @param  int  $formatType  格式类型
     * @param  array  $payload  其他可选参数
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_dataset
     * @see en:https://www.coze.com/open/docs/developer_guides/create_dataset
     */
    public function create(
        string $name,
        string $spaceId,
        int $formatType,
        array $payload = []
    ): JsonResponse {
        $payload['name'] = $name;
        $payload['space_id'] = $spaceId;
        $payload['format_type'] = $formatType;

        return $this->client->postJson('/v1/datasets', $payload);
    }

    /**
     * 获取知识库列表
     *
     * @param  string  $spaceId  空间ID
     * @param  array  $payload  其他可选参数 (name, format_type, page_num, page_size)
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_dataset
     * @see en:https://www.coze.com/open/docs/developer_guides/list_dataset
     */
    public function list(
        string $spaceId,
        array $payload = []
    ): JsonResponse {
        $payload['space_id'] = $spaceId;

        return $this->client->get('/v1/datasets', $payload);
    }

    /**
     * 修改知识库信息
     *
     * @param  string  $datasetId  知识库ID
     * @param  string  $name  知识库名称，长度不超过100个字符
     * @param  array  $payload  其他可选参数 (file_id, description)
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/update_dataset
     * @see en:https://www.coze.com/open/docs/developer_guides/update_dataset
     */
    public function update(
        string $datasetId,
        string $name,
        array $payload = []
    ): JsonResponse {
        $payload['name'] = $name;

        return $this->client->putJson("/v1/datasets/{$datasetId}", $payload);
    }

    /**
     * 删除知识库
     *
     * @param  string  $datasetId  知识库ID
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/delete_dataset
     * @see en:https://www.coze.com/open/docs/developer_guides/delete_dataset
     */
    public function delete(string $datasetId): JsonResponse
    {
        return $this->client->delete("/v1/datasets/{$datasetId}");
    }
}
