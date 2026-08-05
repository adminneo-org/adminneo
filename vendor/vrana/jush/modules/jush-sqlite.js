jush.tr.sqlite = { sqlite_apo: /'/, sqlite_quo: /"/, bra: /\[/, bac: /`/, one: /--/, com: /\/\*/, sql_var: /[:@$]/, sqlite_sqliteset: /(\b)(PRAGMA)(\s+)/i, num: jush.num };
jush.tr.sqlite_sqliteset = { sqlite_apo: /'/, sqlite_quo: /"/, bra: /\[/, bac: /`/, one: /--/, com: /\/\*/, num: jush.num, _1: /;|$/ };
jush.tr.sqliteset = { _0: /$/ };
jush.tr.sqlitestatus = { _0: /$/ };

jush.urls.sqlite_sqliteset = 'https://www.sqlite.org/$key';

jush.slugs.sqlite = name => name.toLowerCase().replace(/\s+/g, '');
jush.slugs.sqliteset = name => name.toLowerCase();
jush.slugs.sqlitestatus = jush.slugs.sqliteset;

jush.build_links2('sqlite', 'https://www.sqlite.org/$key', /(\b)/, /(\b)/gi, {
	'lang_$1.html': /(ALTER\s+TABLE|ANALYZE|ATTACH|COPY|DELETE|DETACH|DROP\s+INDEX|DROP\s+TABLE|DROP\s+TRIGGER|DROP\s+VIEW|EXPLAIN|INSERT|CONFLICT|REINDEX|REPLACE|SELECT|UPDATE|TRANSACTION|VACUUM|WITH)/,
	'lang_createvtab.html': /(CREATE\s+VIRTUAL\s+TABLE)/,
	'lang_transaction.html': /(BEGIN|COMMIT|ROLLBACK)/,
	'lang_createindex.html': /(CREATE(?:\s+UNIQUE)?\s+INDEX)/,
	'lang_createtable.html': /(CREATE(?:\s+TEMP|\s+TEMPORARY)?\s+TABLE)/,
	'lang_createtrigger.html': /(CREATE(?:\s+TEMP|\s+TEMPORARY)?\s+TRIGGER)/,
	'lang_createview.html': /(CREATE(?:\s+TEMP|\s+TEMPORARY)?\s+VIEW)/,
	'stricttables.html': /(STRICT)/,
	'withoutrowid.html': /(WITHOUT\s+ROWID)/,
	'gencol.html': /(GENERATED|ALWAYS|STORED|VIRTUAL)/,
	'windowfunctions.html': /(OVER|PARTITION\s+BY|WINDOW|FILTER)/,
	'windowfunctions.html#$1': /(cume_dist|dense_rank|first_value|lag|last_value|lead|nth_value|ntile|percent_rank|rank|row_number)(?=\s*\(|$)/,
	'datatype3.html': /(INTEGER|TEXT|BLOB|REAL|NUMERIC)/,
	'': /(ABORT|ACTION|ADD|AFTER|ALL|ALTER|AS|ASC|AUTOINCREMENT|BEFORE|BY|CASCADE|CHECK|COLUMN|CONSTRAINT|CREATE|CROSS|CURRENT|CURRENT_DATE|CURRENT_TIME|CURRENT_TIMESTAMP|DATABASE|DEFAULT|DEFERRABLE|DEFERRED|DESC|DISTINCT|DO|DROP|EACH|END|EXCEPT|EXCLUDE|EXCLUDED|EXCLUSIVE|FAIL|FALSE|FIRST|FOLLOWING|FOR|FOREIGN|FROM|FULL|GROUP|GROUPS|HAVING|IF|IGNORE|IMMEDIATE|INDEX|INDEXED|INITIALLY|INNER|INSTEAD|INTERSECT|INTO|IS|JOIN|KEY|LAST|LEFT|LIMIT|MATERIALIZED|NATURAL|NO|NOTHING|NOTNULL|NULL|NULLS|OF|OFFSET|ON|ORDER|OTHERS|OUTER|PARTITION|PLAN|PRAGMA|PRECEDING|PRIMARY|QUERY|RAISE|RANGE|RECURSIVE|REFERENCES|RELEASE|RENAME|RESTRICT|RETURNING|RIGHT|ROW|ROWS|SAVEPOINT|SET|TABLE|TEMP|TEMPORARY|TIES|TO|TRIGGER|TRUE|UNBOUNDED|UNION|UNIQUE|USING|VALUES|VIEW|WHERE|WITHOUT)/,
	'lang_expr.html#$1': /(like|glob|regexp|match|escape|isnull|isnotnull|between|exists|case|when|then|else|cast|collate|in|and|or|not)/,
	'lang_corefunc.html#$1': /(abs|changes|char|coalesce|concat|concat_ws|format|glob|hex|if|ifnull|iif|instr|last_insert_rowid|length|like|likelihood|likely|load_extension|lower|ltrim|max|min|nullif|octet_length|printf|quote|random|randomblob|replace|round|rtrim|sign|soundex|sqlite_compileoption_get|sqlite_compileoption_used|sqlite_offset|sqlite_source_id|sqlite_version|substr|substring|total_changes|trim|typeof|unhex|unicode|unistr|unistr_quote|unlikely|upper|zeroblob)(?=\s*\(|$)/,
	'lang_mathfunc.html#$1': /(acos|acosh|asin|asinh|atan|atan2|atanh|ceil|ceiling|cos|cosh|degrees|exp|floor|ln|log|log10|log2|mod|pi|pow|power|radians|sin|sinh|sqrt|tan|tanh|trunc)(?=\s*\(|$)/,
	'lang_datefunc.html#$1': /(date|datetime|julianday|strftime|time|timediff|unixepoch)(?=\s*\(|$)/,
	'lang_aggfunc.html#$1': /(avg|count|group_concat|max|median|min|percentile|percentile_cont|percentile_disc|string_agg|sum|total)(?=\s*\(|$)/,
	'json1.html#$1': /(json|json_array|json_array_insert|json_array_length|json_each|json_error_position|json_extract|json_group_array|json_group_object|json_insert|json_object|json_patch|json_pretty|json_quote|json_remove|json_replace|json_set|json_tree|json_type|json_valid|jsonb|jsonb_array|jsonb_array_insert|jsonb_each|jsonb_extract|jsonb_group_array|jsonb_group_object|jsonb_insert|jsonb_object|jsonb_patch|jsonb_remove|jsonb_replace|jsonb_set|jsonb_tree)(?=\s*\(|$)/,
}); // collisions: min, max, end, like, glob, trunc
jush.urls.sqliteset = ['https://www.sqlite.org/pragma.html#$key',
	'pragma_$1'
];
jush.urls.sqlitestatus = ['https://www.sqlite.org/compile.html#$key',
	'$1'
];

jush.links.sqlite_sqliteset = { 'pragma.html': /.+/ };

jush.links2.sqliteset = /(\b)(analysis_limit|application_id|auto_vacuum|automatic_index|busy_timeout|cache_size|cache_spill|case_sensitive_like|cell_size_check|checkpoint_fullfsync|collation_list|compile_options|count_changes|data_store_directory|data_version|database_list|default_cache_size|defer_foreign_keys|empty_result_callbacks|encoding|foreign_key_check|foreign_key_list|foreign_keys|freelist_count|full_column_names|fullfsync|function_list|hard_heap_limit|ignore_check_constraints|incremental_vacuum|index_info|index_list|index_xinfo|integrity_check|journal_mode|journal_size_limit|legacy_alter_table|legacy_file_format|locking_mode|max_page_count|mmap_size|module_list|optimize|page_count|page_size|parser_trace|pragma_list|query_only|quick_check|read_uncommitted|recursive_triggers|reverse_unordered_selects|schema_version|secure_delete|short_column_names|shrink_memory|soft_heap_limit|stats|synchronous|table_info|table_list|table_xinfo|temp_store|temp_store_directory|threads|trusted_schema|user_version|vdbe_addoptrace|vdbe_debug|vdbe_listing|vdbe_trace|wal_autocheckpoint|wal_checkpoint|writable_schema)(\b)/gi;
jush.links2.sqlitestatus = /()(.+)()/g;
