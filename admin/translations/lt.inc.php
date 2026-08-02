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
	'Invalid CSRF token. Send the form again.' => 'Neteisingas CSRF tokenas. Bandykite siųsti formos duomenis dar kartą.',

	// Connection
	'No extension' => 'Nėra plėtiio',
	'None of the supported PHP extensions (%s) are available.' => 'Nėra nei vieno iš palaikomų PHP plėtinių (%s).', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'Sesijų palaikymas turi būti įjungtas.',
	'Session expired, please login again.' => 'Sesijos galiojimas baigėsi. Prisijunkite iš naujo.',
	'%s version: %s through PHP extension %s' => '%s versija: %s per PHP plėtinį %s',

	// Settings
	'Language' => 'Kalba',

	'Refresh' => 'Atnaujinti',

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
	'Routine' => 'Procedūra',
	'Grant' => 'Suteikti',
	'Revoke' => 'Atšaukti',

	// Queries
	'SQL command' => 'SQL užklausa',
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
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Per daug POST duomenų. Sumažinkite duomenų kiekį arba padidinkite konfigūracijos nustatymą %s.',
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
	'Alter schema' => 'Keisti schemą',
	'Create schema' => 'Sukurti schemą',
	'Schema has been dropped.' => 'Schema pašalinta.',
	'Schema has been created.' => 'Schema sukurta.',
	'Schema has been altered.' => 'Schema pakeista.',
	'Invalid schema.' => 'Neteisinga schema.',

	// Table list
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
	'Check' => 'Patikrinti',
	'Repair' => 'Pataisyti',
	'Truncate' => 'Tuštinti',
	'Tables have been truncated.' => 'Lentelės buvo ištuštintos.',
	'Move to other database' => 'Perkelti į kitą duomenų bazę',
	'Move' => 'Perkelti',
	'Tables have been moved.' => 'Lentelės perkeltos.',
	'Copy' => 'Kopijuoti',
	'Tables have been copied.' => 'Lentelės nukopijuotos.',

	// Tables
	'Tables' => 'Lentelės',
	'Tables and views' => 'Lentelės ir vaizdai',
	'Table' => 'Lentelė',
	'No tables.' => 'Nėra lentelių.',
	'Alter table' => 'Redaguoti lentelę',
	'Create table' => 'Sukurti lentelę',
	'Table has been dropped.' => 'Lentelė pašalinta.',
	'Tables have been dropped.' => 'Lentelės pašalintos.',
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
	'Drop' => 'Pašalinti',
	'Are you sure?' => 'Tikrai?',
	'Move up' => 'Perkelti į viršų',
	'Move down' => 'Perkelti žemyn',
	'Remove' => 'Pašalinti',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Viršytas maksimalus leidžiamų stulpelių kiekis. Padidinkite %s.',

	// Views
	'View' => 'Vaizdas',
	'View has been dropped.' => 'Vaizdas pašalintas.',
	'View has been altered.' => 'Vaizdas pakeistas.',
	'View has been created.' => 'Vaizdas sukurtas.',
	'Alter view' => 'Redaguoti vaizdą',
	'Create view' => 'Sukurti vaizdą',

	// Partitions
	'Partition by' => 'Skirstyti pagal',
	'Partitions' => 'Skirsniai',
	'Partition name' => 'Skirsnio pavadinimas',
	'Values' => 'Reikšmės',

	// Indexes
	'Indexes' => 'Indeksai',
	'Indexes have been altered.' => 'Indeksai pakeisti.',
	'Alter indexes' => 'Redaguoti indeksus',
	'Add next' => 'Pridėti kitą',
	'Index Type' => 'Indekso tipas',
	'length' => 'ilgis',

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

	// User types (PostgreSQL)
	'User types' => 'Vartotojų tipai',
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
	'Text length' => 'Teksto ilgis',
	'Action' => 'Veiksmas',
	'Unable to select the table' => 'Neįmanoma atrinkti lentelės',
	'Search data in tables' => 'Ieškoti duomenų lentelėse',
	'No rows.' => 'Nėra įrašų.',
	'%d row(s)' => [
		'%d įrašas',
		'%d įrašai',
		'%d įrašų',
	],
	'Page' => 'Puslapis',
	'last' => 'paskutinis',
	'Whole result' => 'Visas rezultatas',
	'%d byte(s)' => [
		'%d baitas',
		'%d baigai',
		'%d baitų',
	],

	// In-place editing in selection
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

	// Settings

	// Plugins
];
