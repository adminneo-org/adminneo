<?php

namespace AdminNeo;

$title2 = h(": " . DB . ($_GET["ns"] ? ".$_GET[ns]" : ""));
page_header(lang('Database schema') . $title2, [lang('Database schema')]);

$table_pos = [];
$table_pos_js = [];
$SCHEMA = ($_GET["schema"] ?: $_COOKIE["neo_schema-" . str_replace(".", "_", DB)]); // $_COOKIE["neo_schema"] was used before 3.2.0 //! ':' in table name
preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $SCHEMA, $matches, PREG_SET_ORDER);
foreach ($matches as $i => $match) {
	$table_pos[$match[1]] = [$match[2], $match[3]];
	$table_pos_js[] = "\n\t'" . js_escape($match[1]) . "': [ $match[2], $match[3] ]";
}

$top = 0;
$base_left = -1;
$schema = []; // table => array("fields" => array(name => field), "pos" => array(top, left), "references" => array(table => array(left => array(source, target))))
$referenced = []; // target_table => array(table => array(left => target_column))
$lefts = []; // float => bool
$all_fields = Driver::get()->getAllFields();
foreach (table_status('', true) as $table => $table_status) {
	if (is_view($table_status)) {
		continue;
	}
	$pos = 0;
	$schema[$table]["fields"] = [];
	foreach ($all_fields[$table] as $field) {
		$pos += 1.25;
		$field["pos"] = $pos;
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
	$top = max($top, $schema[$table]["pos"][0] + 2.5 + $pos);
}

?>
<div id="schema" style="height: <?php echo $top; ?>em;">
<script<?php echo nonce(); ?>>
gid('schema').onselectstart = function () { return false; };
var tablePos = {<?php echo implode(",", $table_pos_js) . "\n"; ?>};
var em = gid('schema').offsetHeight / <?php echo $top; ?>;
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, '<?php echo js_escape(DB); ?>');
</script>
<?php
foreach ($schema as $name => $table) {
	echo "<div class='table' style='top: " . $table["pos"][0] . "em; left: " . $table["pos"][1] . "em;'>";
	echo '<a href="' . h(ME) . 'table=' . urlencode($name) . '"><b>' . h($name) . "</b></a>";
	echo script("qsl('div').onmousedown = schemaMousedown;");

	foreach ($table["fields"] as $field) {
		$val = '<span' . type_class($field["type"]) . ' title="' . h($field["type"] . ($field["length"] ? "($field[length])" : "") . ($field["null"] ? " NULL" : '')) . '">' . h($field["field"]) . '</span>';
		echo "<br>" . ($field["primary"] ? "<i>$val</i>" : $val);
	}

	foreach ((array) $table["references"] as $target_name => $refs) {
		foreach ($refs as $left => $ref) {
			$left1 = $left - ($table_pos[$name][1] ?? 0);
			$i = 0;
			foreach ($ref[0] as $source) {
				echo "\n<div class='references' title='", h($target_name), "' id='refs$left-$i' style='left: {$left1}em; top: ", $table["fields"][$source]["pos"], "em; padding-top: .5em;'>",
					"<div style='border-top: 1px solid Gray; width: " . (-$left1) . "em;'></div>",
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
				echo "\n<div class='references' title='", h($target_name), "' id='refd$left-$i' style='left: {$left1}em; top: " . $table["fields"][$target]["pos"] . "em; height: 1.25em;'>",
					"<svg style='width: 1em; height: 1em; float: right;' viewBox='0 0 22 22' fill='currentColor'><path d='M11,19l10,-8l-10,-8l0,16Z'/></svg>",
					"<div style='height: .5em; border-bottom: 1px solid Gray; width: " . (-$left1) . "em;'></div>",
					"</div>";
				$i++;
			}
		}
	}

	echo "\n</div>\n";
}

foreach ($schema as $name => $table) {
	foreach ((array) $table["references"] as $target_name => $refs) {
		foreach ($refs as $left => $ref) {
			$min_pos = $top;
			$max_pos = -10;
			foreach ($ref[0] as $key => $source) {
				$pos1 = $table["pos"][0] + $table["fields"][$source]["pos"];
				$pos2 = $schema[$target_name]["pos"][0] + $schema[$target_name]["fields"][$ref[1][$key]]["pos"];
				$min_pos = min($min_pos, $pos1, $pos2);
				$max_pos = max($max_pos, $pos1, $pos2);
			}
			echo "<div class='references' id='refl$left' style='left: $left" . "em; top: $min_pos" . "em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: " . ($max_pos - $min_pos) . "em;'></div></div>\n";
		}
	}
}
?>
</div>
<p class="links"><a href="<?php echo h(ME . "schema=" . urlencode($SCHEMA)); ?>" id="schema-link"><?php echo lang('Permanent link'); ?></a>
