<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

?>

<tr>
	<th width="1%" class="nowrap center hidden-phone">
		<?php echo JHtml::_('grid.sort', '<i class="icon-menu-2"></i>', 'Icon.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING'); ?>
	</th>
	<th width="1%" class="hidden-phone">
		<input type="checkbox" name="checkall-toggle" value="" title="<?php echo JText::_('JGLOBAL_CHECK_ALL');?>" onclick="Joomla.checkAll(this)" />
	</th>
	<th width="1%" class="nowrap center">
		<?php echo JHtml::_('grid.sort', 'JSTATUS', 'Icon.state', $listDirn, $listOrder); ?>
	</th>
	<th>
		<?php echo JHtml::_('grid.sort', 'COM_SMARTICONS_ICONS_HEADING_NAME', 'Icon.Name', $listDirn, $listOrder); ?>
	</th>
	<th width="15%" class="hidden-phone">
		<?php echo JHtml::_('grid.sort',  'COM_SMARTICONS_ICONS_HEADING_TITLE', 'Icon.Title', $listDirn, $listOrder); ?>
	</th>
	<th width="15%">
		<?php echo JHtml::_('grid.sort',  'COM_SMARTICONS_ICONS_HEADING_DISPLAY', 'Icon.Display', $listDirn, $listOrder); ?>
	</th>
	<th width="30%">
		<?php echo JText::_('COM_SMARTICONS_ICONS_HEADING_TARGET'); ?>
	</th>
	<th width="1%" class="nowrap center hidden-phone">
		<?php echo JHtml::_('grid.sort', 'JGRID_HEADING_ID', 'Icon.idIcon', $listDirn, $listOrder); ?>
	</th>
</tr>
