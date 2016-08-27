<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

abstract class SmartIconsHelper {
	/**
	 * Stack to hold default buttons
	 *
	 * @since	1.3
	 */
	protected static $groups = array();

	/**
	 * Stack to hold buttons from plugins
	 *
	 * @since	1.3
	 */
	protected static $plugins = array();

	/**
	 * Variable to hold the global configuration
	 */
	protected static $globalConfig = array();


	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function getButtons() {
		
		if (empty(self::$groups)) {
			//Load the translation of the QuickIcon module to have standard trnaslations available
			JFactory::getLanguage()->load('mod_quickicon');
	
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			
			$query->select('id, title, alias')
			      ->from('#__categories')
			      ->where('extension = "com_smarticons"')
			      ->order('lft ASC');
			
			$db->setQuery($query);
			$groups = $db->loadObjectList('id');
			
			$query = $db->getQuery(true);

			//Create the query to extract the plugins
			$query->select('idIcon as id, catid, Name, Title, Text')
			      ->select('Target as link, Icon, Display, params ')
			      ->from('#__smarticons')
			      ->order('ordering');
	
			$db->setQuery($query);
			
			$icons = $db->loadObjectList();
			
			foreach ($icons as $icon) {
				$icon->type = "link";
					
				$icon->classes	= array();
				$icon->style	= array();
				$icon->options	= array();
				
				$icon->classes[] = 'icon-' . $icon->Icon;
				
				if ((!isset($groups[$icon->catid]->icons)) || (!is_array($groups[$icon->catid]->icons))) {
					$groups[$icon->catid]->icons = array();
				}
				$groups[$icon->catid]->icons[] = $icon;
			}
			
			$pluginGroup = self::getComponentConfig()->get('pluginCategory');
			
			if (is_null($pluginGroup)) {
				$catIds = array_keys($groups);
				$pluginGroup = array_pop($catIds);
			}

			$pluginIcons = self::plugins();

			if ((!isset($groups[$pluginGroup]->icons)) || (!is_array($groups[$pluginGroup]->icons))) {
				$groups[$pluginGroup]->icons = array();
			}
			$groups[$pluginGroup]->icons = array_merge($groups[$pluginGroup]->icons, $pluginIcons);
			
			self::$groups = $groups;
			
		}
		return self::$groups;
	}
	
	/**
	 * Helper method to generate a button in administrator panel
	 *
	 * @param	array	A named array with keys link, image, text, access and imagePath
	 *
	 * @return	string	HTML for button
	 * @since	1.6
	 */
	public static function button($button) {
		/*
		 * Verificari de acces pentru buton
		*/
		$globals = self::getComponentConfig();
		if (!is_object($button->params)) {
			// Load the JSON string
			$params = new JRegistry;
			$params->loadString($button->params);
			$button->params = $params;
		}

		// Merge global params with item params
		$params = clone $globals;
		$params->merge($button->params);
		$button->params = $params->toObject();

		if ($button->type == 'link') {
			
			$access = true;
	
			if (isset($button->params->accessCheck) && (!$button->params->accessCheck)) {
				$access = SmartIconsHelper::checkAccess($button);
			}
	
			if (!$access) {
				return;
			}
			
			$urlParts = array();
			
			if (isset($button->params->token)) {
				if ($button->params->token == 1) {
					$urlParts[] = JSession::getFormToken()."=1";
				}
			}
			
			if (isset($button->params->urlParams)) {
				$urlParts[] = str_replace("%user%", JFactory::getUser()->id, $button->params->urlParams);
			}
			
			if (!empty($urlParts)) {
				if (strpos($button->link, "?") === false) {
					$button->link.= "?";
				}
				$button->link.= "&".implode("&", $urlParts);
			}
			
		}

		if (isset($button->params->bold)) {
			if ( (int) $button->params->bold == 1) {
				$button->style[] = "font-weight:bold";
			}
		}
		
		if (isset($button->params->italic)) {
			if ( (int) $button->params->italic == 1) {
				$button->style[] = "font-style:italic";
			}
		}
		
		if (isset($button->params->underline)) {
			if ( (int) $button->params->underline == 1) {
				$button->style[] = "text-decoration:underline";
			}
		}
		
		if (isset($button->params->newWindow)) {
			if ( (int) $button->params->newWindow==1) {
				$button->options[] = 'target="_blank"';
			}
		}
		
		if (isset($button->params->modalWindow)) {
			if ( (int) $button->params->modalWindow==1) {
		
				// Load the modal behavior script.
				JHtml::_('behavior.modal');
		
				$button->options[] = "class=\"modal\"";
				$button->options[] = "rel=\"{handler: 'iframe', size: {x: ". $button->params->modalWidth .", y: ". $button->params->modalHeight ."}}\"";
			}
		}
		
		if (isset($button->params->height)) {
			if (is_numeric($button->params->height)) {
				$button->linkStyle[] = 'height:'. $button->params->height .'px';
			}
		}
		
		if (isset($button->params->width)) {
			if (is_numeric($button->params->width)) {
				$button->linkStyle[] = 'width:'. $button->params->width .'px';
			}
		}
		
		if (isset($button->Title)) {
			$button->options[] = "title=\"" . $button->Title . "\"";			
		}

		return $button;
	}

	public static function checkAccess($button) {
		$task = array();
		$component = array();
		$access = array();
		$access[] = array('core.view', 'com_smarticons.icon.' . $button->idIcon);
		if (preg_match('/option=(\b[a-zA-Z0-9_]*)/', $button->link, $component)) {
			$access[] = array('core.manage', $component[1]);
		}
		if (preg_match('/task=(\b[a-zA-Z0-9\.]*\b)/', $button->link, $task)) {
			$task = explode('.',$task[1]);
			switch ($task[1]) {
				case 'add':
					$access[] = array('core.create', $component[1]);
					break;
				case 'edit':
					$access[] = array('core.edit', $component[1]);
					break;
				default:
					break;
			}
		}
		foreach ($access as $permision) {
			if(!JFactory::getUser()->authorise($permision[0], $permision[1])) {
				return false;
			}
		};

		return true;
	}
	
	public static function plugins() {
		$pluginIcons = array();
	
		//Extract the quickicon plugins icons
		JPluginHelper::importPlugin('quickicon');
		$app = JFactory::getApplication();
			
		//Default quickicon plugins only render icons only if the context is "mod_quickicon"
		//We simulate this by passing a simulated context
		$pluginArray = (array) $app->triggerEvent('onGetIcons', array('mod_quickicon'));

		if (!empty($pluginArray)) {
			//Once we have the icons, we parse them to get them to a format the template understands
			foreach ($pluginArray as $plugin) {
				foreach ($plugin as $icon) {
					$button = new stdClass();
					
					$button->classes 	= array();
					$button->style		= array();
					$button->options	= array();
					$button->linkStyle	= array();
					
					$button->id = $icon['id'];
					$button->classes[] = 'icon-'. $icon['image'];
					$button->Name = $icon['text'];
					$button->link = $icon['link'];
					$button->Display = 4;
					$button->params = "";
					$button->type = "plugin";
					$pluginIcons[] = $button;
				};
			}
	
			return $pluginIcons;
		}
	}
	
	public static function getComponentConfig() {
		if (empty(self::$globalConfig)) {
			self::$globalConfig = JComponentHelper::getParams('com_smarticons');
		}
		return self::$globalConfig;
	}
	
}