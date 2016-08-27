<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsModelIcons extends JModelList {
	public function __construct($config = array()) {
		if (empty($config['filter_fields'])) {
			$config['filter_fields'] = array(
					'Icon.idIcon', 'Icon.ordering',
					'Icon.state', 'Icon.Title',
					'Icon.Display', 'Icon.Name'
			);
		}

		parent::__construct($config);
	}

	protected function getListQuery() {
		// Create a new query object.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Select icon fields
		$query->select('Icon.idIcon, Icon.asset_id, Icon.catid, Icon.Name, Icon.Title, Icon.Target ');
		$query->select('Icon.Display, Icon.state, Icon.ordering, Icon.checked_out, Icon.checked_out_time ');
		// From the icon table
		$query->from('#__smarticons AS Icon ');

		//Select category fields
		$query->select('Category.title AS CategoryTitle ');
		//Join with categories
		$query->join('LEFT OUTER', '#__categories AS Category ON Icon.catid = Category.id ');

		//Select the checked out user
		$query->select('User.name AS editor ');
		//Join with the users table
		$query->join('LEFT OUTER', '#__users AS User ON Icon.checked_out = User.id ');

		// Filter by a single or group of categories.
		$categoryId = $this->getState('filter.category_id');
		if (is_numeric($categoryId)) {
			$query->where('Icon.catid = '.(int) $categoryId);
		}

		// Filter by search in title.
		$search = $this->getState('filter.search');
		if (!empty($search)) {
			if (stripos($search, 'id:') === 0) {
				$query->where('Icon.idIcon = '.(int) substr($search, 3));
			} else if (stripos($search, 'tab:') === 0) {
				$search = $db->Quote('%'.$db->getEscaped(substr($search, 4), true).'%');
				$query->where('(Category.title LIKE '.$search.')');
			} else {
				$search = $db->Quote('%'.$db->getEscaped($search, true).'%');
				$query->where('(Icon.Name LIKE '.$search.' OR Icon.Title LIKE '.$search.')');
			}
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'Icon.ordering');
		$orderDirn	= $this->state->get('list.direction', 'ASC');

		$query->order($db->escape($orderCol.' '.$orderDirn));

		return $query;
	}

	public function getItemsForExport() {
		// Create a new query object.
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Select icons
		$query->select('*');

		// From the icon table
		$query->from('#__smarticons');

		$icons = $this->_getList($query);

		//Select categories
		$query = $db->getQuery(true);
		$query->select('id, title, alias, description');

		// From the icon table
		$query->from('#__categories');

		//Limit results only to our extension
		$query->where('extension = \'com_smarticons\'');

		$categories = $this->_getList($query);

		$result = array();
		$result['icons'] = $icons;
		$result['categories'] = $categories;

		return $result;
	}

	protected function populateState($ordering = null, $direction = null) {
		$search = $this->getUserStateFromRequest($this->context.'.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$categoryId = $this->getUserStateFromRequest($this->context.'.filter.category_id', 'filter_category_id');
		$this->setState('filter.category_id', $categoryId);

		// Load the parameters.
		$params = JComponentHelper::getParams('com_smarticons');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('Icon.ordering', 'ASC');
	}

}