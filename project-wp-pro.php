<?php
/**
 * Plugin Name: ProjectWP Pro
 * Plugin URI: http://yourwebsite.com/projectwp-pro
 * Description: A comprehensive project management tool for WordPress.
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: http://yourwebsite.com
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: projectwp-pro
 * Domain Path: /languages
 */

// Use PHP Namespaces to organize your plugin's code.
namespace ProjectWPPro;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}



/**
 * Define plugin version constant.
 */
define( 'PROJECTWPPRO_VERSION', '1.0.0' );

/**
 * Define plugin directory path constant.
 */
define( 'PROJECTWPPRO_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Define plugin directory URL constant.
 */
define( 'PROJECTWPPRO_URL', plugin_dir_url( __FILE__ ) );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-projectwp-pro-activator.php
 */
function activate_projectwp_pro() {
    require_once PROJECTWPPRO_PATH . 'includes/class-projectwp-pro-activator.php';
    Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-projectwp-pro-deactivator.php
 */
function deactivate_projectwp_pro() {
    require_once PROJECTWPPRO_PATH . 'includes/class-projectwp-pro-deactivator.php';
    Deactivator::deactivate();
}

// Register activation and deactivation hooks.
register_activation_hook( __FILE__, 'ProjectWPPro\\activate_projectwp_pro' );
register_deactivation_hook( __FILE__, 'ProjectWPPro\\deactivate_projectwp_pro' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require_once PROJECTWPPRO_PATH . 'includes/class-projectwp-pro.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 */
function run_projectwp_pro() {
    $plugin = new ProjectWPPro();
    $plugin->run();
}
run_projectwp_pro();
