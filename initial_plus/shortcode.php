<?php
/**
 * Initial Plus 短代码系统
 *
 * 统一管理所有文章/页面内可用的短代码（shortcode）。
 * 按钮类短代码使用工厂模式注册，避免重复代码。
 * 特殊类短代码（弹窗/折叠等）独立实现。
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 加载短代码核心引擎（lib/shortcode.php 提供 add_shortcode / do_shortcode / shortcode_atts）
require_once __DIR__ . '/lib/shortcode.php';

// ============================================================
// 按钮工厂：用于注册结构相同的社交/外部链接短代码
//
// 每个按钮只需要在 $buttonDefs 数组中定义即可自动注册，
// 无需重复书写函数体。
// ============================================================

/**
 * 注册一个按钮类短代码
 *
 * @param string $tag   短代码标签名（如 'down'、'github'）
 * @param array  $defaults 默认参数：url, color, blank, icon（图标CSS类名）
 */
function register_button_shortcode($tag, $defaults) {
    add_shortcode($tag, function($atts, $content = '') use ($defaults) {
        $args = shortcode_atts($defaults, $atts);
        $icon = isset($defaults['icon']) ? $defaults['icon'] : $tag;
        if ($args['blank']) {
            return '<button class="xiazai-bnt iconfont icon-' . $icon . '" style="background-color:' . $args['color'] . '" onclick="window.open(&quot;' . $args['url'] . '&quot;,&quot;_blank&quot;)">' . $content . '</button>';
        } else {
            return '<a href="' . $args['url'] . '"><button class="xiazai-bnt iconfont icon-' . $icon . '" style="background-color:' . $args['color'] . '">' . $content . '</button></a>';
        }
    });
}

/** 所有按钮类短代码的定义：标签名 => [默认参数] */
$buttonDefs = array(
    'down'    => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#38a3fd', 'blank' => 1, 'icon' => 'down'),
    'link'    => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#9f9f9f', 'blank' => 1, 'icon' => 'link'),
    'shop'    => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#ff4400', 'blank' => 1, 'icon' => 'shop'),
    'github'  => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#363a3e', 'blank' => 1, 'icon' => 'github'),
    'steam'   => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#1b2838', 'blank' => 1, 'icon' => 'steam'),
    'weibo'   => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#e6162d', 'blank' => 1, 'icon' => 'weibo'),
    'mail'    => array('url' => 'admin@alttt.com', 'color' => '#3fc1bf', 'blank' => 1, 'icon' => 'youjian'),
    'gitee'   => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#ce3c40', 'blank' => 1, 'icon' => 'gitee'),
    'baidu'   => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#09aaff', 'blank' => 1, 'icon' => 'baiduwangpan'),
    'csdn'    => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#ff4d4d', 'blank' => 1, 'icon' => 'csdn'),
    'zhihu'   => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#0066ff', 'blank' => 1, 'icon' => 'zhihu'),
    'bilibili' => array('url' => Typecho_Widget::widget('Widget_Options')->siteUrl, 'color' => '#fb7299', 'blank' => 1, 'icon' => 'bilibili'),
);

// 批量注册按钮短代码
foreach ($buttonDefs as $tag => $def) {
    register_button_shortcode($tag, $def);
}

// ============================================================
// 以下为独立实现的特殊短代码（各有不同结构）
// ============================================================

/**
 * [toggle] 折叠面板
 * 用法：[toggle title="点击展开" color="#666"]内容[/toggle]
 */
function shortcode_toggle($atts, $content = '') {
    static $count = 0;
    $count++;
    $args = shortcode_atts(array('title' => '点击展开阅读更多内容', 'color' => '#666'), $atts);
    return '<div class="panel">
                <a data-toggle="collapse" href="#toggle-'.$count.'">
                    <div class="panel-title iconfont icon-jiaodian icon-toggle-close" style="background-color:'.$args['color'].'">'.$args['title'].'</div>
                </a>
                <div id="toggle-'.$count.'" class="collapse">
                    <div class="panel-body">'.$content.'</div>
                </div>
            </div>';
}
add_shortcode('toggle', 'shortcode_toggle');

/**
 * [highlight] 高亮提示面板
 * 用法：[highlight title="重要内容" color="#666"]内容[/highlight]
 */
function shortcode_highlight($atts, $content = '') {
    $args = shortcode_atts(array('title' => '重要内容', 'color' => '#666'), $atts);
    return '<div class="highlight"><div class="highlight-title iconfont icon-highlight" style="background-color:'.$args['color'].'">&nbsp;'.$args['title'].'</div><div class="highlight-content">'.$content.'</div></div>';
}
add_shortcode('highlight', 'shortcode_highlight');

