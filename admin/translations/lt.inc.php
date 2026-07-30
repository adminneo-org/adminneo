<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s turi grąžinti masyvą.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s ir %s turi grąžinti objektą, sukurtą metodu %s.', // by Claude Fable 5.1

	// Login
	'System' => 'Sistema',
	'Server' => 'Serveris',
	'Username' => 'Vartotojas',
	'Password' => 'Slaptažodis',
	'Permanent login' => 'Pastovus prisijungimas',
	'Login' => 'Prisijungti',
	'Logout' => 'Atsijungti',
	'Logged as: %s' => 'Prisijungęs kaip: %s',
	'Logout successful.' => 'Jūs atsijungėte nuo sistemos.',
	'hostname[:port] or :socket' => 'serverio vardas[:prievadas] arba :lizdas', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'Neteisingas serveris arba prisijungimo duomenys.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'Įvestame slaptažodyje yra tarpas, tai gali būti priežastis.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo nepalaiko prisijungimo prie duomenų bazės be slaptažodžio, <a href="https://www.adminneo.org/password"%s>daugiau informacijos</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'Duomenų bazė nepalaiko slaptažodžio.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Per daug nesėkmingų prisijungimų, bandykite dar kartą po %d minutės.',
		'Per daug nesėkmingų prisijungimų, bandykite dar kartą po %d minučių.',
		'Per daug nesėkmingų prisijungimų, bandykite dar kartą po %d minučių.',
	], // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => 'Neteisingas pastovus prisijungimas. Prisijunkite iš naujo.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'Neteisingas CSRF tokenas. Bandykite siųsti formos duomenis dar kartą.',
	'If you did not send this request from AdminNeo then close this page.' => 'Jei šios užklausos nesiuntėte iš AdminNeo, uždarykite šį puslapį.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'Veiksmas bus atliktas sėkmingai prisijungus su tais pačiais duomenimis.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'Nėra plėtinio', // by Claude Fable 5.1
	'None of the supported PHP extensions (%s) are available.' => 'Nėra nei vieno iš palaikomų PHP plėtinių (%s).', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Jungtis prie privilegijuotų prievadų neleidžiama.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'Sesijų palaikymas turi būti įjungtas.',
	'Session expired, please login again.' => 'Sesijos galiojimas baigėsi. Prisijunkite iš naujo.',
	'%s version: %s through PHP extension %s' => '%s versija: %s per PHP plėtinį %s',

	// Settings
	'Language' => 'Kalba',

	'Menu' => 'Meniu', // by Claude Fable 5.1
	'Home' => 'Pradžia', // by Claude Fable 5.1
	'Refresh' => 'Atnaujinti',
	'Info' => 'Informacija', // by Claude Fable 5.1
	'More information.' => 'Daugiau informacijos.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'Privilegijos',
	'Create user' => 'Sukurti vartotoją',
	'User has been dropped.' => 'Vartotojas ištrintas.',
	'User has been altered.' => 'Vartotojo duomenys pakeisti.',
	'User has been created.' => 'Vartotojas sukurtas.',
	'Hashed' => 'Šifruotas',

	// Server
	'Process list' => 'Procesų sąrašas',
	'%d process(es) have been killed.' => [
		'%d procesas nutrauktas.',
		'%d procesai nutraukti.',
		'%d procesų nutraukta.',
	],
	'Kill' => 'Nutraukti',
	'Variables' => 'Kintamieji',
	'Status' => 'Būsena',

	// Structure
	'Column' => 'Stulpelis',
	'Columns' => 'Stulpeliai', // by Claude Fable 5.1
	'Routine' => 'Procedūra',
	'Grant' => 'Suteikti',
	'Revoke' => 'Atšaukti',

	// Queries
	'SQL command' => 'SQL užklausa',
	'HTTP request' => 'HTTP užklausa', // by Claude Fable 5.1
	'%d query(s) executed OK.' => [
		'%d užklausa įvykdyta.',
		'%d užklausos įvykdytos.',
		'%d užklausų įvykdyta.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Užklausa įvykdyta. Pakeistas %d įrašas.',
		'Užklausa įvykdyta. Pakeisti %d įrašai.',
		'Užklausa įvykdyta. Pakeista %d įrašų.',
	],
	'No commands to execute.' => 'Nėra vykdomų užklausų.',
	'Error in query' => 'Klaida užklausoje',
	'Unknown error.' => 'Nežinoma klaida.', // by Claude Fable 5.1
	'Warnings' => 'Įspėjimai', // by Claude Fable 5.1
	'%s queries are not supported.' => '%s užklausos nepalaikomos.', // by Claude Fable 5.1
	'Execute' => 'Vykdyti',
	'Stop on error' => 'Sustabdyti esant klaidai',
	'Show only errors' => 'Rodyti tik klaidas',
	'Time' => 'Laikas',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Istorija',
	'Clear' => 'Išvalyti',
	'Edit all' => 'Redaguoti visus',

	// Import
	'Import' => 'Importas',
	'File upload' => 'Failo įkėlimas',
	'From server' => 'Iš serverio',
	'Webserver file %s' => 'Failas %s iš serverio',
	'Run file' => 'Vykdyti failą',
	'File does not exist.' => 'Failas neegzistuoja.',
	'File uploads are disabled.' => 'Failų įkėlimas išjungtas.',
	'Unable to upload a file.' => 'Nepavyko įkelti failo.',
	'Maximum allowed file size is %sB.' => 'Maksimalus failo dydis - %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Maksimalus failų skaičius yra %d. Pasirinkite mažiau failų arba padidinkite konfigūracijos nustatymą %s.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Maksimalus bendras failų dydis yra %s. Pasirinkite mažesnius failus arba padidinkite konfigūracijos nustatymą %s.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Per daug POST duomenų. Sumažinkite duomenų kiekį arba padidinkite konfigūracijos nustatymą %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Didelį SQL failą galite įkelti per FTP ir importuoti jį iš serverio.', // by Claude Fable 5.1
	'File must be in UTF-8 encoding.' => 'Failas turi būti UTF-8 koduotės.', // by Claude Fable 5.1
	'You are offline.' => 'Jūs esate atsijungę nuo tinklo.', // by Claude Fable 5.1
	'%d row(s) have been imported.' => [
		'%d įrašas įkelta.',
		'%d įrašai įkelti.',
		'%d įrašų įkelta.',
	],

	// Export
	'Export' => 'Eksportas',
	'Output' => 'Išvestis',
	'open' => 'atidaryti',
	'save' => 'išsaugoti',
	'Format' => 'Formatas',
	'Data' => 'Duomenys',

	// Databases
	'Database' => 'Duomenų bazė',
	'database' => 'duomenų bazė', // by Claude Fable 5.1
	'DB' => 'DB', // by Claude Fable 5.1
	'Use' => 'Naudoti',
	'Invalid database.' => 'Neteisinga duomenų bazė.',
	'Alter database' => 'Redaguoti duomenų bazę',
	'Create database' => 'Sukurti duomenų bazę',
	'Database schema' => 'Duomenų bazės schema',
	'Permanent link' => 'Pastovi nuoroda',
	'Database has been dropped.' => 'Duomenų bazė panaikinta.',
	'Databases have been dropped.' => 'Duomenų bazės panaikintos.',
	'Database has been created.' => 'Duomenų bazė sukurta.',
	'Database has been renamed.' => 'Duomenų bazė pervadinta.',
	'Database has been altered.' => 'Duomenų bazė pakeista.',

	// SQLite errors
	'File exists.' => 'Failas egzistuoja.',
	'Please use one of the extensions %s.' => 'Naudokite vieną iš plėtinių %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Schema',
	'schema' => 'schema', // by Claude Fable 5.1
	'Schemas' => 'Schemos', // by Claude Fable 5.1
	'No schemas.' => 'Nėra schemų.', // by Claude Fable 5.1
	'Show schema' => 'Rodyti schemą', // by Claude Fable 5.1
	'Alter schema' => 'Keisti schemą',
	'Create schema' => 'Sukurti schemą',
	'Schema has been dropped.' => 'Schema pašalinta.',
	'Schema has been created.' => 'Schema sukurta.',
	'Schema has been altered.' => 'Schema pakeista.',
	'Invalid schema.' => 'Neteisinga schema.',

	// Table list
	'All' => 'Visi', // checkbox selecting all tables and views // by Claude Fable 5.1
	'Engine' => 'Variklis',
	'engine' => 'variklis',
	'Collation' => 'Lyginimas',
	'collation' => 'palyginimas',
	'Data Length' => 'Duomenų ilgis',
	'Index Length' => 'Indekso ilgis',
	'Data Free' => 'Laisvos vietos',
	'Rows' => 'Įrašai',
	'%d in total' => '%d iš viso',
	'Analyze' => 'Analizuoti',
	'Optimize' => 'Optimizuoti',
	'Vacuum' => 'Valyti (Vacuum)', // by Claude Fable 5.1
	'Check' => 'Patikrinti',
	'Repair' => 'Pataisyti',
	'Truncate' => 'Tuštinti',
	'Truncate Cascade' => 'Tuštinti kaskadiškai', // by Claude Fable 5.1
	'Tables have been truncated.' => 'Lentelės buvo ištuštintos.',
	'Move to other database' => 'Perkelti į kitą duomenų bazę',
	'Move' => 'Perkelti',
	'Tables have been moved.' => 'Lentelės perkeltos.',
	'Copy' => 'Kopijuoti',
	'Tables have been copied.' => 'Lentelės nukopijuotos.',
	'overwrite' => 'perrašyti', // by Claude Fable 5.1

	// Tables
	'Tables' => 'Lentelės',
	'Tables and views' => 'Lentelės ir vaizdai',
	'Table' => 'Lentelė',
	'No tables.' => 'Nėra lentelių.',
	'Alter table' => 'Redaguoti lentelę',
	'Create table' => 'Sukurti lentelę',
	'Table has been dropped.' => 'Lentelė pašalinta.',
	'Tables have been dropped.' => 'Lentelės pašalintos.',
	'Tables have been optimized.' => 'Lentelės buvo optimizuotos.', // by Claude Fable 5.1
	'Table has been altered.' => 'Lentelė pakeista.',
	'Table has been created.' => 'Lentelė sukurta.',
	'Table name' => 'Lentelės pavadinimas',
	'Name' => 'Pavadinimas',
	'Show structure' => 'Rodyti struktūrą',
	'Column name' => 'Stulpelio pavadinimas',
	'Type' => 'Tipas',
	'Length' => 'Ilgis',
	'Auto Increment' => 'Auto Increment',
	'Options' => 'Nustatymai',
	'Comment' => 'Komentaras',
	'Default value' => 'Numatytoji reikšmė', // by Claude Fable 5.1
	'Drop' => 'Pašalinti',
	'Drop %s?' => 'Pašalinti %s?', // by Claude Fable 5.1
	'Are you sure?' => 'Tikrai?',
	'Size' => 'Dydis', // by Claude Fable 5.1
	'Compute' => 'Apskaičiuoti', // by Claude Fable 5.1
	'Move up' => 'Perkelti į viršų',
	'Move down' => 'Perkelti žemyn',
	'Remove' => 'Pašalinti',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Viršytas maksimalus leidžiamų stulpelių kiekis. Padidinkite %s.',

	// Views
	'View' => 'Vaizdas',
	'Materialized view' => 'Materializuotas vaizdas', // by Claude Fable 5.1
	'View has been dropped.' => 'Vaizdas pašalintas.',
	'View has been altered.' => 'Vaizdas pakeistas.',
	'View has been created.' => 'Vaizdas sukurtas.',
	'Alter view' => 'Redaguoti vaizdą',
	'Create view' => 'Sukurti vaizdą',

	// Partitions
	'Partition by' => 'Skirstyti pagal',
	'Partition' => 'Skirsnis', // by Claude Fable 5.1
	'Partitions' => 'Skirsniai',
	'Partition name' => 'Skirsnio pavadinimas',
	'Values' => 'Reikšmės',
	'Inherited tables' => 'Paveldėtos lentelės', // by Claude Fable 5.1
	'Inherited from' => 'Paveldėta iš', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'Indeksai',
	'Indexes have been altered.' => 'Indeksai pakeisti.',
	'Alter indexes' => 'Redaguoti indeksus',
	'Add next' => 'Pridėti kitą',
	'Index Type' => 'Indekso tipas',
	'length' => 'ilgis',
	'operator class' => 'operatorių klasė', // by Claude Fable 5.1
	'Algorithm' => 'Algoritmas', // by Claude Fable 5.1
	'Condition' => 'Sąlyga', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'Išoriniai raktai',
	'Foreign key' => 'Išorinis raktas',
	'Foreign key has been dropped.' => 'Išorinis raktas pašalintas.',
	'Foreign key has been altered.' => 'Išorinis raktas pakeistas.',
	'Foreign key has been created.' => 'Išorinis raktas sukurtas.',
	'Target table' => 'Tikslinė lentelė',
	'Change' => 'Pakeisti',
	'Source' => 'Šaltinis',
	'Target' => 'Tikslas',
	'Add column' => 'Pridėti stulpelį',
	'Alter' => 'Redaguoti',
	'Add foreign key' => 'Pridėti išorinį raktą',
	'ON DELETE' => 'Ištrinant',
	'ON UPDATE' => 'Atnaujinant',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Šaltinio ir tikslinis stulpelis turi būti to paties tipo, tiksliniame stulpelyje turi būti naudojamas indeksas ir duomenys turi egzistuoti.',

	// Routines
	'Routines' => 'Procedūros',
	'Routine has been called, %d row(s) affected.' => [
		'Procedūra įvykdyta. %d įrašas pakeistas.',
		'Procedūra įvykdyta. %d įrašai pakeisti.',
		'Procedūra įvykdyta. %d įrašų pakeista.',
	],
	'Call' => 'Vykdyti',
	'Parameter name' => 'Parametro pavadinimas',
	'Create procedure' => 'Sukurti procedūrą',
	'Create function' => 'Sukurti funkciją',
	'Routine has been dropped.' => 'Procedūra pašalinta.',
	'Routine has been altered.' => 'Procedūra pakeista.',
	'Routine has been created.' => 'Procedūra sukurta.',
	'Alter function' => 'Keisti funkciją',
	'Alter procedure' => 'Keiskti procedūrą',
	'Return type' => 'Grąžinimo tipas',

	// Events
	'Events' => 'Įvykiai',
	'Event' => 'Įvykis',
	'Event has been dropped.' => 'Įvykis pašalintas.',
	'Event has been altered.' => 'Įvykis pakeistas.',
	'Event has been created.' => 'Įvykis sukurtas.',
	'Alter event' => 'Redaguoti įvykį',
	'Create event' => 'Sukurti įvykį',
	'At given time' => 'Nurodytu laiku',
	'Every' => 'Kas',
	'Schedule' => 'Grafikas',
	'Start' => 'Pradžia',
	'End' => 'Pabaiga',
	'On completion preserve' => 'Įvykdžius išsaugoti',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sekos',
	'Create sequence' => 'Sukurti seką',
	'Sequence has been dropped.' => 'Seka pašalinta.',
	'Sequence has been created.' => 'Seka sukurta.',
	'Sequence has been altered.' => 'Seka pakeista.',
	'Alter sequence' => 'Keisti seką',

	// User-defined types (PostgreSQL)
	'User types' => 'Vartotojo apibrėžti tipai', // by Claude Fable 5.1
	'Create type' => 'Sukurti tipą',
	'Type has been dropped.' => 'Tipas pašalintas.',
	'Type has been created.' => 'Tipas sukurtas.',
	'Alter type' => 'Keisti tipą',

	// Triggers
	'Triggers' => 'Trigeriai',
	'Add trigger' => 'Pridėti trigerį',
	'Trigger has been dropped.' => 'Trigeris pašalintas.',
	'Trigger has been altered.' => 'Trigeris pakeistas.',
	'Trigger has been created.' => 'Trigeris sukurtas.',
	'Alter trigger' => 'Keisti trigerį',
	'Create trigger' => 'Sukurti trigerį',

	// Table check constraints
	'Checks' => 'Patikros', // by Claude Fable 5.1
	'Create check' => 'Sukurti patikrą', // by Claude Fable 5.1
	'Alter check' => 'Keisti patikrą', // by Claude Fable 5.1
	'Check has been created.' => 'Patikra sukurta.', // by Claude Fable 5.1
	'Check has been altered.' => 'Patikra pakeista.', // by Claude Fable 5.1
	'Check has been dropped.' => 'Patikra pašalinta.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'Atrinkti duomenis',
	'Select' => 'Atrinkti',
	'Functions' => 'Funkcijos',
	'Aggregation' => 'Agregacija',
	'Search' => 'Ieškoti',
	'anywhere' => 'visur',
	'Sort' => 'Rikiuoti',
	'descending' => 'mažėjimo tvarka',
	'Limit' => 'Limitas',
	'Limit rows' => 'Riboti įrašus', // by Claude Fable 5.1
	'Text length' => 'Teksto ilgis',
	'Action' => 'Veiksmas',
	'Full table scan' => 'Visos lentelės nuskaitymas', // by Claude Fable 5.1
	'Unable to select the table' => 'Neįmanoma atrinkti lentelės',
	'Search data in tables' => 'Ieškoti duomenų lentelėse',
	'All rows on this page' => 'Visi šio puslapio įrašai', // by Claude Fable 5.1
	'No rows.' => 'Nėra įrašų.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => [
		'%d įrašas',
		'%d įrašai',
		'%d įrašų',
	],
	'Page' => 'Puslapis',
	'last' => 'paskutinis',
	'Load more data' => 'Įkelti daugiau duomenų', // by Claude Fable 5.1
	'Loading…' => 'Kraunama…', // by Claude Fable 5.1
	'Whole result' => 'Visas rezultatas',
	'%d byte(s)' => [
		'%d baitas',
		'%d baigai',
		'%d baitų',
	],

	// In-place editing in selection
	'Modify' => 'Keisti', // by Claude Fable 5.1
	'Ctrl+click on a value to modify it.' => 'Norėdami pakeisti reikšmę, spustelėkite ją laikydami Ctrl.', // by Claude Fable 5.1
	'Use edit link to modify this value.' => 'Norėdami redaguoti reikšmę naudokite redagavimo nuorodą.',

	// Editing
	'New item' => 'Naujas įrašas',
	'Edit' => 'Redaguoti',
	'original' => 'originalas',
	'empty' => 'tuščia', // label for value '' in enum data type
	'Insert' => 'Įrašyti',
	'Save' => 'Išsaugoti',
	'Save and continue edit' => 'Išsaugoti ir tęsti redagavimą',
	'Save and insert next' => 'Išsaugoti ir įrašyti kitą',
	'Saving…' => 'Išsaugoma…', // by Claude Fable 5.1
	'Selected' => 'Pasirinkta', // by Claude Fable 5.1
	'Clone' => 'Klonuoti',
	'Delete' => 'Trinti',
	'Item%s has been inserted.' => 'Įrašas%s sukurtas.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Įrašas ištrintas.',
	'Item has been updated.' => 'Įrašas pakeistas.',
	'%d item(s) have been affected.' => [
		'Pakeistas %d įrašas.',
		'Pakeisti %d įrašai.',
		'Pakeistas %d įrašų.',
	],
	'You have no privileges to update this table.' => 'Neturite teisių keisti šios lentelės.', // by Claude Fable 5.1

	// Data type descriptions
	'Numbers' => 'Skaičiai',
	'Date and time' => 'Data ir laikas',
	'Strings' => 'Tekstas',
	'Binary' => 'Dvejetainis',
	'Lists' => 'Sąrašai',
	'Network' => 'Tinklas',
	'Geometry' => 'Geometrija',
	'Relations' => 'Ryšiai',

	// Editor - data values
	'now' => 'dabar',
	'yes' => 'taip', // by Claude Fable 5.1
	'no' => 'ne', // by Claude Fable 5.1

	// Settings
	'Settings' => 'Nustatymai', // by Claude Fable 5.1
	'Default' => 'Numatytasis', // by Claude Fable 5.1
	'Color scheme' => 'Spalvų schema', // by Claude Fable 5.1
	'By system' => 'Pagal sistemą', // by Claude Fable 5.1
	'Light' => 'Šviesi', // by Claude Fable 5.1
	'Dark' => 'Tamsi', // by Claude Fable 5.1
	'Navigation mode' => 'Navigacijos režimas', // by Claude Fable 5.1
	'Simple' => 'Paprastas', // by Claude Fable 5.1
	'Dual' => 'Dvigubas', // by Claude Fable 5.1
	'Dual on hover' => 'Dvigubas užvedus pelę', // by Claude Fable 5.1
	'Reversed' => 'Atvirkštinis', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'Pagrindinės navigacijos su lentelių nuorodomis išdėstymas.', // by Claude Fable 5.1
	'Table links' => 'Lentelių nuorodos', // by Claude Fable 5.1
	'Primary action for all table links.' => 'Pagrindinis veiksmas visoms lentelių nuorodoms.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'Nuorodos į lenteles, kurios nurodo į dabartinį įrašą.', // by Claude Fable 5.1
	'Display' => 'Rodyti', // by Claude Fable 5.1
	'Hide' => 'Slėpti', // by Claude Fable 5.1
	'Records per page' => 'Įrašų puslapyje', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'Numatytasis duomenų lentelėje rodomų įrašų skaičius.', // by Claude Fable 5.1
	'Enum as select' => 'Enum kaip pasirinkimo sąrašas', // by Claude Fable 5.1
	'Never' => 'Niekada', // by Claude Fable 5.1
	'Always' => 'Visada', // by Claude Fable 5.1
	'More values than %d' => 'Daugiau nei %d reikšmių', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'Riba, nuo kurios enum stulpeliams rodomas pasirinkimo sąrašas.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'Vienkartinis slaptažodis', // by Claude Fable 5.1
	'Enter OTP code.' => 'Įveskite OTP kodą.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'Neteisingas OTP kodas.', // by Claude Fable 5.1
	'Access denied.' => 'Prieiga uždrausta.', // by Claude Fable 5.1
	'JSON previews' => 'JSON peržiūros', // by Claude Fable 5.1
	'Data table' => 'Duomenų lentelė', // by Claude Fable 5.1
	'Edit form' => 'Redagavimo forma', // by Claude Fable 5.1
	'Ask %s' => 'Paklausti %s', // by Claude Fable 5.1
];
