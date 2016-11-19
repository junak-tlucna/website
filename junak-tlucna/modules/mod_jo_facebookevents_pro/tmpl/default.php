<?php
/*------------------------------------------------------------------------
# mod_jo_facebookevents_pro - JO Facebook Events Pro for Joomla 1.6, 1.7, 2.5, 3.x Module
# -----------------------------------------------------------------------
# author: http://www.joomcore.com
# copyright Copyright (C) 2011 Joomcore.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomcore.com
# Technical Support:  Forum - http://www.joomcore.com/Support
-------------------------------------------------------------------------*/

// no direct access

defined('_JEXEC') or die('Restricted access'); 
jimport( 'joomla.html.html');
$jquery = JURI::root().'modules/mod_jo_facebookevents_pro/assets/js/jquery.js';
$eventon_script = JURI::root().'modules/mod_jo_facebookevents_pro/assets/js/eventon_script.js';
$eventon_gen_maps = JURI::root().'modules/mod_jo_facebookevents_pro/assets/js/eventon_gen_maps.js';
$jquery_map = JURI::root().'modules/mod_jo_facebookevents_pro/assets/js/eventon_init_gmap.js';
?>
<?php if($params->get('loadjquery') == 1){?>
	<script type="text/javascript" src="<?php echo $jquery;?>"></script>
<?php 
}
if($params->get('loadscript') == 1){?>
	<script type="text/javascript" src="<?php echo $eventon_script;?>"></script>
	<script type="text/javascript" src="<?php echo $eventon_gen_maps;?>"></script>
	<script src="https://maps.googleapis.com/maps/api/js?sensor=false&ver=1.0" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo $jquery_map;?>"></script>
<?php }?>

