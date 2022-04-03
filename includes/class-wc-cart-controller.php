<?php
class Cart_Controller {
	public function __construct() {
		add_filter( 'woocommerce_cart_calculate_fees', array( __CLASS__, 'automatic_cart_apply_discount' ) );
	}

	public static function automatic_cart_apply_discount( $cart ) {
		if( !is_user_logged_in() ) {
			return;
		}
		$user_id = get_current_user_id();
		$customer = new WC_Customer( $user_id );
		$previous_orders = $customer->get_order_count();
		if( 0 < $previous_orders ) {
			return;
		}

		$subtotal = $cart->subtotal;
		$discount_percentage = 40;
		$discount = ( $discount_percentage / 100 ) * $subtotal;

		$cart->add_fee( 'First Online Order', -$discount );
	}
}

new Cart_Controller();
