<?php

class Cart_Controller {
	public function __construct() {
		add_filter( 'woocommerce_cart_calculate_fees', array( __CLASS__, 'automatic_cart_apply_discount' ) );
		add_filter( 'woocommerce_variation_is_purchasable', array( __CLASS__, 'conditionally_disable_product_purchase' ), 10, 2 );
		add_filter( 'woocommerce_is_purchasable', array( __CLASS__, 'conditionally_disable_product_purchase' ), 10, 2 );

		add_action( 'woocommerce_check_cart_items', array( __CLASS__, 'conditionally_allow_checkout' ) );
		add_action( 'woocommerce_check_cart_items', array( __CLASS__, 'conditionally_allow_checkout' ) );

		add_action( 'template_redirect', array( __CLASS__, 'closing_shop_notice' ) );
	}

	public static function automatic_cart_apply_discount( $cart ) {
		if ( ! is_user_logged_in() ) {
			return;
		}
		$user_id         = get_current_user_id();
		$customer        = new WC_Customer( $user_id );
		$previous_orders = $customer->get_order_count();
		if ( 0 < $previous_orders ) {
			return;
		}

		$subtotal            = $cart->subtotal;
		$discount_percentage = 40;
		$discount            = ( $discount_percentage / 100 ) * $subtotal;

		$cart->add_fee( 'First Online Order', - $discount );
	}

	public static function conditionally_disable_product_purchase( $purchasable, $product ) {
		$current_day = date( "l" );
		if ( 'Sunday' === $current_day || 'Monday' === $current_day || 'Tuesday' === $current_day || 'Wednesday' === $current_day ) {
			$purchasable = false;
		} elseif ( 'Thursday' === $current_day ) {
			$current_time = time();
			$opening_time = DateTime::createFromFormat( 'H:i:s', '16:00:00' )->format( "d-M-y H:i:s" );
			$closing_time = DateTime::createFromFormat( 'H:i:s', '22:00:00' )->format( "d-M-y H:i:s" );

			if ( $current_time > strtotime( $closing_time ) && $current_time < strtotime( $opening_time ) ) {
				$purchasable = false;
			} else {
				$purchasable = true;
			}
		} elseif ( 'Friday' === $current_day || 'Saturday' === $current_day ) {
			$current_time = time();
			$opening_time = DateTime::createFromFormat( 'H:i:s', '12:00:00' )->format( "d-M-y H:i:s" );
			$closing_time = DateTime::createFromFormat( 'H:i:s', '22:00:00' )->format( "d-M-y H:i:s" );

			if ( $current_time > strtotime( $closing_time ) && $current_time < strtotime( $opening_time ) ) {
				$purchasable = false;
			} else {
				$purchasable = true;
			}
		}

		return $purchasable;
	}

	public static function conditionally_allow_checkout() {
		$current_day = date( "l" );
		if ( 'Sunday' === $current_day || 'Monday' === $current_day || 'Tuesday' === $current_day || 'Wednesday' === $current_day ) {
			$purchasable = false;
		} elseif ( 'Thursday' === $current_day ) {
			$current_time = time();
			$opening_time = DateTime::createFromFormat( 'H:i:s', '16:00:00' )->format( "d-M-y H:i:s" );
			$closing_time = DateTime::createFromFormat( 'H:i:s', '22:00:00' )->format( "d-M-y H:i:s" );

			if ( $current_time > strtotime( $closing_time ) && $current_time < strtotime( $opening_time ) ) {
				$purchasable = false;
			} else {
				$purchasable = true;
			}
		} elseif ( 'Friday' === $current_day || 'Saturday' === $current_day ) {
			$current_time = time();
			$opening_time = DateTime::createFromFormat( 'H:i:s', '12:00:00' )->format( "d-M-y H:i:s" );
			$closing_time = DateTime::createFromFormat( 'H:i:s', '22:00:00' )->format( "d-M-y H:i:s" );

			if ( $current_time > strtotime( $closing_time ) && $current_time < strtotime( $opening_time ) ) {
				$purchasable = false;
			} else {
				$purchasable = true;
			}
		}

		if ( false === $purchasable ) {
			wc_add_notice( __( 'Pizza Pool is close. Please check when the shop opens' ), 'error' );
		}
	}

	public static function closing_shop_notice() {
		$current_day = date( "l" );
		if ( 'Sunday' === $current_day || 'Monday' === $current_day || 'Tuesday' === $current_day || 'Wednesday' === $current_day ) {
			$purchasable = false;
		} elseif ( 'Thursday' === $current_day ) {
			$current_time = time();
			$opening_time = DateTime::createFromFormat( 'H:i:s', '16:00:00' )->format( "d-M-y H:i:s" );
			$closing_time = DateTime::createFromFormat( 'H:i:s', '22:00:00' )->format( "d-M-y H:i:s" );

			if ( $current_time > strtotime( $closing_time ) && $current_time < strtotime( $opening_time ) ) {
				$purchasable = false;
			} else {
				$purchasable = true;
			}
		} elseif ( 'Friday' === $current_day || 'Saturday' === $current_day ) {
			$current_time = time();
			$opening_time = DateTime::createFromFormat( 'H:i:s', '12:00:00' )->format( "d-M-y H:i:s" );
			$closing_time = DateTime::createFromFormat( 'H:i:s', '22:00:00' )->format( "d-M-y H:i:s" );

			if ( $current_time > strtotime( $closing_time ) && $current_time < strtotime( $opening_time ) ) {
				$purchasable = false;
			} else {
				$purchasable = true;
			}
		}

		if ( !(is_cart () || is_checkout() ) && false === $purchasable ) {
			wc_add_notice( __( 'Pizza Pool is close. Please check when the shop opens' ), 'error' );
		}
	}

}

new Cart_Controller();
