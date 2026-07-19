<?php

namespace AdminNeo;

Connection::get()->selectDatabase(Admin::get()->getDatabase());
if (support("scheme")) {
	set_schema(get_schema());
}
