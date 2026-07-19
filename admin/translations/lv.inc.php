<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ' ',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5.$3.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'DD.MM.GGGG',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'Sistēma',
	'Server' => 'Serveris',
	'Username' => 'Lietotājs',
	'Password' => 'Parole',
	'Permanent login' => 'Atcerēties mani',
	'Login' => 'Ieiet',
	'Logout' => 'Iziet',
	'Logged as: %s' => 'Ielogojies kā: %s',
	'Logout successful.' => 'Jūs veiksmīgi izgājāt no sistēmas.',
	'There is a space in the input password which might be the cause.' => 'Parole satur atstarpi, kas varētu būt lieka.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo neatbalsta pieeju bez paroles, <a href="https://www.adminneo.org/password"%s>vairāk informācijas šeit</a>.',
	'Database does not support password.' => 'Datubāze neatbalsta paroli.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Pieteikšanās mēģinājumu skaits par lielu. Mēginiet pēc %d minūtes.',
		'Pieteikšanās mēģinājumu skaits par lielu. Mēginiet pēc %d minūtēm.',
		'Pieteikšanās mēģinājumu skaits par lielu. Mēginiet pēc %d minūtēm.',
	],
	'Invalid CSRF token. Send the form again.' => 'Nederīgs CSRF žetons. Nosūtiet formu vēl vienu reizi.',
	'If you did not send this request from AdminNeo then close this page.' => 'Ja nesūtījāt šo pieprasījumu no AdminNeo, tad aizveriet pārlūka logu.',
	'The action will be performed after successful login with the same credentials.' => 'Darbība tiks pabeigta pēc derīgas pieteikšanās sistēmā.',

	// Connection.
	'No extension' => 'Nav paplašinājuma',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Neviens PHP no atbalstītajiem paplašinājumiem (%s) nav pieejams.',
	'Connecting to privileged ports is not allowed.' => 'Pieeja priviliģētiem portiem nav atļauta.',
	'Session support must be enabled.' => 'Sesiju atbalstam jābūt ieslēgtam.',
	'Session expired, please login again.' => 'Sesijas laiks ir beidzies, piesakies no jauna sistēmā.',
	'%s version: %s through PHP extension %s' => 'Versija %s: %s ar PHP paplašinājumu %s',

	// Settings.
	'Language' => 'Valoda',

	'Refresh' => 'Atjaunot',

	// Privileges.
	'Privileges' => 'Tiesības',
	'Create user' => 'Izveidot lietotāju',
	'User has been dropped.' => 'Lietotājs dzests.',
	'User has been altered.' => 'Lietotājs izmainīts.',
	'User has been created.' => 'Lietotājs izveidots.',
	'Hashed' => 'Sajaukts',

	// Server.
	'Process list' => 'Procesu saraksts',
	'%d process(es) have been killed.' => [
		'Pabeigts %d process.',
		'Pabeigti %d procesi.',
		'Pabeigti %d procesi.',
	],
	'Kill' => 'Nobeigt',
	'Variables' => 'Mainīgie',
	'Status' => 'Statuss',

	// Structure.
	'Column' => 'Lauks',
	'Routine' => 'Procedūra',
	'Grant' => 'Atļaut',
	'Revoke' => 'Aizliegt',

	// Queries.
	'SQL command' => 'SQL pieprasījums',
	'%d query(s) executed OK.' => [
		'%d pieprasījums veiksmīgs.',
		'%d pieprasījumi veiksmīgi.',
		'%d pieprasījumi veiksmīgi.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Pieprasījums pabeigts, izmainīts %d ieraksts.',
		'Pieprasījums pabeigts, izmainīti %d ieraksti.',
		'Pieprasījums pabeigts, izmainīti %d ieraksti.',
	],
	'No commands to execute.' => 'Nav izpildāmu komandu.',
	'Error in query' => 'Kļūda pieprasījumā',
	'Unknown error.' => 'Nezināma kļūda.',
	'Warnings' => 'Brīdinājumi',
	'%s queries are not supported.' => '%s-pieprasījumi nav atbalstīti.',
	'Execute' => 'Izpidīt',
	'Stop on error' => 'Astāties kļūdas gadījumā',
	'Show only errors' => 'Rādīt tikai kļūdas',
	'Time' => 'Laiks',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Vēsture',
	'Clear' => 'Notīrīt',
	'Edit all' => 'Rediģēt visus',

	// Import.
	'Import' => 'Imports',
	'File upload' => 'Augšupielāde',
	'From server' => 'No servera',
	'Webserver file %s' => 'Fails %s uz servera',
	'Run file' => 'Izpildīt failu',
	'File does not exist.' => 'Fails neeksistē.',
	'File uploads are disabled.' => 'Augšupielādes aizliegtas.',
	'Unable to upload a file.' => 'Neizdevās ielādēt failu uz servera.',
	'Maximum allowed file size is %sB.' => 'Faila maksimālais izmērs — %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST metodes pieprasījums apjoms par lielu. Atsūtiet mazāka apjoma pieprasījumu kā konfigurācijas %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Varat ielādēt lielu SQL failu uz servera un tad importēt to.',
	'File must be in UTF-8 encoding.' => 'Failam jābūt UTF-8 kodējumam.',
	'You are offline.' => 'Jūs est bezsasaistē.',
	'%d row(s) have been imported.' => [
		'Importēta %d rinda.',
		'Importētas %d rindas.',
		'Importētas %d rindas.',
	],

	// Export.
	'Export' => 'Eksports',
	'Output' => 'Izejas dati',
	'open' => 'atvērt',
	'save' => 'saglabāt',
	'Format' => 'Formāts',
	'Data' => 'Dati',

	// Databases.
	'Database' => 'Datubāze',
	'DB' => 'DB',
	'Use' => 'Lietot',
	'Invalid database.' => 'Nederīga datubāze.',
	'Alter database' => 'Mainīt datubāzi',
	'Create database' => 'Izveidot datubāzi',
	'Database schema' => 'Datubāzes shēma',
	'Permanent link' => 'Pastāvīga saite',
	'Database has been dropped.' => 'Datubāze tika nodzēsta.',
	'Databases have been dropped.' => 'Datubāzes dzēstas.',
	'Database has been created.' => 'Datubāze tika izveidota.',
	'Database has been renamed.' => 'Datubāze tika pārsaukta.',
	'Database has been altered.' => 'Datubāze tika mainīta.',
	// SQLite errors.
	'File exists.' => 'Fails eksistē.',
	'Please use one of the extensions %s.' => 'Izmainojiet kādu no paplašinājumiem %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Shēma',
	'Alter schema' => 'Izmainīt shēmu',
	'Create schema' => 'Jauna shēma',
	'Schema has been dropped.' => 'Shēma dzēsta.',
	'Schema has been created.' => 'Izveidota jauna shēma.',
	'Schema has been altered.' => 'Shēma izmainīta.',
	'Invalid schema.' => 'Nederīga shēma.',

	// Table list.
	'Engine' => 'Dzinējs',
	'engine' => 'Tabulas tips',
	'Collation' => 'Kolācija',
	'collation' => 'Kolācija',
	'Data Length' => 'Datu apjoms',
	'Index Length' => 'Indeksu izmērs',
	'Data Free' => 'Brīvā vieta',
	'Rows' => 'Rindas',
	'%d in total' => 'Kopā %d',
	'Analyze' => 'Analizēt',
	'Optimize' => 'Optimizēt',
	'Vacuum' => 'Vakums',
	'Check' => 'Pārbaudīt',
	'Repair' => 'Salabot',
	'Truncate' => 'Iztīrīt',
	'Tables have been truncated.' => 'Tabulas iztīrītas.',
	'Move to other database' => 'Pārvietot uz citu datubāzi',
	'Move' => 'Pārvietot',
	'Tables have been moved.' => 'Tabulas pārvietotas.',
	'Copy' => 'kopēt',
	'Tables have been copied.' => 'Tabulas nokopētas.',
	'overwrite' => 'pārrakstīt',

	// Tables.
	'Tables' => 'Tabulas',
	'Tables and views' => 'Tabulas un skati',
	'Table' => 'Tabula',
	'No tables.' => 'Datubāzē nav tabulu.',
	'Alter table' => 'Mainīt tabulu',
	'Create table' => 'Izveidot tabulu',
	'Table has been dropped.' => 'Tabula dzēsta.',
	'Tables have been dropped.' => 'Tabulas dzēstas.',
	'Tables have been optimized.' => 'Tabulas optimizētas.',
	'Table has been altered.' => 'Tabula mainīta.',
	'Table has been created.' => 'Tabula izveidota.',
	'Table name' => 'Tabulas nosaukums',
	'Name' => 'Nosaukums',
	'Show structure' => 'Parādīt struktūru',
	'Column name' => 'Lauka nosaukums',
	'Type' => 'Tips',
	'Length' => 'Garums',
	'Auto Increment' => 'Auto inkrements',
	'Options' => 'Opcijas',
	'Comment' => 'Komentārs',
	'Default value' => 'Noklusētā vērtība',
	'Drop' => 'Dzēst',
	'Drop %s?' => 'Dzēst %s?',
	'Are you sure?' => 'Vai Tu esi pārliecināts?',
	'Size' => 'Izmērs',
	'Compute' => 'Izskaitļot',
	'Move up' => 'Pārvietot uz augšu',
	'Move down' => 'Pārvietot uz leju',
	'Remove' => 'Noņemt',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Sasniegts maksimālais lauku skaita ierobežojums. Palieliniet %s.',

	// Views.
	'View' => 'Skats',
	'Materialized view' => 'Matrializēts skats',
	'View has been dropped.' => 'Skats dzēsts.',
	'View has been altered.' => 'Skats izmainīts.',
	'View has been created.' => 'Skats izveidots.',
	'Alter view' => 'Izmainīt skatu',
	'Create view' => 'Izveidot skatu',

	// Partitions.
	'Partition by' => 'Sadalīt pēc',
	'Partitions' => 'Partīcijas',
	'Partition name' => 'Partīcijas nosaukums',
	'Values' => 'Vērtības',

	// Indexes.
	'Indexes' => 'Indeksi',
	'Indexes have been altered.' => 'Indeksi mainīti.',
	'Alter indexes' => 'Izmainīt indeksus',
	'Add next' => 'Pievienot vēl',
	'Index Type' => 'Indeksa tips',
	'length' => 'garums',

	// Foreign keys.
	'Foreign keys' => 'Ārejā atslēgas',
	'Foreign key' => 'Ārejā atslēga',
	'Foreign key has been dropped.' => 'Ārejā atslēga dzēsta.',
	'Foreign key has been altered.' => 'Ārejā atslēga izmainīta.',
	'Foreign key has been created.' => 'Ārejā atslēga izveidota.',
	'Target table' => 'Mērķa tabula',
	'Change' => 'Mainīt',
	'Source' => 'Avots',
	'Target' => 'Mērķis',
	'Add column' => 'Pievienot lauku',
	'Alter' => 'Izmainīt',
	'Add foreign key' => 'Pievienot ārējo atslēgu',
	'ON DELETE' => 'Pie dzēšanas',
	'ON UPDATE' => 'Pie atjaunošanas',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Lauku tipiem jābūt vienādiem, rezultējošā laukā jābut indeksa datiem.',

	// Routines.
	'Routines' => 'Procedūras un funkcijas',
	'Routine has been called, %d row(s) affected.' => [
		'Procedūra izsaukta, izmainīts %d ieraksts.',
		'Procedūra izsaukta, izmainīti %d ieraksti.',
		'Procedūra izsaukta, izmainīti %d ieraksti.',
	],
	'Call' => 'Izsaukt',
	'Parameter name' => 'Parametra nosaukums',
	'Create procedure' => 'Izveidot procedūru',
	'Create function' => 'Izveidot funkciju',
	'Routine has been dropped.' => 'Procedūru dzēsta.',
	'Routine has been altered.' => 'Procedūru izmainīta.',
	'Routine has been created.' => 'Procedūru izveidota.',
	'Alter function' => 'Mainīt funkciju',
	'Alter procedure' => 'Mainīt procedūru',
	'Return type' => 'Atgriezt tips',

	// Events.
	'Events' => 'Notikumi',
	'Event' => 'Notikums',
	'Event has been dropped.' => 'Notikums dzēsts.',
	'Event has been altered.' => 'Notikums izmainīts.',
	'Event has been created.' => 'Notikums izveidots.',
	'Alter event' => 'Izmainīt notikumu',
	'Create event' => 'Izveidot notikumu',
	'At given time' => 'Norāditā laikā',
	'Every' => 'Katru',
	'Schedule' => 'Grafiks',
	'Start' => 'Sākums',
	'End' => 'Beigas',
	'On completion preserve' => 'Beigās saglabāt',

	// Sequences (PostgreSQL).
	'Sequences' => 'Virknes',
	'Create sequence' => 'Izveidot virkni',
	'Sequence has been dropped.' => 'Virkne dzēsta.',
	'Sequence has been created.' => 'Izveidota virkne.',
	'Sequence has been altered.' => 'Virkne izmainīta.',
	'Alter sequence' => 'Izmainīt virkni',

	// User types (PostgreSQL)
	'User types' => 'Lietotāju tipi',
	'Create type' => 'Izveidot tipu',
	'Type has been dropped.' => 'Tips dzēsts.',
	'Type has been created.' => 'Tips izveidots.',
	'Alter type' => 'Izmainīt tipu',

	// Triggers.
	'Triggers' => 'Trigeri',
	'Add trigger' => 'Pievienot trigeri',
	'Trigger has been dropped.' => 'Trigeris dzēsts.',
	'Trigger has been altered.' => 'Trigeris izmainīts.',
	'Trigger has been created.' => 'Trigeris izveidots.',
	'Alter trigger' => 'Izmainīt trigeri',
	'Create trigger' => 'Izveidot trigeri',

	// Table check constraints.

	// Selection.
	'Select data' => 'Izvēlēties datus',
	'Select' => 'Izvēlēties',
	'Functions' => 'Funkcijas',
	'Aggregation' => 'Agregācija',
	'Search' => 'Meklēšana',
	'anywhere' => 'jebkurā vietā',
	'Sort' => 'Kārtošana',
	'descending' => 'dilstoši',
	'Limit' => 'Limits',
	'Limit rows' => 'Rindu limits',
	'Text length' => 'Teksta garums',
	'Action' => 'Darbība',
	'Full table scan' => 'Pilna tabulas analīze',
	'Unable to select the table' => 'Tabula nav pieejama',
	'Search data in tables' => 'Meklēt tabulās',
	'No rows.' => 'Nav rindu.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d rinda',
		'%d rindas',
		'%d rindu',
	],
	'Page' => 'Lapa',
	'last' => 'pēdējā',
	'Load more data' => 'Ielādēt vēl datus',
	'Loading' => 'Ielāde',
	'Whole result' => 'Viss rezultāts',
	'%d byte(s)' => [
		'%d baits',
		'%d baiti',
		'%d baiti',
	],

	// In-place editing in selection.
	'Modify' => 'Izmainīt',
	'Ctrl+click on a value to modify it.' => 'Lai izmainītu vērtību, izmanto Ctrl + peles klikšķi.',
	'Use edit link to modify this value.' => 'Izmainīt vērtību var tikai ar saiti \'Izmainīt\'.',

	// Editing.
	'New item' => 'Jauns ieraksts',
	'Edit' => 'Rediģēt',
	'original' => 'oriģināls',
	// label for value '' in enum data type
	'empty' => 'tukšs',
	'Insert' => 'Ievietot',
	'Save' => 'Saglabāt',
	'Save and continue edit' => 'Saglabāt un turpināt rediģēt',
	'Save and insert next' => 'Saglabāt un ievietot nākamo',
	'Saving' => 'Saglabāšana',
	'Selected' => 'Izvēlētie',
	'Clone' => 'Klonēt',
	'Delete' => 'Dzēst',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Ieraksti%s tika ievietoti.',
	'Item has been deleted.' => 'Ieraksts dzests.',
	'Item has been updated.' => 'Ieraksts atjaunots.',
	'%d item(s) have been affected.' => [
		'Izmainīts %d ieraksts.',
		'Izmainīti %d ieraksti.',
		'Izmainīti %d ieraksti.',
	],
	'You have no privileges to update this table.' => 'Jums nav pieejas labot šo tabulu.',

	// Data type descriptions.
	'Numbers' => 'Skaitļi',
	'Date and time' => 'Datums un laiks',
	'Strings' => 'Virknes',
	'Binary' => 'Binārie',
	'Lists' => 'Saraksti',
	'Network' => 'Tīkls',
	'Geometry' => 'Ģeometrija',
	'Relations' => 'Relācijas',

	// Editor - data values.
	'now' => 'tagad',
	'yes' => 'jā',
	'no' => 'nē',

	// Plugins.
];
