<?php 
/**
 * Main "Case" Custom Post Type (CPT)
 */
add_action('init', 'cptui_register_my_cpt_case');
function cptui_register_my_cpt_case() {
	register_post_type('case', array(
		'label' => 'Cases',
		'description' => '',
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'capability_type' => 'post',
		'map_meta_cap' => true,
		'hierarchical' => false,
		'rewrite' => array('slug' => 'case', 'with_front' => true),
		'query_var' => true,
		'supports' => array('editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
		'labels' => array (
			'name' => 'Cases',
			'singular_name' => 'Case',
			'menu_name' => 'Cases',
			'add_new' => 'Add Case',
			'add_new_item' => 'Add New Case',
			'edit' => 'Edit',
			'edit_item' => 'Edit Case',
			'new_item' => 'New Case',
			'view' => 'View Case',
			'view_item' => 'View Case',
			'search_items' => 'Search Cases',
			'not_found' => 'No Cases Found',
			'not_found_in_trash' => 'No Cases Found in Trash',
			'parent' => 'Parent Case',
		)
	));
}

/**
 * Custom Taxonomies for "Case" CPT
 */

// Status
add_action('init', 'cptui_register_my_taxes_status');
function cptui_register_my_taxes_status() {
	register_taxonomy( 'status', array (
		0 => 'case',
		), array(
			'hierarchical' => true,
			'label' => 'Statuses',
			'show_ui' => true,
			'query_var' => true,
			'show_admin_column' => true,
			'labels' => array (
				'search_items' => 'Status',
				'popular_items' => '',
				'all_items' => 'All Statuses',
				'parent_item' => '',
				'parent_item_colon' => '',
				'edit_item' => '',
				'update_item' => '',
				'add_new_item' => '',
				'new_item_name' => '',
				'separate_items_with_commas' => '',
				'add_or_remove_items' => '',
				'choose_from_most_used' => '',
			)
		)
	);
}

// Source
add_action('init', 'cptui_register_my_taxes_source');
function cptui_register_my_taxes_source() {
	register_taxonomy( 'source', array (
		0 => 'case',
		),
	array( 'hierarchical' => true,
		'label' => 'Sources',
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'labels' => array (
			'search_items' => 'Source',
			'popular_items' => '',
			'all_items' => 'All Sources',
			'parent_item' => '',
			'parent_item_colon' => '',
			'edit_item' => '',
			'update_item' => '',
			'add_new_item' => '',
			'new_item_name' => '',
			'separate_items_with_commas' => '',
			'add_or_remove_items' => '',
			'choose_from_most_used' => '',
			)
		)
	); 
}

// priority
add_action('init', 'cptui_register_my_taxes_priority');
function cptui_register_my_taxes_priority() {
	register_taxonomy( 'priority', array (
		0 => 'case',
		),
	array( 'hierarchical' => true,
		'label' => 'Priorities',
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'labels' => array (
			'search_items' => 'Priority',
			'popular_items' => '',
			'all_items' => 'All Priorities',
			'parent_item' => '',
			'parent_item_colon' => '',
			'edit_item' => '',
			'update_item' => '',
			'add_new_item' => '',
			'new_item_name' => '',
			'separate_items_with_commas' => '',
			'add_or_remove_items' => '',
			'choose_from_most_used' => '',
			)
		)
	);
}

// Type (Rescue or Tracing)
add_action('init', 'cptui_register_my_taxes_type');
function cptui_register_my_taxes_type() {
	register_taxonomy( 'type', array (
		0 => 'case',
		),
	array( 'hierarchical' => true,
		'label' => 'Types',
		'show_ui' => true,
		'query_var' => true,
		'show_admin_column' => true,
		'labels' => array (
			'search_items' => 'Type',
			'popular_items' => '',
			'all_items' => 'All Types',
			'parent_item' => '',
			'parent_item_colon' => '',
			'edit_item' => '',
			'update_item' => '',
			'add_new_item' => '',
			'new_item_name' => '',
			'separate_items_with_commas' => '',
			'add_or_remove_items' => '',
			'choose_from_most_used' => '',
			)
		) 
	);
}

/**
 * Custom Fields for "Case" CPT
 */
if(function_exists("register_field_group")) {
	register_field_group(array (
		'id' => 'acf_case-details',
		'title' => 'Case Details',
		'fields' => array (
			array (
				'key' => 'field_52899c287a8c1',
				'label' => __('Location'),
				'name' => 'location',
				'type' => 'textarea',
				'instructions' => __('Approximate address information'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52899ca17a8c2',
				'label' => __('Reported By'),
				'name' => 'reported_by',
				'type' => 'textarea',
				'instructions' => __('Who was the information reported by'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52899cdd7a8c3',
				'label' => __('Contact Info'),
				'name' => 'contact_info',
				'type' => 'textarea',
				'instructions' => __('Information regarding whom to contact'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52899ed87a8c5',
				'label' => __('Concern'),
				'name' => 'concern',
				'type' => 'textarea',
				'instructions' => __('Main concerns for this case'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_52899ff347382',
				'label' => __('Latitude'),
				'name' => 'latitude',
				'type' => 'number',
				'instructions' => __('Latitude'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
			array (
				'key' => 'field_5289a02147383',
				'label' => __('Longitude'),
				'name' => 'longitude',
				'type' => 'number',
				'instructions' => __('Longitude'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'min' => '',
				'max' => '',
				'step' => '',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'case',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'excerpt',
				1 => 'discussion',
				2 => 'comments',
				3 => 'slug',
				4 => 'author',
				5 => 'format',
				6 => 'categories',
				7 => 'tags',
				8 => 'send-trackbacks',
				9 => 'custom-fields',
			),
		),
		'menu_order' => 0,
	));
}

?>