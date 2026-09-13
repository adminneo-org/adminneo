'use strict';
// Admin specific functions

/**
 * Loads syntax highlighting.
 *
 * @param {string} version First three characters of database system version.
 * @param {?string} vendor
 * @param {Object} autocompletion
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
			}

			// MariaDB page keys are resolved by jush itself from the 'mysql-key maria-key' entries.
			obj[key] = (vendor === "mariadb" ?
				obj[key].replace('dev.mysql.com/doc/mysql', 'mariadb.com/kb') : // MariaDB
				obj[key]
			).replace('/doc/mysql', '/doc/refman/' + version); // MySQL

			if (vendor !== 'cockroach') {
				obj[key] = obj[key].replace('/docs/current', '/docs/' + version); // PostgreSQL
			}
		}
	}

	if (window.jushLinks) {
		jush.custom_links = jushLinks;
	}

	jush.highlight_tag('code', 0);

	for (const textarea of qsa('textarea')) {
		if ([...textarea.classList].some(name => name.startsWith('jush-'))) {
			const pre = jush.textarea(textarea, autocompletion, {
				silentStart: true
			});

			if (pre) {
				textarea.onchange = () => {
					pre.textContent = textarea.value;
					pre.oninput();
				};
			}
		}
	}
}

/**
 * Tries to change input type to password or to text.
 *
 * @param {HTMLInputElement} el
 * @param {boolean} disable
 */
function typePassword(el, disable) {
	try {
		el.type = (disable ? 'text' : 'password');
	} catch (e) {
		//
	}
}

/**
 * Hides or shows some login rows for selected driver.
 *
 * @param {HTMLSelectElement} driverSelect
 */
function initLoginDriver(driverSelect) {
	driverSelect.onchange = () => {
		const trs = driverSelect.closest('table').rows;
		const disabled = /sqlite/.test(selectValue(driverSelect));

		// 1 - row with server
		trs[1].classList.toggle('hidden', disabled);
		qs('input', trs[1]).disabled = disabled;
	};

	document.addEventListener('DOMContentLoaded', () => {
		driverSelect.onchange();
	});
}


let dbCtrl;
const dbPrevious = {};

/**
 * Checks if database should be opened in a new window.
 *
 * @param {MouseEvent} event
 *
 * @this {HTMLSelectElement}
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

/**
 * Loads database after selecting it.
 *
 * @this {HTMLSelectElement}
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



/**
 * Checks whether the query will be executed with an index.
 *
 * @this {HTMLElement}
 */
function selectFieldChange() {
	const form = this.form;
	const ok = (() => {
		if ([...qsa('input', form)].some(input => input.value && /^fulltext/.test(input.name))) {
			return true;
		}

		let ok = form.limit.value;
		let group = false;
		const columns = {};
		for (const select of qsa('select', form)) {
			const col = selectValue(select);
			let match = /^(where.+)col]/.exec(select.name);
			if (match) {
				const op = selectValue(form[match[1] + 'op]']);
				const val = form[match[1] + 'val]'].value;
				if (col in indexColumns && (!/LIKE|REGEXP/.test(op) || (op === 'LIKE' && val[0] !== '%'))) {
					return true;
				} else if (col || val) {
					ok = false;
				}
			}
			if ((match = /^(columns.+)fun]/.exec(select.name))) {
				if (/^(avg|count|count distinct|group_concat|max|min|sum)$/.test(col)) {
					group = true;
				}
				const val = selectValue(form[match[1] + 'col]']);
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
			for (const column in columns) {
				if (!(column in indexColumns)) {
					ok = false;
				}
			}
		}
		return ok;
	})();
	setHtml('noindex', (ok ? '' : '!'));
}

/**
 * Removes row in indexes table.
 *
 * @this {HTMLButtonElement}
 *
 * @return {boolean} Always false.
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
 *
 * @return {boolean} Always false.
 */
function removeTableRow(button, columnName) {
	const row = button.closest("tr");
	const input = qs(`[name$='[${columnName}]']`, row);

	input.remove();
	row.hidden = true;

	return false;
}

/**
 * Shows or hides selected table column.
 *
 * @param {boolean} checked
 * @param {number} column Column index.
 */
