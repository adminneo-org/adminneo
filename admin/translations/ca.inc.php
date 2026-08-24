<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD/MM/AAAA', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s ha de retornar un array.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s i %s han de retornar un objecte creat pel mètode %s.', // by Claude Opus 5

	// Login
	'System' => 'Sistema',
	'Server' => 'Servidor',
	'Username' => 'Nom d\'usuari',
	'Password' => 'Contrasenya',
	'Permanent login' => 'Sessió permanent',
	'Login' => 'Inicia la sessió',
	'Logout' => 'Desconnecta',
	'Logged as: %s' => 'Connectat com a: %s',
	'Logout successful.' => 'Desconnexió correcta.',
	'hostname[:port] or :socket' => 'hostname[:port] o :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Servidor o credencials invàlids.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Hi ha un espai a la contrasenya introduïda que en podria ser la causa.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo no permet accedir a una base de dades sense contrasenya, <a href="https://www.adminneo.org/password"%s>més informació</a>.', // by Claude Fable 5
	'Database does not support password.' => 'La base de dades no admet contrasenya.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Massa intents d\'inici de sessió fallits, torneu-ho a provar d\'aquí a %d minut.',
		'Massa intents d\'inici de sessió fallits, torneu-ho a provar d\'aquí a %d minuts.',
	], // by Claude Fable 5
	'Invalid permanent login, please login again.' => 'Sessió permanent invàlida, torna a iniciar-ne una.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Token CSRF invàlid. Torna a enviar el formulari.',
	'If you did not send this request from AdminNeo then close this page.' => 'Si no heu enviat aquesta sol·licitud des d\'AdminNeo, tanqueu aquesta pàgina.', // by Claude Fable 5
	'The action will be performed after successful login with the same credentials.' => 'L\'acció es durà a terme després d\'iniciar la sessió correctament amb les mateixes credencials.', // by Claude Fable 5

	// Connection
	'No extension' => 'Cap extensió',
	'None of the supported PHP extensions (%s) are available.' => 'No hi ha cap de les extensions PHP suportades (%s) disponible.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'No es permet connectar-se a ports privilegiats.', // by Claude Fable 5
	'Session support must be enabled.' => 'Cal que estigui permès l\'us de sessions.',
	'Session expired, please login again.' => 'La sessió ha expirat, torna a iniciar-ne una.',
	'%s version: %s through PHP extension %s' => 'Versió %s: %s amb l\'extensió de PHP %s',

	// Settings
	'Language' => 'Idioma',

	'Home' => 'Inici', // by Claude Opus 5
	'Refresh' => 'Refresca',
	'Info' => 'Info', // by Claude Opus 5
	'More information.' => 'Més informació.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Privilegis',
	'Create user' => 'Crea un usuari',
	'User has been dropped.' => 'S\'ha suprimit l\'usuari.',
	'User has been altered.' => 'S\'ha modificat l\'usuari.',
	'User has been created.' => 'S\'ha creat l\'usuari.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Llista de processos',
	'%d process(es) have been killed.' => [
		'S\'ha aturat %d procés.',
		'S\'han aturat %d processos.',
	],
	'Kill' => 'Atura',
	'Variables' => 'Variables',
	'Status' => 'Estat',

	// Structure
	'Column' => 'Columna',
	'Columns' => 'Columnes', // by Claude Fable 5
	'Routine' => 'Rutina',
	'Grant' => 'Grant',
	'Revoke' => 'Revoke',

	// Queries
	'SQL command' => 'Ordre SQL',
	'HTTP request' => 'Petició HTTP', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d consulta executada correctament.',
		'%d consultes executades correctament.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Consulta executada correctament, %d registre modificat.',
		'Consulta executada correctament, %d registres modificats.',
	],
	'No commands to execute.' => 'Cap comanda per executar.',
	'Error in query' => 'Error en la consulta',
	'Unknown error.' => 'Error desconegut.', // by Claude Fable 5
	'Warnings' => 'Avisos', // by Claude Fable 5
	'%s queries are not supported.' => 'Les consultes %s no són compatibles.', // by Claude Fable 5
	'Execute' => 'Executa',
	'Stop on error' => 'Atura en trobar un error',
	'Show only errors' => 'Mostra només els errors',
	'Time' => 'Temps',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Història',
	'Clear' => 'Suprimeix',
	'Edit all' => 'Edita-ho tot',

	// Import
	'Import' => 'Importa',
	'File upload' => 'Adjunta un fitxer',
	'From server' => 'En el servidor',
	'Webserver file %s' => 'Fitxer %s del servidor web',
	'Run file' => 'Executa el fitxer',
	'File does not exist.' => 'El fitxer no existeix.',
	'File uploads are disabled.' => 'La pujada de fitxers està desactivada.',
	'Unable to upload a file.' => 'Impossible adjuntar el fitxer.',
	'Maximum allowed file size is %sB.' => 'La mida màxima permesa del fitxer és de %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'El nombre màxim de fitxers és %d. Selecciona menys fitxers o incrementa la directiva de configuració %s.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'La mida total màxima dels fitxers és de %s. Selecciona fitxers més petits o incrementa la directiva de configuració %s.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Les dades POST són massa grans. Redueix les dades o incrementa la directiva de configuració %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Podeu pujar un fitxer SQL gran per FTP i importar-lo des del servidor.', // by Claude Fable 5
	'File must be in UTF-8 encoding.' => 'El fitxer ha d\'estar codificat en UTF-8.', // by Claude Fable 5
	'You are offline.' => 'Esteu fora de línia.', // by Claude Fable 5
	'%d row(s) have been imported.' => [
		'S\'ha importat %d registre.',
		'S\'han importat %d registres.',
	],

	// Export
	'Export' => 'Exporta',
	'Output' => 'Sortida',
	'open' => 'obre',
	'save' => 'desa',
	'Format' => 'Format',
	'Data' => 'Dades',

	// Databases
	'Database' => 'Base de dades',
	'database' => 'base de dades', // by Claude Opus 5
	'DB' => 'BD', // by Claude Fable 5
	'Use' => 'Utilitza',
	'Invalid database.' => 'Base de dades invàlida.',
	'Alter database' => 'Modifica la base de dades',
	'Create database' => 'Crea una base de dades',
	'Database schema' => 'Esquema de la base de dades',
	'Permanent link' => 'Enllaç permanent',
	'Database has been dropped.' => 'S\'ha suprimit la base de dades.',
	'Databases have been dropped.' => 'S\'han suprimit les bases de dades.',
	'Database has been created.' => 'S\'ha creat la base de dades.',
	'Database has been renamed.' => 'S\'ha canviat el nom de la base de dades.',
	'Database has been altered.' => 'S\'ha modificat la base de dades.',

	// SQLite errors
	'File exists.' => 'El fitxer ja existeix.',
	'Please use one of the extensions %s.' => 'Si us plau, utilitza una de les extensions %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Esquema',
	'schema' => 'esquema', // by Claude Opus 5
	'Schemas' => 'Esquemes', // by Claude Opus 5
	'No schemas.' => 'No hi ha cap esquema.', // by Claude Opus 5
	'Show schema' => 'Mostra l\'esquema', // by Claude Opus 5
	'Alter schema' => 'Modifica l\'esquema',
	'Create schema' => 'Crea un esquema',
	'Schema has been dropped.' => 'S\'ha suprimit l\'esquema.',
	'Schema has been created.' => 'S\'ha creat l\'esquema.',
	'Schema has been altered.' => 'S\'ha modificat l\'esquema.',
	'Invalid schema.' => 'Esquema invàlid.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Compaginació',
	'collation' => 'compaginació',
	'Data Length' => 'Longitud de les dades',
	'Index Length' => 'Longitud de l\'índex',
	'Data Free' => 'Espai lliure',
	'Rows' => 'Files',
	'%d in total' => '%d en total',
	'Analyze' => 'Analitza',
	'Optimize' => 'Optimitza',
	'Vacuum' => 'Neteja', // by Claude Fable 5
	'Check' => 'Verifica',
	'Repair' => 'Repara',
	'Truncate' => 'Escapça',
	'Truncate Cascade' => 'Escapça en cascada', // by Claude Fable 5
	'Tables have been truncated.' => 'S\'han escapçat les taules.',
	'Move to other database' => 'Desplaça a una altra base de dades',
	'Move' => 'Desplaça',
	'Tables have been moved.' => 'S\'han desplaçat les taules.',
	'Copy' => 'Còpia',
	'Tables have been copied.' => 'S\'han copiat les taules.',
	'overwrite' => 'sobreescriure', // by Claude Fable 5

	// Tables
	'Tables' => 'Taules',
	'Tables and views' => 'Taules i vistes',
	'Table' => 'Taula',
	'No tables.' => 'No hi ha cap taula.',
	'Alter table' => 'Modifica la taula',
	'Create table' => 'Crea una taula',
	'Table has been dropped.' => 'S\'ha suprimit la taula.',
	'Tables have been dropped.' => 'S\'han suprimit les taules.',
	'Tables have been optimized.' => 'S\'han optimitzat les taules.', // by Claude Fable 5
	'Table has been altered.' => 'S\'ha modificat la taula.',
	'Table has been created.' => 'S\'ha creat la taula.',
	'Table name' => 'Nom de la taula',
	'Name' => 'Nom',
	'Show structure' => 'Mostra l\'estructura',
	'Column name' => 'Nom de la columna',
	'Type' => 'Tipus',
	'Length' => 'Llargada',
	'Auto Increment' => 'Increment automàtic',
	'Options' => 'Opcions',
	'Comment' => 'Comentari',
	'Default value' => 'Valor per defecte', // by Claude Fable 5
	'Drop' => 'Suprimeix',
	'Drop %s?' => 'Voleu suprimir %s?', // by Claude Fable 5
	'Are you sure?' => 'Estàs segur?',
	'Size' => 'Mida', // by Claude Fable 5
	'Compute' => 'Calcula', // by Claude Fable 5
	'Move up' => 'Mou a dalt',
	'Move down' => 'Mou a baix',
	'Remove' => 'Suprimeix',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'S\'ha assolit el nombre màxim de camps. Incrementa %s.',

	// Views
	'View' => 'Vista',
	'Materialized view' => 'Vista materialitzada', // by Claude Fable 5
	'View has been dropped.' => 'S\'ha suprimit la vista.',
	'View has been altered.' => 'S\'ha modificat la vista.',
	'View has been created.' => 'S\'ha creat la vista.',
	'Alter view' => 'Modifica la vista',
	'Create view' => 'Crea una vista',

	// Partitions
	'Partition by' => 'Fes particions segons',
	'Partition' => 'Partició', // by Claude Opus 5
	'Partitions' => 'Particions',
	'Partition name' => 'Nom de la partició',
	'Values' => 'Valors',
	'Inherited tables' => 'Taules heretades', // by Claude Opus 5
	'Inherited from' => 'Heretada de', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Índexs',
	'Indexes have been altered.' => 'S\'han modificat els índex.',
	'Alter indexes' => 'Modifica els índex',
	'Add next' => 'Afegeix el següent',
	'Index Type' => 'Tipus d\'índex',
	'length' => 'longitud',
	'operator class' => 'classe d\'operadors', // by Claude Fable 5
	'Algorithm' => 'Algorisme', // by Claude Fable 5
	'Condition' => 'Condició', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Claus foranes',
	'Foreign key' => 'Clau forana',
	'Foreign key has been dropped.' => 'S\'ha suprimit la clau forana.',
	'Foreign key has been altered.' => 'S\'ha modificat la clau forana.',
	'Foreign key has been created.' => 'S\'ha creat la clau forana.',
	'Target table' => 'Taula de destinació',
	'Change' => 'Canvi',
	'Source' => 'Font',
	'Target' => 'Destí',
	'Add column' => 'Afegeix una columna',
	'Alter' => 'Modifica',
	'Add foreign key' => 'Afegeix una clau forana',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Les columnes d\'origen i de destinació han de ser del mateix tipus, la columna de destinació ha d\'estar indexada i les dades referenciades han d\'existir.',

	// Routines
	'Routines' => 'Rutines',
	'Routine has been called, %d row(s) affected.' => [
		'S\'ha cridat la rutina, %d registre modificat.',
		'S\'ha cridat la rutina, %d registres modificats.',
	],
	'Call' => 'Crida',
	'Parameter name' => 'Nom del paràmetre',
	'Create procedure' => 'Crea un procediment',
	'Create function' => 'Crea una funció',
	'Routine has been dropped.' => 'S\'ha suprimit la rutina.',
	'Routine has been altered.' => 'S\'ha modificat la rutina.',
	'Routine has been created.' => 'S\'ha creat la rutina.',
	'Alter function' => 'Modifica la funció',
	'Alter procedure' => 'Modifica el procediment',
	'Return type' => 'Tipus retornat',

	// Events
	'Events' => 'Events',
	'Event' => 'Event',
	'Event has been dropped.' => 'S\'ha suprimit l\'event.',
	'Event has been altered.' => 'S\'ha modificat l\'event.',
	'Event has been created.' => 'S\'ha creat l\'event.',
	'Alter event' => 'Modifica l\'event',
	'Create event' => 'Crea un event',
	'At given time' => 'A un moment donat',
	'Every' => 'Cada',
	'Schedule' => 'Horari',
	'Start' => 'Comença',
	'End' => 'Acaba',
	'On completion preserve' => 'Conservar en completar',

	// Sequences (PostgreSQL)
	'Sequences' => 'Seqüències',
	'Create sequence' => 'Crea una seqüència',
	'Sequence has been dropped.' => 'S\'ha suprimit la seqüència.',
	'Sequence has been created.' => 'S\'ha creat la seqüència.',
	'Sequence has been altered.' => 'S\'ha modificat la seqüència.',
	'Alter sequence' => 'Modifica la seqüència',

	// User-defined types (PostgreSQL)
	'User types' => 'Tipus de l\'usuari',
	'Create type' => 'Crea un tipus',
	'Type has been dropped.' => 'S\'ha suprimit el tipus.',
	'Type has been created.' => 'S\'ha creat el tipus.',
	'Alter type' => 'Modifica el tipus',

	// Triggers
	'Triggers' => 'Activadors',
	'Add trigger' => 'Afegeix un activador',
	'Trigger has been dropped.' => 'S\'ha suprimit l\'activador.',
	'Trigger has been altered.' => 'S\'ha modificat l\'activador.',
	'Trigger has been created.' => 'S\'ha creat l\'activador.',
	'Alter trigger' => 'Modifica l\'activador',
	'Create trigger' => 'Crea un activador',

	// Table check constraints
	'Checks' => 'Comprovacions', // by Claude Fable 5
	'Create check' => 'Crea una comprovació', // by Claude Fable 5
	'Alter check' => 'Modifica la comprovació', // by Claude Fable 5
	'Check has been created.' => 'S\'ha creat la comprovació.', // by Claude Fable 5
	'Check has been altered.' => 'S\'ha modificat la comprovació.', // by Claude Fable 5
	'Check has been dropped.' => 'S\'ha suprimit la comprovació.', // by Claude Fable 5

	// Selection
	'Select data' => 'Selecciona dades',
	'Select' => 'Selecciona',
	'Functions' => 'Funcions',
	'Aggregation' => 'Agregació',
	'Search' => 'Cerca',
	'anywhere' => 'a qualsevol lloc',
	'Sort' => 'Ordena',
	'descending' => 'descendent',
	'Limit' => 'Límit',
	'Limit rows' => 'Límit de registres', // by Claude Fable 5
	'Text length' => 'Longitud del text',
	'Action' => 'Acció',
	'Full table scan' => 'Escaneig complet de la taula', // by Claude Fable 5
	'Unable to select the table' => 'Impossible seleccionar la taula',
	'Search data in tables' => 'Cerca dades en les taules',
	'No rows.' => 'No hi ha cap registre.',
	'%d / ' => '%d / ', // by Claude Fable 5
	'%d row(s)' => [
		'%d registre',
		'%d registres',
	],
	'Page' => 'Plana',
	'last' => 'darrera',
	'Load more data' => 'Carrega més dades', // by Claude Fable 5
	'Loading' => 'S\'està carregant', // by Claude Fable 5
	'Whole result' => 'Tots els resultats',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Modifica', // by Claude Fable 5
	'Ctrl+click on a value to modify it.' => 'Fes un Ctrl+clic a un valor per modificar-lo.',
	'Use edit link to modify this value.' => 'Utilitza l\'enllaç d\'edició per modificar aquest valor.',

	// Editing
	'New item' => 'Nou element',
	'Edit' => 'Edita',
	'original' => 'original',
	'empty' => 'buit', // label for value '' in enum data type
	'Insert' => 'Insereix',
	'Save' => 'Desa',
	'Save and continue edit' => 'Desa i segueix editant',
	'Save and insert next' => 'Desa i insereix el següent',
	'Saving' => 'S\'està desant', // by Claude Fable 5
	'Selected' => 'Seleccionats', // by Claude Fable 5
	'Clone' => 'Clona',
	'Delete' => 'Suprimeix',
	'Item%s has been inserted.' => 'S\'ha insertat l\'element%s.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'S\'ha suprimit l\'element.',
	'Item has been updated.' => 'S\'ha actualitzat l\'element.',
	'%d item(s) have been affected.' => [
		'S\'ha modificat %d element.',
		'S\'han modificat %d elements.',
	],
	'You have no privileges to update this table.' => 'No teniu privilegis per actualitzar aquesta taula.', // by Claude Fable 5

	// Data type descriptions
	'Numbers' => 'Nombres',
	'Date and time' => 'Data i hora',
	'Strings' => 'Cadenes',
	'Binary' => 'Binari',
	'Lists' => 'Llistes',
	'Network' => 'Xarxa',
	'Geometry' => 'Geometria',
	'Relations' => 'Relacions',

	// Editor - data values
	'now' => 'ara',
	'yes' => 'sí', // by Claude Fable 5
	'no' => 'no', // by Claude Fable 5

	// Settings
	'Settings' => 'Configuració', // by Claude Opus 5
	'Default' => 'Per defecte', // by Claude Opus 5
	'Color scheme' => 'Esquema de colors', // by Claude Opus 5
	'By system' => 'Segons el sistema', // by Claude Opus 5
	'Light' => 'Clar', // by Claude Opus 5
	'Dark' => 'Fosc', // by Claude Opus 5
	'Navigation mode' => 'Mode de navegació', // by Claude Opus 5
	'Simple' => 'Simple', // by Claude Opus 5
	'Dual' => 'Dual', // by Claude Opus 5
	'Dual on hover' => 'Dual en passar el cursor', // by Claude Opus 5
	'Reversed' => 'Invertit', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Disposició de la navegació principal amb els enllaços de les taules.', // by Claude Opus 5
	'Table links' => 'Enllaços de les taules', // by Claude Opus 5
	'Primary action for all table links.' => 'Acció principal per a tots els enllaços de les taules.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Enllaços a les taules que referencien el registre actual.', // by Claude Opus 5
	'Display' => 'Mostra', // by Claude Opus 5
	'Hide' => 'Amaga', // by Claude Opus 5
	'Records per page' => 'Registres per plana', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Nombre de registres mostrats per defecte a la taula de dades.', // by Claude Opus 5
	'Enum as select' => 'Enum com a selecció', // by Claude Opus 5
	'Never' => 'Mai', // by Claude Opus 5
	'Always' => 'Sempre', // by Claude Opus 5
	'More values than %d' => 'Més de %d valors', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Llindar per mostrar un menú de selecció en els camps enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Contrasenya d\'un sol ús', // by Claude Opus 5
	'Enter OTP code.' => 'Introdueix el codi OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'Codi OTP invàlid.', // by Claude Opus 5
	'Access denied.' => 'Accés denegat.', // by Claude Opus 5
	'JSON previews' => 'Previsualitzacions JSON', // by Claude Opus 5
	'Data table' => 'Taula de dades', // by Claude Opus 5
	'Edit form' => 'Formulari d\'edició', // by Claude Opus 5
	'Ask %s' => 'Pregunta a %s', // by Claude Opus 5
];
