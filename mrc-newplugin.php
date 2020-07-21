<?php
/**
 * Plugin Name:       Mrc New Plugin
 * Plugin URI:        https://www.mar.co.it/
 * Description:       Questo è il mio primo plugin.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Marco M
 * Author URI:        https://www.mar.co.it/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       mrc-new-plugin
 * Domain Path:       /languages
 */


function mrc_adding_script_pluginside() {
    wp_enqueue_script( 'mrcscriptplugin', plugin_dir_url( __FILE__ ) . 'js/mrcscriptplugin.js', array( 'jquery', 'jquery-ui-accordion'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'mrc_adding_script_pluginside' );  
