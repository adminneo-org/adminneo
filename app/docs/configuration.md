Configuration
=============

You can define a configuration as a constructor parameter. Create `index.php` file implementing `create_adminneo()`
method that returns configured Admin instance.

```php
<?php

use AdminNeo\Admin;

function create_adminneo(): Admin 
{
    // Define configuration.
    $config = [
        "colorVariant" => "green",
    ];
	
    return new Admin($config);
}

// Include original AdminNeo.
include "adminneo.php";
```

Options
-------

### theme

- Default value: `default`
- Available in EditorNeo: YES

Theme code. Available themes are: `default`. Make sure that the theme is compiled into the final single file. If the
theme is not found, the default theme will be used.

### colorVariant

- Default value: `blue`
- Available in EditorNeo: YES

Theme color code. Available variants are: `blue`, `green`, `red`. Make sure that the color variant is compiled into the 
final single file together with the selected theme. If the color variant is not found, blue color will be used.

### cssUrls

- Default value: `[]`
- Available in EditorNeo: YES

List of custom CSS files.

### jsUrls

- Default value: `[]`
- Available in EditorNeo: YES

List of custom Javascript files.

### navigationMode

- Default value: `simple`
- Available in EditorNeo: no

Main navigation mode that affects the left menu with the list of tables and top links.

- `simple` - Only one primary link is displayed in the left menu.
- `dual` - Both primary link and secondary icon are displayed in the left menu.
- `reversed` - Dual mode with reversed order of the primary link and secondary icon.

### preferSelection

- Default value: `false`
- Available in EditorNeo: no

Whether data selection is the primary action for all table links.

### jsonValuesDetection

- Default value: `false`
- Available in EditorNeo: no

Whether to detect JSON objects and arrays in text columns. Detected JSON values will be displayed with syntax 
highlighting.

### jsonValuesAutoFormat

- Default value: `false`
- Available in EditorNeo: no

Whether to automatically format JSON values while editing. JSON values will be pretty-formatted in edit fields and
minified before writing to database.

### enumAsSelectThreshold

- Default value: `5`
- Available in EditorNeo: YES

Threshold for displaying `<select>` for `enum` fields instead of radio list in edit form. If number of enum values is 
greater than this threshold, select will be used. Set `null` to disable the threshold.

### recordsPerPage

- Default value: `50`
- Available in EditorNeo: YES

Number of selected records per one page.

### versionVerification

- Default value: `true`
- Available in EditorNeo: YES

Whether verification of the new Adminer's version is enabled.

### hiddenDatabases

- Default value: `[]`
- Available in EditorNeo: no

List of databases to hide from the UI. Value `__system` will be expanded to all system databases for the current driver.
The `*` character can be used as a wildcard.

⚠️ Warning: Access to these databases is not restricted. They can be still selected by modifying URL parameters.

For example:
```php
$config = [
    "hiddenDatabases" => ["__system", "some_other_database"],
];
```

### hiddenSchemas

- Default value: `[]`
- Available in EditorNeo: no

List of schemas to hide from the UI. Value `__system` will be expanded to all system schemas for the current driver.
The `*` character can be used as a wildcard.

⚠️ Warning: Access to these schemas is not restricted. They can be still selected by modifying URL parameters.

For example:
```php
$config = [
    "hiddenSchemas" => ["__system", "some_other_schema"],
];
```

### visibleCollations

- Default value: `[]` (no filtering is applied)
- Available in EditorNeo: no

List of collations to keep in the select box when editing databases or tables. The `*` character can be used as a 
wildcard. If an existing table or row uses a different collation, it will also be preserved in the select box.

For example:
```php
$config = [
    "visibleCollations" => ["ascii_general_ci", "utf8mb4*czech*ci"],
];
```

Note: Access to other collations will be not restricted.

### defaultDriver

- Default value: `null`
- Available in EditorNeo: YES

Default driver for login form. Given value is validated against available drivers. If driver is not set or not invalid,
the first available driver will be used.

### defaultPasswordHash

- Default value: `null`
- Available in EditorNeo: YES

By default, AdminNeo does not allow access to a database without a password. This affects password-less databases such 
as SQLite, SimpleDB or Elasticsearch. In this parameter, you can specify a hash of the default password to enable 
internal authentication. The given password will be validated by AdminNeo and not passed to the database itself.

Set to an empty string to allow connection without a password.

⚠️ Warning: Use disabling default password on your own risk and put other sufficient safety measures in place.

### sslKey

- Default value: `null`
- Available in EditorNeo: YES

MySQL: The path name to the SSL key file.

### sslCertificate

- Default value: `null`
- Available in EditorNeo: YES

MySQL: The path name to the certificate file.

### sslCaCertificate

- Default value: `null`
- Available in EditorNeo: YES

MySQL: The path name to the certificate authority file.

### sslTrustServerCertificate

- Default value: `null`
- Available in EditorNeo: YES

MySQL, MS SQL: Whether to trust server certificate. Values: `true`, `false`, `null` (connection parameter is not set).

### sslEncrypt

- Default value: `null`
- Available in EditorNeo: YES

MS SQL: Whether the communication is encrypted. Values: `true`, `false`, `null` (connection parameter is not set).

### sslMode

- Default value: `null`
- Available in EditorNeo: YES

PostgreSQL: Value for [sslmode connection parameter](https://www.postgresql.org/docs/current/libpq-connect.html#LIBPQ-CONNECT-SSLMODE).

### servers

- Default value: `[]`
- Available in EditorNeo: no

List of predefined server connections. Each server connection has parameters:

| Parameter  | Required | Description                                                                          |
|------------|----------|--------------------------------------------------------------------------------------|
| `driver`   | YES      | Driver code: `mysql`, `pgsql`, `elastic`, etc. ([available drivers](/admin/drivers)) |
| `server`   | no       | Server address.                                                                      |
| `database` | no       | Database name, or file path to SQLite file.                                          |
| `name`     | no       | Custom server name.                                                                  |
| `username` | no       | Database user that will be used to log in.                                           |
| `password` | no       | Database user's password.                                                            |
| `config`   | no       | Configuration parameters that overrides global config.                               |

For example:
```php
$config = [
    "servers" => [
        ["driver" => "mysql", "name" => "Devel DB", "config" => ["colorVariant" => "green"]],
        ["driver" => "pgsql", "server" => "localhost:5432", "database" => "postgres"],
        ["driver" => "sqlite", "database" => "/projects/my-service/test.db", "config" => ["defaultPasswordHash" => ""]],
    ],
];
```

Username and password are used to log in to the database if the login form is submitted with empty credentials. This can
be used to simplify the login process on a development environment.

Global parameters that can't be overridden by server connection: `servers`.
