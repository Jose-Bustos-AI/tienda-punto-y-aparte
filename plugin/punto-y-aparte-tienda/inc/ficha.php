<?php
/**
 * Ficha de producto, página de tienda y portada: piezas a medida de Punto y Aparte.
 */
defined( 'ABSPATH' ) || exit;

/** Importe a partir del cual el envío estándar es gratis. */
const PYA_ENVIO_GRATIS = 30;

add_action( 'wp_enqueue_scripts', function () {
	wp_localize_script( 'pya-tienda', 'PYA', array( 'envioGratis' => PYA_ENVIO_GRATIS ) );
}, 20 );

/* ---------- Descripción para buscadores y para compartir ---------- */

function pya_descripcion_pagina() {
	if ( is_front_page() ) {
		return 'Librería y papelería de barrio, también en internet: novela, misterio, ensayo y álbumes ilustrados elegidos uno a uno. Envoltorio de regalo con dedicatoria y envío gratis desde 30 €.';
	}
	if ( function_exists( 'is_product' ) && is_product() ) {
		return wp_strip_all_tags( get_post_field( 'post_excerpt', get_queried_object_id() ) );
	}
	if ( function_exists( 'is_product_category' ) && is_product_category() ) {
		return wp_strip_all_tags( term_description() );
	}
	if ( function_exists( 'is_shop' ) && is_shop() ) {
		return 'Novela, misterio, ensayo, humor, libros infantiles y papelería para escribir a mano. Cada libro, con sus primeras líneas y envoltorio de regalo si lo quieres.';
	}
	return '';
}

add_action( 'wp_head', function () {
	$texto = trim( pya_descripcion_pagina() );
	if ( '' === $texto ) {
		return;
	}
	$imagen = get_theme_file_uri( 'assets/img/portada.jpg' );
	if ( function_exists( 'is_product' ) && is_product() ) {
		$foto = get_the_post_thumbnail_url( get_queried_object_id(), 'large' );
		if ( $foto ) {
			$imagen = $foto;
		}
	}
	echo '<meta name="description" content="' . esc_attr( $texto ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( wp_get_document_title() ) . '">' . "\n";
	echo '<meta property="og:description" content="' . esc_attr( $texto ) . '">' . "\n";
	echo '<meta property="og:image" content="' . esc_url( $imagen ) . '">' . "\n";
}, 2 );

/* ---------- Ficha de producto ---------- */

/** Devuelve los datos del libro (los atributos que no son de variación). */
function pya_datos_libro( $product ) {
	$campos = array( 'Editorial', 'Páginas', 'Encuadernación', 'Edad' );
	$datos  = array();
	foreach ( $product->get_attributes() as $atributo ) {
		if ( ! is_object( $atributo ) || $atributo->get_variation() ) {
			continue;
		}
		if ( in_array( $atributo->get_name(), $campos, true ) ) {
			$datos[ $atributo->get_name() ] = implode( ', ', $atributo->get_options() );
		}
	}
	return $datos;
}

/** Compromisos de la tienda justo debajo del botón de compra. */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$libro  = (bool) get_post_meta( $product->get_id(), '_pya_autor', true );
	$lineas = array(
		$libro ? 'Leído y recomendado por alguien de la librería' : 'Sale de la librería en 24 horas',
		'Envío en 48-72 h, gratis desde ' . PYA_ENVIO_GRATIS . ' €',
		'Si no te convence, tienes 30 días para devolverlo',
	);
	echo '<ul class="pya-confianza">';
	foreach ( $lineas as $linea ) {
		echo '<li><svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 10.5l4 4 8-9"/></svg>' . esc_html( $linea ) . '</li>';
	}
	echo '</ul>';
}, 31 );

/** Datos del libro a la vista, sin tener que abrir una pestaña. */
add_action( 'woocommerce_single_product_summary', function () {
	global $product;
	if ( ! $product ) {
		return;
	}
	$datos = pya_datos_libro( $product );
	if ( ! $datos ) {
		return;
	}
	echo '<div class="pya-origen"><p class="pya-origen__titulo">El libro por fuera</p><dl>';
	foreach ( $datos as $nombre => $valor ) {
		echo '<div><dt>' . esc_html( $nombre ) . '</dt><dd>' . esc_html( $valor ) . '</dd></div>';
	}
	echo '</dl></div>';
}, 33 );

/** Pestañas: fuera la tabla de atributos (ya está en la ficha), dentro regalo y envíos. */
add_filter( 'woocommerce_product_tabs', function ( $pestanas ) {
	global $product;
	unset( $pestanas['additional_information'] );
	$libro = $product && get_post_meta( $product->get_id(), '_pya_autor', true );
	if ( isset( $pestanas['description'] ) ) {
		$pestanas['description']['title'] = $libro ? 'De qué va' : 'Descripción';
	}
	$pestanas['pya_regalo'] = array(
		'title'    => 'Para regalar',
		'priority' => 20,
		'callback' => function () {
			echo '<h2>Para regalar</h2><p>Marca "Envolver para regalo" antes de añadirlo al carrito: lo envolvemos en papel kraft con cordel por ' . esc_html( wc_format_localized_price( number_format( PYA_ENVOLTORIO, 2, '.', '' ) ) ) . ' €.</p><p>Si escribes una dedicatoria (hasta 150 caracteres), la pasamos a mano a una tarjeta que va dentro del paquete.</p>';
		},
	);
	$pestanas['pya_envios'] = array(
		'title'    => 'Envíos y devoluciones',
		'priority' => 30,
		'callback' => function () {
			echo '<h2>Envíos y devoluciones</h2><p>Envío estándar en 48-72 h por 3,50 €, gratis a partir de ' . (int) PYA_ENVIO_GRATIS . ' €. Envío exprés en 24 h por 5,90 €. Enviamos a toda España.</p><p>Tienes 30 días para devolver cualquier libro o artículo de papelería que esté como lo recibiste. Si llega con un golpe o una esquina doblada, te lo cambiamos sin coste.</p>';
		},
	);
	return $pestanas;
}, 20 );

