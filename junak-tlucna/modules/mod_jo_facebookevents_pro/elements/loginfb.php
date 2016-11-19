<?php
/*------------------------------------------------------------------------
# mod_jo_facebookevents_pro - JO Facebook Events Pro for Joomla 1.6, 1.7, 2.5, 3.x Module
# -----------------------------------------------------------------------
# author: http://www.joomcore.com
# copyright Copyright (C) 2011 Joomcore.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomcore.com
# Technical Support:  Forum - http://www.joomcore.com/Support
-------------------------------------------------------------------------*/
// no direct access
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.form.formfield');

class JFormFieldloginfb extends JFormField
{
	protected $type = 'loginfb';

	protected function getInput()
	{
		if(class_exists('Facebook') != true){
			require_once (JPATH_ROOT.'/modules/mod_jo_facebookevents_pro/assets/facebook.php');
		}
		$db=&JFactory::getDBO();
		$ex_mod_id = JRequest::getVar('id');
		if($ex_mod_id !=''){
			$query = 'SELECT * FROM #__modules WHERE id = '.$ex_mod_id;
			$db->setQuery($query);
			$item = $db->loadObject();
		}		
		$moduleParams	= new JRegistry($item->params);

		$appId = $moduleParams->get('app_id');
	      	$appSecret=  $moduleParams->get('secret');
	    
	   	$qfacebook = new Facebook(array(
		  'appId'  => $appId,
		  'secret' => $appSecret,
		));
	
		$user = $qfacebook->getUser();
	
		// Login or logout url will be needed depending on current user state.
		if ($user) {
		  $logoutUrl = $qfacebook->getLogoutUrl();
		} else {
		  $loginUrl = $qfacebook->getLoginUrl();
		}
		
		$user_id_name = 'fb_'.$appId.'_user_id';
		if(!empty($_SESSION[$user_id_name])){
			$user_id = @$_SESSION[$user_id_name];
		} else {
			$user_id = $moduleParams->get('user_id');
		}
		
		
		$html = '<fieldset style="display: inline; margin-left: 145px; padding: 0px;">';
		
		if (!function_exists('curl_init')) {
  			$html .= '<p style="font:red">ERROR: Facebook needs the CURL PHP extension!</p>';
		}
		if (!function_exists('json_decode')) {
  			$html .= '<p style="color:red">ERROR: Facebook needs the JSON PHP extension!</p>';
		}
		$html .= '
			You need Enabled module and Apply or Save information AppID and Secret before Login Facebook
			<script type="text/javascript">
			function onClick(href)
			{
				appid = "'.$appId.'";
				appsecret = "'.$appSecret.'";
				if(appid != "" && appsecret != ""){
					return true;
				} else {
					alert("You need Enabled module and Apply or Save information AppID and Secret before Login Facebook");
					return false;
				}
			}
			</script>
			
				<table border="0" cellspacing="3" cellpadding="0">
				  <tr>
				    <td><a href="'.@$loginUrl.'" onclick="return onClick(href)"><img src="../modules/mod_jo_facebookevents_pro/assets/loginfb.png"/></a></td>
				    <td rowspan="2"> <img src="http://graph.facebook.com/'.$user_id.'/picture" alt=""></td>
				  </tr>
				  <tr>
				    <td><span style="display: block;">Id:</span><input type="text" size="33" class="text_area" value="'.$user_id.'"  name="jform[params][user_id]"></td>
				  </tr>
				</table></fieldset >';
		return $html;
	}
}

class JFormFieldaccesstoken extends JFormField
{
	protected $type = 'accesstoken';

