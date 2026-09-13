'use strict';

(() => {
	let schema;
	let pixPerEm, tablePos;
	let activeBox = null;
	let startX, startY, x, y, dragging;

	/**
	 * Initializes the schema interactions.
	 *
	 * @param {string} dbName
	 * @param {number} topEm
	 * @param {Object} tablePositions Table name => [top, left] in ems.
	 */
	window.initSchema = function(dbName, topEm, tablePositions) {
		schema = gid('schema');

		pixPerEm = schema.offsetHeight / topEm;
		tablePos = tablePositions;

		for (const content of qsa(".table > .content", schema)) {
			content.addEventListener("mousedown", onBoxMouseDown);
			content.addEventListener("touchstart", onBoxTouchStart);
		}

		document.addEventListener("mousedown", onDocumentPress);
		document.addEventListener("touchstart", onDocumentPress);
		document.addEventListener("mousemove", onMouseMove);
		// The listener is not passive, it prevents scrolling the page while dragging a box.
		document.addEventListener("touchmove", onTouchMove, {passive: false});
		document.addEventListener("mouseup", event => onMouseUp(event, dbName));
		document.addEventListener("touchend", event => onTouchEnd(event, dbName));
		document.addEventListener("touchcancel", event => onTouchEnd(event, dbName));
	};

	/**
	 * Selects the table box together with the lines of its outgoing references.
	 *
	 * @param {HTMLElement} box
	 */
	function selectTable(box) {
		deselectTables();

		box.classList.add('selected');

		for (const div of qsa('.references[id^="refs"]', box)) {
			// The target end of the reference and the line connecting them.
			const div2 = qs('[id="refd' + div.id.slice(4) + '"]');
			const line = qs('[id="' + div.id.replace(/^....(.+)-.+$/, 'refl$1') + '"]');

			div.classList.add('selected');
			if (div2) {
				div2.classList.add('selected');
				// The box is a stacking context, so the line inside it can be raised only together with the box.
				div2.closest('.table').classList.add('related');
			}
			if (line) {
				line.classList.add('selected');
			}
		}
	}

	/**
	 * Removes the selection of a table box and its reference lines.
	 */
	function deselectTables() {
		for (const el of qsa('.selected, .related', schema)) {
			el.classList.remove('selected');
			el.classList.remove('related');
		}
	}

	/**
	 * Deselects the table box when pressed outside the content of any box.
	 *
	 * @param {MouseEvent|TouchEvent} event
	 */
	function onDocumentPress(event) {
		if (!event.target.closest('#schema .content')) {
			deselectTables();
		}
	}

	/**
	 * Selects the box of the pressed content and stores the mouse position.
	 *
	 * @param {MouseEvent} event
	 *
	 * @this {HTMLElement} Content of a table box.
	 */
	function onBoxMouseDown(event) {
		if (event.button !== 0) {
			return;
		}

		startMove(this, event.clientX, event.clientY);

		// The table name is a link and its native dragging would swallow the mouse events until the button is released.
		if (event.target.closest('a')) {
			event.preventDefault();
		}
	}

	/**
	 * Selects the box of the touched content and stores the touch position.
	 *
	 * @param {TouchEvent} event
	 *
	 * @this {HTMLElement} Content of a table box.
	 */
	function onBoxTouchStart(event) {
		// A second finger zooms the page, it does not move the box.
		if (event.touches.length === 1) {
			startMove(this, event.touches[0].clientX, event.touches[0].clientY);
		}
	}

	/**
	 * Remembers the box to move and the position it is grabbed at.
	 *
	 * @param {HTMLElement} content Content of a table box.
	 * @param {number} clientX
	 * @param {number} clientY
	 */
	function startMove(content, clientX, clientY) {
		const box = content.parentNode;

		activeBox = box;
		selectTable(box);

		dragging = false;
		startX = clientX;
		startY = clientY;
		x = clientX - box.offsetLeft;
		y = clientY - box.offsetTop;
	}

	/**
	 * Moves object.
	 *
	 * @param {MouseEvent} event
	 */
	function onMouseMove(event) {
		move(event.clientX, event.clientY);
	}

	/**
	 * Moves object and keeps the page from scrolling under the finger.
	 *
	 * @param {TouchEvent} event
	 */
	function onTouchMove(event) {
		if (event.touches.length === 1 && move(event.touches[0].clientX, event.touches[0].clientY)) {
			event.preventDefault();
		}
	}

	/**
	 * Moves the active box to the position.
	 *
	 * @param {number} clientX
	 * @param {number} clientY
	 *
	 * @return {boolean} True if the box has been moved.
	 */
	function move(clientX, clientY) {
		if (!activeBox) {
			return false;
		}

		if (!dragging) {
			// A tiny movement is not a drag gesture yet, so a click on the table name link stays functional.
			if (Math.abs(clientX - startX) < 3 && Math.abs(clientY - startY) < 3) {
				return false;
			}

			dragging = true;
			document.body.classList.add('moving');

			// A drag started right after the previous one must follow the cursor without the snapping transition.
			schema.classList.remove('snapping');
		}

		moveBox(activeBox, (clientX - x) / pixPerEm, (clientY - y) / pixPerEm);

		return true;
	}

	/**
	 * Moves the table box together with its reference lines.
	 *
	 * @param {HTMLElement} box
	 * @param {number} left Position in ems.
	 * @param {number} top Position in ems.
	 */
	function moveBox(box, left, top) {
		const lineSet = {};

		for (const div of qsa('.references', box)) {
			const div2 = qs('[id="' + (/^refs/.test(div.id) ? 'refd' : 'refs') + div.id.slice(4) + '"]');
			const ref = (tablePos[div.title] || [div2.parentNode.offsetTop / pixPerEm, 0]);
			let left1 = -1;
			const id = div.id.replace(/^ref.(.+)-.+/, '$1');

			if (div.parentNode !== div2.parentNode) {
				left1 = Math.min(0, ref[1] - left) - 1;
				div.style.left = left1 + 'em';
				div.querySelector('div').style.width = -left1 + 'em';

				const left2 = Math.min(0, left - ref[1]) - 1;
				div2.style.left = left2 + 'em';
				div2.querySelector('div').style.width = -left2 + 'em';
			}

			if (!lineSet[id]) {
				const line = qs('[id="' + div.id.replace(/^....(.+)-.+$/, 'refl$1') + '"]');
				const top1 = top + div.offsetTop / pixPerEm;
				let top2 = top + div2.offsetTop / pixPerEm;

				if (div.parentNode !== div2.parentNode) {
					top2 += ref[0] - top;
					line.querySelector('div').style.height = Math.abs(top1 - top2) + 'em';
				}

				line.style.left = (left + left1) + 'em';
				line.style.top = Math.min(top1, top2) + 'em';

				lineSet[id] = true;
			}
		}

		box.style.left = left + 'em';
		box.style.top = top + 'em';
	}

	/**
	 * Finishes box move.
	 *
	 * @param {MouseEvent} event
	 * @param {string} db
	 */
	function onMouseUp(event, db) {
		endMove(event.clientX, event.clientY, db);
	}

	/**
	 * Finishes box move by the lifted or cancelled finger.
	 *
	 * @param {TouchEvent} event
	 * @param {string} db
	 */
	function onTouchEnd(event, db) {
		if (event.changedTouches.length) {
			endMove(event.changedTouches[0].clientX, event.changedTouches[0].clientY, db);
		}
	}

	/**
	 * Snaps the moved box to the grid and stores the new positions.
	 *
	 * @param {number} clientX
	 * @param {number} clientY
	 * @param {string} db
	 */
	function endMove(clientX, clientY, db) {
		if (!activeBox) {
			return;
		}

		const box = activeBox;
		activeBox = null;

		if (!dragging) {
			return;
		}

		document.body.classList.remove('moving');

		// The release is followed by a click, which must not open the table name link after dragging.
		const cancelClick = event2 => {
			event2.preventDefault();
			event2.stopPropagation();
		};
		document.addEventListener('click', cancelClick, true);
		setTimeout(() => document.removeEventListener('click', cancelClick, true));

		schema.classList.add('snapping');
		// Forces a style recalculation, otherwise the transition would start with the class already applied and not run.
		void schema.offsetHeight;

		// The position is stored rounded to whole ems, so the box snaps to the same place the page is rendered with.
		const left = Math.round((clientX - x) / pixPerEm);
		const top = Math.round((clientY - y) / pixPerEm);

		moveBox(box, left, top);
		setTimeout(() => schema.classList.remove('snapping'), 100); // The same duration is in the stylesheet.

		tablePos[qs('h4', box).textContent] = [top, left];

		let posString = '';
		for (const key in tablePos) {
			const pos = tablePos[key];
			posString += '_' + key + ':' + Math.round(pos[0]) + 'x' + Math.round(pos[1]);
		}
		posString = encodeURIComponent(posString.slice(1));

		const link = gid('schema-link');
		link.href = link.href.replace(/[^=]+$/, '') + posString;

		cookie('neo_schema-' + db + '=' + posString, 30); // TODO special chars in db
	}
})();