<div id="evcal_calendar_<?php echo $module->id?>" class="ajde_evcal_calendar" style="width:<?php echo $params->get('width')?>">
	<div data-accord="0" data-ux_val="00" data-send_unix="1" data-range_end="1400993571" data-range_start="1385856000" data-filters_on="false" data-sort_by="sort_date" data-ev_cnt="5" data-mapzoom="14" data-mapformat="roadmap" data-mapscroll="true" data-cal_ver="2.2.11" data-evc_open="0" data-runajax="1" data-cmonth="12" data-cyear="2013" class="evo-data"></div>
	<div id="evcal_list" class="eventon_events_list">
		<?php 
		
		if($params->get('max') != ""){
			if(count($fbevents['data']) > $params->get('max')) {
				$limit = $params->get('max');
			}else{
				$limit = count($fbevents['data']);
			}
		}else{
			$limit = count($fbevents['data']);
		}
		
		$fbevents['data'] = array_reverse($fbevents['data']);
		//for($i=$limit-1; $i>=0;$i--){
		$e = 1;
		for($i=0; $i<count($fbevents['data']);$i++){
			$fbevent=& $fbevents['data'][$i];
			if(count($fbevent >0)){
				
				if($params->get('upcomingevents') == 1){
					if($fbevent["end_time"] !=""){
						$fb_ev_endtime = intval(date('Ymd', strtotime($fbevent["end_time"])));
					}else{
						$fb_ev_endtime = intval(date('Ymd', strtotime($fbevent["start_time"])));
					}					
					$datenow = intval(date('Ymd'));	
					
				}else{
					$fb_ev_endtime = 1;
					$datenow = 1;
				}
				
				//var_dump($datenow);		
				if($fb_ev_endtime >=$datenow){		
								
		?>
		<?php
		if($e <=$limit){
		$cover = modJoFacebookEventsPro::CoverEvent($params, $fbevent["id"]);
		$image_cover = $cover['cover']['source'];		
		?>
				<div id="event_<?php echo $module->id.$fbevent['id']?>" class="eventon_list_event" event_id="<?php echo $module->id.$fbevent['id']?>" itemscope="" itemtype="http://www.facebook.com/events/<?php echo $fbevent["id"]?>">
					<div class="evo_event_schema" style="display:none">
						<a href="http://www.facebook.com/events/<?php echo $fbevent["id"]?>" itemprop="url"></a>				
						<time itemprop="startDate" datetime="<?php echo  date('Y-m-d', strtotime($fbevent["start_time"]))?>"></time>
						<item style="display:none" itemprop="location" itemscope="" itemtype="">
							<span itemprop="address" itemscope="" itemtype="">
								<item itemprop="streetAddress"><?php echo $fbevent["location"]?></item>
							</span>
						</item>						
					</div>
					<?php
					if($params->get('popupevent')==0){
					?>									
					<div id="evc_<?php echo $module->id.$fbevent['id']?>" class="evcal_list_a desc_trig mul_val  evo_business-casual" data-exlk="0" style="border-color: <?php echo 'rgb('.rand(128,255).','.rand(128,255).','.rand(128,255).')'?>" data-gmtrig="1" data-ux_val="1">
					<?php }else{?>	
					<a id="evc_<?php echo $module->id.$fbevent['id']?>" data-ux_val="3" data-gmtrig="1" style="border-color: <?php echo 'rgb('.rand(128,255).','.rand(128,255).','.rand(128,255).')'?>" data-exlk="0" class="evcal_list_a desc_trig sin_val  evo_formal">
					<?php }?>		
						<p class="evcal_cblock" style="background-color:#cc9046" smon="march" syr="2014">
							<em class="evo_date"><?php echo  date('d', strtotime($fbevent["start_time"]))?><span><?php if($fbevent["end_time"] !=""){?> - <?php echo  date('d', strtotime($fbevent["end_time"]))?><?php }?></span></em>
							<em class="evo_month" mo="mar"><?php echo  date('M', strtotime($fbevent["start_time"]))?></em>
							<em class="clear"></em>							
						</p>
						
						<p class="evcal_desc" add_str="<?php echo $fbevent["location"]?>" data-location_name="Kngston Town">
							<span class="evcal_desc2 evcal_event_title" itemprop="name"><?php echo $fbevent['name']?></span>
							<span class="evcal_desc_info">
								<em class="evcal_time"><?php echo  date($params->get('dateformat'), strtotime($fbevent["start_time"]))?><?php if($fbevent["end_time"] !=""){?> - <?php echo  date($params->get('dateformat'), strtotime($fbevent["end_time"]))?><?php }?></em> 
								<em class="evcal_location" add_str="<?php echo $fbevent["location"]?>"><?php echo $fbevent["location"]?></em>								
							</span>
															
						</p>	
					<?php
					if($params->get('popupevent')==0){
					?>									
					</div>
					<?php }else{?>	
					</a>
					<?php }?>						
						
					<div class="event_description evcal_eventcard" style="display:none">							
						<?php if($image_cover !=''){?>
						<div class="evorow evcal_evdata_img evo_metarow_fimg imghover imgCursor" imgheight="200" imgwidth="700" style="background-image: url(<?php echo $image_cover;?>)"></div>
						<?php }?>
						<div class="evorow evcal_evdata_row bordb evcal_event_details">
							<div class="event_excerpt" style="display:none">
								<h3 class="padb5 evo_h3"><?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_EVENT_DETAILS')?></h3><p></p>								
							</div>
							<span class="evcal_evdata_icons">
								<i class="fa fa-align-justify"></i>								
							</span>
							<div class="evcal_evdata_cell shorter_desc">
								<div class="eventon_details_shading_bot">
									<p content="less" class="eventon_shad_p"><span txt="<?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_LESS')?>" class="ev_more_text"><?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_MORE')?></span><span class="ev_more_arrow"></span></p>
								</div>
								<div class="eventon_full_description">
									<h3 class="padb5 evo_h3"><?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_EVENT_DETAILS')?></h3>
									<div class="eventon_desc_in" itemprop="description">
										<p>
											<?php
											$data_detail = modJoFacebookEventsPro::detail_event($params, $fbevent["id"]);
											echo $data_detail['description'];												
										?>
										</p>
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
						<div class="evorow bordb evo_metarow_time_location">
							<div class="tb">
								<div class="tbrow">
									<div class="evcal_col50 bordr">
										<div class="evcal_evdata_row evo_time">
											<span class="evcal_evdata_icons"><i class="fa fa-clock-o"></i></span>
											<div class="evcal_evdata_cell">							
												<h3 class="evo_h3"><?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_TIME')?></h3><p><?php echo  date($params->get('dateformat'), strtotime($fbevent["start_time"]))?><?php if($fbevent["end_time"] !=""){?> - <?php echo  date($params->get('dateformat'), strtotime($fbevent["end_time"]))?><?php }?></p>
											</div>
										</div>
									</div>
									<div class="evcal_col50">
										<div class="evcal_evdata_row evo_location">
											<span class="evcal_evdata_icons">
												<i class="fa fa-map-marker"></i>											
											</span>
											<div class="evcal_evdata_cell">							
												<h3 class="evo_h3"><?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_LOCATION')?></h3>										
												<p><?php echo $fbevent["location"]?></p>
											</div>
										</div>
									</div>
									<div class="clear"></div>
								</div>							
							</div>
						</div>
						<?php if($fbevent["location"] !=''){?>
							<div class="evorow evcal_gmaps bordb" id="evc<?php echo $module->id.$fbevent['id'];?>_gmap"></div>							
							<div class="evorow evcal_evdata_row bordb evcal_evrow_sm getdirections">
								<form action="http://maps.google.com/maps" method="get" target="_blank">
									<input name="daddr" value="<?php echo $fbevent["location"]?>" type="hidden"> 
									<p>
										<input class="evoInput" name="saddr" placeholder="<?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_GET_DIRECTIONS')?>" type="text">
										<button type="submit" class="evcal_evdata_icons evcalicon_9" title="Click here to get directions"><i class="fa fa-road"></i></button>
									</p>						
								</form>
							</div>
						<?php }?>
						<div class="evorow bordb">
							<a target="_blank" href="http://www.facebook.com/events/<?php echo $fbevent["id"]?>" class="evo_ics evcal_evdata_row evo_clik_row dark1">
								<span class="evcal_evdata_icons"><i class="fa fa-calendar-o"></i></span>													
								<h3 class="evo_h3"><?php echo JText::_('MOD_JO_FACEBOOKEVENTS_PRO_SEE_THIS_EVENT')?></h3>
							</a>
							<div class="evcal_evdata_row evcal_close" title="Close"></div>					
						</div>				
					</div>
					<div class="clear"></div>			
				</div>
				<div class="clear"></div>					
	<?php 
			$e++;
			}
		}
	}
	}
	?>	
	</div>	
	<div class="clear"></div>
</div>	

			