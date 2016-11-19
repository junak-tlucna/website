<?php
/**
* @copyright	Copyright (C) 2013 - JoomSpirit. All rights reserved.
*/

defined('_JEXEC') or die('Restricted access');
SetLocale(LC_ALL, "cs_CZ"); 

$path = $this->baseurl.'/templates/'.$this->template;

$app = JFactory::getApplication();
$menu = $app->getMenu();
$lang = JFactory::getLanguage();
if ($menu->getActive() == $menu->getDefault($lang->getTag())) {
$js='<div class="js-copyright" ><a class="jslink" target="_blank" href="http://www.template-joomspirit.com" >template-joomspirit.com</a></div>';
} else {$js='<div class="js-copyright" ><a class="jslink" target="_blank" href="http://www.template-joomspirit.com" >www.template-joomspirit.com</a></div>' ;}

if ($this->params->get('fontSize') == '') 
{ $fontSize ='0.85em'; } 
else { $fontSize = $this->params->get('fontSize'); }

JHtml::_('bootstrap.framework');

$filepath = JURI::root(true).'/templates/'.$this->template;
$doc = JFactory::getDocument();

$doc->addStyleSheet(JURI::root(true).'/templates/system/css/general.css' , 'text/css', 'all');

$doc->addStyleSheet($filepath.'/css/bootstrap.css' , 'text/css', 'all');
$doc->addStyleSheet($filepath.'/css/font-awesome.css' , 'text/css', 'all');
$doc->addStyleSheet($filepath.'/css/template.css' , 'text/css', 'all');
$doc->addStyleSheet($filepath.'/css/print.css' , 'text/css', 'print');

$space_font_name   = array("+");
if ( $this->params->get('custom_font_website_title') != '' ) { $font_website_title = $this->params->get('custom_font_website_title') ; } else { $font_website_title = $this->params->get('font_website_title') ; }
if ( $this->params->get('custom_font_menu') != '' ) { $font_menu = $this->params->get('custom_font_menu') ; } else { $font_menu = $this->params->get('font_menu') ; }
if ( $this->params->get('custom_font_h1') != '' ) { $font_h1 = $this->params->get('custom_font_h1') ; } else { $font_h1 = $this->params->get('font_h1') ; }
if ( $this->params->get('custom_font_h2') != '' ) { $font_h2 = $this->params->get('custom_font_h2') ; } else { $font_h2 = $this->params->get('font_h2') ; }
if ( $this->params->get('custom_font_content') != '' ) { $font_content = $this->params->get('custom_font_content') ; } else { $font_content = $this->params->get('font_content') ; }

// 		find the position of the caracter ":"
function sep_font($font)
{
    $pos=strpos($font, ":");
    $length=strlen($font);
    if ($pos !== false)
    {
        return $pos ;
    }
    else
    {
        return $length ;
    }
}

// load all non standard fonts from Google
$defaultFonts = array('Arial', 'Verdana', 'Trebuchet ms', 'Helvetica', 'Georgia', 'Times new roman');
$allFonts = array($font_content, $font_menu, $font_website_title, $font_h1, $font_h2);
$googleFonts = array_diff($allFonts, $defaultFonts);
foreach ($googleFonts as $loadFont) {
	$doc->addStyleSheet('http://fonts.googleapis.com/css?family='.$loadFont.'&subset=latin,latin-ext', 'text/css', 'all');
}""
	
?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >	

<head>

