<?php
/**
 * Tema hijo Punto y Aparte (tienda de ejemplo de Dania360).
 */

add_action( 'wp_enqueue_scripts', function () {
	$ver = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'punto-y-aparte', get_stylesheet_uri(), array(), $ver );
	wp_enqueue_script( 'punto-y-aparte', get_theme_file_uri( 'assets/pya.js' ), array(), $ver, array( 'in_footer' => true, 'strategy' => 'defer' ) );
}, 20 );

// Precarga de la foto de portada y de la tipografía de titulares.
add_action( 'wp_head', function () {
	echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/fonts/newsreader.woff2' ) ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	if ( is_front_page() ) {
		echo '<link rel="preload" href="' . esc_url( get_theme_file_uri( 'assets/img/portada.jpg' ) ) . '" as="image" fetchpriority="high">' . "\n";
	}
}, 1 );
