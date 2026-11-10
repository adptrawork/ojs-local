/**
 * JRDC Modern Theme - interactive behaviors
 * Theme persistence, registration toggles, abstract toggle, DOI copy,
 * reading progress. Bootstrap 5 bundle owns navbar/offcanvas/dropdowns.
 * Progressive enhancement: every feature degrades to plain links/content.
 */
(function () {
	'use strict';

	function setTheme(dark) {
		var root = document.documentElement;
		root.classList.toggle('dark', dark);
		root.setAttribute('data-bs-theme', dark ? 'dark' : 'light');
		try {
			localStorage.setItem('jrdc-theme', dark ? 'dark' : 'light');
		} catch (e) { /* localStorage unavailable */ }
		document.querySelectorAll('[data-jrdc-theme-toggle]').forEach(function (btn) {
			btn.setAttribute('aria-pressed', dark ? 'true' : 'false');
			btn.setAttribute('aria-label', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
			btn.setAttribute('title', dark ? 'Aktifkan mode terang' : 'Aktifkan mode gelap');
		});
	}

	function initThemeToggle() {
		var btn = document.querySelector('[data-jrdc-theme-toggle]');
		if (!btn) return;
		var dark = document.documentElement.classList.contains('dark');
		btn.setAttribute('aria-pressed', dark ? 'true' : 'false');
		btn.addEventListener('click', function () {
			setTheme(!document.documentElement.classList.contains('dark'));
		});
	}

	// Same behavior as the parent main.js that this theme no longer loads.
	function initRegistrationToggles() {
		var optinGroup = document.getElementById('contextOptinGroup');
		if (optinGroup) {
			optinGroup.querySelectorAll('.roles input[type="checkbox"]').forEach(function (checkbox) {
				checkbox.addEventListener('change', function () {
					var roles = checkbox.closest('.roles');
					if (!roles) return;
					var privacy = roles.parentElement.querySelector('.context_privacy');
					if (!privacy) return;
					privacy.classList.toggle('context_privacy_visible', !!roles.querySelector('input:checked'));
				});
			});
		}

		var reviewerGroup = document.getElementById('reviewerOptinGroup');
		var interests = document.getElementById('reviewerInterests');
		if (!reviewerGroup || !interests) return;

		function toggleInterests() {
			interests.classList.toggle('is_visible', !!reviewerGroup.querySelector('input:checked'));
		}
		reviewerGroup.addEventListener('change', toggleInterests);
		toggleInterests();
	}

	function initAbstractToggle() {
		document.querySelectorAll('.abstract_toggle[data-toggle-target]').forEach(function (btn) {
			btn.addEventListener('click', function (event) {
				event.preventDefault();
				var target = document.getElementById(btn.getAttribute('data-toggle-target'));
				if (!target) return;
				var hidden = target.hasAttribute('hidden');
				if (hidden) target.removeAttribute('hidden'); else target.setAttribute('hidden', '');
				btn.setAttribute('aria-expanded', hidden ? 'true' : 'false');
			});
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
					window.setTimeout(function () { btn.classList.remove('copied'); }, 1500);
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

		window.addEventListener('scroll', function () { window.requestAnimationFrame(update); }, { passive: true });
		window.addEventListener('resize', update);
		update();
	}

	document.addEventListener('DOMContentLoaded', function () {
		initThemeToggle();
		initRegistrationToggles();
		initAbstractToggle();
		initDoiCopy();
		initReadingProgress();

		// Keep nav toggle aria-expanded synchronized with Bootstrap offcanvas
		var offcanvasEl = document.getElementById('jrdcSiteNav');
		var toggleBtn = document.querySelector('.jrdc-nav-toggle');
		if (offcanvasEl && toggleBtn) {
			offcanvasEl.addEventListener('show.bs.offcanvas', function () {
				toggleBtn.setAttribute('aria-expanded', 'true');
			});
			offcanvasEl.addEventListener('hide.bs.offcanvas', function () {
				toggleBtn.setAttribute('aria-expanded', 'false');
			});
		}
	});
})();
