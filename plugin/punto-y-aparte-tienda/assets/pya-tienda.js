/* Punto y Aparte Tienda: recomendador de lecturas y envoltorio de regalo. */
(function () {
	// Recomendador: pestañas con teclado y días de lectura según los minutos al día.
	document.querySelectorAll('.pya-lee').forEach(function (bloque) {
		var tabs = Array.prototype.slice.call(bloque.querySelectorAll('[role=tab]'));
		function elegir(tab, foco) {
			tabs.forEach(function (t) {
				var activo = t === tab;
				t.setAttribute('aria-selected', activo ? 'true' : 'false');
				t.tabIndex = activo ? 0 : -1;
				var panel = document.getElementById(t.getAttribute('aria-controls'));
				if (panel) { panel.hidden = !activo; if (activo) { panel.classList.remove('entra'); void panel.offsetWidth; panel.classList.add('entra'); } }
			});
			if (foco) tab.focus();
		}
		tabs.forEach(function (tab, i) {
			tab.addEventListener('click', function () { elegir(tab); });
			tab.addEventListener('keydown', function (e) {
				var n = null;
				if (e.key === 'ArrowRight' || e.key === 'ArrowDown') n = tabs[(i + 1) % tabs.length];
				if (e.key === 'ArrowLeft' || e.key === 'ArrowUp') n = tabs[(i - 1 + tabs.length) % tabs.length];
				if (e.key === 'Home') n = tabs[0];
				if (e.key === 'End') n = tabs[tabs.length - 1];
				if (n) { e.preventDefault(); elegir(n, true); }
			});
		});

		var rango = bloque.querySelector('#pya-minutos');
		var salida = bloque.querySelector('#pya-minutos-txt');
		function dias() {
			var min = parseInt(rango.value, 10);
			salida.textContent = min + ' minutos';
			rango.style.setProperty('--p', ((min - 10) / 80 * 100) + '%');
			bloque.querySelectorAll('[data-paginas]').forEach(function (p) {
				var paginas = parseInt(p.getAttribute('data-paginas'), 10);
				if (paginas < 80) { p.innerHTML = '<b>Se lee en una noche</b> antes de dormir'; return; }
				// Unas 0,9 páginas por minuto de lectura tranquila.
				var d = Math.max(1, Math.ceil(paginas / (min * 0.9)));
				var semanas = d >= 14 ? ' (unas ' + Math.round(d / 7) + ' semanas)' : '';
				p.innerHTML = 'Lo terminas en <b>' + d + (d === 1 ? ' día' : ' días') + '</b>' + semanas;
			});
		}
		if (rango) { rango.addEventListener('input', dias); dias(); }
	});

	// Envoltorio de regalo: muestra la dedicatoria y cuenta los caracteres.
	document.querySelectorAll('.pya-regalo').forEach(function (r) {
		var check = r.querySelector('input[type=checkbox]');
		var dedi = r.querySelector('.pya-regalo__dedi');
		var texto = r.querySelector('textarea');
		var quedan = r.querySelector('[data-quedan]');
		check.addEventListener('change', function () {
			dedi.hidden = !check.checked;
			r.classList.toggle('activo', check.checked);
			if (check.checked) texto.focus();
		});
		texto.addEventListener('input', function () { quedan.textContent = 150 - texto.value.length; });
	});

	function euros(n) { return n.toFixed(2).replace('.', ',') + ' €'; }
	function avisar(el) {
		if (window.jQuery) window.jQuery(el).trigger('change');
		else el.dispatchEvent(new Event('change', { bubbles: true }));
	}

	// Ficha del cuaderno: el desplegable de hojas pasa a ser botones.
	var form = document.querySelector('form.variations_form');
	if (form) {
		var variaciones = [];
		try { variaciones = JSON.parse(form.getAttribute('data-product_variations')) || []; } catch (e) { variaciones = []; }
		var grupos = [];
		form.querySelectorAll('table.variations select').forEach(function (sel) {
			var etiqueta = form.querySelector('label[for="' + sel.id + '"]');
			var grupo = document.createElement('div');
			grupo.className = 'pya-pildoras';
			grupo.setAttribute('role', 'group');
			if (etiqueta) { etiqueta.id = etiqueta.id || 'pya-et-' + sel.id; grupo.setAttribute('aria-labelledby', etiqueta.id); }
			Array.prototype.forEach.call(sel.options, function (op) {
				if (!op.value) return;
				var b = document.createElement('button');
				b.type = 'button';
				b.setAttribute('data-valor', op.value);
				b.textContent = op.textContent;
				if (sel.name === 'attribute_hojas') {
					var v = variaciones.filter(function (x) { return x.attributes && x.attributes.attribute_hojas === op.value; })[0];
					if (v) { var s = document.createElement('small'); s.textContent = euros(v.display_price); b.appendChild(s); }
				}
				b.addEventListener('click', function () { sel.value = op.value; avisar(sel); });
				grupo.appendChild(b);
			});
			sel.parentNode.insertBefore(grupo, sel);
			sel.classList.add('pya-oculto');
			sel.setAttribute('tabindex', '-1');
			grupos.push({ sel: sel, grupo: grupo });
		});
		// Si todas las opciones cuestan lo mismo, el precio en cada botón sobra.
		grupos.forEach(function (g) {
			var precios = g.grupo.querySelectorAll('small'), vistos = {};
			precios.forEach(function (p) { vistos[p.textContent] = 1; });
			if (precios.length > 1 && Object.keys(vistos).length === 1) precios.forEach(function (p) { p.parentNode.removeChild(p); });
		});
		var pintar = function () {
			grupos.forEach(function (g) {
				g.grupo.querySelectorAll('button').forEach(function (b) {
					var valor = b.getAttribute('data-valor'), existe = false;
					Array.prototype.forEach.call(g.sel.options, function (op) { if (op.value === valor && !op.disabled) existe = true; });
					b.disabled = !existe;
					b.setAttribute('aria-pressed', g.sel.value === valor ? 'true' : 'false');
				});
			});
		};
		if (grupos.length) {
			form.classList.add('pya-con-pildoras');
			form.addEventListener('change', pintar);
			if (window.jQuery) window.jQuery(form).on('change woocommerce_update_variation_values reset_data found_variation', function () { setTimeout(pintar, 0); });
			pintar();
		}
	}

	// Cantidad con botones de menos y más.
	document.querySelectorAll('form.cart .quantity').forEach(function (caja) {
		var campo = caja.querySelector('input.qty');
		if (!campo || campo.type === 'hidden' || caja.querySelector('.pya-cant')) return;
		caja.classList.add('pya-cantidad');
		[['−', -1, 'Quitar una unidad'], ['+', 1, 'Añadir una unidad']].forEach(function (d) {
			var b = document.createElement('button');
			b.type = 'button';
			b.className = 'pya-cant';
			b.textContent = d[0];
			b.setAttribute('aria-label', d[2]);
			b.addEventListener('click', function () {
				var paso = parseFloat(campo.step) || 1, min = parseFloat(campo.min) || 1, max = parseFloat(campo.max) || Infinity;
				var n = (parseFloat(campo.value) || 0) + d[1] * paso;
				campo.value = Math.max(min, Math.min(max, n));
				avisar(campo);
			});
			if (d[1] < 0) caja.insertBefore(b, caja.firstChild); else caja.appendChild(b);
		});
	});

	// Carrito: cuánto falta para el envío gratis.
	var carrito = document.querySelector('.wp-block-woocommerce-cart');
	if (carrito && window.PYA && PYA.envioGratis) {
		var barra = document.createElement('div');
		barra.className = 'pya-envio';
		barra.hidden = true;
		barra.innerHTML = '<p class="pya-envio__texto" aria-live="polite"></p><div class="pya-envio__pista" aria-hidden="true"><span></span></div>';
		carrito.parentNode.insertBefore(barra, carrito);
		var texto = barra.querySelector('.pya-envio__texto'), relleno = barra.querySelector('.pya-envio__pista span');
		var ultimo = null;
		var actualizar = function () {
			var tienda = window.wp && wp.data && wp.data.select('wc/store/cart');
			if (!tienda) return;
			var datos = tienda.getCartData(), t = datos && datos.totals;
			if (!t || !datos.itemsCount) { barra.hidden = true; ultimo = null; return; }
			var div = Math.pow(10, t.currency_minor_unit || 2);
			var total = (parseInt(t.total_items, 10) - parseInt(t.total_discount || 0, 10)) / div;
			if (total === ultimo) return;
			ultimo = total;
			var falta = PYA.envioGratis - total;
			barra.hidden = false;
			barra.classList.toggle('pya-envio--hecho', falta <= 0);
			texto.textContent = falta > 0 ? 'Te faltan ' + euros(falta) + ' para el envío gratis.' : 'Ya tienes el envío estándar gratis.';
			relleno.style.width = Math.max(4, Math.min(100, (total / PYA.envioGratis) * 100)) + '%';
		};
		var enganchar = function (intentos) {
			if (window.wp && wp.data && wp.data.select('wc/store/cart')) { wp.data.subscribe(actualizar); actualizar(); }
			else if (intentos > 0) setTimeout(function () { enganchar(intentos - 1); }, 400);
		};
		enganchar(25);
	}
})();
