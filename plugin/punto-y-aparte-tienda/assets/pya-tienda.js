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
})();
