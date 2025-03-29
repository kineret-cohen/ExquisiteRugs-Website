<?php
$propulsionTypes = array(
    'unknown'   => __( '', 'woocommerce-exquisiterugs' ),
    'light_speed'   => __( 'Light Speed', 'woocommerce-exquisiterugs' ),
    'ftl_speed'   => __( 'Faster Than Light', 'woocommerce-exquisiterugs' ),
);

$settings = array(
        array(
            'name' => __( 'General Configuration', 'woocommerce-exquisiterugs' ),
            'type' => 'title',
            'id'   => $prefix . 'general_config_settings'
        ),
        array(
            'id'        => $prefix . 'battlestar_group',
            'name'      => __( 'Battlestar Group', 'woocommerce-exquisiterugs' ), 
            'type'      => 'number',
            'desc_tip'  => __( ' The numeric designation of this Battlestar Group.', 'woocommerce-exquisiterugs')
        ),
        array(
            'id'        => $prefix . 'flagship',
            'name'      => __( 'Flagship', 'woocommerce-exquisiterugs' ), 
            'type'      => 'text',
            'desc_tip'  => __( ' The name of this Battlestar Group flagship. ', 'woocommerce-exquisiterugs')
        ),
        array(
            'id'        => '',
            'name'      => __( 'General Configuration', 'woocommerce-exquisiterugs' ),
            'type'      => 'sectionend',
            'desc'      => '',
            'id'        => $prefix . 'general_config_settings'
        ),

        array(
            'name' => __( 'Flagship Settings', 'woocommerce-exquisiterugsy' ),
            'type' => 'title',
            'id'   => $prefix . 'flagship_settings',
        ),
        array(
            'id'        => $prefix . 'ship_propulsion_type',
            'name'      => __( 'Propulsion Type', 'woocommerce-exquisiterugs' ), 
            'type'      => 'select',
            'class'     => 'wc-enhanced-select',
            'options'   => $propulsionTypes,
            'desc_tip'  => __( ' The primary propulsion type utilized by this flagship.', 'woocommerce-exquisiterugs')
        ),
        array(
            'id'        => $prefix . 'ship_length',
            'name'      => __( 'Length', 'woocommerce-exquisiterugs' ), 
            'type'      => 'number',
            'desc_tip'  => __( ' The length in meters of this ship.', 'woocommerce-exquisiterugs')
        ),
        array(
            'id'        => $prefix . 'ship_in_service',
            'name'      => __( 'In Service?', 'woocommerce-exquisiterugs' ),
            'type'      => 'checkbox',
            'desc'  => __( 'Uncheck this box if the ship is out of service.', 'woocommerce-exquisiterugs' ),
            'default'   => 'yes'
        ),             
        array(
            'id'        => '',
            'name'      => __( 'Flagship Settings', 'woocommerce-exquisiterugs' ),
            'type'      => 'sectionend',
            'desc'      => '',
            'id'        => $prefix . 'flagship_settings',
        ),                        
    );
?>