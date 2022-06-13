<?php
/**
 * Plantilla 1 para redes sociales
 * Se muestra simplemente el icono de las redes agregadas
 */
?>
<div class="msi-container">
    <ul class="msi-rrss-list">
        <?php
        $rrss_options   = json_decode( get_option( 'rrss_options' ) );
        $max            = count( $rrss_options ) - 1;
        $mode           = get_option('mode_rrss');
        if ( $args['start'] + $args['limit'] <= $max ) {
            $max = $args['start'] + $args['limit'];
        }
        $i = -1;
        foreach ( $rrss_options as $rrss ):
            $i++;
            if ( $i < $args['start'] ) continue;
            if ( $i > $max ) break;
            ?>
            <li class="msi-list-item">
                <a href="<?php echo esc_url($rrss->url) ?>" class="msi-rrss-anchor" target="_blank">
                    <?php if ( 'rrss-mode-images' == $mode ): ?>
                    <img
                        src="<?php echo esc_url( $rrss->icon ); ?>"
                        alt="<?php echo esc_attr( $rrss->name ); ?>"
                        title="<?php echo esc_attr( $rrss->name ); ?>">
                    <?php
                    else:
                        echo stripslashes($rrss->font);
                    endif;
                    ?>
                    </a>
            </li>
            <?php
            endforeach;
        ?>
    </ul>
</div>