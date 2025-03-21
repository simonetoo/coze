<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\Response;

class Files extends Resource
{
    /**
     * 上传文件到扣子平台
     *
     * @param  string  $filePath  要上传的文件路径
     * @return Response 上传的文件信息
     *
     * @throws ApiException 请求异常
     * @throws \InvalidArgumentException 当文件不存在时
     *
     * @see https://www.coze.cn/open/docs/developer_guides/upload_files
     */
    public function upload(string $filePath): Response
    {
        if (! file_exists($filePath)) {
            throw new \InvalidArgumentException("File does not exist: {$filePath}");
        }

        $multipart = [
            [
                'name' => 'file',
                'contents' => fopen($filePath, 'r'),
                'filename' => basename($filePath),
            ],
        ];

        return $this->client->post('/v1/files/upload', [
            'multipart' => $multipart,
        ]);
    }

    /**
     * 获取已上传文件的信息
     *
     * @param  string  $fileId  已上传的文件ID
     * @return Response 文件信息
     *
     * @throws ApiException 请求异常
     *
     * @see https://www.coze.cn/open/docs/developer_guides/retrieve_files
     */
    public function retrieve(string $fileId): Response
    {
        return $this->client->get('/v1/files/retrieve', [
            'file_id' => $fileId,
        ]);
    }
}
