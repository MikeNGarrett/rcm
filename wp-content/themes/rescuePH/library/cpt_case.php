<?php 

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
'supports' => array('title','editor','excerpt','trackbacks','custom-fields','comments','revisions','thumbnail','author','page-attributes','post-formats'),
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
) ); }

add_action('init', 'cptui_register_my_taxes_status');
function cptui_register_my_taxes_status() {
register_taxonomy( 'status',array (
  0 => 'case',
),
array( 'hierarchical' => true,
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
) );
}

add_action('init', 'cptui_register_my_taxes_priority');
function cptui_register_my_taxes_priority() {
register_taxonomy( 'priority',array (
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
) );
}

add_action('init', 'cptui_register_my_taxes_type');
function cptui_register_my_taxes_type() {
register_taxonomy( 'type',array (
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
) );
}


if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_case-details',
		'title' => 'Case Details',
		'fields' => array (
			array (
				'key' => 'field_527fbfe0c47d8',
				'label' => __('Getting Started'),
				'name' => '',
				'type' => 'message',
				'message' => 'Fill in as much information as possible.

	Below you\'ll see a number of tabs:
	<strong>General Info</strong> - quick summary of the request along with internal notes.
	<strong>On Behalf of</strong> - Fill this out if someone is making this request for someone else.
	<strong>Rescue</strong> - Fill this in if this request is for assistance.
	<strong>Tracing</strong> - Fill this in if the request is for tracing purposes.',
			),
			array (
				'key' => 'field_527fbe326045d',
				'label' => __('General Information'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_527fcf4ae7e4b',
				'label' => __('Instructions'),
				'name' => '',
				'type' => 'message',
				'message' => 'To get started add in a brief summary of the request and and internal notes as needed.

	These internal notes will only show for anyone logged into this system and looking at the case from the back-end.',
			),
			array (
				'key' => 'field_527fb48ba3094',
				'label' => __('Summary'),
				'name' => 'summary',
				'type' => 'textarea',
				'instructions' => __('Provide a quick description in as few words as possible.'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => 250,
				'formatting' => 'br',
			),
			array (
				'key' => 'field_527fd1e4650fb',
				'label' => __('Status'),
				'name' => 'status',
				'type' => 'taxonomy',
				'instructions' => __('Use this field to keep the status of this task up to date. '),
				'taxonomy' => 'status',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => 1,
				'return_format' => 'object',
				'multiple' => 0,
			),
			array (
				'key' => 'field_527fd229650fc',
				'label' => __('Priority'),
				'name' => 'priority',
				'type' => 'taxonomy',
				'instructions' => __('How urgent is this task? Does this person need immediate assistance? '),
				'taxonomy' => 'priority',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => 1,
				'return_format' => 'object',
				'multiple' => 0,
			),
			array (
				'key' => 'field_527fd25c650fd',
				'label' => __('Request Type'),
				'name' => 'type',
				'type' => 'taxonomy',
				'instructions' => __('Select whether this is a rescue request or a tracing request. '),
				'taxonomy' => 'type',
				'field_type' => 'select',
				'allow_null' => 0,
				'load_save_terms' => 1,
				'return_format' => 'object',
				'multiple' => 0,
			),
			array (
				'key' => 'field_527f1a6899b15',
				'label' => __('Internal Notes'),
				'name' => 'internal_notes',
				'type' => 'wysiwyg',
				'instructions' => __('These notes will only be available to other volunteers that have logged in. '),
				'default_value' => '',
				'toolbar' => 'basic',
				'media_upload' => 'yes',
			),
			array (
				'key' => 'field_527fbed660460',
				'label' => __('On Behalf of'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_527fd099e7e4c',
				'label' => __('Instructions'),
				'name' => '',
				'type' => 'message',
				'message' => 'Fill in these fields if the request has been made by a third party, eg a daughter looking for her mother.
	Fill in the name, contact info and source of the person making the request so we can get back in touch with them after the status has changed.',
			),
			array (
				'key' => 'field_527f200d7dc3f',
				'label' => __('Requester Name'),
				'name' => 'requester_name',
				'type' => 'text',
				'instructions' => __('The requester\'s name.'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_527f1a2999b14',
				'label' => __('Requester Contact Info'),
				'name' => 'requester_contact_info',
				'type' => 'text',
				'instructions' => __('How can we get back in touch with the person who made this request?'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_527f197899b13',
				'label' => __('Request Source'),
				'name' => 'request_source',
				'type' => 'select',
				'instructions' => __('Select the source of this request.'),
				'choices' => array (
					'Phone Call' => 'Phone Call',
					'SMS' => 'SMS',
					'Email' => 'Email',
					'In-Person' => 'In-Person',
					'Twitter' => 'Twitter',
					'Facebook' => 'Facebook',
					'Other Social Media' => 'Other Social Media',
					'Other' => 'Other',
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 1,
			),
			array (
				'key' => 'field_527fbe616045e',
				'label' => __('Rescue'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_527fd0fee7e4d',
				'label' => __('Instructions'),
				'name' => '',
				'type' => 'message',
				'message' => 'Fill out these fields if the request is for assistance or rescue.

	Fill in as much information as possible.',
			),
			array (
				'key' => 'field_527fbf6018341',
				'label' => __('Name of Person in Need'),
				'name' => 'name',
				'type' => 'text',
				'instructions' => __('Who needs help?'),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_527fbf8e18342',
				'label' => __('Contact of Person in Need'),
				'name' => 'contact',
				'type' => 'textarea',
				'instructions' => __('How do we get in touch with this person. Please be as detailed as possible.'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_527f1be7ab4f0',
				'label' => __('Rescue Location'),
				'name' => 'rescue_location',
				'type' => 'location-field',
				'instructions' => __('Where is the incident?'),
				'val' => 'address',
				'mapheight' => 300,
				'center' => '11.680480,122.783203',
				'zoom' => 5,
				'scrollwheel' => 0,
				'mapTypeControl' => 0,
				'streetViewControl' => 1,
				'PointOfInterest' => 1,
			),
			array (
				'key' => 'field_527fbe926045f',
				'label' => __('Tracing'),
				'name' => '',
				'type' => 'tab',
			),
			array (
				'key' => 'field_527fd12be7e4e',
				'label' => __('Instructions'),
				'name' => '',
				'type' => 'message',
				'message' => 'Fill in this section for any tracing (missing persons) requests.
	The tracing name and last seen locations should be about the person being searched for.

	Any other information that could be of assistance should be added to the text area below.',
			),
			array (
				'key' => 'field_527fb32da3092',
				'label' => __('Tracing Name'),
				'name' => 'tracing_name',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'formatting' => 'html',
				'maxlength' => '',
			),
			array (
				'key' => 'field_527fb43ca3093',
				'label' => __('Tracing Last Seen Location'),
				'name' => 'tracing_location',
				'type' => 'location-field',
				'instructions' => __('Where was this person last seen?'),
				'val' => 'address',
				'mapheight' => 300,
				'center' => '11.680480,122.783203',
				'zoom' => 5,
				'scrollwheel' => 0,
				'mapTypeControl' => 0,
				'streetViewControl' => 1,
				'PointOfInterest' => 1,
			),
			array (
				'key' => 'field_527f20347dc40',
				'label' => __('Tracing Information'),
				'name' => 'tracing_information',
				'type' => 'textarea',
				'instructions' => __('Any information provided about the person trying to be found.'),
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
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
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
				0 => 'excerpt',
				1 => 'custom_fields',
				2 => 'discussion',
				3 => 'comments',
				4 => 'slug',
				5 => 'author',
				6 => 'format',
				7 => 'featured_image',
				8 => 'categories',
				9 => 'tags',
				10 => 'send-trackbacks',
			),
		),
		'menu_order' => 0,
	));
}
?>