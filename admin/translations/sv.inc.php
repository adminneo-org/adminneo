<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s måste returnera en array.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s och %s måste returnera ett objekt skapat av metoden %s.', // by Claude Opus 5

	// Login
	'System' => 'System',
	'Server' => 'Server',
	'Username' => 'Användarnamn',
	'Password' => 'Lösenord',
	'Permanent login' => 'Permanent inloggning',
	'Login' => 'Logga in',
	'Logout' => 'Logga ut',
	'Logged as: %s' => 'Inloggad som: %s',
	'Logout successful.' => 'Du är nu utloggad.',
	'hostname[:port] or :socket' => 'hostname[:port] eller :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Ogiltig server eller inloggningsuppgifter.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Det finns ett mellanslag i lösenordet, vilket kan vara anledningen.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo tillåter inte att ansluta till en databas utan lösenord. <a href="https://www.adminneo.org/password"%s>Mer information</a>.',
	'Database does not support password.' => 'Databasen stödjer inte lösenord.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'För många misslyckade inloggningar, försök igen om %d minut.',
		'För många misslyckade inloggningar, försök igen om %d minuter.',
	],
	'Invalid permanent login, please login again.' => 'Ogiltig permanent inloggning, vänligen logga in igen.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Ogiltig CSRF-token. Skicka formuläret igen.',
	'If you did not send this request from AdminNeo then close this page.' => 'Om du inte skickade en förfrågan från AdminNeo så kan du stänga den här sidan.',
	'The action will be performed after successful login with the same credentials.' => 'Åtgärden kommer att utföras efter en lyckad inloggning med samma inloggningsuppgifter.',

	// Connection
	'No driver' => 'Ingen drivrutin', // by Claude Opus 5
	'Database driver not found.' => 'Databasdrivrutinen hittades inte.', // by Claude Opus 5
	'No extension' => 'Inget tillägg',
	'None of the supported PHP extensions (%s) are available.' => 'Inga av de PHP-tilläggen som stöds (%s) är tillgängliga.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Anslutning till privilegierade portar är inte tillåtet.',
	'Session support must be enabled.' => 'Support för sessioner måste vara på.',
	'Session expired, please login again.' => 'Session har löpt ut, vänligen logga in igen.',
	'%s version: %s through PHP extension %s' => '%s version: %s genom PHP-tillägg %s',

	// Settings
	'Language' => 'Språk',

	'Home' => 'Start', // by Claude Opus 5
	'Refresh' => 'Ladda om',
	'Info' => 'Info', // by Claude Opus 5
	'More information.' => 'Mer information.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Privilegier',
	'Create user' => 'Skapa användare',
	'User has been dropped.' => 'Användare har blivit borttagen.',
	'User has been altered.' => 'Användare har blivit ändrad.',
	'User has been created.' => 'Användare har blivit skapad.',
	'Hashed' => 'Hashad',

	// Server
	'Process list' => 'Processlista',
	'%d process(es) have been killed.' => [
		'%d process har avslutats.',
		'%d processer har avslutats.',
	],
	'Kill' => 'Avsluta',
	'Variables' => 'Variabler',
	'Status' => 'Status',

	// Structure
	'Column' => 'Kolumn',
	'Columns' => 'Kolumner', // by Claude Fable 5
	'Routine' => 'Rutin',
	'Grant' => 'Tillåt',
	'Revoke' => 'Neka',

	// Queries
	'SQL command' => 'SQL-kommando',
	'HTTP request' => 'HTTP-förfrågan', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d förfrågan lyckades.',
		'%d förfrågor lyckades.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Förfrågan lyckades, %d rad påverkades.',
		'Förfrågan lyckades, %d rader påverkades.',
	],
	'No commands to execute.' => 'Inga kommandon att köra.',
	'Error in query' => 'Fel i förfrågan',
	'Unknown error.' => 'Okänt fel.',
	'Warnings' => 'Varningar',
	'%s queries are not supported.' => '%s-förfrågor stöds inte.',
	'Execute' => 'Kör',
	'Stop on error' => 'Stanna på fel',
	'Show only errors' => 'Visa bara fel',
	'Time' => 'Tid',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Historia',
	'Clear' => 'Rensa',
	'Edit all' => 'Redigera alla',

	// Import
	'Import' => 'Importera',
	'File upload' => 'Ladda upp fil',
	'From server' => 'Från server',
	'Webserver file %s' => 'Serverfil %s',
	'Run file' => 'Kör fil',
	'File does not exist.' => 'Filen finns inte.',
	'File uploads are disabled.' => 'Filuppladdningar är avstängda.',
	'Unable to upload a file.' => 'Det går inte att ladda upp filen.', // by Claude Opus 5
	'Maximum allowed file size is %sB.' => 'Högsta tillåtna storlek är %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Högsta antal filer är %d. Välj färre filer eller höj %s-direktivet.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Högsta sammanlagda filstorlek är %s. Välj mindre filer eller höj %s-direktivet.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST-datan är för stor. Minska det eller höj %s-direktivet.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Du kan ladda upp en stor SQL-fil via FTP och importera det från servern.',
	'File must be in UTF-8 encoding.' => 'Filer måste vara i UTF-8-format.',
	'You are offline.' => 'Du är offline.',
	'%d row(s) have been imported.' => [
		'%d rad har importerats.',
		'%d rader har importerats.',
	],

	// Export
	'Export' => 'Exportera',
	'Output' => 'Utmatning',
	'open' => 'Öppna',
	'save' => 'Spara',
	'Format' => 'Format',
	'Data' => 'Data',

	// Databases
	'Database' => 'Databas',
	'database' => 'databas', // by Claude Opus 5
	'DB' => 'DB',
	'Use' => 'Använd',
	'Invalid database.' => 'Ogiltig databas.',
	'Alter database' => 'Ändra databas',
	'Create database' => 'Skapa databas',
	'Database schema' => 'Databasschema',
	'Permanent link' => 'Permanent länk',
	'Database has been dropped.' => 'Databasen har tagits bort.',
	'Databases have been dropped.' => 'Databaserna har tagits bort.',
	'Database has been created.' => 'Databasen har skapats.',
	'Database has been renamed.' => 'Databasen har fått sitt namn ändrat.',
	'Database has been altered.' => 'Databasen har ändrats.',

	// SQLite errors
	'File exists.' => 'Filen finns redan.',
	'Please use one of the extensions %s.' => 'Vänligen använd en av filändelserna %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Schema',
	'schema' => 'schema', // by Claude Opus 5
	'Schemas' => 'Scheman', // by Claude Opus 5
	'No schemas.' => 'Inga scheman.', // by Claude Opus 5
	'Show schema' => 'Visa schema', // by Claude Opus 5
	'Alter schema' => 'Redigera schema',
	'Create schema' => 'Skapa schema',
	'Schema has been dropped.' => 'Schema har tagits bort.',
	'Schema has been created.' => 'Schema har skapats.',
	'Schema has been altered.' => 'Schema har ändrats.',
	'Invalid schema.' => 'Ogiltigt schema.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Kollationering',
	'collation' => 'kollationering',
	'Data Length' => 'Datalängd',
	'Index Length' => 'Indexlängd',
	'Data Free' => 'Ledig data',
	'Rows' => 'Rader',
	'%d in total' => 'totalt %d',
	'Analyze' => 'Analysera',
	'Optimize' => 'Optimera',
	'Vacuum' => 'Städa',
	'Check' => 'Kolla',
	'Repair' => 'Reparera',
	'Truncate' => 'Avkorta',
	'Tables have been truncated.' => 'Tabeller har blivit avkortade.',
	'Move to other database' => 'Flytta till en annan databas',
	'Move' => 'Flytta',
	'Tables have been moved.' => 'Tabeller har flyttats.',
	'Copy' => 'Kopiera',
	'Tables have been copied.' => 'Tabeller har kopierats.',
	'overwrite' => 'Skriv över',

	// Tables
	'Tables' => 'Tabeller',
	'Tables and views' => 'Tabeller och vyer',
	'Table' => 'Tabell',
	'No tables.' => 'Inga tabeller.',
	'Alter table' => 'Ändra tabell',
	'Create table' => 'Skapa tabell',
	'Table has been dropped.' => 'Tabell har tagits bort.',
	'Tables have been dropped.' => 'Tabeller har tagits bort.',
	'Tables have been optimized.' => 'Tabeller har optimerats.',
	'Table has been altered.' => 'Tabell har ändrats.',
	'Table has been created.' => 'Tabell har skapats.',
	'Table name' => 'Tabellnamn',
	'Name' => 'Namn',
	'Show structure' => 'Visa struktur',
	'Column name' => 'Kolumnnamn',
	'Type' => 'Typ',
	'Length' => 'Längd',
	'Auto Increment' => 'Automatisk uppräkning',
	'Options' => 'Inställningar',
	'Comment' => 'Kommentar',
	'Default value' => 'Standardvärde',
	'Drop' => 'Ta bort',
	'Drop %s?' => 'Ta bort %s?',
	'Are you sure?' => 'Är du säker?',
	'Size' => 'Storlek',
	'Compute' => 'Beräkna',
	'Move up' => 'Flytta upp',
	'Move down' => 'Flytta ner',
	'Remove' => 'Ta bort',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Högsta nummer tillåtna fält är överskridet. Vänligen höj %s.',

	// Views
	'View' => 'Vy',
	'Materialized view' => 'Materialiserad vy',
	'View has been dropped.' => 'Vy har tagits bort.',
	'View has been altered.' => 'Vy har ändrats.',
	'View has been created.' => 'Vy har skapats.',
	'Alter view' => 'Ändra vy',
	'Create view' => 'Skapa vy',

	// Partitions
	'Partition by' => 'Partitionera om',
	'Partition' => 'Partition', // by Claude Opus 5
	'Partitions' => 'Partitioner',
	'Partition name' => 'Partition',
	'Values' => 'Värden',
	'Inherited tables' => 'Ärvda tabeller', // by Claude Opus 5
	'Inherited from' => 'Ärvd från', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Index',
	'Indexes have been altered.' => 'Index har ändrats.',
	'Alter indexes' => 'Ändra index',
	'Add next' => 'Lägg till nästa',
	'Index Type' => 'Indextyp',
	'length' => 'längd',
	'Algorithm' => 'Algoritm', // by Claude Fable 5
	'Condition' => 'Villkor', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Främmande nycklar',
	'Foreign key' => 'Främmande nyckel',
	'Foreign key has been dropped.' => 'Främmande nyckel har tagits bort.',
	'Foreign key has been altered.' => 'Främmande nyckel har ändrats.',
	'Foreign key has been created.' => 'Främmande nyckel har skapats.',
	'Target table' => 'Måltabell',
	'Change' => 'Ändra',
	'Source' => 'Källa',
	'Target' => 'Mål',
	'Add column' => 'Lägg till kolumn',
	'Alter' => 'Ändra',
	'Add foreign key' => 'Lägg till främmande nyckel',
	'ON DELETE' => 'VID BORTTAGNING',
	'ON UPDATE' => 'VID UPPDATERING',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Käll- och mål-tabellen måste ha samma datatyp, ett index på målkolumnerna och refererad data måste finnas.',

	// Routines
	'Routines' => 'Rutiner',
	'Routine has been called, %d row(s) affected.' => [
		'Rutin har kallats, %d rad påverkades.',
		'Rutin har kallats, %d rader påverkades.',
	],
	'Call' => 'Kalla',
	'Parameter name' => 'Namn på parameter',
	'Create procedure' => 'Skapa procedur',
	'Create function' => 'Skapa funktion',
	'Routine has been dropped.' => 'Rutin har tagits bort.',
	'Routine has been altered.' => 'Rutin har ändrats.',
	'Routine has been created.' => 'Rutin har skapats.',
	'Alter function' => 'Ändra funktion',
	'Alter procedure' => 'Ändra procedur',
	'Return type' => 'Återvändningstyp',

	// Events
	'Events' => 'Event',
	'Event' => 'Event',
	'Event has been dropped.' => 'Event har tagits bort.',
	'Event has been altered.' => 'Event har ändrats.',
	'Event has been created.' => 'Event har skapats.',
	'Alter event' => 'Ändra event',
	'Create event' => 'Skapa event',
	'At given time' => 'Vid en tid',
	'Every' => 'Varje',
	'Schedule' => 'Schemalägga',
	'Start' => 'Start',
	'End' => 'Slut',
	'On completion preserve' => 'Bibehåll vid slutet',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sekvenser',
	'Create sequence' => 'Skapa sekvens',
	'Sequence has been dropped.' => 'Sekvens har tagits bort.',
	'Sequence has been created.' => 'Sekvens har skapats.',
	'Sequence has been altered.' => 'Sekvens har ändrats.',
	'Alter sequence' => 'Ändra sekvens',

	// User types (PostgreSQL)
	'User types' => 'Användartyper',
	'Create type' => 'Skapa typ',
	'Type has been dropped.' => 'Typ har, typ, tagits bort.',
	'Type has been created.' => 'Typ har skapats.',
	'Alter type' => 'Ändra typ',

	// Triggers
	'Triggers' => 'Avtryckare',
	'Add trigger' => 'Lägg till avtryckare',
	'Trigger has been dropped.' => 'Avtryckare har tagits bort.',
	'Trigger has been altered.' => 'Avtryckare har ändrats.',
	'Trigger has been created.' => 'Avtryckare har skapats.',
	'Alter trigger' => 'Ändra avtryckare',
	'Create trigger' => 'Skapa avtryckare',

	// Table check constraints
	'Checks' => 'Kontrollvillkor', // by Claude Fable 5
	'Create check' => 'Skapa kontrollvillkor', // by Claude Fable 5
	'Alter check' => 'Ändra kontrollvillkor', // by Claude Fable 5
	'Check has been created.' => 'Kontrollvillkoret har skapats.', // by Claude Fable 5
	'Check has been altered.' => 'Kontrollvillkoret har ändrats.', // by Claude Fable 5
	'Check has been dropped.' => 'Kontrollvillkoret har tagits bort.', // by Claude Fable 5

	// Selection
	'Select data' => 'Välj data',
	'Select' => 'Välj',
	'Functions' => 'Funktioner',
	'Aggregation' => 'Aggregation',
	'Search' => 'Sök',
	'anywhere' => 'överallt',
	'Sort' => 'Sortera',
	'descending' => 'Fallande',
	'Limit' => 'Begränsning',
	'Limit rows' => 'Begränsa rader',
	'Text length' => 'Textlängd',
	'Action' => 'Åtgärd',
	'Full table scan' => 'Full tabellskanning',
	'Unable to select the table' => 'Kunde inte välja tabellen',
	'Search data in tables' => 'Sök data i tabeller',
	'No rows.' => 'Inga rader.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d rad',
		'%d rader',
	],
	'Page' => 'Sida',
	'last' => 'sist',
	'Load more data' => 'Ladda mer data',
	'Loading' => 'Laddar',
	'Whole result' => 'Hela resultatet',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Ändra',
	'Ctrl+click on a value to modify it.' => 'Ctrl+klicka på ett värde för att ändra det.',
	'Use edit link to modify this value.' => 'Använd redigeringslänken för att ändra värdet.',

	// Editing
	'New item' => 'Ny sak',
	'Edit' => 'Redigera',
	'original' => 'original',
	'empty' => 'tom', // label for value '' in enum data type
	'Insert' => 'Infoga',
	'Save' => 'Spara',
	'Save and continue edit' => 'Spara och fortsätt att redigera',
	'Save and insert next' => 'Spara och infoga nästa',
	'Saving' => 'Sparar',
	'Selected' => 'Vald',
	'Clone' => 'Klona',
	'Delete' => 'Ta bort',
	'Item%s has been inserted.' => 'Sak%s har skapats.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'En sak har tagits bort.',
	'Item has been updated.' => 'En sak har ändrats.',
	'%d item(s) have been affected.' => [
		'%d sak har blivit förändrad.',
		'%d saker har blivit förändrade.',
	],
	'You have no privileges to update this table.' => 'Du har inga privilegier för att uppdatera den här tabellen.',

	// Data type descriptions
	'Numbers' => 'Nummer',
	'Date and time' => 'Datum och tid',
	'Strings' => 'Strängar',
	'Binary' => 'Binärt',
	'Lists' => 'Listor',
	'Network' => 'Nätverk',
	'Geometry' => 'Geometri',
	'Relations' => 'Relationer',

	// Editor - data values
	'now' => 'nu',
	'yes' => 'ja',
	'no' => 'nej',

	// Settings
	'Settings' => 'Inställningar', // by Claude Opus 5
	'Default' => 'Standard', // by Claude Opus 5
	'Color scheme' => 'Färgtema', // by Claude Opus 5
	'By system' => 'Enligt systemet', // by Claude Opus 5
	'Light' => 'Ljust', // by Claude Opus 5
	'Dark' => 'Mörkt', // by Claude Opus 5
	'Navigation mode' => 'Navigeringsläge', // by Claude Opus 5
	'Simple' => 'Enkelt', // by Claude Opus 5
	'Dual' => 'Dubbelt', // by Claude Opus 5
	'Reversed' => 'Omvänt', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Utformning av huvudnavigeringen med tabellänkar.', // by Claude Opus 5
	'Table links' => 'Tabellänkar', // by Claude Opus 5
	'Primary action for all table links.' => 'Primär åtgärd för alla tabellänkar.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Länkar till tabeller som refererar till den aktuella raden.', // by Claude Opus 5
	'Display' => 'Visa', // by Claude Opus 5
	'Hide' => 'Dölj', // by Claude Opus 5
	'Records per page' => 'Poster per sida', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Antal poster som visas i datatabellen som standard.', // by Claude Opus 5
	'Enum as select' => 'Enum som vallista', // by Claude Opus 5
	'Never' => 'Aldrig', // by Claude Opus 5
	'Always' => 'Alltid', // by Claude Opus 5
	'More values than %d' => 'Fler än %d värden', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Gräns för att visa en vallista för enum-fält.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Engångslösenord', // by Claude Opus 5
	'Enter OTP code.' => 'Ange OTP-koden.', // by Claude Opus 5
	'Invalid OTP code.' => 'Ogiltig OTP-kod.', // by Claude Opus 5
	'Access denied.' => 'Åtkomst nekad.', // by Claude Opus 5
	'JSON previews' => 'JSON-förhandsvisning', // by Claude Opus 5
	'Data table' => 'Datatabell', // by Claude Opus 5
	'Edit form' => 'Redigeringsformulär', // by Claude Opus 5
	'Ask %s' => null,
];
