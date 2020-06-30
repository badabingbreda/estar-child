<?php


add_action( 'init', 'register_cpt_property' );

/**
 * Register a CPT
 */
function register_cpt_property() {

    $args = array (
        'label' => esc_html__( 'Properties', 'text-domain' ),
        'labels' => array(
            'menu_name' => esc_html__( 'Properties', 'text-domain' ),
            'name_admin_bar' => esc_html__( 'Property', 'text-domain' ),
            'add_new' => esc_html__( 'Add new', 'text-domain' ),
            'add_new_item' => esc_html__( 'Add new Property', 'text-domain' ),
            'new_item' => esc_html__( 'New Property', 'text-domain' ),
            'edit_item' => esc_html__( 'Edit Property', 'text-domain' ),
            'view_item' => esc_html__( 'View Property', 'text-domain' ),
            'update_item' => esc_html__( 'Update Property', 'text-domain' ),
            'all_items' => esc_html__( 'All Properties', 'text-domain' ),
            'search_items' => esc_html__( 'Search Properties', 'text-domain' ),
            'parent_item_colon' => esc_html__( 'Parent Property', 'text-domain' ),
            'not_found' => esc_html__( 'No Properties found', 'text-domain' ),
            'not_found_in_trash' => esc_html__( 'No Properties found in Trash', 'text-domain' ),
            'name' => esc_html__( 'Properties', 'text-domain' ),
            'singular_name' => esc_html__( 'Property', 'text-domain' ),
        ),
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-admin-post',
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite_no_front' => false,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
        'rewrite' => true,
    );

    register_post_type( 'property', $args );
}


add_action( 'init', 'register_cpt_agent' );

/**
 * Register a CPT
 */
function register_cpt_agent() {

    $args = array (
        'label' => esc_html__( 'Agents', 'text-domain' ),
        'labels' => array(
            'menu_name' => esc_html__( 'Agents', 'text-domain' ),
            'name_admin_bar' => esc_html__( 'Agent', 'text-domain' ),
            'add_new' => esc_html__( 'Add new', 'text-domain' ),
            'add_new_item' => esc_html__( 'Add new Agent', 'text-domain' ),
            'new_item' => esc_html__( 'New Agent', 'text-domain' ),
            'edit_item' => esc_html__( 'Edit Agent', 'text-domain' ),
            'view_item' => esc_html__( 'View Agent', 'text-domain' ),
            'update_item' => esc_html__( 'Update Agent', 'text-domain' ),
            'all_items' => esc_html__( 'All Agents', 'text-domain' ),
            'search_items' => esc_html__( 'Search Agents', 'text-domain' ),
            'parent_item_colon' => esc_html__( 'Parent Agent', 'text-domain' ),
            'not_found' => esc_html__( 'No Agents found', 'text-domain' ),
            'not_found_in_trash' => esc_html__( 'No Agents found in Trash', 'text-domain' ),
            'name' => esc_html__( 'Agents', 'text-domain' ),
            'singular_name' => esc_html__( 'Agent', 'text-domain' ),
        ),
        'public' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => false,
        'menu_icon' => 'dashicons-admin-post',
        'capability_type' => 'post',
        'hierarchical' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite_no_front' => false,
        'supports' => array(
            'title',
            'editor',
            'thumbnail',
        ),
        'rewrite' => true,
    );

    register_post_type( 'agent', $args );
}

add_action( 'mb_relationships_init', function() {
    MB_Relationships_API::register( array(
        'id'   => 'property_to_agent',
        'from' => array(
            'object_type' => 'post',
            'post_type'		=> 'property',
            'meta_box'    => array(
                'title'       => 'Managed by',
                'context'	=> 'normal',
                'field_title' => 'Select an Agent',
            	),
        	),
        'to'   => array(
            'object_type' => 'post',
            'post_type'   => 'agent',
            'meta_box'    => array(
                'title'         => 'Manages',
                'context'       => 'normal',
                'empty_message' => 'No properties',
            	),
        	)
    	));
} );

add_action( 'init', 'register_property_tax_prop_type', 0 );

