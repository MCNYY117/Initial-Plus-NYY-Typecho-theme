<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
define('INITIAL_VERSION_NUMBER', '3.7.5');
if (Helper::options()->GravatarUrl) define('__TYPECHO_GRAVATAR_PREFIX__', Helper::options()->GravatarUrl);
error_reporting(0);

function themeConfig($form) {
	// ===== 悬浮保存按钮 =====
	$floatBtn = new Typecho_Widget_Helper_Layout('div');
	$floatBtn->html('<style>
.typecho-option-submit{position:fixed;bottom:30px;z-index:999;padding:0!important;margin:0!important;list-style:none!important;border:none!important;background:none!important;box-shadow:none!important}
.typecho-option-submit button,.typecho-option-submit input[type="submit"]{padding:10px 28px;font-size:15px}
@media(max-width:768px){.typecho-option-submit{bottom:15px}}
html{scroll-behavior:smooth}
.bt-toc{position:fixed;top:50%;transform:translateY(-50%);z-index:100;padding:12px 14px;border:1px solid var(--tr-border);border-radius:6px;background:var(--tr-surface);box-shadow:0 1px 4px rgba(0,0,0,.06);color:var(--tr-text)}
.bt-toc-title{font-weight:700;font-size:13px;margin-bottom:8px;color:var(--tr-accent)}
.bt-toc-grid{display:flex;flex-direction:column;gap:3px}
.bt-toc-item{font-size:12px;padding:4px 6px;text-decoration:none;display:block;color:var(--tr-text-2);border-radius:3px}
.bt-toc-item:hover{background:var(--tr-hover-bg);color:var(--tr-accent);border-radius:3px}
@media(max-width:900px){.bt-toc{display:none}}
.bt-section-header{font-weight:700;font-size:15px;padding:10px 0 4px;margin:18px 0 4px;border-bottom:2px solid #467b96}
</style>
<script>
document.addEventListener("DOMContentLoaded",function(){var e=document.querySelector(".tr-panel");if(!e)return;function t(){var t=e.getBoundingClientRect(),n=document.querySelector(".bt-toc"),o=document.querySelector(".typecho-option-submit");n&&(n.style.left=Math.max(8,t.left-n.offsetWidth-6)+"px",n.style.top="50%",n.style.transform="translateY(-50%)"),o&&(o.style.left=Math.min(t.right+6,window.innerWidth-o.offsetWidth-8)+"px",o.style.bottom="30px")}t(),window.addEventListener("resize",t)});
</script>');
	$form->addItem($floatBtn);

	// ===== 导航目录 TOC =====
	$toc = new Typecho_Widget_Helper_Layout('div', ['class' => 'bt-toc']);
	$toc->html('<div class="bt-toc-title">📋 设置分类导航</div>
<div class="bt-toc-grid">
<a href="#sec-basic" class="bt-toc-item">基本设置</a>
<a href="#sec-theme" class="bt-toc-item">主题模式与样式</a>
<a href="#sec-cdn" class="bt-toc-item">CDN与性能</a>
<a href="#sec-features" class="bt-toc-item">功能开关</a>
<a href="#sec-nav" class="bt-toc-item">导航与布局</a>
<a href="#sec-post" class="bt-toc-item">文章与打赏</a>
<a href="#sec-links" class="bt-toc-item">链接与轻语</a>
<a href="#sec-sidebar" class="bt-toc-item">侧边栏</a>
<a href="#sec-footer" class="bt-toc-item">音乐与底部</a>
</div>');
	$form->addItem($toc);

	// ============================================================
	// Section 1: 基本设置
	// ============================================================
	$h1 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-basic', 'class' => 'bt-section-header']);
	$h1->html('基本设置');
	$form->addItem($h1);

	$GravatarUrl = new Typecho_Widget_Helper_Form_Element_Radio('GravatarUrl', 
	array(false => _t('官方源'),
	'https://cn.gravatar.com/avatar/' => _t('国内源'),
	'https://cravatar.cn/avatar/' => _t('Cravatar源'),
	'https://gravatar.ihuan.me/avatar/' => _t('ihuan源')),
	false, _t('Gravatar头像源'), _t('默认官方源'));
	$form->addInput($GravatarUrl);

	$logoUrl = new Typecho_Widget_Helper_Form_Element_Text('logoUrl', NULL, NULL, _t('站点标题 LOGO 地址'), _t('在这里填入一个图片 URL 地址, 以显示网站标题 LOGO'));
	$form->addInput($logoUrl);

	$customTitle = new Typecho_Widget_Helper_Form_Element_Text('customTitle', NULL, NULL, _t('自定义站点标题'), _t('仅用于替换页面头部位置的"标题"显示，和Typecho后台设置的站点名称不冲突，留空则显示默认站点名称'));
	$form->addInput($customTitle);

	$titleForm = new Typecho_Widget_Helper_Form_Element_Radio('titleForm', 
	array('title' => _t('仅文字'),
	'logo' => _t('仅LOGO'),
	'all' => _t('LOGO+文字')),
	'title', _t('站点标题显示内容'), _t('默认仅显示文字标题，若要显示LOGO，请在上方添加 LOGO 地址'));
	$form->addInput($titleForm);

	$subTitle = new Typecho_Widget_Helper_Form_Element_Text('subTitle', NULL, NULL, _t('自定义站点副标题'), _t('浏览器副标题，仅在当前页面为首页时显示，显示格式为：<b>标题 - 副标题</b>，留空则不显示副标题'));
	$form->addInput($subTitle);

	$favicon = new Typecho_Widget_Helper_Form_Element_Text('favicon', NULL, NULL, _t('Favicon 地址'), _t('在这里填入一个图片 URL 地址, 以添加一个Favicon，留空则不单独设置Favicon'));
	$form->addInput($favicon);

	// ============================================================
	// Section 2: 主题模式与样式
	// ============================================================
	$h2 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-theme', 'class' => 'bt-section-header']);
	$h2->html('主题模式与样式');
	$form->addItem($h2);

	$siteskin = new Typecho_Widget_Helper_Form_Element_Radio('siteskin', 
	array('white' => _t('白天模式'),
	'dark' => _t('深夜模式'),
	'auto' => _t('自动')),
	'white', _t('主题模式'), _t('默认白天模式，自动则每天20:00-6:00进入深夜模式'));
	$form->addInput($siteskin);

	$skinoptions = new Typecho_Widget_Helper_Form_Element_Checkbox('skinoptions', 
	array('radius' => _t('圆弧视窗'),
	'free' => _t('允许访客切换模式')),
	NULL, _t('主题模式选项'), _t('圆弧视窗为视窗带有半圆形弧度，允许访客切换模式，访客可以随意切换白天或深夜模式'));
	$form->addInput($skinoptions->multiMode());

	$colortags = new Typecho_Widget_Helper_Form_Element_Checkbox('colortags', 
	array('page' => _t('归档页标签云'),
	'sidebar' => _t('侧边栏')),
	NULL, _t('彩色标签'), _t('启用则随机显示彩色标签色彩，关闭则主题默认式样'));
	$form->addInput($colortags->multiMode());

	$CustomCss = new Typecho_Widget_Helper_Form_Element_Textarea('CustomCss', NULL, NULL, _t('自定义CSS'), _t('位于页头，head之间，适合修改个性式样，如修改局部字体大小，特殊日全站黑白特效等等……'));
	$form->addInput($CustomCss);

	$sitenocolr = new Typecho_Widget_Helper_Form_Element_Radio('sitenocolr', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('全站黑白效果'), _t('默认关闭，启用则所有彩色效果将不被显示'));
	$form->addInput($sitenocolr);

	$scalable = new Typecho_Widget_Helper_Form_Element_Radio('scalable', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('禁止缩放网站'), _t('默认关闭，启用则移动端无法缩放网站'));
	$form->addInput($scalable);

	// ============================================================
	// Section 3: CDN与性能
	// ============================================================
	$h3 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-cdn', 'class' => 'bt-section-header']);
	$h3->html('CDN与性能');
	$form->addItem($h3);

	$cjcdnAddress = new Typecho_Widget_Helper_Form_Element_Text('cjcdnAddress', NULL, NULL, _t('CSS文件的链接地址替换'), _t('请输入你的CDN云存储地址，例如：http://cdn.example.com/，支持绝大部分有镜像功能的CDN服务<br><b>被替换的原地址为主题文件位置，即：http://www.example.com/usr/themes/initial/</b>'));
	$form->addInput($cjcdnAddress);

	$AttUrlReplace = new Typecho_Widget_Helper_Form_Element_Textarea('AttUrlReplace', NULL, NULL, _t('文章内的链接地址替换（建议用在图片等静态资源的链接上）'), _t('按照格式输入你的CDN链接以替换原链接，格式：<br><b class="notice">原地址=替换地址</b><br>原地址与新地址之间用等号"="分隔，例如：<br><b>http://www.example.com/usr/uploads/=http://cdn.example.com/usr/uploads/</b><br>支持绝大部分有镜像功能的CDN服务，可设置多个规则，换行即可，一行一个'));
	$form->addInput($AttUrlReplace);

	$cjCDN = new Typecho_Widget_Helper_Form_Element_Radio('cjCDN', 
	array('sf' => _t('七牛云'),
	'zj' => _t('字节跳动'),
	'bt' => _t('BootCDN'),
	'bmt' => _t('爆米图'),
	0 => _t('关闭')),
	0, _t('公共静态资源来源'), _t('默认关闭，请根据需求选择合适来源，推荐"七牛云"。关闭则加载jscss目录中的本地资源'));
	$form->addInput($cjCDN);

	$compressHtml = new Typecho_Widget_Helper_Form_Element_Radio('compressHtml', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('HTML压缩'), _t('默认关闭，启用则会对HTML代码进行压缩，可能与部分插件存在兼容问题，请酌情选择开启或者关闭'));
	$form->addInput($compressHtml);

	// ============================================================
	// Section 4: 功能开关
	// ============================================================
	$h4 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-features', 'class' => 'bt-section-header']);
	$h4->html('功能开关');
	$form->addItem($h4);

	$duanma = new Typecho_Widget_Helper_Form_Element_Radio('duanma', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	1, _t('短代码功能'), _t('默认开启，启用则支持[toggle][highlight][tips][noway][warning][buy][note][ref][focus][likeme]等……文章编辑代码，优化文章编辑和排版'));
	$form->addInput($duanma);

	$isauthor = new Typecho_Widget_Helper_Form_Element_Radio('isauthor', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('显示作者'), _t('默认关闭，开启后将在主题和列表中显示文章作者，如博客多人使用不同账号发布文章建议开启，个人使用则关闭'));
	$form->addInput($isauthor);

	$webdz = new Typecho_Widget_Helper_Form_Element_Radio('webdz', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('网站弹字'), _t('默认关闭，启用后点击网页任何空白位置自动弹字，也可使用"自定义网站弹字"，对弹字进行自定义'));
	$form->addInput($webdz);

	$webdzCustom = new Typecho_Widget_Helper_Form_Element_Text('webdzCustom', NULL, NULL, _t('自定义网站弹字'), _t('启用网站弹字时生效，在这里填入自定义弹字内容，用"|"隔开。如"富强|民主|文明|和谐|自由"，留空则使用默认文字'));
	$form->addInput($webdzCustom);

	$prism = new Typecho_Widget_Helper_Form_Element_Radio('prism', 
	array('pm' => _t('启用'),
	'ln' => _t('启用并显示行号'),
	0 => _t('关闭')),
	0, _t('代码高亮'), _t('默认关闭，启用后使用"```代码类型（插入代码）```"实现代码高亮，支持html、php、css、markup、js、ini等……高亮显示。也可以自行替换主题文件夹中的"prism(js和css)"更换高亮代码和风格，网址：prismjs.com'));
	$form->addInput($prism);

	$lazyimg = new Typecho_Widget_Helper_Form_Element_Radio('lazyimg', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('图片懒加载'), _t('默认关闭，启用后一定程度上可降低服务器负载。'));
	$form->addInput($lazyimg);

	$fancybox = new Typecho_Widget_Helper_Form_Element_Radio('fancybox', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('FancyBox图片灯箱'), _t('默认关闭，启用后点击图片将会根据浏览器大小弹出图片'));
	$form->addInput($fancybox);

	$commentcaptcha = new Typecho_Widget_Helper_Form_Element_Radio('commentcaptcha', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('评论算术验证码'), _t('默认关闭，启用则会在评论区开启20以内算术题验证码。登录会员无需输入验证码'));
	$form->addInput($commentcaptcha);

	$PjaxOption = new Typecho_Widget_Helper_Form_Element_Radio('PjaxOption', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('全站Pjax'), _t('默认关闭，启用则会强制关闭"反垃圾保护"，强制"将较新的的评论显示在前面"'));
	$form->addInput($PjaxOption);

	$AjaxLoad = new Typecho_Widget_Helper_Form_Element_Radio('AjaxLoad', 
	array('auto' => _t('自动'),
	'click' => _t('点击'),
	0 => _t('关闭')),
	0, _t('Ajax翻页'), _t('默认关闭，启用则会使用Ajax加载文章翻页'));
	$form->addInput($AjaxLoad);

	$scrollTop = new Typecho_Widget_Helper_Form_Element_Radio('scrollTop', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('返回顶部'), _t('默认关闭，启用将在右下角显示"返回顶部"按钮'));
	$form->addInput($scrollTop);

	// ============================================================
	// Section 5: 导航与布局
	// ============================================================
	$h5 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-nav', 'class' => 'bt-section-header']);
	$h5->html('导航与布局');
	$form->addItem($h5);

	$Navset = new Typecho_Widget_Helper_Form_Element_Checkbox('Navset', 
	array('ShowCategory' => _t('显示分类'),
	'AggCategory' => _t('↪合并分类'),
	'ShowPage' => _t('显示页面'),
	'AggPage' => _t('↪合并页面')),
	array('ShowCategory', 'AggCategory', 'ShowPage'), _t('导航栏显示'), _t('默认显示合并的分类，显示页面'));
	$form->addInput($Navset->multiMode());

	$CategoryText = new Typecho_Widget_Helper_Form_Element_Text('CategoryText', NULL, NULL, _t('导航栏-分类 下拉菜单显示名称（使用"导航栏显示-合并分类"时生效）'), _t('在这里输入导航栏<b>分类</b>下拉菜单的显示名称,留空则默认显示为"分类"'));
	$form->addInput($CategoryText);

	$PageText = new Typecho_Widget_Helper_Form_Element_Text('PageText', NULL, NULL, _t('导航栏-页面 下拉菜单显示名称（使用"导航栏显示-合并页面"时生效）'), _t('在这里输入导航栏<b>页面</b>下拉菜单的显示名称,留空则默认显示为"其他"'));
	$form->addInput($PageText);

	$Breadcrumbs = new Typecho_Widget_Helper_Form_Element_Checkbox('Breadcrumbs', 
	array('Postshow' => _t('文章内显示'),
	'Text' => _t('↪文章标题替换为"正文"'),
	'Pageshow' => _t('页面内显示')),
	array('Postshow', 'Text', 'Pageshow'), _t('面包屑导航显示'), _t('默认在文章与页面内显示，并将文章标题替换为"正文"'));
	$form->addInput($Breadcrumbs->multiMode());

	$HeadFixed = new Typecho_Widget_Helper_Form_Element_Radio('HeadFixed', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('浮动显示头部'), _t('默认关闭'));
	$form->addInput($HeadFixed);

	$SidebarFixed = new Typecho_Widget_Helper_Form_Element_Radio('SidebarFixed', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('动态显示侧边栏'), _t('默认关闭'));
	$form->addInput($SidebarFixed);

	// ============================================================
	// Section 6: 文章与打赏
	// ============================================================
	$h6 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-post', 'class' => 'bt-section-header']);
	$h6->html('文章与打赏');
	$form->addItem($h6);

	$thumbAPIurl = new Typecho_Widget_Helper_Form_Element_Text('thumbAPIurl', NULL, NULL, _t('随机缩略图API'), _t('在这里填入一个图片生成API地址, 以开启文章缩略图随机生成功能（每刷新一次更换一张随机图片）, 如：http://api.mtyqx.cn/api/random.php'));
	$form->addInput($thumbAPIurl);

	$postqr = new Typecho_Widget_Helper_Form_Element_Radio('postqr', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('生成文章二维码'), _t('默认关闭，启用则为每篇文章生成二维码,需要开启php的GD库'));
	$form->addInput($postqr);

	$LicenseInfo = new Typecho_Widget_Helper_Form_Element_Text('LicenseInfo', NULL, NULL, _t('文章许可信息'), _t('填入后将在文章底部显示你填入的许可信息（支持HTML标签），留空则默认为 (CC BY-SA 4.0)国际许可协议。'));
	$form->addInput($LicenseInfo);

	$WeChat = new Typecho_Widget_Helper_Form_Element_Text('WeChat', NULL, NULL, _t('自定义二维码1（建议图片尺寸不低于240*240）'), _t('输入格式：二维码名称=二维码图片URL地址，用等号隔开。示例：微信打赏=微信收款二维码URL地址'));
	$form->addInput($WeChat);

	$Alipay = new Typecho_Widget_Helper_Form_Element_Text('Alipay', NULL, NULL, _t('自定义二维码2（建议图片尺寸不低于240*240）'), _t('输入格式：二维码名称=二维码图片URL地址，示例：支付宝打赏=支付宝收款二维码URL地址'));
	$form->addInput($Alipay);

	$customqr3 = new Typecho_Widget_Helper_Form_Element_Text('customqr3', NULL, NULL, _t('自定义二维码3（建议图片尺寸不低于240*240）'), _t('输入格式：二维码名称=二维码图片URL地址，示例：微信公众号=微信公众号二维码URL地址'));
	$form->addInput($customqr3);

	$guanzhu = new Typecho_Widget_Helper_Form_Element_Textarea('guanzhu', NULL, NULL, _t('联系方式'), _t('按照格式输入你的联系方式，如格式：<br><b class="notice">类型=联系信息</b><br>类型与联系信息之间用等号"="分隔，不同类型换行即可，一行一个。<br><br>类型有：<b>qq、qqzone、weixin、weixingz（微信公众号）、weixinsp（微信视频号）、weibo、mail、github、gitee、csdn、zhihu、bilibili、steam</b><br>其中qq和qqzone直接填qq号，weixin、weixingz、weixinsp填微信的二维码图片，mail填邮箱地址，其他填个人页面网址。
	<br>例如：<br><b>qq=12345678</b><br><b>weixin=图片地址</b><br><b>mail=12345678@qq.com</b><br><b>github=个人页面网址</b>'));
	$form->addInput($guanzhu);

	// ============================================================
	// Section 7: 链接与轻语
	// ============================================================
	$h7 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-links', 'class' => 'bt-section-header']);
	$h7->html('链接与轻语');
	$form->addItem($h7);

	$InsideLinksIcon = new Typecho_Widget_Helper_Form_Element_Radio('InsideLinksIcon', 
	array(1 => _t('启用'),
	0 => _t('关闭')),
	0, _t('显示链接图标（内页）'), _t('默认关闭，启用后内页（链接模板）链接将显示链接图标'));
	$form->addInput($InsideLinksIcon);

	$IndexLinksSort = new Typecho_Widget_Helper_Form_Element_Text('IndexLinksSort', NULL, NULL, _t('首页显示的链接分类（支持多分类，请用英文逗号","分隔）'), _t('若只需显示某分类下的链接，请输入链接分类名（建议使用字母形式的分类名），留空则默认显示全部链接'));
	$form->addInput($IndexLinksSort);

	$InsideLinksSort = new Typecho_Widget_Helper_Form_Element_Text('InsideLinksSort', NULL, NULL, _t('内页（链接模板）显示的链接分类（支持多分类，请用英文逗号","分隔）'), _t('若只需显示某分类下的链接，请输入链接分类名（建议使用字母形式的分类名），留空则默认显示全部链接'));
	$form->addInput($InsideLinksSort);

	$ShowLinks = new Typecho_Widget_Helper_Form_Element_Checkbox('ShowLinks', array('footer' => _t('页脚'), 'sidebar' => _t('侧边栏')), NULL, _t('首页显示链接'));
	$form->addInput($ShowLinks->multiMode());

	$ShowWhisper = new Typecho_Widget_Helper_Form_Element_Checkbox('ShowWhisper', array('index' => _t('首页'), 'sidebar' => _t('侧边栏'), 'indexqy' => _t('↪首页轻语小屏显示')), NULL, _t('显示最新的"轻语"'), _t('启动侧边栏显示轻语后，首页轻语小屏显示才会生效，同时侧边栏显示最后发表轻语作者的头像和昵称'));
	$form->addInput($ShowWhisper->multiMode());

	// ============================================================
	// Section 8: 侧边栏
	// ============================================================
	$h8 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-sidebar', 'class' => 'bt-section-header']);
	$h8->html('侧边栏');
	$form->addItem($h8);

	$sidebarBlock = new Typecho_Widget_Helper_Form_Element_Checkbox('sidebarBlock', 
	array('blogonline' => _t('显示建站至今的时间'),
	'sitestat' => _t('显示全站文章、分类、评论总数'),
	'ShowHotPosts' => _t('显示热门文章（根据阅读数量排序）'),
	'ShowGoodPosts' => _t('显示好评文章（根据评论数量排序）'),
	'ShowRecentPosts' => _t('显示最新文章'),
	'ShowRecentComments' => _t('显示最近回复'),
	'IgnoreAuthor' => _t('↪不显示作者回复'),
	'ShowCategory' => _t('显示分类'),
	'ShowTag' => _t('显示标签'),
	'ShowArchive' => _t('显示归档'),
	'ShowOther' => _t('显示其它杂项')),
	array('blogonline', 'ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowTag', 'ShowArchive', 'ShowOther'), _t('侧边栏显示'), _t('显示建站至今的时间：依照发布的第一篇文章时间作为建站的时间。'));
	$form->addInput($sidebarBlock->multiMode());

	// ============================================================
	// Section 9: 音乐与底部
	// ============================================================
	$h9 = new Typecho_Widget_Helper_Layout('div', ['id' => 'sec-footer', 'class' => 'bt-section-header']);
	$h9->html('音乐与底部');
	$form->addItem($h9);

	$MusicSet = new Typecho_Widget_Helper_Form_Element_Radio('MusicSet', 
	array('order' => _t('顺序播放'),
	'shuffle' => _t('随机播放'),
	0 => _t('关闭')),
	0, _t('背景音乐（同时开启天气系统）'), _t('⚠️ 天气系统（导航栏实时温度+右下角切换按钮+雨雪粒子特效）依赖此开关，选择顺序/随机播放即可启用天气功能。如不需要音乐，音乐地址留空即可。'));
	$form->addInput($MusicSet);

	$AutoMusic = new Typecho_Widget_Helper_Form_Element_Radio('AutoMusic', 
	array(true => _t('自动播放'),
	false => _t('关闭')),
	false, _t('自动播放背景音乐'), _t('默认关闭，启用后打开网站自动播放背景音乐'));
	$form->addInput($AutoMusic);

	$MusicUrl = new Typecho_Widget_Helper_Form_Element_Textarea('MusicUrl', NULL, NULL, _t('背景音乐地址（建议使用mp3格式）'), _t('请输入完整的音频文件路径，例如：//music.163.com/song/media/outer/url?id={MusicID}.mp3（好东西^_-）,可设置多个音频，换行即可，一行一个，留空则关闭背景音乐'));
	$form->addInput($MusicUrl);

	$MusicVol = new Typecho_Widget_Helper_Form_Element_Text('MusicVol', NULL, NULL, _t('背景音乐播放音量（输入范围：0~100）'), _t('请输入一个0到100之间的整数（0为静音  50为50%音量  100为100%最大音量）。输入错误或留空则使用默认音量100%。'));
	$form->addInput($MusicVol);

	$ICPbeian = new Typecho_Widget_Helper_Form_Element_Text('ICPbeian', NULL, NULL, _t('ICP备案号'), _t('在这里输入ICP备案号,留空则不显示'));
	$form->addInput($ICPbeian);

	$GABeian = new Typecho_Widget_Helper_Form_Element_Text('GABeian', NULL, NULL, _t('公安备案号'), _t('在这里输入公安备案编号，例如"皖公网安备34170002000107号"，留空则不显示。将显示在底部版权区，与ICP备案号同行，公安备案在左、ICP备案在右'));
	$form->addInput($GABeian);

	$GABeianImg = new Typecho_Widget_Helper_Form_Element_Text('GABeianImg', NULL, NULL, _t('公安备案图标链接'), _t('可选。填写公安备案编号图标的图片URL后，图标将显示在公安备案编号左侧，留空则只显示备案编号文字'));
	$form->addInput($GABeianImg);

	$GABeianHeight = new Typecho_Widget_Helper_Form_Element_Text('GABeianHeight', NULL, NULL, _t('公安备案图标高度（像素）'), _t('可选。默认16px，图标按比例缩放保持纵横比；仅填写了图标链接时生效'));
	$form->addInput($GABeianHeight);

	$CustomContent = new Typecho_Widget_Helper_Form_Element_Textarea('CustomContent', NULL, NULL, _t('底部自定义内容'), _t('位于底部，footer之后body之前，适合放置一些JS内容，如网站统计代码等（若开启全站Pjax，目前支持Google和百度统计的回调，其余统计代码可能会不准确）'));
	$form->addInput($CustomContent);

	$serverruntime = new Typecho_Widget_Helper_Form_Element_Radio('serverruntime', 
	array('linux' => _t('Linux服务器'),
	0 => _t('关闭')),
	0, _t('服务器已运行时间（此功能仅管理员可见）'), _t('默认关闭，启用则会在网页最下方显示服务器已运行时间，以方便快速了解web服务器情况。注：本功能仅支持Linux服务器，Windows服务器无法使用'));
	$form->addInput($serverruntime);
}

/**
 * 主题初始化：在路由分发时进行配置覆盖与内容预处理。
 * 关闭反垃圾保护，根据 Pjax 启用状态调整评论排序与显示，
 * 处理单页内容的站外链接、CDN 替换和文章目录生成，加载短代码模块。
 *
 * @param Widget_Archive $archive 当前路由的 Archive 对象
 */
function themeInit($archive) {
	$options = Helper::options();
	$options->commentsAntiSpam = false;
	if ($options->PjaxOption || FindContents('page-whisper.php', 'commentsNum', 'd')) {
		$options->commentsOrder = 'DESC';
		$options->commentsPageDisplay = 'first';
	}
	if ($archive->is('single')) {
		$archive->content = hrefOpen($archive->content);
		if ($options->AttUrlReplace) {
			$archive->content = UrlReplace($archive->content);
		}
		if ($archive->fields->catalog) {
			$archive->content = createCatalog($archive->content);
		}
	}
	if ($options->duanma) {
		require_once __DIR__ . '/shortcode.php';
	}
	$comment = spam_protection_pre($comment, $post, $result);
}

/**
 * 评论算术验证码 HTML 生成。
 * 生成 20 以内加减法算术题的隐藏域和输入框，
 * 数字随机以阿拉伯数字或中文大写形式展示。
 * 登录会员无需输入。
 */
function spam_protection_math(){
	$num1=rand(0,20);
	$num2=rand(0,10);
	$numchs = array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖','拾');
	$num01 = array($num1,$numchs[$num1]);
	$num02 = array($num2,$numchs[$num2]);
	$num001 = $num01[array_rand($num01)];
	$num002 =  $num02[array_rand($num02)];
	$symbol = '+';
	if ($num1 > 10) { $num001 = $num1;$symbol = '-'; }
	if (is_numeric($num001)) { 	$num002 = $num02[1]; }
	echo '<div id="CAPTCHACode"><input type="text" name="sum" class="text" placeholder="'.$num001.' '.$symbol.' '.$num002.' = ? *" required>';
	echo '<input type="hidden" name="num1" value="'.$num1.'">';
	echo '<input type="hidden" name="num2" value="'.$num2.'"></div>';
}

/**
 * 评论算术验证码校验。
 * 比对用户提交的算术结果与预设值，
 * 验证失败则抛出异常阻止评论提交。
 *
 * @param array $comment 评论数据
 * @param mixed $post 文章对象
 * @param mixed $result 处理结果
 * @return array 通过验证的评论数据
 */
function spam_protection_pre($comment, $post, $result){
	$sum=$_POST['sum'];
	if ($_POST['num1'] > 10) {
		switch($sum) {
			case $_POST['num1']-$_POST['num2']:break;
			default:throw new Typecho_Widget_Exception(_t('对不起: 验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
		}
	} else {
		switch($sum) {
			case $_POST['num1']+$_POST['num2']:break;
			default:throw new Typecho_Widget_Exception(_t('对不起: 验证码错误，请<a href="javascript:history.back(-1)">返回</a>重试。','评论失败'));
		}
	}
	return $comment;
}

/**
 * 资源 URL 生成。
 * 若后台配置了 CDN 地址则输出 CDN 路径 + 版本号，
 * 否则输出主题本地路径 + 版本号。
 * 用于 CSS/JS 等静态资源的引用。
 *
 * @param string $path 相对于主题目录的文件路径
 */
function cjUrl($path) {
	$options = Helper::options();
	$ver = '?ver='.constant("INITIAL_VERSION_NUMBER");
	if ($options->cjcdnAddress) {
		echo rtrim($options->cjcdnAddress, '/').'/'.$path.$ver;
	} else {
		$options->themeUrl($path.$ver);
	}
}

// 设置时区
date_default_timezone_set('Asia/Shanghai');

/**
 * 主题样式/背景 URL 生成（支持白天/夜间/自动模式切换）。
 * 根据后台配置的模式（white/dark/auto）及访客 Cookie 偏好，
 * 输出对应模式的样式文件路径或样式 ID 名。
 * 支持 CDN 替换与版本号追加。
 *
 * @param string $path 样式文件路径前缀
 * @param string $ext 文件扩展名（如 .css）
 * @param string|null $skinid 若为 'id' 则仅输出样式标识名（style-white/style-dark）
 */
function skinUrl($path,$ext,$skinid = NULL) {
	$options = Helper::options();
	$ver = '?ver='.constant("INITIAL_VERSION_NUMBER");
	if (!empty($options->skinoptions) && in_array('free', $options->skinoptions) && isset($_COOKIE["stylemode"]) && $_COOKIE["stylemode"] == "dark") {
		if ($skinid=='id') {
			echo 'style-dark';
		} elseif ($options->cjcdnAddress) {
			echo rtrim($options->cjcdnAddress, '/').'/'.$path.'style-dark'.$ext.$ver;
		} else {
			$options->themeUrl($path.'style-dark'.$ext.$ver);
		}
	} elseif (!empty($options->skinoptions) && in_array('free', $options->skinoptions) && isset($_COOKIE["stylemode"]) && $_COOKIE["stylemode"] == "white") {
		if ($skinid=='id') {
			echo 'style-white';
		} elseif ($options->cjcdnAddress) {
			echo rtrim($options->cjcdnAddress, '/').'/'.$path.'style-white'.$ext.$ver;
		} else {
			$options->themeUrl($path.'style-white'.$ext.$ver);
		}
	} elseif ($options->siteskin == 'auto' && (date('G') < 6 || date('G') >= 20)) {
		if ($skinid=='id') {
			echo 'style-dark';
		} elseif ($options->cjcdnAddress) {
			echo rtrim($options->cjcdnAddress, '/').'/'.$path.'style-dark'.$ext.$ver;
		} else {
			$options->themeUrl($path.'style-dark'.$ext.$ver);
		}
	} elseif ($options->siteskin == 'dark') {
		if ($skinid=='id') {
			echo 'style-dark';
		} elseif ($options->cjcdnAddress) {
			echo rtrim($options->cjcdnAddress, '/').'/'.$path.'style-dark'.$ext.$ver;
		} else {
			$options->themeUrl($path.'style-dark'.$ext.$ver);
		}
	} else {
		if ($skinid=='id') {
			echo 'style-white';
		} elseif ($options->cjcdnAddress) {
			echo rtrim($options->cjcdnAddress, '/').'/'.$path.'style-white'.$ext.$ver;
		} else {
			$options->themeUrl($path.'style-white'.$ext.$ver);
		}
	}
}

/**
 * 计算并输出服务器运行时间或建站至今时长。
 * $sys='linux' 时读取 /proc/uptime 获取服务器连续运行时间（仅管理员可见）；
 * 否则依据第一篇博客文章的发布时间计算建站至今的天/时/分。
 *
 * @param string|null $sys 传入 'linux' 表示统计服务器运行时间
 */
function getBuildTime($sys = NULL) {
	$options = Helper::options();
	if ($sys == 'linux') {
		if (!$options->serverruntime) return false;
		if (false === ($time = @file("/proc/uptime"))) return false;
		$time = explode(" ", implode("", $time));
		$time = trim($time[0]);
	} else {
		if (empty($options->sidebarBlock) || !in_array('blogonline', $options->sidebarBlock)) return false;
		$db = Typecho_Db::get();
		$comment = $db->fetchAll($db->select()->from('table.contents')
			->where('type = ?', 'post')
			->order('cid', Typecho_Db::SORT_ASC)
			->limit(1));
		if ($comment) {	
			$time = time() - $comment[0]['created'];
		} else { $time = false; }
	}
	if($time && $time != false && is_numeric($time)) {
		$value = array(/*"years" => 0, */"days" => 0, "hours" => 0, "minutes" => 0, "seconds" => 0,);
		/*if($time >= 31556926){
			$value["years"] = floor($time/31556926);
			$time = ($time%31556926);
		}*/
		if($time >= 86400) {
			$value["days"] = floor($time/86400);
			$time = ($time%86400);
		}
		if($time >= 3600) {
			$value["hours"] = floor($time/3600);
			$time = ($time%3600);
		}
		if($time >= 60) {
			$value["minutes"] = floor($time/60);
			$time = ($time%60);
		}
		$value["seconds"] = floor($time);
		if ($sys == 'linux') {
			echo '服务器连续运行: ';
			if ($value['days'] != 0) echo $value['days']."天";
			if ($value['hours'] != 0) echo $value['hours']."小时";
			if ($value['minutes'] != 0) echo $value['minutes']."分钟";
		} else {
			echo 'BLOG ONLINE ';
			if ($value['days'] != 0) echo '<strong>'.$value['days'].'</strong> DAYS ';
			if ($value['hours'] != 0) echo '<strong>'.$value['hours'].'</strong> HOURS ';
			if ($value['days'] == 0 && $value['minutes'] != 0) echo '<strong>'.$value['minutes'].'</strong> MINS';
		}
	} else {
		echo '<span style="color:white;background-color:black;">时间显示错误！</span>';
	}
}

/**
 * 将文章内容中的站外链接自动添加 target="_blank"。
 * 匹配非本站域名（含排除首页 # 锚点）的 <a> 标签，
 * 追加新窗口打开属性。
 *
 * @param string $obj 文章 HTML 内容
 * @return string 处理后的 HTML
 */
function hrefOpen($obj) {
	return preg_replace('/<a\b([^>]+?)\bhref="((?!'.addcslashes(Helper::options()->index, '/._-+=#?&').'|\#).*?)"([^>]*?)>/i', '<a\1href="\2"\3 target="_blank">', $obj);
}

/**
 * 文章内容中的 URL 替换（用于 CDN 镜像）。
 * 按后台配置的"原地址=替换地址"规则逐行替换，
 * 可用于将静态资源链接指向 CDN。
 *
 * @param string $obj 文章 HTML 内容
 * @return string 替换后的 HTML
 */
function UrlReplace($obj) {
	$list = explode("\r\n", Helper::options()->AttUrlReplace);
	foreach ($list as $tmp) {
		list($old, $new) = explode('=', $tmp);
		$obj = str_replace($old, $new, $obj);
	}
	return $obj;
}

/**
 * 根据序号返回自定义二维码的名称或 URL。
 * 支持三个自定义二维码（微信打赏、支付宝打赏、自定义），
 * 数据格式为"名称=图片URL"。
 *
 * @param int|null $order 二维码序号（1/2/3）
 * @param string|null $type NULL 返回名称，非 NULL 返回 URL
 * @return string|null 二维码名称或 URL
 */
function customqr($order = NULL,$type = NULL) {
	$options = Helper::options();
	if ( $order == 1 ) {
		list($name, $url) = explode('=', $options->WeChat);
	} elseif ( $order == 2 ) {
		list($name, $url) = explode('=', $options->Alipay);
	} elseif ( $order == 3 ) {
		list($name, $url) = explode('=', $options->customqr3);
	}
	$obj = $type ? $url : $name;
	return $obj;
}

/**
 * 根据类型返回联系方式数据。
 * 从后台配置的"类型=联系信息"列表中按类型名匹配，
 * 支持 qq、weixin、mail、github 等多种社交平台。
 *
 * @param string $type 联系方式类型（如 qq、weixin、mail）
 * @return string|null 匹配到的联系信息
 */
function guanzhu($type) {
	$list = explode("\r\n", Helper::options()->guanzhu);
	foreach ($list as $tmp) {
		list($old, $data) = explode('=', $tmp);
		if($old == $type) {
			return $data;
		}
	}
}

/**
 * 获取文章缩略图 HTML。
 * 优先使用自定义缩略图（支持纯数字表示取文章第 N 张图）；
 * 未设置时若开启了随机缩略图 API 则使用 API 生成；
 * 支持懒加载（data-original 属性）。
 *
 * @param Widget_Archive $obj 文章对象
 * @return string|false 缩略图 HTML 或 false
 */
function postThumb($obj) {
	$options = Helper::options();
	$thumb = $obj->fields->thumb;
	if ($options->thumbAPIurl) {
		$thumbAPI = $obj->fields->thumbAPI;
	} else {
		$thumbAPI = false;
	}
	if (!$thumb && !$thumbAPI) {
		return false;
	}
	if ($thumb) {
		if (is_numeric($thumb)) {
			preg_match_all('/<img.*?src="(.*?)".*?[\/]?>/i', $obj->content, $matches);
			if (isset($matches[1][$thumb-1])) {
				$thumb = $matches[1][$thumb-1];
			} else {
				return false;
			}
		}
		if ($options->AttUrlReplace) {
			$thumb = UrlReplace($thumb);
		}
		return $img = $options->lazyimg ? '<img src="'.$options->themeUrl.'/img/postThumb-load.gif" data-original="'.$thumb.'">' : '<img src="'.$thumb.'">';
	} else {
		return $img = $options->lazyimg ? '<img src="'.$options->themeUrl.'/img/postThumb-load.gif" data-original="'.$options->thumbAPIurl.'?$'.$obj->cid.'">' : '<img src="'.$options->thumbAPIurl.'?$'.$obj->cid.'">';
	}
}

/*
function postfocusimg($obj) {
	$focusimg = $obj->fields->focusimg;
	if (!$focusimg) {
		return false;
	}
	return '<img src="'. Helper::options()->themeUrl .'/img/'.$focusimg.'" />';
}
*/

/**
 * 获取文章简介内容。
 * 读取自定义字段 outline，将换行符替换为 <br> 标签后返回。
 *
 * @param Widget_Archive $obj 文章对象
 * @return string|false 简介 HTML 或 false
 */
function postOutline($obj) {
	$outline = $obj->fields->outline;
	if (!$outline) {
		return false;
	}
	return str_replace("\r\n", "<br>", $outline);
}

/**
 * 文章阅读计数（含 Cookie 去重）。
 * 若 contents 表无 views 字段则自动添加；
 * 同一 Cookie 一小时内重复访问不计数。
 *
 * @param Widget_Archive $archive 文章归档对象
 */
function Postviews($archive) {
	$db = Typecho_Db::get();
	$cid = $archive->cid;
	if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
		$db->query('ALTER TABLE `'.$db->getPrefix().'contents` ADD `views` INT(10) DEFAULT 0;');
	}
	$exist = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid))['views'];
	if ($archive->is('single')) {
		$cookie = Typecho_Cookie::get('contents_views');
		$cookie = $cookie ? explode(',', $cookie) : array();
		if (!in_array($cid, $cookie)) {
			$db->query($db->update('table.contents')
				->rows(array('views' => (int)$exist+1))
				->where('cid = ?', $cid));
			$exist = (int)$exist+1;
			array_push($cookie, $cid);
			$cookie = implode(',', $cookie);
			Typecho_Cookie::set('contents_views', $cookie, time()+3600);
		}
	}
	echo $exist == 0 ? '暂无' : $exist;
}

/**
 * 为文章内容生成锚点目录（处理 h1-h6 标题）。
 * 通过正则匹配所有标题标签，插入锚点 a 标签，
 * 并在文章末尾追加由 getCatalog() 生成的目录 HTML。
 *
 * @param string $obj 文章原始内容
 * @return string 添加锚点与目录后的内容
 */
function createCatalog($obj) {
	global $catalog;
	global $catalog_count;
	$catalog = array();
	$catalog_count = 0;
	$obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($obj) {
		global $catalog;
		global $catalog_count;
		$catalog_count ++;
		$catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
		return '<h'.$obj[1].$obj[2].'><a class="cl-offset" name="cl-'.$catalog_count.'"></a>'.$obj[3].'</h'.$obj[1].'>';
	}, $obj);
	return $obj."\n".getCatalog();
}

/**
 * 根据已解析的目录数据生成 HTML 目录结构。
 * 读取全局变量 $catalog 中的标题层级信息，
 * 递归生成嵌套 <ul>/<li> 列表，含折叠交互脚本。
 *
 * @return string 目录 HTML（含 JS 折叠功能）
 */
function getCatalog() {
	global $catalog;
	$index = '';
	if ($catalog) {
		$index = '<ul>'."\n";
		$prev_depth = '';
		$to_depth = 0;
		foreach($catalog as $catalog_item) {
			$catalog_depth = $catalog_item['depth'];
			if ($prev_depth) {
				if ($catalog_depth == $prev_depth) {
					$index .= '</li>'."\n";
				} elseif ($catalog_depth > $prev_depth) {
					$to_depth++;
					$index .= "\n".'<ul>'."\n";
				} else {
					$to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
					if ($to_depth2) {
						for ($i=0; $i<$to_depth2; $i++) {
							$index .= '</li>'."\n".'</ul>'."\n";
							$to_depth--;
						}
					}
					$index .= '</li>'."\n";
				}
			}
			$index .= '<li><a href="#cl-'.$catalog_item['count'].'" onclick="Catalogswith()">'.$catalog_item['text'].'</a>';
			$prev_depth = $catalog_item['depth'];
		}
		for ($i=0; $i<=$to_depth; $i++) {
			$index .= '</li>'."\n".'</ul>'."\n";
		}
	$index = '<div id="catalog-col">'."\n".'<b>文章目录</b>'."\n".$index.'<script>function Catalogswith(){document.getElementById("catalog-col").classList.toggle("catalog");document.getElementById("catalog").classList.toggle("catalog")}</script>'."\n".'</div>'."\n";
	}
	return $index;
}

/**
 * 输出评论作者链接（支持 nofollow/新窗口）。
 * 若评论者填写了 URL 且启用了链接显示，
 * 则输出带 rel="external nofollow" 和 target="_blank" 的可点击链接。
 *
 * @param Widget_Archive $obj 评论对象
 * @param bool|null $autoLink 是否显示链接（默认取系统配置）
 * @param bool|null $noFollow 是否添加 nofollow（默认取系统配置）
 */
function CommentAuthor($obj, $autoLink = NULL, $noFollow = NULL) {
	$options = Helper::options();
	$autoLink = $autoLink ? $autoLink : $options->commentsShowUrl;
	$noFollow = $noFollow ? $noFollow : $options->commentsUrlNofollow;
	if ($obj->url && $autoLink) {
		echo '<a href="'.$obj->url.'"'.($noFollow ? ' rel="external nofollow"' : NULL).(strstr($obj->url, $options->index) == $obj->url ? NULL : ' target="_blank"').'>'.$obj->author.'</a>';
	} else {
		echo $obj->author;
	}
}

/**
 * 输出评论回复的 @提及标签。
 * 查询当前评论的父级评论作者名，
 * 在回复内容前显示 "@作者名"。
 *
 * @param int $coid 当前评论 ID
 */
function CommentAt($coid){
	$db = Typecho_Db::get();
	$prow = $db->fetchRow($db->select('parent')->from('table.comments')
		->where('coid = ? AND status = ?', $coid, 'approved'));
	$parent = $prow['parent'];
	if ($prow && $parent != '0') {
		$arow = $db->fetchRow($db->select('author')->from('table.comments')
			->where('coid = ? AND status = ?', $parent, 'approved'));
		echo '<b class="comment-at">@'.$arow['author'].'</b>';
	}
}

/**
 * 获取并输出文章列表（用于侧边栏）。
 * 按指定排序方式获取最新发布的文章标题列表，
 * 输出 <li> 格式的 HTML。
 *
 * @param int $limit 获取数量，默认 10
 * @param string $order 排序字段，默认 created
 */
function Contents_Post_Initial($limit = 10, $order = 'created') {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$posts = $db->fetchAll($db->select()->from('table.contents')
		->where('type = ? AND status = ? AND created < ?', 'post', 'publish', $options->time)
		->order($order, Typecho_Db::SORT_DESC)
		->limit($limit), array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
	if ($posts) {
		foreach($posts as $post) {
			echo '<li><a'.($post['hidden'] && $options->PjaxOption ? '' : ' href="'.$post['permalink'].'"').'>'.htmlspecialchars($post['title']).'</a></li>'."\n";
		}
	} else {
		echo '<li>暂无文章</li>'."\n";
	}
}

/**
 * 获取并输出评论列表（用于侧边栏，支持忽略作者）。
 * 查询最新评论，可过滤仅显示访客评论（忽略作者回复），
 * 并自动排除"轻语"页面的非回复评论。
 *
 * @param int $limit 获取数量，默认 10
 * @param int $ignoreAuthor 1=忽略作者回复，0=不过滤
 */
function Contents_Comments_Initial($limit = 10, $ignoreAuthor = 0) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$select = $db->select()->from('table.comments')
		->where('status = ? AND created < ?','approved', $options->time)
		->order('coid', Typecho_Db::SORT_DESC)
		->limit($limit);
	if ($options->commentsShowCommentOnly) {
		$select->where('type = ?', 'comment');
	}
	if ($ignoreAuthor == 1) {
		$select->where('ownerId <> authorId');
	}
	$page_whisper = FindContents('page-whisper.php', 'commentsNum', 'd');
	if ($page_whisper) {
		$select->where('cid <> ? OR (cid = ? AND parent <> ?)', $page_whisper[0]['cid'], $page_whisper[0]['cid'], '0');
	}
	$comments = $db->fetchAll($select);
	if ($comments) {
		foreach($comments as $comment) {
			$parent = FindContent($comment['cid']);
			echo '<li><a'.($parent['hidden'] && $options->PjaxOption ? '' : ' href="'.permaLink($comment).'"').' title="来自: '.$parent['title'].'">'.$comment['author'].'</a>: '.($parent['hidden'] && $options->PjaxOption ? '内容被隐藏' : Typecho_Common::subStr(strip_tags($comment['text']), 0, 35, '...')).'</li>'."\n";
		}
	} else {
		echo '<li>暂无回复</li>'."\n";
	}
}

/**
 * 生成评论的完整永久链接（含分页锚点）。
 * 根据评论所在文章和分页设置，
 * 计算评论所在页码并生成 #type-coid 锚点链接。
 *
 * @param array $obj 评论数据（含 cid、coid、parent、status）
 * @return string 完整永久链接 URL
 */
function permaLink($obj) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$parentContent = FindContent($obj['cid']);
	if ($options->commentsPageBreak && 'approved' == $obj['status']) {
		$coid = $obj['coid'];
		$parent = $obj['parent'];
		while ($parent > 0 && $options->commentsThreaded) {
			$parentRows = $db->fetchRow($db->select('parent')->from('table.comments')
			->where('coid = ? AND status = ?', $parent, 'approved')->limit(1));
			if (!empty($parentRows)) {
				$coid = $parent;
				$parent = $parentRows['parent'];
			} else {
				break;
			}
		}
		$select  = $db->select('coid', 'parent')->from('table.comments')
			->where('cid = ? AND status = ?', $parentContent['cid'], 'approved')
			->where('coid '.('DESC' == $options->commentsOrder ? '>=' : '<=').' ?', $coid)
			->order('coid', Typecho_Db::SORT_ASC);
		if ($options->commentsShowCommentOnly) {
			$select->where('type = ?', 'comment');
		}
		$comments = $db->fetchAll($select);
		$commentsMap = array();
		$total = 0;
		foreach ($comments as $comment) {
			$commentsMap[$comment['coid']] = $comment['parent'];
			if (0 == $comment['parent'] || !isset($commentsMap[$comment['parent']])) {
				$total ++;
			}
		}
		$currentPage = ceil($total / $options->commentsPageSize);
		$pageRow = array('permalink' => $parentContent['pathinfo'], 'commentPage' => $currentPage);
		return Typecho_Router::url('comment_page', $pageRow, $options->index).'#'.$obj['type'].'-'.$obj['coid'];
	}
	return $parentContent['permalink'].'#'.$obj['type'].'-'.$obj['coid'];
}

/**
 * 根据 cid 查询单篇文章/页面内容。
 * 便捷封装，通过 Typecho_Db 查询 contents 表并应用过滤器。
 *
 * @param int $cid 内容 ID
 * @return array 经过 filter 的文章数据
 */
function FindContent($cid) {
	$db = Typecho_Db::get();
	return $db->fetchRow($db->select()->from('table.contents')
	->where('cid = ?', $cid)
	->limit(1), array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
}

/**
 * 按模板/排序条件查询内容列表。
 * 支持按页面模板名筛选、自定义排序方向和排序字段，
 * 可选择仅查询已发布内容。
 *
 * @param string|null $val 页面模板文件名（如 page-whisper.php）
 * @param string $order 排序字段，默认 order
 * @param string $sort 排序方向：'a' 升序 / 'd' 降序
 * @param string|null $publish 非空则仅返回已发布状态
 * @return array|false 文章列表或 false
 */
function FindContents($val = NULL, $order = 'order', $sort = 'a', $publish = NULL) {
	$db = Typecho_Db::get();
	$sort = ($sort == 'a') ? Typecho_Db::SORT_ASC : Typecho_Db::SORT_DESC;
	$select = $db->select()->from('table.contents')
		->where('created < ?', Helper::options()->time)
		->order($order, $sort);
	if ($val) {
		$select->where('template = ?', $val);
	}
	if ($publish) {
		$select->where('status = ?','publish');
	}
	$content = $db->fetchAll($select, array(Typecho_Widget::widget('Widget_Abstract_Contents'), 'filter'));
	return empty($content) ? false : $content;
}

/**
 * 获取并输出"轻语"内容（基于评论系统实现）。
 * 从指定模板页面的评论中提取最新一条顶级评论作为轻语展示，
 * 支持获取作者 ID、邮箱、昵称等元信息。
 *
 * @param bool|null $sidebar 是否为侧边栏模式（影响输出标签）
 * @param int|null $uid 指定用户 ID，仅显示该用户的轻语
 * @param string|null $type 返回类型：authorId/mail/author 或 NULL 直接输出
 */
function Whisper($sidebar = NULL,$uid = NULL,$type = NULL) {
	$db = Typecho_Db::get();
	$options = Helper::options();
	$page = FindContents('page-whisper.php', 'commentsNum', 'd');
	$p = $sidebar ? 'li' : 'p';
	if ($page) {
		$page = $page[0];
		//$title = $sidebar ? '' : '<h2 class="post-title"><a href="'.$page['permalink'].'">'.$page['title'].'<span class="more">···</span></a></h2>'."\n";
		if ($uid) {
			$comment = $db->fetchAll($db->select()->from('table.comments')
				->where('cid = ? AND status = ? AND parent = ? AND authorId = ?', $page['cid'], 'approved', '0', $uid)
				->order('coid', Typecho_Db::SORT_DESC)
				->limit(1));
		} else {
			$comment = $db->fetchAll($db->select()->from('table.comments')
				->where('cid = ? AND status = ? AND parent = ?', $page['cid'], 'approved', '0')
				->order('coid', Typecho_Db::SORT_DESC)
				->limit(1));
		}
		if ($comment) {
			if ($type == 'authorId') {
				return $comment[0]['authorId'];
			} elseif ($type == 'mail') {
				return $comment[0]['mail'];
			} elseif ($type == 'author') {
				return $comment[0]['author'];
			} else {
				$content = hrefOpen(Markdown::convert(($sidebar ? '' : '<b>'.$comment[0]['author'].':</b>&nbsp;').$comment[0]['text'].'&nbsp;<a title="更多:&nbsp;'.$page['title'].'" href="'.$page['permalink'].'">more...</a>'));
				if ($options->AttUrlReplace) {
					$content = UrlReplace($content);
				}
				echo $title.strip_tags($content, '<p><strong><b><span><a>'.$options->commentsHTMLTagAllowed)."\n".($sidebar ? ''."\n" : '');
				//echo $title.strip_tags($content, '<p><br><strong><a><img><pre><code>'.$options->commentsHTMLTagAllowed)."\n".($sidebar ? '<li class="more"><a href="'.$page['permalink'].'">more...</a></li>'."\n" : '<li class="more"><a href="'.$page['permalink'].'">more...</a></li>');
			}
		} else {
			if ($type) {
				return NULL;
			} else {
				echo $title.'<'.$p.'><a title="进入:&nbsp;'.$page['title'].'" href="'.$page['permalink'].'">暂无发布内容</a></'.$p.'>'."\n";
			}
		}
	} else {
		if ($type) {
			return NULL;
		} else {
			echo ($sidebar ? '' : ''."\n").'<'.$p.'><a title="进入:&nbsp;'.$page['title'].'" href="'.$page['permalink'].'">暂无发布内容</a></'.$p.'>'."\n";
		}
	}
}

/**
 * 获取并输出友链列表（支持分类筛选和图标）。
 * 从链接模板页的自定义字段中读取链接数据，
 * 按分类过滤，可选显示网站图标（从 logo 字段或域名 /favicon.ico 获取）。
 *
 * @param string|null $sorts 分类名（逗号分隔多个分类）
 * @param int $icon 1=显示图标，0=不显示
 */
function Links($sorts = NULL, $icon = 0) {
	$db = Typecho_Db::get();
	$link = NULL;
	$list = NULL;
	$page_links = FindContents('page-links.php', 'order', 'a');
	if ($page_links) {
		$exist = $db->fetchRow($db->select()->from('table.fields')
			->where('cid = ? AND name = ?', $page_links[0]['cid'], 'links'));
		if (empty($exist)) {
			$db->query($db->insert('table.fields')
				->rows(array(
					'cid'           =>  $page_links[0]['cid'],
					'name'          =>  'links',
					'type'          =>  'str',
					'str_value'     =>  NULL,
					'int_value'     =>  0,
					'float_value'   =>  0
				)));
			return NULL;
		}
		$list = $exist['str_value'];
	}
	if ($list) {
		$list = explode("\r\n", $list);
		foreach ($list as $val) {
			list($name, $url, $description, $logo, $sort, $urlbak) = explode(',', $val);
			if ($sorts) {
				$arr = explode(',', $sorts);
				if ($sort && in_array($sort, $arr)) {
					$link .= '<li><a'.($url ? ' href="'.$url.'"' : ($urlbak ? ' href="'.$urlbak.'"' : '')).($icon==1&&$url ? ' class="l_logo"' : '').' title="'.$description.'" target="_blank">'.($icon==1&&$url ? '<img src="'.($logo ? $logo : rtrim($url, '/').'/favicon.ico').'" onerror="erroricon(this)">' : '').'<span>'.($url ? $name : '<del>'.$name.'</del>').'</span></a></li>'."\n";
				}
			} else {
				$link .= '<li><a'.($url ? ' href="'.$url.'"' : ($urlbak ? ' href="'.$urlbak.'"' : '')).($icon==1&&$url ? ' class="l_logo"' : '').' title="'.$description.'" target="_blank">'.($icon==1&&$url ? '<img src="'.($logo ? $logo : rtrim($url, '/').'/favicon.ico').'" onerror="erroricon(this)">' : '').'<span>'.($url ? $name : '<del>'.$name.'</del>').'</span></a></li>'."\n";
			}
		}
	}
	echo $link ? $link : '<li>暂无链接</li>'."\n";
}

/**
 * 以 JSON 数组格式输出背景音乐列表。
 * 读取后台配置的 MusicUrl（多行），
 * 若设为随机播放则打乱顺序，输出 ["url1","url2",...] 格式。
 */
function Playlist() {
	$options = Helper::options();
	$arr = explode("\r\n", $options->MusicUrl);
	if ($options->MusicSet == 'shuffle') {
		shuffle($arr);
	}
	echo '["'.implode('","', $arr).'"]';
}

/**
 * HTML 代码压缩（保留 pre/textarea/script 区域）。
 * 利用正则分割保留区域，移除多余空白、换行、注释；
 * 特别处理脚本中的行注释（//），避免误删字符串内的内容。
 *
 * @param string $html_source 原始 HTML 源码
 * @return string 压缩后的 HTML
 */
function compressHtml($html_source) {
	$chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
	$compress = '';
	foreach ($chunks as $c) {
		if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
			$c = substr($c, 19, strlen($c) - 19 - 20);
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
			$c = substr($c, 12, strlen($c) - 12 - 13);
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
			$compress .= $c;
			continue;
		} else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
			$tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
			$c = '';
			foreach ($tmps as $tmp) {
				if (strpos($tmp, '//') !== false) {
					if (substr(trim($tmp), 0, 2) == '//') {
						continue;
					}
					$chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
					$is_quot = $is_apos = false;
					foreach ($chars as $key => $char) {
						if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
							$is_quot = !$is_quot;
						} else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
							$is_apos = !$is_apos;
						} else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
							$tmp = substr($tmp, 0, $key);
							break;
						}
					}
				}
				$c .= $tmp;
			}
		}
		$c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
		$c = preg_replace('/\\s{2,}/', ' ', $c);
		$c = preg_replace('/>\\s</', '> <', $c);
		$c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
		$c = preg_replace('/<!--[^!]*-->/', '', $c);
		$compress .= $c;
	}
	return $compress;
}

