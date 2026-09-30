# Initial Plus NYY —— Typecho 主题

[English](README.md) · **中文**

## 前言

Initial plus 主题由[阵雨兄](http://blog.alttt.com)在[initial](https://github.com/jielive/initial)主题的基础上设计，这款 Typecho 主题就此诞生！
然而，原 initial 主题于 2023 年停更，initial plus 也于 2021 至 2022 年间停止更新。两款主题均无法完美支持新版的 Typecho 1.3.0。为此，本博客在建站期间顺手修复了相关 Bug，如今的 Initial Plus NYY 也算是重获新生了。

重要说明：所有修复代码均为 DeepSeek 编写，人工审查，已尽量保证可读性和规范性。如对 AI 敏感，请自行离开。

## 配置参考

| | |
|---|---|
| Typecho | 1.3.0 |
| PHP 环境 | PHP 8.4.23 |
| JS 环境 | Node.js 24.18.0（仅开发用，主题本身无构建步骤） |
| web 服务 | Nginx 1.30.4 |
| 数据库 | MySQL 8.0.45 |

## 演示

[NYY's Blogs - IT社畜](https://blog.nyyz.top)

## 安装

1. 把 `initial_plus` 整个目录上传到 Typecho 的 `usr/themes/` 下。
   **目录名必须保持 `initial_plus`** —— 主题内部有几处路径是按这个名字写死的，改名会失效。
2. 后台 → 控制台 → 外观，启用「Initial Plus NYY」。
3. 进入外观设置，按需开启天气、背景音乐、动态背景等功能。
   **天气功能需要服务器能访问外网**（`wttr.in` 取天气、`myip.ipip.net` 取 IP 归属）。
4. `plugins/` 下的两个插件按需单独上传到 `usr/plugins/`。
   其中 **`PartiallyPassword`（文章加密）已经与主题捆绑**，主题的 `[password]` 短代码依赖它，不能省略。

## 目录结构

```
initial_plus/              主题本体（上传到 usr/themes/）
├── index.php              首页文章列表
├── archive.php            分类 / 标签 / 日期 / 搜索归档
├── post.php               单篇文章
├── page.php               独立页面
├── 404.php / comments.php
├── page-archives.php      自定义模板：归档
├── page-links.php         自定义模板：链接
├── page-whisper.php       自定义模板：轻语
├── category/photos.php    分类模板：photos（瀑布流相册）
├── header.php / footer.php / sidebar.php
├── page-parts/            局部模板（文章元信息等）
├── functions.php          主题选项与全部主题逻辑
├── shortcode.php          短代码引擎
├── qrcode.php             二维码接口（含打赏码）
├── lib/                   第三方 PHP 库与数据文件
├── jscss/                 前端资源（jQuery / Bootstrap / Fancybox / Prism / 图标字体，均已内置）
└── img/                   图片资源
plugins/                   可选插件
├── PartiallyPassword/     文章内加密（作者 wuxianucw）— 与主题捆绑
└── Sticky/                文章置顶（作者 willin kan）
```

## 更新说明

1. 修复所有后台外观设置的选择框——从"更改不生效"修复为正常运作。
2. Gravatar 头像源新增 Cravatar 源，其余三个源均已失效，使用这一个即可。
3. 背景音乐改为任意点击即可播放。如需跨页面播放，请开启"Ajax 翻页"和"全站 Pjax"。
4. 新增右上角天气信息。
5. 新增动态天气背景。
6. 实时天气信息可与背景联动，背景每 5 分钟自动切换一次。此功能的开关已整合至背景音乐播放的设置中。
7. 修复背景音乐播放音量，音量范围调整为 0–100。
8. 修复加密插件的正常运行，并解决其影响下文 Markdown 格式的问题。
9. 优化后端外观设置，新增导航栏和浮动保存设置按钮，方便定位和随时保存。
10. 修改备案链接为最新"https://beian.miit.gov.cn"
11. 修复后台编辑页的访问方式，从 https 访问改为本地文件方式访问。防止部分情况报错。
12. 增加公安备案外观设置，更方便的添加自己的公安备案信息。

Initial plus 主题中加密插件，已与主题捆绑不可独立使用。如要单独下载插件，[请移步这里](https://ucw.moe/archives/typecho-partially-password.html)。

其他功能说明，[请移步原版主题介绍](https://github.com/jielive/initial)。

## 功能一览

- 双皮肤（white / dark），支持跟随 Cookie 记忆的暗色切换
- 圆角风格，可追加自定义 CSS
- 文章置顶、面包屑导航
- 后台设置页目录导航 + 悬浮保存按钮
- Pjax + Ajax「加载更多」
- Fancybox 灯箱、图片懒加载、Prism 代码高亮
- Gravatar 四源（当前只有 Cravatar 可用）
- 侧边栏组件：访问统计、站点统计、轻语
- 独立页面模板：归档、链接、轻语
- 社交关注（QQ / 微信 / 微博 / GitHub / Gitee / CSDN / 知乎 / B站 / Steam 等）
- 微信、支付宝打赏二维码
- 背景音乐播放器
- 导航栏实时天气 + 动态天气背景（5 分钟联动切换）
- 网页点击弹字特效
- ICP 备案 + 公安备案页脚
- 短代码集合：按钮、面板、折叠、高亮、二维码、微信等

## 已知问题

- **版本号不一致**：`index.php` 标注 `3.7.4`，`functions.php` 里定义 `INITIAL_VERSION_NUMBER = '3.7.5'`。
- **主题目录名不能改**：`functions.php` 中有几处路径硬编码为 `/usr/themes/initial_plus/lib/*.txt`。
- **`error_reporting(0)`** 在 `functions.php` 开头全局屏蔽了 PHP 错误，排查问题时建议临时注释掉。
- 仓库里有 4 个早期提交进来的 `.bak` 文件，其中 `Plugin.php.bak.20260729` 与正式文件完全相同。

## 许可证与署名

本仓库的 [MIT LICENSE](LICENSE) 覆盖的是 **NYY 在 Initial Plus 基础上所做的修改**。

**上游版权说明（重要）**：本主题是**二次派生**作品 ——
`jielive/initial` → 阵雨兄的 Initial Plus → 本仓库。
仓库里以文字和文件头注释的形式保留了上游作者署名（`@author 阵雨兄`、`@link http://blog.alttt.com/`），
**但上游主题自身的许可证文件并未随仓库附带，其授权条款未知**。
如果你是上游作者并对此有异议，或打算把这个主题用于再分发，请先确认上游许可。

仓库还内置了多个第三方组件（phpqrcode、Fancybox、Bootstrap、jQuery、Prism 等），
它们各自的许可证与作者见 [NOTICE](NOTICE)。

## 相关链接

- 上游 initial 主题：https://github.com/jielive/initial
- Initial Plus：http://blog.alttt.com
- 文章加密插件单独下载：https://ucw.moe/archives/typecho-partially-password.html
