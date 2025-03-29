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
        
        // Register settings
        add_action('admin_init', array($this, 'register_settings'));
        
        // Add JavaScript for dynamic form behavior
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
	}

    /**
     * Register settings
     *
     * @since    1.0.0
     */
    public function register_settings() {
        register_setting('wc_exquisiterugs_options', 'wc_exquisiterugs_cart_access');
        register_setting('wc_exquisiterugs_options', 'wc_exquisiterugs_allowed_users');
    }

    /**
     * Enqueue admin scripts
     *
     * @since    1.0.0
     */
    public function enqueue_admin_scripts($hook) {
        if ('toplevel_page_wc-exquisiterugs-setup' !== $hook) {
            return;
        }

        wp_enqueue_script(
            'wc-exquisiterugs-admin',
            plugin_dir_url(__FILE__) . 'js/woocommerce-exquisiterugs-admin.js',
            array('jquery'),
            $this->version,
            true
        );
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
        // Check if settings were saved
        if (isset($_GET['settings-updated']) && $_GET['settings-updated']) {
            add_settings_error(
                'wc_exquisiterugs_messages',
                'wc_exquisiterugs_message',
                'Settings Saved',
                'updated'
            );
        }

        // Get current values
        $cart_access = get_option('wc_exquisiterugs_cart_access', 'disable');
        $allowed_users = get_option('wc_exquisiterugs_allowed_users', '');
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            
            <?php settings_errors('wc_exquisiterugs_messages'); ?>

            <form method="post" action="options.php">
                <?php
                settings_fields('wc_exquisiterugs_options');
                ?>
                <div class="card">
                    <h2>Cart Access Settings</h2>
                    <table class="form-table">
                        <tr>
                            <th scope="row">Cart Access Control</th>
                            <td>
                                <fieldset>
                                    <label>
                                        <input type="radio" name="wc_exquisiterugs_cart_access" value="disable" <?php checked($cart_access, 'disable'); ?>>
                                        Disable Cart
                                    </label><br>
                                    <label>
                                        <input type="radio" name="wc_exquisiterugs_cart_access" value="all" <?php checked($cart_access, 'all'); ?>>
                                        Allow Cart to All Users
                                    </label><br>
                                    <label>
                                        <input type="radio" name="wc_exquisiterugs_cart_access" value="selected" <?php checked($cart_access, 'selected'); ?>>
                                        Allow Cart to Selected Users
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                        <tr class="allowed-users-field" style="display: <?php echo $cart_access === 'selected' ? 'table-row' : 'none'; ?>">
                            <th scope="row">Allowed Users</th>
                            <td>
                                <input type="text" name="wc_exquisiterugs_allowed_users" value="<?php echo esc_attr($allowed_users); ?>" class="regular-text">
                                <p class="description">Enter comma-separated list of users (e.g. kineret, alex)</p>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php submit_button('Save Settings'); ?>
            </form>
        </div>
        <?php
    }
}
