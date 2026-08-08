# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

AdminNeo is a full-featured database management tool written in PHP (based on Adminer). The defining architectural feature is that all source files compile down to **a single deployable PHP file**. EditorNeo is a companion end-user data editor that shares much of the same codebase.

Supported databases: MySQL/MariaDB, PostgreSQL/CockroachDB, MS SQL, SQLite, Oracle, MongoDB, SimpleDB, Elasticsearch and ClickHouse.

## Commands

**Run dev server** (serves from repo root at port 8000):
```sh
make server
# or: php --server 127.0.0.1:8000 --docroot .
```

Then open `http://127.0.0.1:8000/admin/` (dev) or `http://127.0.0.1:8000/compiled/adminneo.php` (compiled).

**Compile to single file** (output goes to `compiled/`):
```sh
make compile
# or: php bin/compile.php
```

Compile with options:
```sh
php bin/compile.php [admin|editor] [drivers] [languages] [themes] [config.json] [-o output-file]

# Examples:
php bin/compile.php editor
php bin/compile.php admin mysql en default-green
php bin/compile.php admin mysql,pgsql en,cs,de
```

**Update translations:**
```sh
php bin/update-translations.php [language]   # e.g. php bin/update-translations.php de
```

**Tests:** Tests use Katalon Automation Recorder (browser-based). Test suite files are in `tests/katalon/`. Run via Katalon browser extension against a live server.

## Architecture

### Single-file compilation model

The build process in `bin/compile.php` concatenates all source PHP files into one file. Special `// !compile: <marker>` comments in source files mark injection points that the compiler replaces (e.g., translation tables, available languages, static asset data). When adding new compile-time substitutions, follow this pattern.

In dev mode, static assets (CSS/JS) are dynamically generated and cached in a temp directory. In compiled mode, they are inlined as base64-encoded strings switched by filename.

The code in compiled file is downgraded to support PHP 5.4 and above by calling `downgrade_php()`. This function does not cover all language features and constructs, so verify that compiled file is valid after every change.

### Plugin system

The plugin architecture is the primary extension mechanism:

- `Plugin` (abstract) — base class all plugins extend. Gets injected with `$admin`, `$config`, `$settings`, `$locale`.
- `Origin` (extends `Plugin`) — the base class with all overridable methods. `admin/core/Admin.php` and `editor/core/Admin.php` each independently define their own `class Admin extends Origin` (there is no separate `Editor` class — EditorNeo's customization classes also extend `Admin`).
- `Pluginer` — wraps an `Origin` instance; intercepts every public method call and dispatches to registered plugins first. For "append" methods (e.g., `getErrors`, `getFieldFunctions`), results from all plugins are merged. For others, the first plugin that returns a non-null value wins; the `Origin` instance is the fallback.

Custom instances are created via `Admin::create($config, $plugins)` (inherited from `Origin::create()`, using late static binding). The entry point for customization is a PHP file that defines `adminneo_instance()` returning this instance, then includes the compiled file.

### Routing

`admin/index.php` routes requests by checking `$_GET` keys (e.g., `$_GET["table"]`, `$_GET["select"]`, `$_GET["sql"]`). Each route includes the corresponding `.inc.php` file. Pages call `page_header()` at the start and `page_footer()` at the end, except when a page `exit`s early to skip the footer (e.g. `admin/download.inc.php`).

### Database drivers

Each driver lives in `admin/drivers/<name>.inc.php`. Drivers:
1. Register themselves with `Drivers::add(name, label, extensions)`.
2. Define constants `DRIVER` and `DIALECT` when active (`isset($_GET[$driver_name])`).
3. Implement a `Connection` subclass and a `Driver` subclass.
4. The abstract `Driver` class defines the interface; methods like `support($feature)` control which UI features are shown for that driver.

### Directory structure

| Path                  | Purpose                                                                                      |
|-----------------------|----------------------------------------------------------------------------------------------|
| `admin/`              | AdminNeo source (dev entry: `admin/index.php`)                                               |
| `admin/core/`         | Core classes: `Admin`, `Config`, `Settings`, `Driver`, `Plugin`, `Pluginer`, `Locale`, etc.  |
| `admin/drivers/`      | One file per supported database                                                              |
| `admin/include/`      | Shared functions, HTML helpers, auth, encryption, bootstrap                                  |
| `admin/translations/` | Language files returning PHP arrays                                                          |
| `admin/themes/`       | CSS theme files (variants: blue/green/orange/red)                                            |
| `editor/`             | EditorNeo (shares `admin/` drivers and most of `admin/include/`)                             |
| `bin/`                | Build scripts                                                                                |
| `plugins/`            | Bundled optional plugins                                                                     |
| `compiled/`           | Output of compilation (entirely gitignored, local build artifact)                            |
| `examples/`           | Customization and plugin usage examples                                                      |
| `externals/`          | Optional third-party assets (e.g. TinyMCE) used by some example plugins; gitignored          |
| `tests/`              | Katalon test suites and helper PHP files                                                     |
| `tests/unit/`         | Unit tests                                                                                   |
| `vendor/vrana/`       | Committed third-party libs used at runtime and build time (e.g. `jush` for SQL highlighting) |

### Configuration

`adminneo-config.php` (placed next to the entry point) returns a PHP array of config options. Key options include `colorVariant`, `navigationMode`, `servers`, `hiddenDatabases`, `defaultPasswordHash`. See `admin/core/Config.php` for all supported keys and `examples/adminneo-custom.php` for a full example.

`adminneo-plugins.php` (placed next to the entry point) returns an array of `Plugin` instances.

### Namespace

All PHP code lives under the `AdminNeo\` namespace.

### Translations

Translations use technical language and terms related to database systems. Czech language (`admin/translations/cs.inc.php`) is considered as correct because it was created by the author. All machine-translated texts are marked with trailing comment naming the AI model, e.g. `'Vacuum' => 'Počisti', // by Claude Fable 5`. In case of multiline translation, mark is placed on the last line.

To find missing translations, run `php bin/update-translations.php` — it adds new texts with a `null` value. In `en.inc.php` only plural texts are added, so a new plural shows up there once `_template.inc.php` holds multiple forms for it. Flags must follow the language argument.

The same script validates the files. A finished pass must print no `⚠️` warnings. It checks:

- **Placeholders** — types and order must match the English text.
- **Sentence-final punctuation** — must match whether the English text ends with a period: none for `he`, `।` for `bn`/`hi`, `。` for `ja`/`zh*`, `.` elsewhere.
- **Plural forms** — 4 for `sl`, 3 for `cs sk pl lt lv bs hr ru sr uk`, 2 otherwise. Languages with no numeral-driven agreement (ja, zh, ko, vi, tr, th, et) use a plain string instead of an array; identical plural forms are reported as an error.

### Commits

End the commit message with the standard `Co-Authored-By` line naming the used Claude model. The commit rules in [Porting changes from Adminer](#porting-changes-from-adminer) apply only to changes ported from Adminer and take precedence there — a simply adapted port carries no `Co-Authored-By` line of yours, a complex one does.

### Porting changes from Adminer

AdminNeo started as a fork of [Adminer](https://github.com/vrana/adminer) project and evolves in a standalone product with separated code base. The process of porting changes from original Adminer includes these steps:

- Fetch git repository if needed:
```shell
git remote add vrana git@github.com:vrana/adminer.git
git fetch vrana main --no-tags
```
- Find the commit (e.g. `git log vrana/main --oneline --grep="<keyword>" -i`) and inspect it with `git show <hash>`.
- Don't run a literal `git cherry-pick` — the two code bases have diverged enough (namespaces, driver structure, helper functions) that it will conflict badly. Instead, read the diff and reimplement the same behavior by hand in the current codebase:
  - Map each changed Adminer file to its AdminNeo equivalent; paths aren't always 1:1 (`adminer/` → `admin/`, and a database's code can move between a `plugins/drivers/*.php` optional plugin upstream and a built-in `admin/drivers/*.inc.php` driver here, or vice versa). Skip files for databases AdminNeo doesn't support.
  - If the target code isn't where expected, grep for the specific functions/symbols the commit touches (not just the file) before concluding it is inapplicable — sometimes it moved, sometimes it's genuinely gone (e.g. a legacy PHP extension AdminNeo dropped, like old `ext/mysql` support). "Nothing to port" is a valid, complete outcome once you've confirmed the code isn't there under any name.
  - Grep for the changed function/pattern across `admin/`, `editor/`, and `plugins/` — AdminNeo may have more or fewer call sites than upstream for the same code.
  - Match AdminNeo's current APIs and idioms rather than copying the old code verbatim (e.g. `$connection->isMinVersion()`, not the deprecated `min_version()`; use `??` instead of `idx()` helper; always use short array syntax). If AdminNeo's version already diverged from upstream at the touched spot, preserve that divergence while applying the fix rather than reverting to upstream's simpler version.
  - Ignore changes of upstream's git submodules.
  - Use `// by AI model name` mark in translations instead of `// AI model name`.
- Update `CHANGELOG.md` only if the original Adminer commit itself added a line there:
  - When porting a line: keep the original wording but bug/issue references.
  - Add "(by @author)" where `@author` is the GitHub user who wrote the commit. But only if adaptation is simple and straight forward.
  - Adapt release version in "regression from X" note to AdminNeo's releases.
  - Place it under `### Changes` or `### Bugfixes` to match its nature.
- If changes adaptation for AdminNeo is simple and straight forward, then:
  - Commit with the original author and author-date preserved (committer/date stay as yours), e.g.:
  ```shell
  GIT_AUTHOR_NAME="..." GIT_AUTHOR_EMAIL="..." GIT_AUTHOR_DATE="<iso-date-from-original-commit>" git commit -m "..."
  ```
  - Remove the bug/issue reference from the commit message subject, add a message line instead:
  ```
  Issue: https://github.com/vrana/adminer/issues/<issue_id>
  ```
  - Don't add your own `Co-Authored-By` signature, but keep original one if present.
- If adaptation is more complex, then:
  - Don't commit automatically. Present the change for review and wait for approval; commit only when asked.
  - Commit the standard way described in [Commits](#commits): don't preserve the original author or author-date, and end the message with your own `Co-Authored-By` line naming the used Claude model. Don't keep the original commit's `Co-Authored-By` line.
  - Add reference to the upstream commit to the commit message:
  ```
  Ported from:
  https://github.com/vrana/adminer/commit/<hash>
  ```
  - Remove the bug/issue reference from the commit message subject, add a message line instead:
  ```
  Issue: https://github.com/vrana/adminer/issues/<issue_id>
  ``` 
- Verify: `php -l` every changed file, then run a real `php bin/compile.php admin <affected-drivers> en` (or `editor`) build to confirm the change compiles cleanly into the single-file output. For behavior-changing (not purely cosmetic) ports, prefer also verifying against a live test database (see Databases section) when one's available for the affected driver — start the dev server, log in, and drive the actual affected request/feature rather than trusting static review alone.

To understand the historical changes in public interface, look at Migration guide for AdminNeo 5.0.0: https://www.adminneo.org/upgrade#v5.0.0

### Running test instance

To drive a live instance for testing AdminNeo run dev server and then open:

- http://127.0.0.1:8000/tests/admin-devel-agent.php — dev version of AdminNeo from source (`admin/`), so edits are picked up live.
- http://127.0.0.1:8000/tests/admin-compiled-agent.php — compiled single file of AdminNeo (`compiled/adminneo.php`).
- http://127.0.0.1:8000/tests/editor-devel-agent.php — dev version of EditorNeo from source (`editor/`), so edits are picked up live.
- http://127.0.0.1:8000/tests/editor-compiled-agent.php — compiled single file of EditorNeo (`compiled/editorneo.php`).

These entry points are pre-configured, so it is possible to connect to selected database without inserting user credentials to the login form — see [Databases](#databases) for the login steps. You can temporarily edit configuration in these files to test specific functionality and plugins.

Always use the `*-agent.php` variants. The counterparts without the suffix (`tests/admin-devel.php`, `tests/admin-compiled.php`, …) back the Katalon test suites and are not pre-configured with servers.

### Databases

Databases for testing:

| Database        | Host            | Username | Password           | URL parameter             |
|-----------------|-----------------|----------|--------------------|---------------------------|
| MySQL 9         | 127.0.0.1:3307  | test     | test               | `mysql=mysql9`            |
| MariaDB 12      | 127.0.0.1       | test     | test               | `mysql=mariadb12`         |
| PostgreSQL 18   | 127.0.0.1:5432  | test     | test               | `pgsql=pgsql18`           |
| MS SQL 18       | 127.0.0.1:1433  | test     | 340$Uuxwp7Mcxo7Khy | `mssql=mssql18`           |
| Elasticsearch 7 | 127.0.0.1:9200  |          |                    | `elastic=elastic7`        |
| MongoDB 2       | 127.0.0.1:27017 | test     | test               | `mongo=mongo2`            |
| Clickhouse 26   | 127.0.0.1:8123  | default  | default            | `clickhouse=clickhouse26` |
| SQLite          | —               |          |                    | `sqlite=sqlite`           |

If not accessible, try to start existing Docker container. Do not change existing databases except `adminneo_test`. Do not drop `adminneo_test`.

Credentials in the table are for direct CLI access (`docker exec`, `psql`, `mysql`). Never type them into AdminNeo's login form — use the `*-agent.php` entry points (see [Running test instance](#running-test-instance)), which supply them from configuration.

To log in: open the entry point with `?<driver>=<server-key>` from the table above (or with no query string and pick the database from the **Server** dropdown), leave **Username** and **Password** empty, and submit. Do not put `username=` or `password=` in the URL of the login request — they pre-fill the form, override the configured credentials and the login fails.

Server keys are static, so deep links can be hand-written once logged in — but they must carry the same `username=` value the app puts in its own links, otherwise the login page appears again:

```
http://127.0.0.1:8000/tests/admin-devel-agent.php?mysql=mariadb12&username=test&db=adminneo_test&select=albums
http://127.0.0.1:8000/tests/admin-devel-agent.php?pgsql=pgsql18&username=test&db=adminneo_test&ns=public&sql=SELECT+version()
```

Log in per server first; the session is per server key. A `db=` in the URL of the login request itself is dropped by the redirect, so open the deep link after logging in.

#### SQLite

SQLite is not in the table above because it has no server — a database is just a file, so there is nothing to start. Create a test database file (e.g. with PHP's `SQLite3` API or the `sqlite3` CLI) and point AdminNeo at it **after log in**: type the database file path into the database input (`#database-select`) in the page header. The file must be readable and writable by the dev server process.

Most alters (e.g. renaming a column) recreate the whole table via `recreate_table()`; a plain no-op resubmit of the alter form does not.
