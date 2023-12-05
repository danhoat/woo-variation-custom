<?php
function dev_debug(){
	$product_id = 18;
	$variation_object = wc_get_product_object( 'variation' );
	$variation_object->set_parent_id( $product_id );

	$args = array(
	    'post_type'     => 'product_variation',
	    'post_status'   => array( 'private', 'publish' ),
	    'numberposts'   => -1,
	    'orderby'       => 'menu_order',
	    'order'         => 'asc',
	    'post_parent'   => 14 // get parent post-ID
	);
	$variations = get_posts( $args );

	foreach ( $variations as $variation ) {

	    // get variation ID
	    $variation_ID = $variation->ID;

	    // get variations meta
	    $product_variation = new WC_Product_Variation( $variation_ID );

	    // get variation featured image
	    $variation_image = $product_variation->get_image();

	    // get variation price
	    $variation_price = $product_variation->get_price_html();

	    $regular_price = $product_variation->get_regular_price( 'edit' );

	}

}

function debug_variations_price(){
	$product_id = 36;
	echo 'Product ID: '.$product_id;
	$args = array(
	    'post_type'     => 'product_variation',
	    'post_status'   => array( 'private', 'publish' ),
	    'numberposts'   => -1,
	    'orderby'       => 'menu_order',
	    'order'         => 'asc',
	    'post_parent'   => $product_id // get parent post-ID
	);
	$variations = get_posts( $args );

	foreach ( $variations as $variation ) {

	    // get variation ID
	    $variation_ID = $variation->ID;

	    // get variations meta
	    $product_variation = new WC_Product_Variation( $variation_ID );
	   	$unit 	= strtoupper($product_variation->get_attribute('pa_unit'));
	   	$price 	= $product_variation->get_price();
	   	echo '<pre>';
	   	echo ('ID:'.$variation_ID.'|'.$unit.'|'.$price);
	   	echo '</pre>';
	}
}
function rss_dev_debug(){
	if( is_admin() ) return ;
	echo '<pre>';
	$gmt_time = date('d-m-y H:i:s', time());
	var_dump('GMT time:'.$gmt_time);
	$local_time = current_time('mysql');
	var_dump('Local time:'.$local_time);
	debug_variations_price();
	$time_update = get_option('rss_update_time_log', true);
	echo '<br >Time Fetch RSS: '.$time_update;
	echo '<br />RSS REAL PRICE:';
	$price = Woo_Rss_Dynamic_Price::fetch_rss(0);
	var_dump($price);


	$unit_price = get_price_of_metal_unit('GOLD','g');
	$weight_price = 0.1*$unit_price;
	echo '<br />1 g of GOLD:'.$unit_price;
	echo '<br />0.1 g of GOLD:'.$weight_price;
	echo '<br />0.2 g of GOLD:'.$unit_price * 0.2;
	echo '<br />0.3 g of GOLD:'.$unit_price * 0.3;

	$unit_price = get_price_of_metal_unit('GOLD','oz');
	$weight_price = 0.1*$unit_price;
	echo '<br />1 oz of GOLD:'.$unit_price;
	echo '<br />0.1 oz of GOLD:'.$weight_price;
	echo '<br />0.2 oz of GOLD:'.$unit_price * 0.2;
	echo '<br />0.3 oz of GOLD:'.$unit_price * 0.3;
	echo '</pre>';
}
add_action('init','rss_dev_debug');