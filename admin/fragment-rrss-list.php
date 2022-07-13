<ul
    id="rrss-list"
    class="mt-10 <?php echo ( 'rrss-mode-images' == get_option('mode_rrss') ) ? 'mode-images' : 'mode-fonts'; ?>">
    <?php
    $rrss_rows  = json_decode( get_option( 'rrss_options' ) );
    if ( ( 'array' == gettype($rrss_rows) and 0 < count( $rrss_rows ) ) ):
        $i = 1;
        foreach( $rrss_rows as $rrss_row ):
        ?>
    <li class="rrss-row">
        <div class="handler-cnt">
            <?php echo $i; ?></div>
        <div class="rrss-icon-cnt">
            <label>
                <input
                    type="file"
                    name="rrss_icon[]"
                    class="input-file"
                    accept="image/*">
                <img src="<?php echo esc_attr( $rrss_row->icon ); ?>">
            </label>
            <input
                type="hidden"
                name="current_icon[]"
                value="<?php echo esc_attr( $rrss_row->icon ); ?>"></div>
        <div class="rrss-font-cnt">
            <input
                type="text"
                name="rrss_font[]"
                class="input-font"
                placeholder='<i class="icon-rrss"></i>'
                value="<?php echo stripslashes( esc_html($rrss_row->font) ); ?>"></div>
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
        $i++; endforeach;
    endif;
    ?>
</ul>