<?php

/**
 * Crea una nueva entrada de opciones en el menú de apariencia
 * 
 * @return void
 */
function msi_theme_settings() {
	add_theme_page(
		__( 'Info. sitio', 'my_site_info' ),
		__( 'Info. contacto y ubicación', 'my_site_info' ),
		'manage_options',
		'msi-settings',
		'show_display_with_theme_settings'
	);
}
add_action( 'admin_menu', 'msi_theme_settings' );

/**
 * Muesta una pantalla con el formulario de opciones para el tema de funeraria auco
 * 
 * @return void
 */
function show_display_with_theme_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'Necesita un perfil con otro nivel de acceso para editar esta configuración', 'my_site_info' ) );
	}
    $update_result = collect_and_update_data();
    include plugin_dir_path( __FILE__ ) . '../admin/msi-screen.php';
    ?>
    <?php
}

/**
 * Funcion encargada de obtener los datos mediante post y actualizar de ser necesario.
 * @since 1.0.0
 * @return bool True si se realizaron actualizaciones, False en caso contrario
 */
function collect_and_update_data() {
    $has_update = false;
    // Datos de las redes sociales ingresadas
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    $rrss_info  = array();

    if ( isset( $_POST['rrss_url'] ) ) {
        $urls           = $_POST['rrss_url'];
        $names          = $_POST['rrss_name'];
        $current_icons  = $_POST['current_icon'];

        $i = 0;
        foreach ( $urls as $url ) {
            $rrss_info[$i]['url'] = $url;
            $i++;
        }
        $i = 0;
        foreach ( $names as $name ) {
            $rrss_info[$i]['name'] = $name;
            $i++;
        }
        $i = 0;
        foreach ( $current_icons as $icon ) {
            $rrss_info[$i]['icon'] = $icon;
            $i++;
        }
        
        $files  = $_FILES['rrss_icon'];
        $i      = 0;
        foreach ( $files['name'] as $key => $value ) {
            if ( $files['name'][ $key ] ) {
                $file = array(
                    'name'      => $files['name'][ $key ],
                    'type'      => $files['type'][ $key ],
                    'tmp_name'  => $files['tmp_name'][ $key ],
                    'error'     => $files['error'][ $key ],
                    'size'      => $files['size'][ $key ],
                );
        
                $urls                   = wp_handle_upload( $file, array( 'test_form' => false ) );
                $icon_url               = $urls["url"];
                $rrss_info[$i]['icon']  = $icon_url;
            } else {
                // No se subió un icono, asi que solo asignamos la url del icono por defecto
                $rrss_info[$i]['icon']  = plugins_url() . '/my-site-info/admin/assets/img/image-icon.svg';
            }

            $i++;
        }

        $rrss_json = json_encode( $rrss_info );
        update_option( 'rrss_options', $rrss_json );
    }

    if ( isset( $_POST['txt-mobile-phone'] ) ) {
        update_option( 'msi_mobile_phone', $_POST['txt-mobile-phone'] );
        update_option( 'msi_phone', $_POST['txt-phone'] );
        update_option( 'msi_email', $_POST['txt-email'] );
        update_option( 'msi_whatsapp', $_POST['txt-whatsapp'] );
        update_option( 'msi_address', $_POST['txt-address'] );
        update_option( 'msi_map', $_POST['txt-map'] );
    }
    
    return $has_update;
}

/**
 * Funcion ejecutada mediante shotcode que muestra una lista con redes sociales registradas en el sitio.
 * Al ser ejecutada por un shortcode, el contenido es retornado y no impreso directamente.
 */
function msi_print_rrss_bar() {
    ob_start();
    include plugin_dir_path( __FILE__ ) . '../public/rrss-layout1.php';

    return ob_get_clean();
}
add_shortcode( 'msi_rrss_bar', 'msi_print_rrss_bar' );

function msi_show_address() {
    echo get_option('msi_address');
}

function msi_show_phone() {
    echo get_option('msi_phone');
}

function msi_show_email() {
    echo get_option('msi_email');
}

function msi_admin_enqueue_scripts_and_styles() {
    wp_enqueue_style(
        'msi-style',
        plugins_url() . '/my-site-info/admin/assets/css/msi-admin-style.css'
    );
    wp_enqueue_script(
        'msi-script',
        plugins_url() . '/my-site-info/admin/assets/js/msi-admin-script.js',
        array(),
        time(),
        true
    );
    wp_localize_script(
        'msi-script',
        'msi_data',
        array(
            'ajax_url'      => admin_url( 'admin-ajax.php' ),
            'site_home'     => get_home_url(),
            'plugins_url'   => plugins_url(),
        )
    );
}
add_action( 'admin_enqueue_scripts', 'msi_admin_enqueue_scripts_and_styles' );

function msi_enqueue_public_scripts_and_styles() {
    wp_enqueue_style(
        'msi-style',
        plugins_url() . '/my-site-info/public/assets/css/msi-style.css'
    );
}
add_action( 'wp_enqueue_scripts', 'msi_enqueue_public_scripts_and_styles' );
