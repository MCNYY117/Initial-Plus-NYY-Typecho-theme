<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<div class="breadcrumbs mianbao iconfont icon-shouye">
<a href="<?php $this->options->siteUrl(); ?>">返回首页</a> &raquo; <?php $this->archiveTitle(array(
'category'  =>  _t('分类 【%s】 下的文章'),
'search'    =>  _t('包含关键字 【%s】 的文章'),
'tag'       =>  _t('标签 【%s】 下的文章'),
'date'      =>  _t('在 【%s】 发布的文章'),
'author'    =>  _t('作者 【%s】 发布的文章')
), '', ''); ?></div>
<?php if ($this->getDescription()): ?>
<div class="fenlei-miaoshu"><?php echo $this->getDescription(); ?></div>
<?php endif; ?>
<?php if ($this->have()): ?>
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
<h2 class="post-title"><?php if ($this->fields->original == 1): ?><span class="original" title="作者原创">原创</span><?php endif; ?><a href="<?php $this->permalink() ?>"><?php $this->title() ?></a></h2>
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
<?php else: ?>
<article class="post">
<h2 class="post-title" style="text-align: center;">没有找到内容</h2>
</article>
<?php endif; ?>
<?php $this->pageNav('上一页', $this->options->AjaxLoad ? '查看更多' : '下一页', 2, '..', $this->options->AjaxLoad ? array('wrapClass' => 'page-navigator ajaxload') : ''); ?>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>