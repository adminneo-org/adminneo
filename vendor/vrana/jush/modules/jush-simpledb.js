jush.tr.simpledb = { sqlite_apo: /'/, sqlite_quo: /"/, bac: /`/ };

jush.build_links2('simpledb', 'https://docs.aws.amazon.com/AmazonSimpleDB/latest/DeveloperGuide/$key.html', /(\b)/, /(\b)/gi, {
	'QuotingRulesSelect': /(select|limit)/,
	'CountingDataSelect': /(count)/,
	'SortingDataSelect': /(order\s+by|asc|desc)/,
	'SimpleQueriesSelect': /(where)/,
	'UsingSelectOperators': /(between|like|is|in)/,
	'RangeValueQueriesSelect': /(every)/,
	'': /(or|and|not|from|null|intersection)/,
});
