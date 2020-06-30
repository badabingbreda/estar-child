<?php

/**
 * http://modern.realhomes.io/property/villa-on-grand-avenue/
 */


add_filter( 'rwmb_meta_boxes', 'property_meta_box' );
/**
 * Create a Meta Box, anonymously
 */
function property_meta_box( $meta_boxes ) {

    $options = array();

    $agents = get_posts( array( 'post_type' => 'agent' ) );
    if ( $agents ) {
        foreach ($agents as $posts ) {
            $options = array_merge( $options , array( "$posts->ID" => "$posts->post_title" ));
        }
    }

   $meta_boxes[] = array(
        'title'  => 'Real Estate Property',
        'id'     =>  'real-estate-property',
        'post_types'    => array(
            'property',
        ),
        'context'   => 'normal',   // normal / advanced / side / form_top / after_title / after_editor / before_permalink
        'priority'  => 'high',      // high / low
        'fields' => array(
        // fields go here
            // array(
            //     'id'    => 'agent',
            //     'options' => $options, // array( 'one' => 'One', 'two' => 'Two', 'three' => 'Three', 'four' => 'Four', 'five' => 'Five', 'six'=> 'Six' ),
            //     'name'  => 'Select the Agent(s)',
            //     'type'  => 'sortabledrop',
            //     'shared'    => true,
            // ),
        	array(	// Property ID
        	    'name'        => 'Property ID',
        	    'label_description' => 'ID',
        	    'id'          => 'property_id',
        	    'desc'        => 'Please provide a property description',
        	    'type'        => 'text',

        	    // Default value (optional)
        	    // 'std'         => 'default_value',

        	    // Cloneable (i.e. have multiple value)?
        	    'clone'       => false,

        	    // Placeholder
        	    'placeholder' => false,

        	    // Input size
        	    'size'        => 30,

        	//    // Datalist
        	//    'datalist'    => array(
        	//        // Unique ID for datalist. Optional.
        	//        'id'      => 'text_datalist',
        	//        // List of predefined options
        	//        'options' => array(
        	//            'What',
        	//            'When',
        	//            'Where',
        	//            'Why',
        	//            'Who',
        	//        ),
        	//    ),
        	),
        	array(	// property type
        	    'name'       => 'Property Type',
        	    'id'         => 'property_type',
        	    'type'       => 'taxonomy',

        	    // Taxonomy slug.
        	    'taxonomy'   => 'prop_type',

        	    // How to show taxonomy.
        	    'field_type' => 'select_advanced',      // select / select_advanced / select_tree / checkbox_list / checkbox_tree / radio_list
        	),
        	array(	// property status
        	    'name'       => 'Property Status',
        	    'id'         => 'property_status',
        	    'type'       => 'taxonomy',

        	    // Taxonomy slug.
        	    'taxonomy'   => 'prop_status',

        	    // How to show taxonomy.
        	    'field_type' => 'select',      // select / select_advanced / select_tree / checkbox_list / checkbox_tree / radio_list
        	),
            array(  // divider
                'type' => 'divider',
            ),
            array(
                'name'                  =>  'Asking Price',
                'id'                    =>  'asking_price',
                'type'                  =>  'multimask',
                'signed'                => true,
                'scale'                 => 0,
                'padFractionalZeros'    => false,
                'mask'                  => '$ num',
                'min'                   => 0,
                'return'                => 'float',
            ),
            array(
                'name'            => 'Rent Frequency',
                'id'              => 'rent_frequency',
                'type'            => 'select',
                // Array of 'value' => 'Label' pairs
                'options'         => array(
                    'monthly'       => 'Monthly',
                    'quarterly'        => 'Quarterly',
                    'yearly' => 'Yearly',
                ),
                // Allow to select multiple value?
                'multiple'        => false,  // true / false
                // Placeholder text
                'placeholder'     => 'Select frequency',
                // Display "Select All / None" button?
                'select_all_none' => false,  // true / false
                'visible'   => array( 'property_status' , '=' , get_term_by( 'slug' , 'for-rent' , 'prop_status'  )->term_id ),
            ),
            array(  // divider
                'type' => 'divider',
            ),
        	// OSM Address field.
        	array(
        	    'name' => 'Property Address',
        	    'id'   => 'propertymap_address',
        	    'type' => 'text',
        	),
        	// Map field.
        	array(
        	    'name'          => 'Property Map',
        	    'id'            => 'propertymap',
        	    'type'          => 'osm',

        	    // Default location: 'latitude,longitude[,zoom]' (zoom is optional)
        	    'std'           => '-6.233406,-35.049906,15',

        	    // Address field ID
        	    'address_field' => 'propertymap_address',
        	),
        	array( // Bedrooms
        	    'name' => 'Bedrooms',
        	    'id'   => 'bedrooms',
        	    'type' => 'number',

        	    'placeholder' => 'No of bedrooms',
        	    'min'  => 0,
        	    // 'max'  => 999,
        	    'step' => 1,
        	),
        	array(	// Bathrooms
        	    'name' => 'Bathrooms',
        	    'id'   => 'bathrooms',
        	    'type' => 'number',

        	    'placeholder' => 'No of bathrooms',
        	    'min'  => 0,
        	    // 'max'  => 999,
        	    'step' => 1,
        	),
        	array(	// Garage spaces
        	    'name' => 'Garage spaces',
        	    'id'   => 'garage_spaces',
        	    'type' => 'number',

        	    'placeholder' => 'Garage spaces',
        	    'min'  => 0,
        	    // 'max'  => 999,
        	    'step' => 1,
        	),
        	array(
        	    'type' => 'divider',
        	),
        	array(	// House size
        	    'name' => 'House size (m2)',
        	    'id'   => 'house_size',
        	    'type' => 'number',

        	    'placeholder' => 'size in m2',
        	    'min'  => 0,
        	    // 'max'  => 999,
        	    'step' => 1,
        	),
        	array( // area sq ft
        	    'name' => 'Area (sq ft)',
        	    'id'   => 'area_sqft',
        	    'type' => 'number',

        	    'placeholder' => 'Sq Ft',
        	    'min'  => 0,
        	    // 'max'  => 999,
        	    'step' => 1,
        	),
        	array( // lot size
        	    'name' => 'Lot Size',
        	    'id'   => 'lot_size',
        	    'type' => 'number',

        	    'placeholder' => 'Lot size',
        	    'min'  => 0,
        	    // 'max'  => 999,
        	    'step' => 1,
        	),
        	array( // year built
        	    'name' => 'Year Built',
        	    'id'   => 'year_built',
        	    'type' => 'number',

        	    'placeholder' => 'Year built',
        	    'min'  => 1500,
        	    'max'  => 2200,
        	    'step' => 1,
        	),
        	array(
        	    'type' => 'divider',
        	),
        	array(	// Features
        	    'name'        => 'Features',
        	    'label_description' => '',
        	    'id'          => 'features',
        	    'desc'        => 'Features',
        	    'type'        => 'text',

        	    // Default value (optional)
        	    // 'std'         => 'default_value',

        	    // Cloneable (i.e. have multiple value)?
        	    'clone'       => true,

        	    // Placeholder
        	    'placeholder' => 'Enter feature',

        	    // Input size
        	    //'size'        => 30,
        	),
        	array(	// Features
        	    'name'        => 'Additional Details',
        	    'label_description' => '',
        	    'id'          => 'additional_details',
        	    'desc'        => 'Additional Details',
        	    'type'        => 'text',

        	    // Default value (optional)
        	    // 'std'         => 'default_value',

        	    // Cloneable (i.e. have multiple value)?
        	    'clone'       => true,

        	    // Placeholder
        	    'placeholder' => 'Enter Detail',

        	    // Input size
        	    'size'        => 60,
        	),
        	array(	// divider
        	    'type' => 'divider',
        	),
        	array(	// property images
        	    'name'             => 'Property Images',
        	    'id'               => 'property_images',
        	    'type'             => 'image_advanced',

        	    // Delete image from Media Library when remove it from post meta?
        	    // Note: it might affect other posts if you use same image for multiple posts
        	    'force_delete'     => false,

        	    // Maximum image uploads
        	    // 'max_file_uploads' => 2,
        	    // Do not show how many images uploaded/remaining.
        	    'max_status'       => 'false',

        	    // Image size that displays in the edit page.
        	    'image_size'       => 'thumbnail',
        	),
            array(
                'name'             => 'Single Image',
                'id'               => 'single_image',
                'type'             => 'single_image',

                // Delete image from Media Library when remove it from post meta?
                // Note: it might affect other posts if you use same image for multiple posts
                'force_delete'     => false,

                // Maximum image uploads
                // 'max_file_uploads' => 2,
            ),

        ),
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'agent_meta_box' );
/**
 * Create a Meta Box, anonymously
 */
function agent_meta_box( $meta_boxes ) {
    $meta_boxes[] = array(
        'title'  => 'Agent',
        'id'     =>  'agent-meta-box',
        'post_types'    => array(
            'agent',
        ),
        'context'   => 'normal',   // normal / advanced / side / form_top / after_title / after_editor / before_permalink
        'priority'  => 'high',      // high / low
        'fields' => array(
        // fields go here
	        array( // Office phone
	            'name'        => 'Office Phone',
	            'label_description' => '',
	            'id'          => 'office_phone',
	            'desc'        => 'Enter Office Phone number',
	            'type'        => 'text',

	            // Default value (optional)
	            // 'std'         => 'default_value',

	            // Cloneable (i.e. have multiple value)?
	            'clone'       => false,

	            // Placeholder
	            'placeholder' => 'Office phone #',

	            // Input size
	            'size'        => 30,
	        ),
	        array( // Fax phone
	            'name'        => 'Fax Phone',
	            'label_description' => '',
	            'id'          => 'fax_phone',
	            'desc'        => 'Enter Fax Phone number',
	            'type'        => 'text',

	            // Default value (optional)
	            // 'std'         => 'default_value',

	            // Cloneable (i.e. have multiple value)?
	            'clone'       => false,

	            // Placeholder
	            'placeholder' => 'Fax phone #',

	            // Input size
	            'size'        => 30,

	        ),
	        array( // Mobile phone
	            'name'        => 'Mobile Phone',
	            'label_description' => '',
	            'id'          => 'mobile_phone',
	            'desc'        => 'Enter Mobile Phone number',
	            'type'        => 'text',

	            // Default value (optional)
	            // 'std'         => 'default_value',

	            // Cloneable (i.e. have multiple value)?
	            'clone'       => false,

	            // Placeholder
	            'placeholder' => 'Mobile phone #',

	            // Input size
	            'size'        => 30,
	        ),
	        array( // Whatsapp phone
	            'name'        => 'Whatsapp Phone',
	            'label_description' => '',
	            'id'          => 'whatsapp',
	            'desc'        => 'Enter Whatsapp Phone number',
	            'type'        => 'multimask',
                'mask_type'   => 'custom',
                'custom'      => "mask: '0-000-000-000'",
                'store'       => 'value',

	            // Default value (optional)
	            // 'std'         => 'default_value',

	            // Cloneable (i.e. have multiple value)?
	            'clone'       => false,

	            // Placeholder
	            'placeholder' => 'Whatsapp phone #',

	            // Input size
	            'size'        => 30,

	        ),
	        array( // Email
	            'name'        => 'Email',
	            'label_description' => '',
	            'id'          => 'email',
	            'desc'        => 'Enter Email',
	            'type'        => 'text',

	            // Default value (optional)
	            // 'std'         => 'default_value',

	            // Cloneable (i.e. have multiple value)?
	            'clone'       => false,

	            // Placeholder
	            'placeholder' => 'Email',

	            // Input size
	            'size'        => 30,

	        ),
            array(  // USD currency format with US number format
                'name'                  =>  'Dollars',
                'id'                    =>  'my_number_format',
                'type'                  =>  'multimask',
                'scale'                 => 0,
                'signed'                => true,
                'padFractionalZeros'    => false,
                'mask'                  => '$ num'
            ),
            array(  // Euro currency with European number format
                'name'                  =>  'Euros',
                'id'                    =>  'my_euro_currency',
                'type'                  =>  'multimask',
                'scale'                 => 0,
                'signed'                => true,
                'padFractionalZeros'    => false,
                'mask'                  => '€ num',
                'min'                   => -1000,
                'radix'                 => ',',
                'thousandsSeparator'    => '.',
                'mapToRadix'            => '[\'.\']'
            ),
            array(  // Dutch postal code
                'name'                  =>  'Postal Code',
                'id'                    =>  'my_postal_code',
                'type'                  =>  'multimask',
                'mask_type'             =>  'custom',
                'custom'               =>  "mask: '0### aa', definitions: { '0': /[1-9]/, '#':/[0-9]/, 'a': /[a-zA-Z]/ }",
                'store'                 => 'value'                  // store to postmeta-table as masked-value
            ),
            array(  // Input restricted to coco coco
                'name'                  =>  'Enter coco coco',
                'id'                    =>  'my_continue',
                'type'                  =>  'multimask',
                'mask_type'             =>  'custom',
                'custom'                 =>  "mask: 'coco coco', definitions: { 'c': /[cC]/, 'o': /[oO]/ }",
                'store'                 => 'value',
                'desc'                  => 'Enter coco coco'
            ),
            array( // Phone number in format 0-000-000-000
                'name'        => 'Phone number',
                'label_description' => '',
                'id'          => 'my_phone_number',
                'desc'        => 'Enter Phone number',
                'type'        => 'multimask',
                'mask_type'   => 'custom',
                'custom'      => "mask: '0-000-000-000'",
                'store'       => 'value',

                // Placeholder
                'placeholder' => '1-800-234-567',

            ),


        ),
    );
    return $meta_boxes;
}

//add_action( 'init' , 'prefix_create_table' );

function prefix_create_table() {
    if ( !class_exists( 'MB_Custom_Table_API' ) ) {
        // return early
        return;
    }
    MB_Custom_Table_API::create( 'toolbox_test_users' ,
        array(
        'name'  => 'TEXT NOT NULL',
        'address' => 'TEXT NOT NULL',
        'zip' => 'TEXT NOT NULL',
        'city' => 'TEXT NOT NULL',
        'email' => 'VARCHAR(40) NOT NULL',
        'datatable' => 'TEXT NOT NULL',
        ),
        array( 'email' )
    );
}

//add_filter( 'rwmb_meta_boxes', 'test_users' );


function test_users( $meta_boxes ) {
    if ( !class_exists( 'MB_Custom_Table_API' ) ) {
        // return early
        return $meta_boxes;
    }

    $meta_boxes[] = array(
        'title'        => 'Test User Table Data',
        'id'     =>  'test-user-meta-box',
        'post_types'    => 'agent',
        'context'   => 'normal',   // normal / advanced / side / form_top / after_title / after_editor / before_permalink
        'priority'  => 'high',      // high / low
        'storage_type' => 'custom_table',    // Important
        'table'        => 'toolbox_test_users', // Your custom table name
        'fields'       => array(
            array(
                'name'        => 'Name',
                'label_description' => 'Label Description',
                'id'          => 'name',
                'desc'        => 'Description',
                'type'        => 'text',

                // Cloneable (i.e. have multiple value)?
                'clone'       => false,

                // Placeholder
                'placeholder' => '',

                // Input size
                'size'        => 30,

            ),
            array(
                'name'        => 'Address',
                'label_description' => 'Label Description',
                'id'          => 'address',
                'desc'        => 'Address',
                'type'        => 'text',
                // Cloneable (i.e. have multiple value)?
                'clone'       => false,

                // Placeholder
                'placeholder' => '',

                // Input size
                'size'        => 30,
            ),
            array(
                'name'        => 'Zip',
                'id'          => 'zip',
                'type'        => 'text',
                // Cloneable (i.e. have multiple value)?
                'clone'       => false,

                // Placeholder
                'placeholder' => '',

                // Input size
                'size'        => 30,

            ),
            array(
                'name'        => 'City',
                'id'          => 'city',
                'type'        => 'text',

                // Cloneable (i.e. have multiple value)?
                'clone'       => false,

                // Placeholder
                'placeholder' => '',

                // Input size
                'size'        => 30,

            ),
            array(
                'name'        => 'Email',
                'id'          => 'email',
                'type'        => 'text',

                // Cloneable (i.e. have multiple value)?
                'clone'       => false,

                // Placeholder
                'placeholder' => '',

                // Input size
                'size'        => 30,

            ),
            array(
                'name'        => 'Data table',
                'id'          => 'datatable',
                'type'        => 'text',

                // Cloneable (i.e. have multiple value)?
                'clone'       => false,

                // Placeholder
                'placeholder' => '',

                // Input size
                'size'        => 30,

            )


        )
    );

    return $meta_boxes;
}


add_action( 'rwmb_meta_boxes', function( $meta_boxes ) {
    $meta_boxes[] = array(
        'title' => 'Contact Info',
        'type'  => 'user', // Specifically for user

        'fields' => array(
            array(
                'name' => 'Mobile phone',
                'id'   => 'mobile',
                'type' => 'tel',
            ),
            array(
                'name' => 'Work phone',
                'id'   => 'work',
                'type' => 'tel',
            ),
            array(
                'name' => 'Address',
                'id'   => 'address',
                'type' => 'textarea',
            ),
            array(
                'name'    => 'City',
                'id'      => 'city',
                'type'    => 'select_advanced',
                'options' => array(
                    'hanoi' => 'Hanoi',
                    'hcm'   => 'Ho Chi Minh City'
                ),
            ),
        ),
    );
    $meta_boxes[] = array(
        'title' => 'Custom avatar',
        'type'  => 'user', // Specifically for user

        'fields' => array(
            array(
                'name'            => 'Upload avatar',
                'id'              => 'avatar',
                'type'            => 'image_advanced',
                'max_file_uploads' => 1,
            ),
        ),
    );

    return $meta_boxes;
} );