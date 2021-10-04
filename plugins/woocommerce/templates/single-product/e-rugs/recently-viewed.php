<?php 
    defined( 'ABSPATH' ) || exit;
    
    global $wpdb, $product;
    
    

    // Get WooCommerce Global
    global $woocommerce;

    // Get recently viewed product cookies data
    $viewed_products = ! empty( $_COOKIE['woocommerce_recently_viewed'] ) ? (array) explode( '|', $_COOKIE['woocommerce_recently_viewed'] ) : array();
    $viewed_products = array_filter( array_map( 'absint', $viewed_products ) );

    // If no data, quit
    if ( empty( $viewed_products ) )
        return;;

    // Create the object
    ob_start();

    // Get products per page
    if( !isset( $per_page ) ? $number = 4 : $number = $per_page )

    // Create query arguments array
    $query_args = array(
                    'posts_per_page' => $number, 
                    'no_found_rows'  => 1, 
                    'post_status'    => 'publish', 
                    'post_type'      => 'product', 
                    'post__in'       => $viewed_products, 
                    'orderby'        => 'rand'
                    );

    // Add meta_query to query args
    $query_args['meta_query'] = array();

    // Check products stock status
    $query_args['meta_query'][] = $woocommerce->query->stock_status_meta_query();

    // Create a new query
    $products = new WP_Query($query_args);

    // If query return results
    if ( $products->have_posts() ) : ?> 

        <div class="related recently-viewed products">
            <h4 style="margin-bottom: 34px;" class="recently-viewed-title"> Recently Viewed Products </h4>
            <?php woocommerce_product_loop_start(); ?>
            
            <?php while ( $products->have_posts() ) : $products->the_post(); ?>
                
                <?php wc_get_template_part( 'content', 'product' ); ?>
            
            <?php endwhile; // end of the loop. ?>
            
            <?php woocommerce_product_loop_end(); ?>
        </div>
        <?php endif;
    
    wp_reset_postdata();
?>
