jush.tr.json = { php: jush.php, json_obj: /\{/, json_arr: /\[/, quo: /"/, num: jush.num, json_const: /\b(?:true|false|null)\b/ };
jush.tr.json_obj = { php: jush.php, json_val: /:/, _1: /\s*}/, json_key: /()/ };
jush.tr.json_key = { php: jush.php, quo: /"/, _1: /(?=[:}])/ };
jush.tr.json_val = { php: jush.php, quo: /"/, num: jush.num, json_const: /\b(?:true|false|null)\b/, json_arr: /\[/, json_obj: /\{/, _1: /,|(?=})/ };
jush.tr.json_arr = { php: jush.php, quo: /"/, num: jush.num, json_const: /\b(?:true|false|null)\b/, json_arr: /\[/, json_obj: /\{/, _1: /]/ };
jush.tr.json_const = { _1: /()/ };