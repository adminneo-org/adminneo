Upgrade guide
=============

Migrating to 5.0
----------------

- Minimum required PHP version is 7.1.

- Compiled file was renamed to `adminneo.php` for database Admin and `editorneo.php` for Editor. Update your include
  statement if you use custom AdminNeo configuration.

```php
// Include AdminNeo file.
include "adminneo.php";
```

- Function for creating Admin instance was renamed form `adminer_object` to `create_adminneo`.

- Core classes has been renamed: `Adminer` -> `Admin`, `AdminerPlugin` -> `Pluginer`.

- Project's code and official plugins are in `AdminNeo` namespace now. Update your index.php and custom plugins by
  using this new namespace. Simple index.php will look like this:

```php
<?php

use AdminNeo\Admin;

function create_adminneo(): Admin 
{
    return new Admin();
}

include "adminneo.php";
```

- AdminNeo has a brand-new default design that is incompatible with the previous one. All alternative designs was
  removed. If you use custom `adminer.css` file, you can delete it. If you use
  [Adminer theme](https://github.com/pematon/adminer-theme) by Pematon, delete all related files. New default theme 
  supports dark mode and color variants. See [Configuration options](/docs/configuration.md) for more information.

- Default theme can be modified by custom `adminneo.css` file that is auto-included in the same way as previous
  `adminer.css`.

- Driver `elastic5` was removed, only Elasticsearch 7+ is supported in `elastic` driver.

- Autoloading of plugins based on the class name was removed. All plugins have to be created in custom index.php file.

### Plugins

- Plugin `AdminerLoginServers` (login-servers.php) was removed. Preconfigured server connections can be defined by
  `servers` configuration option. See [Configuration options](/docs/configuration.md) for more information. This option
  is also replacement for [AdminerLoginServers](https://github.com/pematon/adminer-plugins) by Pematon.

- Plugin `AdminerLoginPasswordLess` (login-password-less.php) was removed. Default password can be defined by
  `defaultPasswordHash` configuration option. See [Configuration options](/docs/configuration.md) for more information.

- Plugin `AdminerVersionNoverify` (version-noverify.php) was removed. Version verification can be disabled by
  `versionVerification` configuration option. See [Configuration options](/docs/configuration.md) for more information.

- Plugin `AdminerDatabaseHide` (database-hide.php) was removed. Selected databases and schemas can be hidden by
  `hiddenDatabases` and `hiddenSchemas` configuration options. See [Configuration options](/docs/configuration.md) for
  more information.

- Plugin `AdminerDotJs` (adminer.js.php) was removed. File `adminneo.js` is autoloaded by default.

- Plugin `AdminerLoginSsl` (login-ssl.php) was removed. SSL options can be defined by `ssl*` configuration options.
  See [Configuration options](/docs/configuration.md) for more information.

- Plugin `AdminerFrames` (frames.php) was removed. Frames can be allowed by `frameAncestors` configuration option. 
  See [Configuration options](/docs/configuration.md) for more information.

- Plugins `AdminerJsonColumn` (json-column.php) and [AdminerJsonPreview](https://github.com/pematon/adminer-plugins) by
  Pematon were replaced by new `JsonPreviewPlugin`.

- Plugin [AdminerCollations](https://github.com/pematon/adminer-plugins#adminercollations) by Pematon is replaced by
  `visibleCollations` configuration option. See [Configuration options](/docs/configuration.md) for more information.

- Plugin [AdminerSimpleMenu](https://github.com/pematon/adminer-plugins#adminersimplemenu) by Pematon can be removed.
  Main menu is simplified by default and can be modified by `navigationMode` configuration option. Set it to `reversed`
  for original-like menu layout. See [Configuration options](/docs/configuration.md) for more information.

- Plugin `AdminerEditTextarea` (edit-textarea.php) was removed without a replacement.
- Plugin `AdminerDumpPhp` (dump-php.php) was removed without a replacement.
- Plugin `AdminerDumpAlter` (dump-alter.php) was removed without a replacement.
- Plugin `AdminerDumpDate` (dump-date.php) was removed. Datetime is part of the filename by default.

- All remaining plugins were renamed:
    - `AdminerDumpBz2` to `Bz2OutputPlugin`
    - `AdminerDumpZip` to `ZipOutputPlugin`
    - `AdminerDumpJson` to `JsonDumpPlugin`
    - `AdminerDumpXml` to `XmlDumpPlugin`
    - `AdminerEditCalendar` to `EditCalendarPlugin`
    - `AdminerEditForeign` to `EditForeignPlugin`
    - `AdminerEditTextarea` to `EditTextareaPlugin`
    - `AdminerEmailTable` to `EmailTablePlugin`
    - `AdminerEnumOption` to `EnumOptionPlugin`
    - `AdminerFileUpload` to `FileUploadPlugin`
    - `AdminerForeignSystem` to `SystemForeignKeysPlugin`
    - `AdminerLoginIp` to `IpLoginPlugin`
    - `AdminerLoginOtp` to `OtpLoginPlugin`
    - `AdminerLoginTable` to `TableLoginPlugin`
    - `AdminerMasterSlave` to `MasterSlavePlugin`
    - `AdminerPrettyJsonColumn` to `PrettyJsonEditPlugin`
    - `AdminerSlugify` to `SlugifyPlugin`
    - `AdminerSqlLog` to `SqlLogPlugin`
    - `AdminerStructComments` to `StructureCommentsPlugin`
    - `AdminerTableIndexesStructure` to `ExpandedTableIndexesPlugin`
    - `AdminerTableStructure` to `ExpandedTableStructurePlugin`
    - `AdminerTinymce` to `TinyMcePlugin`
    - `AdminerTranslation` to `TranslationPlugin`
    - `AdminerWymeditor` to `WymEditorPlugin`

### Customizable functions

- Function `selectQueryBuild()` was removed.
- Function `css()` was removed. CSS files can be defined by `cssUrls` configuration option. See
  [Configuration options](/docs/configuration.md) for more information.
- Function `csp()` was replaced by `getCspHeader()` that allows to redefine CSP directives of just one 
  Content-Security-Policy HTTP header.
- Function `dumpFilename()` was removed.
- Many customizable functions was renamed:
    - `credentials()` to `getCredentials()`
    - `login()` -> `authenticate()`
    - `serverName()` -> `getServerName()`
    - `loginFormField()` -> `composeLoginFormRow()`
    - `foreignKeys()` -> `getForeignKeys()`
    - `dumpOutput()` -> `getDumpOutputs()`
    - `dumpFormat()` -> `getDumpFormats()`
    - `dumpHeaders()` -> `sendDumpHeaders()`

Migrating to 4.17
-----------------

- Remove the `AdminerEnumTypes` plugin (enum-types.php). Its functionality was integrated into the base code.

Migrating to 4.10
-----------------

- Remove the `AdminerTablesFilter` plugin (tables-filter.php). Its functionality was integrated into the base code.
- If you use complex custom theme, you will probably need to adjust a thing or two.

Migrating to 4.9
----------------

- Minimum required PHP version is 5.6.
