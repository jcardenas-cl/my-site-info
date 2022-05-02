<?php
/**
 * Plantilla 1 para redes sociales
 * Se muestra simplemente el icono de las redes agregadas
 */
?>
<div class="msi-container">
    <ul class="msi-rrss-list">
        <?php
        $rrss_options = json_decode( get_option( 'rrss_options' ) );
        foreach( $rrss_options as $rrss ):
            ?>
            <li class="msi-list-item">
                <a href="<?php echo esc_url($rrss->url) ?>" class="msi-rrss-anchor" target="_blank">
                    <img
                        src="<?php echo esc_url( $rrss->icon ); ?>"
                        alt="<?php echo esc_attr( $rrss->name ); ?>"
                        title="<?php echo esc_attr( $rrss->name ); ?>"></a>
            </li>
            <?php
            endforeach;
        ?>
    </ul>
</div>