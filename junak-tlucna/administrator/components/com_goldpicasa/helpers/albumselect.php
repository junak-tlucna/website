<?php
/**
 * @author 	Tom Konopelski - www.konopelski.info
 * @copyright  	Copyright (C) 2014 goldpicasagallery.konopelski.info. All rights reserved.
 * @license    	GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
?>
<style>
#albumselectAllAlbums {
	border: 1px solid #ccc;
	width: 99%;
	clear: both;
	float: left;
	background: #eee;
	margin-bottom: 5px;
}

#albumselectAllAlbums div.removeAlbum {
	display: none;
}

#albumselectDrop {
	border: 1px solid #ccc;
	min-height: 170px;
	float: left;
	width: 99%;
	margin-bottom: 10px;

}

#albumselectDrop div.removeAlbum {
	display: inline;
	border: 1px solid #CCCCCC;
	margin: 2px;
	padding: 1px;
	text-align: center;
	font-size: 0.9em;
}

.albumselectBox div.filesCount {
	display: inline;
	margin: 2px;
	padding: 1px;
	color: blue;
    font-size: 1.1em;
    font-weight: bold;
}

#albumselectDrop div.removeAlbum:HOVER {
	background: #eee;
}

.albumselectBox {
	border: 1px solid #ccc;
	width: 107px;
	height: 152px;
	margin: 5px;
	float: left;
	/*
	position: relative !important;
	*/
	background-color: #FFF;
	background-position: left top;
	background-repeat: no-repeat;
	border: 1px solid #EEE;
	border-bottom: 2px solid #DDD;
	border-right: 2px solid #DDD;
	cursor: move;
	float: left;
	margin: 10px;
	position: relative;
	padding-left: 3px;
	overflow: hidden;
}

.albumselectBox p.title {
	overflow: hidden;
	white-space: nowrap;
	margin: 1px;
	font-weight: bold;
}

.albumselectBox a.title {
	overflow: hidden;
	white-space: nowrap;
	margin: 1px;
	font-weight: bold;
}

.albumselectBox img  {
margin-bottom: 3px;
}

</style>

<script type="text/javascript" src="components/com_goldpicasa/assets/mooToolsPicasaViewer.js?1"></script>

<?php 
if ( isset($users) && !empty($users) ) {
	?>
	
	<?php echo JText::_('COM_GOLDPICASA_SELECT_USER'); ?>:
	
	<select name="goldGalleryUsernameDropdown" id="goldGalleryUsernameDropdown" onchange="goldGalleryUsername=this.value;getAlbumListAlbumselect(1)" class="goldGalleryBig" >
	
	<?php 	
	foreach ($users as $k => $v) {
		$sel = ( $def && $def == $k) ? ' selected="selected" style="color:red;" ' : '';
		echo '<option value="'.$k.'" '.$sel.' >';
		echo $v;
		echo '</option>';
	}
	echo '';
}
?>
</select>
 
&nbsp;
&nbsp;
<input type="button" value="<?php echo JText::_('COM_GOLDPICASA_DONE'); ?>" onclick="if (window.parent) window.parent.jSelectGold_com_goldpicasa_universal_form_name(getAlbumsFromAlbumselect() )"  />
&nbsp;
&nbsp;
<input type="button" value="<?php echo JText::_('JCANCEL'); ?>" onclick="window.parent.SqueezeBox.close();"  />

<div id="goldGallerySpinner" style="visibility: hidden;">
	<img src="components/com_goldpicasa/assets/img/spinner.gif" style="margin-bottom:-4px;" />&nbsp;&nbsp;Loading...
</div>

<?php echo JText::_('COM_GOLDPICASA_SELECTED_ALBUMS'); ?>:
<br />
<div id="albumselectDrop">
</div>

<br style="clear: both;" />

<?php echo JText::_('COM_GOLDPICASA_ALL_ALBUMS'); ?>:
<br />
<div id="albumselectAllAlbums">

</div>
<br /><br />
<div id="albumselectPager">
</div>

<script type="text/javascript">
var JALL = '<?php echo JText::_('JALL'); ?>';
var JACTION_DELETE = '<?php echo JText::_('JACTION_DELETE'); ?>';
var COM_GOLDPICASA_IMAGES = '<?php echo JText::_('COM_GOLDPICASA_IMAGES'); ?>';
var COM_GOLDPICASA_REMEMBER_SAVE_CHANGES="<?php echo JText::_('COM_GOLDPICASA_REMEMBER_SAVE_CHANGES'); ?>";

<?php 
echo 'var goldpicasaSSL="' . $this->isSsl .'";';
?>

window.addEvent('domready', function() {
	viewSavedAlbumsAlbumselect();
	goldGalleryUsername=$('goldGalleryUsernameDropdown').value;
	getAlbumListAlbumselect(1);
});
</script>