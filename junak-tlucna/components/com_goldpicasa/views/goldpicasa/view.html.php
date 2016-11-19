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
class GoldpicasaViewGoldpicasa extends JView
{
	function display($tpl = null)
	{
		if ( JRequest::getVar('album', false, 'get') ) {
			$this->album();
			return true;
		}
		$app		= JFactory::getApplication();
		$params		= $app->getParams();
		$params=$params->toArray();
		$this->goldGalleryIntroText='';
		$this->goldGalleryOutroText='';
		
		$this->jsparams = GoldpicasaHelper::renderAlbums( $params );
		if (!$this->jsparams) return false; 

		if (isset($params['goldGalleryIntroText'][3])) {
			$this->goldGalleryIntroText = '<div class="goldGalleryIntroText">'. ( $params['goldGalleryIntroText'] ) . '</div>';
		}
		if (isset($params['goldGalleryOutroText'][3])) {
			$this->goldGalleryOutroText = '<div class="goldGalleryOutroText">'. ( $params['goldGalleryOutroText'] ) . '</div>';
		}

		parent::display();
		return true;
		
	}
	
	
	public  function album() {
		if (!$albumId=JRequest::getVar('album', false, 'get') ) {
			return '';
		}
		$app		= JFactory::getApplication();
		$params		= $app->getParams();
		$params=$params->toArray();
		$params['goldGalleryAlbumId']=$albumId . ','.$params['goldGalleryUserId'];
		//var_dump($params);
		$this->jsparams = GoldpicasaHelper::renderAlbum( $params );
		if (!$this->jsparams) return false; 
		
		parent::display();
		return true;
	}
	
}
