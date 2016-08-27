<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 *
 * @deprecated  3.4 Use default_batch_body and default_batch_footer
 */

defined('_JEXEC') or die;

$published = $this->state->get('filter.published');
?>
<div class="modal-body modal-batch">
	<p><?php echo JText::_('COM_SMARTICONS_BATCH_TIP'); ?></p>
	<div class="row-fluid">
		<?php if ($published >= 0) : ?>
			<div class="control-group span6">
				<div class="controls">
					<?php echo JHtml::_('batch.item', 'com_smarticons'); ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
