/**
 * Erfan Sanat Isfahan Enterprise Theme - Pure Vanilla JS Frontend Controller
 *
 * Zero jQuery or external framework dependencies.
 * Handles:
 * 1. Mobile off-canvas navigation drawer + Escape key accessibility
 * 2. Header search drawer toggle
 * 3. Homepage Interactive 5-Service Tabs (`[data-es-service-tabs]`)
 * 4. Single Product Technical Specs Tabs (`[data-es-specs-tabs]`)
 * 5. Single Product Thumbnail Image Switcher
 *
 * @package ErfanSanat
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		initMobileDrawer();
		initSearchDrawer();
		initInteractiveServices();
		initProductSpecsTabs();
		initProductGalleryThumbs();
	});

	/**
	 * 1. Mobile Off-Canvas Navigation Drawer
	 */
	function initMobileDrawer() {
		var openBtn = document.querySelector('[data-es-mobile-toggle]');
		var drawer = document.getElementById('es-mobile-drawer');
		if (!openBtn || !drawer) {
			return;
		}

		var closeTriggers = drawer.querySelectorAll('[data-es-mobile-close]');

		function openDrawer() {
			drawer.removeAttribute('hidden');
			drawer.setAttribute('aria-hidden', 'false');
			openBtn.setAttribute('aria-expanded', 'true');
			document.body.style.overflow = 'hidden';
		}

		function closeDrawer() {
			drawer.setAttribute('hidden', '');
			drawer.setAttribute('aria-hidden', 'true');
			openBtn.setAttribute('aria-expanded', 'false');
			document.body.style.overflow = '';
			openBtn.focus();
		}

		openBtn.addEventListener('click', function () {
			var expanded = openBtn.getAttribute('aria-expanded') === 'true';
			if (expanded) {
				closeDrawer();
			} else {
				openDrawer();
			}
		});

		closeTriggers.forEach(function (el) {
			el.addEventListener('click', closeDrawer);
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !drawer.hasAttribute('hidden')) {
				closeDrawer();
			}
		});
	}

	/**
	 * 2. Header Search Drawer Toggle
	 */
	function initSearchDrawer() {
		var toggleBtn = document.querySelector('[data-es-search-toggle]');
		var drawer = document.getElementById('es-search-drawer');
		if (!toggleBtn || !drawer) {
			return;
		}

		toggleBtn.addEventListener('click', function () {
			var isHidden = drawer.hasAttribute('hidden');
			if (isHidden) {
				drawer.removeAttribute('hidden');
				toggleBtn.setAttribute('aria-expanded', 'true');
				var input = drawer.querySelector('input[type="search"]');
				if (input) {
					input.focus();
				}
			} else {
				drawer.setAttribute('hidden', '');
				toggleBtn.setAttribute('aria-expanded', 'false');
			}
		});
	}

	/**
	 * 3. Homepage Interactive 5-Item Services Showcase
	 */
	function initInteractiveServices() {
		var container = document.querySelector('[data-es-service-tabs]');
		if (!container) {
			return;
		}

		var tabs = container.querySelectorAll('[data-service-tab]');
		var panels = container.querySelectorAll('[data-service-panel]');

		tabs.forEach(function (tab) {
			tab.addEventListener('click', function () {
				var targetIdx = tab.getAttribute('data-service-tab');

				tabs.forEach(function (t) {
					var active = t.getAttribute('data-service-tab') === targetIdx;
					t.classList.toggle('is-active', active);
					t.setAttribute('aria-selected', active ? 'true' : 'false');
				});

				panels.forEach(function (p) {
					var match = p.getAttribute('data-service-panel') === targetIdx;
					p.classList.toggle('is-active', match);
					if (match) {
						p.removeAttribute('hidden');
					} else {
						p.setAttribute('hidden', '');
					}
				});
			});
		});
	}

	/**
	 * 4. Single Product Technical Specs Tabs
	 */
	function initProductSpecsTabs() {
		var wrapper = document.querySelector('[data-es-specs-tabs]');
		if (!wrapper) {
			return;
		}

		var buttons = wrapper.querySelectorAll('[data-spec-tab]');
		var panels = wrapper.querySelectorAll('[data-spec-panel]');

		buttons.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var targetKey = btn.getAttribute('data-spec-tab');

				buttons.forEach(function (b) {
					var active = b.getAttribute('data-spec-tab') === targetKey;
					b.classList.toggle('is-active', active);
					b.setAttribute('aria-selected', active ? 'true' : 'false');
				});

				panels.forEach(function (panel) {
					var match = panel.getAttribute('data-spec-panel') === targetKey;
					panel.classList.toggle('is-active', match);
					if (match) {
						panel.removeAttribute('hidden');
					} else {
						panel.setAttribute('hidden', '');
					}
				});
			});
		});
	}

	/**
	 * 5. Single Product Gallery Thumbnail Switcher
	 */
	function initProductGalleryThumbs() {
		var mainImg = document.getElementById('es-main-product-img');
		var thumbs = document.querySelectorAll('.es-product-thumb[data-full-src]');
		if (!mainImg || !thumbs.length) {
			return;
		}

		thumbs.forEach(function (thumb) {
			thumb.addEventListener('click', function () {
				var src = thumb.getAttribute('data-full-src');
				if (src) {
					mainImg.setAttribute('src', src);
					thumbs.forEach(function (t) {
						t.classList.remove('is-active');
					});
					thumb.classList.add('is-active');
				}
			});
		});
	}
})();
