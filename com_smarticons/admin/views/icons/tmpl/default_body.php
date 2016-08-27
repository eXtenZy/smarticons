<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

$user		= JFactory::getUser();
$userId		= $user->get('id');

$listOrder	= $this->state->get('list.ordering');
$listDirn	= $this->state->get('list.direction');
$saveOrder	= $listOrder == 'Icon.ordering';

if ($saveOrder) {
	$saveOrderingUrl = 'index.php?option=com_smarticons&task=icons.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

foreach($this->icons as $i => $icon):
	$canCreate	= $user->authorise('core.create'	, 'com_smarticons.category.'. $icon->catid);
	$canChange 	= $user->authorise('core.edit.state', 'com_smarticons.category.'. $icon->catid);
	$canEdit	= $user->authorise('core.edit'		, 'com_smarticons.category.'. $icon->catid);
	$canCheckin	= $user->authorise('core.manage'	, 'com_checkin') || $item->checked_out == $userId || $item->checked_out == 0;
	$link = JRoute::_('index.php?option=com_smarticons&idIcon='.(int) $icon->idIcon);
	
	switch ($icon->Display) {
		case 1:
			$display = JText::_('COM_SMARTICONS_ICON_FIELD_DISPLAY_IMAGETEXT');
			break;
		case 2:
			$display = JText::_('COM_SMARTICONS_ICON_FIELD_DISPLAY_IMAGE');
			break;
		case 3:
			$display = JText::_('COM_SMARTICONS_ICON_FIELD_DISPLAY_TEXT');
			break;
		case 4:
			$display = JText::_('COM_SMARTICONS_ICON_FIELD_DISPLAY_ICONTEXT');
			break;
		case 5:
			$display = JText::_('COM_SMARTICONS_ICON_FIELD_DISPLAY_ICON');
			break;
		default:
			break;
	}
	
	if (empty($icon->CategoryTitle)) {
		$category = JText::_('COM_SMARTICONS_ICONS_BODY_UNCATEGORISED');
	} else {
		$category = $icon->CategoryTitle;
	}
	
?>
<tr class="row<?php echo $i % 2; ?>" sortable-group-id="<?php echo $icon->catid; ?>">
	<td class="order nowrap center hidden-phone">
	<?php if ($canChange) :
		$disableClassName = '';
		$disableLabel = '';
		if (!$saveOrder) :
			$disableClassName = 'inactive tip-top';
			$disableLabel = JText::_('JORDERINGDISABLED'); 
		endif; ?>
		<span class="sortable-handler hasTooltip <?php echo $disableClassName; ?>" title="<?php echo $disableLabel?>">
			<i class="icon-menu"></i>
		</span>
		<input type="text" style="display: none" name="order[]" size="5" value="<?php echo $icon->ordering; ?>" class="width-20 text-area-order" />
	<?php else :?>
		<span class="sortable-handler inactive">
			<i class="icon-menu"></i>
		</span>
	<?php endif; ?>
	</td>
	<td class="center">
		<?php echo JHtml::_('grid.id', $i, $icon->idIcon); ?>
	</td>
	<td>
		<?php echo JHtml::_('jgrid.published', $icon->state, $i, 'icons.', $canChange); ?>
	</td>
	<td class="nowrap has-context">
		<div class="pull-left">
			<?php 
			if ($icon->checked_out): 
				echo JHtml::_('jgrid.checkedout', $i, $icon->editor, $icon->checked_out_time, 'icons.', $canCheckin); 
			endif;
			if ($canEdit) :?>
			<a href="<?php echo JRoute::_('index.php?option=com_smarticons&task=icon.edit&idIcon='. (int)$icon->idIcon); ?>">
				<?php echo $this->escape($icon->Name); ?>
			</a>
			<?php else: 
				echo $this->escape($icon->Name);
			endif;?>
			<div class="small">
				<?php echo $this->escape($category)?>
			</div>
		</div>
		<div class="pull-left">
			<?php 
				JHtml::_('dropdown.edit', $icon->idIcon, 'icon.');
				JHtml::_('dropdown.divider');
				
				if ($icon->state) :
					JHtml::_('dropdown.unpublish', 'cb'. $i, 'icons.');
				else :
					JHtml::_('dropdown.publish', 'cb'. $i, 'icons.');
				endif;
				
				if ($icon->checked_out):
					JHtml::_('dropdown.divider');
				
					JHtml::_('dropdown.checkin', 'cb'. $i, 'icons.');
				endif;
				
				echo JHtml::_('dropdown.render');
				?>
		</div>
	</td>
	<td class="hidden-phone">
		<?php echo $icon->Title; ?>
	</td>
	<td class="hidden-phone">
		<?php echo $display; ?>
	</td>
	<td class="hidden-phone">
		<?php echo $icon->Target; ?>
	</td>
	<td class="hidden-phone">
		<?php echo $icon->idIcon; ?>
	</td>
</tr>
<?php endforeach; 