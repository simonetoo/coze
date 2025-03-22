<?php

namespace Simonetoo\Coze\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Resources\Files;

class FilesTest extends TestCase
{
    private Coze $client;

    private string $testFilePath;

    protected function setUp(): void
    {
        $this->client = Coze::fake([
            'token' => 'test_token',
        ]);

        // 创建测试文件
        $this->testFilePath = sys_get_temp_dir().'/test_file.txt';
        file_put_contents($this->testFilePath, 'This is a test file content');
    }

    protected function tearDown(): void
    {
        // 清理测试文件
        if (file_exists($this->testFilePath)) {
            unlink($this->testFilePath);
        }
    }

    public function test_files_instance(): void
    {
        $files = $this->client->files();
        $this->assertInstanceOf(Files::class, $files);
    }

    public function test_upload_file(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'file_id' => 'file_123',
                'filename' => 'test_file.txt',
                'size' => 28,
                'content_type' => 'text/plain',
                'created_at' => '2023-01-01T00:00:00Z',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/files/upload', $responseData);

        // 调用upload方法
        $response = $this->client->files()->upload($this->testFilePath);

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('file_123', $response->json('data.file_id'));
        $this->assertEquals('test_file.txt', $response->json('data.filename'));
        $this->assertEquals(28, $response->json('data.size'));
        $this->assertEquals('text/plain', $response->json('data.content_type'));
    }

    public function test_upload_nonexistent_file(): void
    {
        // 设置不存在的文件路径
        $nonExistentFilePath = sys_get_temp_dir().'/nonexistent_file.txt';

        // 确保文件不存在
        if (file_exists($nonExistentFilePath)) {
            unlink($nonExistentFilePath);
        }

        // 期望抛出异常
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("File does not exist: {$nonExistentFilePath}");

        // 调用upload方法，应该抛出异常
        $this->client->files()->upload($nonExistentFilePath);
    }

    public function test_retrieve_file(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'file_id' => 'file_123',
                'filename' => 'test_file.txt',
                'size' => 28,
                'content_type' => 'text/plain',
                'created_at' => '2023-01-01T00:00:00Z',
                'status' => 'available',
                'url' => 'https://example.com/files/file_123',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/files/retrieve', $responseData);

        // 调用retrieve方法
        $response = $this->client->files()->retrieve('file_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('file_123', $response->json('data.file_id'));
        $this->assertEquals('test_file.txt', $response->json('data.filename'));
        $this->assertEquals('available', $response->json('data.status'));
        $this->assertEquals('https://example.com/files/file_123', $response->json('data.url'));
    }

    public function test_retrieve_nonexistent_file(): void
    {
        // 准备模拟响应数据 - 文件不存在的情况
        $responseData = [
            'code' => 404,
            'message' => 'File not found',
            'data' => null,
        ];

        // 模拟API响应
        $this->client->mock('/v1/files/retrieve', $responseData);

        // 调用retrieve方法
        $response = $this->client->files()->retrieve('nonexistent_file_id');

        // 验证响应
        $this->assertEquals(404, $response->json('code'));
        $this->assertEquals('File not found', $response->json('message'));
        $this->assertNull($response->json('data'));
    }

    public function test_retrieve_processing_file(): void
    {
        // 准备模拟响应数据 - 文件正在处理的情况
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'file_id' => 'file_456',
                'filename' => 'large_document.pdf',
                'size' => 1024000,
                'content_type' => 'application/pdf',
                'created_at' => '2023-01-02T00:00:00Z',
                'status' => 'processing',
                'url' => null,
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/files/retrieve', $responseData);

        // 调用retrieve方法
        $response = $this->client->files()->retrieve('file_456');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('file_456', $response->json('data.file_id'));
        $this->assertEquals('processing', $response->json('data.status'));
        $this->assertNull($response->json('data.url'));
    }
}
