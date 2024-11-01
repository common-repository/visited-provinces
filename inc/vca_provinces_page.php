<?php
defined('ABSPATH') or die("No script kiddies please!");

// Create settings page for users to select provinces they have visited
function vca_provinces_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
		echo '<div class="wrap">';
  	$s_content = '{num} Visited';
  	$s_atts = array('height'=>'300','width'=>'400');
  	echo np_vca_show_map($s_atts, $s_content);
		echo '<h2>Visited provinces</h2>';
        echo '';
  			echo 'Select each province that you have visited and hit Save Changes';
        echo '<form method="post" action="options.php">'; 
        settings_fields( 'vca_visited_provinces' );
        do_settings_sections( 'vca_visited_provinces' );
		$options = get_option('vca_provinces');
  
  
		echo '<table><th>US provinces</th><tr>';
    echo vca_checkboxes($options); 
    echo '</table>';
        submit_button();
	echo '</form>';
	echo '</div>';
}

function vca_checkboxes(&$options) {
  $vca_provinces = array('CA-AB','CA-BC','CA-MB','CA-NB','CA-NL','CA-NS','CA-NT','CA-NU','CA-ON','CA-PE','CA-QC','CA-SK','CA-YT');
  $i = 0;
  $output = '';
   foreach ($vca_provinces as $province) {   
     
    if($i >= 5) {
      $output=$output.'<tr>';
      $i = 0;
    } 
     $output=$output.vca_build_checkbox($province, $options);
     $i++;
     }
    return $output;
  }

function vca_build_checkbox($id, &$options) {
    	$crlf = chr(13).chr(10);
      $qt = chr(34);
     	if($options[$id] <> '') {
        $c = checked( 1, $options[$id], false );
      }
      $name = return_province_name($id);
			$s = "<td><input type=".$qt."checkbox".$qt." id=".$qt."provinces".$qt." name=".$qt."vca_provinces[$id]".$qt." value=".$qt."1".$qt." $c/>$name</td>";
    return $s.$crlf;
    }

function return_province_name($id) {
			$provinces = array('CA-AB'=>'Alberta',
								'CA-BC'=>'British Columbia',
								'CA-MB'=>'Manitoba',
								'CA-NB'=>'New Brunswick',
								'CA-NL'=>'Newfoundland and Labrador',
								'CA-NS'=>'Nova Scotia',
								'CA-NT'=>'Northwest Territories',
								'CA-NU'=>'Nunavut',
								'CA-ON'=>'Ontario',
								'CA-PE'=>'Prince Edward Island',
								'CA-QC'=>'Quebec',
								'CA-SK'=>'Saskatchewan',
								'CA-YT'=>'Yukon Territory');
    $name = $provinces[$id];
			return $name;
		}


?>