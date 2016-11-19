<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
  
// No direct access
defined('_JEXEC') or die;


require_once JPATH_COMPONENT.'/helpers/goldpicasa.php';

class GoldpicasaController extends JController
{

	public function display($cachable = false, $urlparams = false)
    {
    	$safeurlparams = array();
		$safeurlparams['album']='STRING';
		
		if (GOLD_JVERSION === 2) {
    		JHTML::_('behavior.mootools');
		} else {
    		JHtmlBehavior::framework('behavior.mootools'); //J30
		}
		
    	$tmpalbum=JRequest::getVar('album', false); // zrezygnowalem z uzywania GET
    	if ( $tmpalbum && is_numeric($tmpalbum) ) {
    		JRequest::setVar('view', 'goldalbum');
    	} 
    	parent::display($cachable, $safeurlparams);

        return $this;
    }
}
