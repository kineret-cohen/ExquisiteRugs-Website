<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://paulmiller3000.com
 * @since      1.0.0
 *
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/includes
 * @author     Paul Miller <hello@paulmiller3000.com>
 */
class WC_ExquisiteRugs {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      WC_ExquisiteRugs_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOCOMMERCE_EXQUISITERUGS_VERSION' ) ) {
			$this->version = WOCOMMERCE_EXQUISITERUGS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woocommerce-exquisiterugs';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WC_ExquisiteRugs_Loader. Orchestrates the hooks of the plugin.
	 * - WC_ExquisiteRugs_i18n. Defines internationalization functionality.
	 * - WC_ExquisiteRugs_Admin. Defines all hooks for the admin area.
	 * - WC_ExquisiteRugs_Public. Defines all hooks for the public side of the site.
	 * - WC_ExquisiteRugs_Checkout. Defines all hooks for the checkout functionality.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-exquisiterugs-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-exquisiterugs-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woocommerce-exquisiterugs-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woocommerce-exquisiterugs-public.php';

		/**
		 * The class responsible for defining all hooks for the checkout functionality.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woocommerce-exquisiterugs-checkout.php';

		$this->loader = new WC_ExquisiteRugs_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WC_ExquisiteRugs_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WC_ExquisiteRugs_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WC_ExquisiteRugs_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        // Add plugin settings to WooCommerce
        $this->loader->add_filter( 'woocommerce_get_settings_pages', $plugin_admin, 'er_add_settings' );
        
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WC_ExquisiteRugs_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		// exquisite rugs specific
		add_action( 'woocommerce_after_single_product_summary', 'exquisiterugs_recently_viewed_products', 30 );
		add_action( 'woocommerce_share', 'exquisiterugs_product_inventory', 10 );

		// Initialize checkout functionality
		new WC_ExquisiteRugs_Checkout();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    WC_ExquisiteRugs_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}


if ( ! function_exists( 'exquisiterugs_product_inventory' ) ) {
	/**
	 * Output the product inventory
	 *
	 * @subpackage	Product
	 */
	function exquisiterugs_product_inventory() {
		
		wc_get_template( 'product/inventory.php', [], '', WP_PLUGIN_DIR . '/woocommerce-exquisiterugs/templates/' );
	}
}

if ( ! function_exists( 'exquisiterugs_recently_viewed_products' ) ) {

	/**
	 * Output the recently viewed product list
	 *
	 * @subpackage	Product
	 */
	function exquisiterugs_recently_viewed_products() {
		
		wc_get_template( 'product/recently-viewed.php', [], '', WP_PLUGIN_DIR . '/woocommerce-exquisiterugs/templates/' );
	}
}
