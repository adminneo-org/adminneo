<?php

namespace AdminNeo;

/**
 * Returns values of AS ENUM (...).
 *
 * @return ?list<string> SQL literals, null if the definition is not an enum.
 */
function enum_values(string $definition): ?array
{
	$value = "'(?:[^']|'')*'"; // A value can't contain an unescaped apostrophe, so it's safe to use it in a query.
	if (!preg_match('~^AS\s+ENUM\s*\(\s*(' . $value . '(?:\s*,\s*' . $value . ')*)\s*\)$~i', $definition, $match)) {
		return null;
	}

	preg_match_all('~' . $value . '~', $match[1], $matches);

	return $matches[0];
}

/**
 * Returns queries adding values to an enum type.
 *
 * @return ?list<string> Null if the definitions differ by anything else than added values.
 */
function add_enum_values(string $type, string $old, string $new): ?array
{
	$old_values = enum_values($old);
	$new_values = enum_values($new);
	if ($old_values === null || $new_values === null) {
		return null;
	}

	$return = [];
	$i = 0; // Number of original values matched so far.
	foreach ($new_values as $value) {
		if ($value === ($old_values[$i] ?? null)) {
			$i++;
		} else {
			// ALTER TYPE ADD VALUE can't run inside a transaction before PostgreSQL 12, queries() doesn't start one.
			$return[] = "ALTER TYPE " . idf_escape($type) . " ADD VALUE $value"
				. ($i < count($old_values) ? " BEFORE " . $old_values[$i] : "");
		}
	}

	return $i == count($old_values) ? $return : null; // A value was renamed, removed or reordered.
}

$TYPE = $_GET["type"];
$row = $_POST;

$type = ($TYPE != "" ? type_definition((int)Driver::get()->getUserTypeId($TYPE)) : ["kind" => "", "definition" => ""]);
$object = ($type["kind"] == 'd' ? "DOMAIN" : "TYPE"); // domains are created, altered and dropped as DOMAIN

if ($_POST) {
	$link = substr(ME, 0, -1);
	$name = trim($row["name"]);
	$as = trim($row["as"]);
	// CREATE TYPE accepts AS ENUM (...), AS RANGE (...), AS (...) and (INPUT = ...), anything else after AS is a base type of a domain
	$new_object = (preg_match('~^AS\s+(?!ENUM\b|RANGE\b|\()~i', $as) ? "DOMAIN" : "TYPE");
	$message = lang('Type has been altered.');

	// Renaming and adding enum values are the only changes not requiring to re-create the type.
	$alter = (!$_POST["drop"] && $TYPE != "" && $new_object == $object
		? ($as == $type["definition"] ? [] : add_enum_values($TYPE, $type["definition"], $as))
		: null
	);

	if ($alter !== null) {
		if ($TYPE != $name) {
			$alter[] = "ALTER $object " . idf_escape($TYPE) . " RENAME TO " . idf_escape($name); // After ADD VALUE which uses the original name.
		}
		if (!$alter) {
			redirect($link);
		}

		$failed = false;
		foreach ($alter as $query) {
			if (!queries($query)) {
				$failed = true;
				break;
			}
		}
		queries_redirect($link, $message, !$failed);
	} else {
		// There's no CREATE OR REPLACE TYPE, so the type is dropped and created again.
		drop_create(
			"DROP $object " . idf_escape($TYPE),
			"CREATE $new_object " . idf_escape($name) . " $as",
			"", // Only PostgreSQL supports types and its DDL is transactional.
			"",
			"",
			$link,
			lang('Type has been dropped.'),
			$message,
			lang('Type has been created.'),
			$TYPE,
			$name
		);
	}
}

if ($TYPE != "") {
	page_header(lang('Alter type') . ": " . h($TYPE), [h($TYPE)]);
} else {
	page_header(lang('Create type'), [lang('Create type')]);
}

if (!$row) {
	$row["name"] = $TYPE;
	$row["as"] = ($TYPE != "" ? $type["definition"] : "AS ");
}

echo "<form action='' method='post'>\n";

echo "<p>";
echo lang('Name') . ": <input class='input' name='name' value='" . h($row['name']) . "' autocapitalize='off'>\n";
echo doc_link([
	'pgsql' => "sql-createtype.html",
], "?");

echo "</p>\n<p>";
textarea("as", $row["as"]);
echo "</p>\n<p>";
echo "<input type='submit' class='button default' value='", lang('Save'), "'>";
if ($TYPE != "") {
	echo "<input type='submit' class='button' name='drop' value='", lang('Drop'), "'>";
	echo confirm(lang('Drop %s?', $TYPE));
}
echo input_token();
echo "</p>\n";

echo "</form>\n";
