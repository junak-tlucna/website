<?php
/**
 * @version     1.0.0
 * @copyright   Copyright (C) 2011 Amy Stephen. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

/**
 * Supports a modal gold picker.
 *
 * @package		Joomla.Administrator
 * @since		1.6
*/
class JFormFieldModal_Goldalbumselect extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Modal_Goldalbumselect';


	private $isDebug=false;

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		JHtml::_('behavior.modal', 'a.modal');

		$formName='com_goldpicasa_universal_form_name';
		$script = array();
		$script[] = '	function jSelectGold_'.$formName.'(json) {';
		$script[] = '		document.id("'.$formName.'_id").value = json;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		$html	= array();
		$link	= 'index.php?option=com_goldpicasa&task=albumselect&tmpl=component&function=jSelectGold_'.$formName;
		$customData=$this->getCustomData();

		# USER NOT FOUND
		if ( !isset($customData['users']) || empty($customData['users']) ) {
			return JText::_('COM_GOLDPICASA_USERNAME_IS_MISSING');
		}

		$this->isDebug=true;
		$dateDebug='';
		if ( $this->isDebug ) {
			$dateDebug = '&dateDebug=' .date("YmdHis");
			$link = $link . $dateDebug;
		}

		$html[] = '<script>';
		$html[] = 'var goldGalleryFieldUrl="'.$link.'";';
		//$html[] = 'var COM_GOLDPICASA_REMEMBER_SAVE_CHANGES="' . JText::_('COM_GOLDPICASA_REMEMBER_SAVE_CHANGES') . '";';
		$html[] = '</script>';

		$album_id_value = '';
		$album_count = '';

		if ( isset($this->value[2]) ) {
			$album_id_value = $this->value;
			$album_id_value_json = json_decode( $this->value, true );
			//var_dump( $album_id_value_json );
			if ( is_array($album_id_value_json) ) {
				$album_count = count($album_id_value_json['albums']);
			}
			$html[] = '<script type="text/javascript" src="'.JURI::root().'/administrator/components/com_goldpicasa/assets/mooToolsPicasaViewer.js"></script>';
		}

		$html[] = '<div id="goldPisacsaAlbumInfo" style="clear:both;"></div><br style="clear:both;">';

		$html[] = '';
		$html[] = '<div class="fltlft">';
		$html[] = '  <input type="text" id="'.$formName.'_name" value="'.$album_count.' ' . JText::_('COM_GOLDPICASA_ALBUMS') .'" disabled="disabled" size="15" />';
		$html[] = '</div>';

		// Select Button
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '	<a onclick="SqueezeBox.open(\''.$link.'\', {handler: \'iframe\', size: {x: (window.innerWidth-100), y: (window.innerHeight-100)}});" id="goldPisacsaSelectChangeAlbum" title="'.JText::_('COM_GOLDPICASA_CREATENEW').'" >'. JText::_('COM_GOLDPICASA_SELECTCHANGE') .'</a>';
		$html[] = '  </div>';
		$html[] = '</div>';

		// Remove Button
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$remove='';
		$remove.="document.id('".$formName."_id').value='';document.id('goldPisacsaAlbumInfo').innerHTML='';";
		$remove.="document.id('".$formName."_name').value='';";
		$remove.=" rememberToSaveAlbumselect();";
		$html[] = '<a id="goldPisacsaSelectChangeAlbum" title="'.JText::_('COM_GOLDPICASA_REMOVE').'"  href="javascript:void(0)" onclick="'.$remove.'">'.JText::_('COM_GOLDPICASA_REMOVE').'</a>';

		$html[] = '  </div>';
		$html[] = '</div>';

		$html[] = '';
		$html[] = '<br style="clear:both;" />';

		//var_dump($album_id_value_json);
		if ( isset($album_id_value[4]) && is_array($album_id_value_json) && isset($album_id_value_json['albums']) ) {
			$html[] = '<div id="goldPisacsaSelectAlbumselectDiv">';
			foreach ($album_id_value_json['albums'] as $albums) {
				$hTitle= '<i>' . $albums['userName'] . '</i><br />' . $albums['title'] . '<br /><img src='. $albums['thumb'] .' />' ;
				$hUrl='https://plus.google.com/photos/' . $albums['userId'] . '/albums/' . $albums['id'];
				$html[] = '<div class="goldPisacsaHasTip" title="'.$hTitle.'" style="float:left;width:52px;border:1px solid #ccc;margin:0 4px 4px 0;padding-left:2px;padding-top:2px;background: #EEEEEE;">';
				$html[] = '<p style="overflow: hidden; white-space: nowrap;margin-bottom:1px;font-size:0.8em;"><b style="color:#FB4900;">' . $albums['userName'] . '</b><br />' . $albums['title'] . '</p>';
				$html[] = '<a href="'.$hUrl.'" target="_blank"><img src="'. $albums['thumb'] .'" style="margin-bottom:2px;width:50px" width="50" /></a>';
				$html[] = '</div>';
			}
			$html[] = '</div>';
			$html[] = '<script>';
			$html[] = "var goldPisacsaJTooltips = new Tips($$('.goldPisacsaHasTip'), { maxTitleChars: 50, fixed: false});";
			$html[] = '</script>';
				
		}

		$class='';
		$html[] = '<input type="hidden" id="'.$formName.'_id"'.$class.' name="'.$this->name.'" value=\''.$album_id_value.'\' />';

		return implode("\n", $html);
	}


	/**
	 * Get config
	 * @return bool
	 */
	private function getCustomData() {

		$db = JFactory::getDbo();
		$com=JComponentHelper::getComponent('com_goldpicasa');
		$query=$db->getQuery(true);
		$query->select('custom_data');
		$query->from('#__extensions');
		$query->where('extension_id = ' . $com->id );
		$db->setQuery((string)$query, 0, 1);
		$data = $db->loadObject();
		//$data = stripcslashes( $data->custom_data );
		if ( !isset($data->custom_data[1]) ) return false;
		return json_decode( $data->custom_data, true);
	}


}