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
 * View class for a list of Goldpicasa.
 */
class GoldpicasaViewItems extends JView
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		//die('ddd0');
		$this->modaliframe=false;
		if ( JRequest::getString('function') === 'jSelectGold_com_goldpicasa_universal_form_name' ) {
			// JS modal
			$this->modaliframe=true;
		}
		
		//$this->setLayout('hidden');
		//parent::display($tpl);
		
		if (count($errors = $this->get('Errors'))) {
			JError::raiseError(500, implode("\n", $errors));
			
			//var_dump($errors);
			//die('ErrorsErrorsErrorsErrorsErrorsErrorsErrors');
			
			return false;
		}

		$this->isSsl = ( $this->is_ssl() ) ? 's' : '';
		parent::display($tpl);
	}
	
	/**
	 * Determine if SSL is used.
	 *
	 *
	 * @return bool True if SSL, false if not used.
	 */
	private function is_ssl() {
		if ( isset($_SERVER['HTTPS']) ) {
			if ( 'on' == strtolower($_SERVER['HTTPS']) )
				return true;
			if ( '1' == $_SERVER['HTTPS'] )
				return true;
		} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			return true;
		}
		return false;
	}

}