	protected function getInput()
	{
		$db=&JFactory::getDBO();
		$ex_mod_id = JRequest::getVar('id');
		if($ex_mod_id !=''){
			$query = 'SELECT * FROM #__modules WHERE id = '.$ex_mod_id;
			$db->setQuery($query);
			$item = $db->loadObject();
		}
		$moduleParams	= new JRegistry($item->params);
		
		$appId = $moduleParams->get('app_id');
		$appSecret=  $moduleParams->get('secret');
		$access_name = 'fb_'.$appId.'_access_token';
		if(!empty($_SESSION[$access_name])){
			$accesstoken = @$_SESSION[$access_name];
		} else {
			$accesstoken = $moduleParams->get('access_token');
		}
		$htmlaccesstoken = '<input type="text" size="60" maxlength="255" class="text_area" value="'.$accesstoken.'" name="jform[params][access_token]">';
		return $htmlaccesstoken;
	}
	
}


class JFormFieldaccountpage extends JFormField
{
	protected $type = 'accountpage';

	protected function getInput()
	{
		$db=&JFactory::getDBO();
		$ex_mod_id = JRequest::getVar('id');
		if($ex_mod_id !=''){
			$query = 'SELECT * FROM #__modules WHERE id = '.$ex_mod_id;
			$db->setQuery($query);
			$item = $db->loadObject();
		}
		$moduleParams	= new JRegistry($item->params);
		
		$appId = $moduleParams->get('app_id');
		$appSecret=  $moduleParams->get('secret');
		
		$user_id_name = 'fb_'.$appId.'_user_id';
		$access_name = 'fb_'.$appId.'_access_token';
		
		
		if(!empty($_SESSION[$user_id_name])){
			$user_id = @$_SESSION[$user_id_name];
		} else {
			$user_id = $moduleParams->get('user_id');
		}
		
		
		if(!empty($_SESSION[$access_name])){
			$access_token = @$_SESSION[$access_name];
		} else {
			$access_token = $moduleParams->get('access_token');
		}
		
		$groupPage = $this->getGroup($access_token);
		//var_dump($groupPage);
		$pagesToken = $this->getAccountpage($access_token);
		$lookup = $moduleParams->get('account_id');
		if(!empty($user_id)){
			$id_profile = array('name'=>'Facebook Personal page', 'id'=>$user_id, 'category'=>'Personal page');
			if(!empty($pagesToken['data'])){
				$pagesToken['data'] = array_merge($pagesToken['data'] ,array($id_profile));
			}else{
				$pagesToken['data'] = array($id_profile);
			}
			if(!empty($groupPage['data'])){
				$pagesToken['data'] = array_merge($pagesToken['data'] ,$groupPage['data']);
			}
			$options = array();
			foreach(@$pagesToken['data'] as $option_page){
					if($option_page['category'] == ''){
						$option_page['category'] = 'Group';
					}
					$options[] = JHTML::_('select.option', $option_page['id'], $option_page['name'].' - ['.$option_page['category'].']', 'access_token', 'name');
			}
			$html = JHTML::_('select.genericlist',  $options, 'jform[params][account_id]', 'class="inputbox" style="width:235px;" size="1"', 'access_token', 'name', $lookup);
		}	
		return @$html;
	}
	
	function file_get_contents_curl($url) {
		$ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	    curl_setopt($ch, CURLOPT_HEADER, false);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_REFERER, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	    $result = curl_exec($ch);
	    curl_close($ch);
	    return $result;
	}
	function getAccountpage($access_token){
		if(!empty($access_token)){
			$token_url = "https://graph.facebook.com/me/accounts?access_token=".$access_token."&expires_in=0";
			$token_content =  json_decode($this->file_get_contents_curl($token_url),true);
			//$token_content =  json_decode(file_get_contents($token_url),true);
		}
		return @$token_content;
	}
	
	function getGroup($access_token){
		if(!empty($access_token)){
			$token_url = "https://graph.facebook.com/me/groups?access_token=".$access_token."&expires_in=0";
			$token_content =  json_decode($this->file_get_contents_curl($token_url),true);
			//$token_content =  json_decode(file_get_contents($token_url),true);
		}
		return @$token_content;
	}
}



