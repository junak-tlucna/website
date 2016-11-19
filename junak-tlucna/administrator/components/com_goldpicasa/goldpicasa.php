<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

defined('_JEXEC') or die;

if(!defined('DS')) {
        define('DS',DIRECTORY_SEPARATOR);
}

$version = new JVersion;
$ver = $version->getShortVersion();
$ver = substr($ver,0,strpos($ver,'.'));

if ($ver === '3') {
        define('GOLD_JVERSION', 3);
        class JController extends JControllerLegacy {}
        class JView extends JViewLegacy {}
} elseif ($ver === '2') {
        define('GOLD_JVERSION', 2);
}


jimport('joomla.application.component.controller');
require_once (JPATH_COMPONENT.DS.'controller.php');
$controller     = new goldpicasaController;
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();