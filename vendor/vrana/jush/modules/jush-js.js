jush.tr.js = { php: jush.php, js_reg: /\s*\/(?![\/*])/, js_obj: /\s*\{/, _1: /}/, js_code: /()/ };
jush.tr.js_code = { php: jush.php, quo: /"/, apo: /'/, js_bac: /`/, js_one: /\/\//, js_doc: /\/\*\*/, com: /\/\*/, num: jush.num, js_write: /(\b)(write(?:ln)?)(\()/, js_http: /(\.)(setRequestHeader|getResponseHeader)(\()/, js: /\{/, _3: /(<)(\/script)(>)/i, _2: /}/, _1: /[^.\])}$\w\s]/ };
jush.tr.js_write = { php: jush.php, js_reg: /\s*\/(?![\/*])/, js_write_code: /()/ };
jush.tr.js_http = { php: jush.php, js_reg: /\s*\/(?![\/*])/, js_http_code: /()/ };
jush.tr.js_write_code = { php: jush.php, quo: /"/, apo: /'/, js_bac: /`/, js_one: /\/\//, com: /\/\*/, num: jush.num, js_write: /\(/, _2: /\)/, _1: /[^\])}$\w\s]/ };
jush.tr.js_http_code = { php: jush.php, quo: /"/, apo: /'/, js_bac: /`/, js_one: /\/\//, com: /\/\*/, num: jush.num, js_http: /\(/, _2: /\)/, _1: /[^\])}$\w\s]/ };
jush.tr.js_one = { php: jush.php, _1: /\n/, _3: /(<)(\/script)(>)/i };
jush.tr.js_reg = { php: jush.php, esc: /\\/, js_reg_bra: /\[/, _1: /\/[a-z]*/i }; //! highlight regexp
jush.tr.js_reg_bra = { php: jush.php, esc: /\\/, _1: /]/ };
jush.tr.js_doc = { _1: /\*\// };
jush.tr.js_arr = { php: jush.php, quo: /"/, apo: /'/, js_bac: /`/, js_one: /\/\//, com: /\/\*/, num: jush.num, js_arr: /\[/, js_obj: /\{/, _1: /]/ };
jush.tr.js_obj = { php: jush.php, js_one: /\s*\/\//, com: /\s*\/\*/, js_val: /:/, _1: /\s*}/, js_key: /()/ };
jush.tr.js_val = { php: jush.php, quo: /"/, apo: /'/, js_bac: /`/, js_one: /\/\//, com: /\/\*/, num: jush.num, js_arr: /\[/, js_obj: /\{/, _1: /,|(?=})/ };
jush.tr.js_key = { php: jush.php, quo: /"/, apo: /'/, js_bac: /`/, js_one: /\/\//, com: /\/\*/, num: jush.num, _1: /(?=[:}])/ };
jush.tr.js_bac = { php: jush.php, esc: /\\/, js: /\$\{/, _1: /`/ };

jush.urls.js_write = 'https://developer.mozilla.org/en/docs/DOM/$key.$val';
jush.urls.js_http = 'https://developer.mozilla.org/en-US/docs/Web/API/XMLHttpRequest/$val';

jush.links.js_write = { 'document': /^(write|writeln)$/ };
jush.links.js_http = { 'method': /^(setRequestHeader|getResponseHeader)$/ };

jush.slugs.js = name => name.replace(/\./g, '/');
jush.slugs.js_doc = name => name.replace(/^@/, '');

// (\.) must be first so that e.g. .name is still looked up from the top; (?=\.) is for a dot not preceded by a word character, e.g. [].at
jush.build_links2('js', 'https://developer.mozilla.org/en/$key', /(\.|\b|(?=\.))/, /(\b)/g, {
	'JavaScript/Reference/Global_Objects/$1': /(ArrayBuffer\.isView|Array\.from|Array\.fromAsync|Array\.isArray|Array\.of|Atomics\.add|Atomics\.and|Atomics\.compareExchange|Atomics\.exchange|Atomics\.isLockFree|Atomics\.load|Atomics\.notify|Atomics\.or|Atomics\.pause|Atomics\.store|Atomics\.sub|Atomics\.wait|Atomics\.waitAsync|Atomics\.xor|BigInt\.asIntN|BigInt\.asUintN|Date\.UTC|Date\.now|Date\.parse|Error\.captureStackTrace|Error\.isError|Error\.stackTraceLimit|Intl\.getCanonicalLocales|Intl\.supportedValuesOf|Iterator\.concat|Iterator\.from|Iterator\.zip|Iterator\.zipKeyed|JSON\.isRawJSON|JSON\.parse|JSON\.rawJSON|JSON\.stringify|Map\.groupBy|Math\.E|Math\.LN10|Math\.LN2|Math\.LOG10E|Math\.LOG2E|Math\.PI|Math\.SQRT1_2|Math\.SQRT2|Math\.abs|Math\.acos|Math\.acosh|Math\.asin|Math\.asinh|Math\.atan|Math\.atan2|Math\.atanh|Math\.cbrt|Math\.ceil|Math\.clz32|Math\.cos|Math\.cosh|Math\.exp|Math\.expm1|Math\.f16round|Math\.floor|Math\.fround|Math\.hypot|Math\.imul|Math\.log|Math\.log10|Math\.log1p|Math\.log2|Math\.max|Math\.min|Math\.pow|Math\.random|Math\.round|Math\.sign|Math\.sin|Math\.sinh|Math\.sqrt|Math\.sumPrecise|Math\.tan|Math\.tanh|Math\.trunc|Number\.EPSILON|Number\.MAX_SAFE_INTEGER|Number\.MAX_VALUE|Number\.MIN_SAFE_INTEGER|Number\.MIN_VALUE|Number\.NEGATIVE_INFINITY|Number\.NaN|Number\.POSITIVE_INFINITY|Number\.isFinite|Number\.isInteger|Number\.isNaN|Number\.isSafeInteger|Number\.parseFloat|Number\.parseInt|Object\.assign|Object\.create|Object\.defineProperties|Object\.defineProperty|Object\.entries|Object\.freeze|Object\.fromEntries|Object\.getOwnPropertyDescriptor|Object\.getOwnPropertyDescriptors|Object\.getOwnPropertyNames|Object\.getOwnPropertySymbols|Object\.getPrototypeOf|Object\.groupBy|Object\.hasOwn|Object\.is|Object\.isExtensible|Object\.isFrozen|Object\.isSealed|Object\.keys|Object\.preventExtensions|Object\.seal|Object\.setPrototypeOf|Object\.values|Promise\.all|Promise\.allSettled|Promise\.any|Promise\.race|Promise\.reject|Promise\.resolve|Promise\.try|Promise\.withResolvers|Proxy\.revocable|Reflect\.apply|Reflect\.construct|Reflect\.defineProperty|Reflect\.deleteProperty|Reflect\.get|Reflect\.getOwnPropertyDescriptor|Reflect\.getPrototypeOf|Reflect\.has|Reflect\.isExtensible|Reflect\.ownKeys|Reflect\.preventExtensions|Reflect\.set|Reflect\.setPrototypeOf|RegExp\.escape|RegExp\.input|RegExp\.lastMatch|RegExp\.lastParen|RegExp\.leftContext|RegExp\.n|RegExp\.rightContext|String\.fromCharCode|String\.fromCodePoint|String\.raw|Symbol\.asyncDispose|Symbol\.asyncIterator|Symbol\.dispose|Symbol\.for|Symbol\.hasInstance|Symbol\.isConcatSpreadable|Symbol\.iterator|Symbol\.keyFor|Symbol\.match|Symbol\.matchAll|Symbol\.replace|Symbol\.search|Symbol\.species|Symbol\.split|Symbol\.toPrimitive|Symbol\.toStringTag|Symbol\.unscopables|TypedArray\.BYTES_PER_ELEMENT|TypedArray\.from|TypedArray\.of|Uint8Array\.fromBase64|Uint8Array\.fromHex|AggregateError|Array|ArrayBuffer|AsyncDisposableStack|AsyncFunction|AsyncGenerator|AsyncGeneratorFunction|AsyncIterator|Atomics|BigInt|BigInt64Array|BigUint64Array|Boolean|DataView|Date|DisposableStack|Error|EvalError|FinalizationRegistry|Float16Array|Float32Array|Float64Array|Function|Generator|GeneratorFunction|Infinity|Int16Array|Int32Array|Int8Array|InternalError|Intl|Iterator|JSON|Map|Math|NaN|Number|Object|Promise|Proxy|RangeError|ReferenceError|Reflect|RegExp|Set|SharedArrayBuffer|String|SuppressedError|Symbol|SyntaxError|Temporal|TypeError|TypedArray|URIError|Uint16Array|Uint32Array|Uint8Array|Uint8ClampedArray|WeakMap|WeakRef|WeakSet|decodeURI|decodeURIComponent|encodeURI|encodeURIComponent|escape|eval|globalThis|isFinite|isNaN|parseFloat|parseInt|undefined|unescape)/,
	'JavaScript/Reference/Statements/$1': /(break|class|const|continue|debugger|export|for|function|import|let|return|switch|throw|using|var|while|with)/,
	'JavaScript/Reference/Statements/do...while': /(do)/,
	'JavaScript/Reference/Statements/if...else': /(if|else)/,
	'JavaScript/Reference/Statements/try...catch': /(try|catch|finally)/,
	'JavaScript/Reference/Operators/Special/$1': /(delete|in|instanceof|new|this|typeof|void)/,
	'docs/Web/JavaScript/Reference/Lexical_grammar#boolean_literal': /(true|false)/,
	'docs/Web/JavaScript/Reference/Operators/null': /(null)/,
	'DOM/document.$1': /(alinkColor|anchors|applets|bgColor|body|characterSet|compatMode|contentType|cookie|defaultView|designMode|doctype|documentElement|domain|embeds|fgColor|forms|height|images|implementation|lastModified|linkColor|links|plugins|popupNode|referrer|styleSheets|title|tooltipNode|URL|vlinkColor|width|clear|createAttribute|createDocumentFragment|createElement|createElementNS|createEvent|createNSResolver|createRange|createTextNode|createTreeWalker|evaluate|execCommand|getElementById|getElementsByName|importNode|loadOverlay|queryCommandEnabled|queryCommandIndeterm|queryCommandState|queryCommandValue|write|writeln)/,
	'DOM/element.$1': /(attributes|childNodes|className|clientHeight|clientLeft|clientTop|clientWidth|dir|firstChild|id|innerHTML|lang|lastChild|localName|name|namespaceURI|nextSibling|nodeName|nodeType|nodeValue|offsetHeight|offsetLeft|offsetParent|offsetTop|offsetWidth|ownerDocument|parentNode|prefix|previousSibling|scrollHeight|scrollLeft|scrollTop|scrollWidth|style|tabIndex|tagName|textContent|addEventListener|appendChild|blur|click|cloneNode|dispatchEvent|focus|getAttribute|getAttributeNS|getAttributeNode|getAttributeNodeNS|getElementsByTagName|getElementsByTagNameNS|hasAttribute|hasAttributeNS|hasAttributes|hasChildNodes|insertBefore|item|normalize|removeAttribute|removeAttributeNS|removeAttributeNode|removeChild|removeEventListener|replaceChild|scrollIntoView|setAttribute|setAttributeNS|setAttributeNode|setAttributeNodeNS|supports|onblur|onchange|onclick|ondblclick|onfocus|onkeydown|onkeypress|onkeyup|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|onresize)/,
	'DOM/event.$1': /(altKey|bubbles|button|cancelBubble|cancelable|clientX|clientY|ctrlKey|currentTarget|detail|eventPhase|explicitOriginalTarget|isChar|layerX|layerY|metaKey|originalTarget|pageX|pageY|relatedTarget|screenX|screenY|shiftKey|target|timeStamp|type|view|which|initEvent|initKeyEvent|initMouseEvent|initUIEvent|stopPropagation|preventDefault)/,
	'DOM/form.$1': /(elements|name|acceptCharset|action|enctype|encoding|method|submit|reset)/,
	'DOM/table.$1': /(caption|tHead|tFoot|rows|tBodies|align|bgColor|border|cellPadding|cellSpacing|frame|rules|summary|width|createTHead|deleteTHead|createTFoot|deleteTFoot|createCaption|deleteCaption|insertRow|deleteRow)/,
	'DOM/window.$1': /(content|closed|controllers|crypto|defaultStatus|directories|document|frameElement|frames|history|innerHeight|innerWidth|location|locationbar|menubar|name|navigator|opener|outerHeight|outerWidth|pageXOffset|pageYOffset|parent|personalbar|pkcs11|screen|availTop|availLeft|availHeight|availWidth|colorDepth|height|left|pixelDepth|top|width|scrollbars|scrollMaxX|scrollMaxY|scrollX|scrollY|self|sidebar|status|statusbar|toolbar|window|alert|atob|back|btoa|captureEvents|clearInterval|clearTimeout|close|confirm|dump|escape|find|forward|getAttention|getComputedStyle|getSelection|home|moveBy|moveTo|open|openDialog|print|prompt|releaseEvents|resizeBy|resizeTo|scroll|scrollBy|scrollByLines|scrollByPages|scrollTo|setInterval|setTimeout|sizeToContent|stop|unescape|updateCommands|onabort|onclose|ondragdrop|onerror|onload|onpaint|onreset|onscroll|onselect|onsubmit|onunload)/,
	'Web/API/XMLHttpRequest': /(XMLHttpRequest)/,
	'Web/API/XMLHttpRequest/$1': /(\.)(abort|getAllResponseHeaders|getResponseHeader|overrideMimeType|send|setAttributionReporting|setPrivateToken|setRequestHeader)/,
	'JavaScript/Reference/Global_Objects/Array/$1': /(\.)(at|concat|copyWithin|entries|every|fill|filter|find|findIndex|findLast|findLastIndex|flat|flatMap|forEach|includes|indexOf|join|keys|lastIndexOf|length|map|pop|push|reduce|reduceRight|reverse|shift|slice|some|sort|splice|toLocaleString|toReversed|toSorted|toSpliced|toString|unshift|values|with)/,
	'JavaScript/Reference/Global_Objects/Date/$1': /(\.)(getDate|getDay|getFullYear|getHours|getMilliseconds|getMinutes|getMonth|getSeconds|getTime|getTimezoneOffset|getUTCDate|getUTCDay|getUTCFullYear|getUTCHours|getUTCMilliseconds|getUTCMinutes|getUTCMonth|getUTCSeconds|getYear|setDate|setFullYear|setHours|setMilliseconds|setMinutes|setMonth|setSeconds|setTime|setUTCDate|setUTCFullYear|setUTCHours|setUTCMilliseconds|setUTCMinutes|setUTCMonth|setUTCSeconds|setYear|toDateString|toISOString|toJSON|toLocaleDateString|toLocaleString|toLocaleTimeString|toString|toTemporalInstant|toTimeString|toUTCString|valueOf)/,
	'JavaScript/Reference/Global_Objects/Function/$1': /(\.)(apply|arguments|bind|call|caller|displayName|length|name|prototype|toString)/,
	'JavaScript/Reference/Global_Objects/Number/$1': /(\.)(toExponential|toFixed|toLocaleString|toPrecision|toString|valueOf)/,
	'JavaScript/Reference/Global_Objects/RegExp/$1': /(\.)(compile|dotAll|exec|flags|global|hasIndices|ignoreCase|lastIndex|multiline|source|sticky|test|toString|unicode|unicodeSets)/,
	'JavaScript/Reference/Global_Objects/String/$1': /(\.)(anchor|at|big|blink|bold|charAt|charCodeAt|codePointAt|concat|endsWith|fixed|fontcolor|fontsize|includes|indexOf|isWellFormed|italics|lastIndexOf|length|link|localeCompare|match|matchAll|normalize|padEnd|padStart|repeat|replace|replaceAll|search|slice|small|split|startsWith|strike|sub|substr|substring|sup|toLocaleLowerCase|toLocaleUpperCase|toLowerCase|toString|toUpperCase|toWellFormed|trim|trimEnd|trimStart|valueOf)/,
}); // collisions: bgColor, height, width, length, name, open - the (\.) members must stay last

// values of object and array literals are not highlighted by the js state
jush.build_links2('js_val', 'https://developer.mozilla.org/en/$key', /(\b)/, /(\b)/g, {
	'docs/Web/JavaScript/Reference/Lexical_grammar#boolean_literal': /(true|false)/,
	'docs/Web/JavaScript/Reference/Operators/null': /(null)/,
});
jush.links2.js_arr = jush.links2.js_val;
jush.urls.js_arr = jush.urls.js_val;

jush.build_links2('js_doc', 'https://jsdoc.app/$key', /(^[ \t]*|\n\s*\*\s*|(?={))/, /(\b)/g, {
	'tags-$1': /(@(?:abstract|access|alias|async|augments|author|borrows|callback|class|classdesc|constant|constructs|copyright|default|deprecated|description|enum|event|example|exports|external|file|fires|function|generator|global|hideconstructor|ignore|implements|inheritdoc|inner|instance|interface|kind|lends|license|listens|member|memberof|mixes|mixin|module|name|namespace|override|package|param|private|property|protected|public|readonly|requires|returns|see|since|static|summary|this|throws|todo|tutorial|type|typedef|variation|version|yields))/,
	'tags-abstract': /(@virtual)/,
	'tags-augments': /(@extends)/,
	'tags-class': /(@constructor)/,
	'tags-constant': /(@const)/,
	'tags-default': /(@defaultvalue)/,
	'tags-description': /(@desc)/,
	'tags-external': /(@host)/,
	'tags-file': /(@fileoverview|@overview)/,
	'tags-fires': /(@emits)/,
	'tags-function': /(@func|@method)/,
	'tags-inline-link': /(\{@link|\{@linkcode|\{@linkplain)/,
	'tags-inline-tutorial': /(\{@tutorial)/,
	'tags-member': /(@var)/,
	'tags-param': /(@arg|@argument)/,
	'tags-property': /(@prop)/,
	'tags-returns': /(@return)/,
	'tags-throws': /(@exception)/,
	'tags-yields': /(@yield)/,
});
