<?php if (!defined('__TYPECHO_ROOT_DIR__')) exit; ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="<?php $this->options->charset(); ?>" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<?php if ($this->options->scalable): ?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
<?php else: ?>
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=2, user-scalable=yes" />
<?php endif; ?>
<?php if ($this->options->favicon): ?>
<link rel="shortcut icon" href="<?php $this->options->favicon(); ?>" />
<?php endif; ?>
<title><?php $this->archiveTitle(array(
'category'  =>  _t('分类 %s 下的文章'),
'search'    =>  _t('包含关键字 %s 的文章'),
'tag'       =>  _t('标签 %s 下的文章'),
'date'      =>  _t('在 %s 发布的文章'),
'author'    =>  _t('作者 %s 发布的文章')
), '', ' - '); ?><?php $this->options->title(); if ($this->is('index') && $this->options->subTitle): ?> - <?php $this->options->subTitle(); endif; ?></title>
<?php $this->header('generator=&template=&pingback=&xmlrpc=&wlw=&commentReply=&rss1=&rss2=&antiSpam=&atom='); ?>
<?php if ($this->options->sitenocolr): ?>
<style>html{filter: grayscale(100%);-webkit-filter: grayscale(100%);-moz-filter: grayscale(100%);-ms-filter: grayscale(100%);-o-filter: grayscale(100%);filter: url("data:image/svg+xml;utf8,#grayscale");filter: progid:DXImageTransform.Microsoft.BasicImage(grayscale=1);-webkit-filter: grayscale(1);}</style>
<?php endif; ?>
<link rel="stylesheet" href="<?php skinUrl('jscss/','.css'); ?>" id="<?php skinUrl('','','id'); ?>" />
<?php if (!empty($this->options->skinoptions) && in_array('radius', $this->options->skinoptions)): ?>
<link rel="stylesheet" href="<?php cjUrl('jscss/style-border-radius.css'); ?>" />
<?php endif; ?>
<link rel="stylesheet" href="<?php cjUrl('jscss/font/iconfont.css'); ?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
<?php if ($this->options->prism): ?>
<link rel="stylesheet" href="<?php cjUrl('jscss/prism.css'); ?>" />
<?php endif; ?>
<?php if ($this->options->fancybox): ?>
<link rel="stylesheet" href="<?php getCdnResource('fancybox_css'); ?>" />
<?php endif; ?>
<?php if ($this->options->CustomCss): ?>
<style><?php $this->options->CustomCss(); ?></style>
<?php endif; ?>
<script>
/* 导航栏天气 - wttr.in(MET Norway) + IP定位城市 */
(function(){
  /* 天气描述→中文映射 + icon/粒子类型 */
  function parseDesc(desc){
    var c=desc.toLowerCase();
    if(/sun|clear/i.test(c))return ["\u2600\ufe0f","\u6674","ti-sun","sunny"];
    if(/partly.cloud/i.test(c))return ["\u26c5","\u591a\u4e91","ti-sun","sunny"];
    if(/cloud|overcast/i.test(c))return ["\u2601\ufe0f","\u9634","ti-cloud-off","none"];
    if(/mist|fog|haze/i.test(c))return ["\ud83c\udf2b\ufe0f","\u96fe","ti-cloud-off","none"];
    if(/thunder|storm/i.test(c))return ["\u26c8\ufe0f","\u96f7\u66b4","ti-cloud-rain","rain"];
    if(/snow|sleet|ice/i.test(c))return ["\u2744\ufe0f","\u96ea","ti-snowflake","snow"];
    if(/rain|drizzle|shower/i.test(c))return ["\ud83c\udf27\ufe0f","\u96e8","ti-cloud-rain","rain"];
    return ["\u2601\ufe0f","--","ti-cloud-off","none"];
  }

  function show(temp,desc,code,loc){
    var ie=document.getElementById('wi'),te=document.getElementById('wt'),
        de=document.getElementById('wd'),le=document.getElementById('wl');
    var v=parseDesc(desc,code);
    if(ie)ie.textContent=v[0];
    if(te)te.textContent=Math.round(temp)+'\u00b0';
    if(de)de.textContent=v[1];
    if(le&&loc)le.textContent=loc;
    /* 统一更新：按钮图标 + 背景粒子 + 5分钟循环（共用 v 参数） */
    var ws=window.WeatherSystem;
    if(ws&&ws.setWeather){
      if(v[3]==='rain')ws.setWeather('rain');
      else if(v[3]==='snow')ws.setWeather('snow');
      else if(v[3]==='sunny')ws.setWeather('sunny');
      else ws.setWeather('none');
      ws.stopAutoCycle();
      setTimeout(function(){ws.startAutoCycle()},300000);
    }
    var btn=document.getElementById('weather-btn');
    if(btn)btn.innerHTML='<i class="ti '+v[2]+'"></i>';
  }

  function fetchW(city){
    var u='https://wttr.in/'+encodeURIComponent(city)+'?format=j1';
    fetch(u).then(function(r){return r.json()}).then(function(d){
      var cc=d.current_condition&&d.current_condition[0];
      var area=d.nearest_area&&d.nearest_area[0];
      var locName=area&&area.region&&area.region[0]?area.region[0].value:city;
      if(cc)show(cc.temp_C,cc.weatherDesc[0].value,cc.weatherCode,locName);
    }).catch(function(){});
  }

  function start(){
    fetch('https://myip.ipip.net').then(function(r){return r.text()}).then(function(t){
      var m=t.match(/\u6765\u81ea\u4e8e\uff1a\u4e2d\u56fd\s+\S+\s+(\S+)/);
      if(m){
        var c=m[1].replace('\u5e02','');
        fetchW(c);return;
      }
      fetchW('\u4e0a\u6d77');
    }).catch(function(){fetchW('\u4e0a\u6d77')});
  }

  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',start);
  else start();
  setInterval(start,600000);
})();
</script>
</head>
<body id="stylebg" <?php if ($this->options->HeadFixed): ?>class="head-fixed"<?php endif; ?> style="background-image:url('<?php skinUrl('img/','.jpg'); ?>');">
<div id="weather-container"><canvas id="weather-canvas"></canvas></div>
<div id="weather-widget-hidden"><div id="ww_cb73de692939a"></div></div>
<style>
#weather-container{position:fixed;top:0;left:0;width:100%;height:100%;z-index:-1;pointer-events:none;overflow:hidden}
#weather-container::after{content:"";position:absolute;top:0;left:0;width:100%;height:100%;background-color:rgba(60,70,80,0.2);opacity:0;transition:opacity 1.5s ease;pointer-events:none;z-index:0}
html.weather-overcast #weather-container::after{opacity:1}
#weather-canvas{position:relative;z-index:1;display:block;width:100%;height:100%;opacity:0;transition:opacity 0.5s ease}
#weather-canvas.active{opacity:1}
.sun-spot{position:absolute;border-radius:50%;filter:blur(80px);opacity:0.6;animation:sunBreath 12s infinite ease-in-out;pointer-events:none;z-index:0}
.sun-spot.spot-1{top:-10%;left:-10%;width:60vw;height:60vw;background:radial-gradient(circle,rgba(255,160,0,0.4),transparent 70%)}
.sun-spot.spot-2{bottom:10%;right:-10%;width:50vw;height:50vw;background:radial-gradient(circle,rgba(255,100,0,0.3),transparent 70%);animation-delay:2s;animation-duration:15s}
.sun-spot.spot-3{top:30%;left:40%;width:40vw;height:40vw;background:radial-gradient(circle,rgba(255,220,100,0.3),transparent 70%);animation-delay:5s;animation-duration:18s}
@keyframes sunBreath{0%,100%{transform:scale(1) translate(0,0);opacity:0.5}50%{transform:scale(1.1) translate(20px,-20px);opacity:0.8}}

