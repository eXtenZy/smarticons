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
	
	public $categories = array (
			array(
					'parent_id' 		=> 1,
					'extension' 		=> 'com_smarticons',
					'title'				=> 'MOD_QUICKICON_CONTENT',
					'published'			=> 1,
					'access'			=> 1,
					'level'				=> 1,
					'language'			=> '*',
					'created_user_id'	=> 0,
					'icons'				=> array (
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_ADD_NEW_ARTICLE',
									'Target'	=> 'index.php?option=com_content&task=article.add',
									'Icon'		=> 'pencil-2',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 1
							),
							array(
									'idIcon' 	=> 0,
									'catid' 	=> 0,
									'Name' 		=> 'MOD_QUICKICON_ARTICLE_MANAGER',
									'Target' 	=> 'index.php?option=com_content',
									'Icon' 		=> 'stack',
									'Display' 	=> 4,
									'state' 	=> 1,
									'ordering' 	=> 2
							),
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_CATEGORY_MANAGER',
									'Target'	=> 'index.php?option=com_categories&extension=com_content',
									'Icon'		=> 'folder',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 3
							),
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_MEDIA_MANAGER',
									'Target'	=> 'index.php?option=com_media',
									'Icon'		=> 'pictures',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 4
							)
					)
			),
			array(
					'parent_id' 		=> 1,
					'extension' 		=> 'com_smarticons',
					'title'				=> 'MOD_QUICKICON_STRUCTURE',
					'published'			=> 1,
					'access'			=> 1,
					'level'				=> 1,
					'language'			=> '*',
					'created_user_id'	=> 0,
					'icons'				=> array (
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_MENU_MANAGER',
									'Target'	=> 'index.php?option=com_menus',
									'Icon'		=> 'list-view',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 5
							),
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_MODULE_MANAGER',
									'Target'	=> 'index.php?option=com_modules',
									'Icon'		=> 'cube',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 6
							)
					)
			),
			array(
					'parent_id' 		=> 1,
					'extension' 		=> 'com_smarticons',
					'title'				=> 'MOD_QUICKICON_USERS',
					'published'			=> 1,
					'access'			=> 1,
					'level'				=> 1,
					'language'			=> '*',
					'created_user_id'	=> 0,
					'icons'				=> array (
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_USER_MANAGER',
									'Target'	=> 'index.php?option=com_users',
									'Icon'		=> 'users',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 7
							)
					)
			),
			array(
					'parent_id' 		=> 1,
					'extension' 		=> 'com_smarticons',
					'title'				=> 'MOD_QUICKICON_CONFIGURATION',
					'published'			=> 1,
					'access'			=> 1,
					'level'				=> 1,
					'language'			=> '*',
					'created_user_id'	=> 0,
					'icons'				=> array (
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_LANGUAGE_MANAGER',
									'Target'	=> 'index.php?option=com_languages',
									'Icon'		=> 'comments-2',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 8
							),
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_GLOBAL_CONFIGURATION',
									'Target'	=> 'index.php?option=com_config',
									'Icon'		=> 'cog',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 9
							),
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_TEMPLATE_MANAGER',
									'Target'	=> 'index.php?option=com_templates',
									'Icon'		=> 'eye',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 10
							)
					)
			),
			array(
					'parent_id' 		=> 1,
					'extension' 		=> 'com_smarticons',
					'title'				=> 'MOD_QUICKICON_EXTENSIONS',
					'published'			=> 1,
					'access'			=> 1,
					'level'				=> 1,
					'language'			=> '*',
					'created_user_id'	=> 0,
					'icons'				=> array (
							array(
									'idIcon'	=> 0,
									'catid'		=> 0,
									'Name'		=> 'MOD_QUICKICON_INSTALL_EXTENSIONS',
									'Target'	=> 'iindex.php?option=com_installer',
									'Icon'		=> 'download',
									'Display'	=> 4,
									'state'		=> 1,
									'ordering'	=> 11
							)
					)
			),
			array(
					'parent_id' 		=> 1,
					'extension' 		=> 'com_smarticons',
					'title'				=> 'MOD_QUICKICON_MAINTENANCE',
					'published'			=> 1,
					'access'			=> 1,
					'level'				=> 1,
					'language'			=> '*',
					'created_user_id'	=> 0,
					'icons'				=> array ()
			)
	);
	
	/**
	 * method to install the component
	 *
	 * @return void
	 */
	function install($parent) {
		
		include_once JPATH_ADMINISTRATOR.'/components/com_smarticons/tables/icon.php';
		
		//Set language file from mod_quickicons
		JFactory::getLanguage()->load('mod_quickicon');
		
		$user				= JFactory::getUser();
		$db					= JFactory::getDbo();
		$categoriesSaved	= 0;
		$iconsSaved			= 0;

		//Create the categories for each group of icons
		foreach ($this->categories as $category) {
			$categoryTable	= JTable::getInstance('Category');
			
			$categoryTable->setLocation($category['parent_id'], 'last-child');
			$categoryTable->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');
			
			$category['title']				= JText::_($category['title']);
			$category['created_user_id']	= $user->id;

			if ($categoryTable->save($category)) {
				
				$query = $db->getQuery(true);
				
				$query->select('id')
				      ->from('#__categories')
				      ->where('title =' . $db->quote($category['title']));
				
				$db->setQuery($query);
				
				$categoryId = $db->loadResult();
				
				foreach ($category['icons'] as $icon) {
					$iconsTable = new SmartIconsTableIcon($db);
					
					$iconsTable->setRules('{"core.view":{"1":1},"core.delete":[],"core.edit":[],"core.edit.state":[]}');
					
					$icon['catid']	= $categoryId;
					$icon['Name']	= JText::_($icon['Name']);

					if ($iconsTable->save($icon)) {
						$iconsSaved++;
					}
				}
			} else {
				$error = $categoryTable->getErrors();
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
		
		$query->select('id')
		      ->from('#__modules')
		      ->where('module = '.$db->quote('mod_smarticons'));

		$db->setQuery($query);

		if ($id = $db->loadResult()) {
			$query = $db->getQuery(true);
			
			$query->update('#__modules')
			      ->set('published = 1')
			      ->set('position = \'icon\'')
			      ->set('ordering = 1')
			      ->set('access = 3')
			      ->where('id = '. $db->quote($id));
			
			$db->setQuery($query);
			
			if ($db->query()) {
				$query = $db->getQuery(true);
				
				$query->insert('#__modules_menu')
				      ->set('moduleid = '. $db->quote($id))
				      ->set('menuid = 0');
				      
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

		$query->select('id')
		      ->from('#__modules')
		      ->where('module = '. $db->quote('mod_quickicon'));

		$db->setQuery($query);

		if ($id = $db->loadResult()) {
			$query = $db->getQuery(true);
			
			$query->update('#__modules')
			      ->set('published = 0')
			      ->where('id = '. $db->quote($id));
			
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
			$query->select('extension_id')
			      ->from('#__extensions')
			      ->where('element = '. $db->quote('mod_smarticons'));

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

			$query->select('id')
			      ->from('#__modules')
			      ->where('module = '. $db->quote('mod_quickicon'));

			$db->setQuery($query);
			if ($id = $db->loadResult()) {
				
				$query = $db->getQuery(true);
				
				$query->update('#__modules')
				      ->set('published = 1')
				      ->where('id = '. $db->quote($id));
				      
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
			
			$query->delete('#__assets')
			      ->where('name LIKE \'%com_smarticons%\'');

			$db->setQuery($query);
			
			$db->query();

			//Delete categories
			$query = $db->getQuery(true);
			
			$query->delete('#__categories')
			      ->where('extension = '. $db->quote('com_smarticons'));
			      
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