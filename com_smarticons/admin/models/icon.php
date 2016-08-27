<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/
defined ( '_JEXEC' ) or die ();
class SmartIconsModelIcon extends JModelAdmin {
	
	/**
	 * Returns a JTable object, always creating it.
	 *
	 * @param string $type
	 *        	The table type to instantiate. [optional]
	 * @param string $prefix
	 *        	A prefix for the table class name. [optional]
	 * @param array $config
	 *        	Configuration array for model. [optional]
	 *        	
	 * @return JTable A database object
	 *        
	 * @since 1.6
	 */
	public function getTable($type = 'Icon', $prefix = 'SmartIconsTable', $config = array()) {
		return JTable::getInstance ( $type, $prefix, $config );
	}
	
	/**
	 * Method to get the record form.
	 *
	 * @param array $data
	 *        	Data for the form. [optional]
	 * @param boolean $loadData
	 *        	True if the form is to load its own data (default case), false if not. [optional]
	 *        	
	 * @return mixed A JForm object on success, false on failure
	 *        
	 * @since 1.6
	 */
	public function getForm($data = array(), $loadData = true) {
		// Get the form.
		$form = $this->loadForm ( 'com_smarticons.icon', 'icon', array (
				'control' => 'jform',
				'load_data' => $loadData 
		) );
		if (empty ( $form )) {
			return false;
		}
		
		// Determine correct permissions to check.
		if ($this->getState ( 'icon.id' )) {
			// Existing record. Can only edit in selected categories.
			$form->setFieldAttribute ( 'catid', 'action', 'core.edit' );
		} else {
			// New record. Can only create in selected categories.
			$form->setFieldAttribute ( 'catid', 'action', 'core.create' );
		}
		
		return $form;
	}
	
	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return mixed The data for the form.
	 *        
	 * @since 1.6
	 */
	protected function loadFormData() {
		// Check the session for previously entered form data.
		$app = JFactory::getApplication ();
		$data = $app->getUserState ( 'com_smarticons.edit.icon.data', array () );
		
		if (empty ( $data )) {
			$data = $this->getItem ();
			
			// Prime some default values.
			if ($this->getState ( 'icon.id' ) == 0) {
				$data->set ( 'catid', $app->input->getInt ( 'catid', $app->getUserState ( 'com_smarticons.icons.filter.category_id' ) ) );
			}
		}
		
		return $data;
	}
	public function getItem($pk = null) {
		// Get the item
		$item = parent::getItem ( $pk );
		
		// Check to see if retrieval was succesful
		if (! empty ( $item )) {
			
			switch ($item->Display) {
				// Image
				case 1 :
				case 2 :
					$item->image = $item->Icon;
					$item->icon = '';
					break;
				// Icon
				case 4 :
				case 5 :
					$item->icon = $item->Icon;
					$item->image = '';
					break;
				default :
					$item->icon = '';
					$item->image = '';
					break;
			}
		}
		
		return $item;
	}
	
	/**
	 * A protected method to get a set of ordering conditions.
	 *
	 * @param JTable $table
	 *        	A record object.
	 *        	
	 * @return array An array of conditions to add to add to ordering queries.
	 *        
	 * @since 1.6
	 */
	protected function getReorderConditions($table) {
		$condition = array ();
		$condition [] = 'catid = ' . ( int ) $table->catid;
		$condition [] = 'state >= 0';
		return $condition;
	}
	
	/**
	 * Batch copy items to a new category or current.
	 *
	 * @param integer $value
	 *        	The new category.
	 * @param array $pks
	 *        	An array of row IDs.
	 * @param array $contexts
	 *        	An array of item contexts.
	 *        	
	 * @return mixed An array of new IDs on success, boolean false on failure.
	 *        
	 * @since 12.2
	 */
	protected function batchCopy($value, $pks, $contexts) {
		if (empty ( $this->batchSet )) {
			// Set some needed variables.
			$this->user = JFactory::getUser ();
			$this->table = $this->getTable ();
			$this->tableClassName = get_class ( $this->table );
			$this->contentType = new JUcmType ();
			$this->type = $this->contentType->getTypeByTable ( $this->tableClassName );
		}
		
		$categoryId = $value;
		
		if (! static::checkCategoryId ( $categoryId )) {
			return false;
		}
		
		$newIds = array ();
		
		// Parent exists so let's proceed
		while ( ! empty ( $pks ) ) {
			// Pop the first ID off the stack
			$pk = array_shift ( $pks );
			
			$this->table->reset ();
			
			// Check that the row actually exists
			if (! $this->table->load ( $pk )) {
				if ($error = $this->table->getError ()) {
					// Fatal error
					$this->setError ( $error );
					
					return false;
				} else {
					// Not fatal error
					$this->setError ( JText::sprintf ( 'JLIB_APPLICATION_ERROR_BATCH_MOVE_ROW_NOT_FOUND', $pk ) );
					continue;
				}
			}
			
			static::generateTitle ( $this->table );
			
			// Reset the ID because we are making a copy
			$this->table->idIcon = 0;
			
			// Unpublish because we are making a copy
			if (isset ( $this->table->published )) {
				$this->table->published = 0;
			} elseif (isset ( $this->table->state )) {
				$this->table->state = 0;
			}
			
			// New category ID
			$this->table->catid = $categoryId;

			// Check the row.
			if (! $this->table->check ()) {
				$this->setError ( $this->table->getError () );
				
				return false;
			}
			
			// Store the row.
			if (! $this->table->store ()) {
				$this->setError ( $this->table->getError () );
				
				return false;
			}
			
			// Get the new item ID
			$newId = $this->table->get ( 'idIcon' );
			
			// Add the new ID to the array
			$newIds [$pk] = $newId;
		}
		
		// Clean the cache
		$this->cleanCache ();
		
		return $newIds;
	}
	
	/**
	 * A method to preprocess generating a new title in order to allow tables with alternative names
	 * for title to use the batch move and copy methods
	 *
	 * @param   integer  $categoryId  The target category id
	 * @param   JTable   $table       The JTable within which move or copy is taking place
	 *
	 * @return  void
	 *
	 * @since   3.2
	 */
	public function generateTitle( $categoryId, $table) {
		// Alter the title & name
		$table->Name = JString::increment($table->Name);
		$table->Title = JString::increment($table->Title);
		
	}
}