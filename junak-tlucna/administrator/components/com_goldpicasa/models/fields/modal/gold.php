<?php
/**
 * @version     1.0.0
 * @copyright   Copyright (C) 2011 Amy Stephen. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

/**
 * Pojedynczy album
 *
 * @package		Joomla.Administrator
 * @since		1.6
 */
class JFormFieldModal_Gold extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Modal_Gold';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		JHtml::_('behavior.modal', 'a.modal');
		
		$lang = JFactory::getLanguage();
		$lang->load('com_goldpicasa', JPATH_ADMINISTRATOR);

		$formName='com_goldpicasa_universal_form_name';
		$script = array();
		$script[] = '	function jSelectGold_'.$formName.'(id, title, userid, object) {';
		$script[] = '		document.id("'.$formName.'_id").value = id + "," + userid;';
		$script[] = '		document.id("'.$formName.'_name").value = title;';
		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		$html	= array();
		$link	= 'index.php?option=com_goldpicasa&view=items&tmpl=component&function=jSelectGold_'.$formName;

		$customData=$this->getCustomData();
		
		# USER NOT FOUND
		if ( !isset($customData['users']) || empty($customData['users']) ) {

			return JText::_('COM_GOLDPICASA_USERNAME_IS_MISSING');
		}
		
		$html[] = '<script>';
		$html[] = 'var goldGalleryFieldUrl="'.$link.'";';
		
		
		$html[] = 'var COM_GOLDPICASA_ALBUMS="' . JText::_('COM_GOLDPICASA_ALBUMS') . '";';
		$html[] = 'var COM_GOLDPICASA_UPDATED="' . JText::_('COM_GOLDPICASA_UPDATED') . '";';
		$html[] = 'var COM_GOLDPICASA_PUBLISHED="' . JText::_('COM_GOLDPICASA_PUBLISHED') . '";';
		$html[] = 'var COM_GOLDPICASA_IMAGES="' . JText::_('COM_GOLDPICASA_IMAGES') . '";';
		$html[] = 'var COM_GOLDPICASA_USER="' . JText::_('COM_GOLDPICASA_USER') . '";';
		$html[] = 'var COM_GOLDPICASA_ALBUM_NAME="' . JText::_('COM_GOLDPICASA_ALBUM_NAME') . '";';
		
		$html[] = '</script>';
		
		$attribs=array();
		$album_id_value = '';
		if ( isset($this->value[2]) ) {
			$album_id_value = $this->value;
			
			if ( $this->form->getValue('attribs') ) {
				$attribs = $this->form->getValue('attribs')->goldpicasa;
			}
			
			$html[] = '<script type="text/javascript" src="'.JURI::root().'components/com_goldpicasa/assets/goldGallery.js"></script>';
			
		} 
				
		$html[] = '<div id="goldPisacsaAlbumInfo" style="clear:both;"></div><br style="clear:both;">';

		$html[] = '';
		$html[] = '<div class="fltlft">';
		$html[] = '  <input type="text" id="'.$formName.'_name" value="'.$album_id_value.'" disabled="disabled" size="15" />';
		$html[] = '</div>';

		// Select Button
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		$html[] = '	<a class="modal" id="goldPisacsaSelectChangeAlbum" title="'.JText::_('COM_GOLDPICASA_SELECTCHANGE').'" 
				 href="'.$link.'" rel="{handler: \'iframe\', size: {x: (window.innerWidth-100), y: (window.innerHeight-100)}}">'. JText::_('COM_GOLDPICASA_SELECTCHANGE') .'</a>';
		$html[] = '  </div>';
		$html[] = '</div>';

		
		// Remove Button
		$html[] = '<div class="button2-left">';
		$html[] = '  <div class="blank">';
		//$remove='document.id("'.$formName.'_id").value;document.id("goldPisacsaAlbumInfo").innerHTML;';
		$remove='';
		$remove.="document.id('".$formName."_id').value='';document.id('goldPisacsaAlbumInfo').innerHTML='';";
		$remove.="document.id('".$formName."_name').value='';";
		$html[] = '<a id="goldPisacsaSelectChangeAlbum" title="'.JText::_('COM_GOLDPICASA_REMOVE').'"  href="javascript:void(0)" onclick="'.$remove.'">'.JText::_('COM_GOLDPICASA_REMOVE').'</a>';
		
		$html[] = '  </div>';
		$html[] = '</div>';
		
		//return implode("\n", $html);
		
		$html[] = '';

		$html[] = '<script>';
		$html[] = 'window.addEvent("domready", function() {';

		if ($album_id_value) {
			//var_dump($attribs);
			$albumAndUser = explode(',', $album_id_value);
			$urltmp='http://picasaweb.google.com/data/entry/api/user/'. $albumAndUser[1] .'/albumid/'.$albumAndUser[0].'?alt=json&callback=goldPicasaShowAlbumInfoView';
			$html[] = "Element('script', {'src':'". $urltmp ."'}).inject($('goldPisacsaAlbumInfo'));";
		}
		$html[] = '});';
		$html[] = '</script>';

		$class='';
		$html[] = '<input type="hidden" id="'.$formName.'_id"'.$class.' name="'.$this->name.'" value="'.$album_id_value.'" />';

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