'use strict';

/**
 * Returns the element found by given identifier.
 *
 * @param {string} id
 * @param {?HTMLElement} context Defaults to document.
 * @return {?HTMLElement}
 */
function gid(id, context = document) {
	return context.getElementById(id);
}

/** Get first element by selector
* @param string
* @param [HTMLElement] defaults to document
* @return HTMLElement
*/
function qs(selector, context = document) {
	return context.querySelector(selector);
}

/** Get last element by selector
* @param string
* @param [HTMLElement] defaults to document
* @return HTMLElement
*/
function qsl(selector, context = document) {
	const els = qsa(selector, context);
	return els[els.length - 1];
}

/** Get all elements by selector
* @param string
* @param [HTMLElement] defaults to document
* @return NodeList
*/
function qsa(selector, context = document) {
	return context.querySelectorAll(selector);
}

/** Return a function calling fn with the next arguments
* @param function
* @param ...
* @return function with preserved this
*/
function partial(fn, ...args) {
	return function () {
		return fn.apply(this, args);
	};
}

/** Return a function calling fn with the first parameter and then the next arguments
* @param function
* @param ...
* @return function with preserved this
*/
function partialArg(fn, ...args) {
	return function (arg) {
		return fn.apply(this, [arg, ...args]);
	};
}

/** Assign values from source to target
* @param Object
* @param Object
*/
function mixin(target, source) {
	for (const key in source) {
		target[key] = source[key];
	}
}

/**
 * Toggles visibility of element with ID.
 *
 * @param {string} id
 * @return {boolean} Always false.
 */
function toggle(id) {
	gid(id).classList.toggle("hidden");

	return false;
}

/** Set permanent cookie
* @param string
* @param number
*/
function cookie(assign, days) {
	const date = new Date();
	date.setDate(date.getDate() + days);
	document.cookie = assign + '; expires=' + date;
}

/**
 * Verifies current AdminNeo version.
 *
 * @param baseUrl string
 * @param token string
 */
function verifyVersion(baseUrl, token) {
	document.addEventListener("DOMContentLoaded", () => {
		// Dummy value to prevent repeated verifications after AJAX failure.
		cookie('neo_version=0', 1);

		ajax('https://api.github.com/repos/adminneo-org/adminneo/releases/latest', (request) => {
			const response = JSON.parse(request.responseText);

			const matches = response.tag_name.match(/^v(\d{1,2}\.\d{1,2}\.\d{1,2}(-(alpha|beta|rc)\d?)?)$/);
			if (!matches) return;

			cookie('neo_version=' + matches[1], 1);
		}, null, null, true);
	});
}

/** Get value of select
* @param HTMLElement <select> or <input>
* @return string
*/
function selectValue(select) {
	if (!select.selectedIndex) {
		return select.value;
	}
	const selected = select.options[select.selectedIndex];
	return (selected.attributes.value?.specified ? selected.value : selected.text);
}

/** Verify if element has a specified tag name
* @param HTMLElement
* @param string regular expression
* @return boolean
*/
function isTag(el, tag) {
	const re = new RegExp('^(' + tag + ')$', 'i');
	return el && re.test(el.tagName);
}

/** Get parent node with specified tag name
* @param HTMLElement
* @param string regular expression
* @return HTMLElement
*/
function parentTag(el, tag) {
	while (el && !isTag(el, tag)) {
		el = el.parentNode;
	}
	return el;
}

/** Set checked class
* @param HTMLInputElement
*/
function trCheck(el) {
	const tr = parentTag(el, 'tr');
	tr.classList.toggle('checked', el.checked);
	el.form?.['all']?.onclick?.();
}

/**
 * Fills number of selected items in fieldset legend and disables submit buttons if count is zero.
 *
 * @param {string} id
 * @param {number|string} count Can be exact number or string like '~ 100'.
 * @uses thousandsSeparator
 */
function selectCount(id, count) {
	const zero = count === 0 || count === '0' || count === '';

	setHtml(id, '(' + (count + '').replace(/\B(?=(\d{3})+$)/g, thousandsSeparator) + ')');

	const el = gid(id);
	if (!el) return;

	const inputs = qsa('input[type="submit"]', el.parentNode.parentNode);
	for (const input of inputs) {
		input.disabled = zero;
	}
}

/** Check all elements matching given name
* @param RegExp
* @this HTMLInputElement
*/
function formCheck(name) {
	for (const el of this.form.elements) {
		if (name.test(el.name)) {
			el.checked = this.checked;
			trCheck(el);
		}
	}
}

