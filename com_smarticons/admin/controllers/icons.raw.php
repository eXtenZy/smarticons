<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

class SmartIconsControllerIcons extends JControllerAdmin {
	public function getModel($name = 'Icon', $prefix = 'SmartIconsModel', $config = array('ignore_request' => true)) {
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	public function export() {
		//Retrieve the model
		$model = $this->getModel('Icons');

		//Set the state for the model
		$model->setState('list.ordering', 'Icon.ordering');

		//Retrieve the items for export, both categories and icons
		$items = $model->getItemsForExport();

		//Create the XML object that will store the items
		$xml = new SimpleXMLElement("<SmartIconsExport />");

		//Parse the results into an xml file
		foreach ($items['categories'] as $category) {
			//Store the category's information
			$xmlCategory = $xml->addChild('category');
			$xmlCategory->addAttribute('id', $category->id);
			$xmlCategory->addChild('title', $category->title);
			$xmlCategory->addChild('alias', $category->alias);
			$xmlCategory->addChild('description', $category->description);

			//Create a node to store the icons from this category
			$xmlCategoryIcons = $xmlCategory->addChild('icons');

			foreach ($items['icons'] as $icon) {
				//We go thought the icons returned, checking if they
				//belong to the current category
				if ($icon->catid == $category->id) {
					
					//We store the icon's details
					$xmlIcon = $xmlCategoryIcons->addChild('icon');
					$xmlIcon->addAttribute('id', $icon->idIcon);
					$xmlIcon->addChild('name', $icon->Name);
					$xmlIcon->addChild('title', $icon->Title);
					$xmlIcon->addChild('text', $icon->Text);
					$xmlIcon->addChild('target', $icon->Target);
					$xmlIcon->addChild('icon', $icon->Icon);
					$xmlIcon->addChild('display', $icon->Display);
					$xmlIcon->addChild('published', $icon->state);
					$xmlIcon->addChild('ordering', $icon->ordering);
					$xmlIcon->addChild('params', $icon->params);
				}
			}
		}

		//Set the headers so to force the download
		header('Content-disposition: attachment; filename=SmartIconsExport.xml');
		header('Content-Type: text/xml');

		//Send the data
		echo $xml->asXML();

		//Close the application so we are not redirected
		JFactory::getApplication()->close();
	}
}