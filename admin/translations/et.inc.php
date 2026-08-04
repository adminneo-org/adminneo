<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$6.$4.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'D.M.YYYY', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s peab tagastama massiivi.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s ja %s peavad tagastama objekti, mis on loodud meetodiga %s.', // by Claude Opus 5

	// Login
	'System' => 'Andmebaasimootor',
	'Server' => 'Server',
	'Username' => 'Kasutajanimi',
	'Password' => 'Parool',
	'Permanent login' => 'Jäta mind meelde',
	'Login' => 'Logi sisse',
	'Logout' => 'Logi välja',
	'Logged as: %s' => 'Sisse logitud: %s',
	'Logout successful.' => 'Väljalogimine õnnestus.',
	'hostname[:port] or :socket' => 'hostinimi[:port] või :sokkel', // by Claude Opus 5
	'Invalid server or credentials.' => 'Sobimatu server või sisselogimisandmed.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Sisestatud paroolis on tühik, mis võib olla põhjuseks.', // by Claude Opus 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ei toeta andmebaasi kasutamist ilma paroolita, <a href="https://www.adminneo.org/password"%s>rohkem infot</a>.', // by Claude Opus 5
	'Database does not support password.' => 'Andmebaas ei toeta parooli.', // by Claude Opus 5
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Liiga palju ebaõnnestunud sisselogimisi, proovi uuesti %d minuti pärast.', // by Claude Opus 5
	'Invalid permanent login, please login again.' => 'Sobimatu püsiv sisselogimine, palun logige uuesti sisse.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Sobimatu CSRF, palun postitage vorm uuesti.',
	'If you did not send this request from AdminNeo then close this page.' => 'Kui te ei saatnud seda päringut AdminNeost, siis sulgege see leht.', // by Claude Opus 5
	'The action will be performed after successful login with the same credentials.' => 'Tegevus viiakse läbi pärast edukat sisselogimist samade andmetega.', // by Claude Opus 5

	// Connection
	'No driver' => 'Ei leitud draiverit', // by Claude Opus 5
	'Database driver not found.' => 'Andmebaasi draiverit ei leitud.', // by Claude Opus 5
	'No extension' => 'Ei leitud laiendust',
	'None of the supported PHP extensions (%s) are available.' => 'Serveris pole ühtegi toetatud PHP laiendustest (%s).', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Privilegeeritud portidega ühendumine ei ole lubatud.', // by Claude Opus 5
	'Session support must be enabled.' => 'Sessioonid peavad olema lubatud.',
	'Session expired, please login again.' => 'Sessioon on aegunud, palun logige uuesti sisse.',
	'%s version: %s through PHP extension %s' => '%s versioon: %s, kasutatud PHP moodul: %s',

	// Settings
	'Language' => 'Keel',

	'Home' => 'Avaleht', // by Claude Opus 5
	'Refresh' => 'Uuenda',
	'Info' => 'Info', // by Claude Opus 5
	'More information.' => 'Rohkem infot.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Õigused',
	'Create user' => 'Loo uus kasutaja',
	'User has been dropped.' => 'Kasutaja on edukalt kustutatud.',
	'User has been altered.' => 'Kasutaja andmed on edukalt muudetud.',
	'User has been created.' => 'Kasutaja on edukalt lisatud.',
	'Hashed' => 'Häshitud (Hashed)',

	// Server
	'Process list' => 'Protsesside nimekiri',
	'%d process(es) have been killed.' => [
		'Protsess on edukalt peatatud (%d).',
		'Valitud protsessid (%d) on edukalt peatatud.',
	],
	'Kill' => 'Peata',
	'Variables' => 'Muutujad',
	'Status' => 'Staatus',

	// Structure
	'Column' => 'Veerg',
	'Columns' => 'Veerud', // by Claude Opus 5
	'Routine' => 'Protseduur',
	'Grant' => 'Anna',
	'Revoke' => 'Eemalda',

	// Queries
	'SQL command' => 'SQL-Päring',
	'HTTP request' => 'HTTP-päring', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d päring edukalt käivitatud.',
		'%d päringut edukalt käivitatud.',
	],
	'Query executed OK, %d row(s) affected.' => 'Päring õnnestus, mõjutatatud ridu: %d.',
	'No commands to execute.' => 'Käsk puudub.',
	'Error in query' => 'Päringus esines viga',
	'Unknown error.' => 'Tundmatu viga.', // by Claude Opus 5
	'Warnings' => 'Hoiatused', // by Claude Opus 5
	'%s queries are not supported.' => '%s päringud ei ole toetatud.', // by Claude Opus 5
	'Execute' => 'Käivita',
	'Stop on error' => 'Peatuda vea esinemisel',
	'Show only errors' => 'Kuva vaid veateateid',
	'Time' => 'Aeg',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Ajalugu',
	'Clear' => 'Puhasta',
	'Edit all' => 'Muuda kõiki',

	// Import
	'Import' => 'Impordi',
	'File upload' => 'Faili üleslaadimine',
	'From server' => 'Serverist',
	'Webserver file %s' => 'Fail serveris: %s',
	'Run file' => 'Käivita fail',
	'File does not exist.' => 'Faili ei leitud.',
	'File uploads are disabled.' => 'Failide üleslaadimine on keelatud.',
	'Unable to upload a file.' => 'Faili üleslaadimine pole võimalik.',
	'Maximum allowed file size is %sB.' => 'Maksimaalne failisuurus %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Failide maksimaalne arv on %d. Palun valige vähem faile või suurendage %s php-seadet.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Failide maksimaalne kogusuurus on %s. Palun valige väiksemad failid või suurendage %s php-seadet.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST-andmete maht on liialt suur. Palun vähendage andmeid või suurendage %s php-seadet.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Suure SQL-faili saab üles laadida FTP kaudu ja importida serverist.', // by Claude Opus 5
	'File must be in UTF-8 encoding.' => 'Fail peab olema UTF-8 kodeeringus.', // by Claude Opus 5
	'You are offline.' => 'Sa oled võrgust väljas.', // by Claude Opus 5
	'%d row(s) have been imported.' => 'Imporditi %d rida.',

	// Export
	'Export' => 'Ekspordi',
	'Output' => 'Väljund',
	'open' => 'näita brauseris',
	'save' => 'salvesta failina',
	'Format' => 'Formaat',
	'Data' => 'Andmed',

	// Databases
	'Database' => 'Andmebaas',
	'database' => 'andmebaas', // by Claude Opus 5
	'DB' => 'AB', // by Claude Opus 5
	'Use' => 'Kasuta',
	'Invalid database.' => 'Tundmatu andmebaas.',
	'Alter database' => 'Muuda andmebaasi',
	'Create database' => 'Loo uus andmebaas',
	'Database schema' => 'Andmebaasi skeem',
	'Permanent link' => 'Püsilink',
	'Database has been dropped.' => 'Andmebaas on edukalt kustutatud.',
	'Databases have been dropped.' => 'Andmebaasid on edukalt kustutatud.',
	'Database has been created.' => 'Andmebaas on edukalt loodud.',
	'Database has been renamed.' => 'Andmebaas on edukalt ümber nimetatud.',
	'Database has been altered.' => 'Andmebaasi struktuuri uuendamine õnnestus.',

	// SQLite errors
	'File exists.' => 'Fail juba eksisteerib.',
	'Please use one of the extensions %s.' => 'Palun kasuta üht laiendustest %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Struktuur',
	'schema' => 'struktuur', // by Claude Opus 5
	'Schemas' => 'Struktuurid', // by Claude Opus 5
	'No schemas.' => 'Struktuure ei leitud.', // by Claude Opus 5
	'Show schema' => 'Näita struktuuri', // by Claude Opus 5
	'Alter schema' => 'Muuda struktuuri',
	'Create schema' => 'Loo struktuur',
	'Schema has been dropped.' => 'Struktuur on edukalt kustutatud.',
	'Schema has been created.' => 'Struktuur on edukalt loodud.',
	'Schema has been altered.' => 'Struktuur on edukalt muudetud.',
	'Invalid schema.' => 'Sobimatu skeema.',

	// Table list
	'Engine' => 'Implementatsioon',
	'engine' => 'andmebaasimootor',
	'Collation' => 'Tähetabel',
	'collation' => 'tähetabel',
	'Data Length' => 'Andmete pikkus',
	'Index Length' => 'Indeksi pikkus',
	'Data Free' => 'Vaba ruumi',
	'Rows' => 'Ridu',
	'%d in total' => 'Kokku: %d',
	'Analyze' => 'Analüüsi',
	'Optimize' => 'Optimeeri',
	'Vacuum' => 'Puhasta (VACUUM)', // by Claude Opus 5
	'Check' => 'Kontrolli',
	'Repair' => 'Paranda',
	'Truncate' => 'Tühjenda',
	'Tables have been truncated.' => 'Valitud tabelid on edukalt tühjendatud.', // by Claude Opus 5
	'Move to other database' => 'Liiguta teise andmebaasi',
	'Move' => 'Liiguta',
	'Tables have been moved.' => 'Valitud tabelid on edukalt liigutatud.',
	'Copy' => 'Kopeeri',
	'Tables have been copied.' => 'Tabelid on edukalt kopeeritud.',
	'overwrite' => 'kirjuta üle', // by Claude Opus 5

	// Tables
	'Tables' => 'Tabelid',
	'Tables and views' => 'Tabelid ja vaated',
	'Table' => 'Tabel',
	'No tables.' => 'Tabeleid ei leitud.',
	'Alter table' => 'Muuda tabeli struktuuri',
	'Create table' => 'Loo uus tabel',
	'Table has been dropped.' => 'Tabel on edukalt kustutatud.',
	'Tables have been dropped.' => 'Valitud tabelid on edukalt kustutatud.',
	'Tables have been optimized.' => 'Valitud tabelid on edukalt optimeeritud.', // by Claude Opus 5
	'Table has been altered.' => 'Tabeli andmed on edukalt muudetud.',
	'Table has been created.' => 'Tabel on edukalt loodud.',
	'Table name' => 'Tabeli nimi',
	'Name' => 'Nimi',
	'Show structure' => 'Näita struktuuri',
	'Column name' => 'Veeru nimi',
	'Type' => 'Tüüp',
	'Length' => 'Pikkus',
	'Auto Increment' => 'Automaatselt suurenev',
	'Options' => 'Valikud',
	'Comment' => 'Kommentaar',
	'Default value' => 'Vaikeväärtus', // by Claude Opus 5
	'Drop' => 'Kustuta',
	'Drop %s?' => 'Kustuta %s?', // by Claude Opus 5
	'Are you sure?' => 'Kas oled kindel?',
	'Size' => 'Suurus', // by Claude Opus 5
	'Compute' => 'Arvuta', // by Claude Opus 5
	'Move up' => 'Liiguta ülespoole',
	'Move down' => 'Liiguta allapoole',
	'Remove' => 'Eemalda',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Maksimaalne väljade arv ületatud. Palun suurendage %s.',

	// Views
	'View' => 'Vaata',
	'Materialized view' => 'Materialiseeritud vaade', // by Claude Opus 5
	'View has been dropped.' => 'Vaade (VIEW) on edukalt kustutatud.',
	'View has been altered.' => 'Vaade (VIEW) on edukalt muudetud.',
	'View has been created.' => 'Vaade (VIEW) on edukalt loodud.',
	'Alter view' => 'Muuda vaadet (VIEW)',
	'Create view' => 'Loo uus vaade (VIEW)',

	// Partitions
	'Partition by' => 'Partitsiooni',
	'Partition' => 'Partitsioon', // by Claude Opus 5
	'Partitions' => 'Partitsioonid',
	'Partition name' => 'Partitsiooni nimi',
	'Values' => 'Väärtused',
	'Inherited tables' => 'Päritud tabelid', // by Claude Opus 5
	'Inherited from' => 'Päritud tabelist', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Indeksid',
	'Indexes have been altered.' => 'Indeksite andmed on edukalt uuendatud.',
	'Alter indexes' => 'Muuda indekseid',
	'Add next' => 'Lisa järgmine',
	'Index Type' => 'Indeksi tüüp',
	'length' => 'pikkus',
	'Algorithm' => 'Algoritm', // by Claude Opus 5
	'Condition' => 'Tingimus', // by Claude Opus 5

	// Foreign keys
	'Foreign keys' => 'Võõrvõtmed (foreign key)',
	'Foreign key' => 'Võõrvõti',
	'Foreign key has been dropped.' => 'Võõrvõti on edukalt kustutatud.',
	'Foreign key has been altered.' => 'Võõrvõtme andmed on edukalt muudetud.',
	'Foreign key has been created.' => 'Võõrvõri on edukalt loodud.',
	'Target table' => 'Siht-tabel',
	'Change' => 'Muuda',
	'Source' => 'Allikas',
	'Target' => 'Sihtkoht',
	'Add column' => 'Lisa veerg',
	'Alter' => 'Muuda',
	'Add foreign key' => 'Lisa võõrvõti',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Lähte- ja sihtveerud peavad eksisteerima ja omama sama andmetüüpi, sihtveergudel peab olema määratud indeks ning viidatud andmed peavad eksisteerima.',

	// Routines
	'Routines' => 'Protseduurid',
	'Routine has been called, %d row(s) affected.' => 'Protseduur täideti edukalt, mõjutatud ridu: %d.',
	'Call' => 'Käivita',
	'Parameter name' => 'Parameetri nimi',
	'Create procedure' => 'Loo uus protseduur',
	'Create function' => 'Loo uus funktsioon',
	'Routine has been dropped.' => 'Protseduur on edukalt kustutatud.',
	'Routine has been altered.' => 'Protseduuri andmed on edukalt muudetud.',
	'Routine has been created.' => 'Protseduur on edukalt loodud.',
	'Alter function' => 'Muuda funktsiooni',
	'Alter procedure' => 'Muuda protseduuri',
	'Return type' => 'Tagastustüüp',

	// Events
	'Events' => 'Sündmused (EVENTS)',
	'Event' => 'Sündmus',
	'Event has been dropped.' => 'Sündmus on edukalt kustutatud.',
	'Event has been altered.' => 'Sündmuse andmed on edukalt uuendatud.',
	'Event has been created.' => 'Sündmus on edukalt loodud.',
	'Alter event' => 'Muuda sündmuse andmeid',
	'Create event' => 'Loo uus sündmus (EVENT)',
	'At given time' => 'Antud ajahetkel',
	'Every' => 'Iga',
	'Schedule' => 'Ajakava',
	'Start' => 'Alusta',
	'End' => 'Lõpeta',
	'On completion preserve' => 'Lõpetamisel jäta sündmus alles',

	// Sequences (PostgreSQL)
	'Sequences' => 'Jadad (sequences)',
	'Create sequence' => 'Loo jada',
	'Sequence has been dropped.' => 'Jada on edukalt kustutatud.',
	'Sequence has been created.' => 'Jada on edukalt loodud.',
	'Sequence has been altered.' => 'Jada on edukalt muudetud.',
	'Alter sequence' => 'Muuda jada',

	// User types (PostgreSQL)
	'User types' => 'Kasutajatüübid',
	'Create type' => 'Loo tüüp',
	'Type has been dropped.' => 'Tüüp on edukalt kustutatud.',
	'Type has been created.' => 'Tüüp on edukalt loodud.',
	'Alter type' => 'Muuda tüüpi',

	// Triggers
	'Triggers' => 'Päästikud (trigger)',
	'Add trigger' => 'Lisa päästik (TRIGGER)',
	'Trigger has been dropped.' => 'Päästik on edukalt kustutatud.',
	'Trigger has been altered.' => 'Päästiku andmed on edukalt uuendatud.',
	'Trigger has been created.' => 'Uus päästik on edukalt loodud.',
	'Alter trigger' => 'Muuda päästiku andmeid',
	'Create trigger' => 'Loo uus päästik (TRIGGER)',

	// Table check constraints
	'Checks' => 'Kontrollid', // by Claude Opus 5
	'Create check' => 'Loo uus kontroll', // by Claude Opus 5
	'Alter check' => 'Muuda kontrolli', // by Claude Opus 5
	'Check has been created.' => 'Uus kontroll on edukalt loodud.', // by Claude Opus 5
	'Check has been altered.' => 'Kontrolli andmed on edukalt muudetud.', // by Claude Opus 5
	'Check has been dropped.' => 'Kontroll on edukalt kustutatud.', // by Claude Opus 5

	// Selection
	'Select data' => 'Vaata andmeid',
	'Select' => 'Kuva',
	'Functions' => 'Funktsioonid',
	'Aggregation' => 'Liitmine',
	'Search' => 'Otsi',
	'anywhere' => 'vahet pole',
	'Sort' => 'Sorteeri',
	'descending' => 'kahanevalt',
	'Limit' => 'Piira',
	'Limit rows' => 'Piira ridu', // by Claude Opus 5
	'Text length' => 'Teksti pikkus',
	'Action' => 'Tegevus',
	'Full table scan' => 'Kogu tabeli läbivaatus', // by Claude Opus 5
	'Unable to select the table' => 'Tabeli valimine ebaõnnestus',
	'Search data in tables' => 'Otsi kogu andmebaasist',
	'No rows.' => 'Sissekanded puuduvad.',
	'%d / ' => '%d / ', // by Claude Opus 5
	'%d row(s)' => '%d rida',
	'Page' => 'Lehekülg',
	'last' => 'viimane',
	'Load more data' => 'Laadi rohkem andmeid', // by Claude Opus 5
	'Loading' => 'Laadin', // by Claude Opus 5
	'Whole result' => 'Täielikud tulemused',
	'%d byte(s)' => [
		'%d bait',
		'%d baiti',
	],

	// In-place editing in selection
	'Modify' => 'Muuda', // by Claude Opus 5
	'Ctrl+click on a value to modify it.' => 'Väärtuse muutmiseks Ctrl+kliki sellel.',
	'Use edit link to modify this value.' => 'Väärtuse muutmiseks kasuta muutmislinki.',

	// Editing
	'New item' => 'Lisa kirje',
	'Edit' => 'Muuda',
	'original' => 'originaal',
	'empty' => 'tühi', // label for value '' in enum data type
	'Insert' => 'Sisesta',
	'Save' => 'Salvesta',
	'Save and continue edit' => 'Salvesta ja jätka muutmist',
	'Save and insert next' => 'Salvesta ja lisa järgmine',
	'Saving' => 'Salvestan', // by Claude Opus 5
	'Selected' => 'Valitud', // by Claude Opus 5
	'Clone' => 'Kloon',
	'Delete' => 'Kustuta',
	'Item%s has been inserted.' => 'Kirje%s on edukalt lisatud.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Kustutamine õnnestus.',
	'Item has been updated.' => 'Uuendamine õnnestus.',
	'%d item(s) have been affected.' => 'Mõjutatud kirjeid: %d.',
	'You have no privileges to update this table.' => 'Sul ei ole õigusi selle tabeli muutmiseks.', // by Claude Opus 5

	// Data type descriptions
	'Numbers' => 'Numbrilised',
	'Date and time' => 'Kuupäev ja kellaaeg',
	'Strings' => 'Tekstid',
	'Binary' => 'Binaar',
	'Lists' => 'Listid',
	'Network' => 'Võrk (network)',
	'Geometry' => 'Geomeetria',
	'Relations' => 'Seosed',

	// Editor - data values
	'now' => 'nüüd',
	'yes' => 'jah', // by Claude Opus 5
	'no' => 'ei', // by Claude Opus 5

	// Settings
	'Settings' => 'Seaded', // by Claude Opus 5
	'Default' => 'Vaikimisi', // by Claude Opus 5
	'Color scheme' => 'Värviskeem', // by Claude Opus 5
	'By system' => 'Süsteemi järgi', // by Claude Opus 5
	'Light' => 'Hele', // by Claude Opus 5
	'Dark' => 'Tume', // by Claude Opus 5
	'Navigation mode' => 'Navigeerimise režiim', // by Claude Opus 5
	'Simple' => 'Lihtne', // by Claude Opus 5
	'Dual' => 'Kahene', // by Claude Opus 5
	'Reversed' => 'Vastupidine', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Peamise navigeerimise paigutus tabelilinkidega.', // by Claude Opus 5
	'Table links' => 'Tabelilingid', // by Claude Opus 5
	'Primary action for all table links.' => 'Peamine tegevus kõikidele tabelilinkidele.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Lingid tabelitele, mis viitavad praegusele reale.', // by Claude Opus 5
	'Display' => 'Näita', // by Claude Opus 5
	'Hide' => 'Peida', // by Claude Opus 5
	'Records per page' => 'Kirjeid lehel', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Andmetabelis kuvatavate kirjete vaikimisi arv.', // by Claude Opus 5
	'Enum as select' => 'Enum valikuloendina', // by Claude Opus 5
	'Never' => 'Mitte kunagi', // by Claude Opus 5
	'Always' => 'Alati', // by Claude Opus 5
	'More values than %d' => 'Rohkem kui %d väärtust', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Lävi valikuloendi kuvamiseks enum-veergudel.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Ühekordne parool', // by Claude Opus 5
	'Enter OTP code.' => 'Sisesta OTP-kood.', // by Claude Opus 5
	'Invalid OTP code.' => 'Sobimatu OTP-kood.', // by Claude Opus 5
	'Access denied.' => 'Ligipääs keelatud.', // by Claude Opus 5
	'JSON previews' => 'JSON-i eelvaated', // by Claude Opus 5
	'Data table' => 'Andmetabel', // by Claude Opus 5
	'Edit form' => 'Muutmisvorm', // by Claude Opus 5
	'Ask %s' => 'Küsi %s käest', // by Claude Opus 5
];
