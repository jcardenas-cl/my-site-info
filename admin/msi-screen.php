<div class="warp">
    <?php if( $update_info->error ): ?>
    <div class="error"><?php echo $update_info->message; ?></div>
    <?php elseif( $update_info->updated ): ?>
    <div class="updated"><?php _e('Ajustes guardados.', 'my_site_info' ); ?></div>
    <?php endif; ?>
    <form action="" method="post" name="msi-form" onsubmit="return msi_check_and_format()" enctype="multipart/form-data">
        <div class="msi-container">
            <section>
                <div class="section-title"><?php _e( 'Redes Sociales', 'my_site_info' ); ?></div>
                <div class="select-rrss-layout">
                    <div class="label"><?php _e( 'Seleccione como desea ver la lista de RRSS', 'my_site_info' ); ?></div>
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
                <div class="rrss-mode-selection">
                    <div class="label"><?php _e( 'Seleccione el modo en que cargará los iconos', 'my_site_info' ); ?></div>
                    <label for="rrss-mode-images">
                        <?php $checked = ( 'rrss-mode-images' == get_option('mode_rrss') ) ? ' checked' : ''; ?>
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
                <div class="mb-15 fonts-urls-section<?php echo $display_font_list; ?>" id="fonts-urls-section">
                    <div class="msi-notice">
                        <?php _e( 'Para usar el modo fuente, lo primero será subir los archivos con las fuentes, estos suelen tener las extrensiones .eot, .svg, .ttf, .woff y .woff2 para asegurar que sea visible en multiples navegadores', 'my_site_info' ); ?></div>
                    <div class="fonts-uploads">
                        <strong><?php _e( 'Archivos de fuente', 'my_site_info' ); ?></strong>

                        <div id="upload-fonts-container" class="font-upload-section">
                            <div id="fonts-progress-bar"></div>
                            <img
                                class="upload-icon"
                                src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/upload-icon.svg'; ?>"
                                alt="<?php _e( 'Subir Fuentes', 'my_site_info' ); ?>">
                            <div class="upload-text" standard-message="<?php _e( 'Arrastra o selecciona los archivos de fuente', 'my_site_info' ); ?>">
                                <?php _e( 'Arrastra o selecciona los archivos de fuente', 'my_site_info' ); ?></div>
                            <input
                                type="file"
                                name="font_file"
                                id="font_file"
                                class="font-input-file"
                                onchange="msi_handle_font_files( this.files )"
                                multiple
                                accept=".eot,.svg,.woff,.woff2,.ttf">
                            <div class="upload-data"></div>
                        </div>

                        <div class="font-urls-section accordion msi-hidden">
                            <div class="hint"><?php _e( 'Reecuerda reemplazar las urls en el archivo css cuando subas una nueva fuente', 'my_site_info' ); ?></div>
                            <div class="show-toggle"><?php _e( 'Mostrar Url', 'my_site_info' ); ?> <img src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/arrow-icon.svg'; ?>" alt="" class="icon-toggle"></div>
                            <div class="fonts-urls content">
                                <?php
                                $registered_fonts = json_decode( get_option( 'fonts_url' ) );
                                if ( 'array' == gettype($registered_fonts) ):
                                    foreach( $registered_fonts as $font_url ):
                                        ?>
                                        <div class="font-row">
                                            <img
                                                class="img-copy-font-url"
                                                src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/copy-icon.svg'; ?>"
                                                alt="<?php _e( 'Copiar', 'my_site_info' ); ?>">
                                            <input type="url" class="txt-font-row" value="<?php echo $font_url; ?>" />
                                        </div>
                                        <?php
                                    endforeach;
                                else:
                                    _e( 'No se han subido archivos de fuente', 'my_site_info' );
                                endif;
                                ?>
                            </div>
                        </div>

                        <div class="label mt-10"><?php _e( 'Con las url de todas las fuentes necesarias, es necesario editar el archivo css para que contenga dichas url,
                        esto puede variar dependiendo de muchos factores como nombre de la fuente, estilo, etc. De cualquier forma, el código a reemplazar será
                        similar al siguiente.', 'my_site_info' ); ?></div>
                        <div class="css-example-section accordion msi-hidden mt-15">
                            <div class="show-toggle"><?php _e( 'Mostrar Ejemplo', 'my_site_info' ); ?> <img src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/arrow-icon.svg'; ?>" alt="" class="icon-toggle"></div>
                            <div class="content">
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
                            </div>
                        </div>
                        <div class="label mt-10 mb-15"><?php _e( 'Solo se deben reemplazar las URL de cada fuente por las entregadas en cada fuente subida, 
                        vigilando que se corresponda con los formatos mencionados. Una vez editado el archivo CSS, súbelo a continuación. Considere que este archivo reemplazará
                        al existente si es que ubiera uno, por lo que asegurese de que tambien esta incluyendo fuentes anteriores.', 'my_site_info' ); ?></div>
                        <div>
                            <div><strong><?php _e( 'Archivo CSS', 'my_site_info' ); ?></strong></div>
                            <input
                                class="mt-10"
                                type="file"
                                name="fonts_css_file"
                                id="fonts_css_file"
                                onchange="msi_handle_css_file( this.files )">
                            <input
                                type="hidden"
                                name="current_font_url"
                                value="<?php echo esc_url( 'fonts_css_file' ); ?>">
                            <div class="css-url-section accordion msi-hidden">
                                <div class="show-toggle mt-15"><?php _e( 'Mostrar Url', 'my_site_info' ); ?> <img src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/arrow-icon.svg'; ?>" alt="" class="icon-toggle"></div>
                                <div class="css-url content">
                                    <?php echo get_option( 'fonts_css_file' ); ?></div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="label"><?php _e( 'Lista con redes sociales', 'my_site_info' ); ?></div>
                <?php require 'fragment-rrss-list.php'; ?>
                <div id="btn-add-social-network"><?php _e( 'Haga clic para agregar un nuevo elemento', 'my_site_info' ); ?></div>
                <div class="hint"><?php _e( 'Para mostrar esta lista use el shortcode', 'my_site_info' ); ?> <i>[msi_rrss_bar]</i> </div>
            </section>
        </div>

        <div class="msi-container">
            <section>
                <div class="section-title"><?php _e( 'Contacto', 'my_site_info' ); ?></div>
                <?php require 'fragment-form-contact.php'; ?>
            </section>
        </div>

        <div class="msi-container">
            <section>
                <div class="section-title"><?php _e( 'Ubicación', 'my_site_info' ); ?></div>
                <?php require 'fragment-form-location.php'; ?>
            </section>
        </div>

        <?php submit_button(__('Guardar', 'my_site_info'), 'primary'); ?>
    </form>
</div>