<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */


// No direct access
defined('_JEXEC') or die;

//error_reporting(E_ALL); ini_set('display_errors', 1);

require_once JPATH_COMPONENT.'/helpers/goldfeed.php';

class GoldpicasaController extends JController
{


	/**
	 * Found or not
	 * @var bool
	 */
	private $found=false;

	public function __construct() {
		parent::__construct();
		$doc = JFactory::getDocument();
		$doc->addStyleDeclaration('.icon-48-goldpicasa {  background: url('.JURI::base().'components/com_goldpicasa/assets/goldpicasa_logo.png) 0 0 no-repeat;}');
		$this->aurl = 'goldpicasagallery.konopelski.info';
		JToolBarHelper::title(JText::_('COM_GOLDPICASA_TITLE_ITEMS'), 'goldpicasa');
		JHTML::_('behavior.tooltip');

		$this->found = GoldfeedHelper::getCustomData();
		//$this->goldfrun();
		
		if (!$this->found) {
			
			$this->adduser();
			return false;
		}

		$this->getSubMenu();
	}


	/**
	 * SUBMENU
	 */
	private function getSubMenu() {

		JSubMenuHelper::addEntry(
		JText::_('COM_GOLDPICASA_ALBUMS'),
			'index.php?option=com_goldpicasa',
			'task' == 'items'
			);

		JSubMenuHelper::addEntry(
		JText::_('COM_GOLDPICASA_USERS'),
			'index.php?option=com_goldpicasa&task=users',
			'task' == 'users'
			);

		JSubMenuHelper::addEntry(
		JText::_('JACTION_COMPONENT_SETTINGS'),
			'index.php?option=com_goldpicasa&task=settings',
			'task' == 'Settings'
			);

		JSubMenuHelper::addEntry(
		JText::_('COM_GOLDPICASA_ABOUT'),
			'index.php?option=com_goldpicasa&task=about',
			'task' == 'About'
			);

	}



	/**
	 * Display
	 * (non-PHPdoc)
	 * @see JController::display()
	 */
	public function display($cachable = false, $urlparams = false) {
		//echo JText::_('JLIB_HTML_NO_RECORDS_FOUND');
		//echo JText::_('JSEARCH_FILTER_SUBMIT');
		//echo JText::_('JCANCEL');
		//echo JText::_('JALL');
		//echo JText::_('JACTION_DELETE');
		
		if (!$this->found) { return false; }

		$view		= JRequest::getCmd('view', 'items');
		JRequest::setVar('view', $view);

		// VIEW
		$document = JFactory::getDocument();
		$viewType  = $document->getType();
		$view = $this->getView($view, $viewType);
		$view->assignRef('users', GoldfeedHelper::$feedData['users'] );
			
		$def = ( isset( GoldfeedHelper::$feedData['default'][2] ) ) ? GoldfeedHelper::$feedData['default'] : false;
			
		if (!$def) {
			if ( !empty(GoldfeedHelper::$feedData['users']) ) {
				foreach (GoldfeedHelper::$feedData['users'] as $k =>  $v) {
					$def = $k;
					break;
				}
			}
		}
		if (  JRequest::getString('function') === 'jSelectGold_com_goldpicasa_universal_form_name' && $modalUserId=JRequest::getVar('picasauserid', false, 'get') ) {
			$def=$modalUserId;
		}
			
		$view->assignRef('default', $def);
		parent::display();
		return $this;
	}



	/**
	 * Add new or override a existing one
	 */
	public function adduser() {

		JToolBarHelper::back();
		//if ( isset($_POST['goldnotfoundfullname'][1]) && JRequest::getInt('goldnotfoundid', 0, 'post') > 3 ) 
		if ( isset($_POST['goldnotfoundfullname'][1]) && isset( $_POST['goldnotfoundid'][1] ) ) 
		{

			$username = JRequest::getVar('goldnotfoundid' );
			$profiname = JRequest::getString('goldnotfoundfullname', $username, 'post');
				
			GoldfeedHelper::addUser( $username, $profiname );
			$r=GoldfeedHelper::updateCustomData();

			$this->setRedirect('index.php?option=com_goldpicasa&task=users', '' . JText::_('COM_GOLDPICASA_ADDEDNEWUSER') . ' ' . $profiname);
			$this->redirect();
			
			return true;
		} 
		JHTML::_('behavior.tooltip');
		$this->isSsl = ( $this->is_ssl() ) ? 's' : '';
		require_once JPATH_COMPONENT.'/helpers/goldnotfoundview.php';
		return false;

	}


	/**
	 * For debug only
	 */
	public function pisasausers() {
		$cd = GoldfeedHelper::getCustomData();
		//var_dump($cd);
		return FALSE;
	}


