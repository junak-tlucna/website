<?php
/**
 * Helper for frontend
 * @version     3.1.0
 * @package     com_goldpicasa
 * @copyright   Copyright (C) 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');


abstract class GoldpicasaHelper
{

	private static $isDebug=0;

    public static $compParams=array();
    public static $theme='clasic';

	

	/**
	 * Render single Album
	 *
	 * @param array $config
	 * @return string
	 */
	public static function renderAlbum($config=array()) {
		
		
		if ( !isset($config['goldGalleryAlbumId'][10]) ) return '';
		$albumAndUser = explode(',', $config['goldGalleryAlbumId']);
		$input = new JRequest();
		$input->set( $config , 'GET');

		//var_dump($albumAndUser);
		//var_dump($config);
		//return false;

		if ( !isset($albumAndUser[1]) || !is_numeric( $albumAndUser[0] ) )
		{
			JError::raiseWarning('com_goldpicasa', 'Album not found');
			return false;
		}


        $compParams = self::getComponentParams();
        //var_dump($compParams);


		$jsparams='goldpicasaAlbumsArray["'.$albumAndUser[0].'"]=Object();';

		
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].albumId="'. $albumAndUser[0].'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].userId="'. $albumAndUser[1].'";';

		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].useOrginalTitle=true;';//??
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].thumbnailSize='. $input->getVar( 'goldGalleryThumbnailSize', 150 ) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].imgmax="'. $input->getVar( 'goldGalleryImgmax', 1000 ).'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].customAlbumName="'. $input->getVar( 'goldGalleryCustomAlbumName', '' ) .'";';

		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].maxResults="'. $input->getVar('goldGalleryMaxResults', 30) .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].showAlbumName="'. $input->getVar('goldGalleryShowAlbumName', 1) .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].startIndex=1;';

		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].marginRight="'. $input->getVar('goldGalleryMarginRight', 5) .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].marginBottom="'. $input->getVar('goldGalleryMarginBottom', 5) .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].borderType="'. $input->getVar('goldGalleryBorderType', '0') .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].borderColor="'. $input->getVar('goldGalleryBorderColor', '') .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].borderBackgroundColor="'. $input->getVar('goldGalleryBackgroundColor', '') .'";';

		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].croped="'. $input->getVar('goldGalleryCroped', 'c') .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].showSummary='. $input->getVar('goldShowSummary', 1) .';';

		// SLIMBOX
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].displayMethod="'. $input->getVar('goldGalleryImageDisplayMethod', 'modal') .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxOverlayopacity='. $input->getVar('goldGallerySlimboxOverlayopacity', 0.4) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxOverlayFadeDuration='. $input->getVar('goldGallerySlimboxOverlayFadeDuration', 200) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxResizeDuration='. $input->getVar('goldGallerySlimboxResizeDuration', 200) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxCaptionAnimationDuration='. $input->getVar('goldGallerySlimboxCaptionAnimationDuration', 200) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxImageFadeDuration='. $input->getVar('goldGallerySlimboxImageFadeDuration', 200) .';';

		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxImageTitle='. $input->getVar('goldGallerySlimboxImageTitle', 3) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxImageLink="'. $input->getVar('goldGallerySlimboxImageLink', 'hide') .'";';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].slimboxAlbumname="'. $input->getVar('goldGallerySlimboxAlbumname', 'hide') .'";';

		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].customPager='. $input->getVar('goldGalleryCustomPager', 1) .';';
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].autoSize='. $input->getVar('goldGalleryAutoResize', 1) .';';
		
		// BACK
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].showBackButton='. $input->getVar('goldGalleryShowBackButton', 0) .';';
		//PAGER SHOW		
		$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].showPager='. $input->getVar('goldGalleryShowPager', 1) .';';
		
		
		
		//$jsparams.="goldpicasaAlbumsArray['".$albumAndUser[0]."']=goldpicasa;";
		//echo $jsparams;
		//return false;
		
		if ( strlen( $input->getVar('goldGalleryAttachCssFile', '') ) > 2  )
		{
			echo '<link rel="stylesheet" href="/media/media/css/'. $input->getVar('goldGalleryAttachCssFile') .'" type="text/css" />';
		}

        echo self::getBoxCss($compParams);



        // dodaje mootools-core.js
        if ( $compParams->get('mootoolscore') === 'yes' ) {
            self::addMootols();
        }

		//JHTML::_('behavior.mootools');
		JHtml::_('behavior.framework');
		$document = JFactory::getDocument();
		$document->addScript('components/com_goldpicasa/assets/goldGallery.js');
		$document->addStyleSheet('components/com_goldpicasa/assets/goldGallery.css'); 

		//	die('1.6');
		if(version_compare(JVERSION,'1.6.0','ge')) {
			// Joomla! 1.6 code here
			$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].jversion=16;';
			$document->addStyleSheet('components/com_goldpicasa/assets/slimbox18/css/slimbox.css'); 
			//echo '<script src="'. JURI::base() .'/components/com_goldpicasa/assets/slimbox18/slimbox_19.js" type="text/javascript"></script>'; // disabled in 3.2.4
		} else {
			// Joomla! 1.5 code here  - OLD!!!
			$jsparams.='goldpicasaAlbumsArray["'.$albumAndUser[0].'"].jversion=15;';
			$document->addScript('components/com_goldpicasa/assets/slimbox158/slimbox.js');
			$document->addStyleSheet('components/com_goldpicasa/assets/slimbox158/css/slimbox.css');
		}
		
		$lang = JFactory::getLanguage();
		$extension = 'com_goldpicasa';
		$base_dir = JPATH_SITE;
		$language_tag = $lang->getTag();
		$reload = true;
		$lang->load($extension, $base_dir, $language_tag, $reload);
		//echo $language_tag . ' ' . JText::_('COM_GOLDPICASA_IMAGE_1_OF_10');
		$jsparams.='COM_GOLDPICASA_IMAGE_1_OF_10="' . JText::_('COM_GOLDPICASA_IMAGE_1_OF_10') . '";';
		$jsparams.='COM_GOLDPICASA_JPREVIOUS="' . JText::_('JPREVIOUS') . '";';
		
		$isSsl = ( self::is_ssl() ) ? 's' : '';
		$jsparams.='goldpicasaSSL="'.$isSsl.'";';
		
		//
		if ( $album=JRequest::getVar('album', false) ) {
			$jsparams.='goldpicasaAlbumlistPart=true;';
		}
		
		if (self::$isDebug==1) {
			$html='';
			$html.='<pre>' .var_export($config, 1) . '</pre>';
			$html.=$jsparams;
			echo $html;
		}
		$jsparams.='window.addEvent("domready", function() { goldGalleryGetAlbumImages(1,"'.$albumAndUser[0].'");});';

		return $jsparams;
	}

	
	
	
	
	
	
	/**
	 * Render for plugin
	 * 
	 * @param string $params
	 * @return string
	 */
	public static function renderPlugin($params, $albumid='') {
		
		//JHTML::_('behavior.mootools'); // added on new issue: TypeError: Fx.Scroll is not a constructor
		JHtmlBehavior::framework('behavior.mootools'); //J30
		$html='';
		//$html.='goldGalleryMainDiv'.$albumid; // debug
		$html.='<div id="goldGallerySpinner'.$albumid.'" style="display: none;"><img src="'.JURI::base().'components/com_goldpicasa/assets/img/spinner.gif" style="margin-bottom:-4px;" /></div>';
		$html.='<div class="goldGalleryMainDivClass" id="goldGalleryMainDiv'.$albumid.'" ></div><div class="goldGalleryPagerClass" id="goldGalleryPager'.$albumid.'" ></div><div id="goldGalleryScriptEmbed" ></div><br style="clear: both;" />';
		$html.='<script>var myFx = new Fx.Scroll(window);';
		$html.= $params;
		$html.='</script>';
		//$html.='<p class="componentNameFooter">Gold Picasa Gallery</p>';
		return $html;
	}
	
	
	
	
	

	/**
	 * Render ALBUMS LIST
	 *
	 * @param array $config
	 * @return string
	 */
	public static function renderAlbums($config=array()) {

		$input = new JRequest();
		$input->set( $config , 'GET');

		if ( !isset($config['goldGalleryUserId'][2]) ) {
			
			echo '<br /><h1>Error: please select picasa user in backend</h1>';
			return false;
		}


        $compParams = self::getComponentParams();
        //var_dump($compParams);

        if ($compParams->get('theme')==='box') {
            self::$theme='box';
        }

        $lang = JFactory::getLanguage();
        $extension = 'com_goldpicasa';
        $base_dir = JPATH_ADMINISTRATOR;
        $language_tag = $lang->getTag();
        $reload = true;
        $lang->load($extension, $base_dir, $language_tag, $reload);

		//var_dump( JFactory::getConfig()->getValue('config.sef', false) );
		JHTML::_('behavior.tooltip');

		$html='';

		$jsparams='var goldpicasa=Object();';

        if (self::$theme==='box') {
            $jsparams.='goldpicasa.theme="box";';
        } else {
            $jsparams.='goldpicasa.theme="clasic";';
        }


		$jsparams.='goldpicasa.userId="'. $config['goldGalleryUserId'] .'";';

		$jsparams.='goldpicasa.thumbnailSize='. $input->getVar( 'goldGalleryThumbnailSize', 150 ) .';';
		$jsparams.='goldpicasa.imgmax="'. $input->getVar( 'goldGalleryImgmax', 1000 ).'";';

		$jsparams.='goldpicasa.maxResults="'. $input->getVar('goldGalleryMaxResults', 30) .'";';
		$jsparams.='goldpicasa.showAlbumName="'. $input->getVar('goldGalleryShowAlbumName', 1) .'";';

		$jsparams.='goldpicasa.showAlbumNameAlbumList="'. $input->getVar('goldGalleryShowAlbumNameAlbumList', 1) .'";';
		
		$jsparams.='goldpicasa.startIndex=1;';

		$jsparams.='goldpicasa.marginRight="'. $input->getVar('goldGalleryMarginRight', 6) .'";';
		$jsparams.='goldpicasa.marginBottom="'. $input->getVar('goldGalleryMarginBottom', 6) .'";';
		$jsparams.='goldpicasa.borderAlbumsType="'. $input->getVar('goldGalleryAlbumsBorderType', '0') .'";';
		$jsparams.='goldpicasa.borderAlbumsColor="'. $input->getVar('goldGalleryAlbumsBorderColor', '') .'";';
		$jsparams.='goldpicasa.borderAlbumsBackgroundColor="'. $input->getVar('goldGalleryAlbumsBackgroundColor', '') .'";';

		$jsparams.='goldpicasa.borderAlbumsThumbnailMargin="'. $input->getVar('goldGalleryThumbnailMargin', 10) .'";';
		$jsparams.='goldpicasa.albumsThumbnailSize='. $input->getVar('goldGalleryAlbumThumbnailSize', 150) .';';
		$jsparams.='goldpicasa.albumsMaxResults='. $input->getVar('goldGalleryAlbumsMaxResults', 10) .';';
		$jsparams.='goldpicasa.albumsCroped="'. $input->getVar('goldGalleryAlbumsCroped', 'c') .'";';

		$jsparams.='goldpicasa.sef="'. JFactory::getConfig()->get('config.sef', 0) .'";'; // not used ?
		
		$jsparams.='goldpicasa.customPager='. $input->getVar('goldGalleryCustomPager', 1) .';';
		
		$jsparams.='goldpicasa.showScrapBook='. $input->getVar('goldGalleryShowScrapBook', 1) .';';
		/*
		 * Disabled
		 * TODO in next version
		$jsparams.='goldpicasa.showBuzz='. $input->getVar('goldGalleryShowBuzz', 1) .';';
		$jsparams.='goldpicasa.showBlogger='. $input->getVar('goldGalleryShowBlogger', 1) .';';
		$jsparams.='goldpicasa.showProfilePhotos='. $input->getVar('goldGalleryShowProfilePhotos', 0) .';';
		$jsparams.='goldpicasa.showCameraSync='. $input->getVar('goldGalleryCameraSync', 0) .';';
		*/
		$jsparams.='goldpicasa.showAlbumFilesNumber='. $input->getVar('goldGalleryShowAlbumFilesNumber', 1) .';'; // photos count
		
		$isSsl = ( self::is_ssl() ) ? 's' : ''; 
		$jsparams.='goldpicasaSSL="'.$isSsl.'";';

		$jsparams.='COM_GOLDPICASA_IMAGES="'.JText::_('COM_GOLDPICASA_IMAGES').'";';



		$jsparams.="\n";

		$jsparams.='goldpicasa.welcomeTitle="'. addslashes( $input->getVar('goldGalleryWelcomeTitle', '') ) .'";';

		$t = $input->getVar('goldGalleryWelcomeText', '', 'HTML');
		$t = preg_replace('/(\r|\n|\r\n){2,}/', '<br />', $t);
		$t = addslashes($t);
		$jsparams.='goldpicasa.welcomeText="'. $t .'";';

		$uri = JFactory::getURI();
		$pageURL = $uri->toString();
		$jsparams.='goldpicasa.pageurl="'. $pageURL .'";';

        // dodaje mootools-core.js
        if ( $compParams->get('mootoolscore') === 'yes' ) {
            self::addMootols();
        }

		JHtml::_('behavior.framework');
		$document = JFactory::getDocument();
		$document->addScript('components/com_goldpicasa/assets/goldGallery.js');
		$document->addStyleSheet('components/com_goldpicasa/assets/goldGallery.css');

        echo self::getBoxCss($compParams);
 
		if ( strlen( $input->getVar('goldGalleryAttachCssFile', '') ) > 2  ) 
		{
			echo '<link rel="stylesheet" href="'.JURI::base() .'media/media/css/'. $input->getVar('goldGalleryAttachCssFile') .'" type="text/css" />';
		}
		
		if (self::$isDebug==1) {
			$html.='<pre>' .var_export($config, 1) . '</pre>';
			$html.=$jsparams;
			echo $html;
		}
		
		return $jsparams;
	}


	
	/**
	 * Determine if SSL is used.
	 *
	 *
	 * @return bool True if SSL, false if not used.
	 */
	public static function is_ssl() {

        return true;

		if ( isset($_SERVER['HTTPS']) ) {
			if ( 'on' == strtolower($_SERVER['HTTPS']) )
				return true;
			if ( '1' == $_SERVER['HTTPS'] )
				return true;
		} elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
			return true;
		}
		return false;
	}
	
	
	/**
	 * nl2br
	 */
	public function convertLineBreaks($string, $line_break=PHP_EOL) {
		$patterns = array("/(<br>|<br \/>|<br\/>)\s*/i","/(\r\n|\r|\n)/");
		$replacements = array(PHP_EOL,$line_break);
		$string = preg_replace($patterns, $replacements, $string);
		return $string;
	}



    public static function getComponentParams() {
        if (!empty(self::$compParams)) {
            return self::$compParams;
        }
        self::$compParams = JComponentHelper::getParams('com_goldpicasa');
        return self::$compParams;

    }


    /**
     * Box theme CSS
     *
     * TODO powtarzanie: run once
     *
     * @param $params
     * @return string
     */
    public static function getBoxCss($params) {

        //var_dump($params);

        $css='';
        $css.='<style>';

        $fontsize = $params->get('fontsize', '');
        $fontcolor = $params->get('fontcolor', '');
        $overlaycolor = $params->get('overlaycolor', '');
        $overlaylevel = $params->get('overlaylevel', '');
        $lineheight = $params->get('lineheight', '');

        //$css.='.ggdfigure, gdfigure:before, .ggdAlbumtitle {';
        //$css.='.ggdFontsDef {';
        //$css.='.ggdFontsDef, .ggdFontsDef div, .ggdFontsDef span, .ggdFontsDef p, .ggdfigure:before { ';
        $css.='.ggdfigure:before, .ggdfigure .ggdfigcaption .ggdAlbumtitle,  .ggdSummary, .ggdfigure .ggdAlbumFoot .ggdCountBottom { ';

            if ( isset($fontsize[2])) {
                $css.='font-size:'. $params->get('fontsize') .';';
            }
            if ( isset($fontcolor[2])) {
                $css.='color:'. $params->get('fontcolor') .';';
            }
            if ( isset($lineheight[2])) {
                $css.='line-height:'. $params->get('lineheight') .';';
            }
        $css.='}'; // koniec ggdfigure

        $css.='.ggdfigure:before, .ggdfigcaption, .ggdfigure .ggdAlbumFoot .ggdCountBottom, .ggdfigcaptionPhotos { ';
            if ( isset($overlaycolor[2])) {
                //$css.='background:'. $params->get('overlaycolor') .' !important;';
                $css.='background-color:'. self::hex2rgba( $params->get('overlaycolor'), $params->get('overlaylevel') ) .' !important;';
            }
        $css.='}';

        //$css.='.ggdfigure:before, .ggdfigcaption:hover {';

        /*
        Stare!
        if ( isset($overlaylevel[0])) {
            $css.='.ggdfigure:before, .ggdfigure a:hover .ggdfigcaption, .goldPicasaThumbA a:hover .ggdfigcaptionPhotos { ';
            //$css.='opacity:'. $params->get('overlaylevel') .' !important;';
            $css.='background-color:'. self::hex2rgba( $params->get('overlaycolor'), $params->get('overlaylevel') ) .' !important;'; // TODO (or not to)
            $css.='}'; // koniec ggdfigcaption
        }
        */


        if ( isset($overlaylevel[0])) {

            $css.='.goldPicasaThumbA a:hover .ggdfigcaptionPhotos { ';
            $css.='background-color:'. self::hex2rgba( $params->get('overlaycolor'), $params->get('overlaylevel') ) .' !important;'; // TODO (or not to)
            $css.='}'; // koniec ggdfigcaption

            $css.='.ggdfigure a:hover .ggdfigcaption { ';
            $css.='opacity: 1;';
            $css.='background-color:'. self::hex2rgba( $params->get('overlaycolor'), $params->get('overlaylevel') ) .' !important;';

            $css.='}'; // koniec ggdfigcaption

        }


        $css.='</style>';

        //var_dump($css);
        return $css;

    }


    public static function hex2rgba($color, $opacity = false) {

        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if(empty($color))
            return $default;

        //Sanitize $color if "#" is provided
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
            $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if($opacity){
            if(abs($opacity) > 1)
                $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }

        //Return rgb(a) color string
        return $output;
    }

    /**
     * Dodaje na poczatek heada mootools-core.js
     *
     */
    function addMootols() {
        $head = JFactory::getDocument()->getHeadData();
        $scripts = $head['scripts'];
        $newScripts = array();
        $newScripts['media/system/js/mootools-core.js'] = array('mime'=>'text/javascript', 'defer'=>false, 'async'=>false);
        foreach ($scripts as $key => $value)
        {
            $newScripts[$key] = $value;
        }
        $head['scripts'] = $newScripts;
        JFactory::getDocument()->setHeadData($head);
    }




} // class end


/**
 * Pokazuje album w module
 * 
 * @param array $params
 * @return string|boolean
 */
function modGoldPicasa($params) {

	if ( !isset($params['goldGalleryAlbumId'][10]) ) return '';
	$albumAndUser = explode(',', $params['goldGalleryAlbumId']);

	if ( !isset($albumAndUser[1]) || !is_numeric( $albumAndUser[0] ) )
	{
		JError::raiseWarning('com_goldpicasa', 'Album not found');
		return false;
	}
	$p = GoldpicasaHelper::renderAlbum( $params );
	if (isset($params['goldGalleryIntroText'][3])) {
		echo '<div class="goldGalleryIntroText">'. ( $params['goldGalleryIntroText'] ) . '</div>';
	}
	echo GoldpicasaHelper::renderPlugin($p, $albumAndUser[0]);
	if (isset($params['goldGalleryOutroText'][3])) {
		echo '<div class="goldGalleryOutroText">'. ( $params['goldGalleryOutroText'] ) . '</div>';
	}

}

