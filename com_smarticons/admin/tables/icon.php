<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsTableIcon extends JTable {
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	public function __construct(& $db) {
		parent::__construct('#__smarticons', 'idIcon', $db);
	}

	/**
	 * Overloaded bind function
	 *
	 * @param	array		$hash named array
	 * @return	null|string	null is operation was satisfactory, otherwise returns an error
	 * @see JTable:bind
	 * @since 1.5
	 */
	public function bind($array, $ignore = array()) {

		if (isset($array['params']) && is_array($array['params'])) {
			
			$registry = new JRegistry;
			$registry->loadArray($array['params']);

			if((int) $registry->get('width', 0) < 0) {
				$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_NEGATIVE_NOT_PERMITTED', JText::_('COM_SMARTICONS_ICON_FIELD_ICON_WIDTH_LABEL')));
				return false;
			}

			if((int) $registry->get('height', 0) < 0) {
				$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_NEGATIVE_NOT_PERMITTED', JText::_('COM_SMARTICONS_ICON_FIELD_ICON_HEIGHT_LABEL')));
				return false;
			}
			
			if((int) $registry->get('modalWidth', 0) < 0) {
				$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_NEGATIVE_NOT_PERMITTED', JText::_('COM_SMARTICONS_ICON_FIELD_MODAL_WIDTH_LABEL')));
				return false;
			}

			if((int) $registry->get('modalHeight', 0) < 0) {
				$this->setError(JText::sprintf('JLIB_DATABASE_ERROR_NEGATIVE_NOT_PERMITTED', JText::_('COM_SMARTICONS_ICON_FIELD_MODAL_HEIGHT_LABEL')));
				return false;
			}

			// Converts the width and height to an absolute numeric value:
			$width = abs((int) $registry->get('width', 0));
			$height = abs((int) $registry->get('height', 0));
			$modalWidth = abs((int) $registry->get('modalWidth', 0));
			$modalHeight = abs((int) $registry->get('modalHeight', 0));

			// Sets the width and height to an empty string if = 0
			$registry->set('width', ($width ? $width : ''));
			$registry->set('height', ($height ? $height : ''));
			$registry->set('modalWidth', ($modalWidth ? $modalWidth : ''));
			$registry->set('modalHeight', ($modalHeight ? $modalHeight : ''));

			$array['params'] = (string) $registry;
		}

		if (isset($array['Display'])) {
			switch ((int)$array['Display']) {
				case 1:
				case 2:
					if (isset($array['image'])) {
						$array['Icon'] = $array['image'];
					}
					break;
				case 4:
				case 5:
					if (isset($array['icon'])) {
						$array['Icon'] = $array['icon'];
					}
					break;
				default:
					break;

			}
				
			unset($this->image);
			unset($this->icon);
		}

		//Bind the rules.
		if (isset($array['rules']) && is_array($array['rules'])) {
			$rules = new JAccessRules($array['rules']);
			$this->setRules($rules);
		}

		return parent::bind($array, $ignore);
	}

	/**
	 * Method to set the publishing state for a row or list of rows in the database
	 * table.  The method respects checked out rows by other users and will attempt
	 * to checkin rows that it can after adjustments are made.
	 *
	 * @param	mixed	An optional array of primary key values to update.  If not
	 *					set the instance property value is used.
	 * @param	integer The publishing state. eg. [0 = unpublished, 1 = published, 2=archived, -2=trashed]
	 * @param	integer The user id of the user performing the operation.
	 * @return	boolean	True on success.
	 */
	public function publish($pks = null, $state = 1, $userId = 0) {
		$k = $this->_tbl_key;

		// Sanitize input.
		JArrayHelper::toInteger($pks);
		$userId = (int) $userId;
		$state  = (int) $state;

		// If there are no primary keys set check to see if the instance key is set.
		if (empty($pks)) {
			if ($this->$k) {
				$pks = array($this->$k);
			} else {
				// Nothing to set publishing state on, return false.
				$this->setError(JText::_('JLIB_DATABASE_ERROR_NO_ROWS_SELECTED'));
				return false;
			}
		}

		// Get an instance of the table
		$table = JTable::getInstance('Icon', 'SmartIconsTable');

		// For all keys
		foreach ($pks as $pk) {
			// Load the banner
			if(!$table->load($pk)) {
				$this->setError($table->getError());
			}

			// Verify checkout
			if ($table->checked_out == 0 || $table->checked_out == $userId)	{
				// Change the state
				$table->state = $state;
				$table->checked_out = 0;
				$table->checked_out_time = $this->_db->getNullDate();

				// Check the row
				$table->check();

				// Store the row
				if (!$table->store()) {
					$this->setError($table->getError());
				}
			}
		}
		return count($this->getErrors()) == 0;
	}

	/**
	 * Method to compute the default name of the asset.
	 * The default name is in the form `table_name.id`
	 * where id is the value of the primary key of the table.
	 *
	 * @return      string
	 */
	protected function _getAssetName() {
		$k = $this->_tbl_key;
		return 'com_smarticons.icon.'.(int) $this->$k;
	}
	
	/**
	 * Method to return the title to use for the asset table.
	 *
	 * @return      string
	 */
	protected function _getAssetTitle() {
		return $this->Name;
	}

	/**
	 * Method to get the asset-parent-id of the item
	 *
	 * @return      int
	 */
	protected function _getAssetParentId($table = null, $id = null) {
		// We will retrieve the parent-asset from the Asset-table
		$assetParent = self::getInstance('Asset', 'JTable', array('dbo' => $this->getDbo()));
		// Default: if no asset-parent can be found we take the global asset
		$assetParentId = $assetParent->getRootId();

		// Find the parent-asset
		if (($this->catid)&& !empty($this->catid)) {
			// The item has a category as asset-parent
			$assetParent->loadByName('com_smarticons.category.' . (int) $this->catid);
		} else {
			// The item has the component as asset-parent
			$assetParent->loadByName('com_smarticons');
		}

		// Return the found asset-parent-id
		if ($assetParent->id) {
			$assetParentId=$assetParent->id;
		}
		return $assetParentId;
	}
}
