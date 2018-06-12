<?php if ( ! defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Ninja Forms - Google Maps
Plugin URI: https://rlaurent.com
Description: Google Maps add-on for Ninja Forms.
Version: 1.0.0
Author: Romain Laurent
Author URI: https://rlaurent.com
*/

// Some define
define( 'NF_GOOGLE_MAPS_VERSION', '1.0.0' );
define( 'NF_GOOGLE_MAPS_AUTHOR', 'Romain Laurent' );

// Include the dependencies needed to instantiate the plugin.
foreach ( glob( plugin_dir_path( __FILE__ ) . 'admin/*.php' ) as $file ) {
    include_once $file;
}

// Create the admin setting page
add_action( 'plugins_loaded', 'nf_google_maps_custom_admin_settings' );
/**
 * Starts the plugin.
 *
 * @since 1.0.0
 */
function nf_google_maps_custom_admin_settings() {
    $plugin = new NF_Google_Maps_Submenu( new NF_Google_Maps_Submenu_Page() );
    $plugin->init();
}

// Add filter for ninja-forms
add_filter( 'ninja_forms_field_template_file_paths', 'nf_google_maps_template_file_path' );
add_filter( 'ninja_forms_register_fields', 'nf_google_maps_register_fields');

/**
 * Register our template
 * 
 * @param  array
 * @return array
 */
function nf_google_maps_template_file_path( $paths ){
    //look for our templates in the same directory as the plugin
    $paths[] = trailingslashit( __DIR__ . "/templates" );
    return $paths;
}

/**
* Register our field
*
* @param array $actions
* @return array
*/
function nf_google_maps_register_fields($actions){
    $actions[ 'ninjaformsgooglemaps' ] = new NF_Google_Maps();
    return $actions;
}

// Get base classes from ninja-forms
require_once plugin_dir_path( __FILE__ ) . "../ninja-forms/includes/Abstracts/Field.php";
require_once plugin_dir_path( __FILE__ ) . "../ninja-forms/includes/Abstracts/Input.php";
require_once plugin_dir_path( __FILE__ ) . "../ninja-forms/includes/Fields/Textbox.php";

/**
 * Class NF_Google_Maps
 */
class NF_Google_Maps extends NF_Fields_Textbox {
    protected $_name = 'ninjaformsgooglemaps';
    protected $_section = 'common'; // which drawer to place field
    protected $_icon = 'map-o'; // name of a Font Awesome ICON
    protected $_type = 'ninjaformsgooglemaps';
    protected $_templates = 'ninjaformsgooglemaps'; // which template to use
    public function __construct() {
        parent::__construct();
        $this->_nicename = __( 'Google Maps Address', 'ninja-forms' ); //Nice name for the field
    }
}





