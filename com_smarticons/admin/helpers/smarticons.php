<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

class SmartIconsHelper {
	public static function getActions() {
		
		$user  	= JFactory::getUser();
		$result = new JObject;

		if (empty($idIcon)) {
			$assetName = 'com_smarticons';
		} else {
			$assetName = 'com_smarticons.icon.'.(int) $idIcon;
		}

		$actions = array(
				'core.view',
				'core.admin',
				'core.manage',
				'core.create',
				'core.edit',
				'core.edit.state',
				'core.delete'
		);

		foreach ($actions as $action) {
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}

	/**
	 * Configure the Linkbar.
	 *
	 * @param	string	The name of the active view.
	 *
	 * @return	void
	 * @since	1.6
	 */
	public static function addSubmenu($vName) {

		JHtmlSidebar::addEntry(
				JText::_('COM_SMARTICONS_SUBMENU_ICONS'), 'index.php?option=com_smarticons&view=icons',	$vName == 'icons'
		);

		JHtmlSidebar::addEntry(
				JText::_('COM_SMARTICONS_SUBMENU_CATEGORIES'), 'index.php?option=com_categories&extension=com_smarticons', $vName == 'categories'
		);
		if ($vName == 'categories') {
			if ($vName == 'categories') {
				JToolbarHelper::title(JText::sprintf('COM_CATEGORIES_CATEGORIES_TITLE', JText::_('COM_SMARTICONS')));
			}
		}
	}
}