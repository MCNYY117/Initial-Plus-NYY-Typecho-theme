<?php
/**
 * Initial Plus - 简约而不简单
 * 还原本质 勿忘初心
 * 
 * @package Initial Plus
 * @author 阵雨兄
 * @version 3.7.4
 * @link http://blog.alttt.com/
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
$this->need('header.php');
?>
<div id="main">
<?php if ($this->_currentPage == 1 && !empty($this->options->ShowWhisper) && in_array('index', $this->options->ShowWhisper)): ?>
<article class="post whisper<?php if (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper) && in_array('indexqy', $this->options->ShowWhisper)): ?> indexqy<?php endif; ?>">
<div class="post-content">
<?php Whisper(); ?>
<?php if ($this->user->pass('editor', true) && (!FindContents('page-whisper.php') || isset(FindContents('page-whisper.php')[1]))): ?>
<p class="notice"><b>仅管理员可见: </b><br><?php echo FindContents('page-whisper.php') ? '发现多个"轻语"模板页面，已自动选取内容最多的页面作为展示，请删除多余模板页面。' : '未找到"轻语"模板页面，请检查是否创建模板页面。' ?></p>
<?php endif; ?>
</div>
</article>
<?php endif; ?>
<?php while($this->next()): ?>
<article class="post<?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?> liebiao">
<div class="post-content">
<?php if ($this->options->PjaxOption && $this->hidden): ?>
<h2 class="post-title"><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
<form method="post">
<p class="word">请输入密码访问</p>
<p>
<input type="password" class="text" name="protectPassword" />
<input type="submit" class="submit" value="提交" />
</p>
</form>
<?php else: ?>
<?php if (postThumb($this)): ?>
<p class="thumb"><a href="<?php $this->permalink() ?>" title="<?php $this->title() ?>"><?php echo postThumb($this); ?></a></p>
<?php endif; ?>
<h2 class="post-title"><?php $this->sticky(); ?><?php if ($this->fields->original == 1): ?><span class="original" title="作者原创">原创</span><?php endif; ?><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
<?php if (postOutline($this)): ?>
<p class="postOutline"><?php echo postOutline($this); ?></p>
<?php else: ?>
<p class="postOutline"><?php $this->excerpt(200, ''); ?></p>
<?php endif; ?>
<?php endif; ?>
<ul class="post-meta">
<?php if ($this->options->isauthor): ?><li class="iconfont icon-wo" title="作者">&nbsp;<?php $this->author(); ?></li><?php endif; ?>
<li class="iconfont icon-rili" title="发布日期">&nbsp;<?php $this->date(); ?></li>
<li class="iconfont icon-fenlei" title="文章分类">&nbsp;<?php $this->category(',', false); ?></li>
<?php if($this->allow('comment')): ?>
<li class="iconfont icon-pinglun" title="文章评论">&nbsp;<?php $this->commentsNum('暂无', '%d'); ?></li>
<?php else: ?>
<li class="iconfont icon-pinglun" title="评论关闭">&nbsp;关闭</li>
<?php endif; ?>
<li class="iconfont icon-yanjing" title="文章阅读">&nbsp;<?php Postviews($this); ?></li>
</ul>
</div>
</article>
<?php endwhile; ?>
<?php $this->pageNav('上一页', $this->options->AjaxLoad ? '查看更多' : '下一页', 2, '..', $this->options->AjaxLoad ? array('wrapClass' => 'page-navigator ajaxload') : ''); ?>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>