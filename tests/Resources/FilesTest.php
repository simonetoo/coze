<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Files;

class FilesTest extends TestCase
{
    private HttpClient $httpClient;

    private Files $files;

    protected function setUp(): void
    {
        HttpClient::fake();
        $this->files = (new Coze('your-token'))->files();
    }

    public function test_upload(): void
    {
        // 创建临时测试文件
        $tempFile = tempnam(sys_get_temp_dir(), 'test_file_');
        file_put_contents($tempFile, 'test content');

        // 模拟响应
        $responseData = [
            'id' => 'file_123456',
            'bytes' => 12,
            'created_at' => time(),
            'file_name' => basename($tempFile),
        ];

        // 设置模拟响应
        $this->httpClient->mockResponse('POST', '/v1/files/upload', $responseData);

        // 执行测试
        $response = $this->files->upload($tempFile);

        // 验证结果
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->getData());

        // 清理
        unlink($tempFile);
    }

    public function test_upload_with_non_existent_file(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->files->upload('/path/to/nonexistent/file.txt');
    }

    public function test_retrieve(): void
    {
        $fileId = 'file_123456';

        // 模拟响应
        $responseData = [
            'id' => $fileId,
            'bytes' => 12,
            'created_at' => time(),
            'file_name' => 'test.txt',
        ];

        // 设置模拟响应
        $this->httpClient->mockResponse('GET', '/v1/files/retrieve', $responseData);

        // 执行测试
        $response = $this->files->retrieve($fileId);

        // 验证结果
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->getData());
    }
}
