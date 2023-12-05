<?php

/*
 Check and auto set price for current product edit.
*/
function rss_update_product_variation_price(){

	global $pagenow;
	if($pagenow == 'post.php'){
		if( ! is_rss_expired() ) return ;

		$product_id = isset($_GET['post']) ? $_GET['post'] : 0;
		$post 		= get_post($product_id);
		if( !$post || $post->post_type !== 'product'){  return; }

		$kg_price = get_unit_price_of_product($product_id);

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

			$variation_ID = $variation->ID;
			$variation = new WC_Product_Variation( $variation_ID );

			$unit   	= strtoupper($variation->get_attribute('pa_unit'));
			$unit_price = get_price_of_unit($kg_price, $unit);

			update_post_meta($variation_ID,'_regular_price', $unit_price);
			update_post_meta($variation_ID,'_price', $unit_price);
		}
	}
}

add_action( 'admin_init', 'rss_update_product_variation_price' );

