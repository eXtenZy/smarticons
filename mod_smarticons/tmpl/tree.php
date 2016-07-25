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

$textStyle	= "";
$linkStyle	= "";
$class		= "";

if (isset($button->params->bold)) {
	if ($button->params->bold == 1) {
		$textStyle.= "font-weight:bold; ";
	}
}
if (isset($button->params->italic)) {
	if ($button->params->italic == 1) {
		$textStyle.= "font-style:italic; ";
	}
}
if (isset($button->params->underline)) {
	if ($button->params->underline == 1) {
		$textStyle.= "text-decoration:underline;";
	}
}
if (isset($button->params->newWindow)) {
	if ($button->params->newWindow==1) {
		$target = ' target="_blank"';
	}
}
if (isset($button->params->modalWindow)) {
	if ($button->params->modalWindow==1) {

		// Load the modal behavior script.
		JHtml::_('behavior.modal');

		$class = ' class="modal" rel="{handler: \'iframe\', size: {x: '. $button->params->modalWidth. ', y: '. $button->params->modalHeight.'}}"';
	}
}

?>
<div class="row-fluid list" <?php echo isset($button->id) ? "id=\"$button->id\"" : ''; ?>>
	<a href="<?php echo $button->Target; ?>" 
		<?php echo empty($linkStyle) ? '' : " style=\"$linkStyle\"";
			echo isset($button->Title) ? " title=\"".JText::_($button->Title)."\"" : '';
			echo isset($target) ? $target : '';
			echo isset($class) ? $class : ''; ?>>
	<?php if (($button->Display > 3) && ($button->Display <= 5)):?>
		<i><?php echo $button->Icon; ?></i>
	<?php endif; ?>
	<?php if (($button->Display <= 2)):
		echo JHtml::_('image',$button->Icon, isset($button->Text) ? JText::_($button->Text) : '', array('id' => "list_image", 'width' => '14px', 'height' => '14px'));
	endif;
	if (($button->Display <= 4) && ($button->Display != 2)) :?>
		<span style="<?php echo $textStyle;?>"><?php echo JText::_($button->Name); ?></span>
	<?php endif;?>
	</a>
</div>