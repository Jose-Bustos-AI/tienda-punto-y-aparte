<?php
/**
 * Funciones visibles de la tienda Punto y Aparte.
 */
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'pya-tienda', PYA_URL . 'assets/pya-tienda.css', array(), PYA_VER );
	wp_enqueue_script( 'pya-tienda', PYA_URL . 'assets/pya-tienda.js', array(), PYA_VER, array( 'in_footer' => true, 'strategy' => 'defer' ) );
} );

/** Iconos del recomendador (trazo de 32x32). */
function pya_iconos() {
	return array(
		'enganche' => '<circle cx="14" cy="14" r="8"/><path d="M20 20l8 8M11 12a3 3 0 0 1 3-3"/>',
		'bonito'   => '<path d="M6 13h17v6a7 7 0 0 1-7 7h-3a7 7 0 0 1-7-7zM23 15h2a3 3 0 0 1 0 6h-2M11 4c-1 2 1 4 0 6M16 4c-1 2 1 4 0 6"/>',
		'reir'     => '<circle cx="16" cy="16" r="12"/><path d="M10 18c2 4 10 4 12 0M11 12h2M19 12h2"/>',
		'pensar'   => '<path d="M16 4a9 9 0 0 0-5 16v4h10v-4a9 9 0 0 0-5-16zM12 28h8M16 12v5M13.5 14.5h5"/>',
		'viajar'   => '<path d="M4 18l24-9-6 18-6-7-7 3 2-6zM16 20l6-11"/>',
		'peques'   => '<circle cx="11" cy="9" r="3"/><circle cx="21" cy="9" r="3"/><circle cx="16" cy="18" r="9"/><path d="M13 17h0M19 17h0M14 21c1 1 3 1 4 0"/>',
	);
}

/** Recomendador de lecturas: [pya_lecturas] */
add_shortcode( 'pya_lecturas', function () {
	$animos = pya_animos();
	$iconos = pya_iconos();
	ob_start();
	?>
	<section class="pya-lee" id="que-leo" aria-labelledby="pya-lee-titulo">
		<div class="pya-lee__in">
			<div class="pya-lee__cab">
				<p class="pya-ceja"><span></span>Recomendador de lecturas</p>
				<h2 class="pya-titulo" id="pya-lee-titulo">¿Qué te apetece <em>leer ahora?</em></h2>
				<p>Dinos qué te pide el cuerpo y cuánto lees al día. Te recomendamos dos libros y te decimos en cuántos días los terminarías.</p>
			</div>
			<div class="pya-lee__botones" role="tablist" aria-label="Qué te apetece">
				<?php $i = 0; foreach ( $animos as $clave => $a ) : ?>
					<button type="button" role="tab" id="pya-tab-<?php echo esc_attr( $clave ); ?>" aria-controls="pya-panel-<?php echo esc_attr( $clave ); ?>" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" tabindex="<?php echo 0 === $i ? '0' : '-1'; ?>">
						<svg viewBox="0 0 32 32" aria-hidden="true"><?php echo $iconos[ $clave ]; // phpcs:ignore ?></svg>
						<span><?php echo esc_html( $a['nombre'] ); ?></span>
					</button>
				<?php $i++; endforeach; ?>
			</div>
			<div class="pya-lee__ritmo">
				<label for="pya-minutos">¿Cuánto lees al día?</label>
				<input type="range" id="pya-minutos" min="10" max="90" step="5" value="30" aria-describedby="pya-minutos-txt">
				<output id="pya-minutos-txt" for="pya-minutos">30 minutos</output>
			</div>
			<?php $i = 0; foreach ( $animos as $clave => $a ) : ?>
				<div class="pya-lee__panel" role="tabpanel" id="pya-panel-<?php echo esc_attr( $clave ); ?>" aria-labelledby="pya-tab-<?php echo esc_attr( $clave ); ?>" <?php echo 0 === $i ? '' : 'hidden'; ?>>
					<p class="pya-lee__frase"><?php echo esc_html( $a['frase'] ); ?></p>
					<div class="pya-lee__libros">
						<?php foreach ( $a['libros'] as $slug ) :
							$p = wc_get_product( pya_id_por_slug( $slug ) );
							if ( ! $p ) {
								continue;
							}
							$paginas = (int) get_post_meta( $p->get_id(), '_pya_paginas', true );
							?>
							<article class="pya-lee__libro">
								<a class="pya-lee__portada" href="<?php echo esc_url( $p->get_permalink() ); ?>" tabindex="-1" aria-hidden="true"><?php echo $p->get_image( 'woocommerce_thumbnail', array( 'loading' => 'lazy' ) ); // phpcs:ignore ?></a>
								<div class="pya-lee__info">
									<h3><a href="<?php echo esc_url( $p->get_permalink() ); ?>"><?php echo esc_html( $p->get_name() ); ?></a></h3>
									<p class="pya-lee__autor"><?php echo esc_html( get_post_meta( $p->get_id(), '_pya_autor', true ) ); ?> · <?php echo (int) $paginas; ?> páginas</p>
									<blockquote>"<?php echo esc_html( get_post_meta( $p->get_id(), '_pya_inicio', true ) ); ?>"</blockquote>
									<p class="pya-lee__dias" data-paginas="<?php echo (int) $paginas; ?>" aria-live="polite"></p>
									<div class="pya-lee__pie">
										<span class="pya-lee__precio"><?php echo wp_kses_post( $p->get_price_html() ); ?></span>
										<a class="pya-btn pya-btn--peq" href="<?php echo esc_url( $p->get_permalink() ); ?>">Ver el libro</a>
									</div>
								</div>
							</article>
						<?php endforeach; ?>
					</div>
				</div>
			<?php $i++; endforeach; ?>
		</div>
	</section>
	<?php
	return ob_get_clean();
} );

