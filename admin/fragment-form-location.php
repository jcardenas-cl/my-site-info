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
            <div class="hint"><?php _e( 'Para mostrar esta lista use el shortcode', 'my_site_info' ); ?>
                <i>[msi_show_address]</i>
            </div>
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
            <div class="hint"><?php _e( 'Para mostrar esta lista use el shortcode', 'my_site_info' ); ?>
                <i>[msi_show_map]</i>
            </div>
        </td>
    </tr>
</table>