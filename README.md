AdminNeo
==========

**AdminNeo** is a full-featured database management tool written in PHP. It consists of a single file ready to deploy 
to the target server. As a companion, **EditorNeo** offers data manipulation for end-users. 

Supported database drivers:
- MySQL, MariaDB, PostgreSQL, SQLite, MS SQL, Oracle, MongoDB
- With plugin: SimpleDB, Elasticsearch (beta), Firebird (alpha), ClickHouse (alpha)

AdminNeo is based on the [Adminer](https://www.adminer.org/) project by Jakub Vrána.

| <img src="/docs/images/screenshot-select.webp?raw=true" alt="Screenshot - Select data"/> | <img src="/docs/images/screenshot-structure.webp?raw=true" alt="Screenshot - Table structure"/> |
|------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| <img src="/docs/images/screenshot-alter.webp?raw=true" alt="Screenshot - Alter table"/>  | <img src="/docs/images/screenshot-database.webp?raw=true" alt="Screenshot - Database"/>         |

Requirements
------------

- PHP 7.1+ with enabled sessions, modern web browser.

Security
--------

AdminNeo does not allow connecting to databases without a password, and it rate-limits connection attempts to protect
against brute force attacks. However, it is highly recommended to **restrict access to AdminNeo** 🔒 by whitelisting IP
addresses allowed to connect to it, by password protecting access in your web server, or by enabling security plugins
(e.g. to require an OTP).

Migration from older versions
-----------------------------

Version 5 has been significantly redesigned and refactored. Unfortunately, this has resulted in many changes that break
backward compatibility.

A complete list of changes can be found in the [Upgrade Guide](/docs/upgrade.md).

Usage
-----

Download one for the latest [release files](https://github.com/adminneo-org/adminneo/releases), upload to the HTTP server 
with PHP and enjoy 😉 If you are not satisfied with any combination of the database driver, language and theme, you can 
download the source code and compile your own AdminNeo:

- Download the source code.
- Run `composer install` to install dependencies.
- Run bin/compile.php:

```shell
# AdminNeo
php bin/compile.php [drivers] [languages] [themes] [config-file.json]

# EditorNeo
php bin/compile.php editor [drivers] [languages] [themes] [config-file.json]
```

Where:
- `drivers` is a comma-separated list of [database drivers](/admin/drivers) or the value `all-drivers`.
  The default set is: mysql, pgsql, mssql, sqlite.
- `languages` is a comma-separated list of [languages](/admin/lang).
  If not specified, all languages will be included.
- `themes` is a comma-separated list of [themes](/admin/themes).
  If not specified, only the default theme with blue color variant will be included. The `+` character can be used as 
  a wildcard in the theme name.
- `config-file.json` is a path to the custom JSON configuration file. It contains a class with [the same parameters](#configuration) 
  that can be configured in Admin constructor.

If the theme name contains a postfix with one of the supported color variants (-green, -red), the corresponding favicons
will be included automatically.

For examples:
```shell
# Default set of drivers, all languages, default theme (without color variants).
php bin/compile.php

# Only pgsql driver, only EN language, default theme.
php bin/compile.php pgsql en

# Only mysql and pgsql driver, selected languages, default theme.
php bin/compile.php mysql,pgsql en,de,cs,sk

# Default set of drivers, all languages, green and red color variants of the default theme.
php bin/compile.php default-green,default-red

# Default theme together with all color variants.
php bin/compile.php default+

# Custom configuration.
php bin/compile.php ~/my-config.json
```

Editor examples:
```shell
# Default set of drivers, all languages, default theme (without color variants).
php bin/compile.php editor

# Only pgsql driver, only EN language, default theme with all color variants.
php bin/compile.php editor pgsql en default+
```

JSON configuration file example:
```json
{
    "navigationMode": "reversed"
}
```

Configuration
-------------

You can define a configuration as a constructor parameter. Create `index.php` file implementing `create_adminneo()` 
method that returns configured `Admin` instance.

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

// Include AdminNeo file.
include "adminneo.php";
```

### Configuration parameters

All parameters available in AdminNeo are listed in the following table. Parameters available in EditorNeo are labeled in
Editor column.

For detailed information see [Configuration documentation](/docs/configuration.md).

| Parameter                   | Default   | Editor | Description                                                                                                                                         |
|-----------------------------|-----------|--------|-----------------------------------------------------------------------------------------------------------------------------------------------------|
| `theme`                     | `default` | YES    | Theme code. Available themes are: `default`.                                                                                                        |
| `colorVariant`              | `blue`    | YES    | Theme color variant. Available variants are: `blue`, `green`, `red`.                                                                                |
| `cssUrls`                   | `[]`      | YES    | List of custom CSS files.                                                                                                                           |
| `jsUrls`                    | `[]`      | YES    | List of custom Javascript files.                                                                                                                    |
| `navigationMode`            | `simple`  | no     | Main navigation mode that affects the left menu with the list of tables and top links: `simple`, `dual`, `reversed`.                                |
| `preferSelection`           | `false`   | no     | Whether data selection is the primary action for all table links.                                                                                   |
| `jsonValuesDetection`       | `false`   | no     | Whether to detect JSON objects and arrays in text columns.                                                                                          |
| `jsonValuesAutoFormat`      | `false`   | no     | Whether to automatically format JSON values while editing.                                                                                          |
| `recordsPerPage`            | `50`      | YES    | Number of selected records per one page.                                                                                                            |
| `versionVerification`       | `true`    | YES    | Whether verification of the new AdminNeo's version is enabled.                                                                                      |
| `hiddenDatabases`           | `[]`      | no     | List of databases to hide from the UI. Value `__system` will be expanded to all system databases. Access to these databases will be not restricted. |
| `hiddenSchemas`             | `[]`      | no     | List of schemas to hide from the UI. Value `__system` will be expanded to all system schemas. Access to these schemas will be not restricted.       |
| `visibleCollations`         | `[]`      | no     | List of collations to keep in select boxes while editing databases or tables.                                                                       |
| `defaultDriver `            | `null`    | YES    | Default driver for login form.                                                                                                                      |
| `defaultPasswordHash`       | `null`    | YES    | Hash of the default password for authentication to password-less databases. Set to an empty string to allow connection without password.            |
| `sslKey`                    | `null`    | YES    | MySQL: The path name to the SSL key file.                                                                                                           |
| `sslCertificate`            | `null`    | YES    | MySQL: The path name to the certificate file.                                                                                                       |
| `sslCaCertificate`          | `null`    | YES    | MySQL: The path name to the certificate authority file.                                                                                             |
| `sslMode`                   | `null`    | YES    | PostgreSQL: Value for [sslmode connection parameter](https://www.postgresql.org/docs/current/libpq-connect.html#LIBPQ-CONNECT-SSLMODE).             |
| `sslEncrypt`                | `null`    | YES    | MS SQL: Value for [Encrypt connection option](https://learn.microsoft.com/en-us/sql/connect/php/connection-options).                                |
| `sslTrustServerCertificate` | `null`    | YES    | MS SQL: Value for [TrustServerCertificate connection option](https://www.postgresql.org/docs/current/libpq-connect.html#LIBPQ-CONNECT-SSLMODE).     |
| `servers`                   | `[]`      | no     | List of predefined server connections.                                                                                                              |

Plugins
-------

AdminNeo functions can be changed or extended by plugins. Plugins are managed by `Pluginer` customization class. 

* Download `Pluginer.php` and plugins you want and place them into the `plugins` folder.
* Create `index.php` file implementing `create_adminneo()` method that returns Pluginer instance.

File structure will be:

```
- plugins
    - Pluginer.php
    - dump-xml.php
    - tinymce.php
    - file-upload.php
    - ...
- adminneo.php
- index.php
```

Index.php:

```php
<?php

use AdminNeo\Pluginer;

function create_adminneo(): Pluginer
{
    // Required to run any plugin.
    include "plugins/Pluginer.php";
    
    // Include plugins.
    include "plugins/dump-xml.php";
    include "plugins/tinymce.php.php";
    include "plugins/file-upload.php";
    
    // Enable plugins.
    $plugins = [
        new XmlDumpPlugin(),
        new TinyMcePlugin(),
        new FileUploadPlugin("data/"),
        // ...
    ];
    
    // Define configuration.
    $config = [
        "colorVariant" => "green",
    ];
    
    return new Pluginer($plugins, $config);
}

// Include AdminNeo or EditorNeo.
include "adminneo.php";
```

[Available plugins](plugins).

Custom CSS and Javascript
-------------------------

It is possible to modify the appearance and functionality by creating a custom CSS or Javasrtipt file. AdminNeo will
automatically include files **adminneo.css**, **adminneo-light.css**, **adminneo-dark.css** and **adminneo.js** that are
placed in the AdminNeo's current working directory (typically next to the index.php).

Custom adminneo.css should be compatible with automatic switching to dark mode. File adminneo-light.css will force 
AdminNeo to use only light mode, file adminneo-dark.css will force dark mode.

Main project files
------------------

- admin/index.php - Run development version of AdminNeo.
- editor/index.php - Run development version of EditorNeo.
- editor/example.php - Example Editor customization.
- admin/plugins.php - Plugins demo.
- admin/sqlite.php - Development version of AdminNeo with SQLite allowed.
- editor/sqlite.php - Development version of Editor with SQLite allowed.
- bin/compile.php - Create a single file version.
- bin/update-languages.php - Update language files.
- tests/katalon.html - Katalon Automation Recorder test suite.

What to expect
--------------

Our top priority is fixing the security issues and reported bugs. But we also want to move forward and transform
AdminNeo to a tool with clean modern UI and simple configuration.

### Version 4.x

Original design and backward compatibility is maintained. Many bugs have been fixed and several functional and 
UI improvements have been introduced.

### Version 5

Bridges are burned 🔥🔥🔥. Our goals are:

- **Requirements** - Bump minimal PHP to 7.1. 
- **Themes** – Brand-new default theme based on our old [Adminer theme](https://github.com/pematon/adminer-theme). It will support dark mode and configurable 
color variants for production/devel environment. All current designs will be removed. 
- **Plugins** - Integrate several basic plugins, enable them by simple optional configuration.
- **Codebase** - Prefer code readability before minimalism, use PER coding style, add a namespace.
- **Compilation** - Allow to export selected drivers, themes, languages and plugins into a single PHP file.
