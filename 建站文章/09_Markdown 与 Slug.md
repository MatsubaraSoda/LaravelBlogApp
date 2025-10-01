# Markdown 与 Slug

记录 Markdown 渲染与中文 Slug 规则。

## Markdown 渲染
- 库：`Parsedown`
- 放置位置：模型访问器 `Post::getContentHtmlAttribute()`
- 用法：读取 `content_markdown`，输出 HTML（空内容返回空字符串）

## 中文 Slug 规则
- 输入：标题（可含中文）
- 处理：
  - 空格 → `-`
  - 特殊字符 → `-`（保留中文/英文/数字/减号）
  - 清理连续 `-` 与首尾 `-`
  - 为空则使用 `post-<timestamp>`
- 唯一性：若存在同名 slug，追加 `-<自增序号>`
