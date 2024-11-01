<?php
/*
Plugin Name: Visited Provinces
Plugin URI: http://www.p3ck.us/visit_canada/
Description: Utilizes AMMap to keep track of visited Canadaian Provinces and displays a map via shortcode.
Version: 1.0.1
Author: Nic P
Author URI: http://www.p3ck.us
License: 
License URI: 
*/

defined('ABSPATH') or die("No script kiddies please!");
define('vca_plugin_path', plugin_dir_path(__FILE__)); 
define('vca_ammap_url', plugins_url( "ammap/", __FILE__ ));
require_once vca_plugin_path . 'inc/vca_settings_page.php';
require_once vca_plugin_path . 'inc/vca_provinces_page.php';
require_once vca_plugin_path . 'inc/vca_map.php';

add_action( 'admin_init', 'register_vca_settings' );
add_action( 'admin_menu', 'np_vca_settings_menu' );
add_shortcode('visited_provinces', 'np_vca_show_map');

register_activation_hook( __FILE__,  'np_vca_activate'  );
register_deactivation_hook( __FILE__, 'np_vca_deactivate' ) ;
register_uninstall_hook( __FILE__,  'np_vca_uninstall'  );

function register_vca_settings() {
	register_setting( 'vca_visited_provinces', 'vca_provinces' );
  register_setting( 'vca_settings', 'vca_settings', 'vca_settings_validate' );
  add_settings_section('vca_settings_main', 'Canada Settings', 'vca_settings_callback', 'vca_settings_section');
  add_settings_field('vca_theme', 'Theme', 'vca_setting_theme', 'vca_settings_section', 'vca_settings_main');
  add_settings_field('vca_waterColor', 'Water Color', 'vca_setting_waterColor', 'vca_settings_section', 'vca_settings_main');
  add_settings_field('vca_color', 'Unvisited Color', 'vca_setting_color', 'vca_settings_section', 'vca_settings_main');
  add_settings_field('vca_selectedColor', 'Visited Color', 'vca_setting_selectedColor', 'vca_settings_section', 'vca_settings_main');
  add_settings_field('vca_outlineColor', 'Outline Color', 'vca_setting_outlineColor', 'vca_settings_section', 'vca_settings_main');
  add_settings_field('vca_rollOverColor', 'Roll Over Color', 'vca_setting_rollOverColor', 'vca_settings_section', 'vca_settings_main');
  add_settings_field('vca_rollOverOutlineColor', 'Roll Over Outline Color', 'vca_setting_rollOverOutlineColor', 'vca_settings_section', 'vca_settings_main');
} 

// Add options to DB on activate
function np_vca_activate(){
   add_option('vca_provinces' );
   add_option('vca_settings' );
}

function np_vca_deactivate(){

}

// Delete options from DB on uninstall
function np_vca_uninstall(){
	delete_option('vca_provinces');
  delete_option('vca_settings');
}

// Create options page
function np_vca_settings_menu() {
  add_menu_page( 'Visited Provinces', 'Visited Provinces', 'manage_options', 'vca-settings', '' );
	add_submenu_page( 'vca-settings', 'Settings', 'Settings', 'manage_options', 'vca-settings', 'vca_settings_page' );
  add_submenu_page( 'vca-settings', 'Provinces', 'Provinces', 'manage_options', 'vca-visited-provinces', 'vca_provinces_page' );
}

// Add settings link on plugin page
	$plugin = plugin_basename(__FILE__); 
	add_filter("plugin_action_links_$plugin", 'vca_plugin_settings_link' );

	// Return link for settings page
	function vca_plugin_settings_link($links) { 
  	$settings_link = '<a href="admin.php?page=vca-settings">Settings</a>'; 
  	array_unshift($links, $settings_link); 
  	return $links; 
	}

?>