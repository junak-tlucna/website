<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');

class com_goldpicasaInstallerScript {
	
	function postflight( $type, $parent ) {
		
		$this->showInfoMessage($parent, $type);
	}
	function showInfoMessage($parent, $type) {
		
		if ($type==='update') {
			$msg = 'Gold Picasa Gallery now updated to version %s';
		} else {
			$msg = 'Gold Picasa Gallery installed. Version %s';
		}
		echo '<table><tr><td>';
		echo '<img src="'.JURI::root().'/administrator/components/com_goldpicasa/assets/goldpicasa_logo.png" />';
		echo '</td><td>';
		echo '<p>' . JText::sprintf('<h1>'.$msg.'</h1>', $parent->get('manifest')->version) . '</p>';
		echo '</td></tr></table>';
	}
	
}