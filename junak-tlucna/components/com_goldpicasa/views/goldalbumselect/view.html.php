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
 * HTML View class for albumselect 
 */
class GoldpicasaViewGoldalbumselect extends JView
{
	protected $state;
	protected $item;
    public $compParams;
    public $theme='clasic';

	function display($tpl = null)
	{
		
		$app 		= JFactory::getApplication();
        $menu 		= $app->getMenu();
        $pathway 	= $app->getPathway();
		$menuId 	= JRequest::getInt('Itemid', false);
		$item 		= $menu->getItem($menuId);
		$params 	= $menu->getParams($menuId);
		$this->params=$params->toArray();
		$this->itemId=$menuId;
		$this->goldGalleryIntroText='';
		$this->goldGalleryOutroText='';
		
		$albumSelect = ( isset($this->params['goldGalleryGoldalbumSelect'][5]) ) ? $this->params['goldGalleryGoldalbumSelect'] : false;
		if (!$albumSelect) {		
			return false;
		}
		$this->albums = json_decode( $albumSelect, true );
		$this->albums = $this->albums['albums'];
		$document = JFactory::getDocument();
		//$document->addScript('components/com_goldpicasa/assets/goldGallery.js');
		$document->addStyleSheet('components/com_goldpicasa/assets/goldGallery.css');

		if (isset($this->params['goldGalleryIntroText'][3])) {
			$this->goldGalleryIntroText = '<div class="goldGalleryIntroText">'. ( $this->params['goldGalleryIntroText'] ) . '</div>';
		}
		if (isset($this->params['goldGalleryOutroText'][3])) {
			$this->goldGalleryOutroText = '<div class="goldGalleryOutroText">'. ( $this->params['goldGalleryOutroText'] ) . '</div>';
		}
        $this->compParams = JComponentHelper::getParams('com_goldpicasa');
        //var_dump($this->compParams);
        if ($this->compParams->get('theme') === 'box') {
            $this->theme='box';
        }


		parent::display($tpl);
		return true;
	}
}
