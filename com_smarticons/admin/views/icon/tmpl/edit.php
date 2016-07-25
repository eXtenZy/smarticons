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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

$params = $this->form->getFieldsets('params');

$this->displayImgControl = false;
$this->displayIconControl = false;

switch ($this->item->Display) {
	case 1:
	case 2:
		$this->displayImgControl = true;
		$this->displayIconControl = false;
		break;
	case 3:
		$this->displayImgControl = false;
		$this->displayIconControl = false;
		break;
	case 4:
	case 5:
	default:
		$this->displayImgControl = false;
		$this->displayIconControl = true;
		break;
}

?>
<form action="<?php echo JRoute::_('index.php?option=com_smarticons&layout=edit&idIcon='.(int) $this->item->idIcon); ?>" method="post" name="adminForm" id="adminForm" class="form-validate form-horizontal">
<div class="span8 form-horizontal">
	<fieldset>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#details" data-toggle="tab"><?php echo JText::_('COM_SMARTICONS_ICON_DETAILS');?></a></li>
			<li><a href="#display" data-toggle="tab"><?php echo JText::_('COM_SMARTICONS_ICON_DISPLAY_OPTIONS');?></a></li>
			<li><a href="#advanced" data-toggle="tab"><?php echo JText::_('COM_SMARTICONS_ICON_ADVANCED_OPTIONS');?></a></li>
			<li><a href="#permissions" data-toggle="tab"><?php echo JText::_('COM_SMARTICONS_ACCESS_FIEDLSET_RULES');?></a></li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="details">
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Name'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Name'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Title'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Title'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Text'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Text'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Display'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Display'); ?>
					</div>
				</div>
				<div id="image_select" class="control-group" style="<?php echo $this->displayImgControl ? 'display:block' : 'display:none'; ?>">
					<div class="control-label">
						<?php echo $this->form->getLabel('image'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('image'); ?>
					</div>
				</div>
				<div id="icon_select" class="control-group"  style="<?php echo $this->displayIconControl ? 'display:block' : 'display:none'; ?>">
					<div class="control-label">
						<?php echo $this->form->getLabel('icon'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('icon'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('catid'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('catid'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('state'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('state'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('Target'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('Target'); ?>
					</div>
				</div>
				<div class="control-group">
					<div class="control-label">
						<?php echo $this->form->getLabel('COM_SMARTICONS_ICON_FIELD_BLANK'); ?>
					</div>
					<div class="controls">
						<?php echo $this->form->getInput('COM_SMARTICONS_ICON_FIELD_BLANK'); ?>
					</div>
				</div>
			</div>
			<div class="tab-pane" id="display">
<?php foreach ($this->form->getFieldset('params') as $field) :?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label; ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
<?php endforeach;?>
			</div>
			<div class="tab-pane" id="advanced">
<?php foreach ($this->form->getFieldset('advanced') as $field) :?>
				<div class="control-group">
					<div class="control-label">
						<?php echo $field->label; ?>
					</div>
					<div class="controls">
						<?php echo $field->input; ?>
					</div>
				</div>
<?php endforeach;?>
			</div>
			<div class="tab-pane" id="permissions">
				<fieldset>
					<?php echo $this->form->getInput('rules'); ?>
				</fieldset>
			</div>
		</div>
		
<?php
//Hidden form fields  
foreach ($this->form->getFieldset('hidden') as $hiddenField) : 
	echo $hiddenField->input;	
endforeach;
echo JHtml::_('form.token');
?>
		<input type="hidden" name="task" value="" />
	</fieldset>
	
</div>
<div class="span2">
	<div>
		<h4 class="nowrap"><?php echo JText::_('COM_SMARTICONS_ICON_GRID_PREVIEW');?></h4>
		<hr />
		<?php echo $this->loadTemplate("button_grid"); ?>
	</div>
	<div style="clear:both">
		<h4 class="nowrap"><?php echo JText::_('COM_SMARTICONS_ICON_LIST_PREVIEW');?></h4>
		<hr />
		<?php echo $this->loadTemplate("button_list"); ?>
	</div>
</div>
</form>