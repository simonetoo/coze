<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Files extends Resource
{
    /**
     * 上传文件
     *
     * @param string $filePath 文件路径
     * @param array $payload 其他可选参数
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/upload_files
     */
    public function upload(string $filePath, array $payload = []): JsonResponse
    {
        $payload['file'] = $this->client->prepareFile($filePath);
        
        return $this->client->postMultipart('/v1/files', $payload);
    }

    /**
     * 获取文件详情
     *
     * @param string $fileId 文件ID
     * @return JsonResponse
     *
     * @throws ApiException
     *
     * @see https://www.coze.com/open/docs/developer_guides/retrieve_files
     */
    public function retrieve(string $fileId): JsonResponse
    {
        return $this->client->get("/v1/files/{$fileId}");
    }
}
