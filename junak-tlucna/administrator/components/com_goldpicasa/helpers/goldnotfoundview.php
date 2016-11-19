<?php
/**
 * @author 	Tom Konopelski - www.konopelski.info
 * @copyright  	Copyright (C) 2014 goldpicasagallery.konopelski.info. All rights reserved.
 * @license    	GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
?>
<style>
.image-container {
	display: inline;
    float: left;
    padding: 4px;
}
.goldnotfoundform input {
	font-size: 1.4em;
}
.goldnotfoundform fieldset {
	background: #fff;
	width: 700px;
}
</style>
<script>
var JLIB_HTML_NO_RECORDS_FOUND='<?php echo JText::_('JLIB_HTML_NO_RECORDS_FOUND'); ?>';
var COM_GOLDPICASA_CHECKING='<?php echo JText::_('COM_GOLDPICASA_CHECKING'); ?>';
<?php 
echo 'var goldpicasaSSL="' . $this->isSsl .'";';
?>
</script>

<form class="goldnotfoundform" action="<?php echo JRoute::_('index.php?option=com_goldpicasa&task=users'); ?>" method="post">
<fieldset class="adminform" id="fieldsetSearch" >
<legend><?php echo JText::_('COM_GOLDPICASA_FIND_PROFILE');  ?></legend>
<table border="0" width="99%">
<tr>
<td nowrap="nowrap">
<?php echo JText::_('COM_GOLDPICASA_FIND_PROFILE_URL');  ?>
	&nbsp;&nbsp;
</td>
<td nowrap="nowrap">
	
	<input type="text" name="goldnotfoundname" id="goldnotfoundname" class="inputbox required" size="40" /> 
	
	<input type="button" value="<?php echo JText::_('JSEARCH_FILTER_SUBMIT');  ?>" onclick="mooToolsPicasaCheck();" style="margin-left: 10px;" />
</td>
<td>
</td>
</tr>
</table>

<input type="hidden" name="goldnotfoundid" id="goldnotfoundid"  />
<input type="hidden" name="goldnotfoundfullname" id="goldnotfoundfullname" />

</fieldset>

<table style="margin-left: 50px; display: none;" id="tableFound">
<tr>
<td>
<input type="button" value="search again" onclick="searchAgain();" style="margin-left: 50px;" />
</td>
<td>
<input type="submit" value="save" class="inputbox required" style="margin-left: 20px; font-size: 2.5em;" />
</td>
</tr>
</table>

<input type="hidden" name="task" value="adduser" />
<input type="hidden" name="boxchecked" value="0" />
<?php echo JHtml::_('form.token'); ?>

</form>

<br />

<div id="content-container">	
		
			<div id="goldnotfoundfullnameStatus"></div>
			
			<h1 id="navigate"></h1>
			<div id="photos"></div>

</div>
<span id="goldPicasaTabImagesLimitBox"></span>
<script type="text/javascript" src="<?php echo JURI::base(); ?>components/com_goldpicasa/assets/mooToolsPicasaViewer.js"></script>