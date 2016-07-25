<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

defined('_JEXEC') or die;
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');

?>
<form enctype="multipart/form-data"  action="<?php echo JRoute::_('index.php?option=com_smarticons'); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
	<div class="btn-group" style="padding:10px">
		<a href="#" onclick="Joomla.submitform('import.save', this.form);" class="btn">
		<i class="icon-save"></i> <?php echo JText::_('JSAVE'); ?></a>
		<a href="#" onclick="window.parent.location.href=window.parent.location.href; window.parent.SqueezeBox.close();" class="btn">
		<i class="icon-cancel"></i> <?php echo JText::_('JCANCEL'); ?></a>
	</div>
	<hr />
	<label id="xmlFile-lbl" for="xmlFile" class="hasTip required" title="<?php echo JText::_('COM_SMARTICONS_IMPORT_FIELD_FILEUPLOAD_LABEL') . '::' . JText::_('COM_SMARTICONS_IMPORT_FIELD_FILEUPLOAD_DESC'); ?>"><?php echo JText::_('COM_SMARTICONS_IMPORT_FIELD_FILEUPLOAD_LABEL'); ?></label>
	<input class="input_box" id="xmlFile" name="xmlFile" type="file" size="57" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="view" value="close" />
	<input type="hidden" name="tmpl" value="component" />
	<?php echo JHtml::_('form.token'); ?>
</form>