/** Autor bajo el título en la ficha y en las tarjetas. */
add_action( 'woocommerce_single_product_summary', function () {
	$autor = get_post_meta( get_the_ID(), '_pya_autor', true );
	if ( $autor ) {
		echo '<p class="pya-ficha-autor">de <b>' . esc_html( $autor ) . '</b></p>';
	}
}, 6 );
add_action( 'woocommerce_after_shop_loop_item_title', function () {
	$autor = get_post_meta( get_the_ID(), '_pya_autor', true );
	if ( $autor ) {
		echo '<p class="pya-tarjeta-autor">' . esc_html( $autor ) . '</p>';
	}
}, 6 );

/** "Así empieza": primeras líneas del libro y tiempo de lectura. */
add_action( 'woocommerce_single_product_summary', function () {
	$id     = get_the_ID();
	$inicio = get_post_meta( $id, '_pya_inicio', true );
	if ( ! $inicio ) {
		return;
	}
	$paginas = (int) get_post_meta( $id, '_pya_paginas', true );
	$horas   = max( 1, round( $paginas * 1.1 / 60 ) );
	echo '<figure class="pya-empieza"><figcaption>Así empieza</figcaption><blockquote>"' . esc_html( $inicio ) . '"</blockquote>';
	echo '<p>' . ( $paginas < 80 ? 'Se lee en una noche, antes de dormir' : 'Unas ' . (int) $horas . ' horas de lectura · ' . (int) $paginas . ' páginas' ) . '</p></figure>';
}, 25 );

/** Envoltorio de regalo y dedicatoria en la ficha de cada producto. */
add_action( 'woocommerce_before_add_to_cart_button', function () {
	?>
	<div class="pya-regalo">
		<label class="pya-regalo__si"><input type="checkbox" name="pya_regalo" value="1"> <span>Envolver para regalo</span> <b>+<?php echo esc_html( wc_format_localized_price( number_format( PYA_ENVOLTORIO, 2, '.', '' ) ) ); ?> €</b></label>
		<div class="pya-regalo__dedi" hidden>
			<label for="pya-dedicatoria">Dedicatoria (opcional)</label>
			<textarea id="pya-dedicatoria" name="pya_dedicatoria" maxlength="150" rows="3" placeholder="La escribimos a mano en una tarjeta dentro del paquete"></textarea>
			<small><span data-quedan>150</span> caracteres disponibles</small>
		</div>
	</div>
	<?php
} );

