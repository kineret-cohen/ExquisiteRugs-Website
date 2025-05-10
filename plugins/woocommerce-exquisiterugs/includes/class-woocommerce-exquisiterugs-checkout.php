<?php

if (!defined('ABSPATH')) {
    exit;
}

class WC_ExquisiteRugs_Checkout {
    public function __construct() {
        add_action('woocommerce_billing_fields', array($this, 'add_po_sidemark_field'));
        add_action('woocommerce_checkout_update_order_meta', array($this, 'save_po_sidemark_field'));
        add_action('woocommerce_email_before_order_table', array($this, 'display_po_sidemark_in_email'), 10, 1);
        add_action('woocommerce_order_details_after_order_table', array($this, 'display_po_sidemark_in_order_details'));
    }

    public function add_po_sidemark_field($fields) {
        $fields['po_sidemark'] = array(
            'type'        => 'text',
            'class'       => array('form-row-wide'),
            'label'       => __('PO #sidemark', 'woocommerce-exquisiterugs'),
            'placeholder' => __('Enter PO #sidemark', 'woocommerce-exquisiterugs'),
            'required'    => false,
            'priority'    => 120, // Add after other billing fields
        );
        return $fields;
    }

    public function save_po_sidemark_field($order_id) {
        if (!empty($_POST['po_sidemark'])) {
            update_post_meta($order_id, '_po_sidemark', sanitize_text_field($_POST['po_sidemark']));
        }
    }

    public function display_po_sidemark_in_email($order) {
        $po_sidemark = get_post_meta($order->get_id(), '_po_sidemark', true);
        if ($po_sidemark) {
            echo '<div style="margin-bottom: 20px;">';
            echo '<strong>' . __('PO #Sidemark:', 'woocommerce-exquisiterugs') . '</strong> ' . esc_html($po_sidemark);
            echo '</div>';
        }
    }

    public function display_po_sidemark_in_order_details($order) {
        $po_sidemark = get_post_meta($order->get_id(), '_po_sidemark', true);
        if ($po_sidemark) {
            echo '<h2>' . __('Additional Information', 'woocommerce-exquisiterugs') . '</h2>';
            echo '<table class="woocommerce-table shop_table additional_information">';
            echo '<tbody>';
            echo '<tr>';
            echo '<th>' . __('PO #Sidemark:', 'woocommerce-exquisiterugs') . '</th>';
            echo '<td>' . esc_html($po_sidemark) . '</td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
        }
    }
} 