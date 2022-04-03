<?php

class Order_Types {
	public function __construct() {
		add_filter( 'wc_order_types', array( __CLASS__, 'custom_order_types'), 10, 2);
	}

	public static function custom_order_types( $order_types, $for ) {
		//$order_types[] = 'shop_order_dine_in';
		return $order_types;
	}
}

new Order_Types();
