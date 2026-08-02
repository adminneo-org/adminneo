<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$6.$4.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'D.M.RRRR', // hint for date format - use language equivalents for day, month and year shortcuts

	// Bootstrap

	// Login
	'System' => 'Sistem',
	'Server' => 'Strežnik',
	'Username' => 'Uporabniško ime',
	'Password' => 'Geslo',
	'Permanent login' => 'Trajna prijava',
	'Login' => 'Prijavi se',
	'Logout' => 'Odjavi se',
	'Logged as: %s' => 'Prijavljen kot: %s',
	'Logout successful.' => 'Prijava uspešna.',
	'Invalid server or credentials.' => 'Neveljaven strežnik ali pravice.',
	'Invalid CSRF token. Send the form again.' => 'Neveljaven token CSRF. Pošljite formular še enkrat.',

	// Connection
	'No extension' => 'Brez dodatkov',
	'None of the supported PHP extensions (%s) are available.' => 'Noben od podprtih dodatkov za PHP (%s) ni na voljo.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'Podpora za seje mora biti omogočena.',
	'Session expired, please login again.' => 'Seja je potekla. Prosimo, ponovno se prijavite.',
	'%s version: %s through PHP extension %s' => 'Verzija %s: %s preko dodatka za PHP %s',

	// Settings
	'Language' => 'Jezik',

	'Refresh' => 'Osveži',

	// Privileges
	'Privileges' => 'Pravice',
	'Create user' => 'Ustvari uporabnika',
	'User has been dropped.' => 'Uporabnik je odstranjen.',
	'User has been altered.' => 'Uporabnik je spremenjen.',
	'User has been created.' => 'Uporabnik je ustvarjen.',
	'Hashed' => 'Zakodirano',

	// Server
	'Process list' => 'Seznam procesov',
	'%d process(es) have been killed.' => [
		'Končan je %d proces.',
		'Končana sta %d procesa.',
		'Končani so %d procesi.',
		'Končanih je %d procesov.',
	],
	'Kill' => 'Končaj',
	'Variables' => 'Spremenljivke',
	'Status' => 'Stanje',

	// Structure
	'Column' => 'Stolpec',
	'Routine' => 'Postopek',
	'Grant' => 'Dovoli',
	'Revoke' => 'Odvzemi',

	// Queries
	'SQL command' => 'Ukaz SQL',
	'%d query(s) executed OK.' => [
		'Uspešno se je končala %d poizvedba.',
		'Uspešno sta se končali %d poizvedbi.',
		'Uspešno so se končale %d poizvedbe.',
		'Uspešno se je končalo %d poizvedb.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Poizvedba se je uspešno izvedla, spremenjena je %d vrstica.',
		'Poizvedba se je uspešno izvedla, spremenjeni sta %d vrstici.',
		'Poizvedba se je uspešno izvedla, spremenjene so %d vrstice.',
		'Poizvedba se je uspešno izvedla, spremenjenih je %d vrstic.',
	],
	'No commands to execute.' => 'Ni ukazov za izvedbo.',
	'Error in query' => 'Napaka v poizvedbi',
	'Execute' => 'Izvedi',
	'Stop on error' => 'Ustavi ob napaki',
	'Show only errors' => 'Pokaži samo napake',
	'Time' => 'Čas',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Zgodovina',
	'Clear' => 'Počisti',

	// Import
	'Import' => 'Uvozi',
	'File upload' => 'Naloži datoteko',
	'From server' => 'z strežnika',
	'Webserver file %s' => 'Datoteka na spletnem strežniku %s',
	'Run file' => 'Zaženi datoteko',
	'File does not exist.' => 'Datoteka ne obstaja.',
	'File uploads are disabled.' => 'Nalaganje datotek je onemogočeno.',
	'Unable to upload a file.' => 'Ne morem naložiti datoteke.',
	'Maximum allowed file size is %sB.' => 'Največja velikost datoteke je %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Preveliko podatkov za POST. Zmanjšajte število podatkov ali povečajte nastavitev za %s.',
	'%d row(s) have been imported.' => [
		'Uvožena je %d vrstica.',
		'Uvoženi sta %d vrstici.',
		'Uvožene so %d vrstice.',
		'Uvoženih je %d vrstic.',
	],

	// Export
	'Export' => 'Izvozi',
	'Output' => 'Izhod rezultata',
	'open' => 'odpri',
	'save' => 'shrani',
	'Format' => 'Format',
	'Data' => 'Podatki',

	// Databases
	'Database' => 'Baza',
	'Use' => 'Uporabi',
	'Invalid database.' => 'Neveljavna baza.',
	'Alter database' => 'Spremeni bazo',
	'Create database' => 'Ustvari bazo',
	'Database schema' => 'Shema baze',
	'Database has been dropped.' => 'Baza je zavržena.',
	'Databases have been dropped.' => 'Baze so zavržene.',
	'Database has been created.' => 'Baza je ustvarjena.',
	'Database has been renamed.' => 'Baza je preimenovana.',
	'Database has been altered.' => 'Baza je spremenjena.',

	// SQLite errors
	'File exists.' => 'Datoteka obstaja.',
	'Please use one of the extensions %s.' => 'Prosim, uporabite enega od dodatkov %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Shema',
	'Alter schema' => 'Spremeni shemo',
	'Create schema' => 'Ustvari shemo',
	'Schema has been dropped.' => 'Shema je zavržena.',
	'Schema has been created.' => 'Shema je ustvarjena.',
	'Schema has been altered.' => 'Shema je spremenjena.',
	'Invalid schema.' => 'Neveljavna shema.',

	// Table list
	'Engine' => 'Pogon',
	'engine' => 'pogon',
	'Collation' => 'Zbiranje',
	'collation' => 'zbiranje',
	'Data Length' => 'Velikost podatkov',
	'Index Length' => 'Velikost indeksa',
	'Data Free' => 'Podatkov prosto ',
	'Rows' => 'Vrstic',
	'%d in total' => 'Skupaj %d',
	'Analyze' => 'Analiziraj',
	'Optimize' => 'Optimiziraj',
	'Check' => 'Preveri',
	'Repair' => 'Popravi',
	'Truncate' => 'Skrajšaj',
	'Tables have been truncated.' => 'Tabele so skrajšane.',
	'Move to other database' => 'Premakni v drugo bazo',
	'Move' => 'Premakni',
	'Tables have been moved.' => 'Tabele so premaknjene.',
	'Copy' => 'Kopiraj',
	'Tables have been copied.' => 'Tabele so kopirane.',

	// Tables
	'Tables' => 'Tabele',
	'Tables and views' => 'Tabele in pogledi',
	'Table' => 'Tabela',
	'No tables.' => 'Ni tabel.',
	'Alter table' => 'Spremeni tabelo',
	'Create table' => 'Ustvari tabelo',
	'Table has been dropped.' => 'Tabela je zavržena.',
	'Tables have been dropped.' => 'Tabele so zavržene.',
	'Table has been altered.' => 'Tabela je spremenjena.',
	'Table has been created.' => 'Tabela je ustvarjena.',
	'Table name' => 'Ime tabele',
	'Name' => 'Naziv',
	'Show structure' => 'Pokaži zgradbo',
	'Column name' => 'Ime stolpca',
	'Type' => 'Tip',
	'Length' => 'Dolžina',
	'Auto Increment' => 'Samodejno povečevanje',
	'Options' => 'Možnosti',
	'Comment' => 'Komentar',
	'Drop' => 'Zavrzi',
	'Are you sure?' => 'Ste prepričani?',
	'Move up' => 'Premakni gor',
	'Move down' => 'Premakni dol',
	'Remove' => 'Odstrani',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Največje število dovoljenih polje je preseženo. Prosimo, povečajte %s.',

	// Views
	'View' => 'Pogledi',
	'View has been dropped.' => 'Pogled je zavržen.',
	'View has been altered.' => 'Pogled je spremenjen.',
	'View has been created.' => 'Pogled je ustvarjen.',
	'Alter view' => 'Spremeni pogled',
	'Create view' => 'Ustvari pogled',

	// Partitions
	'Partition by' => 'Porazdeli po',
	'Partitions' => 'Porazdelitve',
	'Partition name' => 'Ime porazdelitve',
	'Values' => 'Vrednosti',

	// Indexes
	'Indexes' => 'Indeksi',
	'Indexes have been altered.' => 'Indeksi so spremenjeni.',
	'Alter indexes' => 'Spremeni indekse',
	'Add next' => 'Dodaj naslednjega',
	'Index Type' => 'Tip indeksa',
	'length' => 'dolžina',

	// Foreign keys
	'Foreign keys' => 'Tuji ključi',
	'Foreign key' => 'Tuj ključ',
	'Foreign key has been dropped.' => 'Tuj ključ je zavržen.',
	'Foreign key has been altered.' => 'Tuj ključ je spremenjen.',
	'Foreign key has been created.' => 'Tuj ključ je ustvarjen.',
	'Target table' => 'Ciljna tabela',
	'Change' => 'Spremeni',
	'Source' => 'Izvor',
	'Target' => 'Cilj',
	'Add column' => 'Dodaj stolpec',
	'Alter' => 'Spremeni',
	'Add foreign key' => 'Dodaj tuj ključ',
	'ON DELETE' => 'pri brisanju',
	'ON UPDATE' => 'pri posodabljanju',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Izvorni in ciljni stolpec mora imeti isti podatkovni tip. Obstajati mora indeks na ciljnih stolpcih in obstajati morajo referenčni podatki.',

	// Routines
	'Routines' => 'Postopki',
	'Routine has been called, %d row(s) affected.' => [
		'Klican je bil postopek, spremenjena je %d vrstica.',
		'Klican je bil postopek, spremenjeni sta %d vrstici.',
		'Klican je bil postopek, spremenjene so %d vrstice.',
		'Klican je bil postopek, spremenjenih je %d vrstic.',
	],
	'Call' => 'Pokliči',
	'Parameter name' => 'Ime parametra',
	'Create procedure' => 'Ustvari postopek',
	'Create function' => 'Ustvari funkcijo',
	'Routine has been dropped.' => 'Postopek je zavržen.',
	'Routine has been altered.' => 'Postopek je spremenjen.',
	'Routine has been created.' => 'Postopek je ustvarjen.',
	'Alter function' => 'Spremeni funkcijo',
	'Alter procedure' => 'Spremeni postopek',
	'Return type' => 'Vračalni tip',

	// Events
	'Events' => 'Dogodki',
	'Event' => 'Dogodek',
	'Event has been dropped.' => 'Dogodek je zavržen.',
	'Event has been altered.' => 'Dogodek je spremenjen.',
	'Event has been created.' => 'Dogodek je ustvarjen.',
	'Alter event' => 'Spremeni dogodek',
	'Create event' => 'Ustvari dogodek',
	'At given time' => 'v danem času',
	'Every' => 'vsake',
	'Schedule' => 'Urnik',
	'Start' => 'Začetek',
	'End' => 'Konec',
	'On completion preserve' => 'Po zaključku ohrani',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sekvence',
	'Create sequence' => 'Ustvari sekvenco',
	'Sequence has been dropped.' => 'Sekvenca je zavržena.',
	'Sequence has been created.' => 'Sekvence je ustvarjena.',
	'Sequence has been altered.' => 'Sekvence je spremenjena.',
	'Alter sequence' => 'Spremni sekvenco',

	// User types (PostgreSQL)
	'User types' => 'Uporabniški tipi',
	'Create type' => 'Ustvari tip',
	'Type has been dropped.' => 'Tip je zavržen.',
	'Type has been created.' => 'Tip je ustvarjen.',
	'Alter type' => 'Spremeni tip',

	// Triggers
	'Triggers' => 'Sprožilniki',
	'Add trigger' => 'Dodaj sprožilnik',
	'Trigger has been dropped.' => 'Sprožilnik je odstranjen.',
	'Trigger has been altered.' => 'Sprožilnik je spremenjen.',
	'Trigger has been created.' => 'Sprožilnik je ustvarjen.',
	'Alter trigger' => 'Spremeni sprožilnik',
	'Create trigger' => 'Ustvari sprožilnik',

	// Table check constraints

	// Selection
	'Select data' => 'Izberi podatke',
	'Select' => 'Izberi',
	'Functions' => 'Funkcije',
	'Aggregation' => 'Združitev',
	'Search' => 'Išči',
	'anywhere' => 'kjerkoli',
	'Sort' => 'Sortiraj',
	'descending' => 'padajoče',
	'Limit' => 'Limita',
	'Text length' => 'Dolžina teksta',
	'Action' => 'Dejanje',
	'Unable to select the table' => 'Ne morem izbrati tabele',
	'Search data in tables' => 'Išče podatke po tabelah',
	'No rows.' => 'Ni vrstic.',
	'%d row(s)' => [
		'%d vrstica',
		'%d vrstici',
		'%d vrstice',
		'%d vrstic',
	],
	'Page' => 'Stran',
	'last' => 'Zadnja',
	'Whole result' => 'Cel razultat',
	'%d byte(s)' => [
		'%d bajt',
		'%d bajta',
		'%d bajti',
		'%d bajtov',
	],

	// In-place editing in selection
	'Ctrl+click on a value to modify it.' => 'Ctrl+klik na vrednost za urejanje.',
	'Use edit link to modify this value.' => 'Uporabite urejanje povezave za spreminjanje te vrednosti.',

	// Editing
	'New item' => 'Nov predmet',
	'Edit' => 'Uredi',
	'original' => 'original',
	'empty' => 'prazno', // label for value '' in enum data type
	'Insert' => 'Vstavi',
	'Save' => 'Shrani',
	'Save and continue edit' => 'Shrani in nadaljuj z urejanjem',
	'Save and insert next' => 'Shrani in vstavi tekst',
	'Clone' => 'Kloniraj',
	'Delete' => 'Izbriši',
	'Item%s has been inserted.' => 'Predmet%s je vstavljen.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Predmet je izbrisan.',
	'Item has been updated.' => 'Predmet je posodobljen.',
	'%d item(s) have been affected.' => [
		'Spremenjen je %d predmet.',
		'Spremenjena sta %d predmeta.',
		'Spremenjeni so %d predmeti.',
		'Spremenjenih je %d predmetov.',
	],

	// Data type descriptions
	'Numbers' => 'Števila',
	'Date and time' => 'Datum in čas',
	'Strings' => 'Nizi',
	'Binary' => 'Binarni',
	'Lists' => 'Seznami',
	'Network' => 'Mrežni',
	'Geometry' => 'Geometrčni',
	'Relations' => 'Relacijski',

	// Editor - data values
	'now' => 'zdaj',

	// Settings

	// Plugins
];
