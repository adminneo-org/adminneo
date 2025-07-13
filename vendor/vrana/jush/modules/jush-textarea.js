jush.textarea = (function () {
	//! IE sometimes inserts empty <p> in start of a string when newline is entered inside
	
	function findSelPos(pre) {
		var sel = getSelection();
		if (sel.rangeCount) {
			var range = sel.getRangeAt(0);
			return findPosition(pre, range.startContainer, range.startOffset);
		}
	}

	function findPosition(el, container, offset) {
		var pos = { pos: 0 };
		findPositionRecurse(el, container, offset, pos);
		return pos.pos;
	}

	function findPositionRecurse(child, container, offset, pos) {
		if (child.nodeType == 3) {
			if (child == container) {
				pos.pos += offset;
				return true;
			}
			pos.pos += child.textContent.length;
		} else if (child == container) {
			for (var i = 0; i < offset; i++) {
				findPositionRecurse(child.childNodes[i], container, offset, pos);
			}
			return true;
		} else {
			if (/^(br|div)$/i.test(child.tagName)) {
				pos.pos++;
			}
			for (var i = 0; i < child.childNodes.length; i++) {
				if (findPositionRecurse(child.childNodes[i], container, offset, pos)) {
					return true;
				}
			}
			if (/^p$/i.test(child.tagName)) {
				pos.pos++;
			}
		}
	}
	
	function findOffset(el, pos) {
		return findOffsetRecurse(el, { pos: pos });
	}
	
	function findOffsetRecurse(child, pos) {
		if (child.nodeType == 3) { // 3 - TEXT_NODE
			if (child.textContent.length >= pos.pos) {
				return { container: child, offset: pos.pos };
			}
			pos.pos -= child.textContent.length;
		} else {
			for (var i = 0; i < child.childNodes.length; i++) {
				if (/^br$/i.test(child.childNodes[i].tagName)) {
					if (!pos.pos) {
						return { container: child, offset: i };
					}
					pos.pos--;
					if (!pos.pos && i == child.childNodes.length - 1) { // last invisible <br>
						return { container: child, offset: i };
					}
				} else {
					var result = findOffsetRecurse(child.childNodes[i], pos);
					if (result) {
						return result;
					}
				}
			}
		}
	}
	
	function setSelPos(pre, pos) {
		if (pos) {
			var start = findOffset(pre, pos);
			if (start) {
				var range = document.createRange();
				range.setStart(start.container, start.offset);
				var sel = getSelection();
				sel.removeAllRanges();
				sel.addRange(range);
			}
		}
	}

	function setText(pre, text, end) {
		var lang = 'txt';
		if (text.length < 1e4) { // highlighting is slow with most languages
			var match = /(^|\s)(?:jush|language)-(\S+)/.exec(pre.jushTextarea.className);
			lang = (match ? match[2] : 'htm');
		}
		var html = jush.highlight(lang, text).replace(/\n/g, '<br>');
		setHTML(pre, html, text, end);
		if (openAc) {
			openAutocomplete(pre);
			openAc = false;
		} else {
			closeAutocomplete();
		}
	}
	
	function setHTML(pre, html, text, pos) {
		pre.innerHTML = html;
		pre.lastHTML = pre.innerHTML; // not html because IE reformats the string
		pre.jushTextarea.value = text;
		setSelPos(pre, pos);
	}
	
	function keydown(event) {
		const ctrl = (event.ctrlKey || event.metaKey);
		if (!event.altKey) {
			if (!ctrl && acEl.options.length) {
				const select =
					(event.key == 'ArrowDown' ? Math.min(acEl.options.length - 1, acEl.selectedIndex + 1) :
					(event.key == 'ArrowUp' ? Math.max(0, acEl.selectedIndex - 1) :
					(event.key == 'PageDown' ? Math.min(acEl.options.length - 1, acEl.selectedIndex + acEl.size) :
					(event.key == 'PageUp' ? Math.max(0, acEl.selectedIndex - acEl.size) :
					null))))
				;
				if (select !== null) {
					acEl.selectedIndex = select;
					return false;
				}
				if (/^(Enter|Tab)$/.test(event.key) && !event.shiftKey) {
					insertAutocomplete(this);
					return false;
				}
			}
			
			if (ctrl) {
				if (event.key == ' ') {
					openAutocomplete(this);
				}
			} else if (autocomplete.openBy && (autocomplete.openBy.test(event.key) || event.key == 'Backspace' || (event.key == 'Enter' && event.shiftKey))) {
				openAc = true;
			} else if (/^(Escape|ArrowLeft|ArrowRight|Home|End)$/.test(event.key)) {
				closeAutocomplete();
			}
		}
		
		if (ctrl && !event.altKey) {
			var isUndo = (event.keyCode == 90); // 90 - z
			var isRedo = (event.keyCode == 89 || (event.keyCode == 90 && event.shiftKey)); // 89 - y
			if (isUndo || isRedo) {
				if (isRedo) {
					if (this.jushUndoPos + 1 < this.jushUndo.length) {
						this.jushUndoPos++;
						var undo = this.jushUndo[this.jushUndoPos];
						setText(this, undo.text, undo.end)
					}
				} else if (this.jushUndoPos >= 0) {
					this.jushUndoPos--;
					var undo = this.jushUndo[this.jushUndoPos] || { html: '', text: '' };
					setText(this, undo.text, this.jushUndo[this.jushUndoPos + 1].start);
				}
				return false;
			}
		} else {
			setLastPos(this);
		}
	}
	
	const maxSize = 8;
	const acEl = document.createElement('select');
	acEl.size = maxSize;
	acEl.className = 'jush-autocomplete';
	acEl.style.position = 'absolute';
	acEl.style.zIndex = 1;
	acEl.onclick = () => {
		insertAutocomplete(pre);
	};
	openAc = false;
	closeAutocomplete();

	function findState(node) {
		let match;
		while (node && (!/^(CODE|PRE)$/.test(node.tagName) || !(match = node.className.match(/(^|\s)jush-(\w+)/)))) {
			node = node.parentElement;
		}
		return (match ? match[2] : '');
	}

	function openAutocomplete(pre) {
		const prevSelected = acEl.options[acEl.selectedIndex];
		closeAutocomplete();
		const sel = getSelection();
		if (sel.rangeCount) {
			const range = sel.getRangeAt(0);
			const pos = findSelPos(pre);
			const state = findState(range.startContainer);
			if (state) {
				const ac = autocomplete(
					state,
					pre.innerText.substring(0, pos),
					pre.innerText.substring(pos)
				);
				if (Object.keys(ac).length) {
					let select = 0;
					for (const word in ac) {
						const option = document.createElement('option');
						option.value = ac[word];
						option.textContent = word;
						acEl.append(option);
						if (prevSelected && prevSelected.textContent == word) {
							select = acEl.options.length - 1;
						}
					}
					acEl.selectedIndex = select;
					acEl.size = Math.min(Math.max(acEl.options.length, 2), maxSize);
					positionAutocomplete();
					acEl.style.display = '';
				}
			}
		}
	}
	
	function positionAutocomplete() {
		const sel = getSelection();
		if (sel.rangeCount && acEl.options.length) {
			const pos = findSelPos(pre);
			const range = sel.getRangeAt(0);
			const range2 = range.cloneRange();
			range2.setStart(range.startContainer, Math.max(0, range.startOffset - acEl.options[0].value)); // autocompletions currently couldn't cross container boundary
			const span = document.createElement('span'); // collapsed ranges have empty bounding rect
			range2.insertNode(span);
			acEl.style.left = span.offsetLeft + 'px';
			acEl.style.top = (span.offsetTop + 20) + 'px';
			span.remove();
			setSelPos(pre, pos); // required on iOS
		}
	}
	
	function closeAutocomplete() {
		acEl.options.length = 0;
		acEl.style.display = 'none';
	}
	
	function insertAutocomplete(pre) {
		const sel = getSelection();
		const range = sel.rangeCount && sel.getRangeAt(0);
		if (range) {
			const insert = acEl.options[acEl.selectedIndex].textContent;
			const offset = +acEl.options[acEl.selectedIndex].value;
			forceNewUndo = true;
			pre.lastPos = findSelPos(pre);
			const start = findOffset(pre, pre.lastPos - offset);
			range.setStart(start.container, start.offset);
			document.execCommand('insertText', false, insert);
			openAutocomplete(pre);
		}
	}
	
	function setLastPos(pre) {
		if (pre.lastPos === undefined) {
			pre.lastPos = findSelPos(pre);
		}
	}
	
	var forceNewUndo = true;
	
	function highlight(pre) {
		var start = pre.lastPos;
		pre.lastPos = undefined;
		var innerHTML = pre.innerHTML;
		if (innerHTML != pre.lastHTML) {
			var end = findSelPos(pre);
			innerHTML = innerHTML.replace(/<br>((<\/[^>]+>)*<\/?div>)(?!$)/gi, function (all, rest) {
				if (end) {
					end--;
				}
				return rest;
			});
			pre.innerHTML = innerHTML
				.replace(/<(br|div)\b[^>]*>/gi, '\n') // Firefox, Chrome
				.replace(/&nbsp;(<\/[pP]\b)/g, '$1') // IE
				.replace(/<\/p\b[^>]*>($|<p\b[^>]*>)/gi, '\n') // IE
				.replace(/(&nbsp;)+$/gm, '') // Chrome for some users
			;
			setText(pre, pre.textContent.replace(/\u00A0/g, ' '), end);
			pre.jushUndo.length = pre.jushUndoPos + 1;
			if (forceNewUndo || !pre.jushUndo.length || pre.jushUndo[pre.jushUndoPos].end !== start) {
				pre.jushUndo.push({ text: pre.jushTextarea.value, start: start, end: (forceNewUndo ? undefined : end) });
				pre.jushUndoPos++;
				forceNewUndo = false;
			} else {
				pre.jushUndo[pre.jushUndoPos].text = pre.jushTextarea.value;
				pre.jushUndo[pre.jushUndoPos].end = end;
			}
		}
	}
	
	function input() {
		highlight(this);
	}
	
	function paste(event) {
		if (event.clipboardData) {
			setLastPos(this);
			if (document.execCommand('insertHTML', false, jush.htmlspecialchars(event.clipboardData.getData('text')))) { // Opera doesn't support insertText
				event.preventDefault();
			}
			forceNewUndo = true; // highlighted in input
		}
	}
	
	function click(event) {
		if ((event.ctrlKey || event.metaKey) && event.target.href) {
			open(event.target.href);
		}
		closeAutocomplete();
	}
	
	let pre;
	let autocomplete = () => ({});
	addEventListener('resize', positionAutocomplete);
	
	return function textarea(el, autocompleter) {
		if (!window.getSelection) {
			return;
		}
		if (autocompleter) {
			autocomplete = autocompleter;
		}
		pre = document.createElement('pre');
		pre.contentEditable = true;
		pre.className = el.className + ' jush';
		pre.style.border = '1px inset #ccc';
		pre.style.width = el.clientWidth + 'px';
		pre.style.height = el.clientHeight + 'px';
		pre.style.padding = '3px';
		pre.style.overflow = 'auto';
		pre.style.resize = 'both';
		if (el.wrap != 'off') {
			pre.style.whiteSpace = 'pre-wrap';
		}
		pre.jushTextarea = el;
		pre.jushUndo = [ ];
		pre.jushUndoPos = -1;
		pre.onkeydown = keydown;
		pre.oninput = input;
		pre.onpaste = paste;
		pre.onclick = click;
		pre.appendChild(document.createTextNode(el.value));
		highlight(pre);
		if (el.spellcheck === false) {
			pre.spellcheck = false;
		}
		el.before(pre);
		el.before(acEl);
		if (document.activeElement === el) {
			pre.focus();
			if (!el.value) {
				openAutocomplete(pre);
			}
		}
		acEl.style.font = getComputedStyle(pre).font;
		el.style.display = 'none';
		return pre;
	};
})();
