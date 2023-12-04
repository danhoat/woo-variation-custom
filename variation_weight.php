<?php

function custom_weight_variation($html, $args){
	if($args['attribute'] === 'pa_weight'){
		$html = '<input type="number" id="quantity_656d41efd2796" class="input-text qty text" name="quantity" value="1" aria-label="Product quantity" size="4" min="1" max="11" step="1" placeholder="" inputmode="" autocomplete="off"><label> kg</label>';
	}
	return $html;
}
add_filter('woocommerce_dropdown_variation_attribute_options_html', 'custom_weight_variation', 10,2);