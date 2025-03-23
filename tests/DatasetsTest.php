<?php

namespace Simonetoo\Coze\Tests;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Datasets;

class DatasetsTest extends TestCase
{
    private Coze $coze;

    private Datasets $datasets;

    private string $spaceId = '7484524201249194023';

    private string $datasetId = '7484881587176734755';

    private string $documentId = '7484881587176734800';

    protected function setUp(): void
    {
        $this->coze = Coze::fake();
        $this->datasets = $this->coze->datasets();
    }

    public function test_list_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'data' => [
                [
                    'dataset_id' => $this->datasetId,
                    'name' => 'Test Dataset',
                    'description' => 'Test dataset description',
                    'created_at' => '1719371007',
                ],
            ],
            'total' => 1,
            'page_num' => 1,
            'page_size' => 10,
        ];

        // 模拟HTTP响应
        $this->coze->mock('v1/datasets', $responseData);

        // 调用list方法
        $response = $this->datasets->list($this->spaceId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());

        // 测试带有额外参数的情况
        $this->coze->mock('v1/datasets', $responseData);
        $response = $this->datasets->list($this->spaceId, ['page_num' => 2, 'page_size' => 20]);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_update_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'success' => true,
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}", $responseData);

        // 调用update方法
        $payload = [
            'name' => 'Updated Dataset Name',
            'description' => 'Updated dataset description',
        ];
        $response = $this->datasets->update($this->datasetId, $payload);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_delete_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'success' => true,
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}", $responseData);

        // 调用delete方法
        $response = $this->datasets->delete($this->datasetId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_upload_documents_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'document_ids' => ['7484881587176734800', '7484881587176734801'],
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}/documents", $responseData);

        // 调用uploadDocuments方法
        $documents = [
            [
                'document_name' => 'Test Document 1',
                'file_id' => '7484881587176734800',
            ],
            [
                'document_name' => 'Test Document 2',
                'file_id' => '7484881587176734801',
            ],
        ];
        $response = $this->datasets->uploadDocuments($this->datasetId, $documents);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_update_document_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'success' => true,
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}/documents/{$this->documentId}", $responseData);

        // 调用updateDocument方法
        $documentName = 'Updated Document Name';
        $response = $this->datasets->updateDocument($this->datasetId, $this->documentId, $documentName);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_list_documents_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'data' => [
                [
                    'document_id' => $this->documentId,
                    'document_name' => 'Test Document',
                    'file_id' => '7484881587176734800',
                    'created_at' => '1719371007',
                ],
            ],
            'total' => 1,
            'page' => 1,
            'page_size' => 10,
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}/documents", $responseData);

        // 调用listDocuments方法
        $response = $this->datasets->listDocuments($this->datasetId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());

        // 测试带有额外参数的情况
        $this->coze->mock("v1/datasets/{$this->datasetId}/documents", $responseData);
        $response = $this->datasets->listDocuments($this->datasetId, ['page' => 2, 'page_size' => 20]);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_check_document_process_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'data' => [
                [
                    'document_id' => $this->documentId,
                    'status' => 'completed',
                    'progress' => 100,
                ],
            ],
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}/documents/process", $responseData);

        // 调用checkDocumentProcess方法
        $documentIds = [$this->documentId];
        $response = $this->datasets->checkDocumentProcess($this->datasetId, $documentIds);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_list_images_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'data' => [
                [
                    'document_id' => $this->documentId,
                    'document_name' => 'Test Image',
                    'file_id' => '7484881587176734800',
                    'caption' => 'Test image caption',
                    'created_at' => '1719371007',
                ],
            ],
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}/images/list", $responseData);

        // 调用listImages方法
        $response = $this->datasets->listImages($this->datasetId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_update_image_caption_method(): void
    {
        // 模拟响应数据
        $responseData = [
            'success' => true,
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}/images/{$this->documentId}", $responseData);

        // 调用updateImageCaption方法
        $caption = 'Updated image caption';
        $response = $this->datasets->updateImageCaption($this->datasetId, $this->documentId, $caption);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }
}
