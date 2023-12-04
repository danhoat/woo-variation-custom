<?php
/**
 * @package
 * @version 1.7.2
 */
/*
Plugin Name: Woo Rss Dinamic Price
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: This is not just a plugin, it symbolizes the hope and enthusiasm of an entire generation summed up in two words sung most famously by Louis Armstrong: Hello, Dolly. When activated you will randomly see a lyric from <cite>Hello, Dolly</cite> in the upper right of your admin screen on every page.
Author: Matt Mullenweg
Version: 1.7.2
Author URI: http://ma.tt/
*/

define('IS_AUTOMATIC_PRICING', true);
add_filter('https_ssl_verify', '__return_false');

// require __DIR__ .'/variation_weight.php';
// require __DIR__ .'/filter_price.php';
require __DIR__ .'/admin_update_pricing.php';
Class woo_rss_dinamic_price{

	protected $rss_url;
	protected $list_metal;
	protected $opt_pricing;
	protected $transirent_pricing;
	const RSS_URL = 'https://www.cookson-clal.com/mp/rss_mpfr_cdl.jsp';
	const  TRANS_PRICING_OPT = 'woo_rss_pricing';
	const  TRANS_PRICING = '_transient_woo_rss_pricing';
	const CONSTANT = 'constant value';

	const LIST_METAL = array('OR','ARGENT','PLATINE','PALLADIUM');
	function __construct(){
		$this->rss_url 		= 'https://www.cookson-clal.com/mp/rss_mpfr_cdl.jsp';
		$this->list_metal 	= array('OR','ARGENT','PLATINE','PALLADIUM');
		$this->opt_pricing = 'woo_rss_pricing';
		$this->transirent_pricing = '_transient_'.$this->opt_pricing;
		add_action('init', array($this, 'get_pricing') );

		add_action('init', array($this, 'dev_debug'), 999);


	}
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
	static function fetch_rss(){
		$response 		= wp_remote_get(self::RSS_URL,   array('sslverify' => FALSE) );
		$responseBody 	= wp_remote_retrieve_body( $response);
    	$xml  			= simplexml_load_string($responseBody);

    	$option_name 	= 'woo_rss_pricing';

    	$opt_values 	= array();
    	foreach($xml->channel->item as $item=>$value){

    		$title = $value->title->__toString();

    		$price1 = $price2 = '';
    		$info = explode('-', $title);
    		$name = strtoupper(trim($info[0]));

    		if( in_array($name, self::LIST_METAL) ){

    			$price_text = trim($info[1]);
    			if(isset($info[2])) $price_text =trim($info[2]);
    			$price_vs_unit = explode("fixing :", $price_text);
    			$price = substr($price_vs_unit[1], 0, -7);
    			$price = str_replace(',', '.', $price);
    			$opt_values[$name] = $price;
    		}

    	}
    	set_transient(self::TRANS_PRICING,$opt_values,2*60);

	}

	static  function get_pricing(){

		$values = get_transient(self::TRANS_PRICING);
		//if (!$values) {
			$values = self::fetch_rss();
		//}
		$values =  get_transient(self::TRANS_PRICING);
		return (object) $values;

	}
}
new woo_rss_dinamic_price();



add_filter( 'woocommerce_quantity_input_args', 'cart_variation_quantity_input_args', 10, 2 );
function cart_variation_quantity_input_args( $args, $product ){
    $product_weight = $product->get_weight();

    if( $product_weight > 0 ) {
        if ( ! is_cart()) {
            $args['input_value'] = $product_weight;
        }
        $args['step'] = $args['min_value'] = $product_weight;
    }
    return $args;
}

remove_filter('woocommerce_stock_amount', 'intval');
add_filter('woocommerce_stock_amount', 'floatval');



/*Quantity Selector Based On Simple*/
function custom_quantity_selector_min_value( $min, $product ) {
    $weight = $product->get_weight();
    if ( $weight > 0 ) {
        $min = $weight;
    }
    return $min;
}

add_filter( 'woocommerce_quantity_input_min', 'custom_quantity_selector_min_value', 10, 2 );

//Modify the quantity selector step value.

function custom_quantity_selector_step( $step, $product ) {
    $weight = $product->get_weight();
    if ( $weight > 0 ) {
        $step = $weight;
    }
    return $step;
}

add_filter( 'woocommerce_quantity_input_step', 'custom_quantity_selector_step', 10, 2 );

//Update the quantity selector value dynamically.

function custom_quantity_selector_value( $input_value, $product ) {
    $weight = $product->get_weight();
    if ( $weight > 0 ) {
        $input_value = $weight;
    }
    return $input_value;
}

add_filter( 'woocommerce_quantity_input_value', 'custom_quantity_selector_value', 10, 2 );

add_filter( 'http_request_args', function ( $args ) {
    if ( getenv('WP_ENV') !== 'development' ) {
        return $args;
    }

    $args['sslcertificates'] = ini_get( 'curl.cainfo' ) ?? $args['sslcertificates'];

    return $args;
}, 0, 1 );