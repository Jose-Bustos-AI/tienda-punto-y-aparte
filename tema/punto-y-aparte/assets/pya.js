/* Punto y Aparte: animaciones suaves de la portada. */
(function () {
	var reducir = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	var elementos = document.querySelectorAll('.pya-revela, .woocommerce ul.products li.product');
	if (reducir || !('IntersectionObserver' in window)) {
		elementos.forEach(function (el) { el.classList.add('visto'); });
	} else {
		var obs = new IntersectionObserver(function (entradas) {
			entradas.forEach(function (e) {
				if (e.isIntersecting) { e.target.classList.add('visto'); obs.unobserve(e.target); }
			});
		}, { rootMargin: '0px 0px -8% 0px' });
		elementos.forEach(function (el, i) {
			if (el.matches('li.product')) { el.classList.add('pya-revela'); el.style.transitionDelay = (i % 4) * 80 + 'ms'; }
			obs.observe(el);
		});
	}
	// Cifras de la portada que suben al aparecer.
	if (!reducir) {
		document.querySelectorAll('[data-contar]').forEach(function (b) {
			var fin = parseInt(b.getAttribute('data-contar'), 10), t0 = null;
			b.textContent = '0';
			function paso(t) {
				if (!t0) t0 = t;
				var p = Math.min((t - t0) / 1200, 1);
				b.textContent = Math.round(fin * (1 - Math.pow(1 - p, 3)));
				if (p < 1) requestAnimationFrame(paso);
			}
			setTimeout(function () { requestAnimationFrame(paso); }, 700);
		});
	}
})();
