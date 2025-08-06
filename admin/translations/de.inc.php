<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ' ',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$6.$4.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'T.M.JJJJ',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.
	'%s must return an array.' => '%s muss ein Array zurückgeben.',
	'%s and %s must return an object created by %s method.' => '%s und %s müssen ein mit der Methode %s erstelltes Objekt zurückgeben.',

	// Login.
	'System' => 'Datenbank System',
	'Server' => 'Server',
	'Username' => 'Benutzer',
	'Password' => 'Passwort',
	'Permanent login' => 'Passwort speichern',
	'Login' => 'Login',
	'Logout' => 'Abmelden',
	'Logged as: %s' => 'Angemeldet als: %s',
	'Logout successful.' => 'Abmeldung erfolgreich.',
	'Invalid server or credentials.' => 'Ungültige Server oder Anmelde-Informationen.',
	'There is a space in the input password which might be the cause.' => 'Es gibt ein Leerzeichen im Eingabepasswort, das die Ursache sein könnte.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo unterstützt den Zugriff auf eine Datenbank ohne Passwort nicht, <a href="https://www.adminneo.org/password"%s>mehr Informationen</a>.',
	'Database does not support password.' => 'Die Datenbank unterstützt kein Passwort.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Zu viele erfolglose Login-Versuche. Bitte probieren Sie es in %d Minute noch einmal.',
		'Zu viele erfolglose Login-Versuche. Bitte probieren Sie es in %d Minuten noch einmal.',
	],
	'Invalid permanent login, please login again.' => 'Ungültige permanente Anmeldung, bitte melden Sie sich erneut an.',
	'Invalid CSRF token. Send the form again.' => 'CSRF Token ungültig. Bitte die Formulardaten erneut abschicken.',
	'If you did not send this request from AdminNeo then close this page.' => 'Wenn Sie diese Anfrage nicht von AdminNeo gesendet haben, schließen Sie diese Seite.',
	'The action will be performed after successful login with the same credentials.' => 'Die Aktion wird nach erfolgreicher Anmeldung mit denselben Anmeldedaten ausgeführt.',

	// Connection.
	'No driver' => 'Kein Treiber',
	'Database driver not found.' => 'Datenbanktreiber nicht gefunden.',
	'No extension' => 'Keine Erweiterungen installiert',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Keine der unterstützten PHP-Erweiterungen (%s) ist vorhanden.',
	'Connecting to privileged ports is not allowed.' => 'Die Verbindung zu privilegierten Ports ist nicht erlaubt.',
	'Session support must be enabled.' => 'Unterstüzung für PHP-Sessions muss aktiviert sein.',
	'Session expired, please login again.' => 'Sitzungsdauer abgelaufen, bitte erneut anmelden.',
	'%s version: %s through PHP extension %s' => 'Version %s: %s mit PHP-Erweiterung %s',

	// Settings.
	'Language' => 'Sprache',

	'Home' => 'Startseite',
	'Refresh' => 'Aktualisieren',
	'Info' => 'Info',
	'More information.' => 'Weitere Informationen.',

	// Privileges.
	'Privileges' => 'Rechte',
	'Create user' => 'Benutzer erstellen',
	'User has been dropped.' => 'Benutzer wurde entfernt.',
	'User has been altered.' => 'Benutzer wurde geändert.',
	'User has been created.' => 'Benutzer wurde erstellt.',
	'Hashed' => 'Hashed',

	// Server.
	'Process list' => 'Prozessliste',
	'%d process(es) have been killed.' => [
		'%d Prozess gestoppt.',
		'%d Prozesse gestoppt.',
	],
	'Kill' => 'Anhalten',
	'Variables' => 'Variablen',
	'Status' => 'Status',

	// Structure.
	'Column' => 'Spalte',
	'Routine' => 'Routine',
	'Grant' => 'Erlauben',
	'Revoke' => 'Widerrufen',

	// Queries.
	'SQL command' => 'SQL-Kommando',
	'HTTP request' => 'HTTP-Anfrage',
	'%d query(s) executed OK.' => [
		'%d SQL-Abfrage erfolgreich ausgeführt.',
		'%d SQL-Abfragen erfolgreich ausgeführt.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Abfrage ausgeführt, %d Datensatz betroffen.',
		'Abfrage ausgeführt, %d Datensätze betroffen.',
	],
	'No commands to execute.' => 'Kein Kommando vorhanden.',
	'Error in query' => 'Fehler in der SQL-Abfrage',
	'Unknown error.' => 'Unbekannter Fehler.',
	'Warnings' => 'Warnungen',
	'ATTACH queries are not supported.' => 'ATTACH Abfragen werden nicht unterstützt.',
	'Execute' => 'Ausführen',
	'Stop on error' => 'Bei Fehler anhalten',
	'Show only errors' => 'Nur Fehler anzeigen',
	'Time' => 'Zeitpunkt',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'History',
	'Clear' => 'Löschen',
	'Edit all' => 'Alle bearbeiten',

	// Import.
	'Import' => 'Importieren',
	'File upload' => 'Datei importieren',
	'From server' => 'Vom Server',
	'Webserver file %s' => 'Webserver Datei %s',
	'Run file' => 'Datei ausführen',
	'File does not exist.' => 'Datei existiert nicht.',
	'File uploads are disabled.' => 'Importieren von Dateien abgeschaltet.',
	'Unable to upload a file.' => 'Hochladen von Datei fehlgeschlagen.',
	'Maximum allowed file size is %sB.' => 'Maximal erlaubte Dateigröße ist %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST-Daten sind zu groß. Reduzieren Sie die Größe oder vergrößern Sie den Wert %s in der Konfiguration.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Sie können eine große SQL-Datei per FTP hochladen und dann vom Server importieren.',
	'File must be in UTF-8 encoding.' => 'Die Datei muss UTF-8 kodiert sein.',
	'You are offline.' => 'Sie sind offline.',
	'%d row(s) have been imported.' => [
		'%d Datensatz wurde importiert.',
		'%d Datensätze wurden importiert.',
	],

	// Export.
	'Export' => 'Exportieren',
	'Output' => 'Ergebnis',
	'open' => 'anzeigen',
	'save' => 'Datei',
	'Format' => 'Format',
	'Data' => 'Daten',

	// Databases.
	'Database' => 'Datenbank',
	'DB' => 'DB',
	'Use' => 'Auswählen',
	'Invalid database.' => 'Datenbank ungültig.',
	'Alter database' => 'Datenbank ändern',
	'Create database' => 'Datenbank erstellen',
	'Database schema' => 'Datenbankschema',
	'Permanent link' => 'Dauerhafter Link',
	'Database has been dropped.' => 'Datenbank wurde entfernt.',
	'Databases have been dropped.' => 'Datenbanken wurden entfernt.',
	'Database has been created.' => 'Datenbank wurde erstellt.',
	'Database has been renamed.' => 'Datenbank wurde umbenannt.',
	'Database has been altered.' => 'Datenbank wurde geändert.',
	// SQLite errors.
	'File exists.' => 'Datei existiert schon.',
	'Please use one of the extensions %s.' => 'Bitte einen der Dateitypen %s benutzen.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Schema',
	'Schemas' => 'Schemata',
	'No schemas.' => 'Keine Schemata.',
	'Show schema' => 'Zeige Schemata',
	'Alter schema' => 'Schema ändern',
	'Create schema' => 'Schema erstellen',
	'Schema has been dropped.' => 'Schema wurde gelöscht.',
	'Schema has been created.' => 'Schema wurde erstellt.',
	'Schema has been altered.' => 'Schema wurde geändert.',
	'Invalid schema.' => 'Schema nicht gültig.',

	// Table list.
	'Engine' => 'Speicher-Engine',
	'engine' => 'Speicher-Engine',
	'Collation' => 'Kollation',
	'collation' => 'Kollation',
	'Data Length' => 'Datengröße',
	'Index Length' => 'Indexgröße',
	'Data Free' => 'Freier Bereich',
	'Rows' => 'Datensätze',
	'%d in total' => '%d insgesamt',
	'Analyze' => 'Analysieren',
	'Optimize' => 'Optimieren',
	'Vacuum' => 'Vacuum',
	'Check' => 'Prüfen',
	'Repair' => 'Reparieren',
	'Truncate' => 'Leeren (truncate)',
	'Tables have been truncated.' => 'Tabellen wurden geleert (truncate).',
	'Move to other database' => 'In andere Datenbank verschieben',
	'Move' => 'Verschieben',
	'Tables have been moved.' => 'Tabellen verschoben.',
	'Copy' => 'Kopieren',
	'Tables have been copied.' => 'Tabellen wurden kopiert.',
	'overwrite' => 'überschreiben',

	// Tables.
	'Tables' => 'Tabellen',
	'Tables and views' => 'Tabellen und Views',
	'Table' => 'Tabelle',
	'No tables.' => 'Keine Tabellen.',
	'Alter table' => 'Tabelle ändern',
	'Create table' => 'Tabelle erstellen',
	'Table has been dropped.' => 'Tabelle wurde entfernt.',
	'Tables have been dropped.' => 'Tabellen wurden entfernt (drop).',
	'Tables have been optimized.' => 'Tabellen wurden optimiert.',
	'Table has been altered.' => 'Tabelle wurde geändert.',
	'Table has been created.' => 'Tabelle wurde erstellt.',
	'Table name' => 'Name der Tabelle',
	'Name' => 'Name',
	'Show structure' => 'Struktur anzeigen',
	'Column name' => 'Spaltenname',
	'Type' => 'Typ',
	'Length' => 'Länge',
	'Auto Increment' => 'Auto-Inkrement',
	'Options' => 'Optionen',
	'Comment' => 'Kommentar',
	'Default value' => 'Vorgabewert festlegen',
	'Drop' => 'Entfernen',
	'Drop %s?' => '%s entfernen?',
	'Are you sure?' => 'Sind Sie sicher?',
	'Size' => 'Größe',
	'Compute' => 'kalkulieren',
	'Move up' => 'Nach oben',
	'Move down' => 'Nach unten',
	'Remove' => 'Entfernen',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Die maximal erlaubte Anzahl der Felder ist überschritten. Bitte %s erhöhen.',

	// Views.
	'View' => 'View',
	'Materialized view' => 'Strukturierte Ansicht',
	'View has been dropped.' => 'View wurde entfernt.',
	'View has been altered.' => 'View wurde geändert.',
	'View has been created.' => 'View wurde erstellt.',
	'Alter view' => 'View ändern',
	'Create view' => 'View erstellen',

	// Partitions.
	'Partition by' => 'Partitionieren um',
	'Partition' => 'Partition',
	'Partitions' => 'Partitionen',
	'Partition name' => 'Name der Partition',
	'Values' => 'Werte',

	// Indexes.
	'Indexes' => 'Indizes',
	'Indexes have been altered.' => 'Indizes geändert.',
	'Alter indexes' => 'Indizes ändern',
	'Add next' => 'Hinzufügen',
	'Index Type' => 'Index-Typ',
	'length' => 'Länge',

	// Foreign keys.
	'Foreign keys' => 'Fremdschlüssel',
	'Foreign key' => 'Fremdschlüssel',
	'Foreign key has been dropped.' => 'Fremdschlüssel wurde entfernt.',
	'Foreign key has been altered.' => 'Fremdschlüssel wurde geändert.',
	'Foreign key has been created.' => 'Fremdschlüssel wurde erstellt.',
	'Target table' => 'Zieltabelle',
	'Change' => 'Ändern',
	'Source' => 'Ursprung',
	'Target' => 'Ziel',
	'Add column' => 'Spalte hinzufügen',
	'Alter' => 'Ändern',
	'Add foreign key' => 'Fremdschlüssel hinzufügen',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Quell- und Zielspalten müssen vom gleichen Datentyp sein, es muss unter den Zielspalten ein Index existieren und die referenzierten Daten müssen existieren.',

	// Routines.
	'Routines' => 'Routinen',
	'Routine has been called, %d row(s) affected.' => [
		'Routine wurde ausgeführt, %d Datensatz betroffen.',
		'Routine wurde ausgeführt, %d Datensätze betroffen.',
	],
	'Call' => 'Aufrufen',
	'Parameter name' => 'Name des Parameters',
	'Create procedure' => 'Prozedur erstellen',
	'Create function' => 'Funktion erstellen',
	'Routine has been dropped.' => 'Routine wurde entfernt.',
	'Routine has been altered.' => 'Routine wurde geändert.',
	'Routine has been created.' => 'Routine wurde erstellt.',
	'Alter function' => 'Funktion ändern',
	'Alter procedure' => 'Prozedur ändern',
	'Return type' => 'Typ des Rückgabewertes',

	// Events.
	'Events' => 'Ereignisse',
	'Event' => 'Ereignis',
	'Event has been dropped.' => 'Ereignis wurde entfernt.',
	'Event has been altered.' => 'Ereignis wurde geändert.',
	'Event has been created.' => 'Ereignis wurde erstellt.',
	'Alter event' => 'Ereignis ändern',
	'Create event' => 'Ereignis erstellen',
	'At given time' => 'Zur angegebenen Zeit',
	'Every' => 'Jede',
	'Schedule' => 'Zeitplan',
	'Start' => 'Start',
	'End' => 'Ende',
	'On completion preserve' => 'Nach der Ausführung erhalten',

	// Sequences (PostgreSQL).
	'Sequences' => 'Sequenzen',
	'Create sequence' => 'Sequenz erstellen',
	'Sequence has been dropped.' => 'Sequenz wurde gelöscht.',
	'Sequence has been created.' => 'Sequenz wurde erstellt.',
	'Sequence has been altered.' => 'Sequenz wurde geändert.',
	'Alter sequence' => 'Sequenz ändern',

	// User types (PostgreSQL)
	'User types' => 'Benutzerdefinierte Typen',
	'Create type' => 'Typ erstellen',
	'Type has been dropped.' => 'Typ wurde gelöscht.',
	'Type has been created.' => 'Typ wurde erstellt.',
	'Alter type' => 'Typ ändern',

	// Triggers.
	'Triggers' => 'Trigger',
	'Add trigger' => 'Trigger hinzufügen',
	'Trigger has been dropped.' => 'Trigger wurde entfernt.',
	'Trigger has been altered.' => 'Trigger wurde geändert.',
	'Trigger has been created.' => 'Trigger wurde erstellt.',
	'Alter trigger' => 'Trigger ändern',
	'Create trigger' => 'Trigger erstellen',

	// Table check constraints.
	'Checks' => 'Checks',
	'Create check' => 'Check erstellen',
	'Alter check' => 'Check ändern',
	'Check has been created.' => 'Check wurde erstellt.',
	'Check has been altered.' => 'Check wurde geändert.',
	'Check has been dropped.' => 'Check wurde abgebrochen.',

	// Selection.
	'Select data' => 'Daten auswählen',
	'Select' => 'Daten zeigen von',
	'Functions' => 'Funktionen',
	'Aggregation' => 'Aggregationen',
	'Search' => 'Suchen',
	'anywhere' => 'beliebig',
	'Sort' => 'Ordnen',
	'descending' => 'absteigend',
	'Limit' => 'Begrenzung',
	'Limit rows' => 'Datensätze begrenzen',
	'Text length' => 'Textlänge',
	'Action' => 'Aktion',
	'Full table scan' => 'Vollständige Überprüfung der Tabelle',
	'Unable to select the table' => 'Auswahl der Tabelle fehlgeschlagen',
	'Search data in tables' => 'Suche in Tabellen',
	'as a regular expression' => 'als regulärer Ausdruck',
	'No rows.' => 'Keine Datensätze.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d Datensatz',
		'%d Datensätze',
	],
	'Page' => 'Seite',
	'last' => 'letzte',
	'Load more data' => 'Mehr Daten laden',
	'Loading' => 'Lade',
	'Whole result' => 'Gesamtergebnis',
	'%d byte(s)' => [
		'%d Byte',
		'%d Bytes',
	],

	// In-place editing in selection.
	'Modify' => 'Ändern',
	'Ctrl+click on a value to modify it.' => 'Ctrl+Klick zum Bearbeiten des Wertes.',
	'Use edit link to modify this value.' => 'Benutzen Sie den Link zum Bearbeiten dieses Wertes.',

	// Editing.
	'New item' => 'Neuer Datensatz',
	'Edit' => 'Bearbeiten',
	'original' => 'Original',
	// label for value '' in enum data type
	'empty' => 'leer',
	'Insert' => 'Einfügen',
	'Save' => 'Speichern',
	'Save and continue edit' => 'Speichern und weiter bearbeiten',
	'Save and insert next' => 'Speichern und nächsten einfügen',
	'Saving' => 'Speichere',
	'Selected' => 'Ausgewählte',
	'Clone' => 'Klonen',
	'Delete' => 'Entfernen',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Datensatz%s wurde eingefügt.',
	'Item has been deleted.' => 'Datensatz wurde gelöscht.',
	'Item has been updated.' => 'Datensatz wurde geändert.',
	'%d item(s) have been affected.' => '%d Artikel betroffen.',
	'You have no privileges to update this table.' => 'Sie haben keine Rechte, diese Tabelle zu aktualisieren.',

	// Data type descriptions.
	'Numbers' => 'Zahlen',
	'Date and time' => 'Datum und Zeit',
	'Strings' => 'Zeichenketten',
	'Binary' => 'Binär',
	'Lists' => 'Listen',
	'Network' => 'Netzwerk',
	'Geometry' => 'Geometrie',
	'Relations' => 'Relationen',

	// Editor - data values.
	'now' => 'jetzt',
	'yes' => 'ja',
	'no' => 'nein',

	// Settings.
	'Settings' => 'Einstellungen',
	'Default' => 'Standard',
	'Color scheme' => 'Farbschema',
	'By system' => 'Systembasiert',
	'Light' => 'Hell',
	'Dark' => 'Dunkel',
	'Navigation mode' => 'Navigationsmodus',
	'Simple' => 'Einfach',
	'Dual' => 'Dual',
	'Reversed' => 'Umgekehrt',
	'Layout of main navigation with table links.' => 'Layout der Hauptnavigation mit Tabellenlinks.',
	'Table links' => 'Tabellenlinks',
	'Primary action for all table links.' => 'Primäre Aktion für alle Tabellenlinks.',
	'Records per page' => 'Datensätze pro Seite',
	'Default number of records displayed in data table.' => 'Standardanzahl der in der Datentabelle angezeigten Datensätze.',
	'Enum as select' => 'Enum als Auswahlmenü',
	'Never' => 'Niemals',
	'Always' => 'Immer',
	'More values than %d' => 'Mehr als  %d Werte',
	'Threshold for displaying a selection menu for enum fields.' => 'Schwellenwert für die Anzeige eines Auswahlmenüs für Enum-Felder.',

	// Plugins.
	'One Time Password' => 'Einmal-Passwort',
	'Enter OTP code.' => 'OTP-Code eingeben.',
	'Invalid OTP code.' => 'Ungültiger OTP-Code.',
	'Access denied.' => 'Zugang verweigert.',
	'JSON previews' => 'JSON-Vorschau',
	'Data table' => 'Datentabelle',
	'Edit form' => 'Formular bearbeiten',
];
