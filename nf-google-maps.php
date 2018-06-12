<?php if ( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Ninja Forms - Google Maps
Plugin URI: https://rlaurent.com
Description: Google Maps add-on for Ninja Forms.
Version: 1.0.0
Author: Romain Laurent
Author URI: https://rlaurent.com
*/

/**
 * Vars
 */
define( 'NF_GOOGLE_MAPS_VERSION', '1.0.0' );
define( 'NF_GOOGLE_MAPS_AUTHOR', 'Romain Laurent' );

/**
 * Include the dependencies needed to instantiate the plugin.
 */
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
    include_once $file;
}

/**
 * Create the admin page.
 */
function nf_google_maps_custom_admin_settings() {
    $plugin = new NF_Google_Maps_Submenu( new NF_Google_Maps_Submenu_Page() );
    $plugin->init();
}
add_action( 'plugins_loaded', 'nf_google_maps_custom_admin_settings' );

/**
 * Add Google Maps API Places with Key
 */
function nf_google_maps_scripts() {
    wp_enqueue_script( 'google_maps_js', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCd4goTP3cAVKbIgn4OOUqz7ucDmekfwKI&libraries=places', '', '' );
}
add_action( 'wp_enqueue_scripts', 'nf_google_maps_scripts' );


/**
 * Register our template
 */
function nf_google_maps_template_file_path( $paths ){
    //look for our templates in the same directory as the plugin
    $paths[] = trailingslashit( __DIR__ . "/templates" );
    return $paths;
}
add_filter( 'ninja_forms_field_template_file_paths', 'nf_google_maps_template_file_path' );

/**
* Register our field
*/
function nf_google_maps_register_fields($actions){
    $actions[ 'google-maps' ] = new NF_Google_Maps();
    return $actions;
}
add_filter( 'ninja_forms_register_fields', 'nf_google_maps_register_fields');

/**
 * Get base classes from ninja-forms
 */
require_once plugin_dir_path( __FILE__ ) . "../ninja-forms/includes/Abstracts/Field.php";
require_once plugin_dir_path( __FILE__ ) . "../ninja-forms/includes/Abstracts/Input.php";
require_once plugin_dir_path( __FILE__ ) . "../ninja-forms/includes/Fields/Textbox.php";

/**
 * Class NF_Google_Maps
 */
class NF_Google_Maps extends NF_Fields_Textbox {
    protected $_name = 'google-maps';
    protected $_section = 'common'; // which drawer to place field
    protected $_icon = 'map-o'; // name of a Font Awesome ICON
    protected $_type = 'google-maps';
    protected $_templates = 'google-maps'; // which template to use

    public function __construct() {
        parent::__construct();
        $this->_nicename = __( 'Google Maps Address', 'ninja-forms' ); //Nice name for the field
    }
}