/**
 * 提示/禁止/警告/购买/备注/引用面板
 * 结构相同，仅 CSS 类名和图标不同
 * 用法：[tips]内容[/tips]  /  [noway]内容[/noway] 等
 */
function shortcode_panel($atts, $content = '', $class = '') {
    return '<div class="tips mc-panel p-'.$class.' iconfont icon-'.$class.' clearfix">' . $content . '</div>';
}
add_shortcode('tips',    function($a, $c = '') { return shortcode_panel($a, $c, 'tips'); });
add_shortcode('noway',   function($a, $c = '') { return shortcode_panel($a, $c, 'noway'); });
add_shortcode('warning', function($a, $c = '') { return shortcode_panel($a, $c, 'warning'); });
add_shortcode('buy',     function($a, $c = '') { return shortcode_panel($a, $c, 'buy'); });
add_shortcode('note',    function($a, $c = '') { return shortcode_panel($a, $c, 'note'); });
add_shortcode('ref',     function($a, $c = '') { return shortcode_panel($a, $c, 'ref'); });

/**
 * [focus] 弹窗焦点按钮
 * 用法：[focus title="标题" color="#666" name="点击查看"]内容[/focus]
 */
function shortcode_focus_button($atts, $content = '') {
    static $count = 0;
    $count++;
    $args = shortcode_atts(array('title' => '焦点内容', 'color' => '#666', 'name' => '点击查看焦点内容'), $atts);
    return '<button class="focus-bnt iconfont icon-jiaodian" style="background-color:'.$args['color'].'" data-toggle="modal" data-target="#focus-'.$count.'">'.$args['name'].'</button><div class="modal fade focus" id="focus-'.$count.'" tabindex="-1" role="dialog"><div class="modal-dialog"><div class="modal-header" style="background-color:'.$args['color'].'"><button type="button" class="close" data-dismiss="modal">&times;</button><span class="modal-title iconfont icon-jujiao">&nbsp;'.$args['title'].'</span></div><div class="focus-content">'.$content.'</div><div class="modal-footer"><button type="button" class="focus-bnt-close" style="background-color:'.$args['color'].'" data-dismiss="modal">关闭</button></div></div></div>';
}
add_shortcode('focus', 'shortcode_focus_button');

/**
 * [weixin] 微信二维码弹窗
 * 用法：[weixin url="二维码图片地址" title="微信扫一扫" color="#1aad19"]按钮文字[/weixin]
 */
function shortcode_weixin_button($atts, $content = '') {
    static $count = 0;
    $count++;
    $args = shortcode_atts(array(
        'url'   => Typecho_Widget::widget('Widget_Options')->themeUrl . '/lib/qrcode.php?size=235&text=' . Typecho_Widget::widget('Widget_Options')->siteUrl,
        'title' => '微信扫一扫',
        'color' => '#1aad19'
    ), $atts);
    return '
    <button class="focus-bnt iconfont icon-weixin" style="background-color:'.$args['color'].'" data-toggle="modal" data-target="#weixin-'.$count.'">'.$content.'</button>
    <div class="modal fade" id="weixin-'.$count.'" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close font-color" data-dismiss="modal">&times;</button>
                <span class="modal-title iconfont icon-saoyisao font-color">&nbsp;'.$args['title'].'</span>
            </div>
            <div class="tab-content"><img src="'.$args['url'].'" alt="微信二维码"></div>
            <div class="modal-footer">
                <button type="button" class="focus-bnt-close font-color" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>';
}
add_shortcode('weixin', 'shortcode_weixin_button');

/**
 * [qrcode] 二维码弹窗
 * 用法：[qrcode url="二维码图片地址" title="手机扫一扫" color="#666"]按钮文字[/qrcode]
 */
function shortcode_qrcode_button($atts, $content = '') {
    static $count = 0;
    $count++;
    $args = shortcode_atts(array(
        'url'   => Typecho_Widget::widget('Widget_Options')->themeUrl . '/lib/qrcode.php?size=235&text=' . Typecho_Widget::widget('Widget_Options')->siteUrl,
        'title' => '手机扫一扫',
        'color' => '#666'
    ), $atts);
    return '
    <button class="focus-bnt iconfont icon-Qr_code" style="background-color:'.$args['color'].'" data-toggle="modal" data-target="#qrcode-'.$count.'">'.$content.'</button>
    <div class="modal fade" id="qrcode-'.$count.'" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close font-color" data-dismiss="modal">&times;</button>
                <span class="modal-title iconfont icon-saoyisao font-color">&nbsp;'.$args['title'].'</span>
            </div>
            <div class="tab-content"><img src="'.$args['url'].'" alt="二维码"></div>
            <div class="modal-footer">
                <button type="button" class="focus-bnt-close font-color" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>';
}
add_shortcode('qrcode', 'shortcode_qrcode_button');
