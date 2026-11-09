/**
 * JRDC Modern Theme - Interactive behaviors
 * Hamburger toggle, dark mode persistence, DOI copy, reading progress.
 */
(function () {
	'use strict';

	var toggle = null;
	var nav = null;

	function closeMenu() {
		if (!toggle || !nav) return;
		nav.classList.remove('is-open');
		nav.classList.remove('pkp_site_nav_menu--isOpen');
		toggle.classList.remove('pkp_site_nav_toggle--transform');
		toggle.setAttribute('aria-expanded', 'false');
		toggle.setAttribute('aria-label', 'Buka navigasi');
	}

	function openMenu() {
		if (!toggle || !nav) return;
		nav.classList.add('is-open');
		nav.classList.add('pkp_site_nav_menu--isOpen');
		toggle.classList.add('pkp_site_nav_toggle--transform');
		toggle.setAttribute('aria-expanded', 'true');
		toggle.setAttribute('aria-label', 'Tutup navigasi');
	}

	function initHamburger() {
		toggle = document.querySelector('.jrdc-nav-toggle');
		nav = document.querySelector('#jrdcSiteNav');
		if (!toggle || !nav) return;

		// Sync with OJS parent handler that toggles pkp_site_nav_menu--isOpen
		var mutator = new MutationObserver(function () {
			var open = nav.classList.contains('pkp_site_nav_menu--isOpen') || nav.classList.contains('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		mutator.observe(nav, { attributes: true, attributeFilter: ['class'] });

		document.addEventListener('keydown', function (event) {
			if (event.key === 'Escape') closeMenu();
		});

		document.addEventListener('click', function (event) {
			if (!nav.contains(event.target) && !toggle.contains(event.target)) {
				closeMenu();
			}
		});

		var resizeTimer = null;
		window.addEventListener('resize', function () {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function () {
				if (window.innerWidth > 1199) closeMenu();
			}, 120);
		});
	}

	function initDarkMode() {
		var btn = document.querySelector('.jrdc-theme-toggle');
		if (!btn) return;
		try {
			var saved = localStorage.getItem('jrdc-theme');
			if (saved === 'dark') document.documentElement.classList.add('dark');
		} catch (e) { /* localStorage unavailable */ }
		// The inline onclick already toggles; persist state
		btn.addEventListener('click', function () {
			try {
				var dark = document.documentElement.classList.contains('dark');
				localStorage.setItem('jrdc-theme', dark ? 'dark' : 'light');
			} catch (e) { /* noop */ }
		});
	}

	function initDoiCopy() {
		document.querySelectorAll('.jrdc-doi-copy').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var text = btn.getAttribute('data-doi') || '';
				if (!text) return;
				var done = function () {
					btn.classList.add('copied');
					btn.setAttribute('aria-label', 'DOI disalin');
					setTimeout(function () { btn.classList.remove('copied'); }, 1500);
				};
				if (navigator.clipboard && navigator.clipboard.writeText) {
					navigator.clipboard.writeText(text).then(done, function () { fallbackCopy(text, done); });
				} else {
					fallbackCopy(text, done);
				}
			});
		});
		function fallbackCopy(text, done) {
			var ta = document.createElement('textarea');
			ta.value = text;
			ta.style.position = 'fixed';
			ta.style.opacity = '0';
			document.body.appendChild(ta);
			ta.select();
			try { document.execCommand('copy'); done(); } catch (e) { /* noop */ }
			document.body.removeChild(ta);
		}
	}

	function initAbstractToggle() {
		// Fallback if parent main.js absent
		if (typeof jQuery !== 'undefined') return;
		document.querySelectorAll('.jrdc-button--ghost[data-toggle-target]').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var target = document.getElementById(btn.getAttribute('data-toggle-target'));
				if (!target) return;
				var hidden = target.hasAttribute('hidden');
				if (hidden) target.removeAttribute('hidden'); else target.setAttribute('hidden', '');
				btn.setAttribute('aria-expanded', hidden ? 'true' : 'false');
			});
		});
	}

	function initReadingProgress() {
		var article = document.querySelector('.obj_article_details');
		if (!article) return;
		var bar = document.createElement('div');
		bar.className = 'jrdc-reading-progress';
		bar.setAttribute('aria-hidden', 'true');
		document.body.appendChild(bar);
		function update() {
			var rect = article.getBoundingClientRect();
			var total = Math.max(1, article.offsetHeight - window.innerHeight * 0.3);
			var progress = Math.min(1, Math.max(0, -rect.top / total));
			bar.style.width = (progress * 100) + '%';
			bar.style.opacity = progress > 0.02 ? '1' : '0';
		}
		window.addEventListener('scroll', function () { requestAnimationFrame(update); }, { passive: true });
		window.addEventListener('resize', update);
		update();
	}

	document.addEventListener('DOMContentLoaded', function () {
		initHamburger();
		initDarkMode();
		initDoiCopy();
		initAbstractToggle();
		initReadingProgress();
	});
})();
