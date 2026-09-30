'use strict';

(() => {
	/**
	 * Disables the structure and data options if the selected export format does not support them.
	 *
	 * @param {string[]} structureFormats Formats supporting the export of database and table structure.
	 * @param {string[]} dataFormats Formats supporting the export of table data.
	 */
	window.initDumpFormats = function(structureFormats, dataFormats) {
		const form = gid('dump-form');
		const getRows = (labelIds) => labelIds
			.map((id) => gid(id))
			.filter((label) => label)
			.map((label) => label.closest('tr'));

		const structureRows = getRows(['label-db', 'label-tables']);
		const dataRows = getRows(['label-data']);

		const update = () => {
			const format = form['format'].value;

			disableRows(structureRows, structureFormats.indexOf(format) === -1);
			disableRows(dataRows, dataFormats.indexOf(format) === -1);
		};

		for (const radio of qsa('input[name="format"]', form)) {
			radio.addEventListener('change', update);
		}

		update();
	};

	/**
	 * Disables or enables all form controls in the given table rows, including labels of checkboxes.
	 *
	 * @param {HTMLTableRowElement[]} rows
	 * @param {boolean} disabled
	 */
	function disableRows(rows, disabled) {
		for (const row of rows) {
			for (const input of qsa('select, input', row)) {
				input.disabled = disabled;

				const label = input.parentElement;
				if (input.type === 'checkbox' && label.tagName === 'LABEL') {
					label.classList.toggle('disabled', disabled);
				}
			}
		}
	}

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
