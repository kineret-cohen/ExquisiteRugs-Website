<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://paulmiller3000.com
 * @since      1.0.0
 *
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/admin
 * @author     Paul Miller <hello@paulmiller3000.com>
 */
class WC_ExquisiteRugs_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        // Add menu items
        add_action('admin_menu', array($this, 'add_plugin_admin_menu'));
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WC_ExquisiteRugs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WC_ExquisiteRugs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-exquisiterugs-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in WC_ExquisiteRugs_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The WC_ExquisiteRugs_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-exquisiterugs-admin.js', array( 'jquery' ), $this->version, false );

	}

    /**
    * Load dependencies for additional WooCommerce settings
    *
    * @since    1.0.0
    * @access   private
    */
    public function er_add_settings( $settings ) {
        $settings[] = include plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-exquisiterugs-wc-settings.php';        

        return $settings;
    }

    /**
     * Add menu items
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {
        add_menu_page(
            'ExquisiteRugs Setup', // Page title
            'ExquisiteRugs', // Menu title
            'manage_options', // Capability required
            'wc-exquisiterugs-setup', // Menu slug
            array($this, 'display_plugin_setup_page'), // Function to display the page
            'dashicons-store', // Icon
            56 // Position
        );
    }

    /**
     * Display the setup page
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <div class="card">
                <h2>Welcome to ExquisiteRugs Setup</h2>
                <p>Hello World! This is your setup page.</p>
            </div>
        </div>
        <?php
    }
}
