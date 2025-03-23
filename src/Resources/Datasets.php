<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Datasets extends Resource
{
    /**
     * 创建知识库
     *
     * @param string $name 知识库名称
     * @param string $spaceId 空间ID
     * @param int $formatType 格式类型
     * @param array $payload 其他可选参数
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/create_dataset
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
     * @param string $spaceId 空间ID
     * @param array $payload 其他可选参数 (name, format_type, page_num, page_size)
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/list_dataset
     */
    public function list(
        string $spaceId,
        array $payload = []
    ): JsonResponse {
        $payload['space_id'] = $spaceId;
        
        // 设置默认分页参数
        if (!isset($payload['page_num'])) {
            $payload['page_num'] = 1;
        }
        
        if (!isset($payload['page_size'])) {
            $payload['page_size'] = 10;
        }

        return $this->client->get('/v1/datasets', $payload);
    }

    /**
     * 修改知识库信息
     *
     * @param string $datasetId 知识库ID
     * @param array $payload 其他可选参数 (name, description)
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/update_dataset
     */
    public function update(
        string $datasetId,
        array $payload = []
    ): JsonResponse {
        return $this->client->patchJson("/v1/datasets/{$datasetId}", $payload);
    }

    /**
     * 删除知识库
     *
     * @param string $datasetId 知识库ID
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/delete_dataset
     */
    public function delete(string $datasetId): JsonResponse
    {
        return $this->client->delete("/v1/datasets/{$datasetId}");
    }

    /**
     * 上传文件到知识库
     *
     * @param string $datasetId 知识库ID
     * @param array $documents 文档信息数组
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/upload_dataset_document
     */
    public function uploadDocuments(
        string $datasetId,
        array $documents
    ): JsonResponse {
        $payload = [
            'document_bases' => $documents,
        ];

        return $this->client->postJson("/v1/datasets/{$datasetId}/documents", $payload);
    }

    /**
     * 修改知识库文件
     *
     * @param string $datasetId 知识库ID
     * @param string $documentId 文档ID
     * @param string $documentName 文档名称
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/update_dataset_document
     */
    public function updateDocument(
        string $datasetId,
        string $documentId,
        string $documentName
    ): JsonResponse {
        $payload = [
            'document_name' => $documentName,
        ];

        return $this->client->patchJson("/v1/datasets/{$datasetId}/documents/{$documentId}", $payload);
    }

    /**
     * 获取知识库文件列表
     *
     * @param string $datasetId 知识库ID
     * @param array $payload 其他可选参数 (page, page_size)
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/list_dataset_document
     */
    public function listDocuments(
        string $datasetId,
        array $payload = []
    ): JsonResponse {
        // 设置默认分页参数
        if (!isset($payload['page'])) {
            $payload['page'] = 1;
        }
        
        if (!isset($payload['page_size'])) {
            $payload['page_size'] = 10;
        }

        return $this->client->get("/v1/datasets/{$datasetId}/documents", $payload);
    }

    /**
     * 检查文件上传进度
     *
     * @param string $datasetId 知识库ID
     * @param array $documentIds 文档ID数组
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/get_dataset_document_process
     */
    public function checkDocumentProcess(
        string $datasetId,
        array $documentIds
    ): JsonResponse {
        $payload = [
            'document_ids' => $documentIds,
        ];

        return $this->client->get("/v1/datasets/{$datasetId}/documents/process", $payload);
    }

    /**
     * 获取知识库图片列表
     *
     * @param string $datasetId 知识库ID
     * @return JsonResponse
     *
     * @throws ApiException
     */
    public function listImages(string $datasetId): JsonResponse
    {
        return $this->client->get("/v1/datasets/{$datasetId}/images/list");
    }

    /**
     * 更新图片描述
     *
     * @param string $datasetId 知识库ID
     * @param string $documentId 文档ID
     * @param string $caption 图片描述
     * @return JsonResponse
     *
     * @throws ApiException
     */
    public function updateImageCaption(
        string $datasetId,
        string $documentId,
        string $caption
    ): JsonResponse {
        $payload = [
            'caption' => $caption,
        ];

        return $this->client->patchJson("/v1/datasets/{$datasetId}/images/{$documentId}", $payload);
    }
}
