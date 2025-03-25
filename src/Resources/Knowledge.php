<?php

/**
 * @author Simonetoo<simonetoo@xvii.pro>
 */

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Knowledge extends Resource
{
    /**
     * 上传文件到指定的知识库。支持上传本地文件、网页URL或图片文件。
     *
     * @param  string  $datasetId  知识库ID
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/create_knowledge_files
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_knowledge_files
     */
    public function create(string $datasetId, array $payload = []): JsonResponse
    {
        $payload['dataset_id'] = (int) $datasetId;
        if (! isset($payload['format_type'])) {
            $payload['format_type'] = 2;
        }
        return $this->client->postJson('/open_api/knowledge/document/create', $payload);
    }

    /**
     * 修改知识库文件名称和更新策略。
     *
     * @param  array  $payload  可选参数
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/modify_knowledge_files
     * @see zh:https://www.coze.cn/open/docs/developer_guides/modify_knowledge_files
     */
    public function update(string $documentId, array $payload = []): JsonResponse
    {
        $payload['document_id'] = $documentId;

        return $this->client->postJson('/open_api/knowledge/document/update', $payload);
    }

    /**
     * 查看指定知识库的文件列表，包括文档、表格或图片。
     *
     * @param  string  $datasetId  知识库ID
     * @param  array  $payload  可选参数
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/list_knowledge_files
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_knowledge_files
     */
    public function list(string $datasetId, array $payload = []): JsonResponse
    {
        // 使用字符串会导致400 Bad Request. 暂时(int)处理一下
        $payload['dataset_id'] = (int) $datasetId;

        return $this->client->postJson('/open_api/knowledge/document/list', $payload);
    }

    /**
     * 删除知识库中的文本、图片、表格等文件，支持批量删除。
     *
     * @param  array|string  $documentIds  要删除的文档ID数组
     *
     * @throws ApiException
     * @see zh:https://www.coze.cn/open/docs/developer_guides/delete_knowdge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/delete_knowledge_files
     */
    public function delete(array|string $documentIds): JsonResponse
    {
        if (! is_array($documentIds)) {
            $documentIds = [$documentIds];
        }
        return $this->client->postJson('/open_api/knowledge/document/delete', [
            'document_ids' => $documentIds,
        ]);
    }

    /**
     * 获取知识库文件的上传处理进度。
     *
     * @param  string  $datasetId  知识库ID
     * @param  array|string[]  $documentIds  文档ID数组
     *
     * @return JsonResponse
     * @throws ApiException
     * @see en:https://www.coze.com/open/docs/developer_guides/7v3czmpi
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_dataset_progress
     */
    public function process(string $datasetId, array|string $documentIds): JsonResponse
    {
        if (! is_array($documentIds)) {
            $documentIds = [$documentIds];
        }
        return $this->client->postJson("/v1/datasets/{$datasetId}/process", [
            'document_ids' => $documentIds,
        ]);
    }

    /**
     * 更新知识库中图片的描述信息。
     *
     * @param  string  $datasetId  知识库ID
     * @param  string  $caption  图片描述
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/update_image_caption
     * @see en:https://www.coze.com/open/docs/developer_guides/update_image_caption
     */
    public function imageCaption(string $datasetId, string $documentId, string $caption): JsonResponse
    {
        return $this->client->postJson("/v1/datasets/{$datasetId}/images/{$documentId}", [
            'caption' => $caption,
        ]);
    }

    /**
     * 查看图片知识库中的图片详细信息，支持通过图片注释筛选。
     *
     * @param  string  $datasetId  知识库ID
     * @param  array  $payload  可选参数
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/get_images
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_images
     */
    public function images(string $datasetId, array $payload = []): JsonResponse
    {
        return $this->client->get("/v1/datasets/{$datasetId}/images", $payload);
    }
}