/**
 * 统计指定用户的文章/评论/附件数量。
 * 根据 type 参数分别统计 posts（文章）、comments（评论）、attachments（附件）数量。
 *
 * @param int $id 用户 ID
 * @param string $type 统计类型：post / comment / attachment
 * @return int 对应数量
 */
function userstat($id,$type) {
	$db = Typecho_Db::get();
	if ($type == 'comment') {
		$commentnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allcommentnum'))->from ('table.comments')->where ('table.comments.authorId=?',$id)->where('table.comments.type=? AND status=?', 'comment', 'approved'));
		$commentnum = $commentnum['allcommentnum'];
		return $commentnum;
	} elseif ($type == 'attachment') {
		$attachmentnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allattachmentnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=? AND status=?', 'attachment', 'publish'));
		$attachmentnum = $attachmentnum['allattachmentnum'];
		return $attachmentnum;
	} else {
		$postnum=$db->fetchRow($db->select(array('COUNT(authorId)'=>'allpostnum'))->from ('table.contents')->where ('table.contents.authorId=?',$id)->where('table.contents.type=?', 'post'));
		$postnum = $postnum['allpostnum'];
		return $postnum;
	}
}

/**
 * 返回随机彩色标签样式。
 * 从 14 种预设颜色中随机选取一种，
 * 生成内联 style 字符串用于标签云显示。
 *
 * @return string|false 样式字符串或 false（未启用时）
 */