<jdoc:include type="head" />
<?php JFactory::getDocument()->setGenerator(''); ?>		<!-- 	hide the meta tag generator for website security 		-->


	<!-- 		Template manager variables			-->
	<style type="text/css">
		
		/** 	COLOR 			**/
		
		.website-header, .bg-image-module, .isStuck {
		background-color : #<?php echo $this->params->get('color_top_bg') ; ?>;
		}
			
		.drop-down li a, .drop-down li span.separator {
		color:#<?php echo $this->params->get('color_main_menu_item') ; ?>;
		}		
		.drop-down li.active > a, .drop-down li.active > span, .drop-down li:hover > a, .drop-down li:hover > span {
		color:#<?php echo $this->params->get('color_main_menu_item_active') ; ?>;
		border-color : #<?php echo $this->params->get('color_main_menu_item_active') ; ?>;
		}
		.drop-down li li a, .drop-down li li span.separator {
		color:#<?php echo $this->params->get('color_main_menu_subitem') ; ?>;
		}		
		.drop-down li li.active > a, .drop-down li li.active > span, .drop-down li li:hover > a, .drop-down li li:hover > span {
		color:#<?php echo $this->params->get('color_main_menu_subitem_active') ; ?>;
		}
		
		a {
		color: #<?php echo $this->params->get('color_link') ; ?>;
		}		
		input[type="submit"], button, .breadcrumb a:hover, .vertical_menu li a:hover,
		.slogan-module li a:hover, .bottom_menu li a:hover, a:hover, .contact .open a {
		color: #<?php echo $this->params->get('color_link_hover') ; ?>;
		}		
		.horizontal_menu li.current > a {
		background: #<?php echo $this->params->get('color_link_hover') ; ?>;
		}		
		.vertical_menu li.current > a {
		background: #<?php echo $this->params->get('color_link_hover') ; ?>;
		}
		
		/**		TITLE 		**/		

		h1, .componentheading, h1 a, h1 a:hover, .blog > h1, .blog > h2 {
		color: #<?php echo $this->params->get('colorh1') ; ?>;
		}		
		h2, h2 a, h2.contentheading > a , h1 + h1 > a {
		color: #<?php echo $this->params->get('colorh2') ; ?>;
		}		
		.left_column h3, .right-module-position h3, .top-module-position h3, .bottom-module-position h3,
		.user1 h3, .user2 h3, .user3 h3, .user4 h3, .user5 h3, .user6 h3, .user7 h3, .user8 h3, .user9 h3 {
		color: #<?php echo $this->params->get('colorh2') ; ?>;
		}
				
		/**		FONT	**/
				
		.drop-down li a, .drop-down li span.separator {
		font-family: '<?php echo str_replace($space_font_name," ",substr($font_menu,0,sep_font($font_menu)) ) ; ?>', sans-serif;
		}
		.drop-down ul {
		font-size : <?php echo $this->params->get('main_menu_fontsize') ; ?>;
		}
		h1, .componentheading, .blog > h1, .blog > h2 {
		font-family: '<?php echo str_replace($space_font_name," ",substr($font_h1,0,sep_font($font_h1)) ) ; ?>', sans-serif;
		font-size : <?php echo $this->params->get('h1_fontsize') ; ?>;
		}
		h1 + h1, h2, h3, h4, h5,
		.left_column h3, .right-module-position h3, .top-module-position h3, .bottom-module-position h3, .user1 h3, .user2 h3, .user3 h3, 
		.user4 h3, .user5 h3, .user6 h3, .user7 h3, .user8 h3, .user9 h3 {
		font-family: '<?php echo str_replace($space_font_name," ",substr($font_h2,0,sep_font($font_h2)) ) ; ?>', sans-serif;
		}
		.left_column h3, .right-module-position h3, .top-module-position h3, .bottom-module-position h3, .user1 h3, .user2 h3, .user3 h3, 
		.user4 h3, .user5 h3, .user6 h3, .user7 h3, .user8 h3, .user9 h3 {
		font-size : <?php echo $this->params->get('module_title_fontsize') ; ?>;
		}
		h1 + h1, h2 {
		font-size : <?php echo $this->params->get('h2_fontsize') ; ?>;
		}
		h3 {
		font-size : <?php echo $this->params->get('h3_fontsize') ; ?>;
		}
		h4 {
		font-size : <?php echo $this->params->get('h4_fontsize') ; ?>;
		}
		h5 {
		font-size : <?php echo $this->params->get('h5_fontsize') ; ?>;
		}
		
		/**			Width 		**/
		 
		.wrapper-website {
		width : <?php echo $this->params->get('width_website') ; ?>;
		}		
		.left_column {
		width:<?php echo $this->params->get('width_left') ; ?>;
		}
		.right_column {
		width:<?php echo $this->params->get('width_right') ; ?>;
		}
		
		.image-module .wrapper-website {
		width:<?php echo $this->params->get('width_slideshow') ; ?>;
		}

		@media screen and (min-width: 980px) and (max-width: <?php echo $this->params->get('width_website') ; ?>) {
			
			.wrapper-website-content, .wrapper-website-footer {
			width : 98%;
			}		
		
		}
		
	</style>

	<?php if ( $this->params->get('responsive') == 'yes') : ?>
		
		<meta name="viewport" content="initial-scale=1" />
		<link rel="stylesheet" href="<?php echo $filepath ?>/css/media_queries.css" type="text/css" media="all" />
		
		<!--		Fixed a bug with Abndroid 4 and select field (see Boostrap doc) 	-->
		<script type="text/javascript">
		var nua = navigator.userAgent
		var isAndroid = (nua.indexOf('Mozilla/5.0') > -1 && nua.indexOf('Android ') > -1 && nua.indexOf('AppleWebKit') > -1 && nua.indexOf('Chrome') === -1)
		if (isAndroid) {
		  $('select.form-control').removeClass('form-control').css('width', '100%')
		}
		</script>
		
	<?php else : ?>
	
		<link rel="stylesheet" href="<?php echo $filepath ?>/css/media_queries_no_responsive.css" type="text/css" media="all" />
	
	<?php endif; ?>
	
	<link rel="stylesheet" href="<?php echo $filepath ?>/css/custom.css" type="text/css" media="all" />
	
	<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php echo $filepath ?>/css/ie8.css" type="text/css" />
		<script type="text/javascript" src="<?php echo $filepath ?>/lib/js/html5.js"></script>
	<![endif]-->
	
	<!--[if lte IE 7]>
		<link rel="stylesheet" href="<?php echo $filepath ?>/css/ie7.css" type="text/css" />	
	<![endif]-->
	
	<!-- Bootstrap 3 js 		-->
	<script type="text/javascript" src="<?php echo $filepath ?>/lib/js/bootstrap.min.js"></script>

    <!-- YouTube Subscribe Button -->
    <script src="https://apis.google.com/js/platform.js"></script>

