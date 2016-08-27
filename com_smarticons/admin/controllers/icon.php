<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsControllerIcon extends JControllerForm {
	/**
	 * Method override to check if you can add a new record.
	 *
	 * @param   array  $data  An array of input data.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowAdd($data = array()) {
		$user       = JFactory::getUser();
		$filter     = $this->input->getInt('filter_category_id');
		$categoryId = JArrayHelper::getValue($data, 'catid', $filter, 'int');
		$allow      = null;

		if ($categoryId) {
			// If the category has been passed in the URL check it.
			$allow	= $user->authorise('core.create', $this->option . '.category.' . $categoryId);
		}

		if ($allow === null) {
			// In the absence of better information, revert to the component permissions.
			return parent::allowAdd($data);
		} else {
			return $allow;
		}
	}

	/**
	 * Method override to check if you can edit an existing record.
	 *
	 * @param   array   $data  An array of input data.
	 * @param   string  $key   The name of the key for the primary key.
	 *
	 * @return  boolean
	 *
	 * @since   1.6
	 */
	protected function allowEdit($data = array(), $key = 'idIcon') {
		$user		= JFactory::getUser();
		$recordId	= (int) isset($data[$key]) ? $data[$key] : 0;
		$categoryId = 0;

		if ($recordId) {
			$categoryId = (int) $this->getModel()->getItem($recordId)->catid;
		}

		if ($categoryId) {
			// The category has been set. Check the category permissions.
			return $user->authorise('core.edit', $this->option . '.category.' . $categoryId);
		} else {
			// Since there is no asset tracking, revert to the component permissions.
			return parent::allowEdit($data, $key);
		}
	}
	
	/**
	 * Method to run batch operations.
	 *
	 * @param object $model
	 *        	The model.
	 *        	
	 * @return boolean True if successful, false otherwise and internal error is set.
	 *        
	 * @since 1.6
	 */
	public function batch($model = null) {
		JSession::checkToken () or jexit ( JText::_ ( 'JINVALID_TOKEN' ) );
		
		// Set the model
		$model = $this->getModel ( 'Icon', '', array () );
		
		// Preset the redirect
		$this->setRedirect ( JRoute::_ ( 'index.php?option=com_smarticons&view=icons' . $this->getRedirectToListAppend (), false ) );
		
		return parent::batch ( $model );
	}
}