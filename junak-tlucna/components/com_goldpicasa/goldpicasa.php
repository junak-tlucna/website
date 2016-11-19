<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @author		Tomasz Konopelski
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

if(!defined('DS')) {
        define('DS',DIRECTORY_SEPARATOR);
}
jimport('joomla.application.component.controller');

$version = new JVersion;
$ver = $version->getShortVersion();
$ver = substr($ver,0,strpos($ver,'.'));

if ($ver === '3') {
        define('GOLD_JVERSION', 3);
        class JController extends JControllerLegacy {}
        class JView extends JViewLegacy {}
		//class JModel extends JModelLegacy {}
		
} elseif ($ver === '2') {
        define('GOLD_JVERSION', 2);
}

$controller	= JController::getInstance('Goldpicasa');
$controller->execute(JRequest::getVar('task',''));
$controller->redirect();
