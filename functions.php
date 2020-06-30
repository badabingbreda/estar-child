<?php
// Defines
define( 'ESTAR_CHILD_THEME_DIR', get_stylesheet_directory() );
define( 'ESTAR_CHILD_THEME_URL', get_stylesheet_directory_uri() );

define( 'ESTAR_CHILD_THEME_VERSION', '1.0.0' );

require_once( 'src/MBViewsColumns.php' );
require_once( 'src/UIKitNavMenu.php' );
require_once( 'src/CustomFields.php' );
require_once( 'src/TimberBlocks.php' );
require_once( 'src/MetaBoxCPTs.php' );
require_once( 'src/MetaBoxMBs.php' );

add_action( 'wp_enqueue_scripts' , function() {

	wp_enqueue_style( 'estar-child', ESTAR_CHILD_THEME_URL . '/css/estar-child.css', null, ESTAR_CHILD_THEME_VERSION, 'all' );
	wp_enqueue_script( 'jQuery' , 'https://code.jquery.com/jquery-3.x-git.min.js' , null , '3.5.1' , false );
	wp_enqueue_script( 'helloworld' , ESTAR_CHILD_THEME_URL . '/js/estarchild.js', null, ESTAR_CHILD_THEME_VERSION, true );

	wp_localize_script( 'helloworld' , 'fmvars', array( 'adminurl' => admin_url( 'admin-ajax.php' ) , 'action' => 'property_filtered' ) );

} , 100, 1 );

add_action( 'admin_enqueue_scripts' , 'easy_uikit_load_assets' , 10, 1 );

///add_action( 'init' , function() { var_dump( $GLOBALS[ 'wp_filter' ][ 'nav_menu_link_attributes' ] ) ; } );
add_action( 'init' , 'remove_defaults' );

function remove_defaults() {

	remove_action( 'estar_header' , 'EStar\Structure::render_header' , 10, 1  );

	remove_action( 'estar_footer' , 'EStar\Structure::render_footer' , 10, 1  );

}

function easy_uikit_load_assets() {

	wp_enqueue_script( 'easy-uikitjs', EASYUIKIT_URL.'/js/uikit.min.js', false, EASYUIKIT_VERSION , false );

	wp_enqueue_script( 'easy-uikiticons', EASYUIKIT_URL.'/js/uikit-icons.min.js', false, EASYUIKIT_VERSION , false );

	wp_enqueue_style( 'easy-uikitcss', EASYUIKIT_URL.'/css/bbuikit.theme.min.css', false, EASYUIKIT_VERSION , 'all' );
}


function filter_property_args( $args ) {

	global $connector;

	$taxonomies_value = [];

	$taxonomies = [ 'prop_status' ];

	foreach ( $taxonomies as $item ) {

		$taxonomies_value	= filter_input( INPUT_GET, "_{$item}", FILTER_SANITIZE_STRING );

		if ( $taxonomies_value ) {

			if ( !isset( $args['tax_query'] ) ) $args['tax_query'] = array( 'relation' => 'AND' );

			$args['tax_query'] = array_merge(
				$args['tax_query'],
				array(
			    	"{$item}_clause" => array(
				        'taxonomy' => $item,
				        'field' => 'slug',
				        'terms' => array( $taxonomies_value ),
				        'include_children' => true,
				        'operator' => 'IN'
			    	),
			  	)
			);


		}

	}

	$args['post_status'] = 'publish';

	$args[ 'order' ] = 'ASC';
	$args[ 'orderby' ] = 'date';


	$args[ 'suppress_filters' ] = false;

	//var_dump( $args );
	return $args;

}

/**
 * Filter for array_filter that returns only the existing vakgebied slugs
 * @param  [type] $var [description]
 * @return [type]      [description]
 */
function filter_prop_status( $var ) {

	return isset( get_term_by( 'slug' , $var , 'prop_status' )->slug );
}

add_action( 'pre_get_posts' , 'property_query' );

function property_query( $query ) {

	if ( $query->is_main_query() ) {

		// $_in = filter_input( INPUT_GET, '_in', FILTER_SANITIZE_STRING );

		// if ( $_in ) {
		// 	$query->set( 'post_type' , $_in );
		// 	$query->is_search = true;
		// } else {
		// 	return $query;
		// }
		if ( !$query->is_archive() ) return $query;


		if ( !isset( $query->query_vars ) || $query->query_vars[ 'post_type' ] !== 'property' ) return $query;

		$q = filter_input( INPUT_GET, 'q', FILTER_SANITIZE_STRING );

		$query->set( 'q' , $q );

		if ( isset( $_GET[ '_prop_status' ] )  && !empty( $_GET[ '_prop_status' ] ) ) {

			// apply filter that only returns existing slugs, no cheating!
			$_prop_status = array_filter( [ $_GET['_prop_status'] ] , 'filter_prop_status' );

		}

		// check if we can add some stuff

		if ( isset( $query->query_vars[ 'q' ] ) ) {

			$query->set( 'q' , $q );
			//$query->set( 's' , $q );

		}

		if ( isset( $_prop_status ) ) {

			$query->set( 'tax_query' ,
										array(
											'relation' => 'OR' ,
											'clause_prop_status' => array(
																		'taxonomy' 	=> 'prop_status' ,
																		'field'		=> 'slug',
																		'terms'		=> $_prop_status,
																		'operator'	=> 'IN',
																	)
										)
					);
		}

	}

	return $query;
}

add_filter( 'posts_orderby', 'order_search_by_posttype', 10, 2 );
function order_search_by_posttype( $orderby, $wp_query ){
    if( ! $wp_query->is_admin && $wp_query->is_search ) :
        global $wpdb;
        $orderby =
            "
            CASE WHEN {$wpdb->prefix}posts.post_type = 'property' THEN '1'
            ELSE {$wpdb->prefix}posts.post_type END ASC,
            {$wpdb->prefix}posts.post_title ASC";
    endif;
    return $orderby;
}