</head>

<body style="font-size:<?php echo $fontSize ; ?>;color : #<?php echo $this->params->get('color_text_general') ; ?>;font-family: '<?php echo str_replace($space_font_name," ",substr($font_content,0,sep_font($font_content)) ) ; ?>', sans-serif;"  class=" <?php if ( $this->params->get('uppercase') == 'yes') : ?>text-uppercase<?php endif ; ?>">

	
	<header class="website-header clearfix zindex30 <?php if(! $this->countModules('image')) echo $this->params->get('shadow_bg') ; ?>">
		
		<div class="wrapper-website zindex10">
		
			<!--	SOCIAL LINKS	-->
			<?php if( ( $this->params->get('$google1') == 'yes') || ($this->params->get('twitter') != '') || ($this->params->get('facebook') != '') || ($this->params->get('rss') != '') || ($this->params->get('linkedin') != '') || ($this->params->get('google') != '') || ($this->params->get('instagram') != '') || ($this->params->get('pinterest') != '') || ($this->params->get('renren') != '') || ($this->params->get('weibo') != '') || ($this->params->get('flickr') != '') || ($this->params->get('xing') != '') || ($this->params->get('youtube') != '') || ($this->params->get('vimeo') != '') || ($this->params->get('tumblr') != '') || ($this->params->get('custom_icon01') != '') ) : ?>
			<div class="social-links" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_social') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_social_text') ; ?>"<?php endif; ?> >
		
				<?php if ( $this->params->get('text_social_icons') != '') : ?>
				<span class="text_social_icons hidden-phone" style="color:#<?php echo $this->params->get('color_text_social') ; ?>;"><?php echo $this->params->get('text_social_icons') ; ?></span>
				<?php endif; ?>
					
				<ul>
					
					<?php if ( $this->params->get('google1') == 'yes') : ?>
					<li class="google">
					<div class="g-plusone" data-size="small" data-count="false" ></div>
					</li>
					<?php endif; ?>
					
					<?php if ($this->params->get('twitter') != '') : ?>
					<li><a target="_blank" class="icon_twitter" title="Twitter" href="<?php echo $this->params->get('twitter') ?>"><i class="fa fa-twitter"></i></a></li>
					<?php endif; ?>		
					<?php if ($this->params->get('facebook') != '') : ?>
					<li><a target="_blank" class="icon_facebook" title="Facebook" href="<?php echo $this->params->get('facebook') ?>"><i class="fa fa-facebook"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('rss') != '') : ?>
					<li><a target="_blank" class="icon_rss" title="RSS" href="<?php echo $this->params->get('rss') ?>"><i class="fa fa-rss"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('linkedin') != '') : ?>
					<li><a target="_blank" class="icon_linkedin" title="Linkedin" href="<?php echo $this->params->get('linkedin') ?>"><i class="fa fa-linkedin"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('google') != '') : ?>
					<li><a target="_blank" class="icon_google" title="Google" href="<?php echo $this->params->get('google') ?>"><i class="fa fa-google-plus"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('instagram') != '') : ?>
					<li><a target="_blank" class="icon_instagram" title="Instagram" href="<?php echo $this->params->get('instagram') ?>"><i class="fa fa-instagram"></i></a></li>
					<?php endif; ?>					
					<?php if ($this->params->get('pinterest') != '') : ?>
					<li><a target="_blank" class="icon_pinterest" title="Pinterest" href="<?php echo $this->params->get('pinterest') ?>"><i class="fa fa-pinterest"></i></a></li>
					<?php endif; ?>					
					<?php if ($this->params->get('renren') != '') : ?>
					<li><a target="_blank" class="icon_renren" title="Renren" href="<?php echo $this->params->get('renren') ?>"><i class="fa fa-renren"></i></a></li>
					<?php endif; ?>					
					<?php if ($this->params->get('weibo') != '') : ?>
					<li><a target="_blank" class="icon_weibo" title="Weibo" href="<?php echo $this->params->get('weibo') ?>"><i class="fa fa-weibo"></i></a></li>
					<?php endif; ?>					
					<?php if ($this->params->get('xing') != '') : ?>
					<li><a target="_blank" class="icon_xing" title="Xing" href="<?php echo $this->params->get('xing') ?>"><i class="fa fa-xing"></i></a></li>
					<?php endif; ?>					
					<?php if ($this->params->get('flickr') != '') : ?>
					<li><a target="_blank" class="icon_flickr" title="Flickr" href="<?php echo $this->params->get('flickr') ?>"><i class="fa fa-flickr"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('youtube') != '') : ?>
					<li><a target="_blank" class="icon_youtube" title="Youtube" href="<?php echo $this->params->get('youtube') ?>"><i class="fa fa-youtube"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('vimeo') != '') : ?>
					<li><a target="_blank" class="icon_vimeo" title="Vimeo" href="<?php echo $this->params->get('vimeo') ?>"><i class="fa fa-vimeo-square"></i></a></li>
					<?php endif; ?>
					<?php if ($this->params->get('tumblr') != '') : ?>
					<li><a target="_blank" class="icon_tumblr" title="Tumblr" href="<?php echo $this->params->get('tumblr') ?>"><i class="fa fa-tumblr"></i></a></li>
					<?php endif; ?>
	
					<?php if ($this->params->get('custom_icon01') != '') : ?>
					<li><a target="_blank" class="custom_icon01" title="<?php echo $this->params->get('custom_icon01_text') ; ?>" href="<?php echo $this->params->get('custom_icon01') ?>"><img src="<?php echo JURI::base() ; ?>templates/<?php echo $this->template; ?>/images/social-icons/<?php echo $this->params->get('custom_icon01_img') ; ?>" alt="" /></a></li>
					<?php endif; ?>					
	
					<?php if ($this->params->get('custom_icon02') != '') : ?>
					<li><a target="_blank" class="custom_icon02" title="<?php echo $this->params->get('custom_icon02_text') ; ?>" href="<?php echo $this->params->get('custom_icon02') ?>"><img src="<?php echo JURI::base() ; ?>templates/<?php echo $this->template; ?>/images/social-icons/<?php echo $this->params->get('custom_icon02_img') ; ?>" alt="" /></a></li>
					<?php endif; ?>
	
					<?php if ($this->params->get('custom_icon03') != '') : ?>
					<li><a target="_blank" class="custom_icon03" title="<?php echo $this->params->get('custom_icon03_text') ; ?>" href="<?php echo $this->params->get('custom_icon03') ?>"><img src="<?php echo JURI::base() ; ?>templates/<?php echo $this->template; ?>/images/social-icons/<?php echo $this->params->get('custom_icon03_img') ; ?>" alt="" /></a></li>
					<?php endif; ?>					
	
					<?php if ($this->params->get('custom_icon04') != '') : ?>
					<li><a target="_blank" class="custom_icon04" title="<?php echo $this->params->get('custom_icon04_text') ; ?>" href="<?php echo $this->params->get('custom_icon04') ?>"><img src="<?php echo JURI::base() ; ?>templates/<?php echo $this->template; ?>/images/social-icons/<?php echo $this->params->get('custom_icon04_img') ; ?>" alt="" /></a></li>
					<?php endif; ?>
	
				</ul>
					
			</div> 			<!-- 	end of Website icons 		-->
			<?php endif; ?>

			<?php if($this->countModules('translate')) : ?>
			<div id="translate" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_translate') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_translate_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="translate" style="joomspirit" />
			</div>	
			<?php endif; ?>
			
			<div class="logo-module zindex10 <?php echo $this->params->get('logo_position') ; ?>" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_logo') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_logo_text') ; ?>"<?php endif; ?> >
			<?php if($this->countModules('logo')) : ?>
				<jdoc:include type="modules" name="logo" style="joomspirit" />
			<?php else : ?>
				<?php if ( $this->params->get('website_title') != '' ) : ?><a href="<?php echo $this->baseurl ?>" ><span class="website-title " style="font-family: '<?php echo str_replace($space_font_name," ",substr($font_website_title,0,sep_font($font_website_title)) ) ; ?>', sans-serif;color : #<?php echo $this->params->get('color_website_title') ; ?>;font-size : <?php echo $this->params->get('website_title_fontsize') ; ?>;"><span><?php echo $this->params->get('website_title') ; ?></span></span></a><?php endif ; ?>
			<?php endif; ?>
			</div>			
	
			<?php if($this->countModules('menu')) : ?>
			<nav id="js_navigation" class=" zindex30 drop-down clearfix " role="navigation" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_menu') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_menu_text') ; ?>"<?php endif; ?> >
				
				<span class="title_menu">
					<a href="#js_navigation"><img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/icon-menu.png" alt="" class="icone-menu" /><?php echo $this->params->get('text_menu') ; ?></a>
				</span>
									
				<jdoc:include type="modules" name="menu" style="joomspirit" />
					
			</nav>
			<?php endif; ?>
			
			<div class="empty-space clearfix"></div> 		<!--		empty DIV for Sticky menu 		-->
		
		</div>											<!--   		end of Wrapper Website 			-->
			
	</header>												<!--   		end of Header 			-->


	<?php if($this->countModules('image')) : ?>
	<aside class="image-module zindex10" role="complementary" >
	
		<div class="wrapper-website zindex10">		
			<jdoc:include type="modules" name="image" style="joomspirit" />
		</div>
		
		<div class="bg-image-module <?php echo $this->params->get('shadow_bg') ; ?>"></div>
					
	</aside>												<!--   		end of Wrapper Website 			-->
	<?php endif; ?>
	

	<section class="website-content clearfix zindex10" >
	
		<div class="wrapper-website zindex10">
	
			<?php if($this->countModules('breadcrumb')) : ?>
			<nav class="breadcrumb zindex10" role="navigation" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_breadcrumb') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_breadcrumb_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="breadcrumb" style="xhtml" />
			</nav>
			<?php endif; ?>
		
			<?php if($this->countModules('top')) : ?>
			<aside class="top-module-position" role="complementary" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_top') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_top_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="top" style="joomspirit" />
			</aside>
			<?php endif; ?>	
			
			<?php if($this->countModules('left')) : ?>
			<aside class="left_column <?php if ( $this->params->get('column_responsive') == 'yes' && $this->params->get('responsive') == 'yes' ) : ?>visible-desktop<?php endif; ?>" role="complementary" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_left') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_left_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="left" style="joomspirit" />
			</aside>
			<?php endif; ?>
			
			<?php if( $this->countModules('right') ) : ?>
			<aside class="right_column <?php if ( $this->params->get('column_responsive') == 'yes' && $this->params->get('responsive') == 'yes' ) : ?>visible-desktop<?php endif; ?>" role="complementary" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_right') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_right_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="right" style="joomspirit" />
			</aside>
			<?php endif; ?>				
		
			<!--  MAIN COLUMN -->
			<div class="main_content">
					
				<!--  USER 1, 2, 3 -->
				<?php if($this->countModules('user1') || $this->countModules('user2') || $this->countModules('user3')) : ?>
				<aside class="users_top clearfix" role="complementary" >
															
					<?php if($this->countModules('user1')) : ?>
					<div class="user1" <?php echo ('style="width:'.$this->params->get('user1_width').'%;"');?> <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_user1') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_user1_text') ; ?>"<?php endif; ?> >
						<jdoc:include type="modules" name="user1" style="joomspirit" />
					</div>
					<?php endif; ?>
										
					<?php if($this->countModules('user3')) : ?>
					<div class="user3" <?php echo ('style="width:'.$this->params->get('user3_width').'%;"');?> <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_user3') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_user3_text') ; ?>"<?php endif; ?> >
						<jdoc:include type="modules" name="user3" style="joomspirit" />
					</div>
					<?php endif; ?>
				
					<?php if($this->countModules('user2')) : ?>
					<div class="user2" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_user2') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_user2_text') ; ?>"<?php endif; ?> >
						<jdoc:include type="modules" name="user2" style="joomspirit" />
					</div>
					<?php endif; ?>
										
				</aside>
				<?php endif; ?>  <!--	END OF USERS TOP	-->
			
				<div class="main_component clearfix" role="main" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_article') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_article_text') ; ?>"<?php endif; ?> >
	
					<!--  MAIN COMPONENT -->
					<jdoc:include type="message" />
					<jdoc:include type="component" />
			
				</div>	
				
				<!--  USER 4, 5, 6 -->
				<?php if($this->countModules('user4') || $this->countModules('user5') || $this->countModules('user6')) : ?>
				<aside class="users_bottom clearfix" role="complementary" >
															
					<?php if($this->countModules('user4')) : ?>
					<div class="user4" <?php echo ('style="width:'.$this->params->get('user4_width').'%;"');?> <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_user4') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_user4_text') ; ?>"<?php endif; ?> >
						<jdoc:include type="modules" name="user4" style="joomspirit" />
					</div>
					<?php endif; ?>
										
					<?php if($this->countModules('user6')) : ?>
					<div class="user6" <?php echo ('style="width:'.$this->params->get('user6_width').'%;"');?> <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_user6') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_user6_text') ; ?>"<?php endif; ?> >
						<jdoc:include type="modules" name="user6" style="joomspirit" />
					</div>
					<?php endif; ?>
				
					<?php if($this->countModules('user5')) : ?>
					<div class="user5" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_user5') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_user5_text') ; ?>"<?php endif; ?> >
						<jdoc:include type="modules" name="user5" style="joomspirit" />
					</div>
					<?php endif; ?>
										
				</aside>
				<?php endif; ?>  <!--	END OF USERS BOTTOM	-->
				
				<div class="clr"></div>
	
			</div>	  <!--	END OF MAIN CONTENT 	-->
				
			<?php if( ($this->countModules('left')) && ( $this->params->get('column_responsive') == 'yes') && ( $this->params->get('responsive') == 'yes') ) : ?> 				<!-- Left and right column are duplicate to modify the order on mobiles devices 	-->
			<aside class="left_column hidden-desktop" role="complementary" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_left') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_left_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="left" style="joomspirit" />			
			</aside>
			<?php endif; ?>
			
			<?php if( ($this->countModules('right')) && ( $this->params->get('column_responsive') == 'yes') && ( $this->params->get('responsive') == 'yes') ) : ?>
			<aside class="right_column hidden-desktop" role="complementary" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_right') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_right_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="right" style="joomspirit" />			
			</aside>
			<?php endif; ?>
		
			<?php if($this->countModules('bottom')) : ?>
			<aside class="bottom-module-position" role="complementary" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_bottom') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_bottom_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="bottom" style="joomspirit" />
			</aside>
			<?php endif; ?>

		</div>							<!--			END OF WRAPPER WEBSITE 		-->
	
	</section>							<!--			END OF WEBSITE CONTENT		-->		
	
	
	<?php if( ($this->countModules( 'bottom_menu' )) || ($this->countModules( 'search' )) || ($this->countModules( 'address' )) ) : ?>
	<footer class="website-footer zindex10 clearfix">
	
		<div class="wrapper-website zindex10">			
					
			<?php if ($this->countModules( 'search' )) : ?>
			<div id="search" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_search') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_search_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="search" style="joomspirit" />
			</div>	
			<?php endif; ?>		
	
			<!--	bottom nav	-->
			<?php if ($this->countModules( 'bottom_menu' )) : ?>
			<nav class="bottom_menu <?php if (! $this->countModules( 'address' )) : ?>without_address<?php endif ; ?>" role="navigation" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_bottom_menu') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_bottom_menu_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="bottom_menu" style="joomspirit" />
			</nav>
			<?php endif; ?>
	
			<?php if($this->countModules('address')) : ?>
			<div class="address <?php if (! $this->countModules( 'bottom_menu' )) : ?>without_bottom_menu<?php endif ; ?>" <?php if( $this->params->get('animation') == 'yes' && $this->params->get('animation_address') == 'yes' ) : ?>data-scroll-reveal="<?php echo $this->params->get('animation_address_text') ; ?>"<?php endif; ?> >
				<jdoc:include type="modules" name="address" style="joomspirit" />
			</div>
			<?php endif; ?>			
				
		</div>							<!--			END OF WRAPPER WEBSITE 		-->
	
	</footer>							<!--			END OF WEBSITE CONTENT		-->	
	<?php endif; ?>
	
	
	<?php if ($this->countModules( 'debug' )) : ?>
		<jdoc:include type="modules" name="debug" />
	<?php endif; ?>
	
	<?php echo $js; ?>
	
	<?php // Google Analytics Tracking Code
	if( $this->params->get('google_code') ) {echo '<script type="text/javascript">'; echo $this->params->get('google_code') ; echo '</script>';}?>
	
	<?php if ( $this->params->get('sticky_menu') == 'yes') : ?>
	<script src="<?php echo $filepath ?>/lib/js/stickUp.min.js" type="text/javascript"></script>
	<script type="text/javascript">
	//initiating jQuery
	jQuery(function($) {
		jQuery(document).ready( function() {
		jQuery('.drop-down').stickUp();
		});
	});
	</script>
	<?php endif; ?>	
	
	<?php if ( $this->params->get('scroll_to_top') == 'yes' ) : ?>
		<div class="hidden-phone" id="toTop"><a id="toTopLink"><span class="icon-up"></span><span id="toTopText"> Back to top</span></a></div>
		<script type="text/javascript">
			jQuery(document).ready(function(){
					
					jQuery(window).scroll(function () {
					
						if (jQuery(this).scrollTop() > 200) {
							jQuery("#toTop").fadeIn();
						}
						else {
							jQuery("#toTop").fadeOut();
						}
					});
				
					jQuery("#toTop").click(function() {
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
						 return false;
					});
			});
		</script>
	<?php endif ; ?>
  	
	<?php if ( $this->params->get('google1') == 'yes') : ?>
	<script type="text/javascript" src="https://apis.google.com/js/plusone.js"></script>
	<?php endif; ?>

	<?php if ( (! preg_match("/MSIE 7/", $_SERVER['HTTP_USER_AGENT'])) && (! preg_match("/MSIE 8/", $_SERVER['HTTP_USER_AGENT'])) && ($this->params->get('animation') == 'yes' ) ) : ?>
		<script src="<?php echo $filepath ?>/lib/js/scrollReveal.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			var config = {
      			viewportFactor: 0
    			};
			window.scrollReveal = new scrollReveal(config);
		</script>
	<?php endif ; ?>

</body>
</html>
