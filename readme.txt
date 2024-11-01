=== Plugin Name ===
Contributors: pcsforme
Donate link: http://www.p3ck.us/
Tags: canada, provinces, ammap, visited, visit, map, travel, travels
Requires at least: 4.0
Tested up to: 4.0
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Uses amMap's JavaScript maps to display a map of visited places via shortcode.

== Description ==

Uses amMap's JavaScript maps to display a map of visited places via shortcode.

Use [visited_provinces] to display your map. 

You can also add text and close the shortcode while using the following fields:
{num}, {total}, {percent}

i.e. [visited_provinces width="500" height="500"]I have visited {num} of {total} provinces! That is {percent} of the country![/visited_provinces]


== Installation ==

1. Upload `np_visited_provinces` folder to your current plugin directory (i.e. `/wp-content/plugins/` if you haven't changed them)
1. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= Can I change the size of the map? =

Yes, just pass in the width and height values when you call the shortcode. i.e. [visited_provinces width="1000" height="600"]

= What colors can I use? =

You can use any valid HEX color code or even try entering a common color name. If I've added it to the plugin it will automatically
change it to the correct HEX code and save it. Don't worry if you get one wrong, it will just go back to the default color. 

I've added a preview of the map to the settings screen so you can immediately see your color changes!

== Screenshots ==

1. Preview of the map.
1. Preview of the settings screen.
1. Preview of the screen to choose which ones you have visited. 


== Changelog ==

= 1.0.1 =
* Added settings page

= 1.0.0 =
* First Draft

== Upgrade Notice ==

= 1.0.1 =
Provides more functionality. 