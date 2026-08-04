<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5.$3.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD.MM.YYYY', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s trebuie să returneze un array.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s și %s trebuie să returneze un obiect creat prin metoda %s.', // by Claude Opus 5

	// Login
	'System' => 'Sistem',
	'Server' => 'Server',
	'Username' => 'Nume de utilizator',
	'Password' => 'Parola',
	'Permanent login' => 'Logare permanentă',
	'Login' => 'Intră',
	'Logout' => 'Ieșire',
	'Logged as: %s' => 'Ați intrat ca: %s',
	'Logout successful.' => 'Ați ieșit cu succes.',
	'hostname[:port] or :socket' => 'hostname[:port] sau :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Server sau date de autentificare incorecte.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Există un spațiu în parola introdusă, care ar putea fi cauza.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo nu acceptă accesul la o bază de date fără parolă, <a href="https://www.adminneo.org/password"%s>mai multe informații</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Baza de date nu acceptă parolă.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Prea multe autentificări nereușite, încercați din nou peste %d minut.',
		'Prea multe autentificări nereușite, încercați din nou peste %d minute.',
	], // by Claude Fable 5
	'Invalid permanent login, please login again.' => 'Logare permanentă incorectă, rog să vă conectați din nou.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'CSRF token imposibil. Retrimite forma.',
	'If you did not send this request from AdminNeo then close this page.' => 'Dacă nu ați trimis această cerere din AdminNeo, închideți această pagină.', // by Claude Fable 5
	'The action will be performed after successful login with the same credentials.' => 'Acțiunea va fi efectuată după autentificarea reușită cu aceleași date de autentificare.', // by Claude Fable 5

	// Connection
	'No driver' => 'Nu este driver', // by Claude Opus 5
	'Database driver not found.' => 'Driverul bazei de date nu a fost găsit.', // by Claude Opus 5
	'No extension' => 'Nu este extensie',
	'None of the supported PHP extensions (%s) are available.' => 'Nu este aviabilă nici o extensie suportată (%s).', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Conectarea la porturi privilegiate nu este permisă.', // by Claude Fable 5
	'Session support must be enabled.' => 'Sesiunile trebuie să fie pornite.',
	'Session expired, please login again.' => 'Timpul sesiunii a expirat, rog să vă conectați din nou.',
	'%s version: %s through PHP extension %s' => 'Versiunea %s: %s cu extensia PHP %s',

	// Settings
	'Language' => 'Limba',

	'Home' => 'Acasă', // by Claude Opus 5
	'Refresh' => 'Împrospătează',
	'Info' => 'Informații', // by Claude Opus 5
	'More information.' => 'Mai multe informații.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Privilegii',
	'Create user' => 'Crează utilizator',
	'User has been dropped.' => 'Utilizatorul a fost șters.',
	'User has been altered.' => 'Utilizatorul a fost modificat.',
	'User has been created.' => 'Utilizatorul a fost creat.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Lista proceselor',
	'%d process(es) have been killed.' => [
		'A fost terminat %d proces.',
		'Au fost terminate %d procese.',
	],
	'Kill' => 'Termină',
	'Variables' => 'Variabile',
	'Status' => 'Stare',

	// Structure
	'Column' => 'Coloană',
	'Columns' => 'Coloane', // by Claude Fable 5
	'Routine' => 'Procedură',
	'Grant' => 'Permite',
	'Revoke' => 'Interzice',

	// Queries
	'SQL command' => 'SQL query',
	'HTTP request' => 'Cerere HTTP', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d query executat.',
		'%d query-uri executate cu succes.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Query executat, %d înscriere modificată.',
		'Query executat, %d înscrieri modificate.',
	],
	'No commands to execute.' => 'Nu sunt comenzi de executat.',
	'Error in query' => 'Greșeală în query',
	'Unknown error.' => 'Eroare necunoscută.', // by Claude Fable 5
	'Warnings' => 'Avertismente', // by Claude Fable 5
	'%s queries are not supported.' => 'Interogările %s nu sunt acceptate.', // by Claude Fable 5
	'Execute' => 'Execută',
	'Stop on error' => 'Se oprește la greșeală',
	'Show only errors' => 'Arată doar greșeli',
	'Time' => 'Timp',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Istoria',
	'Clear' => 'Curăță',
	'Edit all' => 'Editează tot',

	// Import
	'Import' => 'Importă',
	'File upload' => 'Încarcă fișierul',
	'From server' => 'De pe server',
	'Webserver file %s' => 'Fișierul %s pe server',
	'Run file' => 'Execută fișier',
	'File does not exist.' => 'Acest fișier nu există.',
	'File uploads are disabled.' => 'Încărcarea fișierelor este interzisă.',
	'Unable to upload a file.' => 'Nu am putut încărca fișierul pe server.',
	'Maximum allowed file size is %sB.' => 'Fișierul maxim admis - %sO.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Numărul maxim de fișiere este %d. Alegeți mai puține fișiere sau măriți parametrul configurației directivei %s.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Mărimea totală maximă a fișierelor este %s. Alegeți fișiere mai mici sau măriți parametrul configurației directivei %s.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Mesajul POST este prea mare. Trimiteți mai puține date sau măriți parametrul configurației directivei %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Puteți încărca un fișier SQL mare prin FTP și să îl importați de pe server.', // by Claude Fable 5
	'File must be in UTF-8 encoding.' => 'Fișierul trebuie să fie codificat UTF-8.', // by Claude Fable 5
	'You are offline.' => 'Sunteți offline.', // by Claude Fable 5
	'%d row(s) have been imported.' => [
		'%d rînd importat.',
		'%d rînduri importate.',
	],

	// Export
	'Export' => 'Export',
	'Output' => 'Date de ieșire',
	'open' => 'deschide',
	'save' => 'salvează',
	'Format' => 'Format',
	'Data' => 'Date',

	// Databases
	'Database' => 'Baza de date',
	'database' => 'baza de date', // by Claude Opus 5
	'DB' => 'BD', // by Claude Fable 5
	'Use' => 'Alege',
	'Invalid database.' => 'Bază de date invalidă.', // by Claude Opus 5
	'Alter database' => 'Modifică baza de date',
	'Create database' => 'Crează baza de date',
	'Database schema' => 'Schema bazei de date',
	'Permanent link' => 'Adresă permanentă',
	'Database has been dropped.' => 'Baza de date a fost ștearsă.',
	'Databases have been dropped.' => 'Bazele de date au fost șterse.',
	'Database has been created.' => 'Baza de date a fost creată.',
	'Database has been renamed.' => 'Baza de date a fost redenumită.',
	'Database has been altered.' => 'Baza de date a fost modificată.',

	// SQLite errors
	'File exists.' => 'Fișierul există deja.',
	'Please use one of the extensions %s.' => 'Folosiți una din următoarele extensii %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Schema',
	'schema' => 'schema', // by Claude Opus 5
	'Schemas' => 'Scheme', // by Claude Opus 5
	'No schemas.' => 'Nu sunt scheme.', // by Claude Opus 5
	'Show schema' => 'Arată schema', // by Claude Opus 5
	'Alter schema' => 'Modifică schema',
	'Create schema' => 'Crează o schemă',
	'Schema has been dropped.' => 'Schema a fost ștearsă.',
	'Schema has been created.' => 'Schema a fost creată.',
	'Schema has been altered.' => 'Schema a fost modificată.',
	'Invalid schema.' => 'Schemă incorectă.',

	// Table list
	'Engine' => 'Tip',
	'engine' => 'tip',
	'Collation' => 'Colaționare',
	'collation' => 'colaționarea',
	'Data Length' => 'Cantitatea de date',
	'Index Length' => 'Cantitatea de indecși',
	'Data Free' => 'Spațiu liber',
	'Rows' => 'Înscrieri',
	'%d in total' => 'În total %d',
	'Analyze' => 'Analizează',
	'Optimize' => 'Optimizează',
	'Vacuum' => 'Curăță', // by Claude Fable 5
	'Check' => 'Controlează',
	'Repair' => 'Repară',
	'Truncate' => 'Curăță',
	'Tables have been truncated.' => 'Tabelele au fost curățate.',
	'Move to other database' => 'Mută în altă bază de date',
	'Move' => 'Mută',
	'Tables have been moved.' => 'Tabelele au fost mutate.',
	'Copy' => 'Copiază',
	'Tables have been copied.' => 'Tabelele au fost copiate.',
	'overwrite' => 'suprascrie', // by Claude Fable 5

	// Tables
	'Tables' => 'Tabele',
	'Tables and views' => 'Tabele și reprezentări',
	'Table' => 'Tabel',
	'No tables.' => 'În baza de date nu sunt tabele.',
	'Alter table' => 'Modifică tabelul',
	'Create table' => 'Crează tabel',
	'Table has been dropped.' => 'Tabelul a fost șters.',
	'Tables have been dropped.' => 'Tabelele au fost șterse.',
	'Tables have been optimized.' => 'Tabelele au fost optimizate.', // by Claude Fable 5
	'Table has been altered.' => 'Tabelul a fost modificat.',
	'Table has been created.' => 'Tabelul a fost creat.',
	'Table name' => 'Denumirea tabelului',
	'Name' => 'Titlu',
	'Show structure' => 'Arată structura',
	'Column name' => 'Denumirea coloanei',
	'Type' => 'Tip',
	'Length' => 'Lungime',
	'Auto Increment' => 'Creșterea automată',
	'Options' => 'Acțiune',
	'Comment' => 'Comentariu',
	'Default value' => 'Valoare implicită', // by Claude Fable 5
	'Drop' => 'Șterge',
	'Drop %s?' => 'Ștergeți %s?', // by Claude Fable 5
	'Are you sure?' => 'Sunteți sigur(ă)?',
	'Size' => 'Mărime', // by Claude Fable 5
	'Compute' => 'Calculează', // by Claude Fable 5
	'Move up' => 'Mișcă în sus',
	'Move down' => 'Mișcă în jos',
	'Remove' => 'Șterge',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Numărul maxim de înscrieri disponibile a fost atins. Majorați %s.',

	// Views
	'View' => 'Reprezentare',
	'Materialized view' => 'Reprezentare materializată', // by Claude Fable 5
	'View has been dropped.' => 'Reprezentarea a fost ștearsă.',
	'View has been altered.' => 'Reprezentarea a fost modificată.',
	'View has been created.' => 'Reprezentarea a fost creată.',
	'Alter view' => 'Modifică reprezentarea',
	'Create view' => 'Crează reprezentare',

	// Partitions
	'Partition by' => 'Împarte',
	'Partition' => 'Secțiune', // by Claude Opus 5
	'Partitions' => 'Secțiuni',
	'Partition name' => 'Denumirea secțiunii',
	'Values' => 'Parametru',
	'Inherited tables' => 'Tabele moștenite', // by Claude Opus 5
	'Inherited from' => 'Moștenit de la', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Indexuri',
	'Indexes have been altered.' => 'Indexurile au fost modificate.',
	'Alter indexes' => 'Modifică indexuri',
	'Add next' => 'Adaugă încă',
	'Index Type' => 'Tipul indexului',
	'length' => 'lungimea',
	'Algorithm' => 'Algoritm', // by Claude Fable 5
	'Condition' => 'Condiție', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Chei externe',
	'Foreign key' => 'Cheie externă',
	'Foreign key has been dropped.' => 'Cheia externă a fost ștearsă.',
	'Foreign key has been altered.' => 'Cheia externă a fost modificată.',
	'Foreign key has been created.' => 'Cheia externă a fost creată.',
	'Target table' => 'Tabela scop',
	'Change' => 'Modifică',
	'Source' => 'Sursă',
	'Target' => 'Scop',
	'Add column' => 'Adaugă coloană',
	'Alter' => 'Modifică',
	'Add foreign key' => 'Adaugă cheie externă',
	'ON DELETE' => 'La ștergere',
	'ON UPDATE' => 'La modificare',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Coloanele ar trebui să aibă aceleaşi tipuri de date, trebuie să existe date de referinţă și un index pe coloanela-ţintă.',

	// Routines
	'Routines' => 'Proceduri și funcții salvate',
	'Routine has been called, %d row(s) affected.' => [
		'A fost executată procedura, %d înscriere a fost modificată.',
		'A fost executată procedura, %d înscrieri au fost modificate.',
	],
	'Call' => 'Apelează',
	'Parameter name' => 'Numele parametrului',
	'Create procedure' => 'Crează procedură',
	'Create function' => 'Crează funcție',
	'Routine has been dropped.' => 'Procedura a fost ștearsă.',
	'Routine has been altered.' => 'Procedura a fost modificată.',
	'Routine has been created.' => 'Procedura a fost creată.',
	'Alter function' => 'Modifică funcția',
	'Alter procedure' => 'Modifică procedura',
	'Return type' => 'Tipul returnării',

	// Events
	'Events' => 'Evenimente',
	'Event' => 'Eveniment',
	'Event has been dropped.' => 'Evenimentul a fost șters.',
	'Event has been altered.' => 'Evenimentul a fost modificat.',
	'Event has been created.' => 'Evenimentul a fost adăugat.',
	'Alter event' => 'Modifică eveniment',
	'Create event' => 'Creează evenimet',
	'At given time' => 'În timpul curent',
	'Every' => 'Fiecare',
	'Schedule' => 'Program',
	'Start' => 'Început',
	'End' => 'Sfârșit',
	'On completion preserve' => 'Salvează după finisare',

	// Sequences (PostgreSQL)
	'Sequences' => '«Secvențe»',
	'Create sequence' => 'Crează «secvență»',
	'Sequence has been dropped.' => '«secvența» a fost ștearsă.',
	'Sequence has been created.' => '«secvența» a fost creată.',
	'Sequence has been altered.' => '«secvența» a fost modificată.',
	'Alter sequence' => 'Modifică «secvență»',

	// User types (PostgreSQL)
	'User types' => 'Tipuri definite de utilizator', // by Claude Fable 5
	'Create type' => 'Crează tip noi',
	'Type has been dropped.' => 'Tiipul a fost șters.',
	'Type has been created.' => 'Crează tip nou.',
	'Alter type' => 'Modifică tip',

	// Triggers
	'Triggers' => 'Declanșatoare',
	'Add trigger' => 'Adaugă trigger (declanșator)',
	'Trigger has been dropped.' => 'Triggerul a fost șters.',
	'Trigger has been altered.' => 'Triggerul a fost modificat.',
	'Trigger has been created.' => 'Triggerul a fost creat.',
	'Alter trigger' => 'Modifică trigger',
	'Create trigger' => 'Crează trigger',

	// Table check constraints
	'Checks' => 'Verificări', // by Claude Fable 5
	'Create check' => 'Crează verificare', // by Claude Fable 5
	'Alter check' => 'Modifică verificarea', // by Claude Fable 5
	'Check has been created.' => 'Verificarea a fost creată.', // by Claude Fable 5
	'Check has been altered.' => 'Verificarea a fost modificată.', // by Claude Fable 5
	'Check has been dropped.' => 'Verificarea a fost ștearsă.', // by Claude Fable 5

	// Selection
	'Select data' => 'Selectează',
	'Select' => 'Selectează',
	'Functions' => 'Funcții',
	'Aggregation' => 'Agregare',
	'Search' => 'Căutare',
	'anywhere' => 'oriunde',
	'Sort' => 'Sortare',
	'descending' => 'descrescător',
	'Limit' => 'Limit',
	'Limit rows' => 'Limită de rânduri', // by Claude Fable 5
	'Text length' => 'Lungimea textului',
	'Action' => 'Acțiune',
	'Full table scan' => 'Scanare completă a tabelului', // by Claude Fable 5
	'Unable to select the table' => 'Nu am putut selecta date din tabel',
	'Search data in tables' => 'Caută în tabele',
	'No rows.' => 'Nu sunt înscrieri.',
	'%d / ' => '%d / ', // by Claude Fable 5
	'%d row(s)' => [
		'%d înscriere',
		'%d înscrieri',
	],
	'Page' => 'Pagina',
	'last' => 'ultima',
	'Load more data' => 'Încarcă mai multe date', // by Claude Fable 5
	'Loading' => 'Se încarcă', // by Claude Fable 5
	'Whole result' => 'Tot rezultatul',
	'%d byte(s)' => [
		'%d octet',
		'%d octeți',
	],

	// In-place editing in selection
	'Modify' => 'Modifică', // by Claude Fable 5
	'Ctrl+click on a value to modify it.' => 'Ctrl+click pe o valoare pentru a o modifica.',
	'Use edit link to modify this value.' => 'Valoare poate fi modificată cu ajutorul butonului «modifică».',

	// Editing
	'New item' => 'Înscriere nouă',
	'Edit' => 'Editează',
	'original' => 'original',
	'empty' => 'gol', // label for value '' in enum data type
	'Insert' => 'Inserează',
	'Save' => 'Salvează',
	'Save and continue edit' => 'Salvează și continuă editarea',
	'Save and insert next' => 'Salvează și mai inserează',
	'Saving' => 'Se salvează', // by Claude Fable 5
	'Selected' => 'Selectate', // by Claude Fable 5
	'Clone' => 'Clonează',
	'Delete' => 'Șterge',
	'Item%s has been inserted.' => 'Înregistrarea%s a fost inserată.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Înregistrare a fost ștearsă.',
	'Item has been updated.' => 'Înregistrare a fost înnoită.',
	'%d item(s) have been affected.' => [
		'A fost modificată %d înscriere.',
		'Au fost modificate %d înscrieri.',
	],
	'You have no privileges to update this table.' => 'Nu aveți privilegii pentru a actualiza acest tabel.', // by Claude Fable 5

	// Data type descriptions
	'Numbers' => 'Număr',
	'Date and time' => 'Data și timpul',
	'Strings' => 'Șiruri de caractere',
	'Binary' => 'Tip binar',
	'Lists' => 'Liste',
	'Network' => 'Rețea',
	'Geometry' => 'Geometrie',
	'Relations' => 'Relații',

	// Editor - data values
	'now' => 'acum',
	'yes' => 'da', // by Claude Fable 5
	'no' => 'nu', // by Claude Fable 5

	// Settings
	'Settings' => 'Setări', // by Claude Opus 5
	'Default' => 'Implicit', // by Claude Opus 5
	'Color scheme' => 'Schema de culori', // by Claude Opus 5
	'By system' => 'După sistem', // by Claude Opus 5
	'Light' => 'Luminoasă', // by Claude Opus 5
	'Dark' => 'Întunecată', // by Claude Opus 5
	'Navigation mode' => 'Modul de navigare', // by Claude Opus 5
	'Simple' => 'Simplu', // by Claude Opus 5
	'Dual' => 'Dublu', // by Claude Opus 5
	'Reversed' => 'Inversat', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Aranjarea navigării principale cu adresele tabelelor.', // by Claude Opus 5
	'Table links' => 'Adresele tabelelor', // by Claude Opus 5
	'Primary action for all table links.' => 'Acțiunea principală pentru toate adresele tabelelor.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Adrese către tabelele care fac referire la înscrierea curentă.', // by Claude Opus 5
	'Display' => 'Arată', // by Claude Opus 5
	'Hide' => 'Ascunde', // by Claude Opus 5
	'Records per page' => 'Înscrieri pe pagină', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Numărul implicit de înscrieri arătate în tabelul de date.', // by Claude Opus 5
	'Enum as select' => 'Enum ca listă de selecție', // by Claude Opus 5
	'Never' => 'Niciodată', // by Claude Opus 5
	'Always' => 'Întotdeauna', // by Claude Opus 5
	'More values than %d' => 'Mai mult de %d valori', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Limita pentru afișarea unei liste de selecție la coloanele enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Parolă de unică folosință', // by Claude Opus 5
	'Enter OTP code.' => 'Introduceți codul OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'Cod OTP incorect.', // by Claude Opus 5
	'Access denied.' => 'Acces interzis.', // by Claude Opus 5
	'JSON previews' => 'Previzualizări JSON', // by Claude Opus 5
	'Data table' => 'Tabelul de date', // by Claude Opus 5
	'Edit form' => 'Forma de editare', // by Claude Opus 5
	'Ask %s' => 'Întreabă %s', // by Claude Opus 5
];
