<?php

namespace Simonetoo\Coze\Contracts;

use Simonetoo\Coze\Http\HttpClient;
use Simonetoo\Coze\Resources\Bot;
use Simonetoo\Coze\Resources\Chat;
use Simonetoo\Coze\Resources\Conversation;
use Simonetoo\Coze\Resources\Dataset;
use Simonetoo\Coze\Resources\File;
use Simonetoo\Coze\Resources\Knowledge;
use Simonetoo\Coze\Resources\Message;
use Simonetoo\Coze\Resources\Workflow;
use Simonetoo\Coze\Resources\Workspace;

interface CozeInterface
{
    /**
     * 获取HTTP客户端
     */
    public function getHttpClient(): HttpClient;

    /**
     * 获取Bots API资源
     */
    public function bot(): Bot;

    /**
     * 获取Files API资源
     */
    public function file(): File;

    /**
     * 获取Datasets API资源（知识库）
     */
    public function dataset(): Dataset;

    /**
     * 获取知识库资源
     */
    public function knowledge(): Knowledge;

    /**
     * 获取工作空间资源
     */
    public function workspace(): Workspace;

    /**
     * 获取会话资源
     */
    public function conversation(): Conversation;

    /**
     * 获取聊天资源
     */
    public function chat(): Chat;

    /**
     * 获取消息资源
     */
    public function message(): Message;

    /**
     * 获取Workflow API资源
     */
    public function workflow(): Workflow;
}
