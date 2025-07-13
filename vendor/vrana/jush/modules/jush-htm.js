jush.tr.htm = { php: jush.php, tag_css: /(<)(style)\b/i, tag_js: /(<)(script)\b/i, htm_com: /<!--/, tag: /(<)(\/?[-\w]+)/, ent: /&/ };
jush.tr.htm_com = { php: jush.php, _1: /-->/ };
jush.tr.ent = { php: jush.php, _1: /[;\s]/ };
jush.tr.tag = { php: jush.php, att_css: /(\s*)(style)(\s*=\s*|$)/i, att_js: /(\s*)(on[-\w]+)(\s*=\s*|$)/i, att_http: /(\s*)(http-equiv)(\s*=\s*|$)/i, att: /(\s*)([-\w]+)()/, _1: />/ };
jush.tr.tag_css = { php: jush.php, att: /(\s*)([-\w]+)()/, css: />/ };
jush.tr.tag_js = { php: jush.php, att: /(\s*)([-\w]+)()/, js: />/ };
jush.tr.att = { php: jush.php, att_quo: /\s*=\s*"/, att_apo: /\s*=\s*'/, att_val: /\s*=\s*/, _1: /()/ };
jush.tr.att_css = { php: jush.php, att_quo: /"/, att_apo: /'/, att_val: /\s*/ };
jush.tr.att_js = { php: jush.php, att_quo: /"/, att_apo: /'/, att_val: /\s*/ };
jush.tr.att_http = { php: jush.php, att_quo: /"/, att_apo: /'/, att_val: /\s*/ };
jush.tr.att_quo = { php: jush.php, _2: /"/ };
jush.tr.att_apo = { php: jush.php, _2: /'/ };
jush.tr.att_val = { php: jush.php, _2: /(?=>|\s)/ };
jush.tr.xml = { php: jush.php, htm_com: /<!--/, xml_tag: /(<)(\/?[-\w:]+)/, ent: /&/ };
jush.tr.xml_tag = { php: jush.php, xml_att: /(\s*)([-\w:]+)()/, _1: />/ };
jush.tr.xml_att = { php: jush.php, att_quo: /\s*=\s*"/, att_apo: /\s*=\s*'/, _1: /()/ };

jush.urls.tag = 'https://developer.mozilla.org/en-US/docs/Web/HTML/Reference/$key';
jush.urls.tag_css = jush.urls.tag;
jush.urls.tag_js = jush.urls.tag;
jush.urls.att = jush.urls.tag;
jush.urls.att_css = jush.urls.tag;
jush.urls.att_js = 'https://developer.mozilla.org/en-US/docs/Web/API/$key/$val_event';
jush.urls.att_http = jush.urls.tag;

jush.links.tag = {
	'Elements/$val': /^(a|abbr|acronym|address|area|article|aside|audio|b|base|bdi|bdo|big|blockquote|body|br|button|canvas|caption|center|cite|code|col|colgroup|data|datalist|dd|del|details|dfn|dialog|dir|div|dl|dt|em|embed|fencedframe|fieldset|figcaption|figure|font|footer|form|frame|frameset|head|header|heading_elements|hgroup|hr|html|i|iframe|img|input|ins|kbd|label|legend|li|link|main|map|mark|marquee|menu|meta|meter|nav|nobr|noembed|noframes|noscript|object|ol|optgroup|option|output|p|param|picture|plaintext|pre|progress|q|rb|rp|rt|rtc|ruby|s|samp|search|section|select|selectedcontent|slot|small|source|span|strike|strong|sub|summary|sup|table|tbody|td|template|textarea|tfoot|th|thead|time|title|tr|track|tt|u|ul|var|video|wbr|xmp)$/i
};
jush.links.tag_css = { 'Elements/$val': /^(style)$/i };
jush.links.tag_js = { 'Elements/$val': /^(script)$/i };
jush.links.att_css = { 'Global_attributes/$val': /^(style)$/i };
jush.links.att_js = {
	'Element': /on(blur|click|contextmenu|dblclick|focus|input|keydown|keypress|keyup|mousedown|mouseenter|mouseleave|mousemove|mouseout|mouseover|mouseup|mousewheel|scroll)$/i,
	'HTMLElement': /on(change|drag|dragend|dragenter|dragleave|dragover|dragstart|drop|error|load|toggle)$/i,
	'HTMLFormElement': /on(reset|submit)$/i,
	'HTMLInputElement': /on(cancel|invalid|select)$/i,
	'HTMLMediaElement': /on(canplay|canplaythrough|durationchange|emptied|ended|loadeddata|loadedmetadata|pause|play|playing|ratechange|seeked|seeking|stalled|suspend|timeupdate|volumechange|waiting)$/i,
	'Window': /on(resize)$/i,
};
jush.links.att_http = { 'Elements/meta#$val': /^(http-equiv)$/i };
jush.links.att = {
	'Global_attributes/$val': /^(accesskey|anchor|autocapitalize|autocorrect|autofocus|class|contenteditable|dir|draggable|enterkeyhint|exportparts|hidden|id|inert|inputmode|is|itemid|itemprop|itemref|itemscope|itemtype|lang|nonce|part|popover|slot|spellcheck|style|tabindex|title|translate|virtualkeyboardpolicy|writingsuggestions)$/i,
	'Global_attributes/data-_star_': /^(data-.*)$/i,
	'Elements/$tag#$val': /^(abbr|accept|accept-charset|action|align|alink|allow|allowfullscreen|allowpaymentrequest|alt|archive|as|async|attributionsrc|autocomplete|autoplay|axis|background|behavior|bgcolor|blocking|border|bottommargin|browsingtopics|capture|cellpadding|cellspacing|char|charoff|charset|checked|cite|classid|clear|codebase|codetype|color|cols|colspan|command|commandfor|compact|content|controls|controlslist|coords|credentialless|crossorigin|csp|data|datetime|declare|decoding|default|defer|direction|dirname|disabled|disablepictureinpicture|disableremoteplayback|download|elementtiming|enctype|face|fetchpriority|for|form|formaction|formenctype|formmethod|formnovalidate|formtarget|frame|frameborder|headers|height|high|href|hreflang|hspace|http-equiv|imagesizes|imagesrcset|incremental|integrity|ismap|kind|label|language|leftmargin|link|list|loading|longdesc|loop|low|marginheight|marginwidth|max|maxlength|media|method|min|minlength|moz-opaque|multiple|muted|name|nomodule|noresize|noshade|novalidate|onafterprint|onbeforeprint|onbeforeunload|onblur|onerror|onfocus|onhashchange|onlanguagechange|onload|onmessage|onmessageerror|onoffline|ononline|onpagehide|onpagereveal|onpageshow|onpageswap|onpopstate|onrejectionhandled|onresize|onstorage|onunhandledrejection|onunload|open|optimum|orient|pattern|ping|placeholder|playsinline|popovertarget|popovertargetaction|poster|preload|profile|readonly|referrerpolicy|rel|required|results|rev|reversed|rightmargin|rows|rowspan|rules|sandbox|scope|scrollamount|scrolldelay|scrolling|selected|shadowrootclonable|shadowrootdelegatesfocus|shadowrootmode|shadowrootserializable|shape|size|sizes|span|src|srcdoc|srclang|srcset|standby|start|step|summary|target|text|topmargin|truespeed|type|usemap|valign|value|valuetype|version|vlink|vspace|webkitdirectory|width|wrap|xmlns)$/i
};
