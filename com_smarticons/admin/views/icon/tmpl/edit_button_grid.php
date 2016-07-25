<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');

$textStyle = "";
$linkStyle = "";

if (isset($this->item->params['bold'])) {
	if ($this->item->params['bold']==1) {
		$textStyle.= "font-weight:bold; ";
	}
}
if (isset($this->item->params['italic'])) {
	if ($this->item->params['italic']==1) {
		$textStyle.= "font-style:italic; ";
	}
}
if (isset($this->item->params['underline'])) {
	if ($this->item->params['underline']==1) {
		$textStyle.= "text-decoration:underline;";
	}
}
if (isset($this->item->params['width'])) {
	if (is_numeric($this->item->params['width'])) {
		$linkStyle.= "width:".abs($this->item->params['width']).'px; ';
	}
}
if (isset($this->item->params['height'])) {
	if (is_numeric($this->item->params['height'])) {
		$linkStyle.= "height:".abs($this->item->params['height']).'px; ';
	}
}

?>
<div id="wrapper">
	<div class="grid">
		<a id="grid_url" style="<?php echo $linkStyle; ?>" target="_blank" href="<?php echo $this->item->Target; ?>" title="<?php echo isset($this->item->Title) ? JText::_($this->item->Title) : ''; ?>">
			<i id="grid_icon" class="big" style="<?php echo $this->displayIconControl ? 'display:block' : 'display:none'; ?>"><?php echo $this->item->icon; ?></i>
			<?php echo JHtml::_('image',$this->item->Icon, $this->item->Text, array('id' => "grid_image", 'style' => $this->displayImgControl ? 'display:block' : 'display:none')); ?>
			<span id="grid_text" style="<?php echo $textStyle;?>"><?php echo JText::_($this->item->Name); ?></span>
		</a>
	</div>
</div>
