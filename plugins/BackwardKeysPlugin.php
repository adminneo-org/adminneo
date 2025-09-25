<?php

namespace AdminNeo;

/**
 * Adds a "Relations" column listing tables that reference the current row
 * via foreign keys (backward keys).
 */
class BackwardKeysPlugin extends Plugin
{
    /**
     * Build map of referencing tables and columns for given table.
     *
     * return format:
     *   $return[$targetTable]["keys"][$constraintName][$targetColumn] = $sourceColumn;
     *   $return[$targetTable]["name"] = Admin::get()->getTableName($targetTable);
     */
    public function getBackwardKeys(string $table, string $tableName): array
    {
        // MySQL/MariaDB
        if (DIALECT === "sql") {
            $keys = [];

            foreach (get_rows(
                "SELECT TABLE_NAME, CONSTRAINT_NAME, COLUMN_NAME, REFERENCED_COLUMN_NAME\n"
                . "FROM information_schema.KEY_COLUMN_USAGE\n"
                . "WHERE TABLE_SCHEMA = " . q($this->admin->getDatabase()) . "\n"
                . "AND REFERENCED_TABLE_SCHEMA = " . q($this->admin->getDatabase()) . "\n"
                . "AND REFERENCED_TABLE_NAME = " . q($table) . "\n"
                . "ORDER BY ORDINAL_POSITION",
                null,
                ""
            ) as $row) {
                $keys[$row["TABLE_NAME"]]["keys"][$row["CONSTRAINT_NAME"]][$row["COLUMN_NAME"]] = $row["REFERENCED_COLUMN_NAME"];
            }

            foreach ($keys as $key => $val) {
                $name = $this->admin->getTableName(table_status($key, true));
                if ($name != "") {
                    $search = preg_quote($tableName);
                    $separator = "(:|\\s*-)?\\s+";
                    $keys[$key]["name"] = (preg_match("(^$search$separator(.+)|^(.+?)$separator$search$)iu", $name, $match) ? $match[2] . $match[3] : $name);
                } else {
                    unset($keys[$key]);
                }
            }

            return $keys;
        }

        // PostgreSQL
        if (DIALECT === "pgsql") {
            $keys = [];
            $ns = $_GET["ns"] ?? null;
            if ($ns === null) {
                return [];
            }

            $query =
                "SELECT s.table_name AS table_name, s.constraint_name AS constraint_name, s.column_name AS column_name, t.column_name AS referenced_column_name\n"
                . "FROM information_schema.key_column_usage s\n"
                . "JOIN information_schema.referential_constraints r USING (constraint_catalog, constraint_schema, constraint_name)\n"
                . "JOIN information_schema.key_column_usage t\n"
                . "\tON r.unique_constraint_catalog = t.constraint_catalog\n"
                . "\tAND r.unique_constraint_schema = t.constraint_schema\n"
                . "\tAND r.unique_constraint_name = t.constraint_name\n"
                . "\tAND r.constraint_catalog = t.constraint_catalog\n"
                . "\tAND r.constraint_schema = t.constraint_schema\n"
                . "\tAND s.position_in_unique_constraint = t.ordinal_position\n"
                . "WHERE t.table_catalog = " . q($this->admin->getDatabase()) . "\n"
                . "AND t.table_schema = " . q($ns) . "\n"
                . "AND t.table_name = " . q($table) . "\n"
                . "ORDER BY s.ordinal_position";

            foreach (get_rows($query, null, "") as $row) {
                $keys[$row["table_name"]]["keys"][$row["constraint_name"]][$row["column_name"]] = $row["referenced_column_name"];
            }

            foreach ($keys as $key => $val) {
                $name = $this->admin->getTableName(table_status($key, true));
                if ($name != "") {
                    $search = preg_quote($tableName);
                    $separator = "(:|\\s*-)?\\s+";
                    $keys[$key]["name"] = (preg_match("(^$search$separator(.+)|^(.+?)$separator$search$)iu", $name, $match) ? $match[2] . $match[3] : $name);
                } else {
                    unset($keys[$key]);
                }
            }

            return $keys;
        }

        // Other drivers (SQLite, MSSQL, etc.) not supported "yet".
        return [];
    }

    public function printBackwardKeys(array $backwardKeys, array $row): void
    {
        foreach ($backwardKeys as $table => $backwardKey) {
            foreach ($backwardKey["keys"] as $cols) {
                $link = ME . 'select=' . urlencode($table);
                $i = 0;
                foreach ($cols as $column => $val) {
                    if (!array_key_exists($val, $row)) {
                        continue 2;
                    }
                    $link .= where_link($i++, $column, $row[$val]);
                }
                echo "<a href='" . h($link) . "'>" . h($backwardKey["name"]) . "</a>";

                $link = ME . 'edit=' . urlencode($table);
                foreach ($cols as $column => $val) {
                    $link .= "&set" . urlencode("[" . bracket_escape($column) . "]") . "=" . urlencode($row[$val]);
                }
                echo "<a href='" . h($link) . "' title='" . lang('New item') . "'>" . icon_solo("add") . "</a> ";
            }
        }
    }
}


