<?php
/**
 * @author 	Tom Konopelski - www.konopelski.info
 * @copyright  	Copyright (C) 2014 goldpicasagallery.konopelski.info. All rights reserved.
 * @license    	GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
?>
<?php
/**
 * Component helper
 * @author tomek
 * 
 * thumbs: 32, 48, 64, 72, 104, 144, 150, 160
 */
class GoldfeedHelper
{

	public static $feedData=array();
	public static $feedDataFiltered=array();

	/**
	 * Set user
	 * @param string $id
	 * @param string $username
	 */
	public static function addUser($id, $username='unknown') {

		if ( !isset( self::$feedData['users'] ) ) {
			self::$feedData['users']=array();
		}
		self::$feedData['users'][ $id ] = $username;
	}


	/**
	 * Remove users
	 * @param array $users
	 */
	public static function deleteUsers($users) {
		self::getCustomData();

		foreach ($users as $u) {
			if ( isset(self::$feedData['users'][$u]) ) {
				unset(self::$feedData['users'][$u]);
			}
		}
		return true;
	}


	/**
	 * Set default user
	 * @param string $user
	 */
	public static function setDefault($user) {
		self::getCustomData();
		self::$feedData['default'] = $user;
	}




	/**
	 * Set/Get data from DB or cache - WTF ???????
	 * @return bool
	 */
	public static function getCustomData() {

		if ( !empty(self::$feedData) ) {
			return self::$feedData;
		}
			
		$db = JFactory::getDbo();
		$com=JComponentHelper::getComponent('com_goldpicasa');

		if(version_compare(JVERSION,'1.6.0','ge')) {
			// Joomla! 1.6 code here
			$query='SELECT custom_data FROM #__extensions WHERE extension_id=' . (int) $com->id . ' LIMIT 1';
		} else {
			// Joomla! 1.5 code here
			$query='SELECT params FROM #__components WHERE id=' . (int) $com->id . ' LIMIT 1';
		}
		//echo $query;

		$db->setQuery((string)$query);
		$data = $db->loadObject();
		//$data = stripcslashes( $data->custom_data );

		if(!version_compare(JVERSION,'1.6.0','ge')) {
			$data->custom_data = $data->params;
		}

		if ( !isset($data->custom_data[1]) ) {
			self::$feedData=array();
			return false;
		}

		self::$feedData = json_decode( $data->custom_data, true);
		//var_dump(self::$feedData);
		return true;
	}




	/**
	 * Update custom_data with self::$feedData array
	 * @return bool
	 */
	public static function updateCustomData() {

		if ( !self::$feedData=json_encode(self::$feedData) ) {

			echo __METHOD__ . ' JSON FAIL';
			return false;
		}

		$com=JComponentHelper::getComponent('com_goldpicasa');
		$db = JFactory::getDbo();

		if(version_compare(JVERSION,'1.6.0','ge')) {
			// Joomla! 1.6 code here
			$query = 'UPDATE #__extensions SET custom_data = ' . $db->quote( self::$feedData ) . ' WHERE extension_id = ' . (int) $com->id . ' LIMIT 1';
		} else {
			// Joomla! 1.5 code here
			$query = 'UPDATE #__components SET params = ' . $db->quote( self::$feedData ) . ' WHERE id = ' . (int) $com->id . ' LIMIT 1';
		}

		$db->setQuery((string)$query);
		$db->query();
		return false;
	}

}