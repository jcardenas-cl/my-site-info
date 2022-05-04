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
                <ul id="rrss-list">
                <?php
                $rrss_rows = json_decode( get_option( 'rrss_options' ) );
                $show_placeholder = ( 0 == count( $rrss_rows ) ) ? '' : 'no-display';
                    ?>
                    <li id="empty-rrss-row" class="<?php echo esc_attr($show_placeholder); ?>">
                        <?php _e( 'Haga clic en "Agregar red social" para iniciar este listado', 'my_site_info' ); ?>
                    </li>
                    <?php
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
                ?>
                </ul>
                <div id="btn-add-social-network">
                    <img src="<?php echo plugins_url() . '/my-site-info/admin/assets/img/add-icon.svg'; ?>" />
                    <?php _e( 'Agregar red social', 'my_site_info' ); ?></div>
                <div class="select-rrss-layout">
                    <div><strong><?php _e( 'Seleccione como desea ver la lista de RRSS', 'my_site_info' ); ?></strong></div>
                    <label for="layout-1">
                        <?php $checked = ( 'layout-1' == get_option('layout_rrss') ) ? ' checked' : ''; ?>
                        <input type="radio" name="rrss-layout" id="layout-1" class="input-radio" value="layout-1" <?php echo $checked; ?> />
                        <?php _e( 'Solo iconos', 'my_site_info' ); ?></label>
                    <label for="layout-2">
                    <?php $checked = ( 'layout-2' == get_option('layout_rrss') ) ? ' checked' : ''; ?>
                        <input type="radio" name="rrss-layout" id="layout-2" class="input-radio" value="layout-2" <?php echo $checked; ?> />
                        <?php _e( 'Iconos y nombre', 'my_site_info' ); ?></label>
                </div>
                <div class="hint"><?php _e( 'Agregue el shorcode [msi_rrss_bar] para mostrar las redes sociales', 'my_site_info' ); ?></div>
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
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_mobile_phone') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples números con una coma', 'my_site_info' ); ?></span></td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?php _e( 'Telefono', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-phone"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_phone') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples números con una coma', 'my_site_info' ); ?></span></td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?php _e( 'Correo', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-email"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_email') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples correos con una coma', 'my_site_info' ); ?></span></td>
                </tr>

                <tr valign="top">
                <th scope="row"><?php _e( 'Whatsapp', 'my_site_info' ); ?></th>
                <td><input
                    type="text"
                    name="txt-whatsapp"
                    class="input-text"
                    value="<?php echo esc_attr( get_option('msi_whatsapp') ); ?>" />
                    <span class="hint"><?php _e( 'Separe multiples correos con una coma', 'my_site_info' ); ?></span></td>
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
                    wp_editor( get_option('msi_address'), 'txt-address', $settings = array(
                        'textarea_rows'	=> '3',
                        'wpautop' 		=> false,
                        'media_buttons'	=> false,
                    ) );
                    ?>
                </td>
                </tr>
                
                <tr valign="top">
                <th scope="row"><?php _e( 'Mapa', 'my_site_info' ); ?></th>
                <td>
                    <?php
                    wp_editor( stripslashes(get_option('msi_map')), 'txt-map', $settings = array(
                        'textarea_rows'	=> 20,
                        'wpautop' 		=> false,
                        'media_buttons'	=> false,
                    ) );
                    ?>
                </td>
                </tr>
            </table>
        </div>

        <?php submit_button(__('Guardar', 'my_site_info'), 'primary'); ?>
    </form>
</div>