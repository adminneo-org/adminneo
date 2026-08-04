<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$6.$4.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'D.M.RRRR', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts // by Claude Fable 5

	// Bootstrap
	'%s must return an array.' => '%s mora vrniti polje.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s in %s morata vrniti objekt, ustvarjen z metodo %s.', // by Claude Opus 5

	// Login
	'System' => 'Sistem',
	'Server' => 'Strežnik',
	'Username' => 'Uporabniško ime',
	'Password' => 'Geslo',
	'Permanent login' => 'Trajna prijava',
	'Login' => 'Prijavi se',
	'Logout' => 'Odjavi se',
	'Logged as: %s' => 'Prijavljen kot: %s',
	'Logout successful.' => 'Odjava uspešna.', // by Claude Opus 5
	'hostname[:port] or :socket' => 'hostname[:port] ali :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Neveljaven strežnik ali pravice.',
	'There is a space in the input password which might be the cause.' => 'V vnesenem geslu je presledek, kar je lahko vzrok.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ne podpira dostopa do baze brez gesla, <a href="https://www.adminneo.org/password"%s>več informacij</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Baza ne podpira gesla.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Preveč neuspešnih prijav, poskusite znova čez %d minuto.',
		'Preveč neuspešnih prijav, poskusite znova čez %d minuti.',
		'Preveč neuspešnih prijav, poskusite znova čez %d minute.',
		'Preveč neuspešnih prijav, poskusite znova čez %d minut.',
	], // by Claude Fable 5
	'Invalid permanent login, please login again.' => 'Neveljavna trajna prijava. Prosimo, ponovno se prijavite.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Neveljaven token CSRF. Pošljite formular še enkrat.',
	'If you did not send this request from AdminNeo then close this page.' => 'Če te zahteve niste poslali iz AdminNea, zaprite to stran.', // by Claude Opus 5
	'The action will be performed after successful login with the same credentials.' => 'Dejanje bo izvedeno po uspešni prijavi z istimi poverilnicami.', // by Claude Fable 5

	// Connection
	'No driver' => 'Brez gonilnika', // by Claude Opus 5
	'Database driver not found.' => 'Gonilnika za bazo ni bilo mogoče najti.', // by Claude Opus 5
	'No extension' => 'Brez dodatkov',
	'None of the supported PHP extensions (%s) are available.' => 'Noben od podprtih dodatkov za PHP (%s) ni na voljo.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Povezovanje na privilegirana vrata ni dovoljeno.', // by Claude Fable 5
	'Session support must be enabled.' => 'Podpora za seje mora biti omogočena.',
	'Session expired, please login again.' => 'Seja je potekla. Prosimo, ponovno se prijavite.',
	'%s version: %s through PHP extension %s' => 'Verzija %s: %s preko dodatka za PHP %s',

	// Settings
	'Language' => 'Jezik',

	'Home' => 'Domov', // by Claude Opus 5
	'Refresh' => 'Osveži',
	'Info' => 'Info', // by Claude Opus 5
	'More information.' => 'Več informacij.', // by Claude Opus 5

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
	'Columns' => 'Stolpci', // by Claude Fable 5
	'Routine' => 'Postopek',
	'Grant' => 'Dovoli',
	'Revoke' => 'Odvzemi',

	// Queries
	'SQL command' => 'Ukaz SQL',
	'HTTP request' => 'Zahteva HTTP', // by Claude Opus 5
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
	'Unknown error.' => 'Neznana napaka.', // by Claude Fable 5
	'Warnings' => 'Opozorila', // by Claude Fable 5
	'%s queries are not supported.' => 'Poizvedbe %s niso podprte.', // by Claude Fable 5
	'Execute' => 'Izvedi',
	'Stop on error' => 'Ustavi ob napaki',
	'Show only errors' => 'Pokaži samo napake',
	'Time' => 'Čas',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Zgodovina',
	'Clear' => 'Počisti',
	'Edit all' => 'Uredi vse', // by Claude Fable 5

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
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Največje število datotek je %d. Izberite manj datotek ali povečajte nastavitev za %s.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Največja skupna velikost datotek je %s. Izberite manjše datoteke ali povečajte nastavitev za %s.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Preveliko podatkov za POST. Zmanjšajte število podatkov ali povečajte nastavitev za %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Veliko datoteko SQL lahko naložite prek FTP-ja in jo uvozite s strežnika.', // by Claude Fable 5
	'File must be in UTF-8 encoding.' => 'Datoteka mora biti v kodiranju UTF-8.', // by Claude Fable 5
	'You are offline.' => 'Ste brez povezave.', // by Claude Fable 5
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
	'database' => 'baza', // by Claude Opus 5
	'DB' => 'DB', // by Claude Fable 5
	'Use' => 'Uporabi',
	'Invalid database.' => 'Neveljavna baza.',
	'Alter database' => 'Spremeni bazo',
	'Create database' => 'Ustvari bazo',
	'Database schema' => 'Shema baze',
	'Permanent link' => 'Trajna povezava', // by Claude Fable 5
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
	'schema' => 'shema', // by Claude Opus 5
	'Schemas' => 'Sheme', // by Claude Opus 5
	'No schemas.' => 'Ni shem.', // by Claude Opus 5
	'Show schema' => 'Pokaži shemo', // by Claude Opus 5
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
	'Vacuum' => 'Počisti', // by Claude Fable 5
	'Check' => 'Preveri',
	'Repair' => 'Popravi',
	'Truncate' => 'Skrajšaj',
	'Tables have been truncated.' => 'Tabele so skrajšane.',
	'Move to other database' => 'Premakni v drugo bazo',
	'Move' => 'Premakni',
	'Tables have been moved.' => 'Tabele so premaknjene.',
	'Copy' => 'Kopiraj',
	'Tables have been copied.' => 'Tabele so kopirane.',
	'overwrite' => 'prepiši', // by Claude Fable 5

	// Tables
	'Tables' => 'Tabele',
	'Tables and views' => 'Tabele in pogledi',
	'Table' => 'Tabela',
	'No tables.' => 'Ni tabel.',
	'Alter table' => 'Spremeni tabelo',
	'Create table' => 'Ustvari tabelo',
	'Table has been dropped.' => 'Tabela je zavržena.',
	'Tables have been dropped.' => 'Tabele so zavržene.',
	'Tables have been optimized.' => 'Tabele so optimizirane.', // by Claude Fable 5
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
	'Default value' => 'Privzeta vrednost', // by Claude Fable 5
	'Drop' => 'Zavrzi',
	'Drop %s?' => 'Ali želite zavreči %s?', // by Claude Fable 5
	'Are you sure?' => 'Ste prepričani?',
	'Size' => 'Velikost', // by Claude Fable 5
	'Compute' => 'Izračunaj', // by Claude Fable 5
	'Move up' => 'Premakni gor',
	'Move down' => 'Premakni dol',
	'Remove' => 'Odstrani',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Največje število dovoljenih polje je preseženo. Prosimo, povečajte %s.',

	// Views
	'View' => 'Pogled', // by Claude Opus 5
	'Materialized view' => 'Materializirani pogled', // by Claude Fable 5
	'View has been dropped.' => 'Pogled je zavržen.',
	'View has been altered.' => 'Pogled je spremenjen.',
	'View has been created.' => 'Pogled je ustvarjen.',
	'Alter view' => 'Spremeni pogled',
	'Create view' => 'Ustvari pogled',

	// Partitions
	'Partition by' => 'Porazdeli po',
	'Partition' => 'Porazdelitev', // by Claude Opus 5
	'Partitions' => 'Porazdelitve',
	'Partition name' => 'Ime porazdelitve',
	'Values' => 'Vrednosti',
	'Inherited tables' => 'Podedovane tabele', // by Claude Opus 5
	'Inherited from' => 'Podedovana od', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Indeksi',
	'Indexes have been altered.' => 'Indeksi so spremenjeni.',
	'Alter indexes' => 'Spremeni indekse',
	'Add next' => 'Dodaj naslednjega',
	'Index Type' => 'Tip indeksa',
	'length' => 'dolžina',
	'Algorithm' => 'Algoritem', // by Claude Fable 5
	'Condition' => 'Pogoj', // by Claude Fable 5

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
	'Checks' => 'Preverjanja', // by Claude Fable 5
	'Create check' => 'Ustvari preverjanje', // by Claude Fable 5
	'Alter check' => 'Spremeni preverjanje', // by Claude Fable 5
	'Check has been created.' => 'Preverjanje je ustvarjeno.', // by Claude Fable 5
	'Check has been altered.' => 'Preverjanje je spremenjeno.', // by Claude Fable 5
	'Check has been dropped.' => 'Preverjanje je zavrženo.', // by Claude Fable 5

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
	'Limit rows' => 'Omeji vrstice', // by Claude Fable 5
	'Text length' => 'Dolžina teksta',
	'Action' => 'Dejanje',
	'Full table scan' => 'Pregled celotne tabele', // by Claude Fable 5
	'Unable to select the table' => 'Ne morem izbrati tabele',
	'Search data in tables' => 'Išče podatke po tabelah',
	'No rows.' => 'Ni vrstic.',
	'%d / ' => '%d / ', // by Claude Fable 5
	'%d row(s)' => [
		'%d vrstica',
		'%d vrstici',
		'%d vrstice',
		'%d vrstic',
	],
	'Page' => 'Stran',
	'last' => 'Zadnja',
	'Load more data' => 'Naloži več podatkov', // by Claude Fable 5
	'Loading' => 'Nalaganje', // by Claude Fable 5
	'Whole result' => 'Cel rezultat', // by Claude Opus 5
	'%d byte(s)' => [
		'%d bajt',
		'%d bajta',
		'%d bajti',
		'%d bajtov',
	],

	// In-place editing in selection
	'Modify' => 'Spremeni', // by Claude Fable 5
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
	'Saving' => 'Shranjevanje', // by Claude Fable 5
	'Selected' => 'Izbrano', // by Claude Fable 5
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
	'You have no privileges to update this table.' => 'Nimate pravic za posodabljanje te tabele.', // by Claude Fable 5

	// Data type descriptions
	'Numbers' => 'Števila',
	'Date and time' => 'Datum in čas',
	'Strings' => 'Nizi',
	'Binary' => 'Binarni',
	'Lists' => 'Seznami',
	'Network' => 'Mrežni',
	'Geometry' => 'Geometrijski', // by Claude Opus 5
	'Relations' => 'Relacijski',

	// Editor - data values
	'now' => 'zdaj',
	'yes' => 'da', // by Claude Fable 5
	'no' => 'ne', // by Claude Fable 5

	// Settings
	'Settings' => 'Nastavitve', // by Claude Opus 5
	'Default' => 'Privzeto', // by Claude Opus 5
	'Color scheme' => 'Barvna shema', // by Claude Opus 5
	'By system' => 'Po sistemu', // by Claude Opus 5
	'Light' => 'Svetla', // by Claude Opus 5
	'Dark' => 'Temna', // by Claude Opus 5
	'Navigation mode' => 'Način krmarjenja', // by Claude Opus 5
	'Simple' => 'Enostavno', // by Claude Opus 5
	'Dual' => 'Dvojno', // by Claude Opus 5
	'Reversed' => 'Obrnjeno', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Razporeditev glavnega krmarjenja s povezavami tabel.', // by Claude Opus 5
	'Table links' => 'Povezave tabel', // by Claude Opus 5
	'Primary action for all table links.' => 'Osnovno dejanje za vse povezave tabel.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Povezave na tabele, ki se sklicujejo na trenutno vrstico.', // by Claude Opus 5
	'Display' => 'Prikaži', // by Claude Opus 5
	'Hide' => 'Skrij', // by Claude Opus 5
	'Records per page' => 'Zapisov na stran', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Privzeto število zapisov, prikazanih v tabeli podatkov.', // by Claude Opus 5
	'Enum as select' => 'Enum kot izbirni seznam', // by Claude Opus 5
	'Never' => 'Nikoli', // by Claude Opus 5
	'Always' => 'Vedno', // by Claude Opus 5
	'More values than %d' => 'Več kot %d vrednosti', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Meja za prikaz izbirnega seznama pri poljih enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Enkratno geslo', // by Claude Opus 5
	'Enter OTP code.' => 'Vnesite kodo OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'Neveljavna koda OTP.', // by Claude Opus 5
	'Access denied.' => 'Dostop zavrnjen.', // by Claude Opus 5
	'JSON previews' => 'Predogledi JSON', // by Claude Opus 5
	'Data table' => 'Tabela podatkov', // by Claude Opus 5
	'Edit form' => 'Obrazec za urejanje', // by Claude Opus 5
	'Ask %s' => null,
];
