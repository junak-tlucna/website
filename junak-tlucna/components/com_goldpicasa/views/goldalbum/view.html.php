<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * HTML View class for the Goldpicasa component
 */
class GoldpicasaViewGoldalbum extends JView
{
	protected $state;
	protected $item;

	function display($tpl = null)
	{
		$app 		= JFactory::getApplication();
        $menu 		= $app->getMenu();
        $pathway 	= $app->getPathway();
		$menuId 	= JRequest::getInt('Itemid', false);
		$item 		= $menu->getItem($menuId);
		$params 	= $menu->getParams($menuId);
		$params=$params->toArray();
		$this->goldGalleryIntroText='';
		$this->goldGalleryOutroText='';
		
		// parametr z geta z userid
		if ( $album=JRequest::getVar('userId', false, 'get') ) {
			$params['goldGalleryUserId'] =  $album;
		}
		// album id
		if ( $album=JRequest::getVar('album', false) ) // zrezygnowalem z uzywania GET
		{
			$this->albumId=$album;
			$params['goldGalleryAlbumId'] =  $album.','.$params['goldGalleryUserId'];
		} else {
			$a=explode(',', $params['goldGalleryAlbumId']);
			$this->albumId=$a[0];
			# INTRO/OUTRO
			if (isset($params['goldGalleryIntroText'][3])) {
				$this->goldGalleryIntroText = '<div class="goldGalleryIntroText">'. ( $params['goldGalleryIntroText'] ) . '</div>';
			}
			if (isset($params['goldGalleryOutroText'][3])) {
				$this->goldGalleryOutroText = '<div class="goldGalleryOutroText">'. ( $params['goldGalleryOutroText'] ) . '</div>';
			}
		}
		
		$this->jsparams = GoldpicasaHelper::renderAlbum( $params );
		if (!$this->jsparams) return false; 
		
		parent::display($tpl);
		return true;
	}
}
