<?php
/**
 * Catálogo de la tienda de ejemplo Punto y Aparte.
 * Los libros, autores y editoriales son inventados para esta tienda.
 */
defined( 'ABSPATH' ) || exit;

function pya_categorias() {
	return array(
		'novela'           => array( 'Novela', 'Historias para perderse una tarde entera.' ),
		'misterio'         => array( 'Misterio y thriller', 'Para leer con la luz encendida.' ),
		'ensayo-y-viajes'  => array( 'Ensayo y viajes', 'Libros que te cambian la forma de mirar.' ),
		'humor'            => array( 'Humor', 'Para reírte en el autobús y que te miren raro.' ),
		'infantil'         => array( 'Infantil', 'Álbumes ilustrados para leer juntos.' ),
		'papeleria'        => array( 'Papelería', 'Cuadernos, plumas y lápices para escribir a mano.' ),
	);
}

/**
 * Cada libro lleva: autor, editorial, páginas, encuadernación y sus primeras líneas.
 */
function pya_productos() {
	return array(
		array(
			'slug' => 'la-biblioteca-de-las-cosas-perdidas', 'nombre' => 'La biblioteca de las cosas perdidas', 'tipo' => 'libro', 'cat' => array( 'novela' ), 'img' => 'biblioteca.jpg', 'orden' => 1, 'destacado' => true,
			'precio' => 19.50, 'paginas' => 320, 'autor' => 'Clara Benet', 'editorial' => 'Ediciones Salitre', 'encuadernacion' => 'Rústica con solapas',
			'corta' => 'En una biblioteca de Valencia se guardan todos los objetos que la gente pierde. Una novela luminosa sobre lo que dejamos atrás.',
			'larga' => 'Irene hereda de su abuela un trabajo extraño: cuidar una biblioteca donde, en lugar de libros, se guardan llaves, guantes, cartas y paraguas perdidos. Cada objeto tiene una historia, y alguien que todavía lo busca. Nuestro libro del mes.',
			'inicio' => 'Mi abuela decía que nada se pierde del todo: que las cosas solo cambian de estantería.',
		),
		array(
			'slug' => 'nadie-mira-al-faro', 'nombre' => 'Nadie mira al faro', 'tipo' => 'libro', 'cat' => array( 'misterio' ), 'img' => 'faro.jpg', 'orden' => 2, 'destacado' => true,
			'precio' => 20.50, 'oferta' => 17.90, 'paginas' => 384, 'autor' => 'Marta Quiles', 'editorial' => 'Faro Negro', 'encuadernacion' => 'Rústica',
			'corta' => 'Una noche el faro de Cabo Gris no se enciende y a la mañana siguiente su farero ha desaparecido. Ahora en oferta.',
			'larga' => 'La subinspectora Nuria Llamas vuelve al pueblo donde creció para investigar una desaparición que nadie quiere aclarar. Un thriller psicológico de capítulos cortos que se lee de una sentada.',
			'inicio' => 'La luz llevaba cuarenta años girando sin fallar una sola noche. Por eso nadie miraba al faro.',
		),
		array(
			'slug' => 'marea-baja', 'nombre' => 'Marea baja', 'tipo' => 'libro', 'cat' => array( 'misterio' ), 'img' => 'marea.jpg', 'orden' => 3,
			'precio' => 21.50, 'paginas' => 432, 'autor' => 'Andrés Velasco', 'editorial' => 'Faro Negro', 'encuadernacion' => 'Rústica',
			'corta' => 'Cada marea baja deja algo en la playa de Laredo. Esta vez es un teléfono con mensajes de alguien que murió hace diez años.',
			'larga' => 'Un periodista en horas bajas, una playa del Cantábrico y un caso cerrado que nunca debió cerrarse. Velasco construye una intriga de mareas, secretos de familia y giros que no ves venir.',
			'inicio' => 'El mar devuelve las cosas cuando quiere, no cuando se las pides.',
		),
		array(
			'slug' => 'la-casa-de-los-limoneros', 'nombre' => 'La casa de los limoneros', 'tipo' => 'libro', 'cat' => array( 'novela' ), 'img' => 'limoneros.jpg', 'orden' => 4, 'destacado' => true,
			'precio' => 19.90, 'paginas' => 368, 'autor' => 'Lucía Ferrán', 'editorial' => 'Ediciones Salitre', 'encuadernacion' => 'Rústica con solapas',
			'corta' => 'Tres hermanas vuelven a la casa familiar de Orihuela para venderla. Un verano, un patio con limoneros y todo lo que nunca se dijeron.',
			'larga' => 'Una novela cálida y sin prisa sobre la familia, la memoria y los lugares que nos hacen ser quienes somos. Para leer a la sombra, con un vaso de limonada.',
			'inicio' => 'Aquel verano los limoneros dieron más fruta que nunca, como si supieran que era el último.',
		),
		array(
			'slug' => 'estacion-de-ferrocarril', 'nombre' => 'Estación de ferrocarril', 'tipo' => 'libro', 'cat' => array( 'novela' ), 'img' => 'tren.jpg', 'orden' => 5,
			'precio' => 22.90, 'paginas' => 512, 'autor' => 'Inés Albarracín', 'editorial' => 'Ediciones Salitre', 'encuadernacion' => 'Tapa dura',
			'corta' => 'Cartagena, 1907. La llegada del tren cambia para siempre la vida de una telegrafista y de la ciudad entera.',
			'larga' => 'Novela histórica de gran aliento con el puerto, las minas de La Unión y los cafés modernistas como escenario. Albarracín reconstruye una época con una protagonista inolvidable.',
			'inicio' => 'El primer silbido del tren se oyó en toda la ciudad, y Amparo supo que nada volvería a ser lento.',
		),
		array(
			'slug' => 'cartas-desde-hokkaido', 'nombre' => 'Cartas desde Hokkaido', 'tipo' => 'libro', 'cat' => array( 'ensayo-y-viajes' ), 'img' => 'hokkaido.jpg', 'orden' => 6,
			'precio' => 18.90, 'paginas' => 256, 'autor' => 'Pablo Iriarte', 'editorial' => 'Ediciones Salitre', 'encuadernacion' => 'Rústica',
			'corta' => 'Un invierno entero en el norte de Japón contado en cartas a su madre. Nieve, trenes regionales y sopas calientes.',
			'larga' => 'Crónica de viaje íntima y llena de humor: un profesor de instituto de Murcia se va seis meses a una isla donde nieva cinco meses al año. Para viajar sin moverte del sofá.',
			'inicio' => 'Querida mamá: aquí la nieve no cae, se queda flotando a ver si alguien la invita a entrar.',
		),
		array(
			'slug' => 'lo-que-el-cuerpo-sabe', 'nombre' => 'Lo que el cuerpo sabe', 'tipo' => 'libro', 'cat' => array( 'ensayo-y-viajes' ), 'img' => 'cuerpo.jpg', 'orden' => 7,
			'precio' => 20.90, 'paginas' => 288, 'autor' => 'Elena Sanmartín', 'editorial' => 'Hoja Suelta', 'encuadernacion' => 'Rústica',
			'corta' => 'Una neurocientífica explica, sin tecnicismos, cómo el cuerpo decide antes que nosotros. Divulgación clara y sorprendente.',
			'larga' => 'Por qué tenemos corazonadas, por qué el hambre nos pone de mal humor o por qué recordamos mejor caminando. Un ensayo ameno para entendernos un poco mejor.',
			'inicio' => 'Antes de que pienses que tienes miedo, tu corazón ya lo sabía.',
		),
		array(
			'slug' => 'elogio-del-caracol', 'nombre' => 'Elogio del caracol', 'tipo' => 'libro', 'cat' => array( 'ensayo-y-viajes' ), 'img' => 'caracol.jpg', 'orden' => 8,
			'precio' => 19.90, 'paginas' => 240, 'autor' => 'Tomás Arrieta', 'editorial' => 'Hoja Suelta', 'encuadernacion' => 'Rústica',
			'corta' => 'Un ensayo breve y muy subrayable sobre el arte de ir despacio en un mundo que corre.',
			'larga' => 'Arrieta mezcla filosofía, anécdotas y pequeños experimentos personales para defender la lentitud: comer, leer, caminar y pensar sin prisa.',
			'inicio' => 'El caracol lleva la casa a cuestas y, aun así, nunca llega tarde a ninguna parte.',
		),
		array(
			'slug' => 'manual-para-perder-el-tiempo', 'nombre' => 'Manual para perder el tiempo', 'tipo' => 'libro', 'cat' => array( 'humor' ), 'img' => 'perder-tiempo.jpg', 'orden' => 9,
			'precio' => 17.90, 'paginas' => 224, 'autor' => 'Quique Lorente', 'editorial' => 'Hoja Suelta', 'encuadernacion' => 'Rústica',
			'corta' => 'Instrucciones detalladas para no hacer nada y hacerlo bien. El libro de humor más inútil (y divertido) del año.',
			'larga' => 'Capítulos cortos sobre la siesta, las sobremesas eternas o el arte de mirar por la ventana. Para leer a ratos y reírte en voz alta.',
			'inicio' => 'Si estás leyendo esto en vez de trabajar, enhorabuena: ya has empezado.',
		),
		array(
			'slug' => 'las-vacas-de-mi-tia-paca', 'nombre' => 'Las vacas de mi tía Paca', 'tipo' => 'libro', 'cat' => array( 'humor' ), 'img' => 'vacas.jpg', 'orden' => 10,
			'precio' => 16.90, 'oferta' => 14.90, 'paginas' => 192, 'autor' => 'Rocío Segura', 'editorial' => 'Hoja Suelta', 'encuadernacion' => 'Rústica',
			'corta' => 'Un verano en el pueblo, una tía con mucho carácter y tres vacas que se creen turistas. Ahora en oferta.',
			'larga' => 'Comedia rural disparatada sobre una sobrina urbanita que tiene que cuidar la granja de su tía durante las fiestas del pueblo. Ideal para regalar.',
			'inicio' => 'Mi tía Paca tenía tres vacas, dos maridos y ninguna paciencia.',
		),
		array(
			'slug' => 'el-oso-que-no-queria-dormir', 'nombre' => 'El oso que no quería dormir', 'tipo' => 'libro', 'cat' => array( 'infantil' ), 'img' => 'oso.jpg', 'orden' => 11, 'destacado' => true,
			'precio' => 15.90, 'paginas' => 40, 'autor' => 'Ana Belmonte', 'editorial' => 'Pequeño Oso', 'encuadernacion' => 'Tapa dura', 'edad' => 'De 2 a 5 años',
			'corta' => 'Álbum ilustrado en acuarela para la hora de dormir. Bruno no quiere irse a la cama… hasta que la luna le cuenta un secreto.',
			'larga' => 'Un cuento tierno y con mucho ritmo, perfecto para leer en voz alta antes de dormir. Tapa dura y páginas gruesas que aguantan manitas.',
			'inicio' => 'Bruno tenía sueño en los ojos, pero no en las patas.',
		),
		array(
			'slug' => 'el-dragon-de-los-botones', 'nombre' => 'El dragón de los botones', 'tipo' => 'libro', 'cat' => array( 'infantil' ), 'img' => 'dragon.jpg', 'orden' => 12,
			'precio' => 16.50, 'paginas' => 48, 'autor' => 'Diego Moya', 'editorial' => 'Pequeño Oso', 'encuadernacion' => 'Tapa dura', 'edad' => 'De 4 a 7 años',
			'corta' => 'Un dragón que no echa fuego, sino que colecciona botones. Un álbum alegre sobre ser diferente.',
			'larga' => 'Ilustraciones llenas de detalles para buscar y contar botones en cada página. Un libro para leer juntos y volver a leer muchas veces.',
			'inicio' => 'Todos los dragones guardan tesoros. Fito guardaba botones.',
		),
		array(
			'slug' => 'cuaderno-tela-a5', 'nombre' => 'Cuaderno de tela A5', 'tipo' => 'cuaderno', 'cat' => array( 'papeleria' ), 'img' => 'cuaderno.jpg', 'orden' => 13, 'destacado' => true,
			'precio' => 14.90, 'peso' => 0.35,
			'corta' => 'Tapa de tela azul tinta, goma elástica y 192 páginas de papel de 100 g que no transparenta. Elige rayado, cuadrícula o liso.',
			'larga' => 'Cosido con hilo para que se abra del todo y quede plano sobre la mesa. Incluye cinta marcapáginas y bolsillo interior.',
		),
		array(
			'slug' => 'pluma-estilografica-verde', 'nombre' => 'Pluma estilográfica verde botella', 'tipo' => 'simple', 'cat' => array( 'papeleria' ), 'img' => 'pluma.jpg', 'orden' => 14,
			'precio' => 39.90, 'peso' => 0.2,
			'corta' => 'Plumín de acero de trazo medio, cuerpo de resina verde y detalles dorados. Incluye convertidor y tinta azul.',
			'larga' => 'Escribe suave desde el primer día. Funciona con cartuchos estándar o con tinta de tintero gracias al convertidor incluido. Se entrega en estuche.',
		),
		array(
			'slug' => 'lapices-de-colores-24', 'nombre' => 'Lata de 24 lápices de colores', 'tipo' => 'simple', 'cat' => array( 'papeleria' ), 'img' => 'lapices.jpg', 'orden' => 15,
			'precio' => 18.50, 'peso' => 0.4,
			'corta' => 'Mina blanda y pigmentada en 24 colores, en lata metálica. Para ilustrar, colorear o subrayar con estilo.',
			'larga' => 'Lápices de madera de cedro con mina de 3,8 mm que no se rompe al sacar punta. Colores que se mezclan bien entre sí.',
		),
		array(
			'slug' => 'marcapaginas-laton', 'nombre' => 'Marcapáginas de latón, set de 3', 'tipo' => 'simple', 'cat' => array( 'papeleria' ), 'img' => 'marcapaginas.jpg', 'orden' => 16,
			'precio' => 12.90, 'peso' => 0.05,
			'corta' => 'Tres marcapáginas de latón dorado: punto final, hoja de olivo y flecha. El regalo perfecto para acompañar un libro.',
			'larga' => 'Latón macizo pulido a mano, tan fino que no marca las páginas. Se entregan en sobre de papel kraft.',
		),
	);
}

