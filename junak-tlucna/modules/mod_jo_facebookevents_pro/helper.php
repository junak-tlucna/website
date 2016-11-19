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
defined('_JEXEC') or die ('Restricted access');
class modJoFacebookEventsPro {
	function getFacebookEvents($params){
		$fb_accesstoken = trim($params->get('access_token'));
		$facebook_page_id =  trim($params->get('account_id'));
		
		if(!empty($fb_accesstoken)){
			$token_url = "https://graph.facebook.com/".$facebook_page_id."/events?access_token=".$fb_accesstoken."&expires_in=0&limit=100";
			$token_content =  json_decode(modJoFacebookEventsPro::file_get_contents_curl($token_url),true);
			//$token_content =  json_decode(file_get_contents($token_url),true);
		}
		return @$token_content;
	}
	
	function detail_event($params, $id_events){
		$fb_accesstoken = trim($params->get('access_token'));
		$token_url = "https://graph.facebook.com/".$id_events."?access_token=".$fb_accesstoken."&expires_in=0";
		$token_content =  json_decode(modJoFacebookEventsPro::file_get_contents_curl($token_url),true);
		//$token_content =  json_decode(file_get_contents($token_url),true);
		return @$token_content;
	}
	
	function CoverEvent($params, $id_event){
		$fb_accesstoken = trim($params->get('access_token'));
		$events_photo = "https://graph.facebook.com/v2.0/".$id_event."?fields=cover&access_token=".$fb_accesstoken."&expires_in=0";
		$token_content =  json_decode(modJoFacebookEventsPro::file_get_contents_curl($events_photo),true);		
		return @$token_content;
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
		
}
?>
