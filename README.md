## 前言

Initial plus 主题由[阵雨兄](http://blog.alttt.com)在[initial](https://github.com/jielive/initial)主题的基础上设计，这款 Typecho 主题就此诞生！
然而，原 initial 主题于 2023 年停更，initial plus 也于 2021 至 2022 年间停止更新。两款主题均无法完美支持新版的 Typecho 1.3.0。为此，本博客在建站期间顺手修复了相关 Bug，如今的 Initial Plus NYY 也算是重获新生了。

重要说明：所有修复代码均为DeepSeek编写，人工审查，已尽量保证可读性和规范性。如对AI敏感，请自行离开。

## 配置参考

Typecho：Typecho 1.3.0
PHP环境：PHP 8.4.23
JS环境：Node.js 24.18.0
web服务：Nginx 1.30.4
数据库：MySQL 8.0.45

## 演示

[NYY's Blogs - IT社畜](https://blog.nyyz.top)

## 更新说明

1.修复所有后台外观设置的选择框——从“更改不生效”修复为正常运作。
2.Gravatar 头像源新增 Cravatar 源，其余三个源均已失效，使用这一个即可。
3.背景音乐改为任意点击即可播放。如需跨页面播放，请开启“Ajax 翻页”和“全站Pjax”。
4.新增右上角天气信息。
5.新增动态天气背景。
6.实时天气信息可与背景联动，背景每 5 分钟自动切换一次。此功能的开关已整合至背景音乐播放的设置中。
7.修复背景音乐播放音量，音量范围调整为 0–100。
8.修复加密插件的正常运行，并解决其影响下文 Markdown 格式的问题。
9.优化后端外观设置，新增导航栏和浮动保存设置按钮，方便定位和随时保存。
10.修改备案链接为最新“https://beian.miit.gov.cn”
11.修复后台编辑页的访问方式，从https访问改为本地文件方式访问。防止部分情况报错。
12.增加公安备案外观设置，更方便的添加自己的公安备案信息。

Initial plus主题中加密插件，已与主题捆绑不可独立使用。如要单独下载插件，[请移步这里](https://ucw.moe/archives/typecho-partially-password.html)。

其他功能说明，[请移步原版主题介绍](https://github.com/jielive/initial)。
