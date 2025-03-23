<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;
use Simonetoo\Coze\Resources\Dataset;

class DatasetTest extends TestCase
{
    private Coze $coze;

    private Dataset $datasets;

    private string $spaceId = '7484524201249194023';

    private string $datasetId = '7484881587176734755';

    protected function setUp(): void
    {
        $this->coze = Coze::fake();
        $this->datasets = $this->coze->dataset();
    }

    public function test_list(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => '',
            'data' => [
                'total_count' => 1,
                'dataset_list' => [
                    [
                        'dataset_id' => $this->datasetId,
                        'name' => 'Test Dataset',
                        'description' => 'Test dataset description',
                        'created_at' => '1719371007',
                    ],
                ],

            ],
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

    public function test_update(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => '',
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}", $responseData);

        // 调用update方法
        $payload = [
            'description' => 'Updated dataset description',
        ];
        $response = $this->datasets->update($this->datasetId, 'Updated Dataset Name', $payload);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }

    public function test_delete(): void
    {
        // 模拟响应数据
        $responseData = [
            'code' => 0,
            'msg' => '',
        ];

        // 模拟HTTP响应
        $this->coze->mock("v1/datasets/{$this->datasetId}", $responseData);

        // 调用delete方法
        $response = $this->datasets->delete($this->datasetId);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals($responseData, $response->json());
    }
}
