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
		
		$script[] = "function setDisplay(mode) {";
		$script[] = "	Grid_text = $('grid_text');";
		$script[] = "	List_text = $('list_text');";
		$script[] = "	Grid_image = $('grid_image');";
		$script[] = "	List_image = $('list_image');";
		$script[] = "	Grid_icon = $('grid_icon');";
		$script[] = "	List_icon = $('list_icon');";
		$script[] = "	Icon_image_select = $('image_select');";
		$script[] = "	Icon_icon_select = $('icon_select');";
		$script[] = "	mode = parseInt(mode);";
		$script[] = "	switch(mode) {";
		$script[] = "		case 1:";
		$script[] = "			Grid_text.style.display = 'block';";
		$script[] = "			List_text.style.display = 'inline';";
		$script[] = "			Grid_image.style.display = 'block';";
		$script[] = "			List_image.style.display = 'inline';";
		$script[] = "			Icon_image_select.style.display = 'block';";
		$script[] = "			Grid_icon.style.display = 'none';";
		$script[] = "			List_icon.style.display = 'none';";
		$script[] = "			Icon_icon_select.style.display = 'none';";
		$script[] = "			break;";
		$script[] = "		case 2:";
		$script[] = "			Grid_text.style.display = 'none';";
		$script[] = "			List_text.style.display = 'none';";
		$script[] = "			Grid_image.style.display = 'block';";
		$script[] = "			List_image.style.display = 'inline';";
		$script[] = "			Icon_image_select.style.display = 'block';";
		$script[] = "			Grid_icon.style.display = 'none';";
		$script[] = "			List_icon.style.display = 'none';";
		$script[] = "			Icon_icon_select.style.display = 'none';";
		$script[] = "			break;";
		$script[] = "		case 3:";
		$script[] = "			Grid_text.style.display = 'block';";
		$script[] = "			List_text.style.display = 'inline';";
		$script[] = "			Grid_image.style.display = 'none';";
		$script[] = "			List_image.style.display = 'none';";
		$script[] = "			Icon_image_select.style.display = 'none';";
		$script[] = "			Grid_icon.style.display = 'none';";
		$script[] = "			List_icon.style.display = 'none';";
		$script[] = "			Icon_icon_select.style.display = 'none';";
		$script[] = "			break;";
		$script[] = "		case 4:";
		$script[] = "			Grid_text.style.display = 'block';";
		$script[] = "			List_text.style.display = 'inline';";
		$script[] = "			Grid_image.style.display = 'none';";
		$script[] = "			List_image.style.display = 'none';";
		$script[] = "			Icon_image_select.style.display = 'none';";
		$script[] = "			Grid_icon.style.display = 'block';";
		$script[] = "			List_icon.style.display = 'inline';";
		$script[] = "			Icon_icon_select.style.display = 'block';";
		$script[] = "			break;";
		$script[] = "		case 5:";
		$script[] = "			Grid_text.style.display = 'none';";
		$script[] = "			List_text.style.display = 'none';";
		$script[] = "			Grid_image.style.display = 'none';";
		$script[] = "			List_image.style.display = 'none';";
		$script[] = "			Icon_image_select.style.display = 'none';";
		$script[] = "			Grid_icon.style.display = 'block';";
		$script[] = "			List_icon.style.display = 'inline';";
		$script[] = "			Icon_icon_select.style.display = 'block';";
		$script[] = "			break;";
		$script[] = "		default:";
		$script[] = "			break;";
		$script[] = "	}";
		$script[] = "}";
		
		
		
		$document = JFactory::getDocument();
		$document->addScriptDeclaration(implode("\n", $script));
		$document->addStyleSheet('../media/com_smarticons/css/icon.css');
	}
}