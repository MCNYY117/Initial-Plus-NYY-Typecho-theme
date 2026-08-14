<?php
/**
 * 归档
 *
 * @package custom
 */
?>
<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<?php $this->need('header.php'); ?>
<div id="main">
<div class="post-biaoti">
<h1 class="post-title"><?php $this->title() ?></h1>
<ul class="post-meta">
<?php if ($this->options->isauthor): ?><li class="iconfont icon-wo" title="作者">&nbsp;<a href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></li><?php endif; ?>
<li class="iconfont icon-rili" title="发布日期">&nbsp;<?php $this->date(); ?></li>
<?php if($this->allow('comment')): ?>
<li class="iconfont icon-pinglun" title="文章评论">&nbsp;<a href="<?php $this->permalink() ?>#comments"><?php $this->commentsNum('暂无', '%d'); ?></a></li>
<?php else: ?>
<li class="iconfont icon-pinglun" title="评论关闭">&nbsp;关闭</li>
<?php endif; ?>
<li class="iconfont icon-yanjing" title="文章阅读">&nbsp;<?php Postviews($this); ?></li>
</ul>
</div>
<?php if (!empty($this->options->Breadcrumbs) && in_array('Pageshow', $this->options->Breadcrumbs)): ?>
<div class="breadcrumbs post-mianbao iconfont icon-shouye">
<a href="<?php $this->options->siteUrl(); ?>">返回首页</a> &raquo; <?php $this->title() ?>
</div>
<?php endif; ?>
<article class="post post-zhengwen">
<?php if (postThumb($this)): ?>
<div class="thumb post-toutu"><?php echo postThumb($this); ?></div>
<?php endif; ?>
<div class="post-wenzhang">
<div class="post-content">
<?php echo parseContent($this); ?>
<font class="iconfont icon-biaoqian titleicon">&nbsp;标签</font>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Tag_Cloud@page', 'sort=count&ignoreZeroCount=1&desc=1&limit=0')->to($tags); ?>
<?php if($tags->have()): ?>
<?php while($tags->next()): ?>
<li class="right-tags"><a href="<?php $tags->permalink(); ?>" <?php if (!empty($this->options->colortags) && in_array('page', $this->options->colortags)) { echo colortags(); } ?> title="<?php $tags->count(); ?> 篇文章"><?php $tags->name(); ?></a></li>
<?php endwhile; ?>
<?php else: ?>
<li>暂无标签</li>
<?php endif; ?>
</ul>
</div>
<?php
$this->widget('Widget_Contents_Post_Recent', 'pageSize='.Typecho_Widget::widget('Widget_Stat')->publishedPostsNum)->to($archives);
$year=0; $mon=0;
$output = '<div id="archives">';
while($archives->next()){
	$year_tmp = date('Y',$archives->created);
	$mon_tmp = date('m',$archives->created);
	if ($mon > $mon_tmp) {
		$output .= '</ul></li>';
	}
	if ($year > $year_tmp) {
		$output .= '</ul>';
	}
	if ($year != $year_tmp) {
		$year = $year_tmp;
		$output .= '<font class="iconfont icon-rili titleicon">&nbsp;'.date('Y 年',$archives->created).'</font><ul>';
	}
	if ($mon != $mon_tmp) {
		$mon = $mon_tmp;
		$output .= '<li><h4>'.date('m 月',$archives->created).'</h4><ul>'; 
	}
	if ($this->options->PjaxOption && $archives->hidden) {
		$output .= '<li>'.date('d日：',$archives->created).'<a>'. $archives->title .'</a></li>';
	} else {
		$output .= $archives->commentsNum ? '<li>'.date('d日：',$archives->created).'<a href="'.$archives->permalink .'">'. $archives->title .'</a><span class="mcount">('.$archives->commentsNum.')</span></li>' : '<li>'.date('d日：',$archives->created).'<a href="'.$archives->permalink .'">'. $archives->title .'</a></li>';
	}
}
$output .= '</ul></li></ul></div>';
echo $output;
?>
</div>
</article>
<?php $this->need('comments.php'); ?>
</div>
<?php $this->need('sidebar.php'); ?>
<?php $this->need('footer.php'); ?>