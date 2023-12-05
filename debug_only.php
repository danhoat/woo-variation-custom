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