jush.tr.json = { json_obj: /\{/, json_arr: /\[/, quo: /"/, num: /-?\d+(?:\.\d+)?(?:e[-+]?\d+)?/i };
jush.tr.json_obj = { json_val: /:/, _1: /\s*}/, json_key: /()/ };
jush.tr.json_key = { quo: /"/, _1: /(?=[:}])/ };
jush.tr.json_val = { json_obj: /\{/, json_arr: /\[/, quo: /"/, num: /-?\d+(?:\.\d+)?(?:e[-+]?\d+)?/i, _1: /,|(?=})/ };
jush.tr.json_arr = { json_obj: /\{/, json_arr: /\[/, quo: /"/, num: /-?\d+(?:\.\d+)?(?:e[-+]?\d+)?/i, _1: /]/ };

jush.build_links2('json_val', '', /(\b)/, /(\b)/g, { // empty key - highlight without a link
	'': /(true|false|null)/,
});
jush.links2.json = jush.links2.json_arr = jush.links2.json_val;
jush.urls.json = jush.urls.json_arr = jush.urls.json_val;
