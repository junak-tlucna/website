<?php
/*------------------------------------------------------------------------
# mod_jo_facebookevents_pro - JO Facebook Events Pro for Joomla 1.6, 1.7, 2.5, 3.x Module
# -----------------------------------------------------------------------
# author: http://www.joomcore.com
# copyright Copyright (C) 2011 Joomcore.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomcore.com
# Technical Support:  Forum - http://www.joomcore.com/Support
-------------------------------------------------------------------------*/

// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.form.formfield');

class JFormFieldcolor extends JFormField
{
	protected $type = 'color';

	protected function getInput()
	{
		//var_dump($this->name);
		$jspath=JUri::root()."modules/mod_jo_facebookevents_pro/assets/jscolor.js";				
		$document = &JFactory::getDocument();
		$document->addScript($jspath);
		$html = '<input type="text" size="20" class="color" value="'.$this->value.'" id="jform_params_'.$this->name.'" name="'.$this->name.'">';
		return $html;
	}
}
