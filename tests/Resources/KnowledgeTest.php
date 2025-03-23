<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Knowledge;

class KnowledgeTest extends TestCase
{
    private Coze $coze;

    private Knowledge $knowledge;

    private string $datasetId = '7484881587176734755';

    protected function setUp(): void
    {
        $this->coze = Coze::fake();
        $this->knowledge = $this->coze->knowledge();
        
        // 预先设置所有测试方法需要的模拟响应
        $this->setupMockResponses();
    }
    
    private function setupMockResponses(): void
    {
        // 为create方法设置模拟响应
        $createResponse = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'document_infos' => [
                    [
                        'document_id' => '123456789',
                        'name' => 'test.pdf',
                        'char_count' => 1000,
                        'chunk_strategy' => [
                            'chunk_type' => 1,
                            'max_tokens' => 800,
                        ],
                    ],
                ],
            ],
        ];
        $this->coze->mock('/open_api/knowledge/document/create', $createResponse);
        
        // 为update方法设置模拟响应
        $updateResponse = [
            'code' => 0,
            'msg' => '',
        ];
        $this->coze->mock('/open_api/knowledge/document/update', $updateResponse);
        
        // 为list方法设置模拟响应
        $listResponse = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'documents' => [
                    [
                        'document_id' => '123456789',
                        'name' => 'test.pdf',
                        'status' => 'processed',
                        'create_time' => 1719371007,
                    ],
                ],
                'total' => 1,
            ],
        ];
        $this->coze->mock('/open_api/knowledge/document/list', $listResponse);
        
        // 为delete方法设置模拟响应
        $deleteResponse = [
            'code' => 0,
            'msg' => '',
        ];
        $this->coze->mock('/open_api/knowledge/document/delete', $deleteResponse);
        
        // 为process方法设置模拟响应
        $processResponse = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'documents' => [
                    [
                        'document_id' => '123456789',
                        'status' => 'processing',
                        'progress' => 75,
                    ],
                ],
            ],
        ];
        $this->coze->mock('/v1/datasets/:dataset_id/process', $processResponse);
        
        // 为imageCaption方法设置模拟响应
        $imageCaptionResponse = [
            'code' => 0,
            'msg' => '',
        ];
        $this->coze->mock('/open_api/knowledge/image/caption', $imageCaptionResponse);
        
        // 为images方法设置模拟响应
        $imagesResponse = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'images' => [
                    [
                        'image_id' => '123456789',
                        'url' => 'https://example.com/image.jpg',
                        'caption' => 'Test image',
                        'create_time' => 1719371007,
                    ],
                ],
                'total' => 1,
            ],
        ];
        $this->coze->mock('/v1/datasets/:dataset_id/images', $imagesResponse);
    }

    public function test_create_method(): void
    {
        // 调用create方法
        $documentBases = [
            [
                'name' => 'test.pdf',
                'source_info' => [
                    'file_base64' => '5rWL6K+V5paH5Lu2',
                    'file_type' => 'pdf',
                ],
            ],
        ];
        $response = $this->knowledge->create($this->datasetId, $documentBases);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));

        // 测试带有额外参数的情况
        $response = $this->knowledge->create(
            $this->datasetId,
            $documentBases,
            [
                'chunk_strategy' => [
                    'separator' => '\n\n',
                    'max_tokens' => 800,
                    'remove_extra_spaces' => false,
                ],
            ]
        );
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_update_method(): void
    {
        // 调用update方法
        $documentId = '123456789';
        $name = 'updated_test.pdf';
        $response = $this->knowledge->update($this->datasetId, $documentId, $name);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));

        // 测试带有额外参数的情况
        $response = $this->knowledge->update(
            $this->datasetId,
            $documentId,
            $name,
            [
                'chunk_strategy' => [
                    'separator' => '\n\n',
                    'max_tokens' => 1000,
                ],
            ]
        );
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_list_method(): void
    {
        // 调用list方法
        $response = $this->knowledge->list($this->datasetId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));

        // 测试带有额外参数的情况
        $response = $this->knowledge->list(
            $this->datasetId,
            [
                'page' => 1,
                'page_size' => 10,
                'status' => 'processed',
            ]
        );
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_delete_method(): void
    {
        // 调用delete方法
        $documentIds = ['123456789', '987654321'];
        $response = $this->knowledge->delete($this->datasetId, $documentIds);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_process_method(): void
    {
        // 调用process方法
        $documentIds = ['123456789'];
        $response = $this->knowledge->process($this->datasetId, $documentIds);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_image_caption_method(): void
    {
        // 调用imageCaption方法
        $imageId = '123456789';
        $caption = 'This is a test image caption';
        $response = $this->knowledge->imageCaption($this->datasetId, $imageId, $caption);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
    }

    public function test_images_method(): void
    {
        // 调用images方法
        $response = $this->knowledge->images($this->datasetId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));

        // 测试带有额外参数的情况
        $response = $this->knowledge->images(
            $this->datasetId,
            [
                'page' => 1,
                'page_size' => 10,
                'caption' => 'test',
            ]
        );
        $this->assertEquals(0, $response->json('code'));
    }
}
