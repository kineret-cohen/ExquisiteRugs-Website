<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://paulmiller3000.com
 * @since      1.0.0
 *
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/public
 * @author     Paul Miller <hello@paulmiller3000.com>
 */
class WC_ExquisiteRugs_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

        // Add cart access control
        add_action('woocommerce_init', array($this, 'disable_cart_for_user_role'));
        add_filter('wp_nav_menu_objects', array($this, 'hide_cart_icon_for_user_role'), 10, 2);
	}

    /**
     * Check if current user can use cart
     *
     * @since    1.0.0
     * @return   boolean
     */
    private function can_use_cart() {
        // Site admins always have access
        if (is_site_admin()) {
            return true;
        }

        $cart_access = get_option('wc_exquisiterugs_cart_access', 'disable');
        
        switch ($cart_access) {
            case 'all':
                return true;
            case 'selected':
                $allowed_users = get_option('wc_exquisiterugs_allowed_users', '');
                if (empty($allowed_users)) {
                    return false;
                }
                $current_user = wp_get_current_user();
                $allowed_users_array = array_map('trim', explode(',', $allowed_users));
                return in_array($current_user->user_login, $allowed_users_array);
            case 'disable':
            default:
                return false;
        }
    }

    /**
     * Disable cart functionality for restricted users
     *
     * @since    1.0.0
     */
    public function disable_cart_for_user_role() {
        if (!$this->can_use_cart()) {
            // Remove cart functionality
            remove_action('woocommerce_before_cart', 'woocommerce_cart_redirect_if_empty', 10);
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
            remove_action('woocommerce_cart_update_totals', 'woocommerce_cart_update_totals', 10);
            remove_action('woocommerce_after_cart', 'woocommerce_cart_collaterals', 10);
            remove_action('woocommerce_cart_contents', 'woocommerce_cart_contents', 10);
            
            remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
            remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
            
            add_action('woocommerce_before_cart', array($this, 'cart_disabled_message'));
        }
    }

    /**
     * Hide cart icon from menu for restricted users
     *
     * @since    1.0.0
     * @param    array    $menu_objects    Menu items
     * @param    object   $args            Menu arguments
     * @return   array    Modified menu items
     */
    public function hide_cart_icon_for_user_role($menu_objects, $args) {
        if (!str_contains($args->theme_location, 'navigation') || $this->can_use_cart()) {
            return $menu_objects;
        }
        
        $menu_items = array(
            'Cart',
            'My Account'
        );
        
        foreach ($menu_objects as $key => $menu_object) {
            if (!in_array($menu_object->title, $menu_items)) {
                continue;
            }
            unset($menu_objects[$key]);
        }
            
        return $menu_objects;
    }

    /**
     * Display cart disabled message
     *
     * @since    1.0.0
     */
    public function cart_disabled_message() {
        echo '<div class="woocommerce-info">Your shopping cart is disabled. Please contact support for assistance.</div>';
    }

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woocommerce-exquisiterugs-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woocommerce-exquisiterugs-public.js', array( 'jquery' ), $this->version, false );

	}

}
