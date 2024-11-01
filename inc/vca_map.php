<?php
defined('ABSPATH') or die("No script kiddies please!");

// Generate map for display off of a shortcode
function np_vca_show_map($atts, $content = '') {
  $province_count = 0;
  $vca_map_width = 600;
  $vca_map_height = 400;
  $options = get_option('vca_settings');
  $vca_theme = $options['theme'];
  vca_validate_atts($atts, $vca_map_width, $vca_map_height);
	$vca_show_map_code = '
				<div id="vca_provinces_map">
				<script src="' . vca_ammap_url .'ammap.js" type="text/javascript"></script>
				<script src="' . vca_ammap_url .'maps/canadaLow.js" type="text/javascript"></script>
				<script src="' . vca_ammap_url .'themes/'.$vca_theme.'.js" type="text/javascript"></script>      			
			  <div id="vca_mapdiv" style="width: '.$vca_map_width.'px; height: '.$vca_map_height.'px;"></div>
        			
        			<script type="text/javascript">
           			var map = AmCharts.makeChart("vca_mapdiv",{
                			type: "map",
                theme: "'.$vca_theme.'",
                pathToImages     : "' . vca_ammap_url . 'images/",
                panEventsEnabled : true,
                backgroundColor  : "'.$options['waterColor'].'",
                backgroundAlpha  : 1,

                zoomControl: {
                    panControlEnabled  : true,
                    zoomControlEnabled : true
                },

                dataProvider     : {
                    mapVar          : AmCharts.maps.canadaLow,
										getAreasFromMap:true,
                    areas           : [
										'.vca_fill_provinces().'	
											
                    ]
                },

                areasSettings    : {
                    autoZoom             : false,
                    color                : "'.$options['color'].'",
                    colorSolid           : "'.$options['colorSolid'].'",
                    selectedColor        : "'.$options['selectedColor'].'",
                    outlineColor         : "'.$options['outlineColor'].'",
                    rollOverColor        : "'.$options['rollOverColor'].'",
                    rollOverOutlineColor : "'.$options['rollOverOutlineColor'].'"
                }
            });
        </script>
		</div>';
		$province_count = vca_get_province_count();	
    $total_count = 12;
    $percent_visited = number_format((($province_count/$total_count)*100), 0).'%';
      $content = str_replace('{total}', $total_count, $content);
   		$content = str_replace('{num}', $province_count, $content);
   		$content = str_replace('{percent}', $percent_visited, $content);
   		$content='<div>'.$content.'</div>';
  return $vca_show_map_code.$content;
}

function vca_validate_atts($atts, &$vca_map_width, &$vca_map_height) {
	$vca_atts_width = 0;
	$vca_atts_height = 0;
  if(!empty($atts['width'])) {$vca_atts_width = number_format($atts['width'],0,".","");}
  if(!empty($atts)) {$vca_atts_height = number_format($atts['height'],0,".","");}
  if ($vca_atts_width > 0 ) {$vca_map_width = $vca_atts_width;}
  if ($vca_atts_height > 0) {$vca_map_height = $vca_atts_height;}
  }

// Get provinces from DB and process for Map Display
function vca_fill_provinces() {
   $vprovinces[] = serialize(get_option('vca_provinces'));
	foreach($vprovinces as $key => $province ) {
    $provinces_name = vca_get_province_id($province);
      }
  return $provinces_name;
}

// Create string of provinces for Map Display
	function vca_get_province_id( $name ) {
    	$temp = explode( '"', $name );
		$outString = '';
    	foreach ($temp as $test) {
        $first = substr($test,0,1);
        $second = substr($test,1,1);
        if (ord($first) > 64 && ord($first) < 91 && ord($second) > 64 && ord($second) < 91) {
          $outString = $outString.'	{ id: "'.$test.'", showAsSelected: true }, 
											';
        }
      }
    return $outString;
	}


// Count how many provinces are selected
 function vca_get_province_count() {
   $count = 0;
   $provinces = get_option('vca_provinces');
    if($provinces) {
      $count = count($provinces);
    }
   return $count;
   }

?>