	/**
	 * USERS public task
	 *
	 *
	 */
	public function users() {
		
		if (!$this->found) return false;

		if ( $cid = JRequest::getVar('cid', false, 'post') ) {

			GoldfeedHelper::deleteUsers($cid);
			$r=GoldfeedHelper::updateCustomData();
			$this->setRedirect('index.php?option=com_goldpicasa&task=users', JText::_('COM_GOLDPICASA_USER_DELETED') );
			return false;
		}

		JToolBarHelper::addNew('adduser', JText::_('COM_GOLDPICASA_ADD_NEW_USER', 'Add new user!!'));
		JToolBarHelper::makeDefault('makeDefault', JText::_('COM_GOLDPICASA_SET_DEFAULT'));

		JToolBarHelper::divider();
		//JToolBarHelper::deleteListX(JText::_('COM_GOLDPICASA_ARE_YOU_SURE'), 'users', JText::_('COM_GOLDPICASA_DELETE_USER'));
		JToolBarHelper::deleteList(JText::_('COM_GOLDPICASA_ARE_YOU_SURE'), 'users', JText::_('COM_GOLDPICASA_DELETE_USER'));
		$cd = GoldfeedHelper::getCustomData();

		require_once JPATH_COMPONENT.'/helpers/goldusersview.php';
		return FALSE;
	}


	/**
	 * Set default
	 */
	public function makeDefault() {
		if ( $cid = JRequest::getVar('cid', false, 'post') ) {
			if ( isset($cid[0][2]) ) {
				GoldfeedHelper::setDefault($cid[0]);
				GoldfeedHelper::updateCustomData();
				$this->setRedirect('index.php?option=com_goldpicasa&task=users', 'Updated' );
			}
		}
	}
	
	/**
	 * About
	 */
	public function about() {
						
		$xml = JPATH_COMPONENT . '/goldpicasa.xml';
		$x = simplexml_load_file($xml);
		$version = (string) $x->version;
		$domain = (string) $x->goldDomain;

        echo '<table><tr><td valign="top" style="width: 500px;">';

		echo '<h1>Gold Picasa Gallery</h1>';
		echo '<div style="margin-left:15px;">';
		echo '<h3>Homepage: <a href="http://goldpicasagallery.konopelski.info" target="_blank">goldpicasagallery.konopelski.info</a></h3>';
		echo '<h3>Extension version: '.$version.'</h3>';
		echo '<h3>Registered domain: <a href="http://'.$domain.'" target="_blank">'.$domain.'</a></h3>';
		
		if (isset( $x->goldTrial )) {
			echo '<h3>Trial end: <a>'. ( (string) $x->goldTrial ) .'</a></h3>';
		}
		
		$pluginStatus = JPluginHelper::isEnabled('content', 'goldpicasa');
		//$pluginStatus=false;
		if ($pluginStatus===true) {
			echo '<h3>Plugin status: <span style="color: green;">Enabled</span></h3>';
		} else {
			echo '<h3>Plugin status: <span style="color: red;">Disabled</span> <small>(<a href="'. JURI::base()  .'index.php?option=com_plugins&filter_search=gold" target="_blank">enable plugin</a>)</small></h3>';
		}
		
		$k2pluginStatus = JPluginHelper::isEnabled('k2', 'goldpicasa');
		if ($k2pluginStatus===true) {
			echo '<h3><a href="http://getk2.org" target="_blank" title="K2, the powerful content extension for Joomla!">K2</a> Plugin status: <span style="color: green;">Enabled</span></h3>';
		} else {
			echo '<h3><a href="http://getk2.org" target="_blank" title="K2, the powerful content extension for Joomla!">K2</a> Plugin status: <span style="color: red;">Disabled</span> <small>(<a href="'. JURI::base()  .'index.php?option=com_plugins&filter_search=gold" target="_blank">enable plugin</a>)</small></h3>';
		}
		
		echo '</td><td valign="top">';
		
		echo '<h4>Check <a href="https://plus.google.com/106611905805476290424/posts" target="_blank">google+ page</a> for updates</h4>';		
		/* 
		*/
		echo '<div class="g-plus" data-width="350" data-href="//plus.google.com/106611905805476290424" data-rel="publisher" style="float:right;"></div>';
		echo "<script type='text/javascript'> (function() { var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;";
		echo "po.src = 'https://apis.google.com/js/plusone.js';";
		echo "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);";
		echo "})();</script>";
		echo '<br />';
		echo '<br />';
		echo file_get_contents(JPATH_COMPONENT.'/assets/donate.html');
		echo '</div>';

        echo '</td></tr></table>';
	
	}
	
	

