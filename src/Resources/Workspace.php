<?php

namespace Simonetoo\Coze\Resources;

use Simonetoo\Coze\Exceptions\ApiException;
use Simonetoo\Coze\Http\JsonResponse;

class Workspace extends Resource
{
    /**
     * 获取当前用户加入的工作空间列表。
     *
     * @param  array  $payload  可选参数
     *                          - page_num: 页码，默认为1
     *                          - page_size: 每页数量，默认为20，最大为50
     *
     * @throws ApiException
     *
     * @see en:https://www.coze.com/open/docs/developer_guides/b1t2kfxr
     * @see zh:https://www.coze.cn/open/docs/developer_guides/b1t2kfxr
     */
    public function list(array $payload = []): JsonResponse
    {
        return $this->client->get('/v1/workspaces', $payload);
    }
}