/** Check all rows in <table class="checkable"> once the browser restores the checkboxes
*/
function tableCheck() {
	window.addEventListener('pageshow', () => {
		qsa('table.checkable td:first-child input').forEach(trCheck);
	});
}

/**
 * Uncheck single element.
 */
function formUncheck(id) {
	formUncheckAll("#" + id);
}

/**
 * Uncheck elements matched by selector.
 */
function formUncheckAll(selector) {
	for (const element of qsa(selector)) {
		element.checked = false;
		trCheck(element);
	}
}

/** Get number of checked elements matching given name
* @param HTMLInputElement
* @param RegExp
* @return number
*/
function formChecked(input, name) {
	return [...input.form.elements].filter(el => name.test(el.name) && el.checked).length;
}

/** Select clicked row
* @param MouseEvent
* @param [boolean] force click
*/
function tableClick(event, click, canEdit = true) {
	const td = parentTag(event.target, 'td');
	let text;
	if (canEdit && td && (text = td.dataset.text)) {
		if (selectClick.call(td, event, +text, td.dataset.warning)) {
			return;
		}
	}
	click = (click || getSelection().isCollapsed);
	let el = event.target;
	while (!isTag(el, 'tr')) {
		if (isTag(el, 'table|a|input|textarea')) {
			if (el.type !== 'checkbox') {
				return;
			}
			checkboxClick.call(el, event);
			click = false;
		}
		el = el.parentNode;
		if (!el) { // Ctrl+click on text fields hides the element
			return;
		}
	}
	el = el.firstChild.firstChild;
	if (click) {
		el.checked = !el.checked;
		el.onclick?.();
	}
	if (el.name === 'check[]') {
		el.form['all'].checked = false;
		formUncheck('all-page');
	}
	if (/^(tables|views)\[\]$/.test(el.name)) {
		formUncheck('check-all');
	}
	trCheck(el);
}

let lastChecked;

/** Shift-click on checkbox for multiple selection.
* @param MouseEvent
* @this HTMLInputElement
*/
function checkboxClick(event) {
	if (!this.name) {
		return;
	}
	if (event.shiftKey && (!lastChecked || lastChecked.name === this.name)) {
		const checked = (lastChecked ? lastChecked.checked : true);
		let checking = !lastChecked;
		for (const input of qsa('input', parentTag(this, 'table'))) {
			if (input.name === this.name) {
				if (checking) {
					input.checked = checked;
					trCheck(input);
				}
				if (input === this || input === lastChecked) {
					if (checking) {
						break;
					}
					checking = true;
				}
			}
		}
	} else {
		lastChecked = this;
	}
}

