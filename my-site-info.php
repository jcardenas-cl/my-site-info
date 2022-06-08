<?php
/**
 * Plugin Name: My site info
 * Plugin URI: https://arknite.dev/plugins/my-site-info
 * Description: Pequeño plugin para agregar información sobre redes sociales, direccion y contacto del sitio.
 * Version: 1.0.0
 * Author: Julio Cárdenas
 * Author URI: https://arknite.dev
 * Text Domain: my_site_info
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'My_site_info' ) ) {
	class My_site_info {
		
		/**
		 * Definir la versión del plugin actual.
		 *
		 * @var String $plugin_version Versión del plugin.
		 */
		private $plugin_version = '1.0.0';

		/**
		 * Constructor del plugin, de momento se inicia vacio
		 */
		public function __construct() {

		}

		/**
		 * Realiza la instalación del plugin
		 *
		 * @return void
		 */
		public static function install() {
			update_option( 'layout_rrss', 'layout-1' );
			update_option( 'mode_rrss', 'rrss-mode-image' );
		}

		/**
		 * Metodo que se ejecuta al cargar el plugin, cuando ya esta activado
		 *
		 * @return void
		 */
		public function init_setup() {
			include_once plugin_dir_path( __FILE__ ) . 'includes/msi-core.php';
			include_once plugin_dir_path( __FILE__ ) . 'includes/msi-frontend.php';

			add_filter('upload_mimes', function ($existing_mimes) {
				$existing_mimes['otf'] 		= 'application/x-font-otf';
				$existing_mimes['woff'] 	= 'application/x-font-woff';
				$existing_mimes['woff2']	= 'application/x-font-woff';
				$existing_mimes['ttf'] 		= 'application/x-font-ttf';
				$existing_mimes['svg'] 		= 'image/svg+xml';
				$existing_mimes['eot'] 		= 'application/vnd.ms-fontobject';
				$existing_mimes['css'] 		= 'text/plain';
				
				return $existing_mimes;
			});
		}
	
	}
}

$my_site_info = new My_site_info();
$my_site_info->init_setup();

register_activation_hook( __FILE__, [ 'My_site_info', 'install' ] );