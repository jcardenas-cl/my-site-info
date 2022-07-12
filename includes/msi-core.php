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
    $obj_return->error_items= array();
    // Datos de las redes sociales ingresadas
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    $rrss_info  = array();

    // Validamos que hayan enviado el formulario a actualizar mediante un campo que siempre este presente.
    if ( isset( $_POST['txt-mobile-phone'] ) ) {
        $urls           = $_POST['rrss_url'];
        $names          = $_POST['rrss_name'];
        $current_icons  = $_POST['current_icon'];
        $fonts          = $_POST['rrss_font'];

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
        $i = 0;
        foreach ( $fonts as $font ) {
            $rrss_info[$i]['font'] = $font;
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
                // No se subió un icono, asi que solo asignamos la url del icono por defecto, en caso de que no haya un icono previamente ajustado
                if ( '' == trim($rrss_info[$i]['icon']) ) {
                    $rrss_info[$i]['icon']  = plugins_url() . '/my-site-info/admin/assets/img/image-icon.svg';
                }
            }

            $i++;
        }

        $rrss_json = json_encode( $rrss_info );
        update_option( 'rrss_options', $rrss_json );

        // Dado que en el flujo normal los archivos de fuente se suben y registran de manera asincrona, en este punto debemos consultar si es que viene
        // realmente algún dato, se deja solo en caso de que se descubra que con algun navegador no se pueden subir los archivos de esa manera.
        $font_files                 = $_FILES['font_file'];
        $accepted_font_extensions   = ['eot','svg','ttf','woff','woff2'];
        $i                          = 0;
            
        foreach ( $font_files['name'] as $key => $value ) {
            if ( !in_array(pathinfo($font_files['name'][$key], PATHINFO_EXTENSION), $accepted_font_extensions ) ) {
                // Por ahora solo omitimos la subida, considerar tomar una accion a futuro de ser necesario.
            } else {
                if ( $font_files['name'][ $key ] ) {
                    $file = array(
                        'name'      => $font_files['name'][$key],
                        'type'      => $font_files['type'][$key],
                        'tmp_name'  => $font_files['tmp_name'][$key],
                        'error'     => $font_files['error'][$key],
                        'size'      => $font_files['size'][$key],
                    );
            
                    $upload_result = wp_handle_upload( $file, array( 'test_form' => false ) );
    
                    if ( $upload_result and !isset( $upload_result['error'] ) ) {
                        $sent_url_fonts[$i] = $upload_result['url'];
                    }
                }
                $i++;
            }
        }

        // Se ejecuta solo en caso de que haya ingresado al foreach con las fuentes subidas mediante el submit del formulario
        if ( isset($sent_url_fonts) ) {
            update_option( 'fonts_url', json_encode( $sent_url_fonts ) );
        }
        
        // Obtener, validar y registrar archivo css para vincular las fuentes, solo en caso de que se encuentre presente
        // pues en un flujo normal, este archivo se procesa de manera asincrona.
        if ( $_FILES['fonts_css_file']['size'] > 0 ) {
            $css_font_file              = $_FILES['fonts_css_file'];
            $accepted_css_extensions    = array( 'css' );
            if ( !in_array( pathinfo($css_font_file['name'], PATHINFO_EXTENSION), $accepted_css_extensions ) ) {
                // Por ahora solo omitimos la subida, considerar tomar una accion a futuro de ser necesario.
            } else {
                $css_upload_result  = wp_handle_upload( $css_font_file, array( 'test_form' => false ) );
    
                if ( $css_upload_result and !isset( $css_upload_result['error'] ) ) {
                    update_option( 'fonts_css_file', $css_upload_result['url'] );   
                }
            }
        }
        
        // Validación teléfono móvil
        $mobile_phones = filter_valid_values( $_POST['txt-mobile-phone'] );
        if ( msi_is_valid_phone_number_format( $mobile_phones ) ) {
            update_option( 'msi_mobile_phone', implode( ',', $mobile_phones ) );
        } else {
            $obj_return->error          = true;
            $obj_return->error_items[]  = __('Celular', 'my_site_info');
        }

        // Validación teléfono fijo
        $phones = filter_valid_values( $_POST['txt-phone'] );
        if ( msi_is_valid_phone_number_format( $phones ) ) {
            update_option( 'msi_phone', implode( ',', $phones ) );
        } else {
            $obj_return->error          = true;
            $obj_return->error_items[]  = __('Teléfono', 'my_site_info');
        }
        
        // Validación de correos
        $emails = filter_valid_values( $_POST['txt-email'] );
        if ( msi_is_valid_email( $emails ) ) {
            update_option( 'msi_email', implode( ',', $emails ) );
        } else {
            $obj_return->error          = true;
            $obj_return->error_items[]  = __('Correos', 'my_site_info');
        }
        
        // Validación de teléfonos whatsapp
        $wsp_phones = filter_valid_values( $_POST['txt-whatsapp'] );
        if ( msi_is_valid_phone_number_format( $wsp_phones ) ) {
            update_option( 'msi_whatsapp', implode( ',', $wsp_phones ) );
        } else {
            $obj_return->error          = true;
            $obj_return->error_items[]  = __('WhatsApp', 'my_site_info');
        }

        update_option( 'msi_address', $_POST['txt-address'] );
        update_option( 'msi_map', $_POST['txt-map'] );
        update_option( 'layout_rrss', $_POST['rrss-layout'] );
        update_option( 'mode_rrss', $_POST['rrss-mode'] );
        $obj_return->updated = true;
    }

    if ( $obj_return->error ) {
        $obj_return->message = __( 'Por favor revise los siguientes campos: ', 'my_site_info' ) . implode( ', ', $obj_return->error_items ) . __( '. Los demas datos se han guardado', 'my_site_info' );
    }
    
    return $obj_return;
}

