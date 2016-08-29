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

$groups				= SmartIconsHelper::getButtons();
$componentConfig	= SmartIconsHelper::getComponentConfig()->toObject();
$layout 			= $params->get('layout', '_:tree');
$showTabs 			= $params->get('showtabs', '1');
$mainframe			= JFactory::getApplication();
$instance			= $mainframe->getUserState('mod_smarticons_instances', 0);

$mainframe->setUserState('mod_smarticons_instances', $instance+1);

require JModuleHelper::getLayoutPath('mod_smarticons', $layout);


