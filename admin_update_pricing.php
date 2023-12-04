<?php
function dev_settings(){
	global $pagenow;
	if($pagenow == 'post.php'){

		$product_id = isset($_GET['post']) ? $_GET['post'] : 0;
		$post 		= get_post($product_id);
		if( !$post || $post->post_type !== 'product') return;

		$price = get_unit_price_of_product($product_id);
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

			$variation_ID = $variation->ID;
			$unit = get_post_meta($variation_ID, 'attribute_pa_unit', true);
			if($unit == 'g'){
				$price = $price/10;
			}else if($unit == 'oz'){
				$price = 0.0283495231* $price;
			}

			update_post_meta($variation_ID,'_regular_price', $price);
			update_post_meta($variation_ID,'_price', $price);

		}
	}
}

add_action( 'admin_init', 'dev_settings' );

function get_unit_price_of_product($product_id){
 	$terms = get_the_terms($product_id, 'pa_product-type');
	if( $terms && !is_wp_error($terms) ){

		$t = woo_rss_dinamic_price::get_pricing();
		$product_type = $terms[0];
		$metal 			= strtoupper($product_type->name);
		switch ($metal) {
				case "GOLD":
				$price = $t->OR;
				break;
			case "SILVER":
				$price = $t->ARGENT;
				break;
			case "PLATINUM":
				$price = $t->PLATINE;
				break;
			case "PALLADIUM":
				$price = $t->PALLADIUM;
				break;
		}
	}
	return (float) $price;
}
function dev_fetch_pricing($variation, $i){

}
//add_action( 'woocommerce_save_product_variation','dev_fetch_pricing', 10 ,2);