/** Set HTML code of an element
* @param string
* @param string undefined to set parentNode to empty string
*/
function setHtml(id, html) {
	const el = qs('[id="' + id.replace(/[\\"]/g, '\\$&') + '"]'); // database name is used as ID
	if (el) {
		if (html == null) {
			el.parentNode.innerHTML = '';
		} else {
			el.innerHTML = html;
		}
	}
}

/** Find node position
* @param Node
* @return number
*/
function nodePosition(el) {
	let pos = 0;
	while ((el = el.previousSibling)) {
		pos++;
	}
	return pos;
}

/** Go to the specified page
* @param string
* @param string
*/
function pageClick(href, page) {
	if (!isNaN(page) && page) {
		location.href = href + (page !== 1 ? '&page=' + (page - 1) : '');
	}
}

function initNavigation() {
	const button = gid("navigation-button");
	const panel = gid("navigation-panel");

	button.addEventListener("click", () => {
		button.classList.toggle("opened");
		panel.classList.toggle("opened");
	});
}

/**
 * Makes the navigation panel resizable by the handle at its inner edge.
 *
 * @param {string} url Address storing the new width.
 * @param {string} token CSRF token.
 * @param {number} minWidth Number of rem units.
 * @param {number} maxWidth Number of rem units.
 */
function initNavigationResizer(url, token, minWidth, maxWidth) {
	const handle = gid("navigation-resizer");
	const panel = gid("navigation-panel");
	const style = gid("navigation-width");
	const rtl = document.body.classList.contains("rtl");

	let hoverTimeout = null;
	let dragging = false;
	let remSize = 0;
	let width = 0;

	// The handle is highlighted with a delay to not distract when the pointer just passes over it.
	handle.addEventListener("mouseenter", () => {
		hoverTimeout = window.setTimeout(() => handle.classList.add("active"), 100);
	});

	handle.addEventListener("mouseleave", () => {
		window.clearTimeout(hoverTimeout);
		if (!dragging) {
			handle.classList.remove("active");
		}
	});

	const resize = event => {
		const rect = panel.getBoundingClientRect();
		const offset = (rtl ? rect.right - event.clientX : event.clientX - rect.left) / remSize;
		width = Math.round(Math.min(Math.max(offset, minWidth), maxWidth) * 100) / 100;

		// The same media query as on the server keeps the custom width off the floating panel.
		style.textContent = '@media screen and (min-width: 1024px) { :root { --menu-width: ' + width + 'rem } }';
	};

	const save = value => {
		ajax(url, null, 'width=' + value + '&token=' + encodeURIComponent(token), null, true);
	};

	const stop = () => {
		dragging = false;
		document.removeEventListener("mousemove", resize);
		document.removeEventListener("mouseup", stop);
		document.body.classList.remove("resizing");

		if (width) {
			save(width);
		}
	};

	handle.addEventListener("mousedown", event => {
		if (event.button) { // 0 - left button
			return;
		}

		// Prevent selecting the panel content.
		event.preventDefault();

		dragging = true;
		remSize = parseFloat(getComputedStyle(document.documentElement).fontSize);
		width = 0;
		handle.classList.add("active");
		document.body.classList.add("resizing");
		document.addEventListener("mousemove", resize);
		document.addEventListener("mouseup", stop);
	});

	// Double click restores the default width.
	handle.addEventListener("dblclick", () => {
		width = 0;
		style.textContent = "";
		save("");
	});
}

function initTablesList(dbName) {
	if (!sessionStorage) {
		return;
	}

	const navigationPanel = gid('navigation-panel');
	const tablesList = gid('tables');

	if (sessionStorage.getItem('neo_tables_position_db') !== dbName) {
		sessionStorage.removeItem('neo_tables_position');
	} else if (sessionStorage.getItem('neo_tables_position')) {
		const positions = sessionStorage.getItem('neo_tables_position').split("|");

		navigationPanel.classList.add('opened');
		navigationPanel.scrollTop = positions[0] * 1;
		tablesList.scrollTop = positions[1] * 1;
		navigationPanel.classList.remove('opened');
	}

	sessionStorage.setItem('neo_tables_position_db', dbName);

	window.addEventListener('pagehide', function() {
		navigationPanel.classList.add('opened');
		sessionStorage.setItem('neo_tables_position', `${navigationPanel.scrollTop}|${tablesList.scrollTop}`);
		navigationPanel.classList.remove('opened');
	}, false);
}

let tablesFilterTimeout = null;
let tablesFilterValue = '';

function initTablesFilter(dbName) {
	const filterInput = gid('tables-filter');

	if (sessionStorage) {
		document.addEventListener('DOMContentLoaded', () => {
			if (sessionStorage.getItem('neo_tables_filter_db') !== dbName) {
				sessionStorage.removeItem('neo_tables_filter');
			} else if (sessionStorage.getItem('neo_tables_filter')) {
				filterInput.value = sessionStorage.getItem('neo_tables_filter');
				filterTables();
			}

			sessionStorage.setItem('neo_tables_filter_db', dbName);
		});
	}

	filterInput.addEventListener('input', () => {
		window.clearTimeout(tablesFilterTimeout);
		tablesFilterTimeout = window.setTimeout(filterTables, 200);
	});

	document.body.addEventListener('keydown', event => {
		if (isCtrl(event) && event.shiftKey && event.key.toUpperCase() === 'F') {
			filterInput.focus();
			filterInput.select();

			event.preventDefault();
		}
	});
}

function filterTables() {
	const value = gid('tables-filter').value.toLowerCase();
	if (value === tablesFilterValue) {
		return;
	}
	tablesFilterValue = value;

	let reg
	if (value !== '') {
		const valueExp = (`${value}`).replace(/[\\.+*?\[^\]$(){}=!<>|:]/g, '\\$&');
		reg = new RegExp(`(${valueExp})`, 'gi');
	}

	if (sessionStorage) {
		sessionStorage.setItem('neo_tables_filter', value);
	}

	for (const table of qsa('#tables li')) {
		let a = qs('*[data-primary="true"]', table);

		let tableName = table.dataset.tableName;
		if (tableName == null) {
			tableName = a.innerHTML.trim();

			table.dataset.tableName = tableName;
		}

		if (value === "") {
			table.classList.remove('hidden');
			a.innerHTML = tableName;
		} else if (tableName.toLowerCase().indexOf(value) >= 0) {
			table.classList.remove('hidden');
			a.innerHTML = tableName.replace(reg, '<strong>$1</strong>');
		} else {
			table.classList.add('hidden');
		}
	}
}

/**
 * Initialize collapsable fieldset.
 *
 * @param {string} id
 */
function initFieldset(id) {
	const fieldset = gid(`fieldset-${id}`);

	fieldset.addEventListener("click", () => {
		if (fieldset.classList.contains("closed")) {
			fieldset.classList.remove("closed");
		}
	});

	qs("legend a", fieldset).addEventListener("click", event => {
		fieldset.classList.toggle("closed");
		event.preventDefault();
		event.stopPropagation();
	});
}

/**
 * Installs toggle handler.
 *
 * @param {HTMLElement} parent
 */
function initToggles(parent) {
	for (const link of qsa('.toggle', parent)) {
		link.addEventListener("click", event => {
			const id = link.getAttribute('href').slice(1);

			gid(id).classList.toggle("hidden");
			link.classList.toggle("opened");

			event.preventDefault();
			event.stopPropagation();
		});
	}
}

/**
 * Initialize auto-submitting of settings form.
 */
function initSettingsForm() {
	const form = gid("settings");
	const inputs = qsa("select, input[type='checkbox'], input[type='radio']", form);

	for (const input of inputs) {
		input.addEventListener("change", () => {
			input.form.submit();
		});
	}
}

/**
 * Adds row in select fieldset.
 *
 * @param {Event} event
 * @this HTMLSelectElement
 */
function selectAddRow(event) {
	const field = this;
	const row = cloneNode(field.parentNode);

	field.onchange = selectFieldChange;
	field.onchange(event);

	for (const select of qsa('select', row)) {
		select.name = select.name.replace(/[a-z]\[\d+/, '$&1');
		select.selectedIndex = 0;
	}

	for (const input of qsa('input', row)) {
		input.name = input.name.replace(/[a-z]\[\d+/, '$&1');
		if (input.type === 'checkbox') {
			input.checked = false;
		} else {
			input.value = '';
		}
	}

	const button = qs('.remove', row);
	button.onclick = selectRemoveRow;

	const parent = field.parentNode.parentNode;
	if (parent.classList.contains("sortable")) {
		initSortableRow(field.parentElement);
	}

	parent.append(row);
}

/**
 * Removes a row in select fieldset.
 *
 * @this HTMLInputElement
 * @return {boolean} Always false.
 */
function selectRemoveRow() {
	this.parentElement.remove();

	return false;
}

/** Prevent onsearch handler on Enter
* @param KeyboardEvent
* @this HTMLInputElement
*/
function selectSearchKeydown(event) {
	if (event.key === 'Enter') {
		this.onsearch = () => {
		};
	}
}

// Sorting.
(() => {
	let placeholderRow = null, nextRow = null, dragHelper = null;
	let startScrollY, startY, minY, maxY, lastPointerY, rowHeight;

	/**
	 * Initializes sortable list of DIV elements.
	 *
	 * @param {string} parentSelector
	 */
	window.initSortable = function(parentSelector) {
		const parent = qs(parentSelector);
		if (!parent) return;

		for (const row of parent.children) {
			if (!row.classList.contains("no-sort")) {
				initSortableRow(row);
			}
		}
	};

	/**
	 * Initializes one row of sortable parent.
	 *
	 * @param {HTMLElement} row
	 */
	window.initSortableRow = function(row) {
		row.classList.remove("no-sort");

		const handle = qs(".handle", row);
		handle.addEventListener("mousedown", event => { startSorting(row, event) });
		handle.addEventListener("touchstart", event => { startSorting(row, event) });
	};

	window.isSorting = function() {
		return dragHelper !== null;
	};

	function startSorting(row, event) {
		event.preventDefault();

		const pointerY = getPointerY(event);

		const parent = row.parentNode;
		startScrollY = window.scrollY;
		startY = pointerY - getOffsetTop(row);
		minY = getOffsetTop(parent);
		maxY = minY + parent.offsetHeight - row.offsetHeight;

		placeholderRow = row.cloneNode(true);
		placeholderRow.classList.add("placeholder");
		parent.insertBefore(placeholderRow, row);

		rowHeight = placeholderRow.offsetHeight;
		if (row.tagName !== "TR") {
			rowHeight += parseFloat(window.getComputedStyle(placeholderRow).marginBottom);
		}

		nextRow = row.nextElementSibling;

		let top = pointerY - startY;
		let left = getOffsetLeft(row);
		let width = row.getBoundingClientRect().width;

		if (row.tagName === "TR") {
			const firstChild = row.firstElementChild;
			const borderWidth = (firstChild.offsetWidth - firstChild.clientWidth) / 2;
			const borderHeight = (firstChild.offsetHeight - firstChild.clientHeight) / 2;

			minY -= borderHeight;
			maxY -= borderHeight;
			top -= borderHeight;
			left -= borderWidth;
			width += 2 * borderWidth;

			for (const child of row.children) {
				child.style.width = child.getBoundingClientRect().width + "px";
			}

			const body = document.createElement("tbody");
			body.append(row);

			dragHelper = document.createElement("table");
			dragHelper.append(body);
		} else {
			dragHelper = row;
		}

		dragHelper.style.top = `${top}px`;
		dragHelper.style.left = `${left}px`;
		dragHelper.style.width = `${width}px`;
		dragHelper.classList.add("dragging");
		document.body.append(dragHelper);

		window.addEventListener("mousemove", updateSorting);
		window.addEventListener("touchmove", updateSorting);
		window.addEventListener("scroll", updateSorting);

		window.addEventListener("mouseup", finishSorting);
		window.addEventListener("touchend", finishSorting);
		window.addEventListener("touchcancel", finishSorting);
	}

	function updateSorting(event) {
		const pointerY = getPointerY(event);
		const scrollingBoundary = 30;
		const speedCoefficient = 8;

		// If mouse pointer is over the top boundary, scroll page down.
		let distance = pointerY - scrollingBoundary;
		if (distance < 0 && window.scrollY > 0) {
			window.scrollBy(0, distance / speedCoefficient);
			return;
		}

		// If mouse pointer is under the bottom boundary, scroll page up.
		distance = pointerY - window.innerHeight + scrollingBoundary;
		if (distance > 0 && window.scrollY + window.innerHeight < document.documentElement.scrollHeight) {
			window.scrollBy(0, distance / speedCoefficient);
			return;
		}

		// Move helper row to the pointer position.
		let top = Math.min(Math.max(pointerY - startY + window.scrollY - startScrollY, minY), maxY);
		dragHelper.style.top = `${top}px`;

		// Find a new position for the placeholder.
		const parent = placeholderRow.parentNode;
		let oldNextRow = nextRow;
		top = top - minY + parent.offsetTop;

		let testingRow = placeholderRow;
		do {
			if (top > testingRow.offsetTop + rowHeight / 2 + 1) {
				if (!nextRow.classList.contains("no-sort")) {
					testingRow = nextRow;
					nextRow = nextRow.nextElementSibling;
				} else {
					break;
				}
			} else if (top + rowHeight < testingRow.offsetTop + rowHeight / 2 - 1) {
				nextRow = testingRow = testingRow.previousElementSibling;
			} else {
				break;
			}
		} while (nextRow);

		// Move the placeholder to a new position.
		if (nextRow !== oldNextRow) {
			if (nextRow) {
				parent.insertBefore(placeholderRow, nextRow);
			} else {
				parent.append(placeholderRow);
			}
		}
	}

	function finishSorting() {
		dragHelper.classList.remove("dragging");
		dragHelper.style.top = null;
		dragHelper.style.left = null;
		dragHelper.style.width = null;

		dragHelper.remove();

		placeholderRow.parentNode.insertBefore(
			dragHelper.tagName === "TABLE" ? dragHelper.firstChild.firstChild : dragHelper,
			placeholderRow
		);
		placeholderRow.remove();

		placeholderRow = nextRow = dragHelper = null;

		window.removeEventListener("mousemove", updateSorting);
		window.removeEventListener("touchmove", updateSorting);
		window.removeEventListener("scroll", updateSorting);

		window.removeEventListener("mouseup", finishSorting);
		window.removeEventListener("touchend", finishSorting);
		window.removeEventListener("touchcancel", finishSorting);
	}

	function getPointerY(event) {
		if (event.type.includes("touch")) {
			const touch = event.touches[0] || event.changedTouches[0];
			lastPointerY = touch.clientY;
		} else if (event.clientY !== undefined) {
			lastPointerY = event.clientY;
		}

		return lastPointerY;
	}
})();




/** Fill column in search field
* @param string
* @return boolean false
*/
function selectSearch(name) {
	const fieldset = gid('fieldset-search');
	fieldset.className = '';

	const divs = qsa('div', fieldset);
	let div = [...divs].find(row => {
		const col = qs('[name$="[col]"]', row);
		return col && selectValue(col) === name;
	});

	if (!div) { // use the last empty row
		div = divs[divs.length - 1];
		div.firstChild.value = name;
		div.firstChild.onchange();
	}
	qs('[name$="[val]"]', div).focus();
	return false;
}


/** Check if Ctrl key (Command key on Mac) was pressed
* @param KeyboardEvent|MouseEvent
* @return boolean
*/
function isCtrl(event) {
	return (event.ctrlKey || event.metaKey) && !event.altKey; // shiftKey allowed
}

/** Send form by Ctrl+Enter on <select> and <textarea>
* @param KeyboardEvent
* @param [string]
* @return boolean
*/
function bodyKeydown(event, button) {
	eventStop(event);
	let target = event.target;
	if (target.jushTextarea) {
		target = target.jushTextarea;
	}
	if (isCtrl(event) && event.key === 'Enter' && isTag(target, 'select|textarea|input')) {
		target.blur();
		if (target.form[button]) {
			target.form[button].click();
		} else {
			target.form.dispatchEvent(new Event('submit', {bubbles: true}));
			target.form.submit();
		}
		target.focus();
		return false;
	}
	return true;
}

/** Open form to a new window on Ctrl+click or Shift+click
* @param MouseEvent
*/
function bodyClick(event) {
	const target = event.target;
	if ((isCtrl(event) || event.shiftKey) && target.type === 'submit' && isTag(target, 'input')) {
		target.form.target = '_blank';
		setTimeout(() => {
			// if (isCtrl(event)) { focus(); } doesn't work
			target.form.target = '';
		}, 0);
	}
}



/**
 * Changes the focus by Ctrl+Up or Ctrl+Down in a table.
 *
 * @param {KeyboardEvent} event
 *
 * @return {boolean}
 */
function onEditingKeydown(event)
{
	if (/^Arrow(Down|Up)$/.test(event.key) && isCtrl(event)) {
		event.preventDefault();

		const target = event.target;
		let row = parentTag(target, "tr");
		if (!row) {
			return false;
		}

		row = event.key === 'ArrowDown' ? row.nextElementSibling : row.previousElementSibling;
		if (!row || !isTag(row, 'tr')) {
			return false;
		}

		const cell = row.childNodes[nodePosition(parentTag(target, "th|td"))];
		if (!cell) {
			return false;
		}

		let input = cell.childNodes[nodePosition(target)];
		if (!input || !isTag(input, "input|select|textarea|pre|button") || input.classList.contains("hidden")) {
			input = qs("input:not(.hidden), select:not(.hidden), textarea:not(.hidden), pre.jush, button", cell);
		}

		if (input) {
			input.focus();
		}

		return false;
	}

	if (event.shiftKey && !bodyKeydown(event, 'insert')) {
		event.preventDefault();
		return false;
	}

	return true;
}

/**
 * Disables maxlength for functions and manages value visibility.
 *
 * @this HTMLSelectElement
 */
function functionChange() {
	const func = selectValue(this);

	const inputName = this.name.replace(/^function/, 'fields');
	let input = this.form[inputName] || this.form[`${inputName}[]`];

	// Switch to the text field if function is selected.
	if (func === "SQL" || func === "+" || func === "-") {
		if (!input.origElement) {
			const text = document.createElement('input');
			text.className = "input";
			text.name = input.name;
			text.value = input.lastValue || selectValue(input);
			text.origElement = input;
			text.size = input.size || -1;
			input.replaceWith(text);
		}
	} else if (input.origElement) { // revive the original element (keeps its type, e.g. number for +)
		input.replaceWith(input.origElement);
		input = input.origElement;
	}

	if (func && func !== "NULL" && input.type !== "select-one" && input.type !== "file") {
		if (input.origType === undefined) {
			input.origType = input.type;
			input.origMaxLength = input.dataset.maxlength;
		}

		input.removeAttribute('data-maxlength');
		input.type = 'text';
	} else if (input.origType) {
		input.type = input.origType;
		if (input.origMaxLength >= 0) {
			input.setAttribute('data-maxlength', input.origMaxLength);
		}
	}

	if (func === "NULL") {
		// Hide input value if it will be not used by selected function.
		if (input.type === "select-one") {
			input.lastValue = input.value;
			input.value = "__adminneo_empty__";
		} else if (input.length) {
			// Uncheck every single radio/checkbox.
			let checkedList = [];
			for (let i = 0; i < input.length; i++) {
				const radio = input[i];

				if (!radio.checked) continue;

				checkedList.push(i);
				radio.checked = false;

				if (radio.type === "radio") {
					break;
				}
			}

			input.lastValue = checkedList;
		} else {
			input.lastValue = input.value;
			input.value = "";
		}
	} else if (input.lastValue) {
		// Restore last value.
		if (input.type !== "select-one" && input.length) {
			for (const index of input.lastValue) {
				input[index].checked = true;
			}
		} else {
			input.value = input.lastValue;
		}
	} else {
		// Set the first available value.
		if (input.type === "select-one") {
			if (input.options[0].value === "__adminneo_empty__") {
				input.value = input.options[1].value;
			}
		} else if (input.length && input[0].type === "radio") {
			input[0].checked = true;
		}
	}

	// Hide input for functions without argument.
	input.classList.toggle("hidden", /^(now|getdate|current_date|current_timestamp|uuid)$/.test(func));

	if (!input.length) {
		oninput({target: input});
	}
}

/**
 * Unset 'original', 'NULL' and 'now' functions when typing.
 *
 * @param first number
 * @this HTMLTableCellElement
 */
function skipOriginal(first) {
	const fnSelect = qs('select', this.previousSibling);
	const value = selectValue(fnSelect);

	if (fnSelect.selectedIndex < first || value === "NULL" || value === "now") {
		fnSelect.selectedIndex = first;
	}
}

/** Add new field in schema-less edit
* @this HTMLInputElement
*/
function fieldChange() {
	const tr = parentTag(this, 'tr');
	const row = cloneNode(tr);
	for (const input of qsa('input', row)) {
		input.value = '';
	}
	// keep value in <select> (function)
	tr.parentNode.append(row);
	this.oninput = null;
}



/**
 * Sends AJAX request.
 *
 * @param {string} url
 * @param {function|null} onSuccess (XMLHttpRequest)
 * @param {string|null} data POST data.
 * @param {string|null} progressMessage
 * @param {boolean} failSilently
 * @return XMLHttpRequest or false in case of an error
 * @uses offlineMessage
 */
function ajax(url, onSuccess = null, data = null, progressMessage = null, failSilently = false) {
	const ajaxStatus = gid('ajaxstatus');

	if (progressMessage) {
		ajaxStatus.innerHTML = '<div class="message">' + progressMessage + '</div>';
		ajaxStatus.classList.remove("hidden");
	} else {
		ajaxStatus.classList.add("hidden");
	}

	const request = new XMLHttpRequest();
	request.open((data ? 'POST' : 'GET'), url);
	request.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	if (data) {
		request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	}

	request.onreadystatechange = () => {
		if (request.readyState === 4) {
			if (request.status >= 200 && request.status < 300) {
				if (onSuccess) {
					onSuccess(request);
				}
			} else if (failSilently) {
				console.error(request.status ? request.responseText : "No internet connection");
			} else {
				ajaxStatus.innerHTML = (request.status ? request.responseText : '<div class="error">' + offlineMessage + '</div>');
				ajaxStatus.classList.remove("hidden");
			}
		}
	};

	request.send(data);

	return request;
}

/** Use setHtml(key, value) for JSON response
* @param string
* @return boolean false for success
*/
function ajaxSetHtml(url) {
	return !ajax(url, request => {
		const data = JSON.parse(request.responseText);
		for (const key in data) {
			setHtml(key, data[key]);
		}
	});
}

/** Save form contents through AJAX
* @param HTMLFormElement
* @param string
* @param [HTMLInputElement]
* @return boolean
*/
function ajaxForm(form, message, button) {
	let data = [];
	for (const el of form.elements) {
		if (el.name && !el.disabled) {
			if (/^file$/i.test(el.type) && el.value) {
				return false;
			}
			if (!/^(checkbox|radio|submit|file)$/i.test(el.type) || el.checked || el === button) {
				data.push(encodeURIComponent(el.name) + '=' + encodeURIComponent(isTag(el, 'select') ? selectValue(el) : el.value));
			}
		}
	}
	data = data.join('&');

	let url = form.action;
	if (!/post/i.test(form.method)) {
		url = url.replace(/\?.*/, '') + '?' + data;
		data = '';
	}
	return ajax(url, request => {
		setHtml('ajaxstatus', request.responseText);
		if (window.jush) {
			jush.highlight_tag(qsa('code', gid('ajaxstatus')), 0);
		}
		initToggles(gid('ajaxstatus'));
	}, data, message);
}

function initTableFooter() {
	const footer = qs(".table-footer");
	if (!footer) return;

	const options = {
		root: qs(".table-footer-parent"),
		rootMargin: "0px 0px -1px 0px",
		threshold: 1.0,
	};

	const observer = new IntersectionObserver((entries) => {
		const entry = entries[0];
		// Note: entry.isIntersecting does not work well on mobile Safari so we are comparing bottom positions.
		footer.classList.toggle("sticky", entry.boundingClientRect.bottom < entry.rootBounds.bottom);
	}, options);

	observer.observe(footer);
}

/**
 * Enables the Save button while at least one inline edit field is displayed.
 */
function updateSaveButton() {
	const button = gid('modify-save');
	if (button?.dataset.inlineEdit) {
		button.disabled = !qs('#table td[data-editing="true"]');
	}
}

/**
 * Displays inline edit field.
 *
 * @param {MouseEvent} event
 * @param {number} text Display textarea instead of input, 2 - load long text.
 * @param {string|null} warning Warning text if editing is disabled.
 *
 * @this {HTMLElement}
 *
 * @return boolean|XMLHttpRequest
 */
function selectClick(event, text, warning) {
	const td = this;
	const target = event.target;

	// Note: Shift key forces the editing when clicking on a link.
	if (!isCtrl(event) || td.dataset.editing || (!event.shiftKey && parentTag(target, 'a'))) {
		return false;
	}

	// Prevent opening a link.
	event.preventDefault();

	if (warning) {
		alert(warning);
		return true;
	}

	const original = td.innerHTML;
	text = text || /\n/.test(original);

	const input = document.createElement(text ? 'textarea' : 'input');
	if (!text) {
		input.classList.add("input");
	}

	input.onkeydown = event => {
		if (event.key === 'Escape' && !event.shiftKey && !event.altKey && !isCtrl(event)) {
			td.dataset.editing = "";
			td.innerHTML = original;
			initToggles(td);
			updateSaveButton();
		}
	};

	const dataset = td.firstChild?.dataset ?? {};
	let value;
	if (dataset.value !== undefined) {
		const dom = new DOMParser().parseFromString(dataset.value, "text/html");
		value = dom.documentElement.innerText;
	} else {
		value = td.innerText;
	}

	const tdStyle = window.getComputedStyle(td);
	input.style.width = Math.max(td.clientWidth - parseFloat(tdStyle.paddingLeft) - parseFloat(tdStyle.paddingRight), (text ? 200 : 20)) + 'px';

	if (text) {
		input.rows = value.split('\n').length;
	}

	if (qsa('i', td).length) { // <i> - NULL
		value = '';
	}

	// Firefox: event.rangeOffset is defined, anchorOffset is related to the whole TR not the inner text node.
	// Chrome/Safari: event.rangeOffset is not defined, anchorOffset is related to the inner text node.
	const pos = event.rangeOffset ?? getSelection().anchorOffset;

	td.dataset.editing = "true";
	td.innerHTML = '';
	td.append(input);
	input.focus();
	updateSaveButton();

	if (text === 2) { // long text
		return ajax(location.href + '&' + encodeURIComponent(td.id) + '=', request => {
			if (request.responseText) {
				input.value = request.responseText;
				input.name = td.id;
			}
		});
	}

	input.value = value;
	input.name = td.id;
	input.selectionStart = pos;
	input.selectionEnd = pos;

	return true;
}



/**
 * Loads and displays the next page in the select table.
 *
 * @param {number} limit
 * @param {string} loadingText
 * @this {HTMLLinkElement}
 *
 * @return {boolean} false for success to stop the click event.
 */
function loadNextPage(limit, loadingText) {
	const a = this;
	const title = a.innerHTML;
	const href = a.href;
	if (!href) {
		return true;
	}

	a.innerHTML = loadingText;
	a.removeAttribute('href');

	return !ajax(href, request => {
		const newBody = document.createElement('tbody');
		newBody.innerHTML = request.responseText;

		jush.highlight_tag(qsa("code", newBody), 0);
		initToggles(newBody);

		const lastPage = newBody.children.length < limit;

		qs('#table tbody').append(...newBody.children);

		if (lastPage) {
			a.parentElement.remove();
		} else {
			a.href = href.replace(/\d+$/, page => +page + 1);
			a.innerHTML = title;
		}
	});
}



/** Stop event propagation
* @param Event
*/
function eventStop(event) {
	event.stopPropagation();
}



/** Clone node and setup submit highlighting
* @param HTMLElement
* @return HTMLElement
*/
function cloneNode(el) {
	const el2 = el.cloneNode(true);
	const selector = 'input, select, button';
	const origEls = qsa(selector, el);
	const cloneEls = qsa(selector, el2);

	for (const [i, origEl] of origEls.entries()) {
		for (const key in origEl) {
			if (/^on/.test(key) && origEl[key]) {
				cloneEls[i][key] = origEl[key];
			}
		}
	}

	return el2;
}

function getOffsetTop(element) {
	let box = element.getBoundingClientRect();

	return box.top + window.scrollY;
}

function getOffsetLeft(element) {
	let box = element.getBoundingClientRect();

	return box.left + window.scrollX;
}

oninput = event => {
	const target = event.target;
	const maxLength = target.dataset.maxlength;

	// maxLength could be 0
	target.classList.toggle('maxlength', target.value && maxLength != null && target.value.length > maxLength);
};
