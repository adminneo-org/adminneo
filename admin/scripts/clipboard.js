'use strict';

(() => {
	let copyLink, formatList, toggle;
	let iconTimeout = null;

	/**
	 * Initializes Copy table structure link.
	 */
	window.initCopyTableStructure = function() {
		copyLink = gid("copy-table-structure");
		formatList = gid("format-list");
		toggle = qs("a.toggle[href='#format-list']");

		// Clipboard API is available only in a secure context.
		if (!navigator.clipboard) {
			copyLink.remove();
			if (formatList) {
				toggle.remove();
				formatList.remove();
			}
			return;
		}

		copyLink.addEventListener("click", event => {
			copyStructure();

			event.preventDefault();
		});

		// The format list is missing if there is only one format.
		if (!formatList) {
			return;
		}

		for (const link of qsa("a", formatList)) {
			link.addEventListener("click", event => {
				copyLink.href = link.href;
				qs("span", copyLink).textContent = link.textContent;

				formatList.classList.add("hidden");
				toggle.classList.remove("opened");

				copyStructure();

				event.preventDefault();
			});
		}

		// The list is shown by initToggles() before this listener is called.
		toggle.addEventListener("click", alignFormatList);

		// Clicks on the toggle link do not get here, initToggles() stops their propagation.
		document.addEventListener("click", event => {
			if (!formatList.contains(event.target)) {
				formatList.classList.add("hidden");
				toggle.classList.remove("opened");
			}
		});
	};

	/**
	 * Aligns the end of the format list to the end of its toggle link.
	 */
	function alignFormatList() {
		if (formatList.classList.contains("hidden")) {
			return;
		}

		formatList.style.transform = "";

		const toggleRect = toggle.getBoundingClientRect();
		const listRect = formatList.getBoundingClientRect();
		const shift = document.documentElement.classList.contains("rtl") ? toggleRect.left - listRect.left : toggleRect.right - listRect.right;

		formatList.style.transform = "translateX(" + shift + "px)";
	}

	/**
	 * Copies the table structure in the selected format to the clipboard.
	 */
	function copyStructure() {
		copyToClipboard(loadText(copyLink.href))
			.then(() => {
				clearTimeout(iconTimeout);
				setIcon(copyLink, "check");

				iconTimeout = setTimeout(() => {
					setIcon(copyLink, "copy");
				}, 2000);
			})
			.catch(error => {
				// A failed request is already reported by ajax().
				if (error) {
					console.error(error);
				}
			});
	}

	/**
	 * Loads the text by AJAX request.
	 *
	 * @param {string} url
	 *
	 * @return {Promise<string>} Rejected without a reason if the request fails.
	 */
	function loadText(url) {
		return new Promise((resolve, reject) => {
			const request = ajax(url);

			request.addEventListener("loadend", () => {
				if (request.status >= 200 && request.status < 300) {
					resolve(request.responseText.trim());
				} else {
					reject();
				}
			});
		});
	}

	/**
	 * Writes the text to the clipboard.
	 *
	 * @param {Promise<string>} text
	 *
	 * @return {Promise}
	 */
	function copyToClipboard(text) {
		// Safari allows to write only during the click, so the pending text is passed to the clipboard immediately.
		if (window.ClipboardItem) {
			const blob = text.then(value => new Blob([value], {type: "text/plain"}));

			return navigator.clipboard.write([new ClipboardItem({"text/plain": blob})]);
		}

		return text.then(value => navigator.clipboard.writeText(value));
	}

	/**
	 * Replaces the icon in the element.
	 *
	 * @param {HTMLElement} element
	 * @param {string} id Icon ID.
	 */
	function setIcon(element, id) {
		const icon = qs("svg.icon", element);
		const use = qs("use", icon);

		icon.setAttribute("class", icon.getAttribute("class").replace(/\bic-\S+/, "ic-" + id));
		use.setAttribute("href", use.getAttribute("href").replace(/#.*/, "#" + id));
	}
})();
