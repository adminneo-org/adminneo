<?php

namespace AdminNeo;

$title2 = h(": " . DB . ($_GET["ns"] ? ".$_GET[ns]" : ""));
page_header(lang('Database schema') . $title2, [lang('Database schema')]);

/** @var array{float, float}[] $table_pos */
$table_pos = [];
$table_pos_js = [];
/** @var float[][] $field_pos */
$field_pos = []; // table => field => position
$SCHEMA = ($_GET["schema"] ?: $_COOKIE["neo_schema-" . str_replace(".", "_", DB)]); // $_COOKIE["neo_schema"] was used before 3.2.0 //! ':' in table name

preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $SCHEMA, $matches, PREG_SET_ORDER);
foreach ($matches as $match) {
	$table_pos[$match[1]] = [(float) $match[2], (float) $match[3]];
	$table_pos_js[] = "\n'" . js_escape($match[1]) . "': [ $match[2], $match[3] ]";
}

$line_height = 1.4;
$top = 0;
$base_left = -1;

/** @var array{fields:array[], pos:array{float, float}, references:string[][][]}[] $schema */
$schema = []; // table => array("fields" => array(name => field), "pos" => array(top, left), "references" => array(table => array(left => array(source, target))))
$referenced = []; // target_table => array(table => array(left => target_column))
/** @var array<numeric-string, bool> $lefts */
$lefts = []; // float => bool
$all_fields = Driver::get()->getAllFields();

foreach (table_status('', true) as $table => $table_status) {
	if (is_view($table_status)) {
		continue;
	}
	$pos = 0;
	$schema[$table]["fields"] = [];
	foreach ($all_fields[$table] ?? [] as $field) {
		$pos = round($pos + $line_height, 2); // Rounding keeps the em values in the output short.
		$field_pos[$table][$field["field"]] = $pos;
		$schema[$table]["fields"][$field["field"]] = $field;
	}
	$schema[$table]["pos"] = ($table_pos[$table] ?? [$top, 0]);

	foreach (Admin::get()->getForeignKeys($table) as $val) {
		if (!$val["db"]) {
			$left = $base_left;
			if (($table_pos[$table][1] ?? 0) || ($table_pos[$val["table"]][1] ?? 0)) {
				$left = min(floatval($table_pos[$table][1] ?? 0), floatval($table_pos[$val["table"]][1] ?? 0)) - 1;
			} else {
				$base_left -= .1;
			}
			while ($lefts[(string) $left]) {
				// find free $left
				$left -= .0001;
			}
			$schema[$table]["references"][$val["table"]][(string) $left] = [$val["source"], $val["target"]];
			$referenced[$val["table"]][$table][(string) $left] = $val["target"];
			$lefts[(string) $left] = true;
		}
	}

	// The table box consists of the header row and one row per field, each 1.4em high. 1em is the gap between boxes.
	$top = max($top, round($schema[$table]["pos"][0] + $line_height + $pos + 1, 2));
}

echo "<div id='schema' style='height: {$top}em;'>\n";

foreach ($schema as $name => $table) {
	$height = round($line_height + count($table["fields"]) * $line_height + 0.4, 2);
	echo "<div class='table' style='top: " . $table["pos"][0] . "em; left: " . $table["pos"][1] . "em; height: {$height}em;'>";

	// Only the content is draggable, the reference lines reaching out of the box are not.
	echo "<div class='content'>";
	echo '<h4><a href="' . h(ME) . 'table=' . urlencode($name) . '">' . h($name) . "</a></h4>";

	echo "<ul>";
	foreach ($table["fields"] as $field) {
		$val = '<span ' . type_class($field["type"]) . ' title="' .
			h($field["type"] . ($field["length"] ? "($field[length])" : "") . ($field["null"] ? " NULL" : '')) .
			'">' . h($field["field"]) . '</span>';
		echo "<li>" . ($field["primary"] ? "<i>$val</i>" : $val) . "</li>";
	}
	echo "</ul>";

	echo "</div>";

	foreach ((array) $table["references"] as $target_name => $refs) {
		foreach ($refs as $left => $ref) {
			$left1 = $left - ($table_pos[$name][1] ?? 0);
			$i = 0;
			foreach ($ref[0] as $source) {
				echo "\n<div class='references outgoing' title='", h($target_name), "' id='refs$left-$i' style='left: {$left1}em; top: ", $field_pos[$name][$source], "em;'>",
					"<div style='width: " . (-$left1) . "em;'></div>",
					"</div>";
				$i++;
			}
		}
	}

	foreach ((array) $referenced[$name] as $target_name => $refs) {
		foreach ($refs as $left => $columns) {
			$left1 = $left - ($table_pos[$name][1] ?? 0);
			$i = 0;
			foreach ($columns as $target) {
				echo "\n<div class='references incoming' title='", h($target_name), "' id='refd$left-$i' style='left: {$left1}em; top: " . $field_pos[$name][$target] . "em;'>",
					"<svg viewBox='0 0 22 22' fill='currentColor'><path d='M11,19l10,-8l-10,-8l0,16Z'/></svg>",
					"<div style='width: " . (-$left1) . "em;'></div>",
					"</div>";
				$i++;
			}
		}
	}

	echo "\n</div>\n";
}

foreach ($schema as $name => $table) {
	foreach ((array) $table["references"] as $target_name => $refs) {
		if ($schema[$target_name]) { // otherwise table in another schema
			foreach ($refs as $left => $ref) {
				$min_pos = $top;
				$max_pos = -10;
				foreach ($ref[0] as $key => $source) {
					$pos1 = $table["pos"][0] + $field_pos[$name][$source];
					$pos2 = $schema[$target_name]["pos"][0] + $field_pos[$target_name][$ref[1][$key]];
					$min_pos = round(min($min_pos, $pos1, $pos2), 2);
					$max_pos = round(max($max_pos, $pos1, $pos2), 2);
				}
				echo "<div class='references vertical' id='refl$left' style='left: $left" . "em; top: $min_pos" . "em;'>" .
					"<div style='height: " . round($max_pos - $min_pos, 2) . "em;'></div></div>\n";
			}
		}
	}
}

echo "</div>\n";
echo script("initSchema('" . js_escape(DB) . "', $top, {" . implode(",", $table_pos_js) . "})");

echo "<p class='links'>";
echo "<a href='", (ME . "schema=" . urlencode($SCHEMA)), "' id='schema-link'>", lang('Permanent link'), "</a>";
echo "</p>\n";
