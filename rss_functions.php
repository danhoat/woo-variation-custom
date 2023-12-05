<?php

/**
 * get price of 1kg base on type product.
 *
 **/


function get_unit_price_of_product($product_id){

 	$price = 0;
 	$terms = get_the_terms($product_id, 'pa_product_type');

	if( $terms && !is_wp_error($terms) ){

		$pricing = Woo_Rss_Dynamic_Price::get_pricing();
		$product_type = $terms[0];
		$metal 	= strtoupper($product_type->name);

		switch ($metal) {
				case "GOLD":
				$price = $pricing->OR;
				break;
			case "SILVER":
				$price = $pricing->ARGENT;
				break;
			case "PLATINUM":
				$price = $pricing->PLATINE;
				break;
			case "PALLADIUM":
				$price = $pricing->PALLADIUM;
				break;
		}
	}
	return (float) $price;
}
/**
 * return price of gam or oz base on price of 1 kg.
 **/
function get_price_of_unit($kg_price, $unit){

	$unit_price = 0;
	$unit = strtoupper($unit);
	switch($unit){
		case "G":
			$unit_price = $kg_price*0.001;
			break;
		case "OZ":
			$unit_price =  $kg_price*0.0283495231;
			break;
		 default:
		 	$unit_price = $kg_price;
	}
	return $unit_price;
}

function get_price_of_metal_unit($metal = 'gold', $unit = 'kg'){
	$pricing = Woo_Rss_Dynamic_Price::get_pricing();
	$metal = strtoupper($metal);
	$kg_price = 0;
	switch ($metal) {
		case "GOLD":
			$kg_price = $pricing->OR;
			break;
		case "SILVER":
			$kg_price = $pricing->ARGENT;
			break;
		case "PLATINUM":
			$kg_price = $pricing->PLATINE;
			break;
		case "PALLADIUM":
			$kg_price = $pricing->PALLADIUM;
			break;
	}
	$unit_price = get_price_of_unit($kg_price, $unit);
	return $unit_price;
}

/**
 * only update price or filter price by rss  if rss is expired.
 *
 **/
function is_rss_expired(){
	return true;
	$timeout = get_option('_transient_timeout_'.Woo_Rss_Dynamic_Price::TRANS_PRICING, true);
	if( $timeout - time() < 0 ) return true;
	return false;
}