function colortags() {
	if (empty(Helper::options()->colortags)) {
		return false;
	}
	$colorarr=array("#ffc61b","#4e8ef0","#ff6f6f","#c0c0c0","#add8e6","#00bfff","#d9b999","#ffb380","#da99ff","#eca9a7","#aedcae","#428bca","#f47b20","#5c7e10");
	$n=array_rand($colorarr,1);
	return 'style="border:0px;color:#fff;background-color:'.$colorarr[$n].'"';
}

/**
 * 处理文章内容（图片懒加载/灯箱/短代码解析）。
 * 根据后台配置的 lazyload 和 fancybox 开关，
 * 对文章中的 <img> 标签进行不同策略的替换，
 * 然后执行短代码解析，最后输出处理后的内容。
 *
 * @param Widget_Archive $obj 文章对象（其 content 属性会被修改）
 */
function parseContent($obj) {
	$options = Helper::options();
	if ($options->lazyimg && $options->fancybox) { //lazyimg图片懒加载和fancybox灯箱正则替换<img>
		$obj->content = preg_replace(['/\<img.*?src\=\"(.*?)\"[^>]*>/i'],['<a href="$1" data-fancybox="gallery"><img src="'.$options->themeUrl.'/img/load.gif" data-original="$1" alt="'.$obj->title.'" title="点击放大图片"></a>'],$obj->content);
	} elseif ($options->lazyimg) { //lazyimg图片懒加载<img>
		$obj->content = preg_replace(['/\<img.*?src\=\"(.*?)\"[^>]*>/i'],['<img src="'.$options->themeUrl.'/img/load.gif" data-original="$1" alt="'.$obj->title.'" title="'.$obj->title.'">'],$obj->content);
	} elseif ($options->fancybox) { //fancybox灯箱正则替换<img>
		$obj->content = preg_replace(['/\<img.*?src\=\"(.*?)\"[^>]*>/i'],['<a href="$1" data-fancybox="gallery"><img src="$1" alt="'.$obj->title.'" title="点击放大图片"></a>'],$obj->content);
	}
	//加载短代码
	if ($options->duanma) {
		$obj->content = do_shortcode($obj->content);
	}
	//输出内容
	echo trim($obj->content);
}

