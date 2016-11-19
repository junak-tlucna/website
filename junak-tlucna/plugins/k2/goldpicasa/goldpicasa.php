<?php
/**
 * @version		2.1
 * @package		Gold Picasa for K2 (K2 plugin)
 * @author    Tom Konopelski - http://www.konopelski.info
 * @copyright	Copyright (c) 2006 - 2013 Tom Konopelski. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Load the K2 plugin API
JLoader::register('K2Plugin', JPATH_ADMINISTRATOR.DS.'components'.DS.'com_k2'.DS.'lib'.DS.'k2plugin.php');

class plgK2goldpicasa extends K2Plugin {
	
	
	var $pluginName 				= 'goldpicasa';
	var $pluginNameHumanReadable 	= 'Gold Picasa for K2';

	function plgK2goldpicasa(&$subject, $params) {
		// Load the plugin language file the proper way
		JPlugin::loadLanguage('com_goldpicasa', JPATH_ADMINISTRATOR);
		parent::__construct($subject, $params);
	}
	

	/**
	 * Show gallery
	 * @param arrray $plugin_array
	 * @return string
	 */
	private function showGallery($plugin_array) {
	
		require_once JPATH_SITE . '/components/com_goldpicasa/helpers/goldpicasa.php';
		$art_attribs_array=array();
		foreach ($plugin_array as $k => $v) {
			$art_attribs_array[ substr($k, 10) ] = $v;
	
		}
		//var_dump($art_attribs_array);
		//die(2222);
		if ( !isset($art_attribs_array['goldGalleryAlbumId'][10]) ) return '';
		$albumAndUser = explode(',', $art_attribs_array['goldGalleryAlbumId']);
		//var_dump($albumAndUser);
		if ( !isset($albumAndUser[1]) || !is_numeric( $albumAndUser[0] ) )
		{
			JError::raiseWarning('com_goldpicasa', 'Album not found');
			return false;
		}
		$p = GoldpicasaHelper::renderAlbum( $art_attribs_array );
		return GoldpicasaHelper::renderPlugin($p, $albumAndUser[0]);
	
	}
	
	
	
	
	function onK2BeforeDisplay(&$item, &$params, $limitstart) {
		if (!isset($item->plugins)) return '';
		$plugin_array = json_decode( $item->plugins, true );
		if ( !is_array($plugin_array) ) return '';
		if ( isset($plugin_array['goldpicasagoldGalleryTopOrBottom']) AND $plugin_array['goldpicasagoldGalleryTopOrBottom']==='top' ) {
			return $this->showGallery($plugin_array);
		}
	}
	
	function onK2AfterDisplay(&$item, &$params, $limitstart) {
		if (!isset($item->plugins)) return '';
		$plugin_array = json_decode( $item->plugins, true );
		if ( !is_array($plugin_array) ) return '';
		if ( isset($plugin_array['goldpicasagoldGalleryTopOrBottom']) AND $plugin_array['goldpicasagoldGalleryTopOrBottom']==='bottom' ) {
			return $this->showGallery($plugin_array);
		}
	}
	
	
	
	
}