/**
 * Funcion sencilla que se encarga de validar que exista contenido en medio de los separadores,
 * esta funcion no valida si son valores validos como correos o telefonos, solo valida
 * que tenga un valor presente, en caso de que se encuentren secciones vacias ya sea por
 * estar en ,, o por comas al final de una cadena.
 * @since 1.0.0
 * @param string $str_values Cadena con los valores a guardar.
 * @return array Arreglo con valores que no esten vacios
 */
function filter_valid_values( $str_values ) {
    $array_values   = explode( ',', $str_values );
    $return         = array();
    foreach ( $array_values as $item_value ) {
        if ( '' != trim( $item_value ) ) {
            $return[] = trim($item_value);
        }
    }

    return $return;
}

/**
 * Valida que un correo sea valido.
 * @since 1.0.0
 * 
 * @param string|array $email Cadena con el correo a validar o arreglo con una lista de cadenas.
 * @return bool True de ser valido, false en caso contrario.
 */
function msi_is_valid_email( $email ) {
    // Forzamos que sea un arreglo para procesar todo de la misma manera
    if ( 'array' == gettype($email) ) {
        $emails = $email;
    } else {
        $emails[0] = $email;
    }

    foreach ( $emails as $email ) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
    }

    return true;
}

/**
 * Valida que un elemento tiena un formato valido como número telefónico. Dado que puede llegar a ser usado con números internacionales
 * solo se valida que la cadena tenga números y el simbolo "+" de manera opcional.
 * @since 1.0.0
 * 
 * @param string|array $phone Cadena con el número telefónico a validar, también puede ser un arreglo con varias cadenas a validar.
 * @return bool True en caso de ser valido, false en caso contrario.
 */
function msi_is_valid_phone_number_format( $phone ) {
    // Forzamos que sea un arreglo para procesar todo de la misma manera
    if ( 'array' == gettype($phone) ) {
        $phones = $phone;
    } else {
        $phones[0] = $phone;
    }

    // Validamos que cada item tenga el formato correcto.
    foreach ( $phones as $phone ) {
        $number_portion = substr( $phone, 1, strlen($phone) - 1 );
        if ( !is_numeric( $number_portion ) or ( !is_numeric( $phone[0] ) and $phone[0] != '+' ) ) {
            return false;
        }
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
        plugins_url() . '/my-site-info/admin/assets/css/msi-admin-style.min.css'
    );
    wp_enqueue_script(
        'msi-script',
        plugins_url() . '/my-site-info/admin/assets/js/msi-admin-script.js',
        array( 'wp-i18n' ),
        time(),
        true
    );
    wp_set_script_translations(
        'msi-script',
        'my_site_info',
        plugins_url('languages', __FILE__ )
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
        plugins_url() . '/my-site-info/public/assets/css/msi-style.min.css'
    );
}
add_action( 'wp_enqueue_scripts', 'msi_enqueue_public_scripts_and_styles' );

