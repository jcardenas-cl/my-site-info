<table class="msi-form-table">
    <tr valign="top">
        <th scope="row"><?php _e( 'Celular', 'my_site_info' ); ?></th>
        <td><input
            type="text"
            name="txt-mobile-phone"
            id="txt-mobile-phone"
            class="input-text"
            value="<?php echo esc_attr( get_option('msi_mobile_phone') ); ?>"/>
            <span class="hint"><?php _e( 'Separe multiples números con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?>
                <i>[msi_show_mobile_phone_bar]</i></span></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e( 'Telefono', 'my_site_info' ); ?></th>
        <td><input
            type="text"
            name="txt-phone"
            id="txt-phone"
            class="input-text"
            value="<?php echo esc_attr( get_option('msi_phone') ); ?>"/>
            <span class="hint"><?php _e( 'Separe multiples números con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?>
                <i>[msi_show_phone_bar]</i></span></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e( 'Correo', 'my_site_info' ); ?></th>
        <td><input
            type="text"
            name="txt-email"
            id="txt-email"
            class="input-text"
            value="<?php echo esc_attr( get_option('msi_email') ); ?>"/>
            <span class="hint"><?php _e( 'Separe multiples correos con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?>
                <i>[msi_show_email_bar]</i></span></td>
    </tr>

    <tr valign="top">
        <th scope="row"><?php _e( 'Whatsapp', 'my_site_info' ); ?></th>
        <td><input
            type="text"
            name="txt-whatsapp"
            id="txt-whatsapp"
            class="input-text"
            value="<?php echo esc_attr( get_option('msi_whatsapp') ); ?>"/>
            <span class="hint"><?php _e( 'Separe multiples correos con una coma. Mostrar info. con shortcode', 'my_site_info' ); ?>
                <i>[msi_show_whatsapp_bar]</i></span></td>
    </tr>
</table>