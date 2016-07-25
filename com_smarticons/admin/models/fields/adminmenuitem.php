<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access
defined('_JEXEC') or die('Restricted access');
// import the list field type
jimport('joomla.html.html');
jimport('joomla.form.formfield');
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('groupedlist');

class JFormFieldAdminMenuItem extends JFormFieldGroupedList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'AdminMenuItem';

	protected function getGroups() {
		// Initialise variables.
		$lang	= JFactory::getLanguage();
		$user	= JFactory::getUser();
		$db		= JFactory::getDbo();
		$query	= $db->getQuery(true);
		$groups	= array();
		$langs	= array();
		$name = null;

		// Prepare the query.
		$query->select('m.id, m.title, m.alias, m.link, m.parent_id, m.img, e.element');
		$query->from('#__menu AS m');

		// Filter on the enabled states.
		$query->leftJoin('#__extensions AS e ON m.component_id = e.extension_id');
		$query->where('m.client_id = 1');
		$query->where('e.enabled = 1');
		$query->where('m.id > 1');

		// Order by lft.
		$query->order('m.lft');

		$db->setQuery($query);
		// component list
		$components	= $db->loadObjectList();

		// Parse the list of extensions.
		foreach ($components as &$component) {
			// Trim the menu link.
			$component->link = trim($component->link);

			if ($component->parent_id == 1) {
				// Only add this top level if it is authorised and enabled.
				if ($user->authorise('core.manage', $component->element)) {


					// If the root menu link is empty, add it in.
					if (empty($component->link)) {
						$component->link = 'index.php?option='.$component->element;
					}

					if (!empty($component->element)) {
						// Load the core file then
						// Load extension-local file.
						$lang->load($component->element.'.sys', JPATH_BASE, null, false, false)
						||	$lang->load($component->element.'.sys', JPATH_ADMINISTRATOR.'/components/'.$component->element, null, false, false)
						||	$lang->load($component->element.'.sys', JPATH_BASE, $lang->getDefault(), false, false)
						||	$lang->load($component->element.'.sys', JPATH_ADMINISTRATOR.'/components/'.$component->element, $lang->getDefault(), false, false);
					}
					$name = $lang->hasKey($component->title) ? JText::_($component->title) : $component->alias;
					// Root level.
					if (!isset($groups[$name])) {
						$groups[$name] = array();
					}
					$groups[$name][] = JHtml::_('select.option', $component->link, $name);
				}
			} else {
				// Sub-menu level.
				if (isset($groups[$name])) {
					// Add the submenu link if it is defined.
					if (isset($groups[$name]) && !empty($component->link)) {
						$component->name = $lang->hasKey($component->title) ? JText::_($component->title) : $component->alias;
						if (!in_array(JHtml::_('select.option', $component->link, $component->name), $groups[$name])) {
							$groups[$name][] = JHtml::_('select.option', $component->link, $component->name);
						}
					}
				}
			}
		}
		$groups = array_merge(parent::getGroups(), $groups);

		return $groups;

	}
}