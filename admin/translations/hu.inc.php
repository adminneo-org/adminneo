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
	'%s must return an array.' => 'A(z) %s tömböt kell visszaadjon.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => 'A(z) %s és %s a(z) %s metódussal létrehozott objektumot kell visszaadjon.', // by Claude Opus 5

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
	'hostname[:port] or :socket' => 'hostname[:port] vagy :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Érvénytelen szerver vagy belépési adatok.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'A megadott jelszóban szóköz található, ami az ok lehet.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'Az AdminNeo nem támogatja a jelszó nélküli adatbázis-hozzáférést, <a href="https://www.adminneo.org/password"%s>további információ</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Az adatbázis nem támogat jelszót.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Túl sok sikertelen bejelentkezés, próbálja újra %d perc múlva.', // by Claude Fable 5
	'Invalid permanent login, please login again.' => 'Érvénytelen megjegyzett belépés, jelentkezz be újra.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Érvénytelen CSRF azonosító. Küldd újra az űrlapot.',
	'If you did not send this request from AdminNeo then close this page.' => 'Ha nem az AdminNeo-ból küldted ezt a kérést, akkor zárd be ezt az oldalt.', // by Claude Opus 5
	'The action will be performed after successful login with the same credentials.' => 'A művelet az azonos hitelesítő adatokkal történő sikeres bejelentkezés után hajtódik végre.', // by Claude Fable 5

	// Connection
	'No extension' => 'Nincs kiterjesztés',
	'None of the supported PHP extensions (%s) are available.' => 'Nincs egy elérhető támogatott PHP kiterjesztés (%s) sem.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'A privilegizált portokhoz való csatlakozás nem engedélyezett.', // by Claude Fable 5
	'Session support must be enabled.' => 'A munkameneteknek (session) engedélyezve kell lennie.',
	'Session expired, please login again.' => 'Munkamenet lejárt, jelentkezz be újra.',
	'%s version: %s through PHP extension %s' => '%s verzió: %s, PHP: %s',

	// Settings
	'Language' => 'Nyelv',

	'Home' => 'Kezdőlap', // by Claude Opus 5
	'Refresh' => 'Frissítés',
	'Info' => 'Infó', // by Claude Opus 5
	'More information.' => 'További információ.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Privilégiumok',
	'Create user' => 'Felhasználó hozzáadása',
	'User has been dropped.' => 'A felhasználó eldobva.',
	'User has been altered.' => 'A felhasználó módosult.',
	'User has been created.' => 'A felhasználó létrejött.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Folyamatok',
	'%d process(es) have been killed.' => '%d folyamat leállítva.',
	'Kill' => 'Leállít',
	'Variables' => 'Változók',
	'Status' => 'Állapot',

	// Structure
	'Column' => 'Oszlop',
	'Columns' => 'Oszlopok', // by Claude Fable 5
	'Routine' => 'Rutin',
	'Grant' => 'Engedélyezés',
	'Revoke' => 'Visszavonás',

	// Queries
	'SQL command' => 'SQL parancs',
	'HTTP request' => 'HTTP kérés', // by Claude Opus 5
	'%d query(s) executed OK.' => '%d sikeres lekérdezés.',
	'Query executed OK, %d row(s) affected.' => 'Lekérdezés sikeresen végrehajtva, %d sor érintett.',
	'No commands to execute.' => 'Nincs végrehajtható parancs.',
	'Error in query' => 'Hiba a lekérdezésben',
	'Unknown error.' => 'Ismeretlen hiba.', // by Claude Fable 5
	'Warnings' => 'Figyelmeztetések', // by Claude Fable 5
	'%s queries are not supported.' => 'A(z) %s lekérdezések nem támogatottak.', // by Claude Fable 5
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
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'A fájlok maximális száma %d. Válassz kevesebb fájlt, vagy növeld a %s beállítást.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'A fájlok maximális összmérete %s. Válassz kisebb fájlokat, vagy növeld a %s beállítást.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Túl sok a POST adat! Csökkentsd az adat méretét, vagy növeld a %s beállítást.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Nagy SQL fájlt FTP-n keresztül is feltölthet, és a szerverről importálhatja.', // by Claude Fable 5
	'File must be in UTF-8 encoding.' => 'A fájlnak UTF-8 kódolásúnak kell lennie.', // by Claude Fable 5
	'You are offline.' => 'Ön offline állapotban van.', // by Claude Fable 5
	'%d row(s) have been imported.' => '%d sor importálva.',

	// Export
	'Export' => 'Export',
	'Output' => 'Kimenet',
	'open' => 'megnyit',
	'save' => 'ment',
	'Format' => 'Formátum',
	'Data' => 'Adat',

	// Databases
	'Database' => 'Adatbázis',
	'database' => 'adatbázis', // by Claude Opus 5
	'DB' => 'DB', // by Claude Fable 5
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
	'schema' => 'séma', // by Claude Opus 5
	'Schemas' => 'Sémák', // by Claude Opus 5
	'No schemas.' => 'Nincs séma.', // by Claude Opus 5
	'Show schema' => 'Séma mutatása', // by Claude Opus 5
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
	'Vacuum' => 'Tisztítás', // by Claude Fable 5
	'Check' => 'Ellenőrzés',
	'Repair' => 'Javít',
	'Truncate' => 'Felszabadít',
	'Tables have been truncated.' => 'A tábla felszabadítva.',
	'Move to other database' => 'Áthelyezés másik adatbázisba',
	'Move' => 'Áthelyez',
	'Tables have been moved.' => 'Táblák áthelyezve.',
	'Copy' => 'Másolás',
	'Tables have been copied.' => 'Táblák átmásolva.',
	'overwrite' => 'felülírás', // by Claude Fable 5

	// Tables
	'Tables' => 'Táblák',
	'Tables and views' => 'Táblák és nézetek',
	'Table' => 'Tábla',
	'No tables.' => 'Nincs tábla.',
	'Alter table' => 'Tábla módosítása',
	'Create table' => 'Tábla létrehozása',
	'Table has been dropped.' => 'A tábla eldobva.',
	'Tables have been dropped.' => 'Táblák eldobva.',
	'Tables have been optimized.' => 'A táblák optimalizálva.', // by Claude Fable 5
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
	'Default value' => 'Alapértelmezett érték', // by Claude Fable 5
	'Drop' => 'Eldob',
	'Drop %s?' => 'Eldobja: %s?', // by Claude Fable 5
	'Are you sure?' => 'Biztos benne?',
	'Size' => 'Méret', // by Claude Fable 5
	'Compute' => 'Kiszámítás', // by Claude Fable 5
	'Move up' => 'Felfelé',
	'Move down' => 'Lefelé',
	'Remove' => 'Eltávolítás',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'A maximális mezőszámot elérted. Növeld meg ezeket: %s.',

	// Views
	'View' => 'Nézet',
	'Materialized view' => 'Materializált nézet', // by Claude Fable 5
	'View has been dropped.' => 'A nézet eldobva.',
	'View has been altered.' => 'A nézet módosult.',
	'View has been created.' => 'A nézet létrejött.',
	'Alter view' => 'Nézet módosítása',
	'Create view' => 'Nézet létrehozása',

	// Partitions
	'Partition by' => 'Particionálás ezzel',
	'Partition' => 'Partició', // by Claude Opus 5
	'Partitions' => 'Particiók',
	'Partition name' => 'Partició neve',
	'Values' => 'Értékek',
	'Inherited tables' => 'Örökölt táblák', // by Claude Opus 5
	'Inherited from' => 'Örökölve innen', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Indexek',
	'Indexes have been altered.' => 'Az indexek megváltoztak.',
	'Alter indexes' => 'Index módosítása',
	'Add next' => 'Következő hozzáadása',
	'Index Type' => 'Index típusa',
	'length' => 'méret',
	'operator class' => 'operátorosztály', // by Claude Fable 5
	'Algorithm' => 'Algoritmus', // by Claude Fable 5
	'Condition' => 'Feltétel', // by Claude Fable 5

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
	'Routine has been called, %d row(s) affected.' => 'Rutin meghívva, %d sor érintett.',
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

	// User-defined types (PostgreSQL)
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
	'Checks' => 'Ellenőrzések', // by Claude Fable 5
	'Create check' => 'Ellenőrzés létrehozása', // by Claude Fable 5
	'Alter check' => 'Ellenőrzés módosítása', // by Claude Fable 5
	'Check has been created.' => 'Az ellenőrzés létrehozva.', // by Claude Fable 5
	'Check has been altered.' => 'Az ellenőrzés módosult.', // by Claude Fable 5
	'Check has been dropped.' => 'Az ellenőrzés eldobva.', // by Claude Fable 5

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
	'Limit rows' => 'Sorok korlátozása', // by Claude Fable 5
	'Text length' => 'Szöveg hossz',
	'Action' => 'Művelet',
	'Full table scan' => 'Teljes táblaolvasás', // by Claude Fable 5
	'Unable to select the table' => 'Nem tudom kiválasztani a táblát',
	'Search data in tables' => 'Keresés a táblákban',
	'No rows.' => 'Nincs megjeleníthető eredmény.',
	'%d / ' => '%d / ', // by Claude Fable 5
	'%d row(s)' => '%d sor',
	'Page' => 'oldal',
	'last' => 'utolsó',
	'Load more data' => 'További adatok betöltése', // by Claude Fable 5
	'Loading' => 'Betöltés', // by Claude Fable 5
	'Whole result' => 'Összes eredményt mutatása',
	'%d byte(s)' => '%d bájt',

	// In-place editing in selection
	'Modify' => 'Módosítás', // by Claude Fable 5
	'Ctrl+click on a value to modify it.' => 'Ctrl+kattintás egy értékre a módosításához.', // by Claude Fable 5
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
	'Saving' => 'Mentés', // by Claude Fable 5
	'Selected' => 'Kijelölve', // by Claude Fable 5
	'Clone' => 'Klónoz',
	'Delete' => 'Törlés',
	'Item%s has been inserted.' => '%s tétel beszúrva.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'A tétel törölve.',
	'Item has been updated.' => 'A tétel frissítve.',
	'%d item(s) have been affected.' => '%d tétel érintett.',
	'You have no privileges to update this table.' => 'Nincs jogosultsága a tábla frissítéséhez.', // by Claude Fable 5

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
	'yes' => 'igen', // by Claude Fable 5
	'no' => 'nem', // by Claude Fable 5

	// Settings
	'Settings' => 'Beállítások', // by Claude Opus 5
	'Default' => 'Alapértelmezett', // by Claude Opus 5
	'Color scheme' => 'Színséma', // by Claude Opus 5
	'By system' => 'Rendszer szerint', // by Claude Opus 5
	'Light' => 'Világos', // by Claude Opus 5
	'Dark' => 'Sötét', // by Claude Opus 5
	'Navigation mode' => 'Navigációs mód', // by Claude Opus 5
	'Simple' => 'Egyszerű', // by Claude Opus 5
	'Dual' => 'Kettős', // by Claude Opus 5
	'Reversed' => 'Fordított', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'A fő navigáció elrendezése a tábla hivatkozásokkal.', // by Claude Opus 5
	'Table links' => 'Tábla hivatkozások', // by Claude Opus 5
	'Primary action for all table links.' => 'Az elsődleges művelet minden tábla hivatkozáshoz.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Hivatkozások az aktuális sorra hivatkozó táblákra.', // by Claude Opus 5
	'Display' => 'Mutat', // by Claude Opus 5
	'Hide' => 'Elrejt', // by Claude Opus 5
	'Records per page' => 'Rekord oldalanként', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Az adattáblában megjelenített rekordok alapértelmezett száma.', // by Claude Opus 5
	'Enum as select' => 'Enum legördülő listaként', // by Claude Opus 5
	'Never' => 'Soha', // by Claude Opus 5
	'Always' => 'Mindig', // by Claude Opus 5
	'More values than %d' => 'Több mint %d érték', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Küszöbérték a legördülő lista megjelenítéséhez az enum mezőknél.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Egyszer használatos jelszó', // by Claude Opus 5
	'Enter OTP code.' => 'Add meg az OTP kódot.', // by Claude Opus 5
	'Invalid OTP code.' => 'Érvénytelen OTP kód.', // by Claude Opus 5
	'Access denied.' => 'Hozzáférés megtagadva.', // by Claude Opus 5
	'JSON previews' => 'JSON előnézet', // by Claude Opus 5
	'Data table' => 'Adattábla', // by Claude Opus 5
	'Edit form' => 'Szerkesztő űrlap', // by Claude Opus 5
	'Ask %s' => '%s megkérdezése', // by Claude Opus 5
];
