<?php
/**
 * @package
 * @version 1.0
 */
/*
Plugin Name: Woo Rss Dynamic Price
Plugin URI: http://abc.com
Description:  Auto get pricing from cookson-clal.com rss then update price for product base on unit and product mental type.
Author: Danng
Version: 1.0
Author URI: http://ma.tt/
*/

define('IS_AUTOMATIC_PRICING', true);
define('RSS_DEBUG', true);

require __DIR__ .'/rss_functions.php';
require __DIR__ .'/fe_filter_price.php';
require __DIR__ .'/admin_update_pricing.php';


Class Woo_Rss_Dynamic_Price{

	const 	RSS_URL 			= 'https://www.cookson-clal.com/mp/rss_mpfr_cdl.jsp';
	const   TRANS_PRICING 		= 'woo_rss_pricing';
	const   TRANS_PRICING_TIME 	= 'woo_update_rss_time';
	const 	LIST_METAL 			= array('OR','ARGENT','PLATINE','PALLADIUM');
	const   RSS_FETCH_SECOND	 = 10*60;
	function __construct(){

	}

	static function fetch_rss(){
		$response 		= wp_remote_get(self::RSS_URL,   array('sslverify' => FALSE) );
		if ( is_array( $response ) && ! is_wp_error( $response ) ) {
			$responseBody 	= wp_remote_retrieve_body( $response);
	    	$xml  			= simplexml_load_string($responseBody);
	    	$opt_values 	= array();

	    	foreach($xml->channel->item as $item=>$value){

	    		$title = $value->title->__toString();
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
	    	set_transient(self::TRANS_PRICING, $opt_values, self::RSS_FETCH_SECOND);
	    	return $opt_values;
	    } else {
	    	if(RSS_DEBUG){ wp_die('can not fetch rss'); }
	    }
	}

	static  function get_pricing(){

		$values = get_transient(self::TRANS_PRICING);
		if (!$values) {
			$values = self::fetch_rss();
		}

		return (object) $values;

	}
}
new Woo_Rss_Dynamic_Price();
