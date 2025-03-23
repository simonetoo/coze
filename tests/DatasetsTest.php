<?php

namespace Simonetoo\Coze\Tests;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Resources\Datasets;

class DatasetsTest extends TestCase
{
    private Coze $client;

    protected function setUp(): void
    {
        $this->client = Coze::fake([
            'token' => 'test_token',
        ]);
    }

    public function test_datasets_instance(): void
    {
        $datasets = $this->client->datasets();
        $this->assertInstanceOf(Datasets::class, $datasets);
    }

    public function test_create_dataset(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'dataset_id' => 'dataset_123',
                'name' => 'Test Dataset',
                'space_id' => 'space_123',
                'format_type' => 1,
                'description' => 'Test dataset description',
                'created_at' => '2023-01-01T00:00:00Z',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets', $responseData);

        // 调用create方法
        $response = $this->client->datasets()->create(
            'Test Dataset',
            'space_123',
            1,
            ['description' => 'Test dataset description']
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('dataset_123', $response->json('data.dataset_id'));
        $this->assertEquals('Test Dataset', $response->json('data.name'));
        $this->assertEquals('space_123', $response->json('data.space_id'));
        $this->assertEquals(1, $response->json('data.format_type'));
        $this->assertEquals('Test dataset description', $response->json('data.description'));
    }

    public function test_list_datasets(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'total' => 2,
                'datasets' => [
                    [
                        'dataset_id' => 'dataset_123',
                        'name' => 'Test Dataset 1',
                        'space_id' => 'space_123',
                        'format_type' => 1,
                        'description' => 'Test dataset 1 description',
                        'created_at' => '2023-01-01T00:00:00Z',
                    ],
                    [
                        'dataset_id' => 'dataset_456',
                        'name' => 'Test Dataset 2',
                        'space_id' => 'space_123',
                        'format_type' => 2,
                        'description' => 'Test dataset 2 description',
                        'created_at' => '2023-01-02T00:00:00Z',
                    ],
                ],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets', $responseData);

        // 调用list方法
        $response = $this->client->datasets()->list('space_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals(2, $response->json('data.total'));
        $this->assertCount(2, $response->json('data.datasets'));
        $this->assertEquals('dataset_123', $response->json('data.datasets.0.dataset_id'));
        $this->assertEquals('Test Dataset 1', $response->json('data.datasets.0.name'));
        $this->assertEquals('dataset_456', $response->json('data.datasets.1.dataset_id'));
        $this->assertEquals('Test Dataset 2', $response->json('data.datasets.1.name'));
    }

    public function test_update_dataset(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'dataset_id' => 'dataset_123',
                'name' => 'Updated Dataset Name',
                'description' => 'Updated dataset description',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123', $responseData);

        // 调用update方法
        $response = $this->client->datasets()->update(
            'dataset_123',
            ['name' => 'Updated Dataset Name', 'description' => 'Updated dataset description']
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('dataset_123', $response->json('data.dataset_id'));
        $this->assertEquals('Updated Dataset Name', $response->json('data.name'));
        $this->assertEquals('Updated dataset description', $response->json('data.description'));
    }

    public function test_delete_dataset(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => null,
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123', $responseData);

        // 调用delete方法
        $response = $this->client->datasets()->delete('dataset_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertNull($response->json('data'));
    }

    public function test_upload_documents(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'document_ids' => ['doc_123', 'doc_456'],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123/documents', $responseData);

        // 准备文档数据
        $documents = [
            [
                'document_name' => 'Test Document 1',
                'file_id' => 'file_123',
            ],
            [
                'document_name' => 'Test Document 2',
                'file_id' => 'file_456',
            ],
        ];

        // 调用uploadDocuments方法
        $response = $this->client->datasets()->uploadDocuments('dataset_123', $documents);

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertCount(2, $response->json('data.document_ids'));
        $this->assertEquals('doc_123', $response->json('data.document_ids.0'));
        $this->assertEquals('doc_456', $response->json('data.document_ids.1'));
    }

    public function test_update_document(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'document_id' => 'doc_123',
                'document_name' => 'Updated Document Name',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123/documents/doc_123', $responseData);

        // 调用updateDocument方法
        $response = $this->client->datasets()->updateDocument(
            'dataset_123',
            'doc_123',
            'Updated Document Name'
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('doc_123', $response->json('data.document_id'));
        $this->assertEquals('Updated Document Name', $response->json('data.document_name'));
    }

    public function test_list_documents(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'total' => 2,
                'documents' => [
                    [
                        'document_id' => 'doc_123',
                        'document_name' => 'Test Document 1',
                        'file_id' => 'file_123',
                        'status' => 'completed',
                        'created_at' => '2023-01-01T00:00:00Z',
                    ],
                    [
                        'document_id' => 'doc_456',
                        'document_name' => 'Test Document 2',
                        'file_id' => 'file_456',
                        'status' => 'processing',
                        'created_at' => '2023-01-02T00:00:00Z',
                    ],
                ],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123/documents', $responseData);

        // 调用listDocuments方法
        $response = $this->client->datasets()->listDocuments('dataset_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals(2, $response->json('data.total'));
        $this->assertCount(2, $response->json('data.documents'));
        $this->assertEquals('doc_123', $response->json('data.documents.0.document_id'));
        $this->assertEquals('Test Document 1', $response->json('data.documents.0.document_name'));
        $this->assertEquals('completed', $response->json('data.documents.0.status'));
        $this->assertEquals('doc_456', $response->json('data.documents.1.document_id'));
        $this->assertEquals('processing', $response->json('data.documents.1.status'));
    }

    public function test_check_document_process(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'documents' => [
                    [
                        'document_id' => 'doc_123',
                        'status' => 'completed',
                        'progress' => 100,
                    ],
                    [
                        'document_id' => 'doc_456',
                        'status' => 'processing',
                        'progress' => 50,
                    ],
                ],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123/documents/process', $responseData);

        // 调用checkDocumentProcess方法
        $response = $this->client->datasets()->checkDocumentProcess(
            'dataset_123',
            ['doc_123', 'doc_456']
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertCount(2, $response->json('data.documents'));
        $this->assertEquals('doc_123', $response->json('data.documents.0.document_id'));
        $this->assertEquals('completed', $response->json('data.documents.0.status'));
        $this->assertEquals(100, $response->json('data.documents.0.progress'));
        $this->assertEquals('doc_456', $response->json('data.documents.1.document_id'));
        $this->assertEquals('processing', $response->json('data.documents.1.status'));
        $this->assertEquals(50, $response->json('data.documents.1.progress'));
    }

    public function test_list_images(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'total' => 2,
                'images' => [
                    [
                        'document_id' => 'img_123',
                        'document_name' => 'Test Image 1',
                        'file_id' => 'file_123',
                        'caption' => 'Test image 1 caption',
                        'created_at' => '2023-01-01T00:00:00Z',
                    ],
                    [
                        'document_id' => 'img_456',
                        'document_name' => 'Test Image 2',
                        'file_id' => 'file_456',
                        'caption' => 'Test image 2 caption',
                        'created_at' => '2023-01-02T00:00:00Z',
                    ],
                ],
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123/images/list', $responseData);

        // 调用listImages方法
        $response = $this->client->datasets()->listImages('dataset_123');

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals(2, $response->json('data.total'));
        $this->assertCount(2, $response->json('data.images'));
        $this->assertEquals('img_123', $response->json('data.images.0.document_id'));
        $this->assertEquals('Test Image 1', $response->json('data.images.0.document_name'));
        $this->assertEquals('Test image 1 caption', $response->json('data.images.0.caption'));
        $this->assertEquals('img_456', $response->json('data.images.1.document_id'));
        $this->assertEquals('Test Image 2', $response->json('data.images.1.document_name'));
    }

    public function test_update_image_caption(): void
    {
        // 准备模拟响应数据
        $responseData = [
            'code' => 0,
            'message' => 'success',
            'data' => [
                'document_id' => 'img_123',
                'caption' => 'Updated image caption',
            ],
        ];

        // 模拟API响应
        $this->client->mock('/v1/datasets/dataset_123/images/img_123', $responseData);

        // 调用updateImageCaption方法
        $response = $this->client->datasets()->updateImageCaption(
            'dataset_123',
            'img_123',
            'Updated image caption'
        );

        // 验证响应
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals('success', $response->json('message'));
        $this->assertEquals('img_123', $response->json('data.document_id'));
        $this->assertEquals('Updated image caption', $response->json('data.caption'));
    }
}