function themeFields($layout) {
	// 使用本地文件路径而非 HTTPS URL，避免 PHP 8.4 下 SSL 验证失败导致 TypeError
	$bzFile = __TYPECHO_ROOT_DIR__ . '/usr/themes/initial_plus/lib/bz.txt';
	$dmFile = __TYPECHO_ROOT_DIR__ . '/usr/themes/initial_plus/lib/dm.txt';

	$bzdata = array();
	$dmdata = array();

	if (is_file($bzFile) && is_readable($bzFile)) {
		$lines = @file($bzFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (is_array($lines)) {
			$bzdata = array_values(array_filter($lines, function ($v) {
				return trim($v) !== '';
			}));
		}
	}

	if (is_file($dmFile) && is_readable($dmFile)) {
		$lines = @file($dmFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
		if (is_array($lines)) {
			$dmdata = array_values(array_filter($lines, function ($v) {
				return trim($v) !== '';
			}));
		}
	}

	// 随机取一行，数据为空时返回空字符串
	$bzresult = !empty($bzdata) ? trim($bzdata[array_rand($bzdata)]) : '';
	$dmresult = !empty($dmdata) ? trim($dmdata[array_rand($dmdata)]) : '';
	// 随机选择服务器
	$server = array("1","x1","2","x2","3","x3","4","x4");
	$server = $server[array_rand($server)];
	
	$bzurl = $bzresult ? '<font color=#0000ff>//tva'.$server.'.sinaimg.cn/wap800/'.$bzresult.'.jpg</font>' : '<font color=#ff0000><b>主题目录lib下【'.$bztxt.'】数据文件错误！！！</b></font>';
	$dmurl = $dmresult ? '<font color=#ff0000>//tva'.$server.'.sinaimg.cn/wap800/'.$dmresult.'.jpg</font>' : '<font color=#ff0000><b>主题目录lib下【'.$dmtxt.'】数据文件错误！！！</b></font>';

	$pbzurl = $bzresult ? '<a href="###" title="炫酷壁纸预览" alt="炫酷壁纸预览" onclick="window.open(\'//tva'.$server.'.sinaimg.cn/large/'.$bzresult.'.jpg\',\'_blank\')"><img src="//tva'.$server.'.sinaimg.cn/wap180/'.$bzresult.'.jpg" style="margin:10px 10px 0px 0px"></a>' : '';
	$pdmurl = $dmresult ? '<a href="###" title="二次元动漫预览" alt="二次元动漫预览" onclick="window.open(\'//tva'.$server.'.sinaimg.cn/large/'.$dmresult.'.jpg\',\'_blank\')"><img src="//tva'.$server.'.sinaimg.cn/wap180/'.$dmresult.'.jpg" style="margin:10px 10px 0px 0px"></a>' : '';

	$thumb = new Typecho_Widget_Helper_Form_Element_Text('thumb', NULL, NULL, _t('自定义缩略图'), _t('在这里填入一个图片 URL 地址, 以添加本文的缩略图，若填入纯数字，例如 <b>3</b> ，则使用文章第三张图片作为缩略图（对应位置无图则不显示缩略图），留空则默认不显示自定义缩略图'));
	$thumb->input->setAttribute('class', 'w-100');
	$layout->addItem($thumb);

	if ($options->thumbAPIurl) {
		$thumbAPI = new Typecho_Widget_Helper_Form_Element_Radio('thumbAPI', 
		array(true => _t('启用'),
		false => _t('关闭')),
		false, _t('随机缩略图API'), _t('默认关闭，启用则会根据“主题设置”中的图片api地址自动生成图片，每刷新一次页面都会自动更换。注意：【自定义缩略图】有图片url，则优先显示【自定义缩略图】中的图片'));
		$layout->addItem($thumbAPI);
	}

	$original = new Typecho_Widget_Helper_Form_Element_Text('original', NULL, NULL, _t('原创or转载'), _t('如是作者原创则输入 <b><font color=red>1</font></b> ，转载则输入转载URL网址，原创作品将在标题前显示“原创”icon，并且在文章最下方显示版权申明信息。如设置转载则会在文章最后出现“原文链接”按钮。留空则不显示原创和转载。输入 <b><font color=red>2</font></b> 仅在文章最下方显示版权申明信息，文章标题不显示“原创”icon'));
	$original->input->setAttribute('class', 'w-100');
	$layout->addItem($original);

/*
	$focusimg = new Typecho_Widget_Helper_Form_Element_Select('focusimg', 
	array(0 => _t('关闭'),
	'focusimg01.jpg' => _t('1风景-静止风车'),
	'focusimg02.jpg' => _t('2风景-大海浪花'),
	'focusimg03.jpg' => _t('3风景-航拍海港'),
	'focusimg04.jpg' => _t('4创意-世间百物'),
	'focusimg05.jpg' => _t('5创意-做回自己'), 
	'focusimg06.jpg' => _t('6创意-黑板涂鸦'),
	'focusimg07.jpg' => _t('7漫画-岛国街道'),
	'focusimg08.jpg' => _t('8唯美-夜晚树屋'),
	'focusimg09.jpg' => _t('9游戏-反恐精英')),
	0, _t('快捷缩略图'), _t('默认关闭，注意：如启用自定义缩略图时此选项不生效<br>选择的图片将会作为文章缩略图，可在"主题目录/img/"路径找到对应编号的图片（focusimg“N”.jpg）进行替换'));
	$layout->addItem($focusimg);
*/

	$outline = new Typecho_Widget_Helper_Form_Element_Textarea('outline', NULL, NULL, _t('文章简介'), _t('在这里填入文章简介显示在文章列表中（支持HTML代码），留空则默认自动摘选文章前200个字符作为文章简介'));
	$outline->input->setAttribute('class', 'w-100');
	$layout->addItem($outline);

	$catalog = new Typecho_Widget_Helper_Form_Element_Radio('catalog', 
	array(true => _t('启用'),
	false => _t('关闭')),
	false, _t('文章目录'), _t('默认关闭，启用则会在文章内显示“文章目录”（若文章内无任何标题，则不显示目录）'));
	$layout->addItem($catalog);

	$all = Typecho_Plugin::export();
	if (array_key_exists('PartiallyPassword', $all['activated'])) {
		$pp_passwords = new Typecho_Widget_Helper_Form_Element_Text('pp_passwords' ,NULL, NULL, _t('文章内加密密码'), _t('使用语法1：<font color=red>[password]</font>需要加密的内容<font color=red>[/password]</font><br>使用语法2：<font color=red>[password title="文字提示"]</font>需要加密的内容<font color=red>[/password]</font>，自定义密码框文字提示。<br>多个加密区域设置：填写“<font color=red>|</font>”作为分隔符，在相邻密码间用分隔符分隔。如填写 114514|1919|810 作为密码，则表示依次定义了三个密码：114514 1919 810，同时按顺序对应文章内[password]顺序，如定义的密码大于文章[password]数量，多余的密码将被弃用，不填写分隔符默认只定义一个密码，请避免定义密码小于文章[password]数量。<br><font color=blue><b>留空则关闭此功能，[password]标签失效[/password]</b></font>'));
		$pp_passwords->input->setAttribute('class', 'w-100');
		$layout->addItem($pp_passwords);
	} else {
		$pp_passwords = new Typecho_Widget_Helper_Form_Element_Radio('pp_passwords', 
		array('' => _t('插件未启动')),
		'', _t('文章内加密密码'), _t('<b><font color=red>未检测到“文章内加密”插件或插件未启动！</font></b>'));
		$layout->addItem($pp_passwords);
	}
}

// ============================================================
// CDN 静态资源统一映射
// 集中管理所有第三方库的 CDN 地址，避免 footer.php 中反复
// 书写同样的 if-elseif 判断逻辑。
// 资源键名 = cjCDN 选项值（sf/zj/bmt/bt），local 为本地回退路径。
// ============================================================
function getCdnResource($key) {
	static $cdnMap = array(
		'jquery' => array(
			'sf'   => '//cdn.staticfile.org/jquery/2.2.4/jquery.min.js',
			'zj'   => '//s0.pstatp.com/cdn/expire-1-M/jquery/2.2.4/jquery.min.js',
			'bmt'  => '//lib.baomitu.com/jquery/2.2.4/jquery.min.js',
			'bt'   => '//cdn.bootcss.com/jquery/2.2.4/jquery.min.js',
			'local' => 'jscss/jquery.min.js',
		),
		'lazyload' => array(
			'sf'   => '//cdn.staticfile.org/jquery_lazyload/1.9.7/jquery.lazyload.min.js',
			'zj'   => '//s0.pstatp.com/cdn/expire-1-M/jquery_lazyload/1.9.7/jquery.lazyload.min.js',
			'bmt'  => '//lib.baomitu.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js',
			'bt'   => '//cdn.bootcss.com/jquery_lazyload/1.9.7/jquery.lazyload.min.js',
			'local' => 'jscss/jquery.lazyload.min.js',
		),
		'fancybox_css' => array(
			'sf'   => '//cdn.staticfile.org/fancybox/3.5.7/jquery.fancybox.min.css',
			'zj'   => '//s0.pstatp.com/cdn/expire-1-M/fancybox/3.5.7/jquery.fancybox.min.css',
			'bmt'  => '//lib.baomitu.com/fancybox/3.5.7/jquery.fancybox.min.css',
			'bt'   => '//cdn.bootcss.com/fancybox/3.5.7/jquery.fancybox.min.css',
			'local' => 'jscss/jquery.fancybox.min.css',
		),
		'fancybox_js' => array(
			'sf'   => '//cdn.staticfile.org/fancybox/3.5.7/jquery.fancybox.min.js',
			'zj'   => '//s0.pstatp.com/cdn/expire-1-M/fancybox/3.5.7/jquery.fancybox.min.js',
			'bmt'  => '//lib.baomitu.com/fancybox/3.5.7/jquery.fancybox.min.js',
			'bt'   => '//cdn.bootcss.com/fancybox/3.5.7/jquery.fancybox.min.js',
			'local' => 'jscss/jquery.fancybox.min.js',
		),
		'pjax' => array(
			'sf'   => '//cdn.staticfile.org/jquery.pjax/1.9.6/jquery.pjax.min.js',
			'zj'   => '//s0.pstatp.com/cdn/expire-1-M/jquery.pjax/1.9.6/jquery.pjax.min.js',
			'bmt'  => '//lib.baomitu.com/jquery.pjax/1.9.6/jquery.pjax.min.js',
			'bt'   => '//cdn.bootcss.com/jquery.pjax/1.9.6/jquery.pjax.min.js',
			'local' => 'jscss/jquery.pjax.min.js',
		),
		'bootstrap' => array(
			'sf'   => '//cdn.staticfile.org/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
			'zj'   => '//s0.pstatp.com/cdn/expire-1-M/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
			'bmt'  => '//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
			'bt'   => '//cdn.bootcss.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js',
			'local' => 'jscss/bootstrap.min.js',
		),
	);
	$cdn = Helper::options()->cjCDN;
	if (isset($cdnMap[$key][$cdn])) {
		echo $cdnMap[$key][$cdn];
	} else {
		cjUrl($cdnMap[$key]['local']);
	}
}
