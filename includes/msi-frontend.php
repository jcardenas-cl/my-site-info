<?php
/**
 * Funcion ejecutada mediante shotcode que muestra una lista con redes sociales registradas en el sitio.
 * Al ser ejecutada por un shortcode, el contenido es retornado y no impreso directamente.
 * 
 * @param Array $args Argumentos
 */
add_shortcode( 'msi_show_rrss_bar', function ( $args ) {
    $args = shortcode_atts( array(
        'layout'    => null,
        'limit'     => 99,
        'start'     => 0,
    ), $args );

    $layout_to_use = get_option( 'layout_rrss' );
    // En caso que no se especifique el layout por parametro, se usa la configuracion guardada.
    if ( !is_null( $args['layout'] ) ) {
        if ( $args['layout'] == 'layout-2' ) {
            $layout_to_use = $args['layout'];
        } else {
            $layout_to_use = 'layout-1';
        }
    }

    ob_start();
    include plugin_dir_path( __FILE__ ) . '../public/rrss-' . $layout_to_use . '.php';
    return ob_get_clean();
} );


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

    $max = count($phones);
    if ( $args['start'] + $args['limit'] <= $max ) {
        $max = $args['start'] + $args['limit'];
    }
    
    $output = '<div class="msi-container"><ul class="msi-mobile-phone-list">'; // String con la lista de telefonos.

    if ( '' != trim($phones[0]) ) {
        for ( $i = $args['start']; $i <= $max - 1; $i++ ) {
            $output .= '<li><a href="tel:' . $phones[$i] . '">' . trim( $phones[$i] ) . '</a></li>';
        }
    }

    $output .= '</ul></div>';

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

    $max = count($phones);
    if ( $args['start'] + $args['limit'] <= $max ) {
        $max = $args['start'] + $args['limit'];
    }
    
    $output = '<div class="msi-container"><ul class="msi-phone-list">';

    if ( '' != trim($phones[0]) ) {
        for ( $i = $args['start']; $i <= $max - 1; $i++ ) {
            $output .= '<li><a href="tel:' . $phones[$i] . '">' . trim($phones[$i]) . '</a></li>';
        }
    }

    $output .= '</ul></div>';

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

    $max = count($emails);
    if ( $args['start'] + $args['limit'] <= $max ) {
        $max = $args['start'] + $args['limit'];
    }

    $output = '<div class="msi-container"><ul class="msi-email-list">';

    if ( '' != trim($emails[0]) ) {
        for( $i = $args['start']; $i <= $max - 1; $i++ ) {
            $output .= '<li><a href="mailto:' . $emails[$i] . '">' . trim($emails[$i]) . '</a></li>';
        }
    }

    $output .= '</ul></div>';

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

    $max = count($phones);
    if ( $args['start'] + $args['limit'] <= $max ) {
        $max = $args['start'] + $args['limit'];
    }

    $output = '<div class="msi-container"><ul class="msi-whatsapp-list">';
    
    // Explode retorna al menos un elemento de array, independiente de si tiene un valor luego de la operación.
    if ( '' != trim($phones[0]) ) {
        for( $i = $args['start']; $i <= $max - 1; $i++ ) {
            $output .= '<li><a href="https://api.whatsapp.com/send/?phone:' . $phones[$i] . '">' . trim($phones[$i]) . '</a></li>';
        }
    }

    $output .= '</ul></div>';

    return $output;
} );

/**
 * Shortcode para mostrar la dirección real.
 */
add_shortcode( 'msi_show_address', function() {
    $address = get_option( 'msi_address' );

    $output = '<div class="msi-container"><div class="msi-address">';
    $output .= $address;
    $output .= '</div></div>';

    return $output;
} );


add_shortcode( 'msi_show_map', function() {
    $map = get_option( 'msi_map' );

    $output = '<div class="msi-container"><div class="msi-address">';
    $output .= $map;
    $output .= '</div></div>';

    return $output;
} );