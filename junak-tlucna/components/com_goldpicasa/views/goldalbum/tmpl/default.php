<?php
/**
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die;
?>
<div id="goldPicasaInfoDiv"></div>
<div id="goldGallerySpinner<?php echo $this->albumId; ?>" style="display: none;"><img src="<?php echo JURI::base(); ?>components/com_goldpicasa/assets/img/spinner.gif" style="margin-bottom:-4px;" />&nbsp;&nbsp;<?php echo JText::_('COM_GOLDPICASA_LOADING'); ?>...</div>
<?php echo $this->goldGalleryIntroText; ?>
<div class="goldGalleryMainDivClass" id="goldGalleryMainDiv<?php echo $this->albumId; ?>" ></div>
<div class="goldGalleryPagerClass" id="goldGalleryPager<?php echo $this->albumId; ?>" ></div>
<div id="goldGalleryScriptEmbed" ></div>
<br style="clear: both;" />
<script>
var myFxGpgOptions = { offset: {'x': 0, 'y': -10} };
var myFx = new Fx.Scroll(window, myFxGpgOptions);
<?php echo $this->jsparams; ?>
</script>
<?php echo $this->goldGalleryOutroText; ?>
