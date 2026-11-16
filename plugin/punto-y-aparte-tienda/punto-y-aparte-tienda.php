<?php
/**
 * Plugin Name: Punto y Aparte Tienda
 * Description: Catálogo, ajustes y funciones a medida de la tienda de ejemplo Punto y Aparte: recomendador de lecturas, envoltorio de regalo con dedicatoria, primeras líneas de cada libro, datos del libro a la vista, aviso de envío gratis, envíos y pago de prueba.
 * Version: 1.1.2
 * Author: Dania360
 * Requires Plugins: woocommerce
 * Text Domain: punto-y-aparte-tienda
 */

defined( 'ABSPATH' ) || exit;

define( 'PYA_VER', '1.1.2' );
define( 'PYA_DIR', plugin_dir_path( __FILE__ ) );
define( 'PYA_URL', plugin_dir_url( __FILE__ ) );

/** Precio del envoltorio de regalo. */
const PYA_ENVOLTORIO = 1.50;

require_once PYA_DIR . 'inc/datos.php';
require_once PYA_DIR . 'inc/montaje.php';
require_once PYA_DIR . 'inc/tienda.php';
require_once PYA_DIR . 'inc/ficha.php';
