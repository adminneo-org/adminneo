<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => '.',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5.$3.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'Sustav',
	'Server' => 'Poslužitelj',
	'Username' => 'Korisničko ime',
	'Password' => 'Lozinka',
	'Permanent login' => 'Trajna prijava',
	'Login' => 'Prijava',
	'Logout' => 'Odjava',
	'Logged as: %s' => 'Prijavljen kao: %s',
	'Logout successful.' => 'Uspješna odjava.',
	'hostname[:port] or :socket' => 'hostname[:port] ili :socket',
	'There is a space in the input password which might be the cause.' => 'U unesenoj lozinci postoji razmak koji bi mogao biti uzrok problema.',
	'Database does not support password.' => 'Baza podataka ne podržava lozinku.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Previše neuspješnih pokušaja prijave, pokušajte ponovo za %d minutu.',
		'Previše neuspješnih pokušaja prijave, pokušajte ponovo za %d minute.',
		'Previše neuspješnih pokušaja prijave, pokušajte ponovo za %d minuta.',
	],
	'Invalid CSRF token. Send the form again.' => 'Nevažeći CSRF token. Pošaljite obrazac ponovo.',
	'The action will be performed after successful login with the same credentials.' => 'Radnja će biti izvršena nakon uspješne prijave s istim podacima.',

	// Connection.
	'No extension' => 'Nema proširenja',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Nijedno od podržanih PHP proširenja (%s) nije dostupno.',
	'Connecting to privileged ports is not allowed.' => 'Spajanje na privilegirane portove nije dopušteno.',
	'Session support must be enabled.' => 'Podrška za sesije mora biti uključena.',
	'Session expired, please login again.' => 'Sesija je istekla, molimo prijavite se ponovo.',
	'%s version: %s through PHP extension %s' => '%s verzija: %s putem PHP proširenja %s',

	// Settings.
	'Language' => 'Jezik',

	'Refresh' => 'Osvježi',

	// Privileges.
	'Privileges' => 'Ovlasti',
	'Create user' => 'Novi korisnik',
	'User has been dropped.' => 'Korisnik je izbrisan.',
	'User has been altered.' => 'Korisnik je izmijenjen.',
	'User has been created.' => 'Korisnik je kreiran.',
	'Hashed' => 'Hashirano',

	// Server.
	'Process list' => 'Popis procesa',
	'%d process(es) have been killed.' => [
		'%d proces je zaustavljen.',
		'%d procesa su zaustavljena.',
		'%d procesa je zaustavljeno.',
	],
	'Kill' => 'Zaustavi',
	'Variables' => 'Varijable',
	'Status' => 'Status',

	// Structure.
	'Column' => 'Stupac',
	'Columns' => 'Stupci',
	'Routine' => 'Rutina',
	'Grant' => 'Dodijeli',
	'Revoke' => 'Opozovi',

	// Queries.
	'SQL command' => 'SQL naredba',
	'%d query(s) executed OK.' => [
		'%d upit je uspješno izvršen.',
		'%d upita su uspješno izvršena.',
		'%d upita je uspješno izvršeno.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Upit je uspješno izvršen, %d redak je ažuriran.',
		'Upit je uspješno izvršen, %d retka su ažurirana.',
		'Upit je uspješno izvršen, %d redaka je ažurirano.',
	],
	'No commands to execute.' => 'Nema naredbi za izvršavanje.',
	'Error in query' => 'Greška u upitu',
	'Unknown error.' => 'Nepoznata greška.',
	'Warnings' => 'Upozorenja',
	'%s queries are not supported.' => '%s upiti nisu podržani.',
	'Execute' => 'Izvrši',
	'Stop on error' => 'Zaustavi pri grešci',
	'Show only errors' => 'Prikaži samo greške',
	'Time' => 'Vrijeme',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Povijest',
	'Clear' => 'Očisti',
	'Edit all' => 'Uredi sve',

	// Import.
	'Import' => 'Uvoz',
	'File upload' => 'Prijenos datoteke',
	'From server' => 'S poslužitelja',
	'Webserver file %s' => 'Datoteka %s s web poslužitelja',
	'Run file' => 'Pokreni datoteku',
	'File does not exist.' => 'Datoteka ne postoji.',
	'File uploads are disabled.' => 'Prijenos datoteka je onemogućen.',
	'Unable to upload a file.' => 'Prijenos datoteke nije uspio.',
	'Maximum allowed file size is %sB.' => 'Maksimalna dozvoljena veličina datoteke je %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Preveliki POST podaci. Smanjite podatke ili povećajte vrijednost konfiguracijske direktive %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Veliku SQL datoteku možete prenijeti putem FTP-a i uvesti je s poslužitelja.',
	'File must be in UTF-8 encoding.' => 'Datoteka mora biti u UTF-8 kodiranju.',
	'You are offline.' => 'Niste povezani s mrežom.',
	'%d row(s) have been imported.' => [
		'%d redak je uvezen.',
		'%d retka su uvezena.',
		'%d redaka je uvezeno.',
	],

	// Export.
	'Export' => 'Izvoz',
	'Output' => 'Ispis',
	'open' => 'otvori',
	'save' => 'spremi',
	'Format' => 'Format',
	'Data' => 'Podaci',

	// Databases.
	'Database' => 'Baza podataka',
	'DB' => 'BP',
	'Use' => 'Koristi',
	'Invalid database.' => 'Neispravna baza podataka.',
	'Alter database' => 'Izmijeni bazu podataka',
	'Create database' => 'Kreiraj bazu podataka',
	'Database schema' => 'Shema baze podataka',
	'Permanent link' => 'Trajna veza',
	'Database has been dropped.' => 'Baza podataka je izbrisana.',
	'Databases have been dropped.' => 'Baze podataka su izbrisane.',
	'Database has been created.' => 'Baza podataka je kreirana.',
	'Database has been renamed.' => 'Baza podataka je preimenovana.',
	'Database has been altered.' => 'Baza podataka je izmijenjena.',
	// SQLite errors.
	'File exists.' => 'Datoteka već postoji.',
	'Please use one of the extensions %s.' => 'Molimo koristite jedan od nastavaka %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Shema',
	'Alter schema' => 'Izmijeni shemu',
	'Create schema' => 'Kreiraj shemu',
	'Schema has been dropped.' => 'Shema je izbrisana.',
	'Schema has been created.' => 'Shema je kreirana.',
	'Schema has been altered.' => 'Shema je izmijenjena.',
	'Invalid schema.' => 'Neispravna shema.',

	// Table list.
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Uspoređivanje',
	'collation' => 'uspoređivanje',
	'Data Length' => 'Duljina podataka',
	'Index Length' => 'Duljina indeksa',
	'Data Free' => 'Slobodan prostor',
	'Rows' => 'Redaka',
	'%d in total' => 'ukupno %d',
	'Analyze' => 'Analiziraj',
	'Optimize' => 'Optimiziraj',
	'Vacuum' => 'Vakuumiranje',
	'Check' => 'Provjeri',
	'Repair' => 'Popravi',
	'Truncate' => 'Isprazni',
	'Tables have been truncated.' => 'Tablice su ispražnjene.',
	'Move to other database' => 'Premjesti u drugu bazu podataka',
	'Move' => 'Premjesti',
	'Tables have been moved.' => 'Tablice su premještene.',
	'Copy' => 'Kopiraj',
	'Tables have been copied.' => 'Tablice su kopirane.',
	'overwrite' => 'prepiši',

	// Tables.
	'Tables' => 'Tablice',
	'Tables and views' => 'Tablice i pogledi',
	'Table' => 'Tablica',
	'No tables.' => 'Nema tablica.',
	'Alter table' => 'Izmijeni tablicu',
	'Create table' => 'Kreiraj tablicu',
	'Table has been dropped.' => 'Tablica je izbrisana.',
	'Tables have been dropped.' => 'Tablice su izbrisane.',
	'Tables have been optimized.' => 'Tablice su optimizirane.',
	'Table has been altered.' => 'Tablica je izmijenjena.',
	'Table has been created.' => 'Tablica je kreirana.',
	'Table name' => 'Naziv tablice',
	'Name' => 'Naziv',
	'Show structure' => 'Prikaži strukturu',
	'Column name' => 'Naziv stupca',
	'Type' => 'Tip',
	'Length' => 'Duljina',
	'Auto Increment' => 'Auto-inkrement',
	'Options' => 'Opcije',
	'Comment' => 'Komentar',
	'Default value' => 'Zadana vrijednost',
	'Drop' => 'Izbriši',
	'Drop %s?' => 'Izbrisati %s?',
	'Are you sure?' => 'Jeste li sigurni?',
	'Size' => 'Veličina',
	'Compute' => 'Izračunaj',
	'Move up' => 'Pomakni gore',
	'Move down' => 'Pomakni dolje',
	'Remove' => 'Ukloni',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Premašen je maksimalni broj dozvoljenih polja. Molimo povećajte %s.',

	// Views.
	'View' => 'Pogled',
	'Materialized view' => 'Materijaliziran pogled',
	'View has been dropped.' => 'Pogled je izbrisan.',
	'View has been altered.' => 'Pogled je izmijenjen.',
	'View has been created.' => 'Pogled je kreiran.',
	'Alter view' => 'Izmijeni pogled',
	'Create view' => 'Kreiraj pogled',

	// Partitions.
	'Partition by' => 'Particioniraj po',
	'Partitions' => 'Particije',
	'Partition name' => 'Naziv particije',
	'Values' => 'Vrijednosti',

	// Indexes.
	'Indexes' => 'Indeksi',
	'Indexes have been altered.' => 'Indeksi su izmijenjeni.',
	'Alter indexes' => 'Izmijeni indekse',
	'Add next' => 'Dodaj sljedeći',
	'Index Type' => 'Tip indeksa',
	'length' => 'duljina',
	'Algorithm' => 'Algoritam',
	'Condition' => 'Uvjet',

	// Foreign keys.
	'Foreign keys' => 'Strani ključevi',
	'Foreign key' => 'Strani ključ',
	'Foreign key has been dropped.' => 'Strani ključ je izbrisan.',
	'Foreign key has been altered.' => 'Strani ključ je izmijenjen.',
	'Foreign key has been created.' => 'Strani ključ je kreiran.',
	'Target table' => 'Ciljna tablica',
	'Change' => 'Izmijeni',
	'Source' => 'Izvor',
	'Target' => 'Cilj',
	'Add column' => 'Dodaj stupac',
	'Alter' => 'Izmijeni',
	'Add foreign key' => 'Dodaj strani ključ',
	'ON DELETE' => 'ON DELETE (pri brisanju)',
	'ON UPDATE' => 'ON UPDATE (pri ažuriranju)',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Izvorni i ciljni stupci moraju biti istog tipa podataka, ciljni stupci moraju biti indeksirani i referencirani podaci moraju postojati.',

	// Routines.
	'Routines' => 'Rutine',
	'Routine has been called, %d row(s) affected.' => [
		'Rutina je pozvana, %d redak je ažuriran.',
		'Rutina je pozvana, %d retka su ažurirana.',
		'Rutina je pozvana, %d redaka je ažurirano.',
	],
	'Call' => 'Pozovi',
	'Parameter name' => 'Naziv parametra',
	'Create procedure' => 'Kreiraj proceduru',
	'Create function' => 'Kreiraj funkciju',
	'Routine has been dropped.' => 'Rutina je izbrisana.',
	'Routine has been altered.' => 'Rutina je izmijenjena.',
	'Routine has been created.' => 'Rutina je kreirana.',
	'Alter function' => 'Izmijeni funkciju',
	'Alter procedure' => 'Izmijeni proceduru',
	'Return type' => 'Tip povratne vrijednosti',

	// Events.
	'Events' => 'Događaji',
	'Event' => 'Događaj',
	'Event has been dropped.' => 'Događaj je izbrisan.',
	'Event has been altered.' => 'Događaj je izmijenjen.',
	'Event has been created.' => 'Događaj je kreiran.',
	'Alter event' => 'Izmijeni događaj',
	'Create event' => 'Kreiraj događaj',
	'At given time' => 'U zadano vrijeme',
	'Every' => 'Svako',
	'Schedule' => 'Raspored',
	'Start' => 'Početak',
	'End' => 'Kraj',
	'On completion preserve' => 'Zadrži po završetku',

	// Sequences (PostgreSQL).
	'Sequences' => 'Nizovi',
	'Create sequence' => 'Kreiraj niz',
	'Sequence has been dropped.' => 'Niz je izbrisan.',
	'Sequence has been created.' => 'Niz je kreiran.',
	'Sequence has been altered.' => 'Niz je izmijenjen.',
	'Alter sequence' => 'Izmijeni niz',

	// User types (PostgreSQL)
	'User types' => 'Korisnički tipovi',
	'Create type' => 'Kreiraj tip',
	'Type has been dropped.' => 'Tip je izbrisan.',
	'Type has been created.' => 'Tip je kreiran.',
	'Alter type' => 'Izmijeni tip',

	// Triggers.
	'Triggers' => 'Okidači',
	'Add trigger' => 'Dodaj okidač',
	'Trigger has been dropped.' => 'Okidač je izbrisan.',
	'Trigger has been altered.' => 'Okidač je izmijenjen.',
	'Trigger has been created.' => 'Okidač je kreiran.',
	'Alter trigger' => 'Izmijeni okidač',
	'Create trigger' => 'Kreiraj okidač',

	// Table check constraints.
	'Checks' => 'Provjere',
	'Create check' => 'Kreiraj provjeru',
	'Alter check' => 'Izmijeni provjeru',
	'Check has been created.' => 'Provjera je kreirana.',
	'Check has been altered.' => 'Provjera je izmijenjena.',
	'Check has been dropped.' => 'Provjera je izbrisana.',

	// Selection.
	'Select data' => 'Odaberi podatke',
	'Select' => 'Odaberi',
	'Functions' => 'Funkcije',
	'Aggregation' => 'Agregacija',
	'Search' => 'Pretraži',
	'anywhere' => 'bilo gdje',
	'Sort' => 'Sortiraj',
	'descending' => 'silazno',
	'Limit' => 'Ograničenje',
	'Limit rows' => 'Ograniči retke',
	'Text length' => 'Duljina teksta',
	'Action' => 'Radnja',
	'Full table scan' => 'Puno pretraživanje tablice',
	'Unable to select the table' => 'Nije moguće odabrati tablicu',
	'Search data in tables' => 'Pretraži podatke u tablicama',
	'No rows.' => 'Nema redaka.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d redak',
		'%d retka',
		'%d redaka',
	],
	'Page' => 'Stranica',
	'last' => 'posljednja',
	'Load more data' => 'Učitaj više podataka',
	'Loading' => 'Učitavanje',
	'Whole result' => 'Cijeli skup rezultata',
	'%d byte(s)' => [
		'%d bajt',
		'%d bajta',
		'%d bajtova',
	],

	// In-place editing in selection.
	'Modify' => 'Izmijeni',
	'Ctrl+click on a value to modify it.' => 'Ctrl+klik na vrijednost za izmjenu.',
	'Use edit link to modify this value.' => 'Koristite vezu za uređivanje ove vrijednosti.',

	// Editing.
	'New item' => 'Nova stavka',
	'Edit' => 'Uredi',
	'original' => 'original',
	// label for value '' in enum data type
	'empty' => 'prazno',
	'Insert' => 'Unesi',
	'Save' => 'Spremi',
	'Save and continue edit' => 'Spremi i nastavi uređivanje',
	'Save and insert next' => 'Spremi i unesi sljedeće',
	'Saving' => 'Spremanje',
	'Selected' => 'Odabrano',
	'Clone' => 'Kloniraj',
	'Delete' => 'Izbriši',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Stavka %s je unesena.',
	'Item has been deleted.' => 'Stavka je izbrisana.',
	'Item has been updated.' => 'Stavka je ažurirana.',
	'%d item(s) have been affected.' => [
		'%d stavka je zahvaćena.',
		'%d stavke su zahvaćene.',
		'%d stavki je zahvaćeno.',
	],
	'You have no privileges to update this table.' => 'Nemate ovlasti za ažuriranje ove tablice.',

	// Data type descriptions.
	'Numbers' => 'Brojevi',
	'Date and time' => 'Datum i vrijeme',
	'Strings' => 'Tekst',
	'Binary' => 'Binarno',
	'Lists' => 'Liste',
	'Network' => 'Mreža',
	'Geometry' => 'Geometrija',
	'Relations' => 'Odnosi',

	// Editor - data values.
	'now' => 'sada',
	'yes' => 'da',
	'no' => 'ne',

	// Settings.

	// Plugins.
	// Use the phrases from https://gemini.google.com/
];
