// Admin specific functions

/**
 * Loads syntax highlighting.
 *
 * @param {string} version First three characters of database system version.
 * @param {string|null} vendor
 * @param {object} autocompletion
 */
function initSyntaxHighlighting(version, vendor, autocompletion) {
	if (!window.jush) {
		return;
	}

	jush.create_links = ' target="_blank" rel="noreferrer noopener"';

	if (version) {
		for (let key in jush.urls) {
			let obj = jush.urls;
			if (typeof obj[key] != 'string') {
				obj = obj[key];
				key = 0;
				if (vendor === 'mariadb') {
					for (let i = 1; i < obj.length; i++) {
						obj[i] = obj[i]
							.replace('.html', '/')
							.replace('-type-syntax', '-data-types')
							.replace(/numeric-(data-types)/, '$1-$&')
							.replace(/replication-options-(master|binary-log)\//, 'replication-and-binary-log-system-variables/')
							.replace('server-options/', 'server-system-variables/')
							.replace('innodb-parameters/', 'innodb-system-variables/')
							.replace(/#(statvar|sysvar|option_mysqld)_(.*)/, '#$2')
							.replace(/#sysvar_(.*)/, '#$1')
						;
					}
				}
			}

			obj[key] = (vendor === "mariadb" ? obj[key].replace('dev.mysql.com/doc/mysql', 'mariadb.com/kb') : obj[key]) // MariaDB
				.replace('/doc/mysql', '/doc/refman/' + version) // MySQL
			;
			if (vendor !== 'cockroach') {
				obj[key] = obj[key].replace('/docs/current', '/docs/' + version); // PostgreSQL
			}
		}
	}

	if (window.jushLinks) {
		jush.custom_links = jushLinks;
	}

	jush.highlight_tag('code', 0);

	const tags = qsa('textarea');
	for (let i = 0; i < tags.length; i++) {
		if (tags[i].className.match(/(^|\s)jush-/)) {
			jush.textarea(tags[i], autocompletion, {
				silentStart: true
			});
		}
	}
}

/** Try to change input type to password or to text
* @param HTMLInputElement
* @param boolean
*/
function typePassword(el, disable) {
	try {
		el.type = (disable ? 'text' : 'password');
	} catch (e) {
	}
}

/**
 * Hides or shows some login rows for selected driver.
 *
 * @param {HTMLSelectElement} driverSelect
 */
function initLoginDriver(driverSelect) {
	driverSelect.onchange = function () {
		const trs = parentTag(driverSelect, 'table').rows;
		const disabled = /sqlite/.test(selectValue(driverSelect));

		// 1 - row with server
		trs[1].classList.toggle('hidden', disabled);
		trs[1].getElementsByTagName('input')[0].disabled = disabled;
	};

	document.addEventListener('DOMContentLoaded', function () {
		driverSelect.onchange();
	});
}


var dbCtrl;
var dbPrevious = {};

/** Check if database should be opened to a new window
* @param MouseEvent
* @this HTMLSelectElement
*/
function dbMouseDown(event) {
	// Firefox: mouse-down event does not contain pressed key information for OPTION.
	// Chrome: mouse-down event has inherited key information from SELECT.
	// So we ignore the event for OPTION to work Ctrl+click correctly everywhere.
	if (event.target.tagName === "OPTION") return;

	dbCtrl = isCtrl(event);
	if (dbPrevious[this.name] === undefined) {
		dbPrevious[this.name] = this.value;
	}
}

/** Load database after selecting it
* @this HTMLSelectElement
*/
function dbChange() {
	if (dbCtrl) {
		this.form.target = '_blank';
	}
	this.form.submit();
	this.form.target = '';
	if (dbCtrl && dbPrevious[this.name] !== undefined) {
		this.value = dbPrevious[this.name];
		dbPrevious[this.name] = undefined;
	}
}



/** Check whether the query will be executed with index
* @this HTMLElement
*/
function selectFieldChange() {
	var form = this.form;
	var ok = (function () {
		var inputs = qsa('input', form);
		for (var i=0; i < inputs.length; i++) {
			if (inputs[i].value && /^fulltext/.test(inputs[i].name)) {
				return true;
			}
		}
		var ok = form.limit.value;
		var selects = qsa('select', form);
		var group = false;
		var columns = {};
		for (var i=0; i < selects.length; i++) {
			var select = selects[i];
			var col = selectValue(select);
			var match = /^(where.+)col]/.exec(select.name);
			if (match) {
				var op = selectValue(form[match[1] + 'op]']);
				var val = form[match[1] + 'val]'].value;
				if (col in indexColumns && (!/LIKE|REGEXP/.test(op) || (op === 'LIKE' && val.charAt(0) !== '%'))) {
					return true;
				} else if (col || val) {
					ok = false;
				}
			}
			if ((match = /^(columns.+)fun]/.exec(select.name))) {
				if (/^(avg|count|count distinct|group_concat|max|min|sum)$/.test(col)) {
					group = true;
				}
				var val = selectValue(form[match[1] + 'col]']);
				if (val) {
					columns[col && col !== 'count' ? '' : val] = 1;
				}
			}
			if (col && /^order/.test(select.name)) {
				if (!(col in indexColumns)) {
					ok = false;
				}
				break;
			}
		}
		if (group) {
			for (var col in columns) {
				if (!(col in indexColumns)) {
					ok = false;
				}
			}
		}
		return ok;
	})();
	setHtml('noindex', (ok ? '' : '!'));
}



// Table/Procedure fields editing.
(function() {
	let added = '.';
	let lastType = '';

	/**
	 * Sets up event handlers for table printed by edit_fields().
	 *
	 * @param {HTMLElement} table
	 */
	window.initFieldsEditing = function(table) {
		const tableBody = qs("tbody", table);

		tableBody.addEventListener("keydown", onEditingKeydown);

		const rows = qsa("tr", tableBody);
		for (let row of rows) {
			initFieldsEditingRow(row);
		}
	};

	/**
	 * Sets up event handlers for one row.
	 *
	 * @param {HTMLElement} row
	 * @param {boolean} autoAddRow
	 */
	function initFieldsEditingRow(row, autoAddRow = true) {
		// Field name. Is null if some row is removed and then new row is added to the beginning (form is posted).
		let field = qs('[name$="[field]"]', row);
		if (field) {
			field.addEventListener("input", (event) => {
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
		field.addEventListener("focus", (event) => {
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
		field.addEventListener("input", (event) => {
			// Mark length as required.
			const input = event.target;
			input.classList.toggle('required', !input.value.length && /var(char|binary)$/.test(selectValue(input.parentNode.previousSibling.firstChild)));
		});

		// Autoincrement. Is null in procedure editing.
		field = qs("[name='auto_increment_col']", row);
		if (field) {
			field.addEventListener("click", (event) => {
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
			field.addEventListener("input", (event) => {
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
			button.addEventListener("click", (event) => {
				addRow(event.currentTarget, true);
				event.preventDefault();
			});
		}

		button = qs("button[name^='drop_col']", row);
		if (button) {
			button.addEventListener("click", (event) => {
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
		const name = input.name.substring(0, input.name.length - 7);
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

			let table = match[1];
			const column = match[2];
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
	 * Checks if value is equal to a-delimiter-b where delimiter is '_', '' or big letter.
	 *
	 * @param {string} value
	 * @param {string} part1
	 * @param {string} part2
	 *
	 * @return {boolean}
	 */
	function delimiterEqual(value, part1, part2) {
		return (value === part1 + '_' + part2 || value === part1 + part2 || value === part1 + part2.charAt(0).toUpperCase() + part2.substring(1));
	}

	/**
	 * Edit enum or set.
	 *
	 * @this {HTMLInputElement} Length input.
	 */
	function onFieldLengthFocus() {
		const td = this.parentNode;

		if (/(enum|set)$/.test(selectValue(td.previousSibling.firstChild))) {
			const edit = gid('enum-edit');
			edit.value = parseEnumValues(this.value);

			td.appendChild(edit);
			this.style.display = 'none';
			edit.style.display = 'inline';
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

		field.style.display = 'inline';
		this.style.display = 'none';
	};

	/**
	 * Returns enum values.
	 *
	 * @param {string} string
	 *
	 * @return {string} Values separated by newlines.
	 */
	function parseEnumValues(string) {
		const re = /(^|,)\s*'(([^\\']|\\.|'')*)'\s*/g;
		const result = [];
		let offset = 0;
		let match;

		while (match = re.exec(string)) {
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
	 * @this HTMLSelectElement
	 */
	function onFieldTypeChange() {
		const type = this;
		const name = type.name.substring(0, type.name.length - 6);
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

			if (el.name === name + '[collation]') {
				el.classList.toggle('hidden', !/(char|text|enum|set)$/.test(text));
			}

			if (el.name === name + '[unsigned]') {
				el.classList.toggle('hidden', !/(^|[^o])int(?!er)|numeric|real|float|double|decimal|money/.test(text));
			}

			if (el.name === name + '[on_update]') {
				// MySQL supports datetime since 5.6.5.
				el.classList.toggle('hidden', !/timestamp|datetime/.test(text));
			}

			if (el.name === name + '[on_delete]') {
				el.classList.toggle('hidden', !/`/.test(text));
			}
		}
	}

	/**
	 * Adds new table row for the next field.
	 *
	 * @param {(HTMLInputElement|HTMLButtonElement)} button
	 * @param {boolean} focus
	 */
	function addRow(button, focus = false) {
		const match = /(\d+)(\.\d+)?/.exec(button.name);
		const newIndex = match[0] + (match[2] ? added.substring(match[2].length) : added) + '1';
		const row = parentTag(button, 'tr');
		const newRow = cloneNode(row);

		let inputs = qsa('select, input, button', row);
		let newInputs = qsa('select, input, button', newRow);

		for (let i = 0; i < inputs.length; i++) {
			newInputs[i].name = inputs[i].name.replace(/[0-9.]+/, newIndex);

			if (newInputs[i].tagName === "SELECT") {
				newInputs[i].selectedIndex = /\[(generated)/.test(inputs[i].name) ? 0 : inputs[i].selectedIndex;
			}
		}

		inputs = qsa('input', row);
		newInputs = qsa('input', newRow);

		for (let i = 0; i < inputs.length; i++) {
			if (inputs[i].name === 'auto_increment_col') {
				newInputs[i].value = newIndex;
				newInputs[i].checked = false;
			}

			if (/\[(orig|field|comment|default)/.test(inputs[i].name)) {
				newInputs[i].value = '';
			}

			if (/\[(generated)/.test(inputs[i].name)) {
				newInputs[i].checked = false;
			}
		}

		initFieldsEditingRow(newRow, !focus);

		const parent = parentTag(button, "tbody");
		if (parent.classList.contains("sortable")) {
			initSortableRow(newRow);
		}

		row.parentNode.insertBefore(newRow, row.nextSibling);

		if (focus) {
			newInputs[0].focus();
		}

		added += '0';
	}
})();

/**
 * Removes row in indexes table.
 *
 * @this {HTMLButtonElement}
 * @return {false}
 */
function onRemoveIndexRowClick() {
	removeTableRow(this, "type");

	return false;
}

/**
 * Removes table row for field.
 *
 * @param {HTMLButtonElement} button
 * @param {string} columnName Name of the key input field.
 */
function removeTableRow(button, columnName) {
	const row = parentTag(button, "tr");
	const input = qs(`[name$='[${columnName}]']`, row);

	input.remove();
	row.style.display = 'none';

	return false;
}

/** Show or hide selected table column
* @param boolean
* @param number
*/
function columnShow(checked, column) {
	var trs = qsa('tr', gid('edit-fields'));
	for (var i=0; i < trs.length; i++) {
		qsa('td', trs[i])[column].classList.toggle('hidden', !checked);
	}
}

/** Show or hide index column options
* @param boolean
*/
function indexOptionsShow(checked) {
	var options = qsa(".idxopts");
	for (var i=0; i < options.length; i++) {
		options[i].classList.toggle("hidden", !checked);
	}
}

/** Display partition options
* @this HTMLSelectElement
*/
function partitionByChange() {
	var partitionTable = /RANGE|LIST/.test(selectValue(this));

	this.form['partitions'].classList.toggle('hidden', partitionTable || !this.selectedIndex);
	gid('partition-table').classList.toggle('hidden', !partitionTable);
}

/** Add next partition row
* @this HTMLInputElement
*/
function partitionNameChange() {
	var row = cloneNode(parentTag(this, 'tr'));
	row.firstChild.firstChild.value = '';
	parentTag(this, 'table').appendChild(row);
	this.oninput = function () {};
}

/** Show or hide comment fields
* @param HTMLInputElement
* @param [boolean] whether to focus Comment if checked
*/
function editingCommentsClick(el, focus) {
	var comment = el.form['Comment'];
	columnShow(el.checked, 7);
	comment.classList.toggle('hidden', !el.checked);
	if (focus && el.checked) {
		comment.focus();
	}
}



/** Uncheck 'all' checkbox
* @param MouseEvent
* @this HTMLTableElement
*/
function dumpClick(event) {
	var el = parentTag(event.target, 'label');
	if (el) {
		el = qs('input', el);
		var match = /(.+)\[]$/.exec(el.name);
		if (match) {
			checkboxClick.call(el, event);
			formUncheck('check-' + match[1]);
		}
	}
}



/** Add row for foreign key
* @this HTMLSelectElement
*/
function foreignAddRow() {
	var row = cloneNode(parentTag(this, 'tr'));
	this.onchange = function () { };
	var selects = qsa('select', row);
	for (var i=0; i < selects.length; i++) {
		selects[i].name = selects[i].name.replace(/\d+]/, '1$&');
		selects[i].selectedIndex = 0;
	}
	parentTag(this, 'table').appendChild(row);
}



/** Add row for indexes
* @this HTMLSelectElement
*/
function indexesAddRow() {
	var row = cloneNode(parentTag(this, 'tr'));
	this.onchange = function () { };
	var selects = qsa('select', row);
	for (var i=0; i < selects.length; i++) {
		selects[i].name = selects[i].name.replace(/indexes\[\d+/, '$&1');
		selects[i].selectedIndex = 0;
	}
	var inputs = qsa('input', row);
	for (var i=0; i < inputs.length; i++) {
		inputs[i].name = inputs[i].name.replace(/indexes\[\d+/, '$&1');
		inputs[i].value = '';
	}
	parentTag(this, 'table').appendChild(row);
}

/** Change column in index
* @param string name prefix
* @this HTMLSelectElement
*/
function indexesChangeColumn(prefix) {
	var names = [];
	for (var tag in { 'select': 1, 'input': 1 }) {
		var columns = qsa(tag, parentTag(this, 'td'));
		for (var i=0; i < columns.length; i++) {
			if (/\[columns]/.test(columns[i].name)) {
				var value = selectValue(columns[i]);
				if (value) {
					names.push(value);
				}
			}
		}
	}
	this.form[this.name.replace(/].*/, '][name]')].value = prefix + names.join('_');
}

/** Add column for index
* @param string name prefix
* @this HTMLSelectElement
*/
function indexesAddColumn(prefix) {
	var field = this;
	var select = field.form[field.name.replace(/].*/, '][type]')];
	if (!select.selectedIndex) {
		while (selectValue(select) !== "INDEX" && select.selectedIndex < select.options.length) {
			select.selectedIndex++;
		}
		select.onchange();
	}
	var column = cloneNode(field.parentNode);
	var selects = qsa('select', column);
	for (var i = 0; i < selects.length; i++) {
		select = selects[i];
		select.name = select.name.replace(/]\[\d+/, '$&1');
		select.selectedIndex = 0;
	}
	field.onchange = partial(indexesChangeColumn, prefix);
	var inputs = qsa('input', column);
	for (var i = 0; i < inputs.length; i++) {
		var input = inputs[i];
		input.name = input.name.replace(/]\[\d+/, '$&1');
		if (input.type !== 'checkbox') {
			input.value = '';
		}
	}
	parentTag(field, 'td').appendChild(column);
	field.onchange();
}



/** Updates the form action
* @param HTMLFormElement
* @param string
*/
function sqlSubmit(form, root) {
	if (encodeURIComponent(form['query'].value).length < 500) {
		form.action = root
			+ '&sql=' + encodeURIComponent(form['query'].value)
			+ (form['limit'].value ? '&limit=' + +form['limit'].value : '')
			+ (form['error_stops'].checked ? '&error_stops=1' : '')
			+ (form['only_errors'].checked ? '&only_errors=1' : '')
		;
	}
}



/** Handle changing trigger time or event
* @param RegExp
* @param string
* @param HTMLFormElement
*/
function triggerChange(tableRe, table, form) {
	var formEvent = selectValue(form['Event']);
	if (tableRe.test(form['Trigger'].value)) {
		form['Trigger'].value = table + '_' + (selectValue(form['Timing']).charAt(0) + formEvent.charAt(0)).toLowerCase();
	}
	form['Of'].classList.toggle('hidden', !/ OF/.test(formEvent));
}



var that, x, y; // em and tablePos defined in schema.inc.php

/** Get mouse position
* @param MouseEvent
* @this HTMLElement
*/
function schemaMousedown(event) {
	if ((event.which ? event.which : event.button) === 1) {
		that = this;
		x = event.clientX - this.offsetLeft;
		y = event.clientY - this.offsetTop;
	}
}

/** Move object
* @param MouseEvent
*/
function schemaMousemove(event) {
	if (that !== undefined) {
		var left = (event.clientX - x) / em;
		var top = (event.clientY - y) / em;
		var divs = qsa('div', that);
		var lineSet = { };
		for (var i=0; i < divs.length; i++) {
			if (divs[i].className === 'references') {
				var div2 = qs('[id="' + (/^refs/.test(divs[i].id) ? 'refd' : 'refs') + divs[i].id.substr(4) + '"]');
				var ref = (tablePos[divs[i].title] ? tablePos[divs[i].title] : [ div2.parentNode.offsetTop / em, 0 ]);
				var left1 = -1;
				var id = divs[i].id.replace(/^ref.(.+)-.+/, '$1');
				if (divs[i].parentNode !== div2.parentNode) {
					left1 = Math.min(0, ref[1] - left) - 1;
					divs[i].style.left = left1 + 'em';
					divs[i].querySelector('div').style.width = -left1 + 'em';
					var left2 = Math.min(0, left - ref[1]) - 1;
					div2.style.left = left2 + 'em';
					div2.querySelector('div').style.width = -left2 + 'em';
				}
				if (!lineSet[id]) {
					var line = qs('[id="' + divs[i].id.replace(/^....(.+)-.+$/, 'refl$1') + '"]');
					var top1 = top + divs[i].offsetTop / em;
					var top2 = top + div2.offsetTop / em;
					if (divs[i].parentNode !== div2.parentNode) {
						top2 += ref[0] - top;
						line.querySelector('div').style.height = Math.abs(top1 - top2) + 'em';
					}
					line.style.left = (left + left1) + 'em';
					line.style.top = Math.min(top1, top2) + 'em';
					lineSet[id] = true;
				}
			}
		}
		that.style.left = left + 'em';
		that.style.top = top + 'em';
	}
}

/** Finish move
* @param MouseEvent
* @param string
*/
function schemaMouseup(event, db) {
	if (that !== undefined) {
		tablePos[that.firstChild.firstChild.firstChild.data] = [ (event.clientY - y) / em, (event.clientX - x) / em ];
		that = undefined;
		var s = '';
		for (var key in tablePos) {
			s += '_' + key + ':' + Math.round(tablePos[key][0] * 10000) / 10000 + 'x' + Math.round(tablePos[key][1] * 10000) / 10000;
		}
		s = encodeURIComponent(s.substr(1));
		var link = gid('schema-link');
		link.href = link.href.replace(/[^=]+$/, '') + s;
		cookie('neo_schema-' + db + '=' + s, 30); //! special chars in db
	}
}


// Help.
(function() {
	let openTimeout = null;
	let closeTimeout = null;
	let helpVisible = false;

	window.initHelpPopup = function () {
		const help = gid("help");

		help.addEventListener("mouseenter", () => {
			clearTimeout(closeTimeout);
			closeTimeout = null;
		});

		help.addEventListener("mouseleave", hideHelp);
	};

	/**
	 * @param {HTMLElement} element
	 * @param {string|function} content
	 * @param {boolean} side Displays on left side (otherwise on top).
	 */
	window.initHelpFor = function(element, content, side = false) {
		const withCallback = typeof content === "function";

		element.addEventListener("mouseenter", (event) => {
			showHelp(event.target, withCallback ? content(event.target.value) : content, side)
		});

		element.addEventListener("mouseleave", hideHelp);
		element.addEventListener("blur", hideHelp);

		if (withCallback) {
			element.addEventListener("change", hideHelp);
		}
	};

	/**
	 * Displays help popup after a small delay.
	 *
	 * @param {HTMLElement} element
	 * @param {string} text
	 * @param {boolean} side display on left side (otherwise on top)
	 */
	function showHelp(element, text, side) {
		if (!text) {
			hideHelp();
			return;
		}

		if (isSorting() || !window.jush) {
			return;
		}

		clearTimeout(openTimeout);
		openTimeout = null;
		clearTimeout(closeTimeout);
		closeTimeout = null;

		const help = gid("help");
		help.innerHTML = text;
		jush.highlight_tag([help]);

		// Display help briefly to calculate position properly.
		help.classList.remove("hidden");

		const rect = element.getBoundingClientRect();
		const root = document.documentElement;

		let top = root.scrollTop + rect.top;
		let left = root.scrollLeft + rect.left;

		if (side) {
			left -= help.offsetWidth;
			if (left < 0) {
				left = rect.left;
				top -= help.offsetHeight;
			} else {
				top -= (help.offsetHeight - element.offsetHeight) / 2;
			}
		} else {
			top -= help.offsetHeight;
			left -= (help.offsetWidth - element.offsetWidth) / 2;
		}

		help.style.top = `${top}px`;
		help.style.left = `${left}px`;

		if (helpVisible) {
			return;
		}

		help.classList.add("hidden");

		openTimeout = setTimeout(() => {
			gid("help").classList.remove("hidden");

			helpVisible = true;
			openTimeout = null;
		}, 600);
	}

	/**
	 * Closes the help popup after a small delay.
	 */
	function hideHelp() {
		if (openTimeout) {
			clearTimeout(openTimeout);
			openTimeout = null;
			return;
		}

		closeTimeout = setTimeout(() => {
			gid("help").classList.add("hidden");

			helpVisible = false;
			closeTimeout = null;
		}, 200);
	}
})();
