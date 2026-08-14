<?php
/**
 * 二维码打赏/扫码区域
 *
 * 显示在文章和页面底部，支持微信/支付宝/自定义二维码及文章二维码。
 * 依赖于 functions.php 中的 customqr() 函数读取主题设置。
 *
 * 使用前需确保 $this 指向当前 Widget_Archive 对象。
 * @var Widget_Archive $this
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
if ($this->options->WeChat || $this->options->Alipay || $this->options->customqr3 || $this->options->postqr):
?>
<button class="like-bnt iconfont icon-Qr_code" title="手机扫码" onclick="qr()"></button>
<div id="qr" style="display: none;">
<?php if ($this->options->WeChat): ?>
<div style="display: inline-block">
<a rel="group"><img src="<?php echo customqr(1,1); ?>" alt="<?php echo customqr(1); ?>"></a>
<p><?php echo customqr(1); ?></p>
</div>
<?php endif; ?>
<?php if ($this->options->Alipay): ?>
<div style="display: inline-block">
<a rel="group"><img src="<?php echo customqr(2,1); ?>" alt="<?php echo customqr(2); ?>"></a>
<p><?php echo customqr(2); ?></p>
</div>
<?php endif; ?>
<?php if ($this->options->customqr3): ?>
<div style="display: inline-block">
<a rel="group"><img src="<?php echo customqr(3,1); ?>" alt="<?php echo customqr(3); ?>"></a>
<p><?php echo customqr(3); ?></p>
</div>
<?php endif; ?>
<?php if ($this->options->postqr): ?>
<div style="display: inline-block">
<a rel="group"><img src="<?php $this->options->themeUrl(); ?>lib/qrcode.php?size=240&text=<?php $this->permalink(); ?>" alt="网页二维码"></a>
<p>网页二维码</p>
</div>
<?php endif; ?>
</div>
<?php endif; ?>
