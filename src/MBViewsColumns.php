<?php

// add restricted value to column for restriced post type
add_action( 'manage_mb-views_posts_custom_column', 'manage_columns', 20, 2 );


/**
 * Output for the extra column(s)
 * @param  [type] $column_name [description]
 * @param  [type] $post_id     [description]
 * @return [type]              [description]
 */
function manage_columns( $column_name, $post_id ) {
    //global $post;
    switch ($column_name) {
    case "type":
    	$type = rwmb_meta( 'type' , $post_id );
    	if ( 'action' == $type ) {

    		// this is stored as a metabox value
            $action 		= rwmb_meta( 'mbv_action' , $post_id );

            // get post field for this
    		$menu_order 	= get_post_field( 'menu_order' , $post_id );

            if (!$action) $action = '-';
    		if (!$menu_order) $menu_order = sprintf( '<span title="no priority set, will use 10">?10</span>' , __( 'no priority set, will use 10' , 'text-domain' ) );

	    	echo "<p><code>{$action} <span style='margin-left: 10px;'>{$menu_order}</span></code></p>";
    	}

    break;
    } // end switch
}

