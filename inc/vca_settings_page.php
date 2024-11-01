<?php
defined('ABSPATH') or die("No script kiddies please!");

// Create settings page for users to select the settings they want
function vca_settings_page() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
				echo '<div>';
        echo '<form method="post" action="options.php">'; 
        settings_fields( 'vca_settings' );
        do_settings_sections( 'vca_settings_section' );
				
        submit_button();
	echo '</form>';
	echo '</div>';
}

function vca_settings_callback(){
  // echo section intro text here
  $s_content = '{num} Visited';
  $s_atts = array('height'=>'300','width'=>'400');
  echo np_vca_show_map($s_atts, $s_content);
	echo '<p>Visited Provinces Settings</p>';
  echo 'Enter either HEX codes or common color names.<br>';
	echo 'If the color name is found it will convert it to the HEX code.<br>';
  echo 'If an invalid HEX code is entered or the color name is not found it will change back to the default color.';
  }

function vca_setting_theme() {
$options = get_option('vca_settings');
  echo '<select name="vca_settings[theme]">';
	$themes = array('dark','light','black','chalk'); 
  foreach ($themes as $t) {
    vca_drop_down_entry($t, $options);
  }
	echo '</select>';
} 

// Create Drop Down Entry for provided name
function vca_drop_down_entry($name, &$options){
  if($options['theme'] == $name) {$selected = 'selected="selected"';}
  echo '<option value="'.$name.'" '.$selected.'>'.ucfirst($name).'</option>';
}

function vca_setting_waterColor() {
	vca_build_input_box('waterColor');
} 

function vca_setting_color() {
	vca_build_input_box('color');
} 

function vca_setting_colorSolid() {
	vca_build_input_box('colorSolid');
} 

function vca_setting_selectedColor() {
	vca_build_input_box('selectedColor');
}  

function vca_setting_outlineColor() {
	vca_build_input_box('outlineColor');
}  

function vca_setting_rollOverColor() {
	vca_build_input_box('rollOverColor');
}  

function vca_setting_rollOverOutlineColor() {
	vca_build_input_box('rollOverOutlineColor');
}

//Build an input box from setting name
function vca_build_input_box($name){
  $options = get_option('vca_settings');
  echo "<input id='$name' name='vca_settings[$name]' size='10' type='text' value='{$options[$name]}' />";
}

function vca_settings_validate($input) {
	$colors = array('waterColor','color','selectedColor','outlineColor','rollOverColor','rollOverOutlineColor');
	$options = get_option('vca_settings');
  foreach ($colors as $item) {
  	$options[$item] = vca_validate_color($item, $input);  
  }
	$options['theme'] = vca_validate_theme(trim($input['theme']));
	return $options;
}

function vca_validate_theme($theme){
     $themes = array('dark','light','black','chalk');
  if (in_array($theme, $themes)) {
    	return $theme;
    } else {
    	return vca_get_default('theme');
    }
}

function vca_validate_color($txt, $input){
  $input[$txt] = trim($input[$txt]);
  if(vca_validate_hex( $input[$txt] ) ) {
							return strtoupper( $input[$txt] );
						} else {
						return vc_replace_color_name($input[$txt], $txt);
              }
  }

function vca_validate_hex($color){
  if( empty( $color ) ) return true;
			return preg_match( '/^\#?[A-Fa-f0-9]{3}([A-Fa-f0-9]{3})$/', $color );
  }

function vca_get_default($txt) {
  $vca_defaults = array('theme'=>'dark',
								'waterColor'=>'#535364',
								'color'=>'#CDCDCD',
								'colorSolid'=>'#5EB7DE',
								'outlineColor'=>'#666666',
								'rollOverColor'=>'#88CAE7',
								'rollOverOutlineColor'=>'#000000');
  	return $vca_defaults[$txt];
  }

function vca_replace_color_name($c, $txt) {
  	$colors = array('aqua'=>'#00FFFF','black'=>'#000000','blue'=>'#0000FF','brown'=>'#A52A2A','fuchsia'=>'#FF00FF','gold'=>'#FFD700',
										'gray'=>'#808080','green'=>'#008000','lime'=>'#00FF00','maroon'=>'#800000','navy'=>'#000080','olive'=>'#808000',
										'orange'=>'#FFA500','pink'=>'#FFC0CB','purple'=>'#800080','red'=>'#FF0000','silver'=>'#C0C0C0','tan'=>'#D2B48C',
                    'teal'=>'#008080','violet'=>'#EE82EE','white'=>'#FFFFFF','yellow'=>'#FFFF00');
   if ($colors[$c] == null) {
     	return vca_get_default($txt);
     } else {
     	return $colors[$c];
     }
  }

?>