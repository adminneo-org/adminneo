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
	'Invalid CSRF token. Send the form again.' => 'Sobimatu CSRF, palun postitage vorm uuesti.',

	// Connection
	'No extension' => 'Ei leitud laiendust',
	'None of the supported PHP extensions (%s) are available.' => 'Serveris pole ühtegi toetatud PHP laiendustest (%s).', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'Sessioonid peavad olema lubatud.',
	'Session expired, please login again.' => 'Sessioon on aegunud, palun logige uuesti sisse.',
	'%s version: %s through PHP extension %s' => '%s versioon: %s, kasutatud PHP moodul: %s',

	// Settings
	'Language' => 'Keel',

	'Refresh' => 'Uuenda',

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
	'Routine' => 'Protseduur',
	'Grant' => 'Anna',
	'Revoke' => 'Eemalda',

	// Queries
	'SQL command' => 'SQL-Päring',
	'%d query(s) executed OK.' => [
		'%d päring edukalt käivitatud.',
		'%d päringut edukalt käivitatud.',
	],
	'Query executed OK, %d row(s) affected.' => 'Päring õnnestus, mõjutatatud ridu: %d.',
	'No commands to execute.' => 'Käsk puudub.',
	'Error in query' => 'Päringus esines viga',
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
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST-andmete maht on liialt suur. Palun vähendage andmeid või suurendage %s php-seadet.',
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
	'Check' => 'Kontrolli',
	'Repair' => 'Paranda',
	'Truncate' => 'Tühjenda',
	'Tables have been truncated.' => 'Validud tabelid on edukalt tühjendatud.',
	'Move to other database' => 'Liiguta teise andmebaasi',
	'Move' => 'Liiguta',
	'Tables have been moved.' => 'Valitud tabelid on edukalt liigutatud.',
	'Copy' => 'Kopeeri',
	'Tables have been copied.' => 'Tabelid on edukalt kopeeritud.',

	// Tables
	'Tables' => 'Tabelid',
	'Tables and views' => 'Tabelid ja vaated',
	'Table' => 'Tabel',
	'No tables.' => 'Tabeleid ei leitud.',
	'Alter table' => 'Muuda tabeli struktuuri',
	'Create table' => 'Loo uus tabel',
	'Table has been dropped.' => 'Tabel on edukalt kustutatud.',
	'Tables have been dropped.' => 'Valitud tabelid on edukalt kustutatud.',
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
	'Drop' => 'Kustuta',
	'Are you sure?' => 'Kas oled kindel?',
	'Move up' => 'Liiguta ülespoole',
	'Move down' => 'Liiguta allapoole',
	'Remove' => 'Eemalda',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Maksimaalne väljade arv ületatud. Palun suurendage %s.',

	// Views
	'View' => 'Vaata',
	'View has been dropped.' => 'Vaade (VIEW) on edukalt kustutatud.',
	'View has been altered.' => 'Vaade (VIEW) on edukalt muudetud.',
	'View has been created.' => 'Vaade (VIEW) on edukalt loodud.',
	'Alter view' => 'Muuda vaadet (VIEW)',
	'Create view' => 'Loo uus vaade (VIEW)',

	// Partitions
	'Partition by' => 'Partitsiooni',
	'Partitions' => 'Partitsioonid',
	'Partition name' => 'Partitsiooni nimi',
	'Values' => 'Väärtused',

	// Indexes
	'Indexes' => 'Indeksid',
	'Indexes have been altered.' => 'Indeksite andmed on edukalt uuendatud.',
	'Alter indexes' => 'Muuda indekseid',
	'Add next' => 'Lisa järgmine',
	'Index Type' => 'Indeksi tüüp',
	'length' => 'pikkus',

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
	'Text length' => 'Teksti pikkus',
	'Action' => 'Tegevus',
	'Unable to select the table' => 'Tabeli valimine ebaõnnestus',
	'Search data in tables' => 'Otsi kogu andmebaasist',
	'No rows.' => 'Sissekanded puuduvad.',
	'%d row(s)' => '%d rida',
	'Page' => 'Lehekülg',
	'last' => 'viimane',
	'Whole result' => 'Täielikud tulemused',
	'%d byte(s)' => [
		'%d bait',
		'%d baiti',
	],

	// In-place editing in selection
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
	'Clone' => 'Kloon',
	'Delete' => 'Kustuta',
	'Item%s has been inserted.' => 'Kirje%s on edukalt lisatud.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Kustutamine õnnestus.',
	'Item has been updated.' => 'Uuendamine õnnestus.',
	'%d item(s) have been affected.' => 'Mõjutatud kirjeid: %d.',

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

	// Settings

	// Plugins
];
