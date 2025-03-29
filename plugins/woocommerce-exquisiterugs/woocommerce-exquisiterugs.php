<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 */

/**
 * Restrict this file to call directly
*/
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOCOMMERCE_EXQUISITERUGS', '1.0.0' );

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . '/wp-admin/includes/plugin.php');
}

/**
* Check for the existence of WooCommerce and any other requirements
*/
function er_check_requirements() {
    if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
        return true;
    } else {
        add_action( 'admin_notices', 'er_missing_wc_notice' );
        return false;
    }
}

/**
* Display a message advising WooCommerce is required
*/
function er_missing_wc_notice() { 
    $class = 'notice notice-error';
    $message = __( 'WooCommerce-ExquisiteRugs requires WooCommerce to be installed and active.', 'woocommerce-exquisiterugs' );
 
    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woocommerce-exquisiterugs-activator.php
 */
function activate_wc_exquisiterugs() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-exquisiterugs-activator.php';
    WC_ExquisiteRugs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woocommerce-exquisiterugs-deactivator.php
 */
function deactivate_wc_exquisiterugs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-exquisiterugs-deactivator.php';
	WC_ExquisiteRugs_Deactivator::deactivate();
}

add_action( 'plugins_loaded', 'er_check_requirements' );

register_activation_hook( __FILE__, 'activate_wc_exquisiterugs' );
register_deactivation_hook( __FILE__, 'deactivate_wc_exquisiterugs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woocommerce-exquisiterugs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wc_exquisiterugs() {
    if (er_check_requirements()) {
        $plugin = new WC_ExquisiteRugs();
        $plugin->run();        
    }
}

run_wc_exquisiterugs();