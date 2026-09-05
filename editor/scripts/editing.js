'use strict';
// Editor specific functions

/**
 * Does nothing. EditorNeo does not indicate whether the query will be executed with an index.
 *
 * @this {HTMLElement}
 */
function selectFieldChange() {
}

// Help.
(() => {
	/**
	 * Does nothing. EditorNeo displays no help popup.
	 */
	window.initHelpPopup = function() {
	};

	/**
	 * Does nothing. EditorNeo displays no help popup.
	 *
	 * @param {HTMLElement} element
	 * @param {string|function} content
	 * @param {boolean} [side] Displays on left side (otherwise on top).
	 */
	window.initHelpFor = function(element, content, side = false) {
	};
})();

/**
 * Displays typeahead.
 *
 * @param {string} url
 *
 * @this {HTMLInputElement}
 */
function whisper(url) {
	const field = this;
	field.orig = field.value;
	field.previousSibling.value = field.value; // accept number, reject string
	ajax(url + encodeURIComponent(field.value), xmlhttp => {
		if (xmlhttp.status && field.orig === field.value) { // ignore old responses
			field.nextSibling.innerHTML = xmlhttp.responseText;
			field.nextSibling.style.display = '';
			const a = field.nextSibling.firstChild;
			if (a && a.firstChild.data === field.value) {
				field.previousSibling.value = decodeURIComponent(a.href.replace(/.*=/, ''));
				a.classList.add('active');
			}
		}
	});
}

/**
 * Selects typeahead value.
 *
 * @param {MouseEvent} event
 *
 * @this {HTMLDivElement}
 *
 * @return {boolean} False for success.
 */
function whisperClick(event) {
	const field = this.previousSibling;
	const el = event.target;
	if (isTag(el, 'a') && !(event.button || event.shiftKey || event.altKey || isCtrl(event))) {
		field.value = el.firstChild.data;
		field.previousSibling.value = decodeURIComponent(el.href.replace(/.*=/, ''));
		field.nextSibling.style.display = 'none';
		return false;
	}
}
