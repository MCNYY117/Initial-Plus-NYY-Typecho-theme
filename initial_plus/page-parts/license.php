<?php
/**
 * 版权/许可信息区域
 *
 * 根据文章字段（original）显示原创/转载/普通三种版权状态：
 * - original=1 或 2：显示作者、链接、版权声明（文章标题显示"原创"）
 * - 转载（填入URL）：显示原文链接 + 许可协议
 * - 其他：仅显示许可协议
 *
 * 使用前需确保 $this 指向当前 Widget_Archive 对象。
 * @var Widget_Archive $this
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
?>
<li id="theend">- The end! -</li>
<p class="tags iconfont icon-biaoqian">&nbsp;标签: <?php $this->tags(', ', true, 'none'); ?></p>
<?php if ($this->fields->original && $this->fields->original != 1 && $this->fields->original != 2): ?>
<p class="tags iconfont icon-zhuanzai">&nbsp;转载: <a href="###" onclick="window.open('<?php $this->fields->original(); ?>','_blank')">原文链接</a></p>
<p class="license"><?php echo $this->options->LicenseInfo ? $this->options->LicenseInfo : '本文采用 <a rel="license nofollow" href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可。' ?></p>
<?php elseif ($this->fields->original == 1 || $this->fields->original == 2): ?>
<p class="license iconfont icon-wo">&nbsp;本文作者: <a title="本文作者" href="<?php $this->author->permalink(); ?>"><?php $this->author(); ?></a></p>
<p class="license iconfont icon-link">&nbsp;本文链接: <a href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a></p>
<p class="license">&copy;&nbsp;版权申明: <?php echo $this->options->LicenseInfo ? $this->options->LicenseInfo : '本文采用 <a rel="license nofollow" href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可。' ?>解释权归 <a href="<?php $this->options->siteUrl() ?>"><?php $this->options->title() ?></a> 所有，转载请注明出处。</p>
<?php else: ?>
<p class="tags iconfont icon-link">&nbsp;本文链接: <a href="<?php $this->permalink() ?>"><?php $this->permalink() ?></a></p>
<p class="license"><?php echo $this->options->LicenseInfo ? $this->options->LicenseInfo : '本文采用 <a rel="license nofollow" href="https://creativecommons.org/licenses/by-sa/4.0/" target="_blank">知识共享署名-相同方式共享 4.0 国际许可协议</a> 进行许可。' ?></p>
<?php endif; ?>
