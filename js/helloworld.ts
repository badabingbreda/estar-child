const docReady = ( fn : any ) => {

    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }

}

interface ajaxOptions {
	url 	?: string;
	data 	?: object;
}

const ajax = {

	httpRequest : null,
	call : ( url: string , data : object) => {

		var settings = { url : '' , data: {} } ;

		if ( url ) {
			settings.url = url;
		}
		if ( data ) {
			settings.data = data;
		}

		this.httpRequest = new XMLHttpRequest;

		this.httpRequest.open( 'GET' , settings.url );
		this.httpRequest.onreadystatechange = ajax.response();
		this.httpRequest.send();

		return void(0);
	},
	response: () => {

		if ( this.httpRequest === XMLHttpRequest.DONE ) {
			alert( this.httpRequest.responseText );
		}

		return;
	}

};

// ajax.call ( config : ajaxOptions ): { url: string , data: object } {

// 		var settings = { url: '', data: {} };
// 		if ( config.url ) {
// 			settings.url = config.url;
// 		}
// 		if ( config.data ) {
// 			settings.data = config.data;
// 		}

// 		//this.httpRequest = new XMLHttpRequest();

// 		this.httpRequest.onreadystatechange = this.response;
// 	    this.httpRequest.open('GET', settings.url);
// 	    this.httpRequest.send();

// 	    return;
// 	}

// 	response ( ) {

// 		if ( this.httpRequest.readyState === XMLHttpRequest.DONE ) {
// 			if ( this.httpRequest.status === 200) {
// 				alert( this.httpRequest.responseText );
// 			} else {
// 			    alert('There was a problem with the request.');
// 			}
//       	}

// 	}

// }




docReady( () => {

	const listingsButtons = document.querySelectorAll( '.view-listings' );

	if ( !listingsButtons ) return;

	ajax.call( '/wp-content/themes/estar-child/js/demo.txt' , () => {} );

	listingsButtons.forEach( item => {

		item.addEventListener(
								'mouseover' ,
								e => { console.log( item.getAttribute( 'data-hiddenmessage' ) ); } ,
								false
							);
	});
	console.log( listingsButtons.length );



});