/**
 * Función encargada de recibir y subir al servidor los archivos de fuente para los iconos de redes sociales, solo admite un icono y es llamado
 * por cada archivo seleccionado.
 * @since 1.2.0
 */
function msi_process_font_upload() {
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    
    $accepted_extensions= ['eot','svg','ttf','woff','woff2'];
    $uploaded_file      = $_FILES['file'];
    $json_fonts         = json_decode( get_option( 'fonts_url' ) );
    $registered_fonts   = (is_array($json_fonts)) ? $json_fonts : array();

    if ( !in_array(pathinfo($uploaded_file['name'], PATHINFO_EXTENSION), $accepted_extensions ) ) {
        wp_send_json(array(
            'status'    => 'error',
            'message'   => __( 'Formato no admitido', 'my_site_info' ) . ' ('.pathinfo($uploaded_file['name'], PATHINFO_EXTENSION).')',
            'list'      => json_encode($registered_fonts),
        ));
    } else {
        $movefile           = wp_handle_upload( $uploaded_file, array( 'test_form' => false ) );
        if ( $movefile && !isset( $movefile['error'] ) ) {
            $new_font_url       = $movefile['url'];
            $inserted           = false;
            for ( $i = 0; $i <= count($registered_fonts) -1; $i++ ) {
                // Comparar extensiones para saber si reemplazar la url o registrar como nueva.
                if ( pathinfo($new_font_url, PATHINFO_EXTENSION) == pathinfo($registered_fonts[$i], PATHINFO_EXTENSION) ) {
                    $registered_fonts[$i]   = $new_font_url;
                    $inserted               = true;
                }
            }
    
            if ( !$inserted ) {
                $registered_fonts[] = $new_font_url;
            }
    
            $json_encoded_fonts = json_encode( (array)$registered_fonts );
            update_option( 'fonts_url', $json_encoded_fonts );
            
            wp_send_json(array(
                'status'    => 'ok',
                'url'       => $movefile['url'],
                'list'      => $json_encoded_fonts,
    
            ));
        } else {
            wp_send_json(array(
                'status'    => 'error',
                'message'   => __( 'Error al subir la fuente', 'my_site_info' ),
                'list'      => json_encode($registered_fonts),
            ));
        }
    }
}
add_action( 'wp_ajax_upload_font', 'msi_process_font_upload' );

function msi_process_css_upload() {
    if ( ! function_exists( 'wp_handle_upload' ) ) {
        require_once( ABSPATH . 'wp-admin/includes/file.php' );
    }
    
    $accepted_extensions= ['css'];
    $uploaded_file      = $_FILES['file'];
    $css_url            = get_option( 'fonts_css_file' );

    if ( !in_array(pathinfo($uploaded_file['name'], PATHINFO_EXTENSION), $accepted_extensions ) ) {
        wp_send_json(array(
            'status'    => 'error',
            'message'   => __( 'Formato no admitido', 'my_site_info' ) . ' ('.pathinfo($uploaded_file['name'], PATHINFO_EXTENSION).')',
            'url'       => $css_url,
        ));
    } else {
        $movefile           = wp_handle_upload( $uploaded_file, array( 'test_form' => false ) );
        if ( $movefile && !isset( $movefile['error'] ) ) {
            $new_css_url       = $movefile['url'];
            update_option( 'fonts_css_file', $new_css_url );
            
            wp_send_json(array(
                'status'    => 'ok',
                'url'       => $movefile['url'],
            ));
        } else {
            wp_send_json(array(
                'status'    => 'error',
                'message'   => __( 'Error al subir la fuente', 'my_site_info' ),
                'url'       => $css_url,
            ));
        }
    }
}
add_action( 'wp_ajax_msi_upload_css', 'msi_process_css_upload' );