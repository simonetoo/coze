# 贡献指南

感谢您考虑为Coze PHP SDK做出贡献！以下是一些指导原则，帮助您参与项目开发。

## 行为准则

本项目采用[贡献者公约](https://www.contributor-covenant.org/version/2/0/code_of_conduct/)。通过参与，您同意遵守其条款。

## 如何贡献

1. Fork项目仓库
2. 创建您的特性分支 (`git checkout -b feature/amazing-feature`)
3. 提交您的更改 (`git commit -m 'Add some amazing feature'`)
4. 推送到分支 (`git push origin feature/amazing-feature`)
5. 打开Pull Request

## 开发流程

### 环境设置

确保您的开发环境满足以下要求：
- PHP 8.0+
- Composer

安装依赖：
```bash
composer install
```

### 代码风格

本项目遵循PSR-12编码规范。在提交代码前，请运行代码风格检查：

```bash
composer cs-check
```

如需自动修复代码风格问题：

```bash
composer cs-fix
```

### 测试

添加新功能或修复bug时，请确保编写或更新相应的测试。运行测试：

```bash
composer test
```

### 文档

如果您的更改影响了API或用法，请更新相应的文档。

## Pull Request指南

- 确保您的PR针对`main`分支
- 遵循项目的代码风格
- 添加或更新测试以反映您的更改
- 更新相关文档
- 保持PR的范围小且集中，这样更容易审查
- 在PR描述中清晰地解释您的更改及其目的

## 版本控制

本项目遵循[语义化版本控制](https://semver.org/)。

## 许可证

通过贡献您的代码，您同意您的贡献将根据项目的MIT许可证进行许可。
