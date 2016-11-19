<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */


// no direct access
defined('_JEXEC') or die;

JHTML::_('behavior.tooltip');


if(version_compare(JVERSION,'1.6.0','ge')) {
	// Joomla! 1.6
	JHTML::_('script','system/multiselect.js',false,true);			
} else {
	// Joomla! 1.5
}

//var_dump($this->isSsl);
?>


<script src="<?php echo JURI::root(); ?>components/com_goldpicasa/assets/slimbox18/slimbox_19.js" type="text/javascript"></script>
<link rel="stylesheet" href="<?php echo JURI::root(); ?>components/com_goldpicasa/assets/slimbox18/css/slimbox.css" type="text/css" />



<style>
#goldGalleryUsernameDropdown {
	background: #D5EEFF;
}
.goldGalleryBig {
	font-size: 1.2em;
}
.goldGalleryInfoTable  {
	border-collapse: separate;
	border-spacing: 5px;
}
.goldGalleryInfoTable td {
	background: #fff;
	padding: 4px 6px 4px 6px;
	border: 1px solid #E0E0E0;
}

#goldGalleryPager input {

}

ul.goldGalleryImagesUl li {
  float:left;
  
  width: 144px;
  height: 150px; 
  list-style-type:none;
  /*
  margin-left:1em;
  margin-bottom:2em;
  border: 1px solid #ccc;
   */
   margin-top:4px;
   margin-left:6px;
  margin-bottom:6px;
  padding-bottom:20px;

}


ul.goldGalleryImagesUl li:HOVER {
  background: #CECECE;

}


.goldGalleryImgPanel {
	margin-top:1px;
	white-space: nowrap;
	overflow: hidden;
	border-left: 1px solid #CCCCCC;
	border-bottom: 1px solid #CCCCCC;
	
}


.goldGalleryImgPanel input {
	background: #fff;
	margin-bottom: 1px;
	margin-left: 2px;
	border: 0px;
	border: 1px solid #ccc;
}
.goldGalleryImgPanel input:HOVER {
	background: #A0A0FF;
	border: 1px solid #000;
}

ul.goldGalleryImagesUl li a  img {
/*
	box-shadow: 2px 2px 2px #888888;
*/
	border: 1px solid #888;
}


.goldGalleryImagesUl {

  padding-left: 6px;
}

.goldpicasaBrowseButton {
	
	cursor: pointer; 
}
.goldpicasaBrowseButton:HOVER {
	 background: #CECECE;
}

table.adminlist tbody tr td.goldPicasaNoPadding {
padding: 0;
}


</style>

<ul class="goldGalleryImagesUl" style="display: none;">
<li>
<a href="#">
fsdfsdfds
</a>
</li>
<li>
<a href="#">
543543543
</a>
</li>
</ul>

<script>
<?php 
echo 'var goldGalleryUsername="'.$this->default.'";'; 
echo 'var goldpicasaSSL="' . $this->isSsl .'";';

if ($this->modaliframe===true) {
	echo 'var modaliframe=true;';
} else {
	echo 'var modaliframe=false;';	
}
echo 'var COM_GOLDPICASA_SHOW_ON_PICASA="' . JText::_('COM_GOLDPICASA_SHOW_ON_PICASA') . '";';
echo 'var COM_GOLDPICASA_ALBUMS="' . JText::_('COM_GOLDPICASA_ALBUMS') . '";';
echo 'var COM_GOLDPICASA_UPDATED="' . JText::_('COM_GOLDPICASA_UPDATED') . '";';
echo 'var COM_GOLDPICASA_BROWSE="' . JText::_('COM_GOLDPICASA_BROWSE') . '";';
echo 'var COM_GOLDPICASA_IMAGES="' . JText::_('COM_GOLDPICASA_IMAGES') . '";';

// 
?>
</script>

<table border="0" class="goldGalleryInfoTable" width="100%">
<tr>




<td valign="top" width="2%">
<?php 
if ( isset($this->users) && !empty($this->users) ) {
	?>
	
	
	
	
	<div style="font-size:1.2em;margin-bottom:4px;padding:2px;"><?php echo JText::_('COM_GOLDPICASA_SELECT_USER'); ?>:</div> 
	
	<select name="goldGalleryUsernameDropdown" id="goldGalleryUsernameDropdown" onchange="document.getElementById('goldPicasaTabImagesImageinfo').style.display='none'; this.value;goldGalleryUsername=this.value;getAlbumList(1);" class="goldGalleryBig" >
	
	<?php 	

	$maxL=50;
	foreach ($this->users as $k => $v) {
		$sel = ( $this->default && $this->default == $k) ? ' selected="selected" style="color:red;" ' : '';
		echo '<option value="'.$k.'" '.$sel.' >';
		if (strlen($v) > $maxL) {
			echo substr( $v, 0, $maxL ) . '...';
		} else {
			echo $v;
		}
		
		echo '</option>';
	
	}
	echo '';
}
?>
</select>
</td>

<td valign="top">

		<div id="goldPicasaInfoDivNewUser">
		loading...
		</div>
