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
defined('_JEXEC') or die ('Restricteted access');

require_once dirname(__FILE__).'/helper.php';
$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::base().'modules/mod_jo_facebookevents_pro/assets/eventon_styles.css');
$doc->addStyleSheet(JURI::base().'modules/mod_jo_facebookevents_pro/assets/eventon_dynamic_styles.css');
$doc->addStyleSheet(JURI::base().'modules/mod_jo_facebookevents_pro/assets/font.css');
$doc->addStyleSheet(JURI::base().'modules/mod_jo_facebookevents_pro/assets/font/font-awesome.css');
$fbevents = modJoFacebookEventsPro::getFacebookEvents($params);
//var_dump($fbevents);
require(JModuleHelper::getLayoutPath('mod_jo_facebookevents_pro'));
?>