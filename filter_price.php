<?php

add_action('after_setup_theme','dev_filters', 999);
function dev_filter_price(){
	return 9;
}

function dev_filters(){

	add_filter('woocommerce_product_get_price','dev_filter_price');
	add_filter('woocommerce_product_variation_get_regular_price','dev_filter_price');
	add_filter('woocommerce_product_variation_get_price','dev_filter_price');



	add_filter('woocommerce_variation_prices_price', 'custom_variation_price', 99, 3 );
	add_filter('woocommerce_variation_prices_regular_price', 'custom_variation_price', 99, 3 );
	add_filter( 'woocommerce_product_get_regular_price', 'filter_woocommerce_get_regular_price', 10, 2 );
}

function custom_variation_price( $price, $variation, $product ) {
    // Delete product cached price  (if needed)
wc_delete_product_transients($variation->get_id());

return 999; // X2 for testing
}

function filter_woocommerce_get_regular_price( $price, $product ) {

    // use $product->get_id() to get product ID
    // Do any custom logical action

    return 111;
}