add_filter( 'woocommerce_product_description_heading', function () {
	global $product;
	return ( $product && get_post_meta( $product->get_id(), '_pya_autor', true ) ) ? 'De qué va' : 'Descripción';
} );

add_filter( 'woocommerce_product_related_products_heading', function () {
	return 'También te puede gustar';
} );

/* ---------- Página de tienda ---------- */

add_action( 'woocommerce_archive_description', function () {
	if ( is_shop() && ! is_search() ) {
		echo '<p class="pya-tienda__intro">Libros leídos y elegidos uno a uno, y papelería para escribir a mano. Si es para regalar, te lo envolvemos y escribimos tu dedicatoria.</p>';
	}
}, 5 );

/** Accesos rápidos a las categorías encima de la rejilla. */
add_action( 'woocommerce_before_shop_loop', function () {
	if ( ! is_shop() && ! is_product_category() ) {
		return;
	}
	$actual = is_product_category() ? get_queried_object()->slug : '';
	echo '<nav class="pya-filtros" aria-label="Categorías de la tienda"><ul>';
	echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '"' . ( '' === $actual ? ' aria-current="page"' : '' ) . '>Todo</a></li>';
	foreach ( pya_categorias() as $slug => $cat ) {
		$enlace = get_term_link( $slug, 'product_cat' );
		if ( is_wp_error( $enlace ) ) {
			continue;
		}
		echo '<li><a href="' . esc_url( $enlace ) . '"' . ( $slug === $actual ? ' aria-current="page"' : '' ) . '>' . esc_html( $cat[0] ) . '</a></li>';
	}
	echo '</ul></nav>';
}, 15 );

/* ---------- Portada: el libro del mes ---------- */

add_shortcode( 'pya_libro_mes', function () {
	$p = wc_get_product( pya_id_por_slug( 'la-biblioteca-de-las-cosas-perdidas' ) );
	if ( ! $p ) {
		return '';
	}
	$id      = $p->get_id();
	$autor   = get_post_meta( $id, '_pya_autor', true );
	$inicio  = get_post_meta( $id, '_pya_inicio', true );
	$paginas = (int) get_post_meta( $id, '_pya_paginas', true );
	$datos   = pya_datos_libro( $p );
	ob_start();
	?>
	<section class="pya-edicion" aria-labelledby="pya-edicion-titulo">
		<div class="pya-edicion__in">
			<a class="pya-edicion__foto pya-revela" href="<?php echo esc_url( $p->get_permalink() ); ?>" tabindex="-1" aria-hidden="true">
				<?php echo $p->get_image( 'large', array( 'loading' => 'lazy', 'alt' => '' ) ); // phpcs:ignore ?>
				<span class="pya-edicion__sello">El libro<br>del mes</span>
			</a>
			<div class="pya-edicion__texto">
				<p class="pya-ceja pya-ceja--oscura"><span></span>Lo que estamos recomendando</p>
				<h2 class="pya-titulo" id="pya-edicion-titulo"><?php echo esc_html( $p->get_name() ); ?></h2>
				<?php if ( $autor ) : ?>
					<p class="pya-edicion__autor">de <?php echo esc_html( $autor ); ?></p>
				<?php endif; ?>
				<?php if ( $inicio ) : ?>
					<blockquote class="pya-edicion__cita">"<?php echo esc_html( $inicio ); ?>"</blockquote>
				<?php endif; ?>
				<p class="pya-edicion__lead"><?php echo esc_html( $p->get_short_description() ); ?></p>
				<dl class="pya-edicion__datos">
					<?php if ( isset( $datos['Editorial'] ) ) : ?>
						<div><dt>Editorial</dt><dd><?php echo esc_html( $datos['Editorial'] ); ?></dd></div>
					<?php endif; ?>
					<?php if ( $paginas ) : ?>
						<div><dt>Páginas</dt><dd><?php echo (int) $paginas; ?></dd></div>
						<div><dt>Lectura</dt><dd>Unas <?php echo (int) max( 1, round( $paginas * 1.1 / 60 ) ); ?> horas</dd></div>
					<?php endif; ?>
				</dl>
				<div class="pya-botones">
					<a class="pya-btn" href="<?php echo esc_url( $p->get_permalink() ); ?>">Ver el libro · <?php echo wp_kses_post( wp_strip_all_tags( wc_price( $p->get_price() ) ) ); ?></a>
				</div>
			</div>
		</div>
	</section>
	<?php
	return ob_get_clean();
} );
