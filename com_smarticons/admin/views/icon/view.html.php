<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

JLoader::register('IconsHelper', JPATH_COMPONENT.'/helpers/icons.php');

class SmartIconsViewIcon extends JViewLegacy {
	protected $form;

	protected $item;

	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null) {
		// Initialiase variables.
		$this->form		= $this->get('Form');
		$this->item		= $this->get('Item');
		$this->state	= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		//Set language file from mod_quickicons
		JFactory::getLanguage()->load('mod_quickicon');
		
		$this->addToolbar();
		
		$this->addScript();
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar() {
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user		= JFactory::getUser();
		$userId		= $user->get('id');
		$isNew		= ($this->item->idIcon == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);
		// Since we don't track these assets at the item level, use the category id.
		$canDo		= SmartIconsHelper::getActions($this->item->catid, 0);

		JToolbarHelper::title($isNew ? JText::_('COM_SMARTICONS_MANAGER_ICON_NEW') : JText::_('COM_SMARTICONS_MANAGER_ICON_EDIT'), 'banners.png');
		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || count($user->getAuthorisedCategories('com_smarticons', 'core.create')) > 0)) {
			JToolbarHelper::apply('icon.apply');
			JToolbarHelper::save('icon.save');

			if ($canDo->get('core.create')) {
				JToolbarHelper::save2new('icon.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create')) {
			JToolbarHelper::save2copy('icon.save2copy');
		}

		if (empty($this->item->idIcon))  {
			JToolbarHelper::cancel('icon.cancel');
		}
		else {
			JToolbarHelper::cancel('icon.cancel', 'JTOOLBAR_CLOSE');
		}

	}

	protected function addScript() {
		
		$script = array();
		
		$script[] = "function changeImage(imgSrc) {";
		$script[] = "	$('grid_image').src = '" . JURI::root() . "' + imgSrc;";
		$script[] = "	$('list_image').src = '" . JURI::root() . "' + imgSrc;";
		$script[] = "}";
		
		$document = JFactory::getDocument();
		$document->addScriptDeclaration(implode("\n", $script));
		$document->addStyleSheet('../media/com_smarticons/css/icon.css');
		$document->addScript ( JURI::root () . "/administrator/components/com_smarticons/views/icon/tmpl/icon.js" );
	}
}