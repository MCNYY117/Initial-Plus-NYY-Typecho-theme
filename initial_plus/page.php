<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<?php $this->need('page-parts/post-meta.php'); ?>
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs post-mianbao iconfont icon-shouye">
<a href="<?php $this->options->siteUrl(); ?>">返回首页</a> &raquo; <?php $this->title() ?>
</div>
<?php endif; ?>
<article class="post post-zhengwen">
<?php if (postThumb($this)): ?>
<div class="thumb post-toutu<?php if (!$this->content): ?>1<?php endif; ?>"><?php echo postThumb($this); ?></div>
<?php endif; ?>
<?php if ($this->content): ?>
<div class="post-wenzhang">
<div class="post-content">
<?php echo parseContent($this); ?>
</div>
<li id="like">
<?php $this->need('page-parts/qr-reward.php'); ?>
</li>
<?php $this->need('page-parts/license.php'); ?>
</div>
<?php endif; ?>
</article>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>
