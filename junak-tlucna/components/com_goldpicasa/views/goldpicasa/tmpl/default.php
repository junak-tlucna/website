<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */

# ALBUMS LIST

// no direct access
defined('_JEXEC') or die;
?>
<?php echo $this->goldGalleryIntroText; ?>
<div id="goldPicasaInfoDiv"></div>
<div id="goldGallerySpinner" style="display: none;"><img src="<?php echo JURI::base(); ?>components/com_goldpicasa/assets/img/spinner.gif" style="margin-bottom:-4px;" />&nbsp;&nbsp;<?php echo JText::_('COM_GOLDPICASA_LOADING'); ?>...</div>
<div class="goldGalleryMainDivClass" id="goldGalleryMainDiv" ></div>
<div class="goldGalleryPagerClass" id="goldGalleryPager" ></div>
<div id="goldGalleryScriptEmbed" ></div>
<br style="clear: both;" />
<script>
    var myFxGpgOptions = { offset: {'x': 0, 'y': -22} };
    var myFx = new Fx.Scroll(window, myFxGpgOptions);
    <?php echo $this->jsparams; ?>
    window.addEvent("domready", function() { goldGalleryGetAlbums();});
</script>
<?php echo $this->goldGalleryOutroText; ?>

<?php 
//<pre>
//echo var_export($config, 1);
//echo $jsparams;
//</pre>
?>
