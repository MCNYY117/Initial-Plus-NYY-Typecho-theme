<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<div id="secondary">
<?php if ((!empty($this->options->sidebarBlock) && (in_array('blogonline', $this->options->sidebarBlock) || in_array('sitestat', $this->options->sidebarBlock))) || (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper)) || $this->user->hasLogin()): ?>
<div class="mubu">
<img id="widget-avatar-bg" src="<?php skinUrl('img/','-avatar-bg.jpg'); ?>">
<?php if (!empty($this->options->sidebarBlock) && in_array('blogonline', $this->options->sidebarBlock)): ?>
<li class="blogonline"><?php getBuildTime(); ?></li>
<?php endif; ?>
</div>
<?php endif; ?>
<div class="sidebar">
<?php if ((!empty($this->options->sidebarBlock) && in_array('sitestat', $this->options->sidebarBlock)) || (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper)) || $this->user->hasLogin()): ?>
<section class="widget">
<ul class="widget-list">
<?php if (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper) || $this->user->hasLogin()): ?>
<li><img class="widget-avatar" src="<?php if($this->user->hasLogin()): ?><?php echo Typecho_Common::gravatarUrl($this->user->mail, 100, 'X', 'mm'); ?><?php else: ?><?php echo Typecho_Common::gravatarUrl(Whisper(1,'','mail'), 100, 'X', 'mm'); ?><?php endif; ?>"></li>
<li class="widget-avatar-name iconfont icon-wo">&nbsp;<?php if($this->user->hasLogin()): ?><a href="<?php $this->options->siteUrl(); ?>index.php/author/<?php $this->user->uid(); ?>/"><?php $this->user->screenName(); ?></a><?php else: ?><?php if (Whisper(1,'','authorId')): ?><a href="<?php $this->options->siteUrl(); ?>index.php/author/<?php echo Whisper(1,'','authorId'); ?>/"><?php echo Whisper(1,'','author'); ?></a><?php else: ?>未发表轻语<?php endif; ?><?php endif; ?></li>
<?php endif; ?>
<?php if (!empty($this->options->ShowWhisper) && in_array('sidebar', $this->options->ShowWhisper)): ?>
<?php Whisper(1,$this->user->uid); ?>
<?php if ($this->user->pass('editor', true) && (!FindContents('page-whisper.php') || isset(FindContents('page-whisper.php')[1]))): ?>
<li class="notice"><b>仅管理员可见: </b><br><?php echo FindContents('page-whisper.php') ? '发现多个"轻语"模板页面，已自动选取内容最多的页面作为展示，请删除多余模板页面。' : '未找到"轻语"模板页面，请检查是否创建模板页面。' ?></li>
<?php endif; ?>
<?php endif; ?> 
<?php if ((!empty($this->options->sidebarBlock) && in_array('sitestat', $this->options->sidebarBlock)) || $this->user->hasLogin()): ?>
<ul class="stat-meta">
<?php if($this->user->hasLogin()): ?>
<li><?php echo userstat($this->user->uid,'post'); ?><br>文章</li>
<li><?php echo userstat($this->user->uid,'comment'); ?><br>评论</li>
<li><?php echo userstat($this->user->uid,'attachment'); ?><br>附件</li>
<?php else: ?>
<li><?php Typecho_Widget::widget('Widget_Stat')->to($stat); $stat->publishedPostsNum() ?><br>文章</li>
<li><?php $stat->categoriesNum() ?><br>分类</li>
<li><?php $stat->publishedCommentsNum() ?><br>评论</li>
<?php endif; ?>
</ul>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowHotPosts', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-remen">&nbsp;热门文章</div>
<ul class="widget-list">
<?php Contents_Post_Initial($this->options->postsListSize, 'views'); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowGoodPosts', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-top">&nbsp;好评文章</div>
<ul class="widget-list">
<?php Contents_Post_Initial($this->options->postsListSize, 'commentsNum'); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentPosts', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-new">&nbsp;最新文章</div>
<ul class="widget-list">
<?php Contents_Post_Initial($this->options->postsListSize); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowRecentComments', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-pinglun">&nbsp;最近回复</div>
<ul class="widget-list">
<?php Contents_Comments_Initial($this->options->commentsListSize, in_array('IgnoreAuthor', $this->options->sidebarBlock) ? 1 : ''); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowCategory', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-fenlei2">&nbsp;文章分类</div>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Category_List')
->parse('<li class="right-fenlei"><a href="{permalink}">{name}</a></li>'); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowTag', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-biaoqian">&nbsp;标签</div>
<ul class="widget-tile">
<?php $this->widget('Widget_Metas_Tag_Cloud@sidebar', 'sort=mid&ignoreZeroCount=1&desc=0&limit=15')->to($tags); ?>
<?php if($tags->have()): ?>
<?php while($tags->next()): ?>
<li class="right-tags"><a href="<?php $tags->permalink(); ?>" <?php if (!empty($this->options->colortags) && in_array('sidebar', $this->options->colortags)) { echo colortags(); } ?>><?php $tags->name(); ?></a></li>
<?php endwhile; ?>
<?php if (FindContents('page-archives.php')): ?>
<li class="right-tags"><a href="<?php echo FindContents('page-archives.php')[0]['permalink']; ?>" <?php if (!empty($this->options->colortags) && in_array('sidebar', $this->options->colortags)) { echo colortags(); } ?>>more...</a></li>
<?php endif; ?>
<?php else: ?>
<li>暂无标签</li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowArchive', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-guidang">&nbsp;归档</div>
<ul class="widget-list">
<?php $this->widget('Widget_Contents_Post_Date', 'type=month&format=Y 年 n 月')
->parse('<li><a href="{permalink}">{date}</a></li>'); ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->ShowLinks) && in_array('sidebar', $this->options->ShowLinks)): ?>
<section class="widget">
<div class="widget-title iconfont icon-youlian">&nbsp;链接</div>
<ul class="widget-tile">
<?php Links($this->options->IndexLinksSort); ?>
<?php if (FindContents('page-links.php', 'order', 'a', 1)): ?>
<li class="more"><a href="<?php echo FindContents('page-links.php', 'order', 'a', 1)[0]['permalink']; ?>">more...</a></li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
<?php if (!empty($this->options->sidebarBlock) && in_array('ShowOther', $this->options->sidebarBlock)): ?>
<section class="widget">
<div class="widget-title iconfont icon-shezhi">&nbsp;其它</div>
<ul class="widget-list">
<li><a href="<?php $this->options->feedUrl(); ?>" target="_blank">文章 RSS</a></li>
<li><a href="<?php $this->options->commentsFeedUrl(); ?>" target="_blank">评论 RSS</a></li>
<?php if($this->user->hasLogin()): ?>
<li><a href="<?php $this->options->adminUrl(); ?>" target="_blank">进入后台 (<?php $this->user->screenName(); ?>)</a></li>
<li><a href="<?php $this->options->logoutUrl(); ?>"<?php if ($this->options->PjaxOption): ?> no-pjax <?php endif; ?>>退出</a></li>
<?php endif; ?>
</ul>
</section>
<?php endif; ?>
</div>
</div>
