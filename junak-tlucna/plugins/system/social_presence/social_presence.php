<?php
/**
* @copyright	Copyright (C) 2012 JoomSpirit. All rights reserved.
* @license		GNU General Public License version 2 or later
*/

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root() . 'plugins/system/social_presence/social_presence.css');

/**
 * Social presence Plugin
 *
 */
 
class plgSystemSocial_presence extends JPlugin
{
	var $p_type = '';
	var $p_name = '';

	function plgSystemSocial_presence( &$subject, $params )
	{
		$this->p_type = $params['type'];
		$this->p_name = $params['name'];
		parent::__construct( $subject, $params );
	}
	
	function onAfterRender(){
		$mainframe = JFactory::getApplication();


		// disable plugin in the listed pages
		$excludedPaths = trim( (string) $this->params->get('disableinfrontend', ''));
		if ($excludedPaths) {
		
			$paths = array_map('trim', (array) explode("\n", $excludedPaths));
			$current_uri_string =& JURI::getInstance()->toString();		
		
			foreach ($paths as $path) {
				
				if (strpos($path, '*') === 0) {
					$path = ltrim($path, '*');
					if (stripos($current_uri_string, $path) !== false) { // any URL containing $path
						$this->_enabled = false;
						
						return;
					}
				} else {
					if (strcasecmp($current_uri_string, JURI::root().ltrim($path, '//')) == 0) { // case-insensitive string comparison
						$this->_enabled = false;
						
						return;
					}
				}
			}
			
		}


		
		if($mainframe->isAdmin()){
			return true;
		}
		
		// Get plugin info
		$plugin = JPluginHelper::getPlugin($this->p_type, $this->p_name);
		$pluginParams = new JRegistry( $plugin->params );
		
		ob_start();
		
		?>
		
		<!--[if lte IE 8]> 
		<style type="text/css">
		
		#social_presence li span.white {
		background-color: #fff;	
		}
		