function columnShow(checked, column) {
	for (const tr of qsa('tr', gid('edit-fields'))) {
		qsa('td', tr)[column].classList.toggle('hidden', !checked);
	}
}

/**
 * Shows or hides index column options.
 *
 * @param {boolean} checked
 */
function indexOptionsShow(checked) {
	for (const option of qsa(".idxopts")) {
		option.classList.toggle("hidden", !checked);
	}
}

/**
 * Displays partition options.
 *
 * @this {HTMLSelectElement}
 */
function partitionByChange() {
	const partitionTable = /RANGE|LIST/.test(selectValue(this));

	this.form['partitions'].classList.toggle('hidden', partitionTable || !this.selectedIndex);
	gid('partition-table').classList.toggle('hidden', !partitionTable);
}

/**
 * Adds next partition row.
 *
 * @this {HTMLInputElement}
 */
function partitionNameChange() {
	const tr = this.closest('tr');
	const row = cloneNode(tr);
	row.firstChild.firstChild.value = '';
	tr.parentNode.append(row);
	this.oninput = () => {};
}

/**
 * Toggles comment fields.
 *
 * @param {HTMLInputElement} el
 * @param {number} columnIndex
 */
function editingCommentsClick(el, columnIndex) {
	const comment = el.form['Comment'];

	columnShow(el.checked, columnIndex);

	comment.classList.toggle('hidden', !el.checked);
	if (el.checked) {
		comment.focus();
	}
}

/**
 * Unchecks the 'all' checkbox.
 *
 * @param {MouseEvent} event
 *
 * @this {HTMLTableElement}
 */
function dumpClick(event) {
	let el = event.target.closest('label');
	if (!el) return;

	el = qs('input', el);
	const match = /(.+)\[]$/.exec(el.name);
	if (match) {
		checkboxClick.call(el, event);
		formUncheck('check-' + match[1]);
	}
}



/**
 * Adds row for foreign key.
 *
 * @this {HTMLSelectElement}
 */
function foreignAddRow() {
	const tr = this.closest('tr');
	const row = cloneNode(tr);
	this.onchange = () => { };
	for (const select of qsa('select', row)) {
		select.name = select.name.replace(/\d+]/, '1$&');
		select.selectedIndex = 0;
	}
	tr.parentNode.append(row);
}



/**
 * Adds row for indexes.
 *
 * @this {HTMLSelectElement}
 */
function indexesAddRow() {
	const tr = this.closest('tr');
	const row = cloneNode(tr);
	this.onchange = () => { };
	for (const tag of qsa('select, input, button', row)) {
		tag.name = tag.name.replace(/\[\d+/, '$&1'); // indexes[$j] and drop_col[$j]
		if (tag.matches('select')) {
			tag.selectedIndex = 0;
		} else if (tag.matches('input')) {
			if (tag.type === 'checkbox') {
				tag.checked = false;
			} else {
				tag.value = '';
			}
		}
	}
	tr.parentNode.append(row);
}

/**
 * Changes column in index. The last column also adds the next one.
 *
 * @param {string} prefix Name prefix.
 *
 * @this {HTMLSelectElement|HTMLInputElement}
 */
function indexesChangeColumn(prefix) {
	const field = this;
	const td = field.closest('td');
	const columns = [...qsa('select, input', td)].filter(column => /\[columns]/.test(column.name));

	// The appended column becomes the last one, so it adds the next.
	if (columns[columns.length - 1] === field) {
		const type = field.form[field.name.replace(/].*/, '][type]')];
		if (!type.selectedIndex) {
			while (selectValue(type) !== "INDEX" && type.selectedIndex < type.options.length) {
				type.selectedIndex++;
			}
			type.onchange();
		}

		// The clone keeps the handlers, so it adds the next column.
		const column = cloneNode(field.parentElement);
		for (const select of qsa('select', column)) {
			select.name = select.name.replace(/]\[\d+/, '$&1');
			select.selectedIndex = 0;
		}
		for (const input of qsa('input', column)) {
			input.name = input.name.replace(/]\[\d+/, '$&1');
			if (input.type !== 'checkbox') {
				input.value = '';
			}
		}
		td.append(column);
	}

	const names = [];
	// The appended column is empty, so it doesn't matter that it's not in the list.
	for (const column of columns) {
		const value = selectValue(column);
		if (value) {
			names.push(value);
		}
	}

	field.form[field.name.replace(/].*/, '][name]')].value = prefix + names.join('_');
}

