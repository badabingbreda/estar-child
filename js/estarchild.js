/**
 *  Script loaded on homepage only
 */
var estarChild = {


	/**
	 * [qToArr description]
	 * @param  {[type]} q [description]
	 * @return {[type]}   [description]
	 * @url http://jsfiddle.net/remus/eSL2c/
	 */
	qToArr : function(q) {

	    q = decodeURIComponent((q).replace(/\+/g, '%20'));
	    arr = {};
	    var a = q.split(/&(?!amp;)/g);
	    for (x in a)
	    {
	        var pair = a[x].split('=');
	        arr[pair[0]] = pair[1];
	    }
	    return arr;
	},

	/**
	 * Collect the values for dropdown fields in formid
	 * @param  {[type]} formid [description]
	 * @return {[type]}        [description]
	 */
	collectSearchParams: function( formid ) {

		var searchparameters = [];

		jQuery( '#' + formid + ' input[id$=-filter]').each( function () {
			if ( jQuery( this ).attr( 'value' ) !== '' ) {
				searchparameters[ jQuery( this ).attr('name') ] = jQuery( this ).attr( 'value' );
			}
		});
		return searchparameters;

	},

	collectFormData: function ( formid ) {

		$ = jQuery;

		var fields = $( '#' + formid ).data( 'fields' );

	},

	updatePushURL: function( formid ) {

	  	if ( history.pushState ) {

			let searchparams = this.collectSearchParams( formid );
			let compoundstring = '';

			for ( let keyname of Object.keys( searchparams ) ) {
				if (keyname == 'action') continue;
				compoundstring = compoundstring + keyname + '=' + searchparams[ keyname ] + '&';
			}

	    	var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?' + compoundstring ;

	    	console.log(compoundstring);
	    	window.history.pushState({path:newurl},'',newurl);
	  	}

	},

	ajaxUpdateResults: function ( formid , updateid , reset ) {

	if ( typeof( reset ) == 'undefined') reset = false;

	jQuery( '.loading-spinner' ).removeClass('uk-hidden');
	jQuery( '#' + updateid ).addClass( 'fm_opacity');


	jQuery.ajax(
		{ 	method: 'GET' ,
			url: fmvars.adminurl ,
			data: reset ? { action: fmvars.action } :  { ...this.collectSearchParams( formid ), ...{ action: fmvars.action } },
		})
		.done(
			function( html ){
				jQuery( '#' + updateid )
					.fadeOut( 150 , function() {
						jQuery( this ).html( html ).fadeIn( 150 );
						//jQuery( '#toolbox_spinner' ).addClass( 'uk-invisible' );
					});
				jQuery( '.loading-spinner' ).addClass('uk-hidden');
				jQuery( '#' + updateid ).removeClass( 'fm_opacity' );


			}
		);
	},

	/**
	 * create listeners for any tax-picker id
	 * optionally set if clicking it also triggers an update with ajax
	 * @param  {[type]} taxname    [description]
	 * @param  {[type]} updateajax [description]
	 * @return {[type]}            [description]
	 */
	fancyDropdown: function( taxname , updateajax ) {

				if ( typeof( $ ) == 'undefined' ) $ = jQuery;
				if ( typeof( updateajax ) == 'undefined' ) updateajax = false;

				// open/close the dropdown
				$( '#'+ taxname + '-picker .selector' ).on( 'click' , function(e) { $( '#'+ taxname + '-picker .dropdown').toggleClass( 'hidden' ); } );

				// click one of the options
				$( '#'+ taxname + '-picker .dropdown li' ).on( 'click' , function( e ) {

					var $this = $(this);

					$( '#'+ taxname + '-picker .selector').html( $this.data( 'name' ) );
					$( '#'+ taxname + '-picker #'+ taxname + '-filter').attr( 'value' , $this.data( taxname ) );
					$( '#'+ taxname + '-picker .dropdown' ).addClass( 'hidden' );

					if (updateajax ) {

						var $form = $(this).closest( 'form' );

						estarChild.ajaxUpdateResults( $form.attr( 'id' ) , $form.data( 'target-id' ) , false );

						estarChild.updatePushURL( $form.attr( 'id' ) );

					}

				} );

				let _on_load_value = estarChild.qToArr(location.search.substring(1))['_' + taxname ];
				if( _on_load_value !== '' ) {
					$item = $( '#'+ taxname + '-picker li[data-' + taxname + '=' + _on_load_value + ']' );
					$('#'+ taxname + '-picker .selector').html( $item.data( 'name' ) );
					$('#'+ taxname + '-picker #' + taxname + '-filter').attr( 'value' , $item.data( taxname ) );
				}
	},




};

(function($) {

	$( document ).ready( function() {

		$( 'body' ).delegate( '.reset' , 'click' , function() {
			var $form = $(this).closest( 'form' );
			window.location = window.location.protocol + "//" + window.location.host + window.location.pathname;

		})

		$( 'form div[id$=-picker]' )
			.each(
				function() {
					estarChild.fancyDropdown( $(this).attr('id').replace( '-picker' , '' ) , false )
				}
			);

	});


})(jQuery);