		#social_presence li span.black {
		background-color: #444;
		}
		
		
		.bottom_left_horizontally li span:before, .top_left_horizontally li span:before, .top_right_horizontally li span:before, .bottom_right_horizontally li span:before,
		.bottom_left_vertically li span:before, .top_left_vertically li span:before, .top_right_vertically li span:before, .bottom_right_vertically li span:before {
		display : none ;
		}
		
		#social_presence li.bg {
		border : 1px solid #d6d6d6;
		}
		
		#social_presence.top_left_horizontally li.very_small, #social_presence.top_right_horizontally li.very_small,
		#social_presence.bottom_left_horizontally li.very_small, #social_presence.bottom_right_horizontally li.very_small {
		max-width:19px;
		}
		
		#social_presence.top_left_horizontally li.small, #social_presence.top_right_horizontally li.small,
		#social_presence.bottom_left_horizontally li.small, #social_presence.bottom_right_horizontally li.small {
		max-width:23px;
		}
		
		#social_presence.top_left_horizontally li.medium, #social_presence.top_right_horizontally li.medium,
		#social_presence.bottom_left_horizontally li.medium, #social_presence.bottom_right_horizontally li.medium {
		max-width:29px;
		}
		
		#social_presence.top_left_horizontally li.large, #social_presence.top_right_horizontally li.large,
		#social_presence.bottom_left_horizontally li.large, #social_presence.bottom_right_horizontally li.large {
		max-width:35px;
		}
		
		#social_presence.top_left_horizontally li.very_large, #social_presence.top_right_horizontally li.very_large,
		#social_presence.bottom_left_horizontally li.very_large, #social_presence.bottom_right_horizontally li.very_large {
		max-width:43px;
		}		
		.google_button {
		max-width : inherit !important;
		}
		
			
		</style>
		<![endif]-->
		
		<!--[if lte IE 7]> 
		<style type="text/css">
		
		#social_presence ul li.normal-01, #social_presence ul li.hover-01:hover, #social_presence ul li.normal-02, #social_presence ul li.hover-02:hover,
		#social_presence ul li.normal-03, #social_presence ul li.hover-03:hover, #social_presence ul li.normal-04, #social_presence ul li.hover-04:hover,
		#social_presence ul li.normal-05, #social_presence ul li.hover-05:hover, #social_presence ul li.normal-06, #social_presence ul li.hover-06:hover,
		#social_presence ul li.normal-08, #social_presence ul li.hover-08:hover, #social_presence ul li.normal-07, #social_presence ul li.hover-07:hover,
		#social_presence ul li.normal-09, #social_presence ul li.hover-09:hover {
		filter : none;
		}
		
		</style>
		<![endif]-->

		<div id="social_presence" class="<?php echo $pluginParams->get('position'); ?>_<?php echo $pluginParams->get('alignment'); ?>">
		<ul>
		
		<?php
		// 	Google+1 button
		if ($pluginParams->get('google+1') == 'yes') {

		?>
		
		<li class=" <?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> google_button"  >
			<div class="g-plusone" data-annotation="none" ></div>
			<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
		</li>
		<?php
			
		}
	

		// 	Icon 01
		if ($pluginParams->get('icon_01') == 'yes') {

		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_01_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_01_theme'); ?>/<?php echo $pluginParams->get('icon_01_image'); ?>" alt="<?php echo $pluginParams->get('icon_01_text'); ?>" title=""/>
				<?php if ( $pluginParams->get('icon_01_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_01_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 02
		
		if ($pluginParams->get('icon_02') == 'yes') {
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_02_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_02_theme'); ?>/<?php echo $pluginParams->get('icon_02_image'); ?>" alt="<?php echo $pluginParams->get('icon_02_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_02_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_02_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 03
		
		if ($pluginParams->get('icon_03') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_03_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_03_theme'); ?>/<?php echo $pluginParams->get('icon_03_image'); ?>" alt="<?php echo $pluginParams->get('icon_03_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_03_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_03_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 04
		
		if ($pluginParams->get('icon_04') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_04_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_04_theme'); ?>/<?php echo $pluginParams->get('icon_04_image'); ?>" alt="<?php echo $pluginParams->get('icon_04_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_04_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_04_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 05
		
		if ($pluginParams->get('icon_05') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_05_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_05_theme'); ?>/<?php echo $pluginParams->get('icon_05_image'); ?>" alt="<?php echo $pluginParams->get('icon_05_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_05_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_05_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 06
		
		if ($pluginParams->get('icon_06') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_06_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_06_theme'); ?>/<?php echo $pluginParams->get('icon_06_image'); ?>" alt="<?php echo $pluginParams->get('icon_06_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_06_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_06_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 07
		
		if ($pluginParams->get('icon_07') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_07_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_07_theme'); ?>/<?php echo $pluginParams->get('icon_07_image'); ?>" alt="<?php echo $pluginParams->get('icon_07_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_07_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_07_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 08
		
		if ($pluginParams->get('icon_08') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_08_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_08_theme'); ?>/<?php echo $pluginParams->get('icon_08_image'); ?>" alt="<?php echo $pluginParams->get('icon_08_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_08_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_08_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 09
		?>
		
		<?php
		if ($pluginParams->get('icon_09') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_09_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_09_theme'); ?>/<?php echo $pluginParams->get('icon_09_image'); ?>" alt="<?php echo $pluginParams->get('icon_09_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_09_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_09_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 10
		
		if ($pluginParams->get('icon_10') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_10_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_10_theme'); ?>/<?php echo $pluginParams->get('icon_10_image'); ?>" alt="<?php echo $pluginParams->get('icon_10_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_10_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_10_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 11
		
		if ($pluginParams->get('icon_11') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_11_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_11_theme'); ?>/<?php echo $pluginParams->get('icon_11_image'); ?>" alt="<?php echo $pluginParams->get('icon_11_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_11_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_11_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 12
		
		if ($pluginParams->get('icon_12') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_12_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_12_theme'); ?>/<?php echo $pluginParams->get('icon_12_image'); ?>" alt="<?php echo $pluginParams->get('icon_12_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_12_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_12_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 13
		
		if ($pluginParams->get('icon_13') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_13_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_13_theme'); ?>/<?php echo $pluginParams->get('icon_13_image'); ?>" alt="<?php echo $pluginParams->get('icon_13_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_13_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_13_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 14
		
		if ($pluginParams->get('icon_14') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_14_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_14_theme'); ?>/<?php echo $pluginParams->get('icon_14_image'); ?>" alt="<?php echo $pluginParams->get('icon_14_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_14_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_14_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 15
		
		if ($pluginParams->get('icon_15') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_15_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_15_theme'); ?>/<?php echo $pluginParams->get('icon_15_image'); ?>" alt="<?php echo $pluginParams->get('icon_15_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_15_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_15_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 16
		
		if ($pluginParams->get('icon_16') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_16_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_16_theme'); ?>/<?php echo $pluginParams->get('icon_16_image'); ?>" alt="<?php echo $pluginParams->get('icon_16_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_16_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_16_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 17
		
		if ($pluginParams->get('icon_17') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_17_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_17_theme'); ?>/<?php echo $pluginParams->get('icon_17_image'); ?>" alt="<?php echo $pluginParams->get('icon_17_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_17_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_17_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		// 	Icon 18
		
		if ($pluginParams->get('icon_18') == 'yes') {
		
		?>
		
		
		<li class="<?php echo $pluginParams->get('size'); ?> normal-<?php echo $pluginParams->get('opacity_normal'); ?> hover-<?php echo $pluginParams->get('opacity_hover'); ?> <?php if ( $pluginParams->get('background') == "yes") : ?>bg<?php endif ; ?>" <?php if ( $pluginParams->get('background') == "yes") : ?>style="background-color:<?php echo $pluginParams->get('color_background'); ?>;"<?php endif ; ?> >
		<a target="<?php echo $pluginParams->get('target'); ?>" <?php if ( $pluginParams->get('follow') == "yes") : ?>rel="nofollow"<?php endif ; ?> href="<?php echo $pluginParams->get('icon_18_link'); ?>">
				<img src="<?php echo JURI::Base()?>plugins/system/social_presence/icons/<?php echo $pluginParams->get('icon_18_theme'); ?>/<?php echo $pluginParams->get('icon_18_image'); ?>" alt="<?php echo $pluginParams->get('icon_18_text'); ?>" title="" />
				<?php if ( $pluginParams->get('icon_18_text') != "") : ?><span class="<?php echo $pluginParams->get('tooltips_color'); ?>"><?php echo $pluginParams->get('icon_18_text'); ?></span><?php endif ; ?>
			</a>
		</li>
		<?php
		
		}
		
		?>
		</ul>
		</div>
		
		<?php
		
		$str_html = ob_get_contents();
		ob_end_clean();
		
		$body = JResponse::getBody();
		$body = str_replace('</body>', $str_html.'</body>', $body);
		JResponse::setBody($body);
		
		return true;
	}

}

