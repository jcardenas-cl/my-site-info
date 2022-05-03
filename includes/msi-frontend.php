<?php
/**
 * Shortcode para mostrar lista con telefonos celulares en el sitio.
 */
add_shortcode( 'msi_show_mobile_phone_bar', function( $args ) {
    $phones = explode( ',', get_option( 'msi_mobile_phone' ) );
    /**
     * Valores por defecto cuando se llama al shortcode sin parametros, listamos todos los teléfonos ingresados e iniciamos desde el primer registro.
     */
    $args = shortcode_atts( array (
        'limit' => count($phones),
        'start' => 0,
    ), $args);
    
    $output = '<ul class="msi-mobile-phone-list">'; // String con la lista de telefonos.

    if ( '' != trim($phones[0]) ) {
        for( $i = $args['start']; $i <= ($args['start'] + $args['limit']) - 1; $i++ ) {
            if ( isset($phones[$i]) ) {
                $output .= '<li><a href="tel:' . $phones[$i] . '">' . trim( $phones[$i] ) . '</a></li>';
            } else {
                break;
            }
        }
    }
    
    $output .= '</ul>';

    return $output;
} );

/**
 * Shortcode para mostrar lista con telefonos en el sitio.
 */
add_shortcode( 'msi_show_phone_bar', function( $args ) {
    $phones = explode( ',', get_option( 'msi_phone' ) );
    $args = shortcode_atts( array (
        'limit' => count($phones),
        'start' => 0,
    ), $args);
    
    $output = '<ul class="msi-phone-list">';

    if ( '' != trim($phones[0]) ) {
        for( $i = $args['start']; $i <= ($args['start'] + $args['limit']) - 1; $i++ ) {
            if ( isset($phones[$i]) ) {
                $output .= '<li><a href="tel:' . $phones[$i] . '">' . trim($phones[$i]) . '</a></li>';
            } else {
                break;
            }
        }
    }

    $output .= '</ul>';

    return $output;
} );

/**
 * Shortcode para mostrar lista con correos de contacto en el sitio.
 */
add_shortcode( 'msi_show_email_bar', function( $args ) {
    $emails = explode( ',', get_option( 'msi_email' ) );
    $args = shortcode_atts( array (
        'limit' => count($emails),
        'start' => 0,
    ), $args);
    $output = '<ul class="msi-email-list">';

    if ( '' != trim($emails[0]) ) {
        for( $i = $args['start']; $i <= ($args['start'] + $args['limit']) - 1; $i++ ) {
            if ( isset($emails[$i]) ) {
                $output .= '<li><a href="mailto:' . $emails[$i] . '">' . trim($emails[$i]) . '</a></li>';
            } else {
                break;
            }
        }
    }

    $output .= '</ul>';

    return $output;
} );

/**
 * Shortcode para mostrar lista con correos de contacto en el sitio.
 */
add_shortcode( 'msi_show_whatsapp_bar', function( $args ) {
    $phones = explode( ',', get_option( 'msi_whatsapp' ) );
    $max_phones_index = count($phones);
    $args = shortcode_atts( array (
        'limit' => count($phones),
        'start' => 0,
    ), $args);

    $output = '<ul class="msi-whatsapp-list">';
    
    // Explode retorna al menos un elemento de array, independiente de si tiene un valor luego de la operación.
    if ( '' != trim($phones[0]) ) {
        for( $i = $args['start']; $i <= ($args['start'] + $args['limit']) - 1; $i++ ) {
            if ( isset($phones[$i]) ) {
                $output .= '<li><a href="https://api.whatsapp.com/send/?phone:' . $phones[$i] . '">' . trim($phones[$i]) . '</a></li>';
            } else {
                break;
            }
        }
    }

    $output .= '</ul>';

    return $output;
} );