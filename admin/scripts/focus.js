(() => {
	const focusableSelector = "a, button, input:not([type='hidden']), select, textarea";

	/** @type {?HTMLElement} */
	let focusTrapParent = null;

	/**
	 * Keeps the keyboard focus inside the given element. Tabbing from its .focus-trap-end sentinel
	 * moves the focus to the first focusable element, tabbing backwards from .focus-trap-begin to the last one.
	 *
	 * @param {HTMLElement} parent
	 */
	window.enableFocusTrap = function (parent) {
		disableFocusTrap();

		for (const sentinel of qsa(".focus-trap-begin", parent)) {
			sentinel.tabIndex = 0;
			sentinel.addEventListener("focus", focusLast);
		}
		for (const sentinel of qsa(".focus-trap-end", parent)) {
			sentinel.tabIndex = 0;
			sentinel.addEventListener("focus", focusFirst);
		}

		focusTrapParent = parent;
	};

	/**
	 * Releases the focus trap enabled by enableFocusTrap().
	 */
	window.disableFocusTrap = function () {
		if (!focusTrapParent) {
			return;
		}

		for (const sentinel of qsa(".focus-trap-begin", focusTrapParent)) {
			sentinel.tabIndex = -1;
			sentinel.removeEventListener("focus", focusLast);
		}
		for (const sentinel of qsa(".focus-trap-end", focusTrapParent)) {
			sentinel.tabIndex = -1;
			sentinel.removeEventListener("focus", focusFirst);
		}

		focusTrapParent = null;
	};

	function focusFirst() {
		const el = qs(focusableSelector, focusTrapParent);
		if (el) {
			el.focus();
		}
	}

	function focusLast() {
		const el = qsl(focusableSelector, focusTrapParent);
		if (el) {
			el.focus();
		}
	}
})();
