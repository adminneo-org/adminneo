'use strict';

(() => {
	let openTimeout = null;
	let closeTimeout = null;
	let helpVisible = false;

	/**
	 * Initializes the help popup so it stays visible while the pointer is over it.
	 */
	window.initHelpPopup = function() {
		const help = gid("help");

		help.addEventListener("mouseenter", () => {
			clearTimeout(closeTimeout);
			closeTimeout = null;
		});

		help.addEventListener("mouseleave", hideHelp);
	};

	/**
	 * Installs help popup handlers for the element.
	 *
	 * @param {HTMLElement} element
	 * @param {string|function} content
	 * @param {boolean} [side] Displays on left side (otherwise on top).
	 */
	window.initHelpFor = function(element, content, side = false) {
		const withCallback = typeof content === "function";

		element.addEventListener("mouseenter", event => {
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
	 * @param {boolean} side Displays on left side (otherwise on top).
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
