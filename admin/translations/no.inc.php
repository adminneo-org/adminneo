<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$6/$4 $1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'D/M ÅÅÅÅ', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap

	// Login
	'System' => 'System',
	'Server' => 'Server',
	'Username' => 'Brukernavn',
	'Password' => 'Passord',
	'Permanent login' => 'Permanent login',
	'Login' => 'Logg inn',
	'Logout' => 'Logg ut',
	'Logged as: %s' => 'Logget inn som: %s',
	'Logout successful.' => 'Utlogging vellykket.',
	'hostname[:port] or :socket' => 'hostname[:port] eller :socket', // by Claude Fable 5
	'There is a space in the input password which might be the cause.' => 'Det er et mellomrom i det angitte passordet, noe som kan være årsaken.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo støtter ikke tilgang til en database uten passord, <a href="https://www.adminneo.org/password"%s>mer informasjon</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Databasen støtter ikke passord.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'For mange mislykkede innloggingsforsøk, prøv igjen om %d minutt.',
		'For mange mislykkede innloggingsforsøk, prøv igjen om %d minutter.',
	], // by Claude Fable 5
	'Invalid CSRF token. Send the form again.' => 'Ugylding CSRF-token - Send inn skjemaet igjen.',
	'If you did not send this request from AdminNeo then close this page.' => 'Hvis du ikke sendte denne forespørselen fra AdminNeo, lukk denne siden.', // by Claude Fable 5
	'The action will be performed after successful login with the same credentials.' => 'Handlingen utføres etter vellykket innlogging med samme påloggingsinformasjon.', // by Claude Fable 5

	// Connection
	'No extension' => 'Ingen utvidelse',
	'None of the supported PHP extensions (%s) are available.' => 'Ingen av de støttede PHP-utvidelsene (%s) er tilgjengelige.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Tilkobling til privilegerte porter er ikke tillatt.', // by Claude Fable 5
	'Session support must be enabled.' => 'Økt-støtte må være skrudd på.',
	'Session expired, please login again.' => 'Økt utløpt - vennligst logg inn på nytt.',
	'%s version: %s through PHP extension %s' => '%s versjon: %s via PHP-utvidelse %s',

	// Settings
	'Language' => 'Språk',

	'Refresh' => 'Gjenoppfrisk',

	// Privileges
	'Privileges' => 'Privilegier',
	'Create user' => 'Lag bruker',
	'User has been dropped.' => 'Bruker slettet.',
	'User has been altered.' => 'Bruker endret.',
	'User has been created.' => 'Bruker opprettet.',
	'Hashed' => 'Hashet',

	// Server
	'Process list' => 'Prosessliste',
	'%d process(es) have been killed.' => [
		'%d prosess avsluttet.',
		'%d prosesser avsluttet.',
	],
	'Kill' => 'Avslutt',
	'Variables' => 'Variabler',
	'Status' => 'Status',

	// Structure
	'Column' => 'Kolonne',
	'Columns' => 'Kolonner', // by Claude Fable 5
	'Routine' => 'Rutine',
	'Grant' => 'Gi privilegier',
	'Revoke' => 'Trekk tilbake',

	// Queries
	'SQL command' => 'SQL-kommando',
	'%d query(s) executed OK.' => [
		'%d kall utført OK.',
		'%d kall utført OK.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Kall utført OK, %d rad påvirket.',
		'Kall utført OK, %d rader påvirket.',
	],
	'No commands to execute.' => 'Ingen kommandoer å utføre.',
	'Error in query' => 'Feil i forespørsel',
	'Unknown error.' => 'Ukjent feil.', // by Claude Fable 5
	'Warnings' => 'Advarsler', // by Claude Fable 5
	'%s queries are not supported.' => '%s-spørringer støttes ikke.', // by Claude Fable 5
	'Execute' => 'Kjør',
	'Stop on error' => 'Stopp ved feil',
	'Show only errors' => 'Vis bare feil',
	'Time' => 'Tid',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Historie',
	'Clear' => 'Tøm skjema',
	'Edit all' => 'Rediger alle',

	// Import
	'Import' => 'Importer',
	'File upload' => 'Filopplasting',
	'From server' => 'Fra server',
	'Webserver file %s' => 'Webserver-fil %s',
	'Run file' => 'Kjør fil',
	'File does not exist.' => 'Filen eksisterer ikke.',
	'File uploads are disabled.' => 'Filopplastinger ikke tillatt.',
	'Unable to upload a file.' => 'Kunne ikke laste opp fil.',
	'Maximum allowed file size is %sB.' => 'Maksimum tillatte filstørrelse er %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'For stor datamengde i skjemaet. Reduser datamengden, eller øk størrelsen på %s-konfigurasjonsdirektivet.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Du kan laste opp en stor SQL-fil via FTP og importere den fra serveren.',
	'File must be in UTF-8 encoding.' => 'Filen må være i UTF8-tegnkoding.',
	'You are offline.' => 'Du er frakoblet.', // by Claude Fable 5
	'%d row(s) have been imported.' => [
		'%d rad er importert.',
		'%d rader er importert.',
	],

	// Export
	'Export' => 'Eksport',
	'Output' => 'Resultat',
	'open' => 'åpne',
	'save' => 'lagre',
	'Format' => 'Format',
	'Data' => 'Data',

	// Databases
	'Database' => 'Database',
	'DB' => 'DB', // by Claude Fable 5
	'Use' => 'Bruk',
	'Invalid database.' => 'Ugyldig database.',
	'Alter database' => 'Endre database',
	'Create database' => 'Opprett database',
	'Database schema' => 'Databaseskjema',
	'Permanent link' => 'Permanent lenke',
	'Database has been dropped.' => 'Databasen har blitt slettet.',
	'Databases have been dropped.' => 'Databasene har blitt slettet.',
	'Database has been created.' => 'Databasen er opprettet.',
	'Database has been renamed.' => 'Databasen har fått nytt navn.',
	'Database has been altered.' => 'Databasen er endret.',

	// SQLite errors
	'File exists.' => 'Filen finnes.',
	'Please use one of the extensions %s.' => 'Vennligst bruk en av filendelsene %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Skjema',
	'Alter schema' => 'Endre skjema',
	'Create schema' => 'Opprett skjema',
	'Schema has been dropped.' => 'Skjemaet er slettet.',
	'Schema has been created.' => 'Skjemaet er opprettet.',
	'Schema has been altered.' => 'Skjemaet er endret.',
	'Invalid schema.' => 'Ugylding skjema.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'mottor',
	'Collation' => 'Tekstsortering',
	'collation' => 'sortering',
	'Data Length' => 'Datalengde',
	'Index Length' => 'Indekslengde',
	'Data Free' => 'Frie data',
	'Rows' => 'Rader',
	'%d in total' => '%d totalt',
	'Analyze' => 'Analyser',
	'Optimize' => 'Optimaliser',
	'Vacuum' => 'Støvsug',
	'Check' => 'Sjekk',
	'Repair' => 'Reparer',
	'Truncate' => 'Avkort',
	'Tables have been truncated.' => 'Tabellene har blitt avkortet.',
	'Move to other database' => 'Flytt til annen database',
	'Move' => 'Flytt',
	'Tables have been moved.' => 'Tabellene har blitt flyttet.',
	'Copy' => 'Kopier',
	'Tables have been copied.' => 'Tabellene har blitt kopiert.',
	'overwrite' => 'overskriv', // by Claude Fable 5

	// Tables
	'Tables' => 'Tabeller',
	'Tables and views' => 'Tabeller og views',
	'Table' => 'Tabell',
	'No tables.' => 'Ingen tabeller.',
	'Alter table' => 'Endre tabell',
	'Create table' => 'Opprett tabell',
	'Table has been dropped.' => 'Tabellen er slettet.',
	'Tables have been dropped.' => 'Tabellene er slettet.',
	'Tables have been optimized.' => 'Tabellene er blitt optimalisert.',
	'Table has been altered.' => 'Tabellen er endret.',
	'Table has been created.' => 'Tabellen er opprettet.',
	'Table name' => 'Tabellnavn',
	'Name' => 'Navn',
	'Show structure' => 'Vis struktur',
	'Column name' => 'Kolonnenavn',
	'Type' => 'Type',
	'Length' => 'Lengde',
	'Auto Increment' => 'Autoinkrement',
	'Options' => 'Valg',
	'Comment' => 'Kommentarer',
	'Default value' => 'Standardverdi', // by Claude Fable 5
	'Drop' => 'Dropp',
	'Drop %s?' => 'Dropp %s?', // by Claude Fable 5
	'Are you sure?' => 'Er du sikker?',
	'Size' => 'Størrelse', // by Claude Fable 5
	'Compute' => 'Beregn', // by Claude Fable 5
	'Move up' => 'Flytt opp',
	'Move down' => 'Flytt ned',
	'Remove' => 'Fjern',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Maksimum antall feltnavn overskredet - venligst øk %s.',

	// Views
	'View' => 'View',
	'Materialized view' => 'Materialisert view', // by Claude Fable 5
	'View has been dropped.' => 'Viewet er slettet.',
	'View has been altered.' => 'Viewet er endret.',
	'View has been created.' => 'Viewet er opprettet.',
	'Alter view' => 'Endre view',
	'Create view' => 'Lag nytt view',

	// Partitions
	'Partition by' => 'Partisjoner ved',
	'Partitions' => 'Partisjoner',
	'Partition name' => 'Partisjonsnavn',
	'Values' => 'Verdier',

	// Indexes
	'Indexes' => 'Indekser',
	'Indexes have been altered.' => 'Indeksene er endret.',
	'Alter indexes' => 'Endre indekser',
	'Add next' => 'Legg til neste',
	'Index Type' => 'Indekstype',
	'length' => 'lengde',
	'Algorithm' => 'Algoritme', // by Claude Fable 5
	'Condition' => 'Betingelse', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Fremmednøkler',
	'Foreign key' => 'Fremmednøkkel',
	'Foreign key has been dropped.' => 'Fremmednøkkelen er slettet.',
	'Foreign key has been altered.' => 'Fremmednøkkelen er endret.',
	'Foreign key has been created.' => 'Fremmednøkkelen er opprettet.',
	'Target table' => 'Måltabell',
	'Change' => 'Endre',
	'Source' => 'Kilde',
	'Target' => 'Mål',
	'Add column' => 'Legg til kolonne',
	'Alter' => 'Endre',
	'Add foreign key' => 'Legg til fremmednøkkel',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Kilde- og mål-kolonner må ha samme datatype, det må være en indeks på mål-kolonnen, og dataene som refereres til må eksistere.',

	// Routines
	'Routines' => 'Rutiner',
	'Routine has been called, %d row(s) affected.' => [
		'Rutinen er utført, %d rad påvirket.',
		'Rutinen er utført, %d rader påvirket.',
	],
	'Call' => 'Kall',
	'Parameter name' => 'Parameternavn',
	'Create procedure' => 'Opprett prosedyre',
	'Create function' => 'Opprett funksjon',
	'Routine has been dropped.' => 'Rutinen er slettet.',
	'Routine has been altered.' => 'Rutinen er endret.',
	'Routine has been created.' => 'Rutinen er opprettet.',
	'Alter function' => 'Endre funksjon',
	'Alter procedure' => 'Endre prosedyre',
	'Return type' => 'Returtype',

	// Events
	'Events' => 'Eventer',
	'Event' => 'Hendelse',
	'Event has been dropped.' => 'Eventen er slettet.',
	'Event has been altered.' => 'Eventen er endret.',
	'Event has been created.' => 'Eventen er opprettet.',
	'Alter event' => 'Endre event',
	'Create event' => 'Opprett event',
	'At given time' => 'På gitte tid',
	'Every' => 'Hver',
	'Schedule' => 'Tidsplan',
	'Start' => 'Start',
	'End' => 'Slutt',
	'On completion preserve' => 'Ved fullførelse bevar',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sekvenser',
	'Create sequence' => 'Opprett sekvens',
	'Sequence has been dropped.' => 'Sekvensen er slettet.',
	'Sequence has been created.' => 'Sekvensen er opprettet.',
	'Sequence has been altered.' => 'Sekvensen er endret.',
	'Alter sequence' => 'Endre sekvens',

	// User types (PostgreSQL)
	'User types' => 'Brukertyper',
	'Create type' => 'Opprett type',
	'Type has been dropped.' => 'Type er slettet.',
	'Type has been created.' => 'Type er opprettet.',
	'Alter type' => 'Endre type',

	// Triggers
	'Triggers' => 'Triggere',
	'Add trigger' => 'Legg til trigger',
	'Trigger has been dropped.' => 'Triggeren er slettet.',
	'Trigger has been altered.' => 'Triggeren er endret.',
	'Trigger has been created.' => 'Triggeren er opprettet.',
	'Alter trigger' => 'Endre trigger',
	'Create trigger' => 'Opprett trigger',

	// Table check constraints
	'Checks' => 'Kontroller', // by Claude Fable 5
	'Create check' => 'Opprett kontroll', // by Claude Fable 5
	'Alter check' => 'Endre kontroll', // by Claude Fable 5
	'Check has been created.' => 'Kontrollen er opprettet.', // by Claude Fable 5
	'Check has been altered.' => 'Kontrollen er endret.', // by Claude Fable 5
	'Check has been dropped.' => 'Kontrollen er slettet.', // by Claude Fable 5

	// Selection
	'Select data' => 'Velg data',
	'Select' => 'Velg',
	'Functions' => 'Funksjoner',
	'Aggregation' => 'Sammenfatning',
	'Search' => 'Søk',
	'anywhere' => 'hvorsomhelst',
	'Sort' => 'Sorter',
	'descending' => 'minkende',
	'Limit' => 'Skranke',
	'Limit rows' => 'Begrens rader', // by Claude Fable 5
	'Text length' => 'Tekstlengde',
	'Action' => 'Handling',
	'Full table scan' => 'Full tabell-scan',
	'Unable to select the table' => 'Kan ikke velge tabellen',
	'Search data in tables' => 'Søk data i tabeller',
	'No rows.' => 'Ingen rader.',
	'%d / ' => '%d / ', // by Claude Fable 5
	'%d row(s)' => [
		'%d rad',
		'%d rader',
	],
	'Page' => 'Side',
	'last' => 'siste',
	'Load more data' => 'Last mer data',
	'Loading' => 'Laster',
	'Whole result' => 'Hele resultatet',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Endre',
	'Ctrl+click on a value to modify it.' => 'Ctrl+klikk på en verdi for å endre den.',
	'Use edit link to modify this value.' => 'Bruk rediger-lengde for å endre dennne verdien.',

	// Editing
	'New item' => 'Ny rad',
	'Edit' => 'Rediger',
	'original' => 'original',
	'empty' => 'tom', // label for value '' in enum data type
	'Insert' => 'Sett inn',
	'Save' => 'Lagre',
	'Save and continue edit' => 'Lagre og fortsett å redigere',
	'Save and insert next' => 'Lagre og sett inn neste',
	'Saving' => 'Lagrer',
	'Selected' => 'Valgt',
	'Clone' => 'Klon',
	'Delete' => 'Slett',
	'Item%s has been inserted.' => 'Rad%s er satt inn.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Raden er slettet.',
	'Item has been updated.' => 'Raden er oppdatert.',
	'%d item(s) have been affected.' => [
		'%d rad påvirket.',
		'%d rader påvirket.',
	],
	'You have no privileges to update this table.' => 'Du mangler rettighetene som trengs for å endre denne tabellen.',

	// Data type descriptions
	'Numbers' => 'Nummer',
	'Date and time' => 'Dato og tid',
	'Strings' => 'Strenger',
	'Binary' => 'Binære',
	'Lists' => 'Lister',
	'Network' => 'Nettverk',
	'Geometry' => 'Geometri',
	'Relations' => 'Relasjoner',

	// Editor - data values
	'now' => 'nå',
	'yes' => 'ja',
	'no' => 'nei',

	// Settings

	// Plugins
];
