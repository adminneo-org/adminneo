'use strict';

(() => {
	/**
	 * Unchecks the 'all' checkbox.
	 *
	 * @param {MouseEvent} event
	 *
	 * @this {HTMLTableElement}
	 */
	window.dumpClick = function(event) {
		let el = event.target.closest('label');
		if (!el) return;

		el = qs('input', el);
		const match = /(.+)\[]$/.exec(el.name);
		if (match) {
			checkboxClick.call(el, event);
			formUncheck('check-' + match[1]);
		}
	};
})();
