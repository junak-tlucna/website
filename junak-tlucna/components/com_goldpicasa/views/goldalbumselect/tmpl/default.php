<?php 
/**
* @author 	Tom Konopelski - www.konopelski.info
* @copyright  	Copyright (C) 2014 goldpicasagallery.konopelski.info. All rights reserved.
* @license    	GNU General Public License version 2 or later; see LICENSE
*/
defined('_JEXEC') or die;
?>

<?php
$boxClassName='goldGalleryImgContainer';
if ($this->theme==='box') {
    echo GoldpicasaHelper::getBoxCss( $this->compParams );
    $boxClassName='ggdfigure  cap-bot';
}
?>

<?php echo $this->goldGalleryIntroText; ?>
<div id="goldGalleryMainDiv">
<?php 
if ( isset( $this->params['goldGalleryWelcomeTitle'][2] ) ) {
?>
<h1><?php echo $this->params['goldGalleryWelcomeTitle']; ?></h1>
<?php 
}
?>
<?php 
$albumThumbnailSize = intval( $this->params['goldGalleryAlbumThumbnailSize'] );
$goldGalleryAlbumsBorderType = $this->params['goldGalleryAlbumsBorderType'] ;

$imgStyle='';

if ($this->params['goldGalleryAlbumsBorderType']==='0') {
	$imgStyle.='border:0;';
}
if ($this->params['goldGalleryAlbumsBorderType']==='1') {
	$imgStyle.='border:1px solid '. $this->params['goldGalleryAlbumsBorderColor'] .';padding:0;';
}
if ($this->params['goldGalleryAlbumsBorderType']>'1') {
	$imgStyle.='border:1px solid '. $this->params['goldGalleryAlbumsBorderColor'] .';padding:'.($this->params['goldGalleryAlbumsBorderType']*2).'px;';
}
if ($this->params['goldGalleryAlbumsBackgroundColor']) {
	$imgStyle.='background-color:'. $this->params['goldGalleryAlbumsBackgroundColor'] .';';
}

$width = $albumThumbnailSize + 2 + ( intval($this->params['goldGalleryAlbumsBorderType'])*4);
$height =  $albumThumbnailSize + ( ($this->params['goldGalleryShowAlbumNameAlbumList']==1) ? 38 : 2 );

foreach ($this->albums as $album) {

	$album['thumb'] = str_replace('s104-c', 's'.$albumThumbnailSize.'-c', $album['thumb']);
    $style=' style="width:'.$width.'px;height:'.$height.'px;margin-right:'.$this->params['goldGalleryThumbnailMargin'].'px;margin-bottom:'.$this->params['goldGalleryThumbnailMargin'].'px;"  ';
	
	echo '<div title="'.htmlentities($album['title']).'" class="'.$boxClassName.'" '.$style.'>';
	echo '<a title="" href="' . JRoute::_('index.php?option=com_goldpicasa&amp;view=goldpicasa&amp;Itemid='.$this->itemId.'&amp;album='.$album['id'].'&amp;userId='.$album['userId'] ) .'">';
	echo '<img style="'. $imgStyle .'" src="'.$album['thumb'].'" alt="" class="gpgImgThemebox" />';

    if ($this->theme==='box' AND $this->params['goldGalleryShowAlbumNameAlbumList'] === '1' ) {
        echo '<span class="ggdfigcaption">';
        echo '<span class="ggdAlbumtitle">'.$album['title'].'</span>';
        echo '</span>';
    }

	echo '</a>';

    if ($this->theme!='box') {
        if ( $this->params['goldGalleryShowAlbumNameAlbumList'] == 1 ) {
            echo '<span>'.$album['title'].'</span>';
        }
    }

	//echo '<div></div>';
	echo '</div>';
}
?>
</div>
<br style="clear: both;">
<?php echo $this->goldGalleryOutroText; ?>
<script>
var myFxGpgOptions = { offset: {'x': 0, 'y': -15} };
var myFx = new Fx.Scroll(window, myFxGpgOptions);
</script>
