'use strict';

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

	/**
	 * Checks whether a row is being dragged.
	 *
	 * @return {boolean}
	 */
	window.isSorting = function() {
		return dragHelper !== null;
	};

	/**
	 * Starts dragging of the row.
	 *
	 * @param {HTMLElement} row
	 * @param {MouseEvent|TouchEvent} event
	 */
	function startSorting(row, event) {
		event.preventDefault();

		const pointerY = getPointerY(event);

		const parent = row.parentElement;
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
		dragHelper.style.background = window.getComputedStyle(row.closest("fieldset, table")).backgroundColor;
		dragHelper.classList.add("dragging");
		document.body.append(dragHelper);

		window.addEventListener("mousemove", updateSorting);
		window.addEventListener("touchmove", updateSorting);
		window.addEventListener("scroll", updateSorting);

		window.addEventListener("mouseup", finishSorting);
		window.addEventListener("touchend", finishSorting);
		window.addEventListener("touchcancel", finishSorting);
	}

	/**
	 * Moves the dragged row to the pointer position and places the placeholder to a new position.
	 *
	 * @param {Event} event Mouse, touch or scroll event.
	 */
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
		const parent = placeholderRow.parentElement;
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

	/**
	 * Drops the dragged row to the position of the placeholder.
	 */
	function finishSorting() {
		dragHelper.classList.remove("dragging");
		dragHelper.style.top = null;
		dragHelper.style.left = null;
		dragHelper.style.width = null;
		dragHelper.style.background = null;

		dragHelper.remove();

		placeholderRow.parentElement.insertBefore(
			dragHelper.tagName === "TABLE" ? dragHelper.firstElementChild.firstElementChild : dragHelper,
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

	/**
	 * Returns the vertical pointer position.
	 *
	 * @param {Event} event Mouse, touch or scroll event.
	 *
	 * @return {number} The last known position for events without pointer coordinates.
	 */
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
