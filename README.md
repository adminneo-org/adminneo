AdminNeo
==========

**AdminNeo** is a full-featured database management tool written in PHP. It consists of a single file ready to deploy 
to the target server. As a companion, **EditorNeo** offers data manipulation for end-users.

AdminNeo is based on the [Adminer](https://www.adminer.org/) project by Jakub Vrána.

| <img src="https://raw.githubusercontent.com/adminneo-org/adminneo/refs/heads/main/docs/images/screenshot-select.webp" alt="Screenshot - Select data"/> | <img src="https://raw.githubusercontent.com/adminneo-org/adminneo/refs/heads/main/docs/images/screenshot-structure.webp" alt="Screenshot - Table structure"/> |
|--------------------------------------------------------------------------------------------------------------------------------------------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------|
| <img src="https://raw.githubusercontent.com/adminneo-org/adminneo/refs/heads/main/docs/images/screenshot-alter.webp" alt="Screenshot - Alter table"/>  | <img src="https://raw.githubusercontent.com/adminneo-org/adminneo/refs/heads/main/docs/images/screenshot-database.webp" alt="Screenshot - Database"/>         |

### Key features
- Clean modern user interface
- Managing the structure of databases and tables
- Data manipulation and searching
- Exporting and importing databases and data
- Executing batch SQL commands
- Extendable by plugins
- And much more…

### Supported databases

- MySQL, MariaDB, PostgreSQL, MS SQL, SQLite, Oracle
- MongoDB, SimpleDB
- Elasticsearch, ClickHouse (alpha)

Installation
------------

Just a few steps to start using AdminNeo:
- Download the latest release from [adminneo.org/download](https://www.adminneo.org/download).
- Upload it to your HTTP server with PHP.
- Take the appropriate [security measures](https://www.adminneo.org/download#security).
- Enjoy 😉

AdminNeo can be also [configured](https://www.adminneo.org/configuration) and extended by
[plugins](https://www.adminneo.org/plugins) or [customizations](https://www.adminneo.org/customizations).
For accessing a database that does not support a password, see [further instructions](https://www.adminneo.org/password).

Requirements
------------

- PHP 5.4+ with enabled sessions, modern web browser.
- Running AdminNeo from the source code requires PHP 7.1+.

It is also recommended to install [OpenSSL PHP extension](https://www.php.net/manual/en/book.openssl.php) for improved
security of stored login information.

Migrating from older versions
-----------------------------

Version 5 has been significantly redesigned and refactored. Unfortunately, this has resulted in many changes that break
backward compatibility.

A complete list of changes can be found in the [Upgrade Guide](https://www.adminneo.org/upgrade).

Docker
------

The official Docker image is available on [Docker Hub](https://hub.docker.com/r/adminneoorg/adminneo). Follow the
instructions on the Docker page to get started.

Main project files
------------------

- admin/index.php - Development version of AdminNeo.
- editor/index.php - Development version of EditorNeo.
- bin/compile.php - Create a single file version.
- bin/update-translations.php - Update translation files.
- examples - Examples of customizations and plugins usage.
- tests - Katalon Automation Recorder test suites.

Updating translations 
---------------------

- Download the current source code.
- Run `php bin/update-translations.php [language]` where `language` is the language code (e.g. `de`).
- Translate all missing texts with `null` values and/or correct existing translations.
- Create a pull request or send your updates by another channel (e.g., in new GitHub issue).
