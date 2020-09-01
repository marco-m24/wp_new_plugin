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







// Funzione creazione Custom Post
function mrc_create_posttype() {
 
    register_post_type( 'libri',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Libri' ),
                'singular_name' => __( 'Libro' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'libri'),
            'show_in_rest' => true,
 
        )
    );
}
// Hook funzione
add_action( 'init', 'mrc_create_posttype' );







// Creazione del Custom Field

function custom_meta_box_markup($post)
{
    ?>
    <div>
        <label for="meta-box-text">Text</label>
        <input name="meta-box-text" type="text" value="<?php echo get_post_meta($post->ID, "meta-box-text", true); ?>">
    </div>
    <?php
}

function add_custom_meta_box()
{
    add_meta_box("custom-meta-box", "Editore", "custom_meta_box_markup", "libri", "normal");
}

add_action("add_meta_boxes", "add_custom_meta_box");






// Salvataggio del custom field

function save_custom_meta_box($post_id, $post)
{
    if(!current_user_can("edit_post", $post_id))
        return $post_id;

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE)
        return $post_id;

    $slug = "libri";
    if($slug != $post->post_type)
        return $post_id;

    $meta_box_text_value = "";

    if(isset($_POST["meta-box-text"])) {
        $meta_box_text_value = $_POST["meta-box-text"];
    }
    update_post_meta($post_id, "meta-box-text", $meta_box_text_value);

}

add_action("save_post", "save_custom_meta_box", 10, 2);







add_action( 'init', 'mrc_create_genere_hierarchical_taxonomy', 0 );
 
//creiamo la custom taxonomy e la chiamiamo genere per i nostri libri
 
function mrc_create_genere_hierarchical_taxonomy() {
 
// Add new taxonomy, make it hierarchical like categories
//first do the translations part for GUI
 
  $labels = array(
    'name' => _x( 'Genere', 'taxonomy general name' ),
    'singular_name' => _x( 'Genere', 'taxonomy singular name' ),
    'search_items' =>  __( 'Cerca Genere' ),
    'all_items' => __( 'Tutti i Generi' ),
    'parent_item' => __( 'Genere Genitore' ),
    'parent_item_colon' => __( 'Genere Genitore:' ),
    'edit_item' => __( 'Edita Genere' ), 
    'update_item' => __( 'Aggiorna Genere' ),
    'add_new_item' => __( 'Aggiungi nuovo Genere' ),
    'new_item_name' => __( 'Nuovo Genere Nome' ),
    'menu_name' => __( 'Generi' ),
  );    
 
// Now register the taxonomy
 
  register_taxonomy('genere',array('libri'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'genere' ),
  ));
 
}








function mrc_get_single_custom_post_type_template( $single_template ) {
  global $post;

  if ( 'libri' === $post->post_type ) {
    $single_template = plugin_dir_path( __FILE__ ) . 'mrc-single-libri-template.php';
  }

  return $single_template;
}
add_filter( 'single_template', 'mrc_get_single_custom_post_type_template' );






function mrc_get_archive_custom_post_type_template( $archive_template ) {
     global $post;

     if ( is_post_type_archive ( 'libri' ) ) {
          $archive_template = plugin_dir_path( __FILE__ ) . 'mrc-archive-single-libri-template.php';
     }
     return $archive_template;
}

add_filter( 'archive_template', 'mrc_get_archive_custom_post_type_template' ) ;
?>
