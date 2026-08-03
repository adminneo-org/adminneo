<?php

namespace AdminNeo;

Connection::get()->selectDatabase(Admin::get()->getDatabase());
if (support("scheme")) {
	$schema = get_schema();
	if ($schema != "") {
		set_schema($schema);
	}
}
