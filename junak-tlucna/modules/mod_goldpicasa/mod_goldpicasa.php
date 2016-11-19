<?php
/**
 * @package		GoldPicasa
 * @subpackage	mod_goldpicasa
 * @copyright	Copyright (C) 2012 - 2013 Tom Konopelski, Inc. All rights reserved.
 * @link 		http://goldpicasagallery.konopelski.info
 * @license		GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

$comHelperFound=false;
$comHelper = JPATH_SITE . '/components/com_goldpicasa/helpers/goldpicasa.php';
if (file_exists($comHelper)) {
	$comHelperFound=true;
	include_once $comHelper;
} else {
	JFactory::getApplication()->enqueueMessage("Gold Picasa Component not found", 'Notice');
}

$goldParams = $params->toArray();
if ($comHelperFound && is_array($goldParams)) modGoldPicasa($goldParams);