#cornertool #weather-btn i{font-size:18px;line-height:40px;display:block;text-align:center;color:#fff}
#weather-btn{transition:transform .2s ease}#weather-btn:hover{transform:scale(1.15)}
/* 导航栏天气信息 - 与首页风格一致 */
.nav-weather{white-space:nowrap}
.nav-weather .nw-temp{font-weight:700;margin:0 1px}
.nav-weather .nw-desc{margin:0 5px 0 3px}
/* 隐藏的天气容器（WeatherSystem数据源兼容） */
#weather-widget-hidden{position:absolute;width:1px;height:1px;overflow:hidden;opacity:0;pointer-events:none}
</style>
<!--[if lt IE 9]>
<div class="browsehappy">当前网页可能 <strong>不支持</strong> 您正在使用的浏览器. 为了正常的访问, 请 <a href="https://browsehappy.com/">升级您的浏览器</a>.推荐使用：QQ、360、谷歌浏览器……</div>
<![endif]-->
<header id="header">
<div class="container clearfix">
<div class="site-name">
<h1>
<a id="logo" href="<?php $this->options->siteUrl(); ?>"><?php if ($this->options->logoUrl && ($this->options->titleForm == 'logo' || $this->options->titleForm == 'all')): ?><img src="<?php $this->options->logoUrl() ?>" alt="<?php $this->options->title() ?>" title="<?php $this->options->title() ?>" /><?php endif; ($this->options->titleForm == 'logo' && $this->options->logoUrl) ? '' : ($this->options->customTitle ? $this->options->customTitle() : $this->options->title()) ?>
</a>
</h1>
</div>
<script>function Navswith(){document.getElementById("header").classList.toggle("on")}</script>
<button id="nav-swith" onclick="Navswith()"><span></span></button>
<div id="nav">
<div id="site-search">
<form id="search" method="post" action="<?php $this->options->siteUrl(); ?>">
<input type="text" id="s" name="s" class="text" placeholder="输入关键字搜索" required />
<button type="submit"></button>
</form>
</div>
<ul class="nav-menu">
<li class="nav-weather"><span id="wi">&#x23f3;</span><span id="wt" class="nw-temp">--</span><span id="wd" class="nw-desc"></span><span id="wl" class="nw-loc"></span></li>
<li><a class="iconfont siteUrl" href="<?php $this->options->siteUrl(); ?>">首页</a></li>
<?php if (!empty($this->options->Navset) && in_array('ShowCategory', $this->options->Navset)): if (in_array('AggCategory', $this->options->Navset)): ?>
<li class="menu-parent"><a class="iconfont Categorya" onclick="document.getElementById('Category').classList.toggle('Categoryactive');"><?php if ($this->options->CategoryText): $this->options->CategoryText(); else: ?>分类<?php endif; ?></a>
<ul id="Category">
<?php
endif;
$this->widget('Widget_Metas_Category_List')->to($categorys);
while($categorys->next()):
if ($categorys->levels == 0):
$children = $categorys->getAllChildren($categorys->mid);
if (empty($children)):
?>
<li><a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?></a></li>
<?php else: ?>
<li class="menu-parent">
<a href="<?php $categorys->permalink(); ?>" title="<?php $categorys->name(); ?>"><?php $categorys->name(); ?></a>
<ul class="menu-child">
<?php foreach ($children as $mid) {
$child = $categorys->getCategory($mid); ?>
<li><a href="<?php echo $child['permalink'] ?>" title="<?php echo $child['name']; ?>"><?php echo $child['name']; ?></a></li>
<?php } ?>
</ul>
</li>
<?php
endif;
endif;
endwhile;
?>
<?php if (in_array('AggCategory', $this->options->Navset)): ?>
</ul>
</li>
<?php
endif;
endif;
if (!empty($this->options->Navset) && in_array('ShowPage', $this->options->Navset)):
if (in_array('AggPage', $this->options->Navset)):
?>
<li class="menu-parent"><a class="iconfont PageTexta" onclick="document.getElementById('PageText').classList.toggle('PageTextactive');"><?php if ($this->options->PageText): $this->options->PageText(); else: ?>其他<?php endif; ?></a>
<ul id="PageText">
<?php
endif;
$this->widget('Widget_Contents_Page_List')->to($pages);
while($pages->next()):
?>
<li><a href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a></li>
<?php endwhile;
if (in_array('AggPage', $this->options->Navset)): ?>
</ul>
</li>
<?php endif;
endif; ?>
</ul>
</div>
</div>
</header>
<div id="body">
<div class="container clearfix">
