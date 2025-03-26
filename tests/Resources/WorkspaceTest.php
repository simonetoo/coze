<?php

namespace Simonetoo\Coze\Tests\Resources;

use PHPUnit\Framework\TestCase;
use Simonetoo\Coze\Coze;
use Simonetoo\Coze\Http\JsonResponse;

class WorkspaceTest extends TestCase
{
    protected Coze $coze;

    protected function setUp(): void
    {
        parent::setUp();

        $this->coze = Coze::fake();

        // 为list方法设置模拟响应
        $listResponse = [
            'code' => 0,
            'msg' => 'Success',
            'data' => [
                'workspaces' => [
                    [
                        'id' => '7484524201249194023',
                        'name' => '测试工作空间',
                        'description' => '这是一个测试工作空间',
                        'created_at' => 1719371007,
                    ],
                ],
                'total_count' => 1,
            ],
        ];
        $this->coze->mock('/v1/workspaces', $listResponse);
    }

    public function test_list(): void
    {
        // 调用list方法
        $response = $this->coze->workspace()->list([
            'page_num' => 1,
            'page_size' => 10,
        ]);

        // 验证响应
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(0, $response->json('code'));
        $this->assertEquals(1, $response->json('data.total_count'));
        $this->assertCount(1, $response->json('data.workspaces'));
        $this->assertEquals('7484524201249194023', $response->json('data.workspaces.0.id'));
        $this->assertEquals('测试工作空间', $response->json('data.workspaces.0.name'));
    }
}
