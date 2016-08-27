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

?>
<div class="row-fluid">
	<div class="list">
		<a id="list_url" style="<?php echo $linkStyle; ?>" target="_blank" href="<?php echo $this->item->Target; ?>" title="<?php echo isset($this->item->Title) ? $this->item->Title : ''; ?>">
			<span id="list_icon" class="<?php echo 'icon-'. $this->item->icon; ?>" style="<?php echo $this->displayIconControl ? 'display:inline' : 'display:none'; ?>"></span>
			<?php echo JHtml::_('image',$this->item->Icon, $this->item->Text, array('id' => "list_image", 'style' => $this->displayImgControl ? 'display:inline' : 'display:none', 'width' => '14px', 'height' => '14px')); ?>
			<span id="list_text" style="<?php echo $textStyle;?>"><?php echo $this->item->Name; ?></span>
		</a>
	</div>
</div>
