<?php
/**
 * @package SmartIcons Component for Joomla! 3.0
 * @version $Id$
 * @author SUTA Bogdan-Ioan
 * @copyright (C) 2011 SUTA Bogdan-Ioan
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla formrule library
jimport('joomla.form.formrule');

class JFormRuleTarget extends JFormRule {
	/**
	 * The regular expression.
	 *
	 * @access      protected
	 * @var         string
	 * @since       1.6
	 */
	protected $regex = '^[a-zA-Z0-9;\/?:@&=+$,-_.!~*\'()]+$';
}