</td>



	

</tr>
</table>


<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_goldpicasa/assets/mooToolsPicasaViewer.js"></script>



<div id="goldGallerySpinner" style="visibility: hidden;">
	<img src="components/com_goldpicasa/assets/img/spinner.gif" style="margin-bottom:-4px;" />&nbsp;&nbsp;Loading...
</div>



<div id="goldPicasaTabAlbums">


<table class="adminlist table table-striped" id="goldPicasaMainTable" style="border-top:1px solid #D5D5D5;border-bottom:1px solid #D5D5D5;width:99%;">
	<thead>
		<tr>
		
			<th width="1%" title="<?php echo JText::_('COM_GOLDPICASA_LINK_TO_PICASA'); ?>">Url</th>
			<th width="1%"><?php echo JText::_('COM_GOLDPICASA_IMAGE'); ?></th>
			<th width="1%">&nbsp;</th>
			<th ><?php echo JText::_('COM_GOLDPICASA_ALBUM_NAME'); ?></th>
			<th width="1%"><?php echo JText::_('COM_GOLDPICASA_PUBLISHED'); ?></th>
			<th width="1%"><?php echo JText::_('COM_GOLDPICASA_UPDATED'); ?></th>
		</tr>
	</thead>
	
	<tbody id="goldPicasaMainTableTbody">
		
	</tbody>
</table>



<table>
<tr>
<td style="padding-right: 10px;">
	<div id="goldGalleryPager" ></div>
</td>




<td >
<!-- 
<?php echo JText::_('COM_GOLDPICASA_DISPLAY'); ?> # 
	<select id="goldGallerylimitBox" name="goldGallerylimitBox" class="inputbox" size="1" onchange="maxResult=this.value;getAlbumList(1)" >
		<option value="5">5</option>
		<option value="10">10</option>
		<option value="15">15</option>
		<option value="20" selected="selected">20</option>
		<option value="25">25</option>
		<option value="30">30</option>
		<option value="50">50</option>
		<option value="100">100</option>
	</select>
-->
</td>
</tr>
</table>

</div>


<div id="goldPicasaTabImages">


</div>



<br style="clear: both;" />

<div id="goldPicasaTabImagesPager" style="float: left;">
</div>

<div id="goldPicasaTabImagesLimitBox" style="float: left;display:none;">
&nbsp;&nbsp;&nbsp;&nbsp;
<?php echo JText::_('COM_GOLDPICASA_DISPLAY'); ?> # 
	<select id="goldGallerylimitBox" name="goldGallerylimitBox" class="inputbox" size="1" onchange="goldpicasa.maxResults=this.value;getImages(1);" style="display: inline;">
		<option value="5">5</option>
		<option value="10">10</option>
		<option value="15">15</option>
		<option value="20" selected="selected">20</option>
		<option value="25">25</option>
		<option value="30">30</option>
		<option value="50">50</option>
		<option value="100">100</option>
	</select>
</div>






<div id="goldPicasaTabImagesImageinfo" style="display: none;">



<span id="goldPicasaTabImagesImageinfoHeader">
</span>


<h3 style="display: inline;">H3</h3>
<br />
<br />


<table>

<tr>

<td valign="top">
<img id="gptii_thumb" src="http://j25.lan/administrator/components/com_goldpicasa/assets/goldpicasa_logo.png">
</td>

<td valign="top" style="padding-left:15px;">
<p class="gptii_dscr">
</p>

<p>
Thumb:
<select id="gptii_imgSizeThumb">
</select>
&nbsp;&nbsp;|&nbsp;

Full-size: 
<select id="gptii_imgSize">
</select>
&nbsp;&nbsp;|&nbsp;

<span title="Open in new window (tab)"> 
new window <input type="checkbox" name="gptii_targetBlank" id="gptii_targetBlank" checked="checked" /> 
</span>
&nbsp;&nbsp;|&nbsp;

Class: 
<input type="text" name="gptii_class" id="gptii_class" value="modal" />
&nbsp;&nbsp;|&nbsp;

Rel: 
<input type="text" name="gptii_rel" id="gptii_rel" />
<br >

Thumbail with fullszie image link <input type="radio" name="gptii_htmltype" value="1" checked="checked">
&nbsp;&nbsp;&nbsp;&nbsp;
Fullszie image only <input type="radio" name="gptii_htmltype" value="2">
<br />

</p>



<input type="button" value="Generate" onclick="return generateHtmlImage()" style="width: 500px;margin: 10px 20px;" />

<br />
<textarea rows="3" cols="80" name="gptii_textarea" id="gptii_textarea"></textarea>

</td>

</tr>

</table>


<fieldset class="adminform">
<label>Preview</label>
<div id="gptii_preview">

</div>
</fieldset>

</div>




<?php 

if ($this->modaliframe===true) {
	echo '<script>window.addEvent("domready", function() {getAlbumList(1);});</script>';
	
} else {
	echo '<script>window.addEvent("domready", function() {getAlbumList(1);});</script>';
}
?>

<div id="scriptEmbed">

</div>