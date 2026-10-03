/**
 * Erfan Sanat Isfahan Enterprise Theme - Pure Vanilla JS Frontend Controller
 *
 * Zero jQuery or external framework dependencies.
 * Handles:
 * 1. Mobile off-canvas navigation drawer + Escape key accessibility
 * 2. Header search modal/drawer toggle + close button
 * 3. Homepage Interactive 5-Service Showcase (`[data-es-services="true"]` & `[data-es-service-tabs]`)
 * 4. Single Product Technical Specs & Identity Tabs (`[data-es-specs-tabs]`)
 * 5. Single Product Quantity Stepper (`[data-qty-step]`)
 * 6. Single Product Gallery Thumbnail Switcher
 *
 * @package ErfanSanat
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		initMobileDrawer();
		initSearchModal();
		initInteractiveServices();
		initProductSpecsTabs();
		initQuantitySteppers();
		initProductGalleryThumbs();
	});

	/**
	 * 1. Mobile Off-Canvas Navigation Drawer (`#es-mobile-drawer`)
	 */
	function initMobileDrawer() {
		var openBtn = document.querySelector('.es-mobile-menu-toggle, [data-es-mobile-toggle]');
		var drawer = document.getElementById('es-mobile-drawer');
		if (!openBtn || !drawer) {
			return;
		}

		var closeTriggers = drawer.querySelectorAll('.es-mobile-drawer-close, [data-close-drawer="true"], [data-es-mobile-close]');

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
			var isOpen = !drawer.hasAttribute('hidden');
			if (isOpen) {
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
	 * 2. Header Search Modal / Drawer (`#es-search-modal`)
	 */
	function initSearchModal() {
		var toggleBtn = document.querySelector('.es-search-toggle, [data-es-search-toggle]');
		var modal = document.getElementById('es-search-modal') || document.getElementById('es-search-drawer');
		if (!toggleBtn || !modal) {
			return;
		}

		var closeBtns = modal.querySelectorAll('.es-search-close, [data-es-search-close]');

		function openSearch() {
			modal.removeAttribute('hidden');
			modal.setAttribute('aria-hidden', 'false');
			toggleBtn.setAttribute('aria-expanded', 'true');
			var input = modal.querySelector('input[type="search"]');
			if (input) {
				input.focus();
			}
		}

		function closeSearch() {
			modal.setAttribute('hidden', '');
			modal.setAttribute('aria-hidden', 'true');
			toggleBtn.setAttribute('aria-expanded', 'false');
			toggleBtn.focus();
		}

		toggleBtn.addEventListener('click', function () {
			if (modal.hasAttribute('hidden')) {
				openSearch();
			} else {
				closeSearch();
			}
		});

		closeBtns.forEach(function (btn) {
			btn.addEventListener('click', closeSearch);
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !modal.hasAttribute('hidden')) {
				closeSearch();
			}
		});
	}

	/**
	 * 3. Homepage Interactive 5-Item Services Showcase (`template-parts/home/services-interactive.php`)
	 */
	function initInteractiveServices() {
		var container = document.querySelector('[data-es-services="true"], [data-es-service-tabs]');
		if (!container) {
			return;
		}

		var tabs = container.querySelectorAll('.es-service-tab-btn');
		var panels = container.querySelectorAll('.es-service-preview-panel, [data-service-panel]');
		var counterBadge = document.getElementById('es-service-counter');

		tabs.forEach(function (tab, idx) {
			tab.addEventListener('click', function () {
				var targetIdx = tab.getAttribute('data-service-index') || tab.getAttribute('data-service-tab') || String(idx);
				var numText = tab.getAttribute('data-service-num');

				tabs.forEach(function (t, tIdx) {
					var tKey = t.getAttribute('data-service-index') || t.getAttribute('data-service-tab') || String(tIdx);
					var active = tKey === targetIdx;
					t.classList.toggle('is-active', active);
					t.setAttribute('aria-selected', active ? 'true' : 'false');
				});

				panels.forEach(function (p, pIdx) {
					var pKey = p.getAttribute('data-service-panel') || String(pIdx);
					var match = pKey === targetIdx || p.id === 'es-srv-panel-' + targetIdx;
					p.classList.toggle('is-active', match);
					if (match) {
						p.removeAttribute('hidden');
					} else {
						p.setAttribute('hidden', '');
					}
				});

				if (counterBadge && numText) {
					counterBadge.textContent = numText;
				}
			});
		});
	}

	/**
	 * 4. Single Product Technical Specs & Identity Tabs (`[data-es-specs-tabs]`)
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
	 * 5. Single Product Quantity Stepper (`[data-qty-step]`)
	 */
	function initQuantitySteppers() {
		var stepBtns = document.querySelectorAll('.es-qty-btn[data-qty-step]');
		stepBtns.forEach(function (btn) {
			btn.addEventListener('click', function () {
				var step = parseInt(btn.getAttribute('data-qty-step') || '1', 10);
				var control = btn.closest('.es-qty-control');
				if (!control) {
					return;
				}
				var input = control.querySelector('.es-qty-input');
				if (!input) {
					return;
				}
				var current = parseInt(input.value || '1', 10);
				var min = parseInt(input.getAttribute('min') || '1', 10);
				var nextVal = Math.max(min, current + step);
				input.value = String(nextVal);
			});
		});
	}

	/**
	 * 6. Single Product Gallery Thumbnail Switcher
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