/**
 * Updates the form action.
 *
 * @param {HTMLFormElement} form
 * @param {string} root
 */
function sqlSubmit(form, root) {
	const action = root
		+ '&sql=' + encodeURIComponent(form['query'].value)
		+ (form['limit'].value ? '&limit=' + +form['limit'].value : '')
		+ (form['error_stops'].checked ? '' : '&error_stops=0')
		+ (form['only_errors'].checked ? '&only_errors=1' : '')
	;
	if ((location.origin + location.pathname + action).length < 2000) { // reasonable minimum is 2048
		form.action = action;
	}
}



/**
 * Exports the result table by JS without re-running the query.
 *
 * @param {MouseEvent} event
 * @param {string} settingsUrl Address storing the selected format and output.
 *
 * @this {HTMLInputElement}
 *
 * @return {boolean} False when the export is handled by JS.
 */
function sqlExport(event, settingsUrl) {
	const form = this.form;
	const format = form['format'].value;
	const output = form['output'].value;
	if (!/^(csv|csv;|tsv)$/.test(format) || !/^(text|file)$/.test(output)) {
		return true;
	}

	const table = qs('.scrollable table', form.parentNode);
	if (!table) {
		return true;
	}

	// <i> other than NULL means the value is not displayed fully
	if ([...qsa('i', table)].some(i => i.textContent !== 'NULL')) {
		return true;
	}

	// The form is not submitted, so the settings have to be stored separately.
	ajax(settingsUrl, null, 'format=' + encodeURIComponent(format) + '&output=' + encodeURIComponent(output)
		+ '&token=' + encodeURIComponent(form['token'].value), null, true);

	const tsv = (format === 'tsv');
	const quotable = new RegExp('["\n]|^0[^.]|\\.\\d*0$|' + (tsv ? '\t' : '[,;]|^$')); // dump_csv()
	const separator = (format === 'csv' ? ',' : (tsv ? '\t' : ';'));

	let data = '\ufeff'; // UTF-8 byte order mark
	for (const row of qsa('tr', table)) {
		data += Array.from(row.children).map(cell => {
			const val = (qsa('i', cell).length ? '' : cell.textContent); // <i> - NULL
			return (quotable.test(val) ? '"' + val.replace(/"/g, '""') + '"' : val);
		}).join(separator) + '\r\n';
	}

	const url = URL.createObjectURL(new Blob([data], {type: (output === 'file' ? 'text/csv' : 'text/plain') + '; charset=utf-8'}));
	if (output === 'file') {
		const a = document.createElement('a');
		a.href = url;
		a.download = 'sql-' + formatDateTime(new Date()) + '.csv'; // dump_headers()
		document.body.append(a);
		a.click();
		a.remove();
		setTimeout(() => URL.revokeObjectURL(url));
	} else if (isCtrl(event) || event.shiftKey) {
		// The same modifiers open the server-side export in a new window in bodyClick(). Submit the form if the pop-up is blocked.
		// The URL is not revoked to not break the load of the new window.
		return !open(url);
	} else {
		location.href = url;
	}

	return false;
}

/**
 * Formats date and time as Ymd-His.
 *
 * @param {Date} date
 *
 * @return {string}
 */
function formatDateTime(date) {
	const pad = number => ('0' + number).slice(-2);

	return date.getFullYear() + pad(date.getMonth() + 1) + pad(date.getDate())
		+ '-' + pad(date.getHours()) + pad(date.getMinutes()) + pad(date.getSeconds());
}

/**
 * Handles changing trigger time or event.
 *
 * @param {RegExp} tableRe
 * @param {string} table
 * @param {HTMLFormElement} form
 */
function triggerChange(tableRe, table, form) {
	const formEvent = selectValue(form['Event']);
	if (tableRe.test(form['Trigger'].value)) {
		form['Trigger'].value = table + '_' + (selectValue(form['Timing'])[0] + formEvent[0]).toLowerCase();
	}
	form['Of'].classList.toggle('hidden', !/ OF/.test(formEvent));
}
