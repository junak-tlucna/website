<?php
/**
 * @author 	Tom Konopelski - www.konopelski.info
 * @copyright  	Copyright (C) 2014 goldpicasagallery.konopelski.info. All rights reserved.
 * @license    	GNU General Public License version 2 or later; see LICENSE
 */
defined('_JEXEC') or die('Restricted access');
?>

<div id="content-container">	
			<h1 id="navigate"><a href="index.php?option=com_goldpicasa">Back to the album list</a></h1>
			<div id="photos"></div>
</div>
<link href="/administrator/components/com_goldpicasa/assets/css/picasaViewer.css" type="text/css" rel="stylesheet">
<link href="/administrator/components/com_goldpicasa/assets/css/slimbox.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="/administrator/components/com_goldpicasa/assets/slimbox.js"></script>
<script type="text/javascript" src="/administrator/components/com_goldpicasa/assets/mooToolsPicasaViewer.js?gh=4"></script>
<script>
window.addEvent('domready', function() {

	//viewPhotoList
	var thumbsize	= '160c';
	var imgmax = '1200';
	var albumid = '<?php echo $album; ?>';
	var username= '<?php echo $username; ?>';
	
	var url = 'http://picasaweb.google.com/data/feed/base/user/'+ username +'/albumid/' + albumid +'?category=photo&alt=json&callback=viewPhotoList&thumbsize=' + thumbsize +'&imgmax='+imgmax;
	new Element('script', {'src': url}).inject($('photos'));

	personObj=new Object();
	personObj.url=url;
	
	console.log( personObj );
});
</script>

