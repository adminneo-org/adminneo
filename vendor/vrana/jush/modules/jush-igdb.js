jush.tr.igdb = { quo: /"/ };

jush.build_links2('igdb', 'https://api-docs.igdb.com/#$key', /(\b)/, /(\b)/gi, {
	'endpoints': /(POST|GET|DELETE)/,
	'$1': /(fields|exclude)/,
	'filters': /(where)/,
	'sorting': /(sort)/,
	'search-1': /(search)/,
	'pagination': /(limit|offset)/,
	'multi-query': /(query)/,
});