/**
 * Register a taxonomy
 *
 */
function register_property_tax_prop_type() {

    $args = array (
        'label' => esc_html__( 'Property Types', 'text-domain' ),
        'labels' => array(
            'menu_name' => esc_html__( 'Property Types', 'text-domain' ),
            'all_items' => esc_html__( 'All Property Types', 'text-domain' ),
            'edit_item' => esc_html__( 'Edit Property Type', 'text-domain' ),
            'view_item' => esc_html__( 'View Property Type', 'text-domain' ),
            'update_item' => esc_html__( 'Update Property Type', 'text-domain' ),
            'add_new_item' => esc_html__( 'Add new Property Type', 'text-domain' ),
            'new_item_name' => esc_html__( 'New Property Type', 'text-domain' ),
            'parent_item' => esc_html__( 'Parent Property Type', 'text-domain' ),
            'parent_item_colon' => esc_html__( 'Parent Property Type:', 'text-domain' ),
            'search_items' => esc_html__( 'Search Property Types', 'text-domain' ),
            'popular_items' => esc_html__( 'Popular Property Types', 'text-domain' ),
            'separate_items_with_commas' => esc_html__( 'Separate Property Types with commas', 'text-domain' ),
            'add_or_remove_items' => esc_html__( 'Add or remove Property Types', 'text-domain' ),
            'choose_from_most_used' => esc_html__( 'Choose most used Property Types', 'text-domain' ),
            'not_found' => esc_html__( 'No Property Types found', 'text-domain' ),
            'name' => esc_html__( 'Property Types', 'text-domain' ),
            'singular_name' => esc_html__( 'Property Type', 'text-domain' ),
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => false,
        'show_in_rest' => false,
        'hierarchical' => true,
        'query_var' => true,
        'sort' => false,
        'rewrite_no_front' => false,
        'rewrite_hierarchical' => false,
        'rewrite' => true,
    );

    register_taxonomy( 'prop_type', array( 'property' ), $args );
}

add_action( 'init', 'register_property_tax_prop_status', 0 );

/**
 * Register a taxonomy
 *
 */
function register_property_tax_prop_status() {

    $args = array (
        'label' => esc_html__( 'Prop Status', 'text-domain' ),
        'labels' => array(
            'menu_name' => esc_html__( 'Prop Status', 'text-domain' ),
            'all_items' => esc_html__( 'All Prop Status', 'text-domain' ),
            'edit_item' => esc_html__( 'Edit Prop Status', 'text-domain' ),
            'view_item' => esc_html__( 'View Prop Status', 'text-domain' ),
            'update_item' => esc_html__( 'Update Prop Status', 'text-domain' ),
            'add_new_item' => esc_html__( 'Add new Prop Status', 'text-domain' ),
            'new_item_name' => esc_html__( 'New Prop Status', 'text-domain' ),
            'parent_item' => esc_html__( 'Parent Prop Status', 'text-domain' ),
            'parent_item_colon' => esc_html__( 'Parent Prop Status:', 'text-domain' ),
            'search_items' => esc_html__( 'Search Prop Status', 'text-domain' ),
            'popular_items' => esc_html__( 'Popular Prop Status', 'text-domain' ),
            'separate_items_with_commas' => esc_html__( 'Separate Prop Status with commas', 'text-domain' ),
            'add_or_remove_items' => esc_html__( 'Add or remove Prop Status', 'text-domain' ),
            'choose_from_most_used' => esc_html__( 'Choose most used Prop Status', 'text-domain' ),
            'not_found' => esc_html__( 'No Prop Status found', 'text-domain' ),
            'name' => esc_html__( 'Prop Status', 'text-domain' ),
            'singular_name' => esc_html__( 'Prop Status', 'text-domain' ),
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_quick_edit' => true,
        'show_admin_column' => false,
        'show_in_rest' => false,
        'hierarchical' => false,
        'query_var' => true,
        'sort' => false,
        'rewrite_no_front' => false,
        'rewrite_hierarchical' => false,
        'rewrite' => true,
    );

    register_taxonomy( 'prop_status', array( 'property' ), $args );
}
