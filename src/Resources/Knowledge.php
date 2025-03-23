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
     * @see zh:https://www.coze.cn/open/docs/developer_guides/create_knowledge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/create_knowledge_files
     */
    public function create(): JsonResponse {}

    /*
     * 修改知识库文件
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/modify_knowledge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/modify_knowledge_files
     */
    public function update(): JsonResponse {}

    /*
     * 查看知识库文件列表
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/list_knowledge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/list_knowledge_files
     */
    public function list(): JsonResponse {}

    /*
     * 删除知识库文件列表
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/delete_knowdge_files
     * @see en:https://www.coze.com/open/docs/developer_guides/delete_knowledge_files
     */
    public function delete(): JsonResponse {}

    /*
     * 查看知识库文件上传进度
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_dataset_progress
     * @see en:https://www.coze.com/open/docs/developer_guides/7v3czmpi
     */
    public function process(): JsonResponse {}

    /*
     * 更新知识库图片描述
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/update_image_caption
     * @see en:https://www.coze.com/open/docs/developer_guides/update_image_caption
     */
    public function imageCaption(): JsonResponse {}

    /*
     * 查看知识库图片列表
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/get_images
     * @see en:https://www.coze.com/open/docs/developer_guides/get_images
     */
    public function images(): JsonResponse {}
}
