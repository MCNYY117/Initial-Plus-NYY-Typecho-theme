<?php
/**
 * 文章/页面通用元信息头部
 *
 * 包含：标题、原创标识、作者、日期、分类、评论数、阅读量。
 * 被 post.php、page.php 及自定义模板引用，保持展示一致。
 *
 * 使用前需确保 $this 指向当前文章/page 对象。
 * @var Widget_Archive $this
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<div class="post-biaoti">
<h1 class="post-title"><?php if ($this->fields->original == 1): ?><span class="original" title="作者原创">原创</span><?php endif; ?><?php $this->title() ?></h1>
<ul class="post-meta">
<?php if ($this->options->isauthor): ?><li class="iconfont icon-wo" title="作者">&nbsp;<a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></li><?php endif; ?>
<li class="iconfont icon-rili" title="发布日期">&nbsp;<?php $this->date(); ?></li>
<li class="iconfont icon-fenlei" title="文章分类">&nbsp;<?php $this->category(','); ?></li>
<?php if($this->allow('comment')): ?>
<li class="iconfont icon-pinglun" title="文章评论">&nbsp;<a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无', '%d'); ?></a></li>
<?php else: ?>
<li class="iconfont icon-pinglun" title="评论关闭">&nbsp;关闭</li>
<?php endif; ?>
<li class="iconfont icon-yanjing" title="文章阅读">&nbsp;<?php Postviews($this); ?></li>
</ul>
</div>
