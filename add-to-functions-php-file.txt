/*
 * Product subscriptions
 */

function get_company_name($echo = false){

	if (function_exists('get_field'))
		$output = get_field('company', 'option');

	if (empty($output))
		$output = get_bloginfo('name');

	if ($echo) echo $output;
	else return $output;
}


function get_help_icon($content, $type = 'text', $echo = false){

	if ($type == 'image') {

		$class = 'covering-image';
		$content = "<img src='$content' alt='' />";

	} else $class = 'with-paddings';

	$output = "<span class='help-icon'>\n".
		"<span class='help-icon-inner fa fa-question-circle'></span>\n".
		($content ? "<span class='help-icon-hover $class'><span class='help-icon-hover-inner'>$content</span></span>\n" : "").
		"</span>\n";

	if ($echo) echo $output;
	else return $output;
}

/*
 * Product subscriptions: Cart
 */

// Remove filters added by "WC Subscriptions" and "WC All Products For Subscriptions"
remove_filter( 'woocommerce_cart_item_price', array( 'WCS_ATT_Display_Cart', 'show_cart_item_subscription_options' ), 1000, 3 );
remove_filter( 'woocommerce_cart_item_subtotal', array( 'WC_Subscriptions_Switcher', 'add_cart_item_switch_direction' ), 10, 3 );
