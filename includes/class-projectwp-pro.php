<?php
/**
 * Class File for ProjectWP Pro Plugin
 *
 * This file contains the main class definition for the ProjectWP Pro plugin. It includes
 * methods for registering custom post types, custom taxonomies, adjusting the admin menu,
 * enqueueing scripts and styles, handling template overrides, and setting up meta boxes
 * for the 'Projects' and 'Tasks' post types. It serves as the core file for defining
 * the plugin's administrative and public-facing functionality.
 *
 * @package    ProjectWPPro
 * @subpackage ProjectWPPro/includes
 * @author     Your Name or Your Organization
 * @license    GPL-2.0+
 * @link       Your Plugin or Organization Website URL
 * @since      1.0.0
 */

namespace ProjectWPPro;

define('PROJECTWPPRO_PATH', plugin_dir_path(__FILE__));

class ProjectWPPro {

    /**
     * The single instance of the class.
     *
     * @since    1.0.0
     * @access   protected
     * @var      ProjectWPPro    $instance    The single instance of the class.
     */
    protected static $instance = null;

    /**
     * Main ProjectWPPro Instance.
     *
     * Ensures only one instance of ProjectWPPro is loaded or can be loaded.
     *
     * @since    1.0.0
     * @return ProjectWPPro - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Define the core functionality of the plugin.
     *
     * Set the hooks for the administrative area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function run() {
        add_action('init', array($this, 'register_tasks_cpt'));
        add_action('init', array($this, 'register_projects_cpt'));
        add_action('init', array($this, 'register_custom_taxonomy'));
        add_action('admin_menu', array($this, 'adjust_admin_menu'));
        add_action('wp_enqueue_scripts', array($this, 'projectwp_pro_enqueue_scripts'));
        $this->setup_meta_boxes();
        add_filter('single_template', array($this, 'register_single_project_template'));
    }

    /**
     * Adjust the admin menu for the plugin.
     */
    public function adjust_admin_menu() {
        // Add "ProjectWP" as a top-level menu item
        add_menu_page(
            'ProjectWP', // Page Title
            'ProjectWP', // Menu Title
            'manage_options', // Capability required to see this menu
            'edit.php?post_type=pwp_project', // Menu Slug - Redirect to Projects list
            '', // Function to display the dashboard page content, not needed as we are redirecting
            'dashicons-portfolio', // Icon URL (use a WordPress Dashicon)
            6 // Position
        );
    
        
    }

    /**
     * Enqueue some scripts 
     */
    function projectwp_pro_enqueue_scripts() {
        if (is_singular('pwp_project')) {
            // Enqueue your styles or scripts here
            wp_enqueue_style('projectwp-pro-style', plugins_url('css/single-pwp_project.css', __FILE__));
        }
    }

    /**
     * Display callback for the dashboard page.
     */
    public function projectwp_dashboard_page() {
        echo '<div class="wrap"><h2>ProjectWP Dashboard</h2></div>';
    }

    /**
     * Register the custom post type.
     *
     * Defines the labels and arguments for the custom post type "Task" and registers it with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    public function register_tasks_cpt() {
        $labels = array(
            'name'                  => _x( 'Tasks', 'Post type general name', 'projectwp-pro' ),
            'singular_name'         => _x( 'Task', 'Post type singular name', 'projectwp-pro' ),
            'menu_name'             => _x( 'Tasks', 'Admin Menu text', 'projectwp-pro' ),
            'name_admin_bar'        => _x( 'Task', 'Add New on Toolbar', 'projectwp-pro' ),
            'add_new'               => __( 'Add New', 'projectwp-pro' ),
            'add_new_item'          => __( 'Add New Task', 'projectwp-pro' ),
            'new_item'              => __( 'New Task', 'projectwp-pro' ),
            'edit_item'             => __( 'Edit Task', 'projectwp-pro' ),
            'view_item'             => __( 'View Task', 'projectwp-pro' ),
            'all_items'             => __( 'All Tasks', 'projectwp-pro' ),
            'search_items'          => __( 'Search Tasks', 'projectwp-pro' ),
            'parent_item_colon'     => __( 'Parent Tasks:', 'projectwp-pro' ),
            'not_found'             => __( 'No tasks found.', 'projectwp-pro' ),
            'not_found_in_trash'    => __( 'No tasks found in Trash.', 'projectwp-pro' ),
            'featured_image'        => _x( 'Task Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'projectwp-pro' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'projectwp-pro' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'projectwp-pro' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'projectwp-pro' ),
            'archives'              => _x( 'Task archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'projectwp-pro' ),
            'insert_into_item'      => _x( 'Insert into task', 'Overrides the “Insert into post”/“Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'projectwp-pro' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this task', 'Overrides the “Uploaded to this post”/“Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'projectwp-pro' ),
            'filter_items_list'     => _x( 'Filter tasks list', 'Screen reader text for the filter links heading on the post type listing screen. Added in 4.4', 'projectwp-pro' ),
            'items_list_navigation' => _x( 'Tasks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Added in 4.4', 'projectwp-pro' ),
            'items_list'            => _x( 'Tasks list', 'Screen reader text for the items list heading on the post type listing screen. Added in 4.4', 'projectwp-pro' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'pwp_task' ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array( 'title', 'editor', 'author', 'excerpt', 'comments' ),
        );

        register_post_type( 'pwp_task', $args );
    }
    /**
     * Register the Projects custom post type.
     */
    public function register_projects_cpt() {
        error_log("projects registered");
        $labels = array(
            'name'                  => _x('Projects', 'Post type general name', 'projectwp-pro'),
            'singular_name'         => _x('Project', 'Post type singular name', 'projectwp-pro'),
            'menu_name'             => _x('Projects', 'Admin Menu text', 'projectwp-pro'),
            'name_admin_bar'        => _x('Project', 'Add New on Toolbar', 'projectwp-pro'),
            'add_new'               => __('Add New', 'projectwp-pro'),
            'add_new_item'          => __('Add New Project', 'projectwp-pro'),
            'new_item'              => __('New Project', 'projectwp-pro'),
            'edit_item'             => __('Edit Project', 'projectwp-pro'),
            'view_item'             => __('View Project', 'projectwp-pro'),
            'all_items'             => __('All Projects', 'projectwp-pro'),
            'search_items'          => __('Search Projects', 'projectwp-pro'),
            'parent_item_colon'     => __('Parent Projects:', 'projectwp-pro'),
            'not_found'             => __('No projects found.', 'projectwp-pro'),
            'not_found_in_trash'    => __('No projects found in Trash.', 'projectwp-pro')
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'pwp_project'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => null,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'),
        );

        register_post_type('pwp_project', $args);
    }


    /**
     * Register Custom Taxonomy.
     *
     * @since    1.0.0
     */
    public function register_custom_taxonomy() {
        $labels = array(
            'name'                       => _x( 'Statuses', 'Taxonomy General Name', 'projectwp-pro' ),
            'singular_name'              => _x( 'Status', 'Taxonomy Singular Name', 'projectwp-pro' ),
            'menu_name'                  => __( 'Status', 'projectwp-pro' ),
            'all_items'                  => __( 'All Statuses', 'projectwp-pro' ),
            'parent_item'                => __( 'Parent Status', 'projectwp-pro' ),
            'parent_item_colon'          => __( 'Parent Status:', 'projectwp-pro' ),
            'new_item_name'              => __( 'New Status Name', 'projectwp-pro' ),
            'add_new_item'               => __( 'Add New Status', 'projectwp-pro' ),
            'edit_item'                  => __( 'Edit Status', 'projectwp-pro' ),
            'update_item'                => __( 'Update Status', 'projectwp-pro' ),
            'view_item'                  => __( 'View Status', 'projectwp-pro' ),
            'separate_items_with_commas' => __( 'Separate statuses with commas', 'projectwp-pro' ),
            'add_or_remove_items'        => __( 'Add or remove statuses', 'projectwp-pro' ),
            'choose_from_most_used'      => __( 'Choose from the most used', 'projectwp-pro' ),
            'popular_items'              => __( 'Popular Statuses', 'projectwp-pro' ),
            'search_items'               => __( 'Search Statuses', 'projectwp-pro' ),
            'not_found'                  => __( 'Not Found', 'projectwp-pro' ),
            'items_list'                 => __( 'Statuses list', 'projectwp-pro' ),
            'items_list_navigation'      => __( 'Statuses list navigation', 'projectwp-pro' ),
        );
        $args = array(
            'labels'            => $labels,
            'hierarchical'      => true, // Set to false if you want the taxonomy to be tag-like
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'projectwp_pro_status'),
        );
        register_taxonomy('projectwp_pro_status', array('pwp_task'), $args);
    }

    /**
     * Hook into WordPress to register meta boxes and save their data.
     */
    public function setup_meta_boxes() {
        add_action('add_meta_boxes', array($this, 'add_project_meta_box'));
        add_action('save_post', array($this, 'save_project_association'));
    }

    /**
     * Add meta box for project association.
     */
    public function add_project_meta_box() {
        add_meta_box(
            'pwp_project', // ID
            'Project Association', // Title
            array($this, 'project_meta_box_callback'), // Callback function
            'pwp_task', // Post type
            'side', // Context
            'default' // Priority
        );
    }

    /**
     * Meta box display callback.
     *
     * @param WP_Post $post Current post object.
     */
    public function project_meta_box_callback($post) {
        wp_nonce_field(plugin_basename(__FILE__), 'pwp_project_nonce');

        // Retrieve existing value from the database
        $current_project = get_post_meta($post->ID, '_pwp_project_id', true);

        // Dropdown for selecting project
        echo '<select name="pwp_project_id" style="width:100%;">';
        echo '<option value="">Select Project</option>';

        $projects = get_posts(array('post_type' => 'pwp_project', 'numberposts' => -1));
        foreach ($projects as $project) {
            echo '<option value="' . esc_attr($project->ID) . '"' . selected($current_project, $project->ID, false) . '>' . esc_html($project->post_title) . '</option>';
        }
        echo '</select>';
    }

    /**
     * Save the meta box data.
     *
     * @param int $post_id Post ID.
     */
    public function save_project_association($post_id) {
        if (!isset($_POST['pwp_project_nonce']) || !wp_verify_nonce($_POST['pwp_project_nonce'], plugin_basename(__FILE__))) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

        if ('pwp_task' == $_POST['post_type'] && !current_user_can('edit_post', $post_id)) {
            return;
        }

        if (!empty($_POST['pwp_project_id'])) {
            update_post_meta($post_id, '_pwp_project_id', $_POST['pwp_project_id']);
        } else {
            delete_post_meta($post_id, '_pwp_project_id');
        }
    }


/**
 * Filter the single template for projects.
 *
 * This function checks if the current post is of the 'pwp_project' custom post type
 * and, if so, attempts to load a custom template file from the plugin's 'templates' directory.
 * This allows for a custom display of single project posts.
 *
 * @param string $single_template The path to the current template file.
 * @return string The path to the new template file, if found; otherwise, the path to the current template.
 */
public function register_single_project_template($single_template) {
    global $post;

    if ('pwp_project' === $post->post_type) {
        $template_file = PROJECTWPPRO_PATH . 'templates/single-pwp_project.php';
        if (file_exists($template_file)) {
            return $template_file;
        }
    }

    return $single_template;
}


}
