AdminNeo
==========

**AdminNeo** is a full-featured database management tool written in PHP. It consists of a single file ready to deploy 
to the target server. As a companion, **EditorNeo** offers data manipulation for end-users. 

Supported database drivers:
- MySQL, MariaDB, PostgreSQL, SQLite, MS SQL, Oracle, MongoDB, SimpleDB, Elasticsearch (beta), ClickHouse (alpha)

AdminNeo is based on the [Adminer](https://www.adminer.org/) project by Jakub Vrána.

| <img src="/docs/images/screenshot-select.webp?raw=true" alt="Screenshot - Select data"/> | <img src="/docs/images/screenshot-structure.webp?raw=true" alt="Screenshot - Table structure"/> |
|------------------------------------------------------------------------------------------|-------------------------------------------------------------------------------------------------|
| <img src="/docs/images/screenshot-alter.webp?raw=true" alt="Screenshot - Alter table"/>  | <img src="/docs/images/screenshot-database.webp?raw=true" alt="Screenshot - Database"/>         |

Requirements
------------

- PHP 5.4+ with enabled sessions, modern web browser.

It is also recommended to install [OpenSSL PHP extension](https://www.php.net/manual/en/book.openssl.php) for improved
security of stored login information.

Security
--------

AdminNeo does not allow connecting to databases without a password, and it also rate-limits connection attempts to protect
against brute force attacks. However, it is highly recommended to **restrict access to AdminNeo** 🔒 by whitelisting IP
addresses allowed to connect to it, by password protecting access in your web server or by enabling security plugins
(e.g., to require an OTP).

Migration from older versions
-----------------------------

Version 5 has been significantly redesigned and refactored. Unfortunately, this has resulted in many changes that break
backward compatibility.

A complete list of changes can be found in the [Upgrade Guide](/docs/upgrade.md).

Docker
------

The official Docker image is available at [Docker Hub](https://hub.docker.com/r/peterknut/adminneo). Please follow the
instructions on the Docker page to get started.

Usage
-----

Download one of the latest [release files](https://github.com/adminneo-org/adminneo/releases), upload to the HTTP server 
with PHP and enjoy 😉. If you are not satisfied with any combination of the database driver, language and theme, you can 
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
- `languages` is a comma-separated list of [languages](/admin/translations).
  If not specified, all languages will be included.
- `themes` is a comma-separated list of [themes](/admin/themes) together with specific color variant. E.g. 
  `default-blue`, `default-red`, etc. If not specified, only the `default-blue` theme will be included. The `+` 
  character can be used as a wildcard in the theme name.
- `config-file.json` is a path to the custom JSON configuration file. It contains a class with [the same parameters](#configuration) 
  that can be configured in Admin constructor.

If the theme name contains a postfix with one of the supported color variants (-green, -red), the corresponding favicons
will be included automatically.

For example:
```shell
# Default set of drivers, all languages, only default-blue theme.
php bin/compile.php

# Only pgsql driver, only EN language, only default-blue theme.
php bin/compile.php pgsql en

# Only mysql and pgsql driver, selected languages, only default-blue theme.
php bin/compile.php mysql,pgsql en,de,cs,sk

# Default set of drivers, all languages, green and red color variants of the default theme. 
# Blue color variant will be not available.
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

Configuration can be defined in `adminneo-config.php` file placed in the AdminNeo's current working directory. 
A simple file structure will be:

```
– adminneo.php
– adminneo-config.php
```

You can freely rename adminneo.php to index.php.

The file adminneo-config.php will just return the configuration array:

```php
<?php

// Define configuration.
return [
    "colorVariant" => "green",
];
```

### Configuration parameters

All parameters available in AdminNeo are listed in the following table. Parameters available in EditorNeo are labeled in
the Editor column.

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
| `enumAsSelectThreshold`     | `5`       | YES    | Threshold for displaying `<select>` for `enum` fields instead of radio list in edit form.                                                           |
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
| `sslTrustServerCertificate` | `null`    | YES    | MySQL, MS SQL: Whether to trust server certificate. Values: `true`, `false`, `null`.                                                                |
| `sslEncrypt`                | `null`    | YES    | MS SQL: Whether the communication is encrypted. Values: `true`, `false`, `null`.                                                                    |
| `sslMode`                   | `null`    | YES    | PostgreSQL: Value for [sslmode connection parameter](https://www.postgresql.org/docs/current/libpq-connect.html#LIBPQ-CONNECT-SSLMODE).             |
| `servers`                   | `[]`      | no     | List of predefined server connections.                                                                                                              |

Plugins
-------

AdminNeo functions can be modified or extended by plugins. 

* Download plugins you want and place them into the `adminneo-plugins` folder. All plugins in this folder will be
  autoloaded (but not enabled).
* Define the list of enabled plugins in `adminneo-plugins.php` file.

File structure will be:

```
- adminneo-plugins
    - JsonPreviewPlugin.php
    - XmlDumpPlugin.php
    - FileUploadPlugin.php
    - ...
- adminneo.php
- adminneo-plugins.php
```

adminneo-plugins.php:

```php
<?php
  
// Enable plugins. Files in `adminneo-plugins` are autoloaded, so including the source files is not necessary.
return [
    new \AdminNeo\JsonPreviewPlugin(),
    new \AdminNeo\XmlDumpPlugin(),
    new \AdminNeo\FileUploadPlugin("data/"),
    // ...
];
```

[Available plugins](plugins).

Advanced customizations
-----------------------

The final option is overriding methods in the `Admin` class. It can be done in `adminneo-instance.php` file.

File structure will be:

```
- adminneo.php
- adminneo-instance.php
```

adminneo-instance.php:

```php
<?php
class CustomAdmin extends \AdminNeo\Admin
{
    public function getServiceTitle(): string
    {
        return "Custom Service";
    }
}

// Use factory method to create CustomAdmin instance.
return CustomAdmin::create();
```

Factory method create() accepts also configuration and plugins, so everything can be defined in one 
`adminneo-instance.php` file:

```php
<?php

class CustomAdmin extends \AdminNeo\Admin
{
    public function getServiceTitle(): string
    {
        return "Custom Service";
    }
}

// Define configuration.
$config = [
    "colorVariant" => "green",
];

// Enable plugins.
$plugins = [
    new \AdminNeo\JsonPreviewPlugin(),
    new \AdminNeo\XmlDumpPlugin(),
    new \AdminNeo\FileUploadPlugin("data/"),
    // ...
];
    
// Use factory method to create CustomAdmin instance.
return CustomAdmin::create($config, $plugins);
```

### Custom index.php

It is also possible to create `Admin` instance inside your own index.php file. In this case, implement
`adminneo_instance()` function in the global namespace and include AdminNeo file placed in the **non-public** directory:

```php
<?php

function adminneo_instance() 
{
    // Define configuration.
    $config = [
        "colorVariant" => "green",
    ];
	
    // Use factory method to create Admin instance.
    return \AdminNeo\Admin::create($config);
}

// Include AdminNeo file.
include "/non-public-path/adminneo.php";
```

Or with derived class and plugins:

```php
<?php

function adminneo_instance() 
{
    class CustomAdmin extends \AdminNeo\Admin
    {
        public function getServiceTitle(): string
        {
            return "Custom Service";
        }
    }

    // Define configuration.
    $config = [
        "colorVariant" => "green",
    ];
    
    // Enable plugins.
    $plugins = [
        new \AdminNeo\JsonPreviewPlugin(),
        new \AdminNeo\XmlDumpPlugin(),
        new \AdminNeo\FileUploadPlugin("data/"),
        // ...
    ];
	
    // Use factory method to create Admin instance.
    return CustomAdmin::create($config, $plugins);
}

// Include AdminNeo file.
include "/non-public-path/adminneo.php";
```

Custom CSS and JavaScript
-------------------------

It is possible to modify the appearance and functionality by creating a custom CSS or JavaScript file. AdminNeo will
automatically include files `adminneo.css`, `adminneo-light.css`, `adminneo-dark.css` and `adminneo.js` that are
placed in the AdminNeo's current working directory (typically next to the index.php).

- adminneo.css - Should be compatible with automatic switching to dark mode.
- adminneo-light.css - Will force AdminNeo to use only the light mode.
- adminneo-dark.css - Will force the dark mode.

Main project files
------------------

- admin/index.php - Development version of AdminNeo.
- admin/plugins.php - Plugins example.
- editor/index.php - Development version of EditorNeo.
- editor/plugins.php - Plugins example.
- editor/example.php - Customizations example.
- editor/sqlite.php - SQLite example.
- bin/compile.php - Create a single file version.
- bin/update-translations.php - Update translation files.
- tests/katalon.html - Katalon Automation Recorder test suite.

What to expect
--------------

Our top priority is fixing the security issues and reported bugs. But we also want to move forward and transform
AdminNeo to a tool with a clean modern UI and simple configuration.

### Version 4.x

Original design and backward compatibility is maintained. Many bugs have been fixed and several functional and 
UI improvements have been introduced.

### Version 5

Bridges are burned 🔥🔥🔥. Our goals are:

- **Themes** – Brand-new default theme based on our old [Adminer theme](https://github.com/pematon/adminer-theme). It will support dark mode and configurable 
color variants for production/devel environment. All current designs will be removed. 
- **Plugins** - Integrate several basic plugins, enable them by simple optional configuration.
- **Codebase** - Prefer code readability before minimalism, use PER coding style, add a namespace.
- **Compilation** - Allow to export selected drivers, themes, languages and plugins into a single PHP file.
