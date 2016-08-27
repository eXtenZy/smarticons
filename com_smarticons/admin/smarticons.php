<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

if (!JFactory::getUser()->authorise('core.manage', 'com_smarticons'))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

require_once JPATH_COMPONENT . '/helpers/smarticons.php';

// Set some global property
$document = JFactory::getDocument ();
$document->addStyleDeclaration ( '.menu-smarticons16x16 {background-image: url(../media/com_smarticons/images/SmartIcons16x16.png);}' );

$controller = JControllerLegacy::getInstance('SmartIcons');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();