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

?>
<div class="j-links-groups sidebar-nav quick-icons">
<?php 
foreach ($groups as $group) : 
?>
	<h2 class="nav-header"><?php echo $group->title; ?></h2>
	
<?php
	if (isset($group->icons) && !empty($group->icons)):?>
	<ul class="j-links-group nav nav-list">
<?php 
		foreach ($group->icons as $icon) :
			$button = SmartIconsHelper::button($icon);
	
?>
		<li id="<?php echo $button->id; ?>">
			<a href="<?php echo $button->link; ?>" <?php echo implode(' ', $button->options); ?>>
			<?php if (($button->Display > 3) && ($button->Display <= 5)):?>
				<span class="<?php echo implode(' ', $button->classes); ?>"></span>
			<?php endif; ?>
			<?php if (($button->Display <= 2)):
				echo JHtml::_('image',$button->Icon, isset($button->Text) ? $button->Text : '', array('id' => "list_image", 'width' => '14px', 'height' => '14px'));
			endif;
			if (($button->Display <= 4) && ($button->Display != 2)) :?>
				<span class="j-links-link" style="<?php echo implode("; ", $button->style);?>"><?php echo $button->Name; ?></span>
			<?php endif;?>
			</a>
		</li>
<?php 
		endforeach;	
?>
	</ul>
<?php
	else:?>
	<span class='empty'>Empty group</span> 
<?php
	endif; 
endforeach;
?>
</div>


