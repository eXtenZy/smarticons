<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsViewIcons extends JViewLegacy {
	
	protected $categories;
	
	protected $icons;

	protected $pagination;

	protected $state;

	public function display($tpl = null) {
		
		$this->icons 		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state 		= $this->get('State');

		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}
		
		//Set language file from mod_quickicons
		JFactory::getLanguage()->load('mod_quickicon');
		
		$this->addToolbar();
		
		$this->addScript();
		
		SmartIconsHelper::addSubmenu('icons');
		
		$this->sidebar = JHtmlSidebar::render();
		
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolbar() {

		$canDo = SmartIconsHelper::getActions($this->state->get('filter.category_id'));
		$user = JFactory::getUser();
		
		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		JToolbarHelper::title(JText::_('COM_SMARTICONS_MANAGER_ICONS'), 'SmartIcons48x48.png');
		
		if (count($user->getAuthorisedCategories('com_smarticons', 'core.create')) > 0) {
			JToolbarHelper::addNew('icon.add');
		}

		if ($canDo->get('core.edit')) {
			JToolbarHelper::editList('icon.edit');
		}

		if ($canDo->get('core.edit.state')) {
			if ($this->state->get('filter.state') != 2) {
				JToolbarHelper::publish('icons.publish', 'JTOOLBAR_PUBLISH', true);
				JToolbarHelper::unpublish('icons.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			}
		}

		if ($canDo->get('core.edit.state')) {
			JToolbarHelper::checkin('icons.checkin');
		}

		if ($canDo->get('core.delete')) {
			JToolbarHelper::deleteList('', 'icons.delete', 'JTOOLBAR_DELETE');
		}

		if ($canDo->get('core.create')) {
			$bar = JToolbar::getInstance('toolbar');
			
			// Add the import button.
			$bar->appendButton('Popup', 'upload', 'COM_SMARTICONS_ICONS_TOOLBAR_IMPORT', 'index.php?option=com_smarticons&tmpl=component&view=import', 500, 200, 100, 100, '', 'COM_SMARTICONS_IMPORT_DETAILS');
			//Add the export button
			$bar->appendButton('Link', 'download', 'COM_SMARTICONS_ICONS_TOOLBAR_EXPORT', 'index.php?option=com_smarticons&task=icons.export&format=raw');
			
		}

		if ($canDo->get('core.admin')) {
			JToolbarHelper::preferences('com_smarticons');
		}

		JHtmlSidebar::setAction('index.php?option=com_smarticons&view=icons');

		JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_PUBLISHED'),
				'filter_state',
				JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);

		JHtmlSidebar::addFilter(
				JText::_('JOPTION_SELECT_CATEGORY'),
				'filter_category_id',
				JHtml::_('select.options', JHtml::_('category.options', 'com_smarticons'), 'value', 'text', $this->state->get('filter.category_id'))
		);

	}
	
	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 */
	protected function getSortFields() {
		return array(
				'Icon.idIcon' => JText::_('JGRID_HEADING_ID'),
				'Icon.Name' => JText::_('COM_SMARTICONS_ICONS_HEADING_NAME'),
				'Icon.Title' => JText::_('COM_SMARTICONS_ICONS_HEADING_TITLE'),
				'Icon.Display' => JText::_('COM_SMARTICONS_ICONS_HEADING_DISPLAY'),
				'Icon.ordering' => JText::_('JGRID_HEADING_ORDERING'),
				'Icon.state' => JText::_('JSTATUS')
		);
	}
	
	protected function addScript() {
		$listOrder	= $this->escape($this->state->get('list.ordering'));
		
		$script = array();
		$script[] = "Joomla.orderTable = function() {";
		$script[] = "	table = document.getElementById(\"sortTable\");";
		$script[] = "	direction = document.getElementById(\"directionTable\");";
		$script[] = "	order = table.options[table.selectedIndex].value;";
		$script[] = "		if (order != '$listOrder') {";
		$script[] = "			dirn = 'asc';";
		$script[] = "		} else {";
		$script[] = "			dirn = direction.options[direction.selectedIndex].value;";
		$script[] = "		}";
		$script[] = "		Joomla.tableOrdering(order, dirn, '');";
		$script[] = "	}";
		
		$document = JFactory::getDocument();
		$document->addScriptDeclaration(implode("\n", $script));
	}
}