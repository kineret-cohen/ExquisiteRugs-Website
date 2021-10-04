<?php
defined( 'ABSPATH' ) || exit;

global $wpdb, $product;

$sku = $product->get_sku();

$items = $wpdb->get_results( 'SELECT * FROM er_reports WHERE design = \''. $sku . '\' order by sort_by_size_1, sort_by_size_2, amount;', ARRAY_A);

$hide_back_orders = !(current_user_can( 'administrator') || current_user_can('read_full_inventory'));

$last_updated = '';
foreach ($items as $item) {
    // get the recent report date
    $report_date = $item["report_date"];
    if ($last_updated < $report_date)
        $last_updated = $report_date;
}

if ($last_updated !== '')
    $last_updated = date('Y/m/d', strtotime($last_updated));

// see if we need to filter backorders
/*if ($hide_back_orders) {
    $filtered_items = array();
    $back_orders = 0;
    $prev_item = NULL;
   
   
    foreach ($items as $item) {
        $size = $item["size"];
        $amount = $item["amount"];
       
        // reset after every time size changes
        if ($prev_item != NULL && strcmp($size,$prev_item["size"]) !== 0) {
           
            if ($prev_item["amount"] == 0) {
                $prev_item["eta"] = "Out of Stock";
                array_push($filtered_items,$prev_item);
            }
               
            $prev_item = NULL;
            $back_orders = 0;
        }
           
        if ($amount < 0) {
            $back_orders = $amount * -1;
            $item["amount"] = 0;
        }
        else if ($back_orders > 0) {
            if ($amount > $back_orders) {
                $item["amount"] = $amount - $back_orders;
                $back_orders = 0;
            }
            else {
                $back_orders = $back_orders - $amount;
                $item["amount"] = 0;
            }
        }
       
        if ($item["amount"] > 0) {
            array_push($filtered_items,$item);
        }
       
        $prev_item = $item;
    }
   
   
    $items = $filtered_items;
}*/

?>
<style>
.product_table_inventory {
        text-transform: capitalize;
        width: 100%;
}

.product_table_inventory tbody tr:nth-child(2n) {
    background-color: #F6F6F6;
}
.product_table_inventory > thead > tr {
    border-width: 1px;
    border-bottom-style: solid;
    border-color: #efefef;
}
</style>
<div class="q_accordion_holder toggle boxed woocommerce-accordion accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset" style="visibility: visible;margin-bottom:0px">
<h6 class="title-holder clearfix description_tab ui-accordion-header ui-helper-reset ui-corner-top ui-state-default ui-corner-bottom">
<span class="tab-title">Inventory Details</span>
</h6>
<div class="accordion_content ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom" style="display: none;">
<div class="accordion_content_inner">
            <div class="product_inventory">                  
                <?php if (sizeof($items) > 0) { ?>
       
                    <table class="product_table_inventory">
                        <thead>
                            <tr>
                                <th>Size</th>
                                <th>In Stock</th>
                                <th>In Transit</th>
                                <th>ETA (In Transit)</th>
                                <th>On Loom</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item) { ?>
                            <tr>
                                <td><?php echo $item["size"]; ?></td>
                                <td><?php echo $item["in_stock"]; ?></td>
                                <td><?php echo $item["in_transit"] == null? '&mdash;':$item["in_transit"]; ?></td>
                                <td><?php echo $item["eta"]; ?></td>
                                <td><?php echo $item["on_loom"] == 1? 'Yes':''; ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
       
                <?php } else { ?>
               
                    <p>There is no inventory data available for this product</p>
               
                <?php } ?>  
            </div>
            <?php if ($last_updated !== '') { ?>
                <br />
                <small>* Last updated at <?php echo $last_updated ?></small>
            <?php } ?>
</div>
</div>
</div>

