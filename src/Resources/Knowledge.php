<?php

/**
 * @author Simon<shihuiqian@xvii.pro>
 */

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Http\JsonResponse;

class Knowledge extends Resource
{
    /**
     * 创建知识库文件
     *
     * 上传文件到指定的知识库。支持上传本地文件、网页URL或图片文件。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  array  $document_bases  文档基础信息数组
     * @param  array  $payload  可选参数
     *                          - chunk_strategy: array 分块策略
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_knowledge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/create_knowledge_files
     */
    public function create(string $dataset_id, array $document_bases, array $payload = []): JsonResponse
    {
        $data = array_merge([
            'dataset_id' => $dataset_id,
            'document_bases' => $document_bases,
        ], $payload);

        return $this->client->postJson('/open_api/knowledge/document/create', $data);
    }

    /**
     * 修改知识库文件
     *
     * 修改知识库文件名称和更新策略。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  string  $document_id  文档ID
     * @param  string  $name  新的文件名称
     * @param  array  $payload  可选参数
     *                          - chunk_strategy: array 分块策略
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/modify_knowledge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/modify_knowledge_files
     */
    public function update(string $dataset_id, string $document_id, string $name, array $payload = []): JsonResponse
    {
        $data = array_merge([
            'dataset_id' => $dataset_id,
            'document_id' => $document_id,
            'name' => $name,
        ], $payload);

        return $this->client->postJson('/open_api/knowledge/document/update', $data);
    }

    /**
     * 查看知识库文件列表
     *
     * 查看指定知识库的文件列表，包括文档、表格或图片。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  array  $payload  可选参数
     *                          - page: int 页码，默认为1
     *                          - page_size: int 每页数量，默认为10
     *                          - status: string 文件状态筛选
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_knowledge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/list_knowledge_files
     */
    public function list(string $dataset_id, array $payload = []): JsonResponse
    {
        $data = array_merge([
            'dataset_id' => $dataset_id,
        ], $payload);

        return $this->client->postJson('/open_api/knowledge/document/list', $data);
    }

    /**
     * 删除知识库文件
     *
     * 删除知识库中的文本、图片、表格等文件，支持批量删除。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  array  $document_ids  要删除的文档ID数组
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/delete_knowdge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/delete_knowledge_files
     */
    public function delete(string $dataset_id, array $document_ids): JsonResponse
    {
        $data = [
            'dataset_id' => $dataset_id,
            'document_ids' => $document_ids,
        ];

        return $this->client->postJson('/open_api/knowledge/document/delete', $data);
    }

    /**
     * 查看知识库文件上传进度
     *
     * 获取知识库文件的上传处理进度。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  array  $document_ids  文档ID数组
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_dataset_progress
     * @see en:https://www.coze.com/open/docs/developer_guides/7v3czmpi
     */
    public function process(string $dataset_id, array $document_ids): JsonResponse
    {
        $data = [
            'dataset_id' => $dataset_id,
            'document_ids' => $document_ids,
        ];

        return $this->client->postJson('/v1/datasets/:dataset_id/process', $data);
    }

    /**
     * 更新知识库图片描述
     *
     * 更新知识库中图片的描述信息。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  string  $image_id  图片ID
     * @param  string  $caption  图片描述
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/update_image_caption
     * @see en:https://www.coze.com/open/docs/developer_guides/update_image_caption
     */
    public function imageCaption(string $dataset_id, string $image_id, string $caption): JsonResponse
    {
        $data = [
            'dataset_id' => $dataset_id,
            'image_id' => $image_id,
            'caption' => $caption,
        ];

        return $this->client->postJson('/open_api/knowledge/image/caption', $data);
    }

    /**
     * 查看知识库图片列表
     *
     * 查看图片知识库中的图片详细信息，支持通过图片注释筛选。
     *
     * @param  string  $dataset_id  知识库ID
     * @param  array  $payload  可选参数
     *                          - page: int 页码，默认为1
     *                          - page_size: int 每页数量，默认为10
     *                          - caption: string 图片描述筛选
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_images
     * @see en:https://www.coze.com/open/docs/developer_guides/get_images
     */
    public function images(string $dataset_id, array $payload = []): JsonResponse
    {
        $data = array_merge([
            'dataset_id' => $dataset_id,
        ], $payload);

        return $this->client->get('/v1/datasets/:dataset_id/images', $data);
    }
}
