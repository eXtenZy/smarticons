<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

//Add styling
$document = JFactory::getDocument();
$document->addStyleSheet("modules/mod_smarticons/css/smarticons.css");

require_once dirname(__FILE__).'/helper.php';

JFactory::getLanguage()->load('mod_quickicon');

$tabs				= SmartIconsHelper::getButtons();
$lastTab			= end($tabs);
$firstTab			= reset($tabs);
$componentConfig	= SmartIconsHelper::getComponentConfig()->toObject();
$displayMode		= isset($componentConfig->display_mode) ? $componentConfig->display_mode : 2; 
$layout 			= $params->get('layout', '_:list');

$tabNum 			= count($tabs);

if ($displayMode == 4) {
	$tabNum++;
}

if ($tabNum > 1) {
	echo "<ul class=\"nav nav-tabs\">";

	foreach ($tabs as $tab) {
		$active = $tab == $firstTab ? ' class="active"' : '';
		echo "<li$active><a href=\"#$tab->Alias$tab->Id\" data-toggle=\"tab\">". $tab->Title . "</a></li>";
	}

	if ($displayMode == 4) {
		echo "<li><a href=\"#plugins\" data-toggle=\"tab\">". JText::_('MOD_SMARTICONS_TAB_PLUGINS') . "</a></li>";
	}

	echo "</ul>";
	
	echo "<div class=\"tab-content\" style=\"clear:both\">";
}

foreach ($tabs as $tab) {
	$active = $tab == $firstTab ? ' active' : '';
	echo "<div class=\"tab-pane$active\" id=\"$tab->Alias$tab->Id\">";
	
	if (substr($layout, 2) == 'list') {
		echo "<div class=\"row-striped\">";
	} else if (substr($layout, 2) == 'grid') {
		echo "<div class=\"wrapper\">";
	}
	
	foreach ($tab->icons as $icon) {
		echo SmartIconsHelper::button($icon, $layout);
	};
	
	if (($displayMode == 2) && ($tab == $firstTab)) {
		SmartIconsHelper::plugins($layout);
	}
	
	if (($displayMode == 3) && ($tab == $lastTab)) {
		SmartIconsHelper::plugins($layout);
	}
	
	echo "</div>";
	echo "</div>";
}

if ($displayMode == 4) {
	echo "<div class=\"tab-pane\" id=\"plugins\">";
	
	if (substr($layout, 2) == 'list') {
		echo "<div class=\"row-striped\">";
	} else if (substr($layout, 2) == 'grid') {
		echo "<div class=\"wrapper\">";
	}
	
	SmartIconsHelper::plugins($layout);
	
	echo "</div>";
	echo "</div>";
}

if ($tabNum > 1) {
	echo "</div>";
}

if ($displayMode == 1) {
	if (substr($layout, 2) == 'list') {
		echo "<div class=\"row-striped\">";
	} else if (substr($layout, 2) == 'grid') {
		echo "<div class=\"wrapper\">";
	}
	
	SmartIconsHelper::plugins($layout);
	
	echo "</div>";
}
