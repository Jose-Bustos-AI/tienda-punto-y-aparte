# Punto y Aparte · tienda WooCommerce de demostración

Librería y papelería de barrio: novela, misterio, ensayo, humor y álbumes infantiles, y cuadernos, plumas y lápices. Cualquier producto se puede pedir envuelto para regalo con dedicatoria, y la portada tiene un recomendador que te dice qué leer según lo que te apetece y en cuántos días lo terminarías.

**Verla publicada:** https://punto-y-aparte.dania360.com/

## Qué hay en este repositorio
Solo el código hecho a medida para esta tienda; WordPress y WooCommerce no se incluyen.

```
tema/punto-y-aparte/      Tema hijo de Twenty Twenty-Five: plantillas de bloques, estilos (theme.json), tipografías y JavaScript
plugin/punto-y-aparte-tienda/    Plugin propio: funciones de la tienda, datos del catálogo y montaje automático
```

## Cómo está hecha
- WordPress con WooCommerce 11, en el hosting de Hostinger, con su propio subdominio y certificado de seguridad
- Tema hijo propio sobre Twenty Twenty-Five: paleta azul tinta, papel y mostaza, tipografías Newsreader y DM Sans servidas desde la propia web, cabecera, pie y portada a medida
- Portada con foto a pantalla completa, titular animado, tarjeta flotante del libro del mes, cinta de frases en movimiento y secciones que aparecen al hacer scroll
- Tienda, carrito, pago y direcciones de la web en español, con la traducción oficial de WooCommerce

## Catálogo y compra
- 16 productos en 6 categorías: novela, misterio y thriller, ensayo y viajes, humor, infantil y papelería
- Ficha de cada libro con autor, editorial, páginas y encuadernación (libros, autores y editoriales inventados para la tienda)
- "Así empieza": las primeras líneas de cada libro en su ficha, con las horas de lectura
- Cuaderno con variaciones de hojas (rayado, cuadrícula y liso) y ofertas con precio tachado
- Fotos de producto y cubiertas creadas para la marca
- Envío estándar a 3,50 €, gratis desde 30 € (entonces el estándar de pago desaparece) y exprés en 24 h a 5,90 €
- Cupón de bienvenida BIENVENIDA10 con un 10 % de descuento
- Envoltorio de regalo por 1,50 € con dedicatoria de hasta 150 caracteres: se ve en el carrito y queda guardada en el pedido
- Venta cruzada en el carrito: con cada libro propone los marcapáginas y el cuaderno
- Pago de prueba que no pide tarjeta ni cobra nada y termina en la página de pedido recibido
- Dos pedidos de prueba completos: libro envuelto con dedicatoria y envío gratis, y desde el móvil con variación, cupón y envío exprés

## Detalles
- Sin plugins de pago: todo lo propio está en un plugin hecho a medida para la tienda
- Recomendador "¿Qué te apetece leer ahora?": seis estados de ánimo con dos libros cada uno y sus primeras líneas, y un control de minutos de lectura al día que calcula en cuántos días terminarías cada libro
- Montaje automático del catálogo, los envíos, el pago y el cupón desde el propio plugin
- Lista para conectar Stripe, Redsys o Bizum cuando sea una tienda real

## Cómo instalarlo
1. WordPress 6.6 o superior con WooCommerce activo.
2. Copia `tema/punto-y-aparte` en `wp-content/themes/` y actívalo (necesita Twenty Twenty-Five instalado).
3. Copia `plugin/punto-y-aparte-tienda` en `wp-content/plugins/` y actívalo.
4. El plugin incluye un montaje por pasos que crea las categorías, los productos, los envíos y las páginas; se desactiva solo al terminar.

Tipografías de Google Fonts con licencia SIL Open Font License, incluidas en `tema/punto-y-aparte/assets/fonts`.

## Sobre esta tienda
Diseño y desarrollo de [Dania360](https://dania360.com). Es una tienda de ejemplo: la marca y los productos son inventados, las fotos se crearon para la marca y el pago es de prueba, no cobra nada. El código se publica para enseñar cómo está hecha; no tiene licencia de uso.

Más tiendas en el portafolio: https://tiendas.dania360.com
