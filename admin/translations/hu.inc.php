<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$6.$4.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY.M.D', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'óó:pp:mm', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap

	// Login
	'System' => 'Adatbázis',
	'Server' => 'Szerver',
	'Username' => 'Felhasználó',
	'Password' => 'Jelszó',
	'Permanent login' => 'Emlékezz rám',
	'Login' => 'Belépés',
	'Logout' => 'Kilépés',
	'Logged as: %s' => 'Belépve: %s',
	'Logout successful.' => 'Sikeres kilépés.',
	'Invalid CSRF token. Send the form again.' => 'Érvénytelen CSRF azonosító. Küldd újra az űrlapot.',

	// Connection
	'No extension' => 'Nincs kiterjesztés',
	'None of the supported PHP extensions (%s) are available.' => 'Nincs egy elérhető támogatott PHP kiterjesztés (%s) sem.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'A munkameneteknek (session) engedélyezve kell lennie.',
	'Session expired, please login again.' => 'Munkamenet lejárt, jelentkezz be újra.',
	'%s version: %s through PHP extension %s' => '%s verzió: %s, PHP: %s',

	// Settings
	'Language' => 'Nyelv',

	'Refresh' => 'Frissítés',

	// Privileges
	'Privileges' => 'Privilégiumok',
	'Create user' => 'Felhasználó hozzáadása',
	'User has been dropped.' => 'A felhasználó eldobva.',
	'User has been altered.' => 'A felhasználó módosult.',
	'User has been created.' => 'A felhasználó létrejött.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Folyamatok',
	'%d process(es) have been killed.' => [
		'%d folyamat leállítva.',
		'%d folyamat leállítva.',
		'%d folyamat leállítva.',
	],
	'Kill' => 'Leállít',
	'Variables' => 'Változók',
	'Status' => 'Állapot',

	// Structure
	'Column' => 'Oszlop',
	'Routine' => 'Rutin',
	'Grant' => 'Engedélyezés',
	'Revoke' => 'Visszavonás',

	// Queries
	'SQL command' => 'SQL parancs',
	'%d query(s) executed OK.' => '%d sikeres lekérdezés.',
	'Query executed OK, %d row(s) affected.' => [
		'Lekérdezés sikeresen végrehajtva, %d sor érintett.',
		'Lekérdezés sikeresen végrehajtva, %d sor érintett.',
		'Lekérdezés sikeresen végrehajtva, %d sor érintett.',
	],
	'No commands to execute.' => 'Nincs végrehajtható parancs.',
	'Error in query' => 'Hiba a lekérdezésben',
	'Execute' => 'Végrehajt',
	'Stop on error' => 'Hiba esetén megáll',
	'Show only errors' => 'Csak a hibák mutatása',
	'Time' => 'Idő',
	'%.3f s' => '%.3f másodperc', // sprintf() format for time of the command
	'History' => 'Történet',
	'Clear' => 'Törlés',
	'Edit all' => 'Összes szerkesztése',

	// Import
	'Import' => 'Importálás',
	'File upload' => 'Fájl feltöltése',
	'From server' => 'Szerverről',
	'Webserver file %s' => 'Webszerver fájl %s',
	'Run file' => 'Fájl futtatása',
	'File does not exist.' => 'A fájl nem létezik.',
	'File uploads are disabled.' => 'A fájl feltöltés le van tiltva.',
	'Unable to upload a file.' => 'Nem tudom feltölteni a fájlt.',
	'Maximum allowed file size is %sB.' => 'A maximális fájlméret %s B.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Túl sok a POST adat! Csökkentsd az adat méretét, vagy növeld a %s beállítást.',
	'%d row(s) have been imported.' => [
		'%d sor importálva.',
		'%d sor importálva.',
		'%d sor importálva.',
	],

	// Export
	'Export' => 'Export',
	'Output' => 'Kimenet',
	'open' => 'megnyit',
	'save' => 'ment',
	'Format' => 'Formátum',
	'Data' => 'Adat',

	// Databases
	'Database' => 'Adatbázis',
	'Use' => 'Használ',
	'Invalid database.' => 'Érvénytelen adatbázis.',
	'Alter database' => 'Adatbázis módosítása',
	'Create database' => 'Adatbázis létrehozása',
	'Database schema' => 'Adatbázis séma',
	'Permanent link' => 'Hivatkozás',
	'Database has been dropped.' => 'Az adatbázis eldobva.',
	'Databases have been dropped.' => 'Adatbázis eldobva.',
	'Database has been created.' => 'Az adatbázis létrejött.',
	'Database has been renamed.' => 'Az adadtbázis átnevezve.',
	'Database has been altered.' => 'Az adatbázis módosult.',

	// SQLite errors
	'File exists.' => 'A fájl létezik.',
	'Please use one of the extensions %s.' => 'Használja a(z) %s kiterjesztést.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Séma',
	'Alter schema' => 'Séma módosítása',
	'Create schema' => 'Séma létrehozása',
	'Schema has been dropped.' => 'Séma eldobva.',
	'Schema has been created.' => 'Séma létrejött.',
	'Schema has been altered.' => 'Séma módosult.',
	'Invalid schema.' => 'Érvénytelen séma.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Egybevetés',
	'collation' => 'egybevetés',
	'Data Length' => 'Méret',
	'Index Length' => 'Index hossz',
	'Data Free' => 'Adat szabad',
	'Rows' => 'Sorok',
	'%d in total' => 'összesen %d',
	'Analyze' => 'Elemzés',
	'Optimize' => 'Optimalizál',
	'Check' => 'Ellenőrzés',
	'Repair' => 'Javít',
	'Truncate' => 'Felszabadít',
	'Tables have been truncated.' => 'A tábla felszabadítva.',
	'Move to other database' => 'Áthelyezés másik adatbázisba',
	'Move' => 'Áthelyez',
	'Tables have been moved.' => 'Táblák áthelyezve.',
	'Copy' => 'Másolás',
	'Tables have been copied.' => 'Táblák átmásolva.',

	// Tables
	'Tables' => 'Táblák',
	'Tables and views' => 'Táblák és nézetek',
	'Table' => 'Tábla',
	'No tables.' => 'Nincs tábla.',
	'Alter table' => 'Tábla módosítása',
	'Create table' => 'Tábla létrehozása',
	'Table has been dropped.' => 'A tábla eldobva.',
	'Tables have been dropped.' => 'Táblák eldobva.',
	'Table has been altered.' => 'A tábla módosult.',
	'Table has been created.' => 'A tábla létrejött.',
	'Table name' => 'Tábla név',
	'Name' => 'Név',
	'Show structure' => 'Struktúra',
	'Column name' => 'Oszlop neve',
	'Type' => 'Típus',
	'Length' => 'Hossz',
	'Auto Increment' => 'Automatikus növelés',
	'Options' => 'Opciók',
	'Comment' => 'Megjegyzés',
	'Drop' => 'Eldob',
	'Are you sure?' => 'Biztos benne?',
	'Move up' => 'Felfelé',
	'Move down' => 'Lefelé',
	'Remove' => 'Eltávolítás',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'A maximális mezőszámot elérted. Növeld meg ezeket: %s.',

	// Views
	'View' => 'Nézet',
	'View has been dropped.' => 'A nézet eldobva.',
	'View has been altered.' => 'A nézet módosult.',
	'View has been created.' => 'A nézet létrejött.',
	'Alter view' => 'Nézet módosítása',
	'Create view' => 'Nézet létrehozása',

	// Partitions
	'Partition by' => 'Particionálás ezzel',
	'Partitions' => 'Particiók',
	'Partition name' => 'Partició neve',
	'Values' => 'Értékek',

	// Indexes
	'Indexes' => 'Indexek',
	'Indexes have been altered.' => 'Az indexek megváltoztak.',
	'Alter indexes' => 'Index módosítása',
	'Add next' => 'Következő hozzáadása',
	'Index Type' => 'Index típusa',
	'length' => 'méret',

	// Foreign keys
	'Foreign keys' => 'Idegen kulcs',
	'Foreign key' => 'Idegen kulcs',
	'Foreign key has been dropped.' => 'Idegen kulcs eldobva.',
	'Foreign key has been altered.' => 'Idegen kulcs módosult.',
	'Foreign key has been created.' => 'Idegen kulcs létrejött.',
	'Target table' => 'Cél tábla',
	'Change' => 'Változtat',
	'Source' => 'Forrás',
	'Target' => 'Cél',
	'Add column' => 'Oszlop hozzáadása',
	'Alter' => 'Módosítás',
	'Add foreign key' => 'Idegen kulcs hozzadása',
	'ON DELETE' => 'törléskor',
	'ON UPDATE' => 'frissítéskor',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'A forrás és cél oszlopoknak azonos típusúak legyenek, a cél oszlopok indexeltek legyenek, és a hivatkozott adatnak léteznie kell.',

	// Routines
	'Routines' => 'Rutinok',
	'Routine has been called, %d row(s) affected.' => [
		'Rutin meghívva, %d sor érintett.',
		'Rutin meghívva, %d sor érintett.',
		'Rutin meghívva, %d sor érintett.',
	],
	'Call' => 'Meghív',
	'Parameter name' => 'Paraméter neve',
	'Create procedure' => 'Eljárás létrehozása',
	'Create function' => 'Funkció létrehozása',
	'Routine has been dropped.' => 'A rutin eldobva.',
	'Routine has been altered.' => 'A rutin módosult.',
	'Routine has been created.' => 'A rutin létrejött.',
	'Alter function' => 'Funkció módosítása',
	'Alter procedure' => 'Eljárás módosítása',
	'Return type' => 'Visszatérési érték',

	// Events
	'Events' => 'Esemény',
	'Event' => 'Esemény',
	'Event has been dropped.' => 'Az esemény eldobva.',
	'Event has been altered.' => 'Az esemény módosult.',
	'Event has been created.' => 'Az esemény létrejött.',
	'Alter event' => 'Esemény módosítása',
	'Create event' => 'Esemény létrehozása',
	'At given time' => 'Megadott időben',
	'Every' => 'Minden',
	'Schedule' => 'Ütemzés',
	'Start' => 'Kezd',
	'End' => 'Vége',
	'On completion preserve' => 'Befejezéskor megőrzi',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sorozatok',
	'Create sequence' => 'Sorozat létrehozása',
	'Sequence has been dropped.' => 'Sorozat eldobva.',
	'Sequence has been created.' => 'Sorozat létrejött.',
	'Sequence has been altered.' => 'Sorozat módosult.',
	'Alter sequence' => 'Sorozat módosítása',

	// User types (PostgreSQL)
	'User types' => 'Felhasználói típus',
	'Create type' => 'Típus létrehozása',
	'Type has been dropped.' => 'Típus eldobva.',
	'Type has been created.' => 'Típus létrehozva.',
	'Alter type' => 'Típus módosítása',

	// Triggers
	'Triggers' => 'Trigger',
	'Add trigger' => 'Trigger hozzáadása',
	'Trigger has been dropped.' => 'A trigger eldobva.',
	'Trigger has been altered.' => 'A trigger módosult.',
	'Trigger has been created.' => 'A trigger létrejött.',
	'Alter trigger' => 'Trigger módosítása',
	'Create trigger' => 'Trigger létrehozása',

	// Table check constraints

	// Selection
	'Select data' => 'Tartalom',
	'Select' => 'Kiválasztás',
	'Functions' => 'Funkciók',
	'Aggregation' => 'Aggregálás',
	'Search' => 'Keresés',
	'anywhere' => 'bárhol',
	'Sort' => 'Sorba rendezés',
	'descending' => 'csökkenő',
	'Limit' => 'korlát',
	'Text length' => 'Szöveg hossz',
	'Action' => 'Művelet',
	'Unable to select the table' => 'Nem tudom kiválasztani a táblát',
	'Search data in tables' => 'Keresés a táblákban',
	'No rows.' => 'Nincs megjeleníthető eredmény.',
	'%d row(s)' => [
		'%d sor',
		'%d sor',
		'%d sor',
	],
	'Page' => 'oldal',
	'last' => 'utolsó',
	'Whole result' => 'Összes eredményt mutatása',
	'%d byte(s)' => [
		'%d bájt',
		'%d bájt',
		'%d bájt',
	],

	// In-place editing in selection
	'Use edit link to modify this value.' => 'Használd a szerkesztés hivatkozást ezen érték módosításához.',

	// Editing
	'New item' => 'Új tétel',
	'Edit' => 'Szerkeszt',
	'original' => 'eredeti',
	'empty' => 'üres', // label for value '' in enum data type
	'Insert' => 'Beszúr',
	'Save' => 'Mentés',
	'Save and continue edit' => 'Mentés és szerkesztés folytatása',
	'Save and insert next' => 'Mentés és újat beszúr',
	'Clone' => 'Klónoz',
	'Delete' => 'Törlés',
	'Item%s has been inserted.' => '%s tétel beszúrva.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'A tétel törölve.',
	'Item has been updated.' => 'A tétel frissítve.',
	'%d item(s) have been affected.' => [
		'%d tétel érintett.',
		'%d tétel érintett.',
		'%d tétel érintett.',
	],

	// Data type descriptions
	'Numbers' => 'Szám',
	'Date and time' => 'Dátum és idő',
	'Strings' => 'Szöveg',
	'Binary' => 'Bináris',
	'Lists' => 'Lista',
	'Network' => 'Hálózat',
	'Geometry' => 'Geometria',
	'Relations' => 'Reláció',

	// Editor - data values
	'now' => 'most',

	// Settings

	// Plugins
];
