<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\Response;
use SplFileInfo;

class Files extends Resource
{
    /**
     * 上传文件到扣子平台
     *
     * @param  string|resource|SplFileInfo  $file  要上传的文件（文件路径、资源或SplFileInfo对象）
     * @return Response 上传的文件信息
     *
     * @throws ApiException 请求异常
     *
     * @see https://www.coze.cn/open/docs/developer_guides/upload_files
     */
    public function upload($file): Response
    {
        $multipart = [
            [
                'name' => 'file',
                'contents' => $this->resolveFile($file),
                'filename' => $this->getFilename($file),
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

    /**
     * 解析文件内容
     *
     * @param  string|resource|SplFileInfo  $file  文件
     * @return resource 文件内容
     *
     * @throws \InvalidArgumentException 无效的文件类型
     */
    protected function resolveFile($file)
    {
        if (is_string($file)) {
            if (! file_exists($file)) {
                throw new \InvalidArgumentException("File does not exist: {$file}");
            }
            return fopen($file, 'r');
        }

        if (is_resource($file)) {
            return $file;
        }

        if ($file instanceof SplFileInfo) {
            return fopen($file->getPathname(), 'r');
        }

        throw new \InvalidArgumentException('Invalid file type. Expected string, resource, or SplFileInfo.');
    }

    /**
     * 获取文件名
     *
     * @param  string|resource|SplFileInfo  $file  文件
     * @return string 文件名
     */
    protected function getFilename($file): string
    {
        if (is_string($file)) {
            return basename($file);
        }

        if ($file instanceof SplFileInfo) {
            return $file->getFilename();
        }

        // 对于资源，使用默认文件名
        return 'file';
    }
}
