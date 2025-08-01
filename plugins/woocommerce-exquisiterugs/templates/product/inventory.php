<?php
defined( 'ABSPATH' ) || exit;

global $wpdb, $product;

$sku = $product->get_sku();

$items = $wpdb->get_results( 'SELECT * FROM er_inventory WHERE design = \''. $sku . '\' order by sort_by_size_1, sort_by_size_2, in_stock;', ARRAY_A);

$last_updated = '';
foreach ($items as $item) {
    // get the recent report date
    $report_date = $item["report_date"];
    if ($last_updated < $report_date)
        $last_updated = $report_date;
}

if ($last_updated !== '') {
    $last_updated = new DateTime($last_updated, new DateTimeZone('UTC')); 
    $last_updated->setTimezone( new DateTimeZone('US/Pacific') );
}

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

.q_accordion_holder {
    font-family: Raleway, sans-serif;
}

.q_accordion_holder.accordion.boxed .ui-accordion-header {
    border: 0px;
    border-radius: 0px;
}

.q_accordion_holder.boxed div.accordion_content {
    border: 0px;
    font-size: 14px;
    color: #818181;
}

</style>
<div class="q_accordion_holder inventory_details toggle boxed woocommerce-accordion accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset" style="visibility: visible;margin-bottom:0px">
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
                                <th>ETA</th>
                                <th>On Loom</th>
                                <th>ETA</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item) { ?>
                            <tr>
                                <td><?php echo $item["size"]; ?></td>
                                <td><?php echo $item["in_stock"]; ?></td>
                                <td><?php echo $item["in_transit"] == null? '&mdash;':$item["in_transit"]; ?></td>
                                <td><?php echo $item["in_transit_eta"] == null? '&mdash;':$item["in_transit_eta"]; ?></td>
                                <td><?php echo $item["on_loom"] == null? '&mdash;':$item["on_loom"]; ?></td>
                                <td><?php echo $item["on_loom_eta"] == null? '&mdash;':$item["on_loom_eta"]; ?></td>
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
                <small>* ETAs subject to change. Last updated at <?php echo $last_updated->format('Y-m-d H:i')?> Pacific Time</small>
            <?php } ?>
</div>
</div>
</div>
<script>
// remove if no auto expand is needed
document.addEventListener('DOMContentLoaded', function(event) {
  document.querySelector('div.q_accordion_holder.inventory_details > .title-holder').click();
})
</script>