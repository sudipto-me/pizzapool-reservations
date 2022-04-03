<?php

class Order_Types {
	public static function init() {
		add_action( 'init', array( __CLASS__, 'add_custom_order_types' ) );
		add_filter( 'woocommerce_data_stores', array( __CLASS__, 'add_custom_data_stores' ) );
	}

	public static function add_custom_order_types() {
		if ( post_type_exists( 'order_dine_in' ) ) {
			return;
		}
		if ( ! function_exists( 'wc_register_order_type' ) ) {
			return;
		}
		wc_register_order_type( 'order_dine_in', apply_filters( 'pizzapool_register_post_type_order_dine_in', array(
			'label'                            => __( 'Order Dine Ins', 'pizzapool-reservations' ),
			'description'                      => __( 'This is where store order dine ins are stored.', 'pizzapool-reservations' ),
			'public'                           => true,
			'show_ui'                          => true,
			'capability_type'                  => 'shop_order',
			'map_meta_cap'                     => true,
			'publicly_queryable'               => true,
			'exclude_from_search'              => true,
			'show_in_menu'                     => true,
			'hierarchical'                     => false,
			'show_in_nav_menus'                => true,
			'rewrite'                          => true,
			'query_var'                        => false,
			'supports'                         => array( 'title', 'comments', 'custom-fields' ),
			'has_archive'                      => false,
			'exclude_from_orders_screen'       => true,
			'add_order_meta_boxes'             => true,
			'exclude_from_order_count'         => true,
			'exclude_from_order_views'         => true,
			'exclude_from_order_reports'       => true,
			'exclude_from_order_sales_reports' => true,
			'class_name'                       => 'WC_Order'
		) ) );
	}

	public static function add_custom_data_stores( $stores ) {
		$stores['dine-in'] = 'WC_Order_Dine_In_Data_Store_CPT';

		return $stores;
	}
}

Order_Types::init();