	public function albumselect() {
		//index.php?option=com_goldpicasa&task=albumselect&tmpl=component
		$users = GoldfeedHelper::$feedData['users'];
		$def = ( isset( GoldfeedHelper::$feedData['default'][2] ) ) ? GoldfeedHelper::$feedData['default'] : false;
		if (!$def) {
			if ( !empty(GoldfeedHelper::$feedData['users']) ) {
				foreach (GoldfeedHelper::$feedData['users'] as $k =>  $v) {
					$def = $k;
					break;
				}
			}
		}
		$this->isSsl = ( $this->is_ssl() ) ? 's' : '';
		require_once JPATH_COMPONENT.'/helpers/albumselect.php';
		return FALSE;
	}
	
	private function is_ssl() {
		//echo __METHOD__;
		//die();
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

	private function goldfrun() {
		$params = JComponentHelper::getParams('com_goldpicasa');
        if ( $params->get('frun', 0) > 1 OR JFactory::getSession()->get('frun', 0) > 1 )
		{
			return true;
		}
		$list=array();
		$xml = JPATH_COMPONENT . '/goldpicasa.xml';
		$x = simplexml_load_file($xml);
		$list['goldVersion'] = (string) $x->version;
		$list['goldDomain'] = (string) $x->goldDomain;
		$list['host']=$_SERVER['HTTP_HOST'];
		$list['type']=1;
		if (isset($x->goldTrial)) {
			$list['goldTrial']=(string) $x->goldTrial;
		}
		if (isset($x->goldOrder)) {
			$list['goldOrder']=(string) $x->goldOrder;
		}
		$list = base64_encode(json_encode($list) );
		if ($_SERVER['HTTP_HOST']==='j25.lan') {
			$url = 'http://j25.lan';
		} else {
			$url = 'http://' . $this->aurl;
		}
		echo '<br /><br /><img src="'.$url.'/installs/logo.gif?gpg='. $list .'" alt="" />';

        $this->setConfig(array('frun'=>2));
        JFactory::getSession()->set('frun', 2);
        return false;


		$params->set('frun', 0);
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->update('#__extensions AS a');
		$query->set('a.params = ' . $db->quote( $params->toString() ));
		$query->where('a.element = "com_goldpicasa"');
		$db->setQuery($query);
		$db->query();
		JFactory::getSession()->set('frun', 2);
	}


    /**
     * Settings view
     *
     */
    public function settings() {

        $data=array();
        if ( isset($_POST['gpgsettings']['theme'][0]) ) {
            //var_dump($_POST);
            $input = JFactory::getApplication()->input;
            $post_array = $input->get('gpgsettings', array(), 'ARRAY');
            //var_dump($post_array);
            $this->setConfig($post_array);
            $this->setRedirect('index.php?option=com_goldpicasa&task=settings', 'Updated' );
            return false;
        }
        JHtml::_('behavior.colorpicker');
		$params = JComponentHelper::getParams('com_goldpicasa');
		//var_dump($params);
        include_once JPATH_COMPONENT . '/helpers/settingsview.php';

		//$this->cleanCache('_system', 1);
		//Only difference is second argument, which tells joomla that we need to clear "admin" side "_system" dir as XYZ's component parameters is being updated!!

	}


    /**
     * Gold Pisaca Config 2014
     *
     *
     *
     * @param $data
     * @return bool
     */
    private function setConfig($data)
	{
		// To access the extensions table we need the id of the component
		$compomentId = JComponentHelper::getComponent('com_goldpicasa')->id;
		//assert($compomentId != 0); // make sure that no error will cause the creation of a new entry in the extenions table
		if (!is_numeric($compomentId)OR  !is_array($data) OR empty($data)) {
			return false;
		}
	
		// set the new value using set()
		$params = JComponentHelper::getParams('com_goldpicasa');
		$params->set('last_save', time());
		foreach ($data as $k => $v) {
			$params->set($k, $v);
		}

        //var_dump( $params->toArray() );
        //return false;

	
		// get an instance of the table class, load the component, overwrite the param-string with the new parameter values
		$table = JTable::getInstance('extension');
		$table->load($compomentId);
		$table->bind(array('params' => $params->toString()));
	
		// check and store with some simple error handling
		if (!$table->check()) {
			$this->setError(__METHOD__ . ' check: '.$table->getError());
			return false;
		}
		if (!$table->store()) {
			$this->setError(__METHOD__ . ' store: '.$table->getError());
			return false;
		}

        // clean cache
        $options = array('defaultgroup' => '_system',);
        $cache = JCache::getInstance('callback', $options);
        $cache->clean();

		return true;
	}
	
}
