<?php
/**
 * The file that contains the class to deactivate the plugin
 *
 * A class definition that includes attributes and functions used during the deactivation of the plugin.
 * 
 * @package    ProjectWP_Pro
 * @subpackage ProjectWP_Pro/includes
 * @author     Your Name or Your Company
 */

 namespace ProjectWPPro;

 /**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    ProjectWP_Pro
 * @subpackage ProjectWP_Pro/includes
 */
class Deactivator {

/**
 * Register the custom post type and flush rewrite rules.
 *
 * This method is called upon plugin activation. It registers the custom post type and flushes rewrite rules to ensure the CPT's slug is recognized.
 *
 * @since    1.0.0
 */
    public static function deactivate() {
        
    }
}