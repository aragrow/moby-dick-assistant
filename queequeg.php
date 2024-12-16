<?php
/*
Plugin Name: Queequeg
Description: Your friendly Moby Dick assistant.
Version: 1.1
Author: David Arago - ARAGROW, LLC
Author URI: https://aragrow.me
*/

// Ensure the genai library is installed and the gemini-pro-vision model is accessible.

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

// Define a constant for the plugin's base directory. This makes the code more readable and easier to maintain.
defined( 'QUEEQUEG_BASE_DIR' ) or define( 'QUEEQUEG_BASE_DIR', plugin_dir_path( __FILE__ ) );

require_once QUEEQUEG_BASE_DIR . 'includes/queequeg_shortcodes.php';


/* The function enqueue_inshape_meta_box_styles() is used to enqueue a custom CSS file (styles.css) and make an 
AJAX URL available to your JavaScript code. This is useful when you need to apply custom styling to the InShape 
meta box in the WordPress admin interface and also need to make AJAX calls in your custom JavaScript. */
function queequeg_enqueue_admin_styles() {
    wp_enqueue_style( 'queequeg-admin-styles', plugin_dir_url(__FILE__) . '/assets/css/admin-styles.css' ); // Path to your CSS file
    wp_localize_script('inshape-script', 'inshapeAjax', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}
add_action( 'admin_enqueue_scripts', 'queequeg_enqueue_admin_styles' );

function queequeg_enqueue_styles() {
    wp_enqueue_style( 'queequeg-styles', plugin_dir_url(__FILE__) . '/assets/css/styles.css' ); // Path to your CSS file
    wp_localize_script('inshape-script', 'inshapeAjax', [
        'ajax_url' => admin_url('admin-ajax.php')
    ]);
}
add_action('wp_enqueue_scripts', 'queequeg_enqueue_styles');