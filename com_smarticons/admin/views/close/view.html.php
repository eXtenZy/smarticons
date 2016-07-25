<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsViewClose extends JViewLegacy {

	/**
	 * Display the view
	 */
	function display($tpl = null) {
		// close a modal window
		JFactory::getDocument()->addScriptDeclaration('
				window.parent.location.href=window.parent.location.href;
				window.parent.SqueezeBox.close();
				');
	}
}