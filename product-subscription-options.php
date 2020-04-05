<?php

// exit if accessed directly
if (!defined('ABSPATH')) exit;

$subscription_options = $hidden_options = array();

$tip_text = sprintf(__('We’ll ship your favorite %s products based on the schedule that you select. This way, you will never run out. You can change the schedule, pause, or cancel anytime.'), get_company_name());

foreach ($options as $option) {

	// visible controls
	if ($option['value'] == 0) {

		$one_time_option = "<li". ($option['selected'] ? " class='selected'" : "") .">".
			"<input type='radio' id='one-time-purchase' name='purchase-options' value='one-time'". ($option['selected'] ? " checked" : "") ." />".
			"<label for='one-time-purchase'>". __('One-Time Purchase') ."</label></li>\n";

	} else {

		if ($option['selected'])
			$selected_subscription_option = $option['selected'];

		$subscription_options[] = "<option value='". $option['value'] ."'". ($option['selected'] ? " selected" : "") .">".
			sprintf('%d %s', $option['data']['subscription_scheme']['interval'], ucfirst($option['data']['subscription_scheme']['period'])) ."</option>\n";
	}

	// hidden controls
	$hidden_options[] = sprintf('<li class="%1$s"><label><input type="radio" name="convert_to_sub_%2$d" data-custom_data="%3$s" value="%4$s" %5$s autocomplete="off" />'.
		'<span class="%1$s-details">%6$s</span></label></li>',
			esc_attr($option['class']),
			absint($product_id),
			esc_attr(json_encode($option['data'])),
			esc_attr($option['value']),
			checked($option['selected'], true, false),
			$option['description']
	);
}

echo
"<ul class='purchase-options'>\n".

	(isset($one_time_option) ? $one_time_option : "").

	($subscription_options ? "<li". (isset($selected_subscription_option) ? " class='selected'" : "") .">".
		"<input type='radio' id='subscriptions-list' name='purchase-options' value='subscription'". (isset($selected_subscription_option) ? " checked" : "") ." />\n".
		"<label for='subscriptions-list'>". ($prompt ? strip_tags($prompt) : __('Choose a subscription plan:')) ."</label>\n".
		"<select name='subscription-options'>". implode('', $subscription_options) ."</select>\n" : "").
		get_help_icon($tip_text) ."</li>\n".

"</ul>\n".

"<div class='wcsatt-options-wrapper' style='display: none;'>\n".

	"<ul class='wcsatt-options-product'>\n".
		implode('', $hidden_options).
	"</ul>\n".

"</div>\n";
