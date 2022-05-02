<?php
/**
 * Shortcode para mostrar lista con telefonos celulares en el sitio.
 */
add_shortcode( 'msi_show_mobile_phone_bar', function( $args ) {
    $args = shortcode_atts( array (
        'limit' => 99,
        'start' => 0,
    ), $args);
    $phones = explode( ',', get_option( 'msi_mobile_phone' ) );
    $output = '<ul class="msi-mobile-phone-list">'; // String con la lista de telefonos.
    for( $i = $args['start']; $i <= ($args['start'] + $args['limit']) - 1; $i++ ) {
        if ( isset($phones[$i]) ) {
            $output .= '<li><a href="tel:' . $phones[$i] . '">' . trim( $phones[$i] ) . '</a></li>';
        } else {
            break;
        }
    }
    $output .= '</ul>';

    return $output;
} );

/**
 * Shortcode para mostrar lista con telefonos celulares en el sitio.
 */
add_shortcode( 'msi_show_phone_bar', function( $args ) {
    $args = shortcode_atts( array (
        'limit' => 99,
        'start' => 0,
    ), $args);
    $phones = explode( ',', get_option( 'msi_phone' ) );
    $output = '<ul class="msi-phone-list">'; // String con la lista de telefonos.
    for( $i = $args['start']; $i <= $args['start'] + $args['count']; $i++ ) {
        if ( !is_null($phones[$i]) ) {
            $output .= '<li><a href="tel:' . $phones[$i] . '">' . trim($phones[$i]) . '</a></li>';
        } else {
            break;
        }
    }
    $output .= '</ul>';

    return $output;
} );