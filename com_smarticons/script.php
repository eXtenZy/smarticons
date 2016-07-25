<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class com_SmartIconsInstallerScript {
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) {
		$user			= JFactory::getUser();
		$db				= JFactory::getDbo();
		$categoryTable	= JTable::getInstance('Category');

		//Create the standard category for the default shortcuts
		$category = array();
		$category['parent_id']			= '1';
		$category['extension']			= 'com_smarticons';
		$category['title']				= 'Standard';
		$category['published']			= '1';
		$category['access']				= '1';
		$category['level']				= '1';
		$category['language']			= '*';
		$category['created_user_id']	= $user->id;

		$categoryTable->setLocation($category['parent_id'], 'last-child');
		$categoryTable->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');

		if ($categoryTable->save($category)) {
			//Get the id of the newly created category
			$query = $db->getQuery(true);
			$query->select('id');
			$query->from('#__categories');
			$query->where('extension = \'com_smarticons\'');
			$query->where('title = \'Standard\'');

			$db->setQuery($query);
			if ($id = (int)$db->loadResult()) {
				echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_CATEGORY_ADDSUCCESS') .'</p>';
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_CATEGORY_ADDFAIL').'</p>';
			}
		} else {
			echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_CATEGORY_ADDFAIL').'</p>';
		}


		//Create the shortcuts
		$icons = array();

		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_ADD_NEW_ARTICLE',
				'Title' => 'MOD_QUICKICON_ADD_NEW_ARTICLE',
				'Target' => 'index.php?option=com_content&task=article.add',
				'Icon' => ')',
				'Display' => 4,
				'state' => 1,
				'ordering' => 1);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_ARTICLE_MANAGER',
				'Title' => 'MOD_QUICKICON_ARTICLE_MANAGER',
				'Target' => 'index.php?option=com_content',
				'Icon' => ',',
				'Display' => 4,
				'state' => 1,
				'ordering' => 2);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_CATEGORY_MANAGER',
				'Title' => 'MOD_QUICKICON_CATEGORY_MANAGER',
				'Target' => 'index.php?option=com_categories&extension=com_content',
				'Icon' => '-',
				'Display' => 4,
				'state' => 1,
				'ordering' => 3);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_MEDIA_MANAGER',
				'Title' => 'MOD_QUICKICON_MEDIA_MANAGER',
				'Target' => 'index.php?option=com_media',
				'Icon' => '0',
				'Display' => 4,
				'state' => 1,
				'ordering' => 4);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_MENU_MANAGER',
				'Title' => 'MOD_QUICKICON_MENU_MANAGER',
				'Target' => 'index.php?option=com_menus',
				'Icon' => '1',
				'Display' => 4,
				'state' => 1,
				'ordering' => 5);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_USER_MANAGER',
				'Title' => 'MOD_QUICKICON_USER_MANAGER',
				'Target' => 'index.php?option=com_users',
				'Icon' => 'p',
				'Display' => 4,
				'state' => 1,
				'ordering' => 6);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_MODULE_MANAGER',
				'Title' => 'MOD_QUICKICON_MODULE_MANAGER',
				'Target' => 'index.php?option=com_modules',
				'Icon' => '3',
				'Display' => 4,
				'state' => 1,
				'ordering' => 7);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_EXTENSION_MANAGER',
				'Title' => 'MOD_QUICKICON_EXTENSION_MANAGER',
				'Target' => 'index.php?option=com_installer',
				'Icon' => '4',
				'Display' => 4,
				'state' => 1,
				'ordering' => 8);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_LANGUAGE_MANAGER',
				'Title' => 'MOD_QUICKICON_LANGUAGE_MANAGER',
				'Target' => 'index.php?option=com_languages',
				'Icon' => '%',
				'Display' => 4,
				'state' => 1,
				'ordering' => 9);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_GLOBAL_CONFIGURATION',
				'Title' => 'MOD_QUICKICON_GLOBAL_CONFIGURATION',
				'Target' => 'index.php?option=com_config',
				'Icon' => '8',
				'Display' => 4,
				'state' => 1,
				'ordering' => 10);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_TEMPLATE_MANAGER',
				'Title' => 'MOD_QUICKICON_TEMPLATE_MANAGER',
				'Target' => 'index.php?option=com_templates',
				'Icon' => '<',
				'Display' => 4,
				'state' => 1,
				'ordering' => 11);
		$icons[] = array(
				'idIcon' => 0,
				'catid' => $id,
				'Name' => 'MOD_QUICKICON_PROFILE',
				'Title' => 'MOD_QUICKICON_PROFILE',
				'Target' => 'index.php?option=com_admin&task=profile.edit',
				'Icon' => 'm',
				'Display' => 4,
				'state' => 1,
				'ordering' => 12,
				'params' => '{"accessCheck":"1","urlParams":"id=%user%"}');

		include_once JPATH_ADMINISTRATOR.'/components/com_smarticons/tables/icon.php';
		$iconsTable = new SmartIconsTableIcon($db);

		$iconsSaved = 0;

		//Save the default shortcuts in the database
		foreach ($icons as $icon) {
			$iconsTable->reset();
			$iconsTable->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');
			if ($iconsTable->save($icon)) {
				$iconsSaved++;
			}
		}

		echo '<p>'.JText::plural('COM_SMARTICONS_INSTALLER_N_ICONS_SAVED', $iconsSaved).'</p>';

		//Copy images to folder
		$sourceDir = JPATH_ADMINISTRATOR.'/components/com_smarticons/images';
		$targetDir = JPATH_SITE.'/images/smarticons';

		if (!(JFolder::exists($targetDir))) {
			if (JFolder::copy($sourceDir, $targetDir)) {
				JFolder::delete($sourceDir);
				echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_IMAGES_COPYSUCCESS') .'</p>';
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_IMAGES_COPYFAIL') .'</p>';
			}
		} else {
			echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_IMAGES_EXISTS') .'</p>';
		}

		//Install smarticons module
		$modulePath = JPATH_ADMINISTRATOR.'/components/com_smarticons/module';

		$installer = new JInstaller();
		$installer->setOverwrite(true);

		if ($installer->install($modulePath)) {
			JFolder::delete($modulePath);
			echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_MODULE_INSTALL_SUCCESS') .'</p>';
		} else {
			echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_MODULE_INSTALL_FAIL') .'</p>';
			echo "<p style=\"color:red\">".nl2br($installer->message) .'</p>';
		}

		//Enable mod_smarticons module
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__modules');
		$query->where('module = '.$db->quote('mod_smarticons'));

		$db->setQuery($query);

		if ($id = $db->loadResult()) {
			$query = $db->getQuery(true);
			$query->update('#__modules');
			$query->set('published = 1');
			$query->set('position = \'icon\'');
			$query->set('ordering = 1');
			$query->set('access = 3');
			$query->where('id = '. $db->quote($id));
			$db->setQuery($query);
			if ($db->query()) {
				$query = $db->getQuery(true);
				$query->insert('#__modules_menu');
				$query->set('moduleid = '. $db->quote($id));
				$query->set('menuid = 0');
				$db->setQuery($query);
				if ($db->query()) {
					echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_MODULE_ENABLE_SUCCESS') .'</p>';
				} else {
					echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_MODULE_ENABLE_FAIL') .'</p>';
				}
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_MODULE_ENABLE_FAIL') .'</p>';
			}

		} else {
			echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_MODULE_ENABLE_FAIL');
		}

		//Disable mod_quickicons module
		$query = $db->getQuery(true);

		$query->select('id');
		$query->from('#__modules');
		$query->where('module = '. $db->quote('mod_quickicon'));

		$db->setQuery($query);

		if ($id = $db->loadResult()) {
			$query = $db->getQuery(true);
			$query->update('#__modules');
			$query->set('published = 0');
			$query->where('id = '. $db->quote($id));
			$db->setQuery($query);
			if ($db->query()) {
				echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_QUICKICON_DISABLE_SUCCESS') .'</p>';
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_QUICKICON_DISABLE_FAIL') .'</p>';
			}
		} else {
			echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_QUICKICON_DISABLE_FAIL') .'</p>';
		}
	}

	/**
	 * method to uninstall the component
	 *
	 * @return void
	 */
	function uninstall($parent) {
		try {
			$db			= JFactory::getDbo();
			$installer	= new JInstaller();

			//Uninstall mod_smarticons
			$query = $db->getQuery(true);
			$query->select('extension_id');
			$query->from('#__extensions');
			$query->where('element = '. $db->quote('mod_smarticons'));

			$db->setQuery($query);
			if ($id = $db->loadResult()) {
				if ($installer->uninstall('module', $id)) {
					echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_MODULE_UNINSTALL_SUCCESS') .'</p>';
				} else {
					echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_MODULE_UNINSTALL_FAIL') .'</p>';
				}
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_MODULE_UNINSTALL_FAIL') .'</p>';
			}

			//Enable mod_quickicons
			$query = $db->getQuery(true);

			$query->select('id');
			$query->from('#__modules');
			$query->where('module = '. $db->quote('mod_quickicon'));

			$db->setQuery($query);
			if ($id = $db->loadResult()) {
				$query = $db->getQuery(true);
				$query->update('#__modules');
				$query->set('published = 1');
				$query->where('id = '. $db->quote($id));
				$db->setQuery($query);
				if ($db->query()) {
					echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_QUICKICON_ENABLE_SUCCESS') .'</p>';
				} else {
					echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_QUICKICON_ENABLE_FAIL') .'</p>';
				}
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_QUICKICON_ENABLE_FAIL') .'</p>';
			}

			//Delete assets
			$query = $db->getQuery(true);
			$query->delete('#__assets');
			$query->where('name LIKE \'%com_smarticons%\'');

			$db->setQuery($query);
			$db->query();

			//Delete categories
			$query = $db->getQuery(true);
			$query->delete('#__categories');
			$query->where('extension = '. $db->quote('com_smarticons'));
			$db->setQuery($query);

			if ($db->query()) {
				echo '<p>'. JText::_('COM_SMARTICONS_INSTALLER_CATEGORY_DELETESUCCESS') .'</p>';
			} else {
				echo "<p style=\"color:red\">".JText::_('COM_SMARTICONS_INSTALLER_CATEGORY_DELETEFAIL') .'</p>';
			}

			echo '<p>' . JText::_('COM_SMARTICONS_UNINSTALL_TEXT') . '</p>';

		} catch (Exception $e) {
			echo "<p style=\"color:red\">".$e->getMessage()."</p>";
		}
	}

	/**
	 * method to update the component
	 *
	 * @return void
	 */
	function update($parent) {

	}

	/**
	 * method to run before an install/update/uninstall method
	 *
	 * @return void
	 */
	function preflight($type, $parent) {
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_SMARTICONS_PREFLIGHT_' . $type . '_TEXT') . '</p>';
	}

	/**
	 * method to run after an install/update/uninstall method
	 *
	 * @return void
	 */
	function postflight($type, $parent) {
		// $type is the type of change (install, update or discover_install)
		echo '<p>' . JText::_('COM_SMARTICONS_POSTFLIGHT_' . $type . '_TEXT') . '</p>';
	}
}