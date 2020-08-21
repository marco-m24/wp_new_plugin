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
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'mrcscriptplugin', plugin_dir_url( __FILE__ ) . 'js/mrcscriptplugin.js', array( 'jquery', 'jquery-ui-accordion', 'wp-color-picker'), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'mrc_adding_script_pluginside' ); 





function mrc_myplugin_register_settings() {
   add_option( 'mrc_myplugin_option_name', 'Valore della option.');
   register_setting( 'myplugin_options_group', 'mrc_myplugin_option_name', 'myplugin_callback' );
}
add_action( 'admin_init', 'mrc_myplugin_register_settings' );





function mrc_myplugin_register_options_page() {
  add_options_page('Titolo', 'Mrc New Plugin', 'manage_options', 'myplugin', 'myplugin_options_page');
}
add_action('admin_menu', 'mrc_myplugin_register_options_page');





function myplugin_options_page()
{
?>
  <div>
  <h1>Titolo della pagina</h1>
  <form method="post" action="options.php">
  <?php settings_fields( 'myplugin_options_group' ); ?>
  <h3>Titolo delle opzione</h3>
  <p>Qui puoi inserire una descrizione di cosa farà questa opzione.</p>
  <table>
  <tr valign="top">
  <th scope="row"><label for="mrc_myplugin_option_name">Option 1</label></th>
  <td><input type="text" id="mrc_myplugin_option_name" name="mrc_myplugin_option_name" class="my-color-field" value="<?php echo get_option('mrc_myplugin_option_name'); ?>" /></td>
  </tr>
  </table>
  <?php  submit_button(); ?>
  </form>
  </div>
<?php
}





add_action( 'wp_body_open', 'mrc_add_custom_body_open_code' );
 
function mrc_add_custom_body_open_code() {
    echo '<h1>'.get_option('mrc_myplugin_option_name').'</h1>';
}






function mrc_more_comments( $post_id ) {
  echo '<p>'.get_option('mrc_myplugin_option_name').'</p>';
}

add_action( 'comment_form', 'mrc_more_comments' );

?>
