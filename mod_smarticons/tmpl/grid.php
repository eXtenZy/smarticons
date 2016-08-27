<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access
defined('_JEXEC') or die; 

$tabNum = count($groups);
$firstTab = reset($groups); 

?>
<div class="wrapper">
<?php 
if ($tabNum > 1) : 
?>
	<ul class="nav nav-tabs">
<?php 
	foreach ($groups as $key => $group) :
		$active = $group == $firstTab ? ' class="active"' : '';
?>	
		<li <?php echo $active; ?>><a href="#<?php echo $group->alias . $group->id . $instance; ?>" data-toggle="tab"><?php echo JText::_($group->title); ?></a></li>
<?php 
	endforeach;
?>
	</ul>
	<div class="tab-content" style="clear:both">
<?php 

endif;

foreach ($groups as $group) :
	$active = $group == $firstTab ? ' active' : '';
?>
		<div class="tab-pane<?php echo $active; ?>" id="<?php echo $group->alias . $group->id . $instance; ?>">
<?php
	if (isset($group->icons) && !empty($group->icons)):
		foreach ($group->icons as $icon) :
			$button = SmartIconsHelper::button($icon, $layout);
?>
			<div class="grid" id="<?php echo $button->id; ?>">
				<a href="<?php echo $button->link; ?>" <?php echo implode(' ', $button->options); echo !empty($button->linkStyle) ? 'style="'. implode('; ', $button->linkStyle) .'"' : "" ; ?>>
				<?php if (($button->Display > 3) && ($button->Display <= 5)):?>
					<span class="big <?php echo implode(' ', $button->classes); ?>" ></span>
				<?php endif; ?>
				<?php if (($button->Display <= 2)):
					echo JHtml::_('image',$button->Icon, isset($button->Text) ? JText::_($button->Text) : ''); 
				endif;
				if (($button->Display <= 4) && ($button->Display != 2)) :?>
					<span class="j-links-link" style="<?php echo implode("; ", $button->style);?>"><?php echo JText::_($button->Name); ?></span>
				<?php endif;?>
				</a>
			</div>
<?php 
		endforeach;
	else:?>
	<div class='alert'><?php echo JText::_('MOD_SMARTICONS_EMPTY'); ?></div>
<?php 
	endif;
?>
		</div>
<?php 
endforeach;
if ($tabNum > 1) :
?>
	</div>
<?php 
endif;
?>
</div>
