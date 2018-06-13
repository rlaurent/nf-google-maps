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
 * Create the Ninja forms settings page.
 */
function nf_google_maps_settings( $settings ) {
    $settings[ 'nf-google-maps' ] = array(
        'google_maps_api_key' => array(
            'id'    => 'google_maps_api_key',
            'type'  => 'textbox',
            'label'  => __( 'Google Maps API Key', 'nf-google-maps' ),
            'desc'  => __( 'Enter your Google Maps API Key. Make sure to enable Places API.', 'nf-google-maps' ),
        ),
    );
    return $settings;
}
add_filter( 'ninja_forms_plugin_settings', 'nf_google_maps_settings', 10, 1 );

function nf_google_maps_settings_groups( $groups ) {
    $groups[ 'nf-google-maps' ] = array(
        'id' => 'nf-google-maps',
        'label' => __( 'Ninja Forms Google Maps Extension', 'nf-google-maps' ),
    );
    return $groups;
}
add_filter( 'ninja_forms_plugin_settings_groups', 'nf_google_maps_settings_groups', 10, 1 );

function save_google_maps_api_key( $setting_value ) {
    if( strpos( $setting_value, '_' ) ){
        $parts = explode( '_', $setting_value );
        foreach( $parts as $key => $value ){
            Ninja_Forms()->update_setting( 'nfgm_' . $key, $value );
        }
    }
}
add_action( 'ninja_forms_save_setting_google_maps_api_key',  'save_google_maps_api_key', 10, 1 );

/**
 * Add Google Maps API Places with Key
 */
function nf_google_maps_scripts() {
    $google_maps_api_key = Ninja_Forms()->get_setting( 'google_maps_api_key' );
    
    wp_enqueue_script( 'google_maps_js', 'https://maps.googleapis.com/maps/api/js?key='.$google_maps_api_key.'&libraries=places', array(), '1.0.0', true );
    wp_enqueue_script( 'nf_google_maps', plugin_dir_url( __FILE__ ) . '/js/nf-google-maps.js', array(), '1.0.0', true );
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

