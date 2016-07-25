<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsController extends JControllerLegacy {
	public function display($cachable = false, $urlparams = false) {

		$this->default_view 	= $this->input->get('view','icons');
		$layout = $this->input->get('layout', 'default');
		$id 	= $this->input->get('idIcon');

		// Check for edit form.
		if ($this->default_view == 'icon' && $layout == 'edit' && !$this->checkEditId('com_smarticons.edit.icon', $id)) {

			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_smarticons&view=icons', false));

			return false;
		}

		parent::display();

		return $this;
	}
}