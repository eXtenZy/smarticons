<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsViewImport extends JViewLegacy {
	function display($tpl = null) {
		// get the form
		$this->form = $this->get('Form');

		//set the document
		$this->setDocument();
			
		parent::display($tpl);
	}

	protected function setDocument() {
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('COM_SMARTICONS_ADMINISTRATION'));
	}
}