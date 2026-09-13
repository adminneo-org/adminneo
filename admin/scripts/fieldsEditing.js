'use strict';
// Table/Procedure fields editing.

(() => {
	let added = '.';
	let lastType = '';

	/**
	 * Sets up event handlers for table printed by edit_fields().
	 *
	 * @param {HTMLTableElement} table
	 */
	window.initFieldsEditing = function(table) {
		const tableBody = qs("tbody", table);

		tableBody.addEventListener("keydown", onEditingKeydown);

		const rows = qsa("tr", tableBody);
		for (const row of rows) {
			initFieldsEditingRow(row);
		}
	};

	/**
	 * Sets up event handlers for one row.
	 *
	 * @param {HTMLTableRowElement} row
	 * @param {boolean} [autoAddRow]
	 */
	function initFieldsEditingRow(row, autoAddRow = true) {
		// Field name. Is null if some row is removed and then new row is added to the beginning (form is posted).
		let field = qs('[name$="[field]"]', row);
		if (field) {
			field.addEventListener("input", event => {
				const input = event.target;
				detectForeignKey(input);

				if (autoAddRow && !input.defaultValue) {
					addRow(input);
					autoAddRow = false;
				}
			});
		}

		// Type.
		field = qs('[name$="[type]"]', row);
		field.addEventListener("focus", event => {
			lastType = selectValue(event.target);
		});
		field.addEventListener("change", onFieldTypeChange);

		// Help.
		initHelpFor(field, (value) => {
			return value;
		}, true);

		// Length.
		field = qs('[name$="[length]"]', row);
		field.addEventListener("focus", onFieldLengthFocus);
		field.addEventListener("input", event => {
			// Mark length as required.
			const input = event.target;
			const typeSelect = input.parentElement.previousElementSibling.firstElementChild;

			input.classList.toggle('required', !input.value.length && /var(char|binary)$/.test(selectValue(typeSelect)));
		});

		// Autoincrement. Is null in procedure editing.
		field = qs("[name='auto_increment_col']", row);
		if (field) {
			field.addEventListener("click", event => {
				const input = event.target;
				const field = input.form['fields[' + input.value + '][field]'];
				if (!field.value) {
					field.value = "id";
					field.dispatchEvent(new Event("input"));
				}
			});
		}

		// Default value. Is null in procedure editing.
		field = qs('[name$="[default]"]', row);
		if (field) {
			field.addEventListener("input", event => {
				// Set usage of the default value Previous element can be checkbox or select.
				const element = event.target.previousElementSibling;

				element.checked = true;
				if (!element.selectedIndex) {
					element.selectedIndex = 1;
				}
			});
		}

		// Actions.
		let button = qs("button[name^='add']", row);
		if (button) {
			button.addEventListener("click", event => {
				addRow(event.currentTarget, true);
				event.preventDefault();
			});
		}

		button = qs("button[name^='drop_col']", row);
		if (button) {
			button.addEventListener("click", event => {
				removeTableRow(event.currentTarget, "field");
				event.preventDefault();
			});
		}
	}

	/**
	 * Detects foreign key from field name.
	 *
	 * @param {HTMLInputElement} input
	 */
	function detectForeignKey(input) {
		const name = input.name.slice(0, -7);
		const typeSelect = input.form.elements[name + '[type]'];
		const options = typeSelect.options;
		const value = input.value;
		let candidate; // don't select anything with ambiguous match (like column `id`)

		for (let i = options.length; i--; ) {
			const match = /(.+)`(.+)/.exec(options[i].value);
			// Common type.
			if (!match) {
				// Single target table, link to column, first field - probably `id`.
				if (candidate && i === options.length - 2 && value === options[candidate].value.replace(/.+`/, '') && name === 'fields[1]') {
					return;
				}
				break;
			}

			const [, table, column] = match;
			const tables = [table, table.replace(/s$/, ''), table.replace(/es$/, '')];

			for (const table of tables) {
				if (value === column || value === table || delimiterEqual(value, table, column) || delimiterEqual(value, column, table)) {
					if (candidate) {
						return;
					}

					candidate = i;
					break;
				}
			}
		}

		if (candidate) {
			typeSelect.selectedIndex = candidate;
			typeSelect.dispatchEvent(new Event('change'));
		}
	}

	/**
	 * Checks whether the value is equal to a-delimiter-b where delimiter is '_', '' or big letter.
	 *
	 * @param {string} value
	 * @param {string} part1
	 * @param {string} part2
	 *
	 * @return {boolean}
	 */
	function delimiterEqual(value, part1, part2) {
		return (value === part1 + '_' + part2 || value === part1 + part2 || value === part1 + part2[0].toUpperCase() + part2.slice(1));
	}

	/**
	 * Edits enum or set in the focused length input.
	 *
	 * @this {HTMLInputElement}
	 */
	function onFieldLengthFocus() {
		const td = this.parentElement;

		if (/^(enum|set)$/.test(selectValue(td.previousElementSibling.firstElementChild))) {
			const edit = gid('enum-edit');
			edit.value = parseEnumValues(this.value);

			td.append(edit);
			this.hidden = true;
			edit.hidden = false;
			edit.focus();
		}
	}

	/**
	 * Finishes editing of enum or set.
	 *
	 * @this {HTMLTextAreaElement}
	 */
	window.onFieldLengthBlur = function() {
		const field = this.parentNode.firstChild;
		const value = this.value;

		field.value = (/^'[^\n]+'$/.test(value) ?
			value :
			value && "'" + value.replace(/\n+$/, '').replace(/'/g, "''").replace(/\\/g, '\\\\').replace(/\n/g, "','") + "'");

		field.hidden = false;
		this.hidden = true;
	};

	/**
	 * Returns enum values separated by newlines.
	 *
	 * @param {string} string
	 *
	 * @return {string}
	 */
	function parseEnumValues(string) {
		const re = /(^|,)\s*'(([^\\']|\\.|'')*)'\s*/g;
		const result = [];
		let offset = 0;
		let match;

		while ((match = re.exec(string))) {
			if (offset !== match.index) {
				break;
			}

			result.push(match[2].replace(/'(')|\\(.)/g, '$1$2'));
			offset += match[0].length;
		}

		return offset === string.length ? result.join('\n') : string;
	}

	/**
	 * Clears length and hides collation or unsigned.
	 *
	 * @this {HTMLSelectElement}
	 */
	function onFieldTypeChange() {
		const type = this;
		const name = type.name.slice(0, -6);
		const text = selectValue(type);

		for (const el of type.form.elements) {
			if (el.name === name + '[length]') {
				if (!(
					(/(char|binary)$/.test(lastType) && /(char|binary)$/.test(text))
					|| (/(enum|set)$/.test(lastType) && /(enum|set)$/.test(text))
				)) {
					el.value = '';
				}
				el.dispatchEvent(new Event("input"));
			}

			if (lastType === 'timestamp' && el.name === name + '[generated]' && /timestamp/i.test(type.form.elements[name + '[default]'].value)) {
				el.checked = false;
				el.selectedIndex = 0;
			}

			// The expressions come from option_types(), the options of the other columns start with another name.
			if (el.dataset.types && el.name.startsWith(name + '[')) {
				el.classList.toggle('hidden', !new RegExp(el.dataset.types).test(text));
			}
		}
	}

	/**
	 * Adds new table row for the next field.
	 *
	 * @param {HTMLInputElement|HTMLButtonElement} button
	 * @param {boolean} [focus]
	 */
	function addRow(button, focus = false) {
		const match = /(\d+)(\.\d+)?/.exec(button.name);
		const newIndex = match[0] + (match[2] ? added.slice(match[2].length) : added) + '1';
		const row = button.closest('tr');
		const newRow = cloneNode(row);

		let inputs = qsa('select, input, button', row);
		let newInputs = qsa('select, input, button', newRow);

		for (const [i, input] of inputs.entries()) {
			newInputs[i].name = input.name.replace(/[0-9.]+/, newIndex);

			if (newInputs[i].tagName === "SELECT") {
				newInputs[i].selectedIndex = /\[(generated)/.test(input.name) ? 0 : input.selectedIndex;
			}
		}

		inputs = qsa('input', row);
		newInputs = qsa('input', newRow);

		for (const [i, input] of inputs.entries()) {
			if (input.name === 'auto_increment_col') {
				newInputs[i].value = newIndex;
				newInputs[i].checked = false;
			}

			if (/\[(orig|field|comment|default)/.test(input.name)) {
				newInputs[i].value = '';
			}

			if (/\[(generated)/.test(input.name)) {
				newInputs[i].checked = false;
			}
		}

		initFieldsEditingRow(newRow, !focus);

		const parent = button.closest("tbody");
		if (parent.classList.contains("sortable")) {
			initSortableRow(newRow);
		}

		row.parentNode.insertBefore(newRow, row.nextSibling);

		if (focus) {
			newInputs[0].focus();
		}

		added += '0';

		maxFieldsCheck();
	}

	/**
	 * Displays the error about the number of fields if the form has too many columns.
	 */
	function maxFieldsCheck() {
		// Only in table creating and altering, only if max_input_vars is set and only if the message is hidden.
		const message = qs('#max-fields');
		if (!message) {
			return;
		}

		// [orig] is printed for every column and removeTableRow() keeps it, so the removed columns are counted too.
		if (qsa('#edit-fields [name$="[orig]"]').length > +message.dataset.columns) {
			message.classList.remove('hidden');

			// The top of the page is not visible after adding columns.
			gid('edit-fields').parentNode.after(message);
		}
	}

	/**
	 * Adds new table row after the last field. Used by drivers where columns can be added only to the end.
	 *
	 * @this {HTMLButtonElement}
	 *
	 * @return {boolean} False on success, true to submit the form.
	 */
	window.onAddLastFieldRowClick = function () {
		const inputs = qsa('#edit-fields [name$="[field]"]');
		if (!inputs.length) {
			return true; // Submit the form to add the row by PHP.
		}

		addRow(inputs[inputs.length - 1], true);

		return false;
	};
})();
