<?php
/**
 * @version     1.0.0
 * @copyright   Copyright (C) 2011 Amy Stephen. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.form.formfield');

/**
 * Lista userow - lista albumow
 *
 * @package		Joomla.Administrator
 * @since		1.6
 */
class JFormFieldModal_Album extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Modal_Album';

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
		//echo $formName;
		//var_dump($this);

		$script = array();
		$script[] = '	function jSelectGold_'.$formName.'(id, title, userid, object) {';
		$script[] = '		document.id("'.$formName.'_id").value = id + "," + userid;';
		$script[] = '		document.id("'.$formName.'_name").value = title;';

		$script[] = '		SqueezeBox.close();';
		$script[] = '	}';

		// Add the script to the document head.
		JFactory::getDocument()->addScriptDeclaration(implode("\n", $script));

		$html	= array();
		$link	= 'index.php?option=com_goldpicasa&view=items&tmpl=component&function=jSelectGold_'.$formName;

		$customData=$this->getCustomData();

		if ( !isset($customData['users']) || empty($customData['users']) ) {

			//var_dump($customData);
			$msg = '<div style="float:left;background-image: url(templates/bluestork/images/notice-note.png);background-repeat: no-repeat;padding-left:35px;">';
			$msg .= 'Component not configured.<br>Username is missing!';
			$msg .= '<h4 style="margin-top:2px;"><a href="index.php?option=com_goldpicasa" target="_blank">Add Picasa username...</a></h4>';
			$msg .= '</div>';
			return $msg;
		}


		$html[] = '<script>';
		$html[] = 'var goldGalleryFieldUrl="'.$link.'";';
		$html[] = '</script>';

		
		
		
		$attribs=array();
		$album_id_value = '';
		if ( isset($this->value[2]) ) {
			$album_id_value = $this->value;

			if ( $this->form->getValue('attribs') ) {
				$attribs = $this->form->getValue('attribs')->goldpicasa;
			}
			$html[] = '<script type="text/javascript" src="/components/com_goldpicasa/assets/goldGallery.js"></script>';
		} 
		
		$onchange = "document.getElementById('jform_attribs_goldpicasa_goldGalleryUserId').value=this.value;";
		$onchange .= "$('goldPisacsaSelectChangeAlbum').set('href', goldGalleryFieldUrl + '&picasauserid=' + this.value);";
		
		$onchange = "document.getElementById('".$formName."_id').value=this.value;";
		
		$html[] = '<select name="goldGalleryFieldSel" id="goldGalleryFieldSel"  onchange="'.$onchange.'">';
		
		$html[] = '<option>- Select user -</option>';
		$maxLen=45;
		foreach ($customData['users'] as $k => $v) {
			$sel = ( $album_id_value === $k ) ? ' selected="selected" ' : '';
			$html[] = '<option value="'.$k.'" '.$sel.'>';
			
			if (strlen($v)>50)			
			$html[] = substr($v, 0, $maxLen). '...';
			else
			$html[] = $v;

			$html[] = '</option>';
		}
		$html[] = '</select>';
		$html[] = '';

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