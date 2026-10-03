/**
 * Erfan Sanat Enterprise WordPress Theme — Native Admin Panel Controller (Vanilla JS)
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		// 1. Live Color Picker Sync
		const colorSwatches = document.querySelectorAll('.es-color-swatch');
		colorSwatches.forEach(function (swatch) {
			const targetId = swatch.getAttribute('data-target-input');
			const hexInput = targetId ? document.getElementById(targetId) : null;
			const preview = swatch.parentElement ? swatch.parentElement.querySelector('.es-color-live-preview') : null;

			swatch.addEventListener('input', function () {
				if (hexInput) {
					hexInput.value = swatch.value;
				}
				if (preview) {
					preview.style.backgroundColor = swatch.value;
				}
			});

			if (hexInput) {
				hexInput.addEventListener('input', function () {
					if (/^#[0-9A-Fa-f]{6}$/.test(hexInput.value)) {
						swatch.value = hexInput.value;
						if (preview) {
							preview.style.backgroundColor = hexInput.value;
						}
					}
				});
			}
		});

		// 2. Live Range Slider Value Output
		const rangeInputs = document.querySelectorAll('.es-range-input');
		rangeInputs.forEach(function (range) {
			const outputId = range.getAttribute('data-range-output');
			const outputEl = outputId ? document.getElementById(outputId) : null;
			range.addEventListener('input', function () {
				if (outputEl) {
					outputEl.textContent = range.value + 'px';
				}
			});
		});

		// 3. Repeater Add / Remove Rows
		const repeaterContainers = document.querySelectorAll('.es-repeater-container');
		repeaterContainers.forEach(function (container) {
			const rowsWrap = container.querySelector('.es-repeater-rows');
			const template = container.querySelector('.es-repeater-template');
			const addBtn = container.querySelector('.es-repeater-add-row');

			if (addBtn && rowsWrap && template) {
				addBtn.addEventListener('click', function () {
					const nextIndex = rowsWrap.querySelectorAll('.es-repeater-row').length;
					const html = template.innerHTML.replace(/__INDEX__/g, String(nextIndex));
					const tempDiv = document.createElement('div');
					tempDiv.innerHTML = html.trim();
					const newRow = tempDiv.firstElementChild;
					if (newRow) {
						rowsWrap.appendChild(newRow);
					}
				});
			}

			container.addEventListener('click', function (e) {
				const removeBtn = e.target.closest('.es-repeater-remove-row');
				if (removeBtn) {
					const row = removeBtn.closest('.es-repeater-row');
					if (row) {
						row.remove();
					}
				}
			});
		});

		// 4. WordPress Native Media Library Selector
		const mediaButtons = document.querySelectorAll('.es-media-upload-btn, .es-gallery-upload-btn');
		mediaButtons.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				e.preventDefault();
				const targetSelector = btn.getAttribute('data-target');
				const targetInput = targetSelector ? document.querySelector(targetSelector) : null;
				if (!targetInput || typeof wp === 'undefined' || !wp.media) {
					return;
				}

				const isGallery = btn.classList.contains('es-gallery-upload-btn');
				const frame = wp.media({
					title: (window.erfanSanatAdmin && window.erfanSanatAdmin.mediaTitle) || 'انتخاب رسانه',
					button: {
						text: (window.erfanSanatAdmin && window.erfanSanatAdmin.mediaButton) || 'انتخاب',
					},
					multiple: isGallery,
				});

				frame.on('select', function () {
					const selection = frame.state().get('selection');
					if (isGallery) {
						const ids = [];
						selection.each(function (attachment) {
							ids.push(attachment.id);
						});
						targetInput.value = ids.join(',');
					} else {
						const attachment = selection.first().toJSON();
						targetInput.value = attachment.url || '';
					}
				});

				frame.open();
			});
		});

		// 5. Confirmation on Reset Buttons
		const resetButtons = document.querySelectorAll('.es-reset-tab-btn, .es-reset-all-btn');
		resetButtons.forEach(function (btn) {
			btn.addEventListener('click', function (e) {
				const msg = (window.erfanSanatAdmin && window.erfanSanatAdmin.confirmReset)
					? window.erfanSanatAdmin.confirmReset
					: 'آیا از بازنشانی تنظیمات اطمینان دارید؟';
				if (!window.confirm(msg)) {
					e.preventDefault();
				}
			});
		});
	});
})();
