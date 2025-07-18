<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ' ',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$6.$4.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'D.M.RRRR',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.
	'%s must return an array.' => '%s musí vraciať pole.',
	'%s and %s must return an object created by %s method.' => '%s a %s musí vraciať objekt vytvorený pomocou metódy %s.',

	// Login.
	'System' => 'Systém',
	'Server' => 'Server',
	'Username' => 'Používateľ',
	'Password' => 'Heslo',
	'Permanent login' => 'Trvalé prihlásenie',
	'Login' => 'Prihlásiť sa',
	'Logout' => 'Odhlásiť',
	'Logged as: %s' => 'Prihlásený ako: %s',
	'Logout successful.' => 'Odhlásenie prebehlo v poriadku.',
	'Invalid server or credentials.' => 'Neplatný server alebo prihlasovacie údaje.',
	'There is a space in the input password which might be the cause.' => 'V zadanom hesle je medzera, ktorá môže byť príčinou.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo nepodporuje prístup k databáze bez hesla, <a href="https://www.adminneo.org/password"%s>viac informácií</a>.',
	'Database does not support password.' => 'Databáza nepodporuje heslo.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Príliš veľa pokusov o prihlásenie, skúste to znova za %d minutu.',
		'Príliš veľa pokusov o prihlásenie, skúste to znova za %d minuty.',
		'Príliš veľa pokusov o prihlásenie, skúste to znova za %d minút.',
	],
	'Invalid permanent login, please login again.' => 'Neplatné trvalé prihlásenie, prihláste sa prosím znova.',
	'Invalid CSRF token. Send the form again.' => 'Neplatný token CSRF. Odošlite formulár znova.',
	'If you did not send this request from AdminNeo then close this page.' => 'Pokiaľ ste tento požiadavok neodoslali z AdminNeo, zatvorte túto stránku.',
	'The action will be performed after successful login with the same credentials.' => 'Akcia sa vykoná po úspešnom prihlásení s rovnakými prihlasovacími údajmi.',

	// Connection.
	'No driver' => 'Žiadny ovládač',
	'Database driver not found.' => 'Databázový ovládač sa nenašiel.',
	'No extension' => 'Žiadne rozšírenie',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Nie je dostupné žiadne z podporovaných rozšírení (%s).',
	'Connecting to privileged ports is not allowed.' => 'Pripojenie k privilegovaným portom nie je povolené.',
	'Session support must be enabled.' => 'Session premenné musia byť povolené.',
	'Session expired, please login again.' => 'Session vypršala, prihláste sa prosím znova.',
	'%s version: %s through PHP extension %s' => 'Verzia %s: %s cez PHP rozšírenie %s',

	// Settings.
	'Language' => 'Jazyk',

	'Home' => 'Domov',
	'Refresh' => 'Obnoviť',
	'Info' => 'Info',
	'More information.' => 'Viac informácií.',

	// Privileges.
	'Privileges' => 'Oprávnenia',
	'Create user' => 'Vytvoriť používateľa',
	'User has been dropped.' => 'Používateľ bol odstránený.',
	'User has been altered.' => 'Používateľ bol zmenený.',
	'User has been created.' => 'Používateľ bol vytvorený.',
	'Hashed' => 'Zahašované',

	// Server.
	'Process list' => 'Zoznam procesov',
	'%d process(es) have been killed.' => [
		'Bol ukončený %d proces.',
		'Boli ukončené %d procesy.',
		'Bolo ukončených %d procesov.',
	],
	'Kill' => 'Ukončiť',
	'Variables' => 'Premenné',
	'Status' => 'Stav',

	// Structure.
	'Column' => 'Stĺpec',
	'Routine' => 'Procedúra',
	'Grant' => 'Povoliť',
	'Revoke' => 'Zakázať',

	// Queries.
	'SQL command' => 'SQL príkaz',
	'HTTP request' => 'HTTP požiadavka',
	'%d query(s) executed OK.' => [
		'Bol vykonaný %d dotaz.',
		'Boli vykonané %d dotazy.',
		'Bolo vykonaných %d dotazov.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Príkaz prebehol v poriadku, bol zmenený %d záznam.',
		'Príkaz prebehol v poriadku boli zmenené %d záznamy.',
		'Príkaz prebehol v poriadku bolo zmenených %d záznamov.',
	],
	'No commands to execute.' => 'Žiadne príkazy na vykonanie.',
	'Error in query' => 'Chyba v dotaze',
	'Unknown error.' => 'Neznáma chyba.',
	'Warnings' => 'Varovania',
	'ATTACH queries are not supported.' => 'Dotazy ATTACH nie sú podporované.',
	'Execute' => 'Vykonať',
	'Stop on error' => 'Zastaviť pri chybe',
	'Show only errors' => 'Zobraziť iba chyby',
	'Time' => 'Čas',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'História',
	'Clear' => 'Vyčistiť',
	'Edit all' => 'Upraviť všetko',

	// Import.
	'Import' => 'Import',
	'File upload' => 'Nahranie súboru',
	'From server' => 'Zo serveru',
	'Webserver file %s' => 'Súbor %s na webovom serveri',
	'Run file' => 'Spustiť súbor',
	'File does not exist.' => 'Súbor neexistuje.',
	'File uploads are disabled.' => 'Nahrávánie súborov nie je povolené.',
	'Unable to upload a file.' => 'Súbor sa nepodarilo nahrať.',
	'Maximum allowed file size is %sB.' => 'Maximálna povolená veľkosť súboru je %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Príliš veľké POST dáta. Zmenšite dáta alebo zvýšte hodnotu konfiguračej direktívy %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Veľký SQL soubor môžete nahrať pomocou FTP a importovať ho zo servera.',
	'File must be in UTF-8 encoding.' => 'Súbor musí byť v kódovaní UTF-8.',
	'You are offline.' => 'Ste offline.',
	'%d row(s) have been imported.' => [
		'Bol importovaný %d záznam.',
		'Boli importované %d záznamy.',
		'Bolo importovaných %d záznamov.',
	],

	// Export.
	'Export' => 'Export',
	'Output' => 'Výstup',
	'open' => 'otvoriť',
	'save' => 'uložiť',
	'Format' => 'Formát',
	'Data' => 'Dáta',

	// Databases.
	'Database' => 'Databáza',
	'DB' => 'DB',
	'Use' => 'Vybrať',
	'Invalid database.' => 'Nesprávna databáza.',
	'Alter database' => 'Zmeniť databázu',
	'Create database' => 'Vytvoriť databázu',
	'Database schema' => 'Schéma databázy',
	'Permanent link' => 'Permanentný odkaz',
	'Database has been dropped.' => 'Databáza bola odstránená.',
	'Databases have been dropped.' => 'Databázy boli odstránené.',
	'Database has been created.' => 'Databáza bola vytvorená.',
	'Database has been renamed.' => 'Databáza bola premenovaná.',
	'Database has been altered.' => 'Databáza bola zmenená.',
	// SQLite errors.
	'File exists.' => 'Súbor existuje.',
	'Please use one of the extensions %s.' => 'Prosím vyberte jednu z koncoviek %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Schéma',
	'Schemas' => 'Schémy',
	'No schemas.' => 'Žiadne schémy.',
	'Show schema' => 'Zobraziť schému',
	'Alter schema' => 'Pozmeniť schému',
	'Create schema' => 'Vytvoriť schému',
	'Schema has been dropped.' => 'Schéma bola odstránená.',
	'Schema has been created.' => 'Schéma bola vytvorená.',
	'Schema has been altered.' => 'Schéma bola zmenená.',
	'Invalid schema.' => 'Neplatná schéma.',

	// Table list.
	'Engine' => 'Typ',
	'engine' => 'úložisko',
	'Collation' => 'Porovnávanie',
	'collation' => 'porovnávanie',
	'Data Length' => 'Veľkosť dát',
	'Index Length' => 'Veľkosť indexu',
	'Data Free' => 'Voľné miesto',
	'Rows' => 'Riadky',
	'%d in total' => '%d celkom',
	'Analyze' => 'Analyzovať',
	'Optimize' => 'Optimalizovať',
	'Vacuum' => 'Vyčistiť',
	'Check' => 'Skontrolovať',
	'Repair' => 'Opraviť',
	'Truncate' => 'Vyprázdniť',
	'Tables have been truncated.' => 'Tabuľka bola vyprázdnená.',
	'Move to other database' => 'Presunúť do inej databázy',
	'Move' => 'Presunúť',
	'Tables have been moved.' => 'Tabuľka bola presunutá.',
	'Copy' => 'Kopírovať',
	'Tables have been copied.' => 'Tabuľky boli skopírované.',
	'overwrite' => 'prepísať',

	// Tables.
	'Tables' => 'Tabuľky',
	'Tables and views' => 'Tabuľky a pohľady',
	'Table' => 'Tabuľka',
	'No tables.' => 'Žiadne tabuľky.',
	'Alter table' => 'Zmeniť tabuľku',
	'Create table' => 'Vytvoriť tabuľku',
	'Table has been dropped.' => 'Tabuľka bola odstránená.',
	'Tables have been dropped.' => 'Tabuľka bola odstránená.',
	'Tables have been optimized.' => 'Tabuľky boli optimalizované.',
	'Table has been altered.' => 'Tabuľka bola zmenená.',
	'Table has been created.' => 'Tabuľka bola vytvorená.',
	'Table name' => 'Názov tabuľky',
	'Name' => 'Názov',
	'Show structure' => 'Zobraziť štruktúru',
	'Column name' => 'Názov stĺpca',
	'Type' => 'Typ',
	'Length' => 'Dĺžka',
	'Auto Increment' => 'Auto Increment',
	'Options' => 'Voľby',
	'Comment' => 'Komentár',
	'Default value' => 'Predvolená hodnota',
	'Drop' => 'Odstrániť',
	'Drop %s?' => 'Odstrániť %s?',
	'Are you sure?' => 'Naozaj?',
	'Size' => 'Veľkosť',
	'Compute' => 'Spočítať',
	'Move up' => 'Presunúť hore',
	'Move down' => 'Presunúť dolu',
	'Remove' => 'Odobrať',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Bol prekročený maximálny počet povolených polí. Zvýšte prosím %s.',

	// Views.
	'View' => 'Pohľad',
	'Materialized view' => 'Materializovaný pohľad',
	'View has been dropped.' => 'Pohľad bol odstránený.',
	'View has been altered.' => 'Pohľad bol zmenený.',
	'View has been created.' => 'Pohľad bol vytvorený.',
	'Alter view' => 'Zmeniť pohľad',
	'Create view' => 'Vytvoriť pohľad',

	// Partitions.
	'Partition by' => 'Rozdeliť podľa',
	'Partition' => 'Oddiel',
	'Partitions' => 'Oddiely',
	'Partition name' => 'Názov oddielu',
	'Values' => 'Hodnoty',

	// Indexes.
	'Indexes' => 'Indexy',
	'Indexes have been altered.' => 'Indexy boli zmenené.',
	'Alter indexes' => 'Zmeniť indexy',
	'Add next' => 'Pridať ďalší',
	'Index Type' => 'Typ indexu',
	'length' => 'dĺžka',

	// Foreign keys.
	'Foreign keys' => 'Cudzie kľúče',
	'Foreign key' => 'Cudzí kľúč',
	'Foreign key has been dropped.' => 'Cudzí kľúč bol odstránený.',
	'Foreign key has been altered.' => 'Cudzí kľúč bol zmenený.',
	'Foreign key has been created.' => 'Cudzí kľúč bol vytvorený.',
	'Target table' => 'Cieľová tabuľka',
	'Change' => 'Zmeniť',
	'Source' => 'Zdroj',
	'Target' => 'Cieľ',
	'Add column' => 'Pridať stĺpec',
	'Alter' => 'Zmeniť',
	'Add foreign key' => 'Pridať cudzí kľúč',
	'ON DELETE' => 'Pri zmazaní',
	'ON UPDATE' => 'Pri aktualizácii',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Zdrojové a cieľové stĺpce musia mať rovnaký datový typ, nad cieľovými stĺpcami musí byť definovaný index a odkazované dáta musia existovať.',

	// Routines.
	'Routines' => 'Procedúry',
	'Routine has been called, %d row(s) affected.' => [
		'Procedúra bola zavolaná, bol zmenený %d záznam.',
		'Procedúra bola zavolaná, boli zmenené %d záznamy.',
		'Procedúra bola zavolaná, bolo zmenených %d záznamov.',
	],
	'Call' => 'Zavolať',
	'Parameter name' => 'Názov parametra',
	'Create procedure' => 'Vytvoriť procedúru',
	'Create function' => 'Vytvoriť funkciu',
	'Routine has been dropped.' => 'Procedúra bola odstránená.',
	'Routine has been altered.' => 'Procedúra bola zmenená.',
	'Routine has been created.' => 'Procedúra bola vytvorená.',
	'Alter function' => 'Zmeniť funkciu',
	'Alter procedure' => 'Zmeniť procedúru',
	'Return type' => 'Návratový typ',

	// Events.
	'Events' => 'Udalosti',
	'Event' => 'Udalosť',
	'Event has been dropped.' => 'Udalosť bola odstránená.',
	'Event has been altered.' => 'Udalosť bola zmenená.',
	'Event has been created.' => 'Udalosť bola vytvorená.',
	'Alter event' => 'Upraviť udalosť',
	'Create event' => 'Vytvoriť udalosť',
	'At given time' => 'V stanovený čas',
	'Every' => 'Každých',
	'Schedule' => 'Plán',
	'Start' => 'Začiatok',
	'End' => 'Koniec',
	'On completion preserve' => 'Po dokončení zachovat',

	// Sequences (PostgreSQL).
	'Sequences' => 'Sekvencia',
	'Create sequence' => 'Vytvoriť sekvenciu',
	'Sequence has been dropped.' => 'Sekvencia bola odstránená.',
	'Sequence has been created.' => 'Sekvencia bola vytvorená.',
	'Sequence has been altered.' => 'Sekvencia bola zmenená.',
	'Alter sequence' => 'Pozmeniť sekvenciu',

	// User types (PostgreSQL)
	'User types' => 'Užívateľské typy',
	'Create type' => 'Vytvoriť typ',
	'Type has been dropped.' => 'Typ bol odstránený.',
	'Type has been created.' => 'Typ bol vytvorený.',
	'Alter type' => 'Pozmeniť typ',

	// Triggers.
	'Triggers' => 'Triggery',
	'Add trigger' => 'Pridať trigger',
	'Trigger has been dropped.' => 'Trigger bol odstránený.',
	'Trigger has been altered.' => 'Trigger bol zmenený.',
	'Trigger has been created.' => 'Trigger bol vytvorený.',
	'Alter trigger' => 'Zmeniť trigger',
	'Create trigger' => 'Vytvoriť trigger',

	// Table check constraints.
	'Checks' => 'Kontroly',
	'Create check' => 'Vytvoriť kontrolu',
	'Alter check' => 'Zmeniť kontrolu',
	'Check has been created.' => 'Kontrola bola vytvorená.',
	'Check has been altered.' => 'Kontrola byla zmenená.',
	'Check has been dropped.' => 'Kontrola byla odstránená.',

	// Selection.
	'Select data' => 'Vypísať dáta',
	'Select' => 'Vypísať',
	'Functions' => 'Funkcie',
	'Aggregation' => 'Agregácia',
	'Search' => 'Vyhľadať',
	'anywhere' => 'kdekoľvek',
	'Sort' => 'Zotriediť',
	'descending' => 'zostupne',
	'Limit' => 'Limit',
	'Limit rows' => 'Limit riadkov',
	'Text length' => 'Dĺžka textov',
	'Action' => 'Akcia',
	'Full table scan' => 'Prechod celej tabuľky',
	'Unable to select the table' => 'Tabuľku sa nepodarilo vypísať',
	'Search data in tables' => 'Vyhľadať dáta v tabuľkách',
	'as a regular expression' => 'ako regulárny výraz',
	'No rows.' => 'Žiadne riadky.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d riadok',
		'%d riadky',
		'%d riadkov',
	],
	'Page' => 'Stránka',
	'last' => 'posledný',
	'Load more data' => 'Načítať ďalšie dáta',
	'Loading' => 'Načítava sa',
	'Whole result' => 'Celý výsledok',
	'%d byte(s)' => [
		'%d bajt',
		'%d bajty',
		'%d bajtov',
	],

	// In-place editing in selection.
	'Modify' => 'Zmeniť',
	'Ctrl+click on a value to modify it.' => 'Ctrl+kliknite na políčko, ktoré chcete zmeniť.',
	'Use edit link to modify this value.' => 'Pre zmenu tejto hodnoty použite odkaz upraviť.',

	// Editing.
	'New item' => 'Nová položka',
	'Edit' => 'Upraviť',
	'original' => 'originál',
	// label for value '' in enum data type
	'empty' => 'prázdne',
	'Insert' => 'Vložiť',
	'Save' => 'Uložiť',
	'Save and continue edit' => 'Uložiť a pokračovať v úpravách',
	'Save and insert next' => 'Uložiť a vložiť ďalší',
	'Saving' => 'Ukladá sa',
	'Selected' => 'Označené',
	'Clone' => 'Klonovať',
	'Delete' => 'Zmazať',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Položka%s bola vložená.',
	'Item has been deleted.' => 'Položka bola vymazaná.',
	'Item has been updated.' => 'Položka bola aktualizovaná.',
	'%d item(s) have been affected.' => '%d položiek bolo ovplyvnených.',
	'You have no privileges to update this table.' => 'Nemáte oprávnenie na aktualizáciu tejto tabuľky.',

	// Data type descriptions.
	'Numbers' => 'Čísla',
	'Date and time' => 'Dátum a čas',
	'Strings' => 'Reťazce',
	'Binary' => 'Binárne',
	'Lists' => 'Zoznamy',
	'Network' => 'Sieť',
	'Geometry' => 'Geometria',
	'Relations' => 'Vzťahy',

	// Editor - data values.
	'now' => 'teraz',
	'yes' => 'áno',
	'no' => 'nie',

	// Plugins.
	'One Time Password' => 'Jednorázové heslo',
	'Enter OTP code.' => 'Zadajte jednorázový kód.',
	'Invalid OTP code.' => 'Neplatný jednorázový kód.',
	'Access denied.' => 'Prístup zamietnutý.',
];
