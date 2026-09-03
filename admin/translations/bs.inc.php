<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5.$3.$1.', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD.MM.YYYY.', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s mora vratiti niz.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s i %s moraju vratiti objekat kreiran metodom %s.', // by Claude Fable 5.1

	// Login
	'System' => 'Sistem',
	'Server' => 'Server',
	'Username' => 'Korisničko ime',
	'Password' => 'Lozinka',
	'Permanent login' => 'Trajna prijava',
	'Login' => 'Prijava',
	'Logout' => 'Odjava',
	'Logged as: %s' => 'Prijavi se kao: %s',
	'Logout successful.' => 'Uspešna odjava.',
	'hostname[:port] or :socket' => 'hostname[:port] ili :socket', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'Neispravan server ili podaci za prijavu.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'U unesenoj lozinci postoji razmak, što bi mogao biti uzrok.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ne podržava pristup bazi podataka bez lozinke, <a href="https://www.adminneo.org/password"%s>više informacija</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'Baza podataka ne podržava lozinku.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Previše neuspješnih prijava, pokušajte ponovo za %d minutu.',
		'Previše neuspješnih prijava, pokušajte ponovo za %d minute.',
		'Previše neuspješnih prijava, pokušajte ponovo za %d minuta.',
	], // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => 'Neispravna trajna prijava, prijavite se ponovo.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'Nevažeći CSRF kod. Proslijedite ponovo formu.',
	'If you did not send this request from AdminNeo then close this page.' => 'Ako ovaj zahtjev niste poslali iz AdminNea, zatvorite ovu stranicu.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'Radnja će biti izvršena nakon uspješne prijave s istim podacima.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'Bez dodataka',
	'None of the supported PHP extensions (%s) are available.' => 'Nijedan od podržanih PHP dodataka (%s) nije dostupan.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Povezivanje na privilegirane portove nije dozvoljeno.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'Morate omogućiti podršku za sesije.',
	'Session expired, please login again.' => 'Vaša sesija je istekla, prijavite se ponovo.',
	'%s version: %s through PHP extension %s' => '%s verzija: %s pomoću PHP dodatka je %s',

	// Settings
	'Language' => 'Jezik',

	'Menu' => 'Meni', // by Claude Fable 5.1
	'Home' => 'Početna', // by Claude Fable 5.1
	'Refresh' => 'Osveži',
	'Info' => 'Informacije', // by Claude Fable 5.1
	'More information.' => 'Više informacija.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'Dozvole',
	'Create user' => 'Novi korisnik',
	'User has been dropped.' => 'Korisnik je izbrisan.',
	'User has been altered.' => 'Korisnik je izmijenjen.',
	'User has been created.' => 'korisnik je spašen.',
	'Hashed' => 'Heširano',

	// Server
	'Process list' => 'Spisak procesa',
	'%d process(es) have been killed.' => [
		'%d proces je ukinut.',
		'%d procesa su ukinuta.',
		'%d procesa je ukinuto.',
	],
	'Kill' => 'Ubij',
	'Variables' => 'Promijenljive',
	'Status' => 'Status',

	// Structure
	'Column' => 'kolumna',
	'Columns' => 'Kolumne', // by Claude Fable 5.1
	'Routine' => 'Rutina',
	'Grant' => 'Dozvoli',
	'Revoke' => 'Opozovi',

	// Queries
	'SQL command' => 'SQL komanda',
	'HTTP request' => 'HTTP zahtjev', // by Claude Fable 5.1
	'%d query(s) executed OK.' => [
		'%d upit je uspiješno izvršen.',
		'%d upita su uspiješno izvršena.',
		'%d upita je uspiješno izvršeno.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Upit je uspiješno izvršen, %d red je ažuriran.',
		'Upit je uspiješno izvršen, %d reda su ažurirana.',
		'Upit je uspiješno izvršen, %d redova je ažurirano.',
	],
	'No commands to execute.' => 'Bez komandi za izvršavanje.',
	'Error in query' => 'Greška u upitu',
	'Unknown error.' => 'Nepoznata greška.', // by Claude Fable 5.1
	'Warnings' => 'Upozorenja', // by Claude Fable 5.1
	'%s queries are not supported.' => '%s upiti nisu podržani.', // by Claude Fable 5.1
	'Execute' => 'Izvrši',
	'Stop on error' => 'Zaustavi prilikom greške',
	'Show only errors' => 'Prikazuj samo greške',
	'Time' => 'Vrijeme',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Historijat',
	'Clear' => 'Očisti',
	'Edit all' => 'Izmijeni sve',

	// Import
	'Import' => 'Uvoz',
	'File upload' => 'Slanje datoteka',
	'From server' => 'Sa servera',
	'Webserver file %s' => 'Datoteka %s sa veb servera',
	'Run file' => 'Pokreni datoteku',
	'File does not exist.' => 'Datoteka ne postoji.',
	'File uploads are disabled.' => 'Onemogućeno je slanje datoteka.',
	'Unable to upload a file.' => 'Slanje datoteke nije uspelo.',
	'Maximum allowed file size is %sB.' => 'Najveća dozvoljena veličina datoteke je %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Najveći broj datoteka je %d. Izaberite manje datoteka ili povećajte vrijednost konfiguracione direktive %s.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Najveća ukupna veličina datoteka je %s. Izaberite manje datoteke ili povećajte vrijednost konfiguracione direktive %s.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Preveliki POST podatak. Morate da smanjite podatak ili povećajte vrijednost konfiguracione direktive %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Veliku SQL datoteku možete poslati putem FTP-a i uvesti je sa servera.', // by Claude Fable 5.1
	'File must be in UTF-8 encoding.' => 'Datoteka mora biti u UTF-8 kodiranju.', // by Claude Fable 5.1
	'You are offline.' => 'Van mreže ste.', // by Claude Fable 5.1
	'%d row(s) have been imported.' => [
		'%d red je uvežen.',
		'%d reda su uvežena.',
		'%d redova je uveženo.',
	],

	// Export
	'Export' => 'Izvoz',
	'Output' => 'Ispis',
	'open' => 'otvori',
	'save' => 'spasi',
	'Format' => 'Format',
	'Data' => 'Podaci',

	// Databases
	'Database' => 'Baza podataka',
	'database' => 'baza podataka', // by Claude Fable 5.1
	'DB' => 'DB', // by Claude Fable 5.1
	'Use' => 'Koristi',
	'Invalid database.' => 'Neispravna baza podataka.',
	'Alter database' => 'Ažuriraj bazu podataka',
	'Create database' => 'Formiraj bazu podataka',
	'Database schema' => 'Šema baze podataka',
	'Permanent link' => 'Trajna veza',
	'Database has been dropped.' => 'Baza podataka je izbrisana.',
	'Databases have been dropped.' => 'Baze podataka su izbrisane.',
	'Database has been created.' => 'Baza podataka je spašena.',
	'Database has been renamed.' => 'Baza podataka je preimenovana.',
	'Database has been altered.' => 'Baza podataka je izmijenjena.',

	// SQLite errors
	'File exists.' => 'Datoteka već postoji.',
	'Please use one of the extensions %s.' => 'Molim koristite jedan od nastavaka %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Šema',
	'schema' => 'šema', // by Claude Fable 5.1
	'Schemas' => 'Šeme', // by Claude Fable 5.1
	'No schemas.' => 'Bez šema.', // by Claude Fable 5.1
	'Show schema' => 'Prikaži šemu', // by Claude Fable 5.1
	'Alter schema' => 'Ažuriraj šemu',
	'Create schema' => 'Formiraj šemu',
	'Schema has been dropped.' => 'Šema je izbrisana.',
	'Schema has been created.' => 'Šema je spašena.',
	'Schema has been altered.' => 'Šema je izmijenjena.',
	'Invalid schema.' => 'Šema nije ispravna.',

	// Table list
	'Engine' => 'Stroj',
	'engine' => 'stroj',
	'Collation' => 'Sravnjivanje',
	'collation' => 'Sravnjivanje',
	'Data Length' => 'Dužina podataka',
	'Index Length' => 'Dužina indeksa',
	'Data Free' => 'Slobodno podataka',
	'Rows' => 'Redova',
	'%d in total' => 'ukupno %d',
	'Analyze' => 'Analiziraj',
	'Optimize' => 'Optimizuj',
	'Vacuum' => 'Očisti', // by Claude Fable 5.1
	'Check' => 'Provjeri',
	'Repair' => 'Popravi',
	'Truncate' => 'Isprazni',
	'Truncate Cascade' => 'Isprazni kaskadno', // by Claude Fable 5.1
	'Tables have been truncated.' => 'Tabele su ispražnjene.',
	'Move to other database' => 'Premijesti u drugu bazu podataka',
	'Move' => 'Premijesti',
	'Tables have been moved.' => 'Tabele su premješćene.',
	'Copy' => 'Umnoži',
	'Tables have been copied.' => 'Tabele su umnožene.',
	'overwrite' => 'prepiši', // by Claude Fable 5.1

	// Tables
	'Tables' => 'Tabele',
	'Tables and views' => 'Tabele i pogledi',
	'Table' => 'Tabela',
	'No tables.' => 'Bez tabela.',
	'Alter table' => 'Ažuriraj tabelu',
	'Create table' => 'Napravi tabelu',
	'Table has been dropped.' => 'Tabela je izbrisana.',
	'Tables have been dropped.' => 'Tabele su izbrisane.',
	'Tables have been optimized.' => 'Tabele su optimizovane.',
	'Table has been altered.' => 'Tabela je izmijenjena.',
	'Table has been created.' => 'Tabela je spašena.',
	'Table name' => 'Naziv tabele',
	'Name' => 'Ime',
	'Show structure' => 'Prikaži strukturu',
	'Column name' => 'Naziv kolumne',
	'Type' => 'Tip',
	'Length' => 'Dužina',
	'Auto Increment' => 'Auto-priraštaj',
	'Options' => 'Opcije',
	'Comment' => 'Komentar',
	'Default value' => 'Podrazumijevana vrijednost', // by Claude Fable 5.1
	'Drop' => 'Izbriši',
	'Drop %s?' => 'Izbrisati %s?', // by Claude Fable 5.1
	'Are you sure?' => 'Da li ste sigurni?',
	'Size' => 'Veličina', // by Claude Fable 5.1
	'Compute' => 'Izračunaj', // by Claude Fable 5.1
	'Move up' => 'Pomijeri na gore',
	'Move down' => 'Pomijeri na dole',
	'Remove' => 'Ukloni',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Premašen je maksimalni broj dozvoljenih polja. Molim uvećajte %s.',

	// Views
	'View' => 'Pogled',
	'Materialized view' => 'Materijalizirani pogled', // by Claude Fable 5.1
	'View has been dropped.' => 'Pogled je izbrisan.',
	'View has been altered.' => 'Pogled je izmijenjen.',
	'View has been created.' => 'Pogled je spašen.',
	'Alter view' => 'Ažuriraj pogled',
	'Create view' => 'Napravi pogled',

	// Partitions
	'Partition by' => 'Podijeli po',
	'Partition' => 'Podjela', // by Claude Fable 5.1
	'Partitions' => 'Podjele', // by Claude Fable 5.1
	'Partition name' => 'Ime podjele', // by Claude Fable 5.1
	'Values' => 'Vrijednosti',
	'Inherited tables' => 'Naslijeđene tabele', // by Claude Fable 5.1
	'Inherited from' => 'Naslijeđena od', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'Indeksi',
	'Indexes have been altered.' => 'Indeksi su izmijenjeni.',
	'Alter indexes' => 'Ažuriraj indekse',
	'Add next' => 'Dodaj slijedeći',
	'Index Type' => 'Tip indeksa',
	'length' => 'dužina',
	'operator class' => 'klasa operatora', // by Claude Fable 5.1
	'Algorithm' => 'Algoritam', // by Claude Fable 5.1
	'Condition' => 'Uslov', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'Strani ključevi',
	'Foreign key' => 'Strani ključ',
	'Foreign key has been dropped.' => 'Strani ključ je izbrisan.',
	'Foreign key has been altered.' => 'Strani ključ je izmijenjen.',
	'Foreign key has been created.' => 'Strani ključ je spašen.',
	'Target table' => 'Ciljna tabela',
	'Change' => 'izmijeni',
	'Source' => 'Izvor',
	'Target' => 'Cilj',
	'Add column' => 'Dodaj kolumnu',
	'Alter' => 'Ažuriraj',
	'Add foreign key' => 'Dodaj strani ključ',
	'ON DELETE' => 'ON DELETE (prilikom brisanja)',
	'ON UPDATE' => 'ON UPDATE (prilikom osvežavanja)',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Izvorne i ciljne kolumne moraju biti istog tipa, ciljna kolumna mora biti indeksirana i izvorna tabela mora sadržati podatke iz ciljne.',

	// Routines
	'Routines' => 'Rutine',
	'Routine has been called, %d row(s) affected.' => [
		'Pozvana je rutina, %d red je ažuriran.',
		'Pozvana je rutina, %d reda su ažurirani.',
		'Pozvana je rutina, %d redova je ažurirano.',
	],
	'Call' => 'Pozovi',
	'Parameter name' => 'Naziv parametra',
	'Create procedure' => 'Formiraj proceduru',
	'Create function' => 'Formiraj funkciju',
	'Routine has been dropped.' => 'Rutina je izbrisana.',
	'Routine has been altered.' => 'Rutina je izmijenjena.',
	'Routine has been created.' => 'Rutina je spašena.',
	'Alter function' => 'Ažuriraj funkciju',
	'Alter procedure' => 'Ažuriraj proceduru',
	'Return type' => 'Povratni tip',

	// Events
	'Events' => 'Događaji',
	'Event' => 'Događaj',
	'Event has been dropped.' => 'Događaj je izbrisan.',
	'Event has been altered.' => 'Događaj je izmijenjen.',
	'Event has been created.' => 'Događaj je spašen.',
	'Alter event' => 'Ažuriraj događaj',
	'Create event' => 'Napravi događaj',
	'At given time' => 'U zadato vrijeme',
	'Every' => 'Svaki',
	'Schedule' => 'Raspored',
	'Start' => 'Početak',
	'End' => 'Kraj',
	'On completion preserve' => 'Zadrži po završetku',

	// Sequences (PostgreSQL)
	'Sequences' => 'Nizovi',
	'Create sequence' => 'Napravi niz',
	'Sequence has been dropped.' => 'Niz je izbrisan.',
	'Sequence has been created.' => 'Niz je formiran.',
	'Sequence has been altered.' => 'Niz je izmijenjen.',
	'Alter sequence' => 'Ažuriraj niz',

	// User-defined types (PostgreSQL)
	'User types' => 'Korisnički tipovi',
	'Create type' => 'Definiši tip',
	'Type has been dropped.' => 'Tip je izbrisan.',
	'Type has been created.' => 'tip je spašen.',
	'Alter type' => 'Ažuriraj tip',

	// Triggers
	'Triggers' => 'Okidači',
	'Add trigger' => 'Dodaj okidač',
	'Trigger has been dropped.' => 'Okidač je izbrisan.',
	'Trigger has been altered.' => 'Okidač je izmijenjen.',
	'Trigger has been created.' => 'Okidač je spašen.',
	'Alter trigger' => 'Ažuriraj okidač',
	'Create trigger' => 'Formiraj okidač',

	// Table check constraints
	'Checks' => 'Provjere', // by Claude Fable 5.1
	'Create check' => 'Napravi provjeru', // by Claude Fable 5.1
	'Alter check' => 'Izmijeni provjeru', // by Claude Fable 5.1
	'Check has been created.' => 'Provjera je napravljena.', // by Claude Fable 5.1
	'Check has been altered.' => 'Provjera je izmijenjena.', // by Claude Fable 5.1
	'Check has been dropped.' => 'Provjera je izbrisana.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'Izaberi podatke',
	'Select' => 'Izaberi',
	'Functions' => 'Funkcije',
	'Aggregation' => 'Sakupljanje',
	'Search' => 'Pretraga',
	'anywhere' => 'bilo gdje',
	'Sort' => 'Poređaj',
	'descending' => 'opadajuće',
	'Limit' => 'Granica',
	'Limit rows' => 'Ograniči broj redova', // by Claude Fable 5.1
	'Text length' => 'Dužina teksta',
	'Action' => 'Akcija',
	'Full table scan' => 'Skreniranje kompletne tabele',
	'Unable to select the table' => 'Ne mogu da izaberem tabelu',
	'Search data in tables' => 'Pretraži podatke u tabelama',
	'No rows.' => 'Bez redova.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => [
		'%d red',
		'%d reda',
		'%d redova',
	],
	'Page' => 'Strana',
	'last' => 'poslijednja',
	'Load more data' => 'Učitavam još podataka',
	'Loading' => 'Učitavam',
	'Whole result' => 'Ceo rezultat',
	'%d byte(s)' => [
		'%d bajt',
		'%d bajta',
		'%d bajtova',
	],

	// In-place editing in selection
	'Modify' => 'Izmjene',
	'Ctrl+click on a value to modify it.' => 'Ctrl+klik na vrijednost za izmijenu.',
	'Use edit link to modify this value.' => 'Koristi vezu za izmijenu ove vrijednosti.',

	// Editing
	'New item' => 'Nova stavka',
	'Edit' => 'Izmijeni',
	'original' => 'original',
	'empty' => 'prazno', // label for value '' in enum data type
	'Insert' => 'Umetni',
	'Save' => 'Sačuvaj',
	'Save and continue edit' => 'Sačuvaj i nastavi uređenje',
	'Save and insert next' => 'Sačuvaj i umijetni slijedeće',
	'Saving' => 'Čuvam', // by Claude Fable 5.1
	'Selected' => 'Izabrano',
	'Clone' => 'Dupliraj',
	'Delete' => 'Izbriši',
	'Item%s has been inserted.' => 'Stavka %s je spašena.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Stavka je izbrisana.',
	'Item has been updated.' => 'Stavka je izmijenjena.',
	'%d item(s) have been affected.' => [
		'%d stavka je ažurirana.',
		'%d stavke su ažurirane.',
		'%d stavki je ažurirano.',
	],
	'You have no privileges to update this table.' => 'Nemate privilegije za ažuriranje ove tabele.', // by Claude Fable 5.1

	// Data type descriptions
	'Numbers' => 'Broj',
	'Date and time' => 'Datum i vrijeme',
	'Strings' => 'Tekst',
	'Binary' => 'Binarno',
	'Lists' => 'Liste',
	'Network' => 'Mreža',
	'Geometry' => 'Geometrija',
	'Relations' => 'Odnosi',

	// Editor - data values
	'now' => 'sad',
	'yes' => 'da',
	'no' => 'ne',

	// Settings
	'Settings' => 'Podešavanja', // by Claude Fable 5.1
	'Default' => 'Podrazumijevano', // by Claude Fable 5.1
	'Color scheme' => 'Šema boja', // by Claude Fable 5.1
	'By system' => 'Prema sistemu', // by Claude Fable 5.1
	'Light' => 'Svijetla', // by Claude Fable 5.1
	'Dark' => 'Tamna', // by Claude Fable 5.1
	'Navigation mode' => 'Način navigacije', // by Claude Fable 5.1
	'Simple' => 'Jednostavan', // by Claude Fable 5.1
	'Dual' => 'Dvostruk', // by Claude Fable 5.1
	'Dual on hover' => 'Dvostruk pri prelasku mišem', // by Claude Fable 5.1
	'Reversed' => 'Obrnut', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'Raspored glavne navigacije sa vezama tabela.', // by Claude Fable 5.1
	'Table links' => 'Veze tabela', // by Claude Fable 5.1
	'Primary action for all table links.' => 'Osnovna akcija za sve veze tabela.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'Veze ka tabelama koje upućuju na trenutni red.', // by Claude Fable 5.1
	'Display' => 'Prikaži', // by Claude Fable 5.1
	'Hide' => 'Sakrij', // by Claude Fable 5.1
	'Records per page' => 'Zapisa po strani', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'Podrazumijevani broj zapisa prikazanih u tabeli podataka.', // by Claude Fable 5.1
	'Enum as select' => 'Enum kao spisak', // by Claude Fable 5.1
	'Never' => 'Nikada', // by Claude Fable 5.1
	'Always' => 'Uvijek', // by Claude Fable 5.1
	'More values than %d' => 'Više od %d vrijednosti', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'Prag za prikaz spiska izbora za enum kolumne.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'Jednokratna lozinka', // by Claude Fable 5.1
	'Enter OTP code.' => 'Unesite OTP kod.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'Neispravan OTP kod.', // by Claude Fable 5.1
	'Access denied.' => 'Pristup odbijen.', // by Claude Fable 5.1
	'JSON previews' => 'Pregled JSON-a', // by Claude Fable 5.1
	'Data table' => 'Tabela podataka', // by Claude Fable 5.1
	'Edit form' => 'Forma za izmjenu', // by Claude Fable 5.1
	'Ask %s' => 'Pitaj %s', // by Claude Fable 5.1
];
