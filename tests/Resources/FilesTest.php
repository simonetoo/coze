<?php

namespace Simonetoo\Coze\Tests\Resources;

use Mockery;
use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Files;

class FilesTest extends TestCase
{
    private $httpClient;

    private Files $files;

    protected function setUp(): void
    {
        $this->httpClient = Mockery::mock(HttpClient::class);
        $this->files = new Files($this->httpClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function test_upload(): void
    {
        // 创建临时测试文件
        $tempFile = tempnam(sys_get_temp_dir(), 'test_file_');
        file_put_contents($tempFile, 'test content');

        // 模拟响应
        $mockResponse = Mockery::mock(JsonResponse::class);
        $mockResponse->shouldReceive('getData')
            ->andReturn([
                'id' => 'file_123456',
                'bytes' => 12,
                'created_at' => time(),
                'file_name' => basename($tempFile),
            ]);

        // 设置期望
        $this->httpClient->shouldReceive('post')
            ->once()
            ->with('/v1/files/upload', Mockery::on(function ($options) {
                return isset($options['multipart']) &&
                       is_array($options['multipart']) &&
                       isset($options['multipart'][0]['name']) &&
                       $options['multipart'][0]['name'] === 'file';
            }))
            ->andReturn($mockResponse);

        // 执行测试
        $response = $this->files->upload($tempFile);

        // 验证结果
        $this->assertInstanceOf(JsonResponse::class, $response);

        // 清理
        unlink($tempFile);
    }

    public function test_upload_with_resource(): void
    {
        // 创建资源
        $resource = fopen('php://memory', 'r+');
        fwrite($resource, 'test content');
        rewind($resource);

        // 模拟响应
        $mockResponse = Mockery::mock(JsonResponse::class);
        $mockResponse->shouldReceive('getData')
            ->andReturn([
                'id' => 'file_123456',
                'bytes' => 12,
                'created_at' => time(),
                'file_name' => 'file',
            ]);

        // 设置期望
        $this->httpClient->shouldReceive('post')
            ->once()
            ->with('/v1/files/upload', Mockery::on(function ($options) {
                return isset($options['multipart']) &&
                       is_array($options['multipart']) &&
                       isset($options['multipart'][0]['name']) &&
                       $options['multipart'][0]['name'] === 'file';
            }))
            ->andReturn($mockResponse);

        // 执行测试
        $response = $this->files->upload($resource);

        // 验证结果
        $this->assertInstanceOf(JsonResponse::class, $response);

        // 清理
        fclose($resource);
    }

    public function test_upload_with_spl_file_info(): void
    {
        // 创建临时测试文件
        $tempFile = tempnam(sys_get_temp_dir(), 'test_file_');
        file_put_contents($tempFile, 'test content');
        $fileInfo = new \SplFileInfo($tempFile);

        // 模拟响应
        $mockResponse = Mockery::mock(JsonResponse::class);
        $mockResponse->shouldReceive('getData')
            ->andReturn([
                'id' => 'file_123456',
                'bytes' => 12,
                'created_at' => time(),
                'file_name' => $fileInfo->getFilename(),
            ]);

        // 设置期望
        $this->httpClient->shouldReceive('post')
            ->once()
            ->with('/v1/files/upload', Mockery::on(function ($options) {
                return isset($options['multipart']) &&
                       is_array($options['multipart']) &&
                       isset($options['multipart'][0]['name']) &&
                       $options['multipart'][0]['name'] === 'file';
            }))
            ->andReturn($mockResponse);

        // 执行测试
        $response = $this->files->upload($fileInfo);

        // 验证结果
        $this->assertInstanceOf(JsonResponse::class, $response);

        // 清理
        unlink($tempFile);
    }

    public function test_upload_with_invalid_file(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->files->upload(new \stdClass);
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
        $mockResponse = Mockery::mock(JsonResponse::class);
        $mockResponse->shouldReceive('getData')
            ->andReturn([
                'id' => $fileId,
                'bytes' => 12,
                'created_at' => time(),
                'file_name' => 'test.txt',
            ]);

        // 设置期望
        $this->httpClient->shouldReceive('get')
            ->once()
            ->with('/v1/files/retrieve', ['file_id' => $fileId])
            ->andReturn($mockResponse);

        // 执行测试
        $response = $this->files->retrieve($fileId);

        // 验证结果
        $this->assertInstanceOf(JsonResponse::class, $response);
    }
}
