<?php
add_filter( 'rwmb_meta_boxes', 'your_prefix_register_meta_boxes' );

function your_prefix_register_meta_boxes( $meta_boxes ) {
	$prefix = '';

	$meta_boxes[] = array (
		'title' => esc_html__( 'Page fields', 'text-domain' ),
		'id' => 'page-fields',
		'post_types' => 'page',
		'context' => 'side',
		'priority' => 'high',
		'fields' => array(
			array(
			    'name'            => 'Select Layout',
			    'id'              => 'pagelayout',
			    'type'            => 'select',
			    // Array of 'value' => 'Label' pairs
			    'options'         => array(
			        'nosidebar'       => 'No Sidebar',
			        'sidebar' => 'Sidebar',
			    ),
			    // Allow to select multiple value?
			    'multiple'        => false,  // true / false
			    // Placeholder text
			    'placeholder'     => 'Select a layout',
			    // Display "Select All / None" button?
			    'select_all_none' => false,  // true / false
			),
			array (
				'id' => 'hide_header',
				'type' => 'switch',
				'name' => esc_html__( 'Hide Header?', 'text-domain' ),
				'style' => 'rounded',
				'on_label' => 'Yes',
				'off_label' => 'No',
			),

		),
	);

	return $meta_boxes;
}