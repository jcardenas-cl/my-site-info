<?php
/**
 * Crea una nueva entrada de opciones en el menú de apariencia
 * @since 1.0.0
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
 * Validamos que tenga los permisos necesarios para editar los datos, en caso de tenerlos, se le presenta el formulario para administrar los datos.
 * @since 1.0.0
 * @return void
 */
function show_display_with_theme_settings() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'Necesita un perfil con otro nivel de acceso para editar esta configuración', 'my_site_info' ) );
	}
    $update_info = collect_and_update_data();
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
    $obj_return             = new stdClass();
    $obj_return->updated    = false;
    $obj_return->error      = false;
    $obj_return->message    = '';
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

    // Validamos que hayan enviado el formulario a actualizar mediante un campo que siempre este presente.
    if ( isset( $_POST['txt-mobile-phone'] ) ) {
        update_option( 'msi_mobile_phone', filter_valid_values( $_POST['txt-mobile-phone'] ) );
        update_option( 'msi_phone', filter_valid_values( $_POST['txt-phone'] ) );
        $emails = explode( ',', filter_valid_values( $_POST['txt-email'] ) );
        foreach ( $emails as $email ) {
            if ( !msi_is_valid_email( $email ) ) {
                $obj_return->error      = true;
                $obj_return->message    = __('Revise la lista de correos, se ha guardado el resto de los datos', 'my_site_info');
                break;
            }
        }
        if ( !$obj_return->error ) {
            update_option( 'msi_email', filter_valid_values( $_POST['txt-email'] ) );
        }
        
        update_option( 'msi_whatsapp', filter_valid_values( $_POST['txt-whatsapp'] ) );
        update_option( 'msi_address', $_POST['txt-address'] );
        update_option( 'msi_map', $_POST['txt-map'] );
        update_option( 'layout_rrss', $_POST['rrss-layout'] );
        $obj_return->updated = true;
    }
    
    return $obj_return;
}

/**
 * Funcion sencilla que se encarga de validar que exista contenido en medio de los separadores,
 * esta funcion no valida si son valores validos como correos o telefonos, solo valida
 * que exista un valor presente, en caso de que se encuentren secciones vacias ya sea por
 * estar en ,, o por comas al final de una cadena.
 * @since 1.0.0
 * @param string $str_values Cadena con los valores a guardar.
 * @return string Cadena con los valores validos.
 */
function filter_valid_values( $str_values ) {
    $array_values   = explode( ',', $str_values );
    $return         = array();
    foreach ( $array_values as $item_value ) {
        if ( '' != trim( $item_value ) ) {
            $return[] = trim($item_value);
        }
    }

    return implode( ',', $return );
}

/**
 * Valida que un correo sea valido.
 * @since 1.0.0
 * 
 * @param string $email Cadena con el correo a validar
 * @return bool True de ser valido, false en caso contrario.
 */
function msi_is_valid_email( $email ) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    return true;
}

/**
 * Agregamos a la cola el listado de estilos y scripts que se usaran exclusivamente en el administrador.
 * @since 1.0.0
 */
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

/**
 * Se agregan a la cola el listado de estilos y script que se usan en el sitio de cara al usuario.
 * @since 1.0.0
 */
function msi_enqueue_public_scripts_and_styles() {
    wp_enqueue_style(
        'msi-style',
        plugins_url() . '/my-site-info/public/assets/css/msi-style.css'
    );
}
add_action( 'wp_enqueue_scripts', 'msi_enqueue_public_scripts_and_styles' );
