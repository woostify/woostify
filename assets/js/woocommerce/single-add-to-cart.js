'use strict';

function single_add_to_cart_button() {
    var cart = document.getElementsByClassName( 'cart' )[0],
    	singleAddToCartButton = cart ? cart.getElementsByClassName( 'single_add_to_cart_button' )[0] : false;

	if ( ! cart || ! singleAddToCartButton ) {
		return;
	}

    singleAddToCartButton.addEventListener( 'click', function( e ) {
        e.preventDefault();

        fetch( woostify_ajax.url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=utf-8'
            },
            body: 'action=single_add_to_cart',
            credentials: 'same-origin'
        } ).then( function( res ) {
            if ( 200 !== res.status ) {  
                console.log( 'Looks like there was a problem. Status Code: ' + res.status ); 
                return;  
            }

            // Examine the text in the response  
            res.json().then( function( data ) {  
                console.log( data );
            });
        } )  
        .catch( function( err ) {  
            console.log( err ); 
        });
    } );
}
single_add_to_cart_button();