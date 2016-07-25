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
	protected static $tabs = array();

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
	 * Helper method to generate a button in administrator panel
	 *
	 * @param	array	A named array with keys link, image, text, access and imagePath
	 *
	 * @return	string	HTML for button
	 * @since	1.6
	 */
	public static function button($button, $layout = 'list') {
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

		$access = true;

		if (isset($button->params->accessCheck)) {
			if (!$button->params->accessCheck) {
				$access = SmartIconsHelper::checkAccess($button);
			}
		} else {
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
			if (strpos($button->Target, "?") === false) {
				$button->Target.= "?";
			}
			$button->Target.= "&".implode("&", $urlParts);
		}

		ob_start();
		require JModuleHelper::getLayoutPath('mod_smarticons', $layout);
		$html = ob_get_clean();
		return $html;
	}

	public static function checkAccess($button) {
		$task = array();
		$component = array();
		$access = array();
		$access[] = array('core.view', 'com_smarticons.icon.' . $button->idIcon);
		if (preg_match('/option=(\b[a-zA-Z0-9_]*)/', $button->Target, $component)) {
			$access[] = array('core.manage', $component[1]);
		}
		if (preg_match('/task=(\b[a-zA-Z0-9\.]*\b)/', $button->Target, $task)) {
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

	public static function plugin($button, $layout = 'list') {
		$globals = self::getComponentConfig();

		$button->params = $globals->toObject();

		ob_start();
		require JModuleHelper::getLayoutPath('mod_smarticons', $layout);
		$html = ob_get_clean();
		return $html;
	}

	public static function plugins($layout = 'list') {
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
					$button->id = $icon['id'];
					$button->Icon = self::translateClassToChar($icon['image']);
					$button->Target = $icon['link'];
					$button->Name = $icon['text'];
					$button->Display = 4;
					$button->params = "";
					$pluginIcons[] = $button;
				};
			}

			foreach ($pluginIcons as $plugin) {
				echo self::plugin($plugin, $layout);
			}
			return $pluginIcons;
		}
	}

	/**
	 * Helper method to return button list.
	 *
	 * This method returns the array by reference so it can be
	 * used to add custom buttons or remove default ones.
	 *
	 * @return	array	An array of buttons
	 * @since	1.6
	 */
	public static function &getButtons() {
		if (empty(self::$tabs)) {
			//Load the translation of the QuickIcon module to have standard trnaslations available
			JFactory::getLanguage()->load('mod_quickicon');

			$db = JFactory::getDbo();
			$query = $db->getQuery(true);

			//Create the query to extract the plugins
			$query->select('Tab.title AS Tab, Tab.id as TabId, Tab.alias as TabAlias, Icon.idIcon ');
			$query->select('Icon.Name, Icon.Title, Icon.Text, Icon.Target, Icon.Icon, Icon.Display, Icon.params ');
			$query->from('#__smarticons AS Icon');
			$query->innerjoin('#__categories AS Tab ON Icon.catid = Tab.id');
			$query->where('Icon.state = 1');
			$query->where('Tab.published = 1');
			$query->order('Tab.lft, Icon.ordering');

			$db->setQuery($query);

			if($icons = $db->loadObjectList()) {
				$tabId = null;
				foreach ($icons as $icon) {
					if ($tabId != $icon->TabId) {
						if (!is_null($tabId)) {
							self::$tabs[] = $tab;
						}
						$tab = new stdClass();
						$tab->Title = $icon->Tab;
						$tab->Alias = $icon->Tab;
						$tab->Id = $icon->TabId;
						$tab->icons = array();
						$tabId = $icon->TabId;
					}
					$tab->icons[] = $icon;
				}
				self::$tabs[] = $tab;
			};
		}
		return self::$tabs;
	}

	public static function getComponentConfig() {
		if (empty(self::$globalConfig)) {
			self::$globalConfig = JComponentHelper::getParams('com_smarticons');
		}
		return self::$globalConfig;
	}

	public static function translateClassToChar($class) {
		switch ($class) {
			case 'home':
				$character = "!";
				break;
			case 'user':
				$character = "\"";
				break;
			case 'checkedout':
			case 'lock':
			case 'locked':
				$character = "#";
				break;
			case 'comment':
			case 'comments':
				$character = "$";
				break;
			case 'comments-2':
				$character = "%";
				break;
			case 'share-alt':
			case 'out':
				$character = "&";
				break;
			case 'share':
			case 'redo':
				$character = "'";
				break;
			case 'undo':
				$character = ")";
				break;
			case 'file-add':
				$character = "(";
				break;
			case 'new':
			case 'plus':
				$character = "*";
				break;
			case 'apply':
			case 'edit':
			case 'pencil':
				$character = "+";
				break;
			case 'pencil-2':
				$character = ",";
				break;
			case 'folder-open':
			case 'folder':
				$character = "-";
				break;
			case 'folder-close':
			case 'folder-2':
				$character = ".";
				break;
			case 'picture':
				$character = "/";
				break;
			case 'pictures':
				$character = "0";
				break;
			case 'list':
			case 'list-view':
				$character = "1";
				break;
			case 'power-cord':
				$character = "2";
				break;
			case 'cube':
				$character = "3";
				break;
			case 'puzzle':
				$character = "4";
				break;
			case 'flag':
				$character = "5";
				break;
			case 'tools':
				$character = "6";
				break;
			case 'cogs':
				$character = "7";
				break;
			case 'options':
			case 'cog':
				$character = "8";
				break;
			case 'equalizer':
				$character = "9";
				break;
			case 'wrench':
				$character = ":";
				break;
			case 'brush':
				$character = ";";
				break;
			case 'eye-open':
			case 'eye':
				$character = "<";
				break;
			case 'checkbox-unchecked':
				$character = "=";
				break;
			case 'checkin':
			case 'checkbox':
				$character = ">";
				break;
			case 'checkbox-partial':
				$character = "?";
				break;
			case 'asterisk':
			case 'star-empty':
				$character = "@";
				break;
			case 'star-2':
				$character = "A";
				break;
			case 'featured':
			case 'star':
				$character = "B";
				break;
			case 'calendar':
				$character = "C";
				break;
			case 'calendar-2':
				$character = "D";
				break;
			case 'question-sign':
			case 'help':
				$character = "E";
				break;
			case 'support':
				$character = "F";
				break;
			case 'warning':
				$character = "H";
				break;
			case 'publish':
			case 'save':
			case 'ok':
			case 'checkmark':
				$character = "G";
				break;
			case 'unpublish':
			case 'cancel':
				$character = "J";
				break;
			case 'eye-close':
			case 'minus':
				$character = "K";
				break;
			case 'purge':
			case 'trash':
				$character = "L";
				break;
			case 'envelope':
			case 'mail':
				$character = "M";
				break;
			case 'mail-2':
				$character = "N";
				break;
			case 'unarchive':
			case 'drawer':
				$character = "O";
				break;
			case 'archive':
			case 'drawer-2':
				$character = "P";
				break;
			case 'box-add':
				$character = "Q";
				break;
			case 'box-remove':
				$character = "R";
				break;
			case 'search':
				$character = "S";
				break;
			case 'filter':
				$character = "T";
				break;
			case 'camera':
				$character = "U";
				break;
			case 'play':
				$character = "V";
				break;
			case 'music':
				$character = "W";
				break;
			case 'grid-view':
				$character = "X";
				break;
			case 'grid-view-2':
				$character = "Y";
				break;
			case 'menu':
				$character = "Z";
				break;
			case 'thumbs-up':
				$character = "[";
				break;
			case 'thumbs-down':
				$character = "\\";
				break;
			case 'delete':
			case 'remove':
			case 'cancel-2':
				$character = "I";
				break;
			case 'save-new':
			case 'plus-2':
				$character = "]";
				break;
			case 'ban-circle':
			case 'minus-sign':
			case 'minus-2':
				$character = "^";
				break;
			case 'key':
				$character = "_";
				break;
			case 'quote':
				$character = "`";
				break;
			case 'quote-2':
				$character = "a";
				break;
			case 'database':
				$character = "b";
				break;
			case 'location':
				$character = "c";
				break;
			case 'zoom-in':
				$character = "d";
				break;
			case 'zoom-out':
				$character = "e";
				break;
			case 'expand':
				$character = "f";
				break;
			case 'contract':
				$character = "g";
				break;
			case 'expand-2':
				$character = "h";
				break;
			case 'contract-2':
				$character = "i";
				break;
			case 'health':
				$character = "j";
				break;
			case 'wand':
				$character = "k";
				break;
			case 'unblock':
			case 'refresh':
				$character = "l";
				break;
			case 'vcard':
				$character = "m";
				break;
			case 'clock':
				$character = "n";
				break;
			case 'compass':
				$character = "o";
				break;
			case 'address':
				$character = "p";
				break;
			case 'feed':
				$character = "q";
				break;
			case 'flag-2':
				$character = "r";
				break;
			case 'pin':
				$character = "s";
				break;
			case 'lamp':
				$character = "t";
				break;
			case 'chart':
				$character = "u";
				break;
			case 'bars':
				$character = "v";
				break;
			case 'pie':
				$character = "w";
				break;
			case 'dashboard':
				$character = "x";
				break;
			case 'lightning':
				$character = "y";
				break;
			case 'move':
				$character = "z";
				break;
			case 'next':
				$character = "{";
				break;
			case 'previous':
				$character = "|";
				break;
			case 'first':
				$character = "}";
				break;
			case 'last':
				$character = "";
				break;
			case 'loop':
				$character = "";
				break;
			case 'shuffle':
				$character = "";
				break;
			case 'arrow-first':
				$character = "";
				break;
			case 'arrow-last':
				$character = "";
				break;
			case 'chevron-up':
			case 'uparrow':
			case 'arrow-up':
				$character = "";
				break;
			case 'chevron-right':
			case 'arrow-right':
				$character = "";
				break;
			case 'chevron-down':
			case 'downarrow':
			case 'arrow-down':
				$character = "";
				break;
			case 'chevron-left':
			case 'arrow-left':
				$character = "";
				break;
			case 'arrow-up-2':
				$character = "";
				break;
			case 'arrow-right-2':
				$character = "";
				break;
			case 'arrow-down-2':
				$character = "";
				break;
			case 'arrow-left-2':
				$character = "";
				break;
			case 'play-2':
				$character = "";
				break;
			case 'menu-2':
				$character = "";
				break;
			case 'arrow-up-3':
				$character = "";
				break;
			case 'arrow-right-3':
				$character = "";
				break;
			case 'arrow-down-3':
				$character = "";
				break;
			case 'arrow-left-3':
				$character = "";
				break;
			case 'print':
			case 'printer':
				$character = "";
				break;
			case 'color-palette':
				$character = "";
				break;
			case 'camera-2':
				$character = "";
				break;
			case 'file':
				$character = "";
				break;
			case 'file-remove':
				$character = "";
				break;
			case 'save-copy':
			case 'copy':
				$character = "";
				break;
			case 'cart':
				$character = "";
				break;
			case 'basket':
				$character = "";
				break;
			case 'broadcast':
				$character = "";
				break;
			case 'screen':
				$character = "";
				break;
			case 'tablet':
				$character = "";
				break;
			case 'mobile':
				$character = "";
				break;
			case 'users':
				$character = "";
				break;
			case 'briefcase':
				$character = "";
				break;
			case 'download':
				$character = "";
				break;
			case 'upload':
				$character = "";
				break;
			case 'bookmark':
				$character = "";
				break;
			case 'out-2':
				$character = "";
				break;
			default:
				$character = "";
		}
		return $character;
	}
}