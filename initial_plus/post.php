<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php $this->need('page-parts/post-meta.php'); ?>
<?php if (!empty($this->options->Breadcrumbs) && in_array('Postshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs post-mianbao iconfont icon-shouye">
<a href="<?php $this->options->siteUrl(); ?>">返回首页</a> &raquo; <?php $this->category(); ?> &raquo; <?php if (!empty($this->options->Breadcrumbs) && in_array('Text', $this->options->Breadcrumbs)): ?>正文<?php else: $this->title(); endif; ?>
</div>
<?php endif; ?>
<article class="post<?php if ($this->options->PjaxOption && $this->hidden): ?> protected<?php endif; ?> post-zhengwen">
<?php if (postThumb($this)): ?>
<div class="thumb post-toutu"><?php echo postThumb($this); ?></div>
<?php endif; ?>
<div class="post-wenzhang">
<div class="post-content">
<?php echo parseContent($this); ?>
</div>
<li id="like">
<?php $this->need('page-parts/qr-reward.php'); ?>
</li>
<?php $this->need('page-parts/license.php'); ?>
</div>
</article>
<?php $this->need('comments.php'); ?>
<ul class="post-near">
<li>上一篇: <?php $this->thePrev('%s','没有了'); ?></li>
<li>下一篇: <?php $this->theNext('%s','没有了'); ?></li>
</ul>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
