/** JUSH - JavaScript Syntax Highlighter
* @link https://jush.sourceforge.io/
* @author Jakub Vrana, https://www.vrana.cz
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
*/

/* Limitations:
<style> and <script> supposes CDATA or HTML comments
unnecessary escaping (e.g. echo "\'" or ='&quot;') is removed
*/

var jush = { // var (not const) - consumers such as Adminer check window.jush
	create_links: true, // string for extra <a> parameters, e.g. 'target="_blank"'
	timeout: 1000, // milliseconds
	custom_links: { }, // { state: { url: regexp } }, for example { php : { 'doc/$&.html': /\b(getData|setData)\b/g } }
	api: { }, // { state: { function: description } }, for example { php: { array: 'Create an array' } }

	php: /<\?(?!xml)(?:php)?|<script\s+language\s*=\s*(?:"php"|'php'|php)\s*>/i, // asp_tags=0, short_open_tag=1
	num: /(?:0x[0-9a-f]+)|(?:\b[0-9]+\.?[0-9]*|\.[0-9]+)(?:e[+-]?[0-9]+)?/i,
	embedded: /^(att_js|att_css|att_http|css_js|js_write_code|js_http_code|php_php|php_sql|php_sqlite|php_pgsql|php_mssql|php_oracle|php_echo|php_phpini|php_http|php_mail)$/, // states embedding another language

	regexps: undefined,
	subpatterns: { },

	/** Link stylesheet
	* @param {string} href
	* @param {string} [media]
	*/
	style: function (href, media) {
		const link = document.createElement('link');
		link.rel = 'stylesheet';
		if (media) {
			link.media = media;
		}
		link.href = href;
		document.getElementsByTagName('head')[0].appendChild(link);
	},

	/** Highlight text
	* @param {string} language
	* @param {string} text
	* @return {string}
	*/
	highlight: function (language, text) {
		this.last_tag = '';
		this.last_class = '';
		return '<span class="jush">' + this.highlight_states([ language ], text.replace(/\r\n?/g, '\n'), !/^(htm|tag|xml|txt)$/.test(language))[0] + '</span>';
	},

	/** Highlight html
	* @param {string} language
	* @param {string} html
	* @return {string}
	*/
	highlight_html: function (language, html) {
		const original = html.replace(/<br(\s+[^>]*)?>/gi, '\n');
		let highlighted = jush.highlight(language, jush.html_entity_decode(original.replace(/<[^>]*>/g, '')));

		const inject = { };
		let pos = 0;
		let last_offset = 0;
		original.replace(/(&[^;]+;)|(?:<[^>]+>)+/g, (str, entity, offset) => {
			pos += (offset - last_offset) + (entity ? 1 : 0);
			if (!entity) {
				inject[pos] = str;
			}
			last_offset = offset + str.length;
		});

		pos = 0;
		highlighted = highlighted.replace(/([^&<]*)(?:(&[^;]+;)|(?:<[^>]+>)+|$)/g, (str, text, entity) => {
			for (let i = text.length; i >= 0; i--) {
				if (inject[pos + i]) {
					str = str.slice(0, i) + inject[pos + i] + str.slice(i);
					delete inject[pos + i];
				}
			}
			pos += text.length + (entity ? 1 : 0);
			return str;
		});
		return highlighted;
	},

	/** Highlight text in tags
	* @param {string|HTMLElement[]} tag
	* @param {number} [tab_width=4] number of spaces for tab, 0 for tab itself
	*/
	highlight_tag: function (tag, tab_width = 4) {
		const pre = (typeof tag == 'string' ? [...document.getElementsByTagName(tag)] : tag);
		const tab = ' '.repeat(tab_width);
		let i = 0;
		const highlight = () => {
			const start = Date.now();
			while (i < pre.length) {
				const match = /(^|\s)(?:jush|language(?=-\S))($|\s|-(\S+))/.exec(pre[i].className); // https://www.w3.org/TR/html5/text-level-semantics.html#the-code-element
				if (match) {
					const language = match[3] ? match[3] : 'htm';
					pre[i].innerHTML = '<span class="jush"><span class="jush-' + language + '">' + jush.highlight_html(language, pre[i].innerHTML.replace(/\t/g, tab.length ? tab : '\t')) + '</span></span>'; // span - enable style for class="language-"
				}
				i++;
				if (jush.timeout && window.setTimeout && (Date.now() - start) > jush.timeout) {
					window.setTimeout(highlight, 100);
					break;
				}
			}
		};
		highlight();
	},

	link_manual: function (language, text) {
		const code = document.createElement('code');
		code.innerHTML = this.highlight(language, text);
		for (const a of code.getElementsByTagName('a')) {
			if (a.href) {
				return a.href;
			}
		}
		return '';
	},

	create_link: function (link, s, attrs) {
		return '<a'
			+ (this.create_links && link ? ' href="' + link + '" class="jush-help"' : '')
			+ (typeof this.create_links == 'string' ? ' ' + this.create_links.replace(/^\s+/, '') : '')
			+ (attrs || '')
			+ '>' + s + '</a>'
		;
	},

	keywords_links: function (state, s, next) {
		if (/^js(_write|_code)+$/.test(state)) {
			state = 'js';
		}
		if (/^(php_quo_var|php_php|php_sql|php_sqlite|php_pgsql|php_mssql|php_oracle|php_echo|php_phpini|php_http|php_mail)$/.test(state)) {
			state = 'php2';
		}
		if (state == 'sql_code') {
			state = 'sql';
		}
		if (this.links2 && this.links2[state]) {
			const url = this.urls[state];
			const links2 = this.links2[state];
			const link_key = this.link_key[state];
			const slug = this.slugs[state];
			s = s.replace(links2, function (str, match1) {
				for (let i=arguments.length - 4; i > 1; i--) {
					if (arguments[i]) {
						let key = url[i-1];
						let prefix = ''; // groups of the same path before the linked text, e.g. the dot in .at
						for (let j=i - 1; j > 1 && url[j-1] == url[i-1]; j--) {
							prefix = (arguments[j] || '') + prefix;
						}
						prefix = (match1 ? match1 : '') + prefix;
						if (link_key) {
							key = link_key(key, url);
							if (key == '-') { // the other vendor doesn't know this phrase, it may still know its beginning
								const last_word = arguments[i].search(/\s+\S*$/);
								if (last_word < 0) {
									return str;
								}
								return prefix
									+ jush.keywords_links(state, arguments[i].substring(0, last_word))
									+ arguments[i].substring(last_word)
									+ (arguments[arguments.length - 3] ? arguments[arguments.length - 3] : '')
								;
							}
						}
						let link = (/^https?:/.test(key) || !key ? key : url[0].replace(/\$key/g, key));
						link = (slug ? link.replace(/\$1/g, slug(arguments[i], key, url)) : link.replace(/\$1/g, arguments[i]).replace(/\\/g, '-'));
						let title = '';
						if (jush.api[state]) {
							title = jush.api[state][(state == 'js' ? arguments[i] : arguments[i].toLowerCase())];
						}
						return prefix + jush.create_link(link, arguments[i], (title ? ' title="' + jush.htmlspecialchars_quo(title) + '"' : '')) + (arguments[arguments.length - 3] ? arguments[arguments.length - 3] : '');
					}
				}
			});
		}
		if (this.custom_links[state]) {
			if (Array.isArray(this.custom_links[state])) { // backwards compatibility
				const url = this.custom_links[state][0];
				const re = this.custom_links[state][1];
				this.custom_links[state] = {};
				this.custom_links[state][url] = re;
			}
			next = next || '';
			const append = this.htmlspecialchars(next || ''); // lookahead context, e.g. '"(' following a quoted routine name
			s += append;
			for (const url in this.custom_links[state]) {
				s = s.replace(this.custom_links[state][url], function (str) {
					const offset = arguments[arguments.length - 2];
					if (offset + str.length > s.length - append.length || /<[^>]*$/.test(s.slice(0, offset)) || /^[^<]*<\/a>/.test(s.slice(offset))) {
						return str; // don't create links inside tags or in the appended context
					}
					return '<a href="' + jush.htmlspecialchars_quo(url.replace('$&', encodeURIComponent(str))) + '" class="jush-custom">' + str + '</a>' // not create_link() - ignores create_links
				});
			}
			s = s.substring(0, s.length - append.length);
		}
		return s;
	},

	/** Count capturing subpatterns in a regular expression source
	* @param {string} source
	* @return {number}
	*/
	count_subpatterns: function (source) {
		let in_bra = false;
		let count = 0;
		source.replace(/\\.|\[|]|\((?!\?)/g, str => {
			if (str == (in_bra ? ']' : '[')) {
				in_bra = !in_bra;
			}
			if (str == '(' && !in_bra) { // ( is literal inside []
				count++;
			}
			return str;
		});
		return count;
	},

	build_regexp: function (key, tr1) {
		const re = [ ];
		const subpatterns = [ '' ];
		for (const k in tr1) {
			let in_bra = false;
			for (let i = this.count_subpatterns(tr1[k].source) + 1; i--; ) { // + 1 for the () wrapping the whole subpattern
				subpatterns.push(k);
			}
			const s = tr1[k].source.replace(/\\.|\[|]|([a-z])(?:-([a-z]))?/gi, (str, match1, match2) => {
				if (str == (in_bra ? ']' : '[')) {
					in_bra = !in_bra;
				}
				if (match1 && tr1[k].ignoreCase) {
					if (in_bra) {
						return str.toLowerCase() + str.toUpperCase();
					}
					return '[' + match1.toLowerCase() + match1.toUpperCase() + ']' + (match2 ? '-[' + match2.toLowerCase() + match2.toUpperCase() + ']' : '');
				}
				return str;
			});
			re.push('(' + s + ')');
		}
		this.subpatterns[key] = subpatterns;
		this.regexps[key] = new RegExp(re.join('|'), 'g');
	},

	build_links2: function (key, url, prefix, suffix, paths) {
		this.urls[key] = [url];
		const regexps = [];
		for (const path in paths) {
			for (let i = this.count_subpatterns(paths[path].source); i--; ) { // a path may capture a prefix before the linked text, e.g. the dot in .at
				this.urls[key].push(path);
			}
			regexps.push(paths[path].source);
		}
		this.links2[key] = new RegExp(prefix.source + '(?:' + regexps.join('|') + ')' + suffix.source, suffix.flags);
	},

	highlight_states: function (states, text, in_php, escape) {
		if (!this.regexps) {
			this.regexps = { };
			for (const key in this.tr) {
				this.build_regexp(key, this.tr[key]);
			}
		} else {
			for (const key in this.tr) {
				this.regexps[key].lastIndex = 0;
			}
		}
		let state = states[states.length - 1];
		if (!Object.keys(this.tr[state] || {}).length) {
			return [ this.htmlspecialchars(text), states ];
		}
		const ret = [ ]; // return
		for (let i=1; i < states.length; i++) {
			ret.push('<span class="jush-' + states[i] + '">');
		}
		let match;
		let child_states = [ ];
		let s_states;
		let start = 0;
		while (start < text.length && (match = this.regexps[state].exec(text))) {
			if (states[0] != 'htm' && /^<\/(script|style)>$/i.test(match[0])) {
				continue;
			}
			let key;
			const m = [ ];
			for (let i = match.length; i--; ) {
				if (match[i] || !match[0].length) { // WScript returns empty string even for non matched subexpressions
					key = this.subpatterns[state][i];
					while (this.subpatterns[state][i - 1] == key) {
						i--;
					}
					while (this.subpatterns[state][i] == key) {
						m.push(match[i]);
						i++;
					}
					break;
				}
			}
			if (!key) {
				return [ 'regexp not found', [ ] ];
			}

			if (in_php && key == 'php') {
				continue;
			}
			//~ console.log(states + ' (' + key + '): ' + text.substring(start).replace(/\n/g, '\\n'));
			const out = (key.charAt(0) == '_');
			const division = match.index + (key == 'php_halt2' ? match[0].length : 0);
			let s = text.substring(start, division);

			// highlight children
			let prev_state = states[states.length - 2];
			if (/^(att_quo|att_apo|att_val)$/.test(state) && (/^(att_js|att_css|att_http)$/.test(prev_state) || /^\s*javascript:/i.test(s))) { // javascript: - easy but without own state //! should be checked only in %URI;
				child_states.unshift(prev_state == 'att_css' ? 'css_pro' : (prev_state == 'att_http' ? 'http' : 'js'));
				s_states = this.highlight_states(child_states, this.html_entity_decode(s), true, (state == 'att_apo' ? this.htmlspecialchars_apo : (state == 'att_quo' ? this.htmlspecialchars_quo : this.htmlspecialchars_quo_apo)));
			} else if (state == 'css_js' || state == 'cnf_http' || state == 'cnf_phpini' || state == 'sql_sqlset' || state == 'sqlite_sqliteset' || state == 'pgsql_pgsqlset') {
				child_states.unshift(state.replace(/^[^_]+_/, ''));
				s_states = this.highlight_states(child_states, s, true);
			} else if ((state == 'php_quo' || state == 'php_apo') && /^(php_php|php_sql|php_sqlite|php_pgsql|php_mssql|php_oracle|php_phpini|php_http|php_mail)$/.test(prev_state)) {
				child_states.unshift(prev_state.slice(4));
				s_states = this.highlight_states(child_states, this.stripslashes(s), true, (state == 'php_apo' ? this.addslashes_apo : this.addslashes_quo));
			} else if (key == 'php_halt2') {
				child_states.unshift('htm');
				s_states = this.highlight_states(child_states, s, true);
			} else if ((state == 'apo' || state == 'quo') && prev_state == 'js_write_code') {
				child_states.unshift('htm');
				s_states = this.highlight_states(child_states, s, true);
			} else if ((state == 'apo' || state == 'quo') && prev_state == 'js_http_code') {
				child_states.unshift('http');
				s_states = this.highlight_states(child_states, s, true);
			} else if (((state == 'php_quo' || state == 'php_apo') && prev_state == 'php_echo') || (state == 'php_eot2' && states[states.length - 3] == 'php_echo')) {
				let i; // read after the loop
				for (i=states.length; i--; ) {
					prev_state = states[i];
					if (prev_state.substring(0, 3) != 'php' && prev_state != 'att_quo' && prev_state != 'att_apo' && prev_state != 'att_val') {
						break;
					}
					prev_state = '';
				}
				const f = (state == 'php_eot2' ? this.addslashes : (state == 'php_apo' ? this.addslashes_apo : this.addslashes_quo));
				s = this.stripslashes(s);
				if (/^(att_js|att_css|att_http)$/.test(prev_state)) {
					const g = (states[i+1] == 'att_quo' ? this.htmlspecialchars_quo : (states[i+1] == 'att_apo' ? this.htmlspecialchars_apo : this.htmlspecialchars_quo_apo));
					child_states.unshift(prev_state == 'att_js' ? 'js' : prev_state.slice(4));
					s_states = this.highlight_states(child_states, this.html_entity_decode(s), true, string => f(g(string)));
				} else if (prev_state && child_states) {
					child_states.unshift(prev_state);
					s_states = this.highlight_states(child_states, s, true, f);
				} else {
					s = this.htmlspecialchars(s);
					s_states = [ (escape ? escape(s) : s), (!out || !this.embedded.test(state) ? child_states : [ ]) ];
				}
			} else {
				s = this.htmlspecialchars(s);
				s_states = [ (escape ? escape(s) : s), (!out || !this.embedded.test(state) ? child_states : [ ]) ]; // reset child states when leaving construct
			}
			s = s_states[0];
			child_states = s_states[1];
			s = this.keywords_links(state, s, text.slice(match.index, match.index + 2)); // 2 - lookahead for closing quote plus parenthesis
			ret.push(s);

			s = text.substring(division, match.index + match[0].length);
			// a keyword can leave the state (e.g. DO in MySQL) - link it instead of printing it as an operator
			const keyword = (out && /\w/.test(s) ? this.keywords_links(state, this.htmlspecialchars(escape ? escape(s) : s)) : '');
			s = (/<a/.test(keyword) ? keyword : (m.length < 3 ? (s ? '<span class="jush-op">' + this.htmlspecialchars(escape ? escape(s) : s) + '</span>' : '') : (m[1] ? '<span class="jush-op">' + this.htmlspecialchars(escape ? escape(m[1]) : m[1]) + '</span>' : '') + this.htmlspecialchars(escape ? escape(m[2]) : m[2]) + (m[3] ? '<span class="jush-op">' + this.htmlspecialchars(escape ? escape(m[3]) : m[3]) + '</span>' : '')));
			if (!out) {
				if (this.links && this.links[key] && m[2]) {
					if (/^tag/.test(key)) {
						this.last_tag = m[2].toLowerCase();
					}
					let link = m[2].toLowerCase();
					let k_link = '';
					for (const k in this.links[key]) {
						const m2 = this.links[key][k].exec(m[2]);
						if (m2) {
							if (m2[1]) {
								link = (key == 'js_http' ? m2[1] : m2[1].toLowerCase().replace(/\\/g, '-')); // \ is PHP namespace
							}
							k_link = k;
							if (key != 'att') {
								break;
							}
						}
					}
					if (key == 'php_met') {
						this.last_class = (k_link && !/^(self|parent|static|dir)$/i.test(link) ? link : '');
					}
					if (k_link) {
						s = (m[1] ? '<span class="jush-op">' + this.htmlspecialchars(escape ? escape(m[1]) : m[1]) + '</span>' : '');
						s += this.create_link(
							(/^https?:/.test(k_link) ? k_link : this.urls[key].replace(/\$key/, k_link))
								.replace(/\$val/, (/^https?:/.test(k_link) ? link.toLowerCase() : link))
								.replace(/\$tag/, this.last_tag),
							this.htmlspecialchars(escape ? escape(m[2]) : m[2])); //! use jush.api
						s += (m[3] ? '<span class="jush-op">' + this.htmlspecialchars(escape ? escape(m[3]) : m[3]) + '</span>' : '');
					}
				}
				ret.push('<span class="jush-' + key + '">', s);
				states.push(key);
				if (state == 'php_eot') {
					this.tr.php_eot2._2 = new RegExp('(\n)(' + match[2] + ')(?=;?\n)');
					this.build_regexp('php_eot2', (match[3] == "'" ? { _2: this.tr.php_eot2._2 } : this.tr.php_eot2));
				} else if (state == 'pgsql_eot') {
					this.tr.pgsql_eot2._2 = new RegExp('\\$' + match[0].replace(/\$/, '\\$'));
					this.build_regexp('pgsql_eot2', this.tr.pgsql_eot2);
				}
			} else {
				if (state == 'php_met' && this.last_class) {
					const title = (jush.api['php2'] ? jush.api['php2'][(this.last_class + '::' + s).toLowerCase()] : '');
					s = this.create_link(this.urls[state].replace(/\$key/, this.last_class) + '.' + s.toLowerCase().replace(/^__/, ''), s, (title ? ' title="' + this.htmlspecialchars_quo(title) + '"' : ''));
				}
				ret.push(s);
				for (let i = Math.min(states.length, +key.slice(1)); i--; ) {
					ret.push('</span>');
					states.pop();
				}
			}
			start = match.index + match[0].length;
			if (!states.length) { // out of states
				break;
			}
			state = states[states.length - 1];
			this.regexps[state].lastIndex = start;
		}
		ret.push(this.keywords_links(state, this.htmlspecialchars(text.substring(start))));
		for (let i=1; i < states.length; i++) {
			ret.push('</span>');
		}
		states.shift();
		return [ ret.join(''), states ];
	},

	/** Replace <&> by HTML entities
	* @param {string} string
	* @return {string}
	*/
	htmlspecialchars: function (string) {
		return string.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
	},

	htmlspecialchars_quo: function (string) {
		return jush.htmlspecialchars(string).replace(/"/g, '&quot;'); // jush - this.htmlspecialchars_quo is passed as reference
	},

	htmlspecialchars_apo: function (string) {
		return jush.htmlspecialchars(string).replace(/'/g, '&#39;');
	},

	htmlspecialchars_quo_apo: function (string) {
		return jush.htmlspecialchars_quo(string).replace(/'/g, '&#39;');
	},

	/** Decode HTML entities
	* @param {string} string
	* @return {string}
	*/
	html_entity_decode: function (string) {
		return string.replace(/&lt;/g, '<').replace(/&gt;/g, '>').replace(/&quot;/g, '"').replace(/&nbsp;/g, '\u00A0').replace(/&#(?:([0-9]+)|x([0-9a-f]+));/gi, (str, p1, p2) => { //! named entities
			return String.fromCharCode(p1 ? p1 : parseInt(p2, 16));
		}).replace(/&amp;/g, '&');
	},

	/** Add backslash before backslash
	* @param {string} string
	* @return {string}
	*/
	addslashes: function (string) {
		return string.replace(/\\/g, '\\$&');
	},

	addslashes_apo: function (string) {
		return string.replace(/[\\']/g, '\\$&');
	},

	addslashes_quo: function (string) {
		return string.replace(/[\\"]/g, '\\$&');
	},

	/** Remove backslash before \"'
	* @param {string} string
	* @return {string}
	*/
	stripslashes: function (string) {
		return string.replace(/\\([\\"'])/g, '$1');
	}
};



jush.tr = { // transitions - key: go inside this state, _2: go outside 2 levels (number alone is put to the beginning in Chrome)
	// regular expressions matching empty string could be used only in the last key
	quo: { php: jush.php, esc: /\\/, _1: /"/ },
	apo: { php: jush.php, esc: /\\/, _1: /'/ },
	com: { php: jush.php, _1: /\*\// },
	com_nest: { com_nest: /\/\*/, _1: /\*\// },
	php: { _1: /\?>/ }, // overwritten by jush-php.js
	esc: { _1: /./ }, //! php_quo allows [0-7]{1,3} and x[0-9A-Fa-f]{1,2}
	one: { _1: /(?=\n)/ },
	num: { _1: /()/ },

	sql_apo: { esc: /\\/, _0: /''/, _1: /'/ },
	sql_quo: { esc: /\\/, _0: /""/, _1: /"/ },
	sql_var: { _1: /(?=[^_.$a-zA-Z0-9])/ },
	sqlite_apo: { _0: /''/, _1: /'/ },
	sqlite_quo: { _0: /""/, _1: /"/ },
	bac: { _1: /`/ },
	bra: { _1: /]/ }
};

// string: $key stands for key in jush.links, $val stands for found string
// array: [0] is base, other elements correspond to () in jush.links2, $key stands for text of selected element, $1 stands for found string
jush.urls = { };
jush.links = { };
jush.links2 = { }; // first and last () is used as delimiter
jush.slugs = { }; // { state: function (name, key, url) } returning the $1 replacement in doc links; default keeps name with \ replaced by -
jush.link_key = { }; // { state: function (key, url) } resolving the matched key in jush.urls; '-' means no link
