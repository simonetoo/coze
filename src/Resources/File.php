<?php

namespace Simonetoo\Coze\Resources;

use GuzzleHttp\Psr7\Utils;
use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class File extends Resource
{
    /**
     * 上传文件
     *
     * @param  string  $path  文件路径
     *
     * @throws ApiException
     *
     * @see zh:https://www.coze.cn/open/docs/developer_guides/upload_files
     * @see en:https://www.coze.com/open/docs/developer_guides/upload_files
     */
    public function upload(string $path): JsonResponse
    {
        return $this->client->post('/v1/files/upload', [
            'multipart' => [
                [
                    'name' => 'file',
                    'contents' => Utils::tryFopen($path, 'r'),
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
