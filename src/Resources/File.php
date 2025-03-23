<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class File extends Resource
{
    /**
     * 上传文件
     *
     * @param  string  $filePath  文件路径
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/upload_files
     * @see en:https://www.coze.com/open/docs/developer_guides/upload_files
     */
    public function upload(string $filePath): JsonResponse
    {
        return $this->client->post('/v1/files/upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => fopen($filePath, 'r'),
                ],
            ],
        ]);
    }

    /**
     * 获取文件详情
     *
     * @param  string  $fileId  文件ID
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/retrieve_files
     * @see en:https://www.coze.com/open/docs/developer_guides/retrieve_files
     */
    public function retrieve(string $fileId): JsonResponse
    {
        return $this->client->get('/v1/files/retrieve', [
            'file_id' => $fileId,
        ]);
    }
}
