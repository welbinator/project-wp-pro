<?php
/**
 * The file that contains the class to activate the plugin
 *
 * A class definition that includes attributes and functions used during the activation of the plugin.
 * 
 * @package    ProjectWP_Pro
 * @subpackage ProjectWP_Pro/includes
 * @author     Your Name or Your Company
 */

 namespace ProjectWPPro;
 use ProjectWPPro;
 /**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    ProjectWP_Pro
 * @subpackage ProjectWP_Pro/includes
 */
class Activator {

/**
 * Register the custom post type and flush rewrite rules.
 *
 * This method is called upon plugin activation. It registers the custom post type and flushes rewrite rules to ensure the CPT's slug is recognized.
 *
 * @since    1.0.0
 */
public static function activate() {
    
    // Ensure the taxonomy is registered before attempting to add terms
    $terms = array(
        'Dev in progress', 'QA in progress', 'Ready for QA', 'Smoketest', 
        'Ready to release', 'Declined', 'Done'
    );
    
    foreach ($terms as $term) {
        if (!term_exists($term, 'projectwp_pro_status')) {
            wp_insert_term($term, 'projectwp_pro_status');
        }
    }

    // Flush rewrite rules after setup
    flush_rewrite_rules();
}


}
