<?php

function rss_filter_variation_price($price, $variation){

	if( ! is_rss_expired() ) return $price;

	$product_id = $variation->parent_id;
	$unit 		= strtoupper($variation->get_attribute('pa_unit'));
	$kg_price 	= get_unit_price_of_product($product_id);
	$unit_price = get_price_of_unit($kg_price, $unit);
	return $unit_price;
}

add_filter('woocommerce_product_variation_get_price','rss_filter_variation_price', 10 ,2);


function rss_filter_product_price($price, $object){
	if( ! is_rss_expired() ) return $price;
	$prices = $object->get_variation_prices( true );

	if ( empty( $prices['price'] ) ) {
		//$price = apply_filters( 'woocommerce_variable_empty_price_html', '', $object );
	} else {
		$min_price     = current( $prices['price'] );
		$max_price     = end( $prices['price'] );
		$min_reg_price = current( $prices['regular_price'] );
		$max_reg_price = end( $prices['regular_price'] );

		if ( $min_price !== $max_price ) {
			$price = wc_format_price_range( $min_price, $max_price );
		} elseif ( $object->is_on_sale() && $min_reg_price === $max_reg_price ) {
			$price = wc_format_sale_price( wc_price( $max_reg_price ), wc_price( $min_price ) );
		} else {
			$price = wc_price( $min_price );
		}

	}
	return $price;
}
 add_filter( 'woocommerce_variable_price_html','rss_filter_product_price', 10 ,2);