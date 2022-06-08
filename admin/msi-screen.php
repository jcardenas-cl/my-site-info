<div class="warp">
    <?php if( $update_info->error ): ?>
    <div class="error"><?php echo $update_info->message; ?></div>
    <?php elseif( $update_info->updated ): ?>
    <div class="updated"><?php _e('Ajustes guardados.', 'my_site_info' ); ?></div>
    <?php endif; ?>
    <form action="" method="post" name="msi-form" onsubmit="return msi_check_and_format()" enctype="multipart/form-data">
        <div class="msi-container">
            <section>
                <h3><?php _e( 'Redes Sociales', 'my_site_info' ); ?></h3>
                <div class="rrss-mode-selection">
                    <div class="label"><?php _e( 'Seleccione el modo en que cargará los iconos', 'my_site_info' ); ?></div>
                    <label for="rrss-mode-images">
                        <?php $checked = ( 'rrss-mode-image' == get_option('mode_rrss') ) ? ' checked' : ''; ?>
                        <input
                            type="radio"
                            name="rrss-mode"
                            id="rrss-mode-images"
                            class="input-radio rrss-mode-selection"
                            value="rrss-mode-images" <?php echo $checked; ?> />
                        <?php _e( 'Mediante imágenes', 'my_site_info' ); ?></label>
                    <label for="rrss-mode-fonts">
                    <?php $checked = ( 'rrss-mode-fonts' == get_option('mode_rrss') ) ? ' checked' : ''; ?>
                        <input
                            type="radio"
                            name="rrss-mode"
                            id="rrss-mode-fonts"
                            class="input-radio rrss-mode-selection"
                            value="rrss-mode-fonts" <?php echo $checked; ?> />
                        <?php _e( 'Mediante fuentes', 'my_site_info' ); ?></label>
                </div>
                <?php $display_font_list = ( 'rrss-mode-fonts' == get_option('mode_rrss') ) ? '' : ' no-display'; ?>
                <div class="fonts-urls<?php echo $display_font_list; ?>" id="fonts-urls">
                    <div class="label"><?php _e( 'Para usar el modo fuente, lo primero será subir los archivos con las fuentes, estos suelen tener las extrensiones .eot, .svg, .ttf, .woff y .woff2 para asegurar que sea visible en multiples navegadores', 'my_site_info' ); ?></div>
                    <div class="fonts-uploads">
                        <ul id="fonts-list">
                            <?php
                            $registered_fonts = json_decode( get_option( 'fonts_url' ) );
                            if ( 'array' == gettype($registered_fonts) ):
                                foreach( $registered_fonts as $font_url ):
                                    ?>
                                    <li class="font-row">
                                        <div class="file">
                                            <input type="file" name="font_file[]"></div>
                                        <div class="close-font-btn">X</div>
                                        <div><?php echo $font_url->url; ?>
                                            <input type="hidden" name="current_font_url[]" value="<?php echo esc_attr( $font_url->url ); ?>"></div>
                                    </li>
                                    <?php
                                endforeach;
                            endif;
                            ?>
                        </ul>
                        <div id="add-font-button" class="add-font-button"><?php _e( 'Haga clic aquí para agregar una fuente' ); ?></div>
                        <div class="hint"><?php _e( 'Guarde los datos al final del formulario para generar las url de las fuentes' , 'my_site_info' ); ?></div>

                        <div class="label"><?php _e( 'Con las url de todas las fuentes necesarias, es necesario editar el archivo css para que contenga dichas url,
                        esto puede variar dependiendo de muchos factores como nombre de la fuente, estilo, etc. De cualquier forma, el código a reemplazar será
                        similar al siguiente.', 'my_site_info' ); ?></div>
                        <code>
                        @font-face {
                            font-family: 'font_name';<br>
                            src: url('../font/font_name.eot?16052275');<br>
                            src: url('../font/font_name.eot?16052275#iefix') format('embedded-opentype'),<br>
                                url('../font/font_name.woff2?16052275') format('woff2'),<br>
                                url('../font/font_name.woff?16052275') format('woff'),<br>
                                url('../font/font_name.ttf?16052275') format('truetype'),<br>
                                url('../font/font_name.svg?16052275#font_name') format('svg');<br>
                            font-weight: normal;<br>
                            font-style: normal;<br>
                            }
                        </code>
                        <div class="label"><?php _e( 'Solo se deben reemplazar las URL de cada fuente por las entregadas en cada fuente subida, 
                        vigilando que se corresponda con los formatos mencionados. Una vez editado el archivo CSS, súbelo a continuación. Considere que este archivo reemplazará
                        al existente si es que ubiera uno, por lo que asegurese de que tambien esta incluyendo fuentes anteriores.', 'my_site_info' ); ?></div>
                        <div>
                            <input type="file" name="fonts_css_file">
                            <div><?php echo get_option( 'fonts_css_file' ); ?></div></div>
                        <div class="hint"><?php _e( 'Seleccione el archivo y guarde este formulario, una vez hecho eso, debe colocar las etiquetas a las redes sociales en el 
                        listado con las redes sociales mencionado abajo.', 'my_site_info' ); ?></div>
                    </div>
                </div>
                <h3><?php _e( 'Lista con redes sociales', 'my_site_info' ); ?></h3>
                <ul id="rrss-list" class="<?php echo ( 'rrss-mode-image' == get_option('mode_rrss') ) ? 'mode-images' : 'mode-fonts'; ?>">
                    <?php
                    $rrss_rows          = json_decode( get_option( 'rrss_options' ) );
                    $show_placeholder   = ( 'array' != gettype($rrss_rows) or 0 == count( $rrss_rows ) ) ? '' : 'no-display';
                    if ( ( 'array' == gettype($rrss_rows) and 0 < count( $rrss_rows ) ) ):
                        foreach( $rrss_rows as $rrss_row ):
                        ?>
                        <li class="rrss-row">
                            <div class="handler-cnt">
                                <img src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/move-icon.svg'; ?>">
                            </div>
                            <div class="rrss-icon-cnt">
                                <label>
                                    <input type="file" name="rrss_icon[]" class="input-file">
                                    <img src="<?php echo esc_attr( $rrss_row->icon ); ?>">
                                </label>
                                <input type="hidden" name="current_icon[]" value="<?php echo esc_attr( $rrss_row->icon ); ?>"></div>
                            <div class="rrss-font-cnt">
                                <input type="text" name="rrss_font[]" class="input-font" value="<?php echo stripslashes( esc_html($rrss_row->font) ); ?>"></div>
                            <div class="name-cnt">
                                <input
                                    type="text"
                                    placeholder="Nombre"
                                    name="rrss_name[]"
                                    class="input-text"
                                    value="<?php echo esc_attr( $rrss_row->name ); ?>"></div>
                            <div class="url-cnt">
                                <input
                                    type="url"
                                    placeholder="Url"
                                    name="rrss_url[]"
                                    class="input-text"
                                    value="<?php echo esc_attr( $rrss_row->url ); ?>"></div>
                            <div class="close-btn">X</div>
                        </li>
                        <?php
                        endforeach;
                    endif;
                    ?>
                    <li id="empty-rrss-row" class="<?php echo esc_attr($show_placeholder); ?>">
                        <?php _e( 'Haga clic en "Agregar red social" para iniciar este listado', 'my_site_info' ); ?>
                    </li>
                </ul>
                <div id="btn-add-social-network">
                    <img src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/add-icon.svg'; ?>" />
                    <?php _e( 'Agregar red social', 'my_site_info' ); ?></div>
                <div class="select-rrss-layout">
                    <div><strong><?php _e( 'Seleccione como desea ver la lista de RRSS', 'my_site_info' ); ?></strong></div>
                    <label for="layout-1">
                        <?php $checked = ( 'layout-1' == get_option('layout_rrss') ) ? ' checked' : ''; ?>
                        <input
                            type="radio"
                            name="rrss-layout"
                            id="layout-1"
                            class="input-radio"
                            value="layout-1" <?php echo $checked; ?> />
                        <?php _e( 'Solo iconos', 'my_site_info' ); ?></label>
                    <label for="layout-2">
                    <?php $checked = ( 'layout-2' == get_option('layout_rrss') ) ? ' checked' : ''; ?>
                        <input
                            type="radio"
                            name="rrss-layout"
                            id="layout-2"
                            class="input-radio"
                            value="layout-2" <?php echo $checked; ?> />
                        <?php _e( 'Iconos y nombre', 'my_site_info' ); ?></label>
                </div>
                <div class="hint"><?php _e( 'Para mostrar esta lista use el shortcode', 'my_site_info' ); ?> <i>[msi_rrss_bar]</i> </div>
            </section>
        </div>

        <div class="msi-container">
            <h3><?php _e( 'Contacto', 'my_site_info' ); ?></h3>
            <table class="msi-form-table">
                <tr valign="top">
                <th scope="row"><?php _e( 'Celular', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-mobile-phone"
                    id="txt-mobile-phone"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_mobile_phone') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples números con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?> <i>[msi_show_mobile_phone_bar]</i></span></td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?php _e( 'Telefono', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-phone"
                    id="txt-phone"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_phone') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples números con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?> <i>[msi_show_phone_bar]</i></span></td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?php _e( 'Correo', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-email"
                    id="txt-email"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_email') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples correos con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?> <i>[msi_show_email_bar]</i></span></td>
                </tr>

                <tr valign="top">
                <th scope="row"><?php _e( 'Whatsapp', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-whatsapp"
                    id="txt-whatsapp"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_whatsapp') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples correos con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?> <i>[msi_show_whatsapp_bar]</i></span></td>
                </tr>
            </table>
        </div>

        <div class="msi-container">
            <h3><?php _e( 'Ubicación', 'my_site_info' ); ?></h3>
            <table class="msi-form-table">
                <tr valign="top">
                <th scope="row"><?php _e( 'Dirección', 'my_site_info' ); ?></th>
                <td>
                    <?php
                    wp_editor( get_option('msi_address'), 'txt-address', array(
                        'textarea_rows'	=> '3',
                        'wpautop' 		=> false,
                        'media_buttons'	=> false,
                    ) );
                    ?>
                    <div class="hint"><?php _e( 'Para mostrar esta lista use el shortcode', 'my_site_info' ); ?> <i>[msi_show_address]</i> </div>
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?php _e( 'Mapa', 'my_site_info' ); ?></th>
                <td>
                    <?php
                    wp_editor( stripslashes(get_option('msi_map')), 'txt-map', array(
                        'textarea_rows'	=> 20,
                        'wpautop' 		=> false,
                        'media_buttons'	=> false,
                    ) );
                    ?>
                    <div class="hint"><?php _e( 'Para mostrar esta lista use el shortcode', 'my_site_info' ); ?> <i>[msi_show_map]</i> </div>
                </td>
                </tr>
            </table>
        </div>

        <?php submit_button(__('Guardar', 'my_site_info'), 'primary'); ?>
    </form>
</div>