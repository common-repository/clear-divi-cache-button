<?php
/**
 * Plugin Name: Clear Divi Cache Button
 * Description: Clear the Divi Static CSS Files faster with a nifty button in the WordPress toolbar.
 * Version: 1.0
 * Author: DiviMundo
 * Author URI: https://divimundo.com/en/
 */
// Register the button in the admin bar
function clear_divi_cache_add_button() {
    global $wp_admin_bar;

    $wp_admin_bar->add_menu( array(
        'id'    => 'clear-divi-cache',
        'title' => 'Clear Divi Cache',
        'href'  => '#',
        'meta'  => array(
            'onclick' => 'clear_divi_cache_run_cron(); return false;',
        ),
    ) );
}

add_action( 'wp_before_admin_bar_render', 'clear_divi_cache_add_button' );

// Register the script that runs the cron job
function clear_divi_cache_register_script() {
    if ( is_admin() && is_user_logged_in() ) {
        wp_register_script( 'clear-divi-cache-script', plugins_url( 'clear-divi-cache.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'clear-divi-cache-script' );
    }
}

add_action( 'admin_enqueue_scripts', 'clear_divi_cache_register_script' );

// Register the AJAX action that runs the cron job
add_action( 'wp_ajax_clear_divi_cache_run_cron', 'clear_divi_cache_run_cron' );

function clear_divi_cache_run_cron() {
    if ( ! wp_next_scheduled( 'et_core_page_resource_auto_clear()' ) ) {
        wp_schedule_single_event( time(), 'et_core_page_resource_auto_clear' );
    }
}
// Add Donate Link
add_filter('plugin_action_links_' . plugin_basename(__FILE__), function ($links) {
    return array_merge($links, [
        '<a href="https://www.buymeacoffee.com/divimundo" target="_blank" style="color:#3db634;">Buy developer a coffee</a>'
    ]);
});