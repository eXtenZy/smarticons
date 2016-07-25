<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('dropdown.init');
JHtml::_('formbehavior.chosen', 'select');

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

$sortFields = $this->getSortFields();

?>
<form action="<?php echo JRoute::_('index.php?option=com_smarticons&view=icons'); ?>" method="post" name="adminForm" id="adminForm">
	<?php if(!empty( $this->sidebar)): ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>
			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('COM_SMARTICONS_ICONS_FILTER_SEARCH_LABEL');?> </label> <input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('COM_SMARTICONS_ICONS_FILTER_SEARCH_LABEL'); ?>"
						value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('COM_SMARTICONS_ICONS_FILTER_SEARCH_DESC'); ?>"
					/>
				</div>
				<div class="btn-group pull-left">
					<button type="submit" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>">
						<i class="icon-search"></i>
					</button>
					<button type="button" class="btn hasTooltip" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>" onclick="document.id('filter_search').value='';this.form.submit();">
						<i class="icon-remove"></i>
					</button>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?> </label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				<div class="btn-group pull-right hidden-phone">
					<label for="directionTable" class="element-invisible"><?php echo JText::_('JFIELD_ORDERING_DESC');?> </label> <select name="directionTable" id="directionTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value="">
							<?php echo JText::_('JFIELD_ORDERING_DESC');?>
						</option>
						<option value="asc" <?php if ($listDirn == 'asc') echo 'selected="selected"'; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_ASCENDING');?>
						</option>
						<option value="desc" <?php if ($listDirn == 'desc') echo 'selected="selected"'; ?>>
							<?php echo JText::_('JGLOBAL_ORDER_DESCENDING');?>
						</option>
					</select>
				</div>
				<div class="btn-group pull-right">
					<label for="sortTable" class="element-invisible"><?php echo JText::_('JGLOBAL_SORT_BY');?></label>
					<select name="sortTable" id="sortTable" class="input-medium" onchange="Joomla.orderTable()">
						<option value="">
							<?php echo JText::_('JGLOBAL_SORT_BY');?>
						</option>
						<?php echo JHtml::_('select.options', $sortFields, 'value', 'text', $listOrder);?>
					</select>
				</div>
			</div>
			<div class="clearfix"></div>
			<table class="table table-striped" id="articleList">
				<thead>
					<?php echo $this->loadTemplate('head'); ?>
				</thead>
				<tfoot>
					<?php echo $this->loadTemplate('footer'); ?>
				</tfoot>
				<tbody>
					<?php
					if (count($this->icons) > 0) {
						echo $this->loadTemplate('body');
					} else {
						echo $this->loadTemplate('body_empty');
					}
					?>
				</tbody>
			</table>
		</div>
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
