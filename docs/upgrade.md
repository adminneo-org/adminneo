Upgrade guide
=============

Migrating to 5.0
----------------

- Minimum required PHP version is 7.1.
- TODO: AdminNeo namespace
- TODO: adminer_object -> create_adminneo
- TODO: AdminerPlugin -> Pluginer
- TODO: removed autoload of plugins based on class name
- TODO: removed all designs, new configurable theme and color variants
- TODO: removed driver `elastic5`, all drivers can be compiled
- TODO: removed plugin `AdminerLoginServers`, config options `servers`
- TODO: removed plugin `AdminerLoginPasswordLess`, config options `defaultPasswordHash`
- TODO: removed plugin `AdminerVersionNoverify`, config option `versionVerification`
- TODO: removed plugin `AdminerDatabaseHide`, config options `hiddenDatabases`, `hiddenSchemas`
- TODO: removed plugin `AdminerDotJs`, config option `jsUrls`
- TODO: removed plugin `AdminerLoginSsl`, config options `ssl*`
- TODO: removed plugin `AdminerDotJs`, adminneo.js is autoloaded
- TODO: removed plugin `AdminerJsonColumn`, new `JsonPreviewPlugin` plugin
- TODO: config option `visibleCollations` as a replacement for the plugin [AdminerCollations](https://github.com/pematon/adminer-plugins#adminercollations)
- TODO: renamed all plugins
- TODO: plugin interface
    - credentials() -> getCredentials()
    - login() -> authenticate()
    - serverName() -> getServerName()
    - loginFormField() -> composeLoginFormRow()
- TODO: removed customizable css() method, config option `cssUrls`
- TODO: removed unused selectQueryBuild() customization method
- TODO: set `navigationMode` as a replacement for [AdminerSimpleMenu](https://github.com/pematon/adminer-plugins?tab=readme-ov-file#adminersimplemenu)
    - Set to `reversed` for original-like menu

Migrating to 4.17
-----------------

- Plugin enum-types.php was integrated into the base code, so it can be removed.

Migrating to 4.10
-----------------

- Remove plugin AdminerTablesFilter (plugins/tables-filter.php) if you use it. Its functionality was integrated into the
  base code.
- If you use complex custom theme, you will probably need to adjust a thing or two.

Migrating to 4.9
----------------

- Minimum required PHP version is 5.6.
