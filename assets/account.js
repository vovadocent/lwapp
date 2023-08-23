/**
 * Account scripts
 */

define( [ "jquery" ], function ( $ ) {

    $( '#accountForm' ).on( 'submit', function () {
        let $form = $( this );

        $.ajax( {
            url: $form.attr( 'action' ),
            type: 'POST',
            data: $form.serialize(),
            beforeSend: function () {},
            success: function ( resp ) {
                if ( typeof resp.msg !== 'undefined' ) {
                    $( '.ajaxResponce' ).html( resp.msg );
                }
            },
            error: function ( req, status, error ) {
                $( '.ajaxResponce' ).text( 'An error has been occurred' );
            }
        } );

        return false;
    } )

} );
