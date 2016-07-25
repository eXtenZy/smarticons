<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsControllerImport extends JControllerForm {

	function save($key = null, $urlVar = null) {
		// Check for request forgeries.
		JRequest::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Set FTP credentials, if given.
		JClientHelper::setCredentialsFromRequest('ftp');

		// Initialise variables.
		$app	= JFactory::getApplication();
		$model	= $this->getModel('Import');

		// Get the uploaded file information
		$data = JRequest::getVar('xmlFile', null, 'files', 'array');

		// Check if the user is authorized to do this.
		if (!JFactory::getUser()->authorise('core.admin', $this->option)) {
			JFactory::getApplication()->redirect('index.php', JText::_('JERROR_ALERTNOAUTHOR'));
			return;
		}

		// Validate the posted data.
		$return = $model->validate(null, $data);

		// Check for validation errors.
		if ($return === false) {
			// Get the validation messages.
			$errors	= $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState('com_config.config.global.data', $data);

			// Redirect back to the edit screen.
			$this->setRedirect(JRoute::_('index.php?option=com_smarticons&view=import&tmpl=component', false));
			return false;
		}

		/// Build the appropriate paths
		$config		= JFactory::getConfig();
		$tmp_dest	= $config->get('tmp_path') . '/' . $data['name'];
		$tmp_src	= $data['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest);

		$xmlObject = simplexml_load_file($tmp_dest);

		if (!$xmlObject) {
			$app->enqueueMessage(JText::_("COM_SMARTICONS_IMPORT_ERROR_FILEUPLOAD_XML_PARSING"), 'warning');

			// Redirect back to the edit screen.
			$this->setRedirect(JRoute::_('index.php?option=com_smarticons&view=import&tmpl=component', false));
			return false;
		}

		$return = $model->save($xmlObject);

		// Check the return value.
		if ($return === false) {
			// Save the data in the session.
			$app->setUserState('com_config.config.global.data', $data);

			// Save failed, go back to the screen and display a notice.
			$message = JText::sprintf('JERROR_SAVE_FAILED', $model->getError());
			$this->setRedirect('index.php?option=com_smarticons&view=import&tmpl=component', $message, 'error');
			return false;
		}

		JFile::delete($tmp_dest);

		// Set the redirect based on the task.
		$this->setRedirect('index.php?option=com_smarticons&view=close&tmpl=component');

		return true;
	}
}