add_filter( 'woocommerce_add_cart_item_data', function ( $datos ) {
	if ( ! empty( $_POST['pya_regalo'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
		$datos['pya_regalo'] = 1;
		$dedi                = isset( $_POST['pya_dedicatoria'] ) ? sanitize_textarea_field( wp_unslash( $_POST['pya_dedicatoria'] ) ) : ''; // phpcs:ignore
		if ( '' !== $dedi ) {
			$datos['pya_dedicatoria'] = mb_substr( $dedi, 0, 150 );
		}
	}
	return $datos;
} );

add_filter( 'woocommerce_get_item_data', function ( $lineas, $item ) {
	if ( ! empty( $item['pya_regalo'] ) ) {
		$lineas[] = array( 'name' => 'Envoltorio de regalo', 'value' => 'Sí' );
		if ( ! empty( $item['pya_dedicatoria'] ) ) {
			$lineas[] = array( 'name' => 'Dedicatoria', 'value' => $item['pya_dedicatoria'] );
		}
	}
	return $lineas;
}, 10, 2 );

/** El envoltorio suma 1,50 € al precio de esa línea. */
add_action( 'woocommerce_before_calculate_totals', function ( $carrito ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return;
	}
	foreach ( $carrito->get_cart() as $item ) {
		if ( ! empty( $item['pya_regalo'] ) ) {
			$base = wc_get_product( $item['data']->get_id() );
			if ( $base ) {
				$item['data']->set_price( (float) $base->get_price() + PYA_ENVOLTORIO );
			}
		}
	}
}, 20 );

add_action( 'woocommerce_checkout_create_order_line_item', function ( $linea, $clave, $item ) {
	if ( ! empty( $item['pya_regalo'] ) ) {
		$linea->add_meta_data( 'Envoltorio de regalo', 'Sí' );
		if ( ! empty( $item['pya_dedicatoria'] ) ) {
			$linea->add_meta_data( 'Dedicatoria', $item['pya_dedicatoria'] );
		}
	}
}, 10, 3 );

/** En las tarjetas del cuaderno, el botón dice "Elegir hojas". */
add_filter( 'woocommerce_product_add_to_cart_text', function ( $texto, $product ) {
	return $product->is_type( 'variable' ) ? 'Elegir hojas' : $texto;
}, 10, 2 );

/** Si el pedido tiene envío gratis, no mostrar el estándar de pago (sí el exprés). */
add_filter( 'woocommerce_package_rates', function ( $tarifas ) {
	$hay_gratis = false;
	foreach ( $tarifas as $t ) {
		if ( 'free_shipping' === $t->get_method_id() ) {
			$hay_gratis = true;
		}
	}
	if ( $hay_gratis ) {
		$estandar = (int) get_option( 'pya_envio_estandar' );
		foreach ( $tarifas as $clave => $t ) {
			if ( 'flat_rate' === $t->get_method_id() && (int) $t->get_instance_id() === $estandar ) {
				unset( $tarifas[ $clave ] );
			}
		}
	}
	return $tarifas;
}, 100 );

/** El pago de prueba deja el pedido como "Procesando", igual que un pago con tarjeta. */
add_filter( 'woocommerce_cheque_process_payment_order_status', function () {
	return 'processing';
} );

/** Sin referencias (SKU) en una tienda de ejemplo. */
add_filter( 'wc_product_sku_enabled', '__return_false' );

/** Comillas normales en lugar de « » en todos los textos de la tienda. */
function pya_comillas( $texto ) {
	return ( is_string( $texto ) && false !== strpbrk( $texto, '«»' ) ) ? str_replace( array( '«', '»' ), '"', $texto ) : $texto;
}
add_filter( 'gettext', 'pya_comillas', 99 );
add_filter( 'ngettext', 'pya_comillas', 99 );
add_filter( 'gettext_with_context', 'pya_comillas', 99 );
add_filter( 'woocommerce_add_message', 'pya_comillas', 99 );
add_filter( 'woocommerce_add_success', 'pya_comillas', 99 );
add_filter( 'woocommerce_add_error', 'pya_comillas', 99 );
add_filter( 'woocommerce_add_notice', 'pya_comillas', 99 );
add_action( 'wp_enqueue_scripts', function () {
	$js = "(function(){if(!window.wp||!wp.hooks)return;var f=function(t){return typeof t==='string'?t.replace(/[\\u00ab\\u00bb]/g,'\"'):t;};['i18n.gettext','i18n.ngettext','i18n.gettext_with_context','i18n.ngettext_with_context'].forEach(function(h){wp.hooks.addFilter(h,'pya/comillas',f,99);});})();";
	wp_add_inline_script( 'wp-i18n', $js, 'after' );
}, 1 );
add_filter( 'load_script_translations', function ( $json ) {
	return is_string( $json ) ? str_replace( array( '«', '»', '«', '»' ), '\"', $json ) : $json;
}, 99 );

/** Las páginas se revalidan siempre: así nadie ve precios o carritos antiguos. */
add_action( 'send_headers', function () {
	if ( ! is_admin() ) {
		header( 'Cache-Control: no-cache, must-revalidate, max-age=0', true );
	}
}, 99 );

/** Tienda de ejemplo: que no aparezca en buscadores. */
add_filter( 'wp_robots', function ( $robots ) {
	$robots['noindex']  = true;
	$robots['nofollow'] = true;
	return $robots;
} );
