<?php

namespace AdminNeo;

/**
 * Links tables by foreign keys in system 'information_schema', 'mysql' and 'pg_catalog' schemas.
 *
 * Last changed in release: !compile: version
 *
 * @link https://www.adminneo.org/plugins/#usage
 *
 * @author Jakub Vrana, https://www.vrana.cz/
 * @author Peter Knut
 *
 * @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
 */
class SystemForeignKeysPlugin extends Plugin
{
	public function getForeignKeys(string $table): ?array
	{
		if (DRIVER == "mysql" && DB == "mysql") {
			switch ($table) {
				case "db":
				case "tables_priv":
				case "columns_priv":
					return [["table" => "user", "source" => ["Host", "User"], "target" => ["Host", "User"]]];
				case "help_category":
					return [["table" => "help_category", "source" => ["parent_category_id"], "target" => ["help_category_id"]]];
				case "help_relation":
					return [
						["table" => "help_topic", "source" => ["help_topic_id"], "target" => ["help_topic_id"]],
						["table" => "help_keyword", "source" => ["help_keyword_id"], "target" => ["help_keyword_id"]],
					];
				case "help_topic":
					return [[
						"table" => "help_category",
						"source" => ["help_category_id"],
						"target" => ["help_category_id"]
					]];
				case "procs_priv":
					return [
						["table" => "user", "source" => ["Host", "User"], "target" => ["Host", "User"]],
						["table" => "proc", "source" => ["Db", "Routine_name"], "target" => ["db", "name"]]
					];
				case "time_zone_name":
				case "time_zone_transition_type":
					return [["table" => "time_zone", "source" => ["Time_zone_id"], "target" => ["Time_zone_id"]]];
				case "time_zone_transition":
					return [
						["table" => "time_zone", "source" => ["Time_zone_id"], "target" => ["Time_zone_id"]],
						["table" => "time_zone_transition_type", "source" => ["Time_zone_id", "Transition_type_id"], "target" => ["Time_zone_id", "Transition_type_id"]]
					];
			}
		} elseif (DB == "information_schema" || $_GET["ns"] == "information_schema") {
			$schemas = $this->schemas("TABLE");
			$tables = $this->tables("TABLE");
			$columns = [
				"table" => "COLUMNS",
				"source" => ["TABLE_CATALOG", "TABLE_SCHEMA", "TABLE_NAME", "COLUMN_NAME"],
				"target" => ["TABLE_CATALOG", "TABLE_SCHEMA", "TABLE_NAME", "COLUMN_NAME"],
			];
			$characterSets = $this->characterSets("CHARACTER_SET_NAME");
			$collations = $this->collations("COLLATION_NAME");
			$routineCharsets = [
				$this->characterSets("CHARACTER_SET_CLIENT"),
				$this->collations("COLLATION_CONNECTION"),
				$this->collations("DATABASE_COLLATION")
			];

			switch (strtoupper($table)) {
				case "CHARACTER_SETS":
					$foreignKeys = [$this->collations("DEFAULT_COLLATE_NAME")];
					break;
				case "CHECK_CONSTRAINTS":
					$foreignKeys = [$this->schemas("CONSTRAINT")];
					break;
				case "COLLATIONS":
					$foreignKeys = [$characterSets];
					break;
				case "COLLATION_CHARACTER_SET_APPLICABILITY":
					$foreignKeys = [$collations, $characterSets];
					break;
				case "COLUMNS":
					$foreignKeys = [$schemas, $tables, $characterSets, $collations];
					break;
				case "COLUMN_PRIVILEGES":
				case "COLUMNS_EXTENSIONS":
					$foreignKeys = [$schemas, $tables, $columns];
					break;
				case "TABLES":
					$foreignKeys = [
						$schemas,
						$this->collations("TABLE_COLLATION"),
						["table" => "ENGINES", "source" => ["ENGINE"], "target" => ["ENGINE"]]
					];
					break;
				case "SCHEMATA":
					$foreignKeys = [
						$this->characterSets("DEFAULT_CHARACTER_SET_NAME"),
						$this->collations("DEFAULT_COLLATION_NAME")
					];
					break;
				case "EVENTS":
					$foreignKeys = array_merge([$this->schemas("EVENT")], $routineCharsets);
					break;
				case "FILES":
				case "PARAMETERS":
					$foreignKeys = [
						$this->schemas("SPECIFIC"),
						["table" => "ROUTINES", "source" => ["SPECIFIC_CATALOG", "SPECIFIC_SCHEMA", "SPECIFIC_NAME"], "target" => ["ROUTINE_CATALOG", "ROUTINE_SCHEMA", "SPECIFIC_NAME"]]
					];
					break;
				case "PARTITIONS":
				case "TABLE_PRIVILEGES":
				case "TABLES_EXTENSIONS":
					$foreignKeys = [$schemas, $tables];
					break;
				case "KEY_COLUMN_USAGE":
					$foreignKeys = [
						$this->schemas("CONSTRAINT"),
						$schemas,
						$tables,
						$columns,
						$this->schemas("TABLE", "REFERENCED_TABLE"),
						$this->tables("TABLE", "REFERENCED_TABLE"),
						["source" => ["TABLE_CATALOG", "REFERENCED_TABLE_SCHEMA", "REFERENCED_TABLE_NAME", "REFERENCED_COLUMN_NAME"]] + $columns,
					];
					break;
				case "REFERENTIAL_CONSTRAINTS":
					$foreignKeys = [
						$this->schemas("CONSTRAINT"),
						$this->schemas("UNIQUE_CONSTRAINT"),
						$this->tables("CONSTRAINT", "CONSTRAINT", "TABLE_NAME"),
						$this->tables("CONSTRAINT", "CONSTRAINT", "REFERENCED_TABLE_NAME"),
					];
					break;
				case "ROUTINES":
					$foreignKeys = array_merge([$this->schemas("ROUTINE")], $routineCharsets);
					break;
				case "SCHEMA_PRIVILEGES":
					$foreignKeys = [$schemas];
					break;
				case "SCHEMATA_EXTENSIONS":
					$foreignKeys = [["table" => "SCHEMATA", "source" => ["CATALOG_NAME", "SCHEMA_NAME"], "target" => ["CATALOG_NAME", "SCHEMA_NAME"]]];
					break;
				case "STATISTICS":
					$foreignKeys = [$schemas, $tables, $columns, $this->schemas("TABLE", "INDEX")];
					break;
				case "TABLE_CONSTRAINTS":
					$foreignKeys = [
						$this->schemas("CONSTRAINT"),
						$this->schemas("CONSTRAINT", "TABLE"),
						$this->tables("CONSTRAINT", "TABLE"),
					];
					break;
				case "TABLE_CONSTRAINTS_EXTENSIONS":
					$foreignKeys = [$this->schemas("CONSTRAINT"), $this->tables("CONSTRAINT", "CONSTRAINT", "TABLE_NAME")];
					break;
				case "TRIGGERS":
					$foreignKeys = array_merge(
						[
							$this->schemas("TRIGGER"),
							$this->schemas("EVENT_OBJECT"),
							$this->tables("EVENT_OBJECT", "EVENT_OBJECT", "EVENT_OBJECT_TABLE"),
						],
						$routineCharsets
					);
					break;
				case "VIEWS":
					$foreignKeys = [
						$schemas,
						$this->characterSets("CHARACTER_SET_CLIENT"),
						$this->collations("COLLATION_CONNECTION")
					];
					break;
				case "VIEW_TABLE_USAGE":
					$foreignKeys = [
						$schemas,
						$this->schemas("VIEW"),
						$tables,
						["table" => "VIEWS", "source" => ["VIEW_CATALOG", "VIEW_SCHEMA", "VIEW_NAME"], "target" => ["TABLE_CATALOG", "TABLE_SCHEMA", "TABLE_NAME"]]
					];
					break;
				default:
					return null;
			}

			return $_GET["ns"] == "information_schema" ? $this->lowerCase($foreignKeys) : $foreignKeys;
		} elseif (DRIVER == "pgsql" && $_GET["ns"] == "pg_catalog") {
			$mapping = [
				'pg_aggregate' => [
					'aggtransfn.proc', 'aggfinalfn.proc', 'aggcombinefn.proc', 'aggserialfn.proc', 'aggdeserialfn.proc', 'aggmtransfn.proc', 'aggminvtransfn.proc', 'aggmfinalfn.proc',
					'aggsortop.operator', 'aggtranstype.type', 'aggmtranstype.type',
				],
				'pg_am' => ['amhandler.proc'],
				'pg_amop' => ['amopfamily.opfamily', 'amoplefttype.type', 'amoprighttype.type', 'amopopr.operator', 'amopmethod.am', 'amopsortfamily.opfamily'],
				'pg_amproc' => ['amprocfamily.opfamily', 'amproclefttype.type', 'amprocrighttype.type', 'amproc.proc'],
				'pg_attrdef' => ['adrelid.class', 'adnum.attribute.attnum'],
				'pg_attribute' => ['attrelid.class', 'atttypid.type', 'attcollation.collation'],
				'pg_auth_members' => ['roleid.authid', 'member.authid', 'grantor.authid'],
				'pg_cast' => ['castsource.type', 'casttarget.type', 'castfunc.proc'],
				'pg_class' => ['relnamespace.namespace', 'reltype.type', 'reloftype.type', 'relowner.authid', 'relam.am', 'reltablespace.tablespace', 'reltoastrelid.class', 'relrewrite.class'],
				'pg_collation' => ['collnamespace.namespace', 'collowner.authid'],
				'pg_constraint' => [
					'connamespace.namespace', 'conrelid.class', 'contypid.type', 'conindid.class', 'conparentid.constraint', 'confrelid.class', 'conkey.attribute.attnum', 'confkey.attribute.attnum',
					'conpfeqop.operator', 'conppeqop.operator', 'conffeqop.operator', 'confdelsetcols.attribute.attnum', 'conexclop.operator',
				],
				'pg_conversion' => ['connamespace.namespace', 'conowner.authid', 'conproc.proc'],
				'pg_database' => ['datdba.authid', 'dattablespace.tablespace'],
				'pg_db_role_setting' => ['setdatabase.database', 'setrole.authid'],
				'pg_default_acl' => ['defaclrole.authid', 'defaclnamespace.namespace'],
				'pg_depend' => ['classid.class', 'refclassid.class'],
				'pg_description' => ['classoid.class'],
				'pg_enum' => ['enumtypid.type'],
				'pg_event_trigger' => ['evtowner.authid', 'evtfoid.proc'],
				'pg_extension' => ['extowner.authid', 'extnamespace.namespace', 'extconfig.class'],
				'pg_foreign_data_wrapper' => ['fdwowner.authid', 'fdwhandler.proc', 'fdwvalidator.proc'],
				'pg_foreign_server' => ['srvowner.authid', 'srvfdw.foreign_data_wrapper'],
				'pg_foreign_table' => ['ftrelid.class', 'ftserver.foreign_server'],
				'pg_index' => ['indexrelid.class', 'indrelid.class', 'indkey.attribute.attnum', 'indcollation.collation', 'indclass.opclass'],
				'pg_inherits' => ['inhrelid.class', 'inhparent.class'],
				'pg_init_privs' => ['classoid.class'],
				'pg_language' => ['lanowner.authid', 'lanplcallfoid.proc', 'laninline.proc', 'lanvalidator.proc'],
				'pg_largeobject' => ['loid.largeobject_metadata'],
				'pg_largeobject_metadata' => ['lomowner.authid'],
				'pg_namespace' => ['nspowner.authid'],
				'pg_opclass' => ['opcmethod.am', 'opcnamespace.namespace', 'opcowner.authid', 'opcfamily.opfamily', 'opcintype.type', 'opckeytype.type'],
				'pg_operator' => [
					'oprnamespace.namespace', 'oprowner.authid', 'oprleft.type', 'oprright.type', 'oprresult.type', 'oprcom.operator', 'oprnegate.operator', 'oprcode.proc', 'oprrest.proc',
					'oprjoin.proc',
				],
				'pg_opfamily' => ['opfmethod.am', 'opfnamespace.namespace', 'opfowner.authid'],
				'pg_partitioned_table' => ['partrelid.class', 'partdefid.class', 'partattrs.attribute.attnum', 'partclass.opclass', 'partcollation.collation'],
				'pg_policy' => ['polrelid.class', 'polroles.authid'],
				'pg_proc' => [
					'pronamespace.namespace', 'proowner.authid', 'prolang.language', 'provariadic.type', 'prosupport.proc', 'prorettype.type', 'proargtypes.type', 'proallargtypes.type',
					'protrftypes.type',
				],
				'pg_publication' => ['pubowner.authid'],
				'pg_publication_namespace' => ['pnpubid.publication', 'pnnspid.namespace'],
				'pg_publication_rel' => ['prpubid.publication', 'prrelid.class', 'prattrs.attribute.attnum'],
				'pg_range' => ['rngtypid.type', 'rngsubtype.type', 'rngmultitypid.type', 'rngcollation.collation', 'rngsubopc.opclass', 'rngcanonical.proc', 'rngsubdiff.proc'],
				'pg_rewrite' => ['ev_class.class'],
				'pg_seclabel' => ['classoid.class'],
				'pg_sequence' => ['seqrelid.class', 'seqtypid.type'],
				'pg_shdepend' => ['dbid.database', 'classid.class', 'refclassid.class'],
				'pg_shdescription' => ['classoid.class'],
				'pg_shseclabel' => ['classoid.class'],
				'pg_statistic' => ['starelid.class', 'staattnum.attribute.attnum', 'staop.operator', 'stacoll.collation'],
				'pg_statistic_ext' => ['stxrelid.class', 'stxnamespace.namespace', 'stxowner.authid', 'stxkeys.attribute.attnum'],
				'pg_statistic_ext_data' => ['stxoid.statistic_ext'],
				'pg_subscription' => ['subdbid.database', 'subowner.authid'],
				'pg_subscription_rel' => ['srsubid.subscription', 'srrelid.class'],
				'pg_tablespace' => ['spcowner.authid'],
				'pg_transform' => ['trftype.type', 'trflang.language', 'trffromsql.proc', 'trftosql.proc'],
				'pg_trigger' => ['tgrelid.class', 'tgparentid.trigger', 'tgfoid.proc', 'tgconstrrelid.class', 'tgconstrindid.class', 'tgconstraint.constraint', 'tgattr.attribute.attnum'],
				'pg_ts_config' => ['cfgnamespace.namespace', 'cfgowner.authid', 'cfgparser.ts_parser'],
				'pg_ts_config_map' => ['mapcfg.ts_config', 'mapdict.ts_dict'],
				'pg_ts_dict' => ['dictnamespace.namespace', 'dictowner.authid', 'dicttemplate.ts_template'],
				'pg_ts_parser' => ['prsnamespace.namespace', 'prsstart.proc', 'prstoken.proc', 'prsend.proc', 'prsheadline.proc', 'prslextype.proc'],
				'pg_ts_template' => ['tmplnamespace.namespace', 'tmplinit.proc', 'tmpllexize.proc'],
				'pg_type' => [
					'typnamespace.namespace', 'typowner.authid', 'typrelid.class', 'typsubscript.proc', 'typelem.type', 'typarray.type', 'typinput.proc', 'typoutput.proc', 'typreceive.proc',
					'typsend.proc', 'typmodin.proc', 'typmodout.proc', 'typanalyze.proc', 'typbasetype.type', 'typcollation.collation',
				],
				'pg_user_mapping' => ['umuser.authid', 'umserver.foreign_server'],
			];

			$foreignKeys = [];
			foreach ($mapping[$table] ?? [] as $val) {
				[$source, $target, $column] = explode(".", "$val.oid");
				$foreignKeys[] = ["table" => "pg_$target", "source" => [$source], "target" => [$column]];
			}

			return $foreignKeys;
		}

		return null;
	}

	private function schemas(string $catalog, ?string $schema = null): array
	{
		return [
			"table" => "SCHEMATA",
			"source" => [$catalog . "_CATALOG", ($schema ?: $catalog) . "_SCHEMA"],
			"target" => ["CATALOG_NAME", "SCHEMA_NAME"]
		];
	}

	private function tables(string $catalog, ?string $schema = null, ?string $table_name = null): array
	{
		$schema = $schema ?: $catalog;

		return [
			"table" => "TABLES",
			"source" => [$catalog . "_CATALOG", $schema . "_SCHEMA", ($table_name ?: $schema . "_NAME")],
			"target" => ["TABLE_CATALOG", "TABLE_SCHEMA", "TABLE_NAME"]
		];
	}

	private function characterSets(string $source): array
	{
		return [
			"table" => "CHARACTER_SETS",
			"source" => [$source],
			"target" => ["CHARACTER_SET_NAME"]
		];
	}

	private function collations(string $source): array
	{
		return [
			"table" => "COLLATIONS",
			"source" => [$source],
			"target" => ["COLLATION_NAME"]
		];
	}

	private function lowerCase($value) {
		return (is_array($value) ? array_map([$this, "lowerCase"], $value) : strtolower($value));
	}
}