/** Tipos de hoja del cuaderno. */
const PYA_HOJAS = array( 'Rayado', 'Cuadrícula', 'Liso' );

/**
 * Recomendador "¿Qué te apetece leer?": cada estado de ánimo con su frase y dos libros.
 */
function pya_animos() {
	return array(
		'enganche' => array( 'nombre' => 'Algo que me enganche', 'frase' => 'Capítulos cortos, giros y esa sensación de "solo uno más" a las dos de la mañana.', 'libros' => array( 'nadie-mira-al-faro', 'marea-baja' ) ),
		'bonito'   => array( 'nombre' => 'Algo bonito y tranquilo', 'frase' => 'Historias que abrazan: para leer sin prisa, con una manta y un té.', 'libros' => array( 'la-biblioteca-de-las-cosas-perdidas', 'la-casa-de-los-limoneros' ) ),
		'reir'     => array( 'nombre' => 'Reírme un rato', 'frase' => 'Para reírte en voz alta en el autobús y que te miren raro.', 'libros' => array( 'manual-para-perder-el-tiempo', 'las-vacas-de-mi-tia-paca' ) ),
		'pensar'   => array( 'nombre' => 'Aprender algo', 'frase' => 'Ensayos claros que te dejan pensando días después de cerrarlos.', 'libros' => array( 'lo-que-el-cuerpo-sabe', 'elogio-del-caracol' ) ),
		'viajar'   => array( 'nombre' => 'Viajar sin moverme', 'frase' => 'Otro país, otra época: billete de ida sin salir del sofá.', 'libros' => array( 'cartas-desde-hokkaido', 'estacion-de-ferrocarril' ) ),
		'peques'   => array( 'nombre' => 'Leer con los peques', 'frase' => 'Álbumes ilustrados para leer juntos antes de dormir (y repetir mañana).', 'libros' => array( 'el-oso-que-no-queria-dormir', 'el-dragon-de-los-botones' ) ),
	);
}
