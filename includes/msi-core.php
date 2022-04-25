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
 * Muestra una estructura html con las distintas rrss agregadas
 */
function show_rrss_bar() {
    $rrss_options = json_decode( get_option( 'rrss_options' ) );
    // En una siguiente version iterar entre una coleccion de redes sociales, por ahora se define solo para bioamerica
    foreach( $rrss_options as $rrss ):
    ?>
    <a 
    class="linkIco mx-1"
    style="width: 33px; display: inline-block!important;"
    href="<?php echo esc_url($rrss->url) ?>"
    target="_blank">
        <img 
            src="<?php echo esc_url( $rrss->icon ); ?>"
            class="img-fluid">
        </a>
    <?php
    endforeach;
}

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