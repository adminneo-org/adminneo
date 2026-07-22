<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD/MM/AAAA', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s debe devolver un array.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s e %s deben devolver un obxecto creado polo método %s.', // by Claude Opus 5

	// Login
	'System' => 'Sistema',
	'Server' => 'Servidor',
	'Username' => 'Usuario',
	'Password' => 'Contrasinal',
	'Permanent login' => 'Permanecer conectado',
	'Login' => 'Conectar',
	'Logout' => 'Pechar sesión',
	'Logged as: %s' => 'Conectado como: %s',
	'Logout successful.' => 'Pechouse a sesión con éxito.',
	'hostname[:port] or :socket' => 'hostname[:port] ou :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Servidor ou credenciais incorrectos.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Hai un espazo no contrasinal introducido que podería ser a causa.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo non permite acceder a unha base de datos sen contrasinal, <a href="https://www.adminneo.org/password"%s>máis información</a>.', // by Claude Fable 5
	'Database does not support password.' => 'A base de datos non admite contrasinal.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Demasiados intentos de conexión, intentao de novo en %d minuto.',
		'Demasiados intentos de conexión, intentao de novo en %d minutos.',
	],
	'Invalid permanent login, please login again.' => 'Sesión permanente inválida, por favor acceda de novo.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Token CSRF inválido. Envíe de novo os datos do formulario.',
	'If you did not send this request from AdminNeo then close this page.' => 'Se non enviaches esta petición dende o AdminNeo entón pecha esta páxina.',
	'The action will be performed after successful login with the same credentials.' => 'A acción realizarase despois de iniciar sesión correctamente coas mesmas credenciais.', // by Claude Fable 5

	// Connection
	'No extension' => 'Non ten extensión',
	'None of the supported PHP extensions (%s) are available.' => 'Ningunha das extensións PHP soportadas (%s) está dispoñible.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Non se permite conectar a portos privilexiados.', // by Claude Fable 5
	'Session support must be enabled.' => 'As sesións deben estar habilitadas.',
	'Session expired, please login again.' => 'Caducou a sesión, por favor acceda de novo.',
	'%s version: %s through PHP extension %s' => 'Versión %s: %s a través da extensión de PHP %s',

	// Settings
	'Language' => 'Lingua',

	'Home' => 'Inicio', // by Claude Opus 5
	'Refresh' => 'Refrescar',
	'Info' => 'Info', // by Claude Opus 5
	'More information.' => 'Máis información.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Privilexios',
	'Create user' => 'Crear Usuario',
	'User has been dropped.' => 'Eliminouse o usuario.',
	'User has been altered.' => 'Modificouse o usuario.',
	'User has been created.' => 'Creouse o usuario.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Lista de procesos',
	'%d process(es) have been killed.' => [
		'%d proceso foi detido.',
		'%d procesos foron detidos.',
	],
	'Kill' => 'Deter',
	'Variables' => 'Variables',
	'Status' => 'Estado',

	// Structure
	'Column' => 'Columna',
	'Columns' => 'Columnas', // by Claude Fable 5
	'Routine' => 'Rutina',
	'Grant' => 'Conceder',
	'Revoke' => 'Revocar',

	// Queries
	'SQL command' => 'Comando SQL',
	'HTTP request' => 'Petición HTTP', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d consulta executada correctamente.',
		'%d consultas executadas correctamente.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Consulta executada, %d fila afectada.',
		'Consulta executada, %d filas afectadas.',
	],
	'No commands to execute.' => 'Non hai comandos para executar.',
	'Error in query' => 'Erro na consulta',
	'Unknown error.' => 'Erro descoñecido.', // by Claude Fable 5
	'Warnings' => 'Avisos', // by Claude Fable 5
	'%s queries are not supported.' => 'As consultas %s non son compatibles.', // by Claude Fable 5
	'Execute' => 'Executar',
	'Stop on error' => 'Parar en caso de erro',
	'Show only errors' => 'Amosar só erros',
	'Time' => 'Tempo',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Histórico',
	'Clear' => 'Baleirar',
	'Edit all' => 'Editar todo',

	// Import
	'Import' => 'Importar',
	'File upload' => 'Importar ficheiro',
	'From server' => 'Desde o servidor',
	'Webserver file %s' => 'Ficheiro de servidor web %s',
	'Run file' => 'Executar ficheiro',
	'File does not exist.' => 'O ficheiro non existe.',
	'File uploads are disabled.' => 'Importación de ficheiros deshabilitada.', // by Claude Opus 5
	'Unable to upload a file.' => 'Non é posible importar o ficheiro.',
	'Maximum allowed file size is %sB.' => 'O tamaño máximo de ficheiro permitido é de %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'O número máximo de ficheiros é %d. Seleccione menos ficheiros ou aumente a directiva de configuración %s.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'O tamaño total máximo dos ficheiros é de %s. Seleccione ficheiros máis pequenos ou aumente a directiva de configuración %s.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Datos POST demasiado grandes. Reduza os datos ou aumente a directiva de configuración %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Podes subir un ficheiro SQL de gran tamaño vía FTP e importalo dende o servidor.',
	'File must be in UTF-8 encoding.' => 'O ficheiro ten que estar codificado con UTF-8.',
	'You are offline.' => 'Non tes conexión.',
	'%d row(s) have been imported.' => [
		'%d fila importada.',
		'%d filas importadas.',
	],

	// Export
	'Export' => 'Exportar',
	'Output' => 'Saída', // by Claude Opus 5
	'open' => 'abrir',
	'save' => 'gardar',
	'Format' => 'Formato',
	'Data' => 'Datos',

	// Databases
	'Database' => 'Base de datos',
	'database' => 'base de datos', // by Claude Opus 5
	'DB' => 'BD', // by Claude Fable 5
	'Use' => 'Usar',
	'Invalid database.' => 'Base de datos incorrecta.',
	'Alter database' => 'Modificar Base de datos',
	'Create database' => 'Crear Base de datos',
	'Database schema' => 'Esquema de base de datos',
	'Permanent link' => 'Ligazón permanente',
	'Database has been dropped.' => 'Eliminouse a base de datos.',
	'Databases have been dropped.' => 'Elimináronse as bases de datos.',
	'Database has been created.' => 'Creouse a base de datos.',
	'Database has been renamed.' => 'Renomeouse a base de datos.',
	'Database has been altered.' => 'Modificouse a base de datos.',

	// SQLite errors
	'File exists.' => 'O ficheiro xa existe.',
	'Please use one of the extensions %s.' => 'Por favor use unha das extensións %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Esquema',
	'schema' => 'esquema', // by Claude Opus 5
	'Schemas' => 'Esquemas', // by Claude Opus 5
	'No schemas.' => 'Nengún esquema.', // by Claude Opus 5
	'Show schema' => 'Amosar esquema', // by Claude Opus 5
	'Alter schema' => 'Modificar esquema',
	'Create schema' => 'Crear esquema',
	'Schema has been dropped.' => 'Eliminouse o esquema.',
	'Schema has been created.' => 'Creouse o esquema.',
	'Schema has been altered.' => 'Modificouse o esquema.',
	'Invalid schema.' => 'Esquema inválido.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Xogo de caracteres (collation)',
	'collation' => 'xogo de caracteres (collation)',
	'Data Length' => 'Lonxitude de datos',
	'Index Length' => 'Lonxitude de índice',
	'Data Free' => 'Espazo dispoñible',
	'Rows' => 'Filas',
	'%d in total' => '%d en total',
	'Analyze' => 'Analizar',
	'Optimize' => 'Optimizar',
	'Vacuum' => 'Baleirar',
	'Check' => 'Comprobar',
	'Repair' => 'Reparar',
	'Truncate' => 'Baleirar',
	'Truncate Cascade' => 'Baleirar en cascada', // by Claude Fable 5
	'Tables have been truncated.' => 'Baleiráronse as táboas.',
	'Move to other database' => 'Mover a outra base de datos',
	'Move' => 'Mover',
	'Tables have been moved.' => 'Movéronse as táboas.',
	'Copy' => 'Copiar',
	'Tables have been copied.' => 'Copiáronse as táboas.',
	'overwrite' => 'sobrescribir', // by Claude Fable 5

	// Tables
	'Tables' => 'Táboas',
	'Tables and views' => 'táboas e vistas',
	'Table' => 'Táboa',
	'No tables.' => 'Nengunha táboa.',
	'Alter table' => 'Modificar táboa',
	'Create table' => 'Crear táboa',
	'Table has been dropped.' => 'Eliminouse a táboa.',
	'Tables have been dropped.' => 'Elimináronse as táboas.',
	'Tables have been optimized.' => 'Optimizáronse as táboas.',
	'Table has been altered.' => 'Modificouse a táboa.',
	'Table has been created.' => 'Creouse a táboa.',
	'Table name' => 'Nome da táboa',
	'Name' => 'Nome',
	'Show structure' => 'Amosar estructura',
	'Column name' => 'Nome da columna',
	'Type' => 'Tipo',
	'Length' => 'Lonxitude',
	'Auto Increment' => 'Incremento automático',
	'Options' => 'Opcións',
	'Comment' => 'Comentario',
	'Default value' => 'Valor por defecto',
	'Drop' => 'Eliminar',
	'Drop %s?' => 'Eliminar %s?', // by Claude Fable 5
	'Are you sure?' => 'Está seguro?',
	'Size' => 'Tamaño',
	'Compute' => 'Calcular',
	'Move up' => 'Mover arriba',
	'Move down' => 'Mover abaixo',
	'Remove' => 'Eliminar',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Excedida o número máximo de campos permitidos. Por favor aumente %s.',

	// Views
	'View' => 'Vista',
	'Materialized view' => 'Vista materializada',
	'View has been dropped.' => 'Eliminouse a vista.',
	'View has been altered.' => 'Modificouse a vista.',
	'View has been created.' => 'Creouse a vista.',
	'Alter view' => 'Modificar vista',
	'Create view' => 'Crear vista',

	// Partitions
	'Partition by' => 'Particionar por',
	'Partition' => 'Partición', // by Claude Opus 5
	'Partitions' => 'Particións',
	'Partition name' => 'Nome da Partición',
	'Values' => 'Valores',
	'Inherited tables' => 'Táboas herdadas', // by Claude Opus 5
	'Inherited from' => 'Herdada de', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Índices',
	'Indexes have been altered.' => 'Alteráronse os índices.',
	'Alter indexes' => 'Modificar índices',
	'Add next' => 'Engadir seguinte',
	'Index Type' => 'Tipo de índice',
	'length' => 'lonxitude',
	'operator class' => 'clase de operadores', // by Claude Fable 5
	'Algorithm' => 'Algoritmo', // by Claude Fable 5
	'Condition' => 'Condición', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Chaves externas',
	'Foreign key' => 'Chave externa',
	'Foreign key has been dropped.' => 'Eliminouse a chave externa.',
	'Foreign key has been altered.' => 'Modificouse a chave externa.',
	'Foreign key has been created.' => 'Creouse a chave externa.',
	'Target table' => 'táboa de destino',
	'Change' => 'Cambiar',
	'Source' => 'Orixe',
	'Target' => 'Destino',
	'Add column' => 'Engadir columna',
	'Alter' => 'Modificar',
	'Add foreign key' => 'Engadir chave externa',
	'ON DELETE' => 'AO BORRAR (ON DELETE)',
	'ON UPDATE' => 'AO ACTUALIZAR (ON UPDATE)',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'As columnas de orixe e destino deben ser do mesmo tipo, debe existir un índice nas columnas de destino e os datos referenciados deben existir.',

	// Routines
	'Routines' => 'Rutinas',
	'Routine has been called, %d row(s) affected.' => [
		'Chamouse á rutina, %d fila afectada.',
		'Chamouse á rutina, %d filas afectadas.',
	],
	'Call' => 'Chamar',
	'Parameter name' => 'Nome de Parámetro',
	'Create procedure' => 'Crear procedemento',
	'Create function' => 'Crear función',
	'Routine has been dropped.' => 'Eliminouse o procedemento.',
	'Routine has been altered.' => 'Alterouse o procedemento.',
	'Routine has been created.' => 'Creouse o procedemento.',
	'Alter function' => 'Modificar Función',
	'Alter procedure' => 'Modificar procedemento',
	'Return type' => 'Tipo de valor devolto',

	// Events
	'Events' => 'Eventos',
	'Event' => 'Evento',
	'Event has been dropped.' => 'Eliminouse o evento.',
	'Event has been altered.' => 'Modificouse o evento.',
	'Event has been created.' => 'Creouse o evento.',
	'Alter event' => 'Modificar Evento',
	'Create event' => 'Crear Evento',
	'At given time' => 'No tempo indicado',
	'Every' => 'Cada',
	'Schedule' => 'Axenda',
	'Start' => 'Inicio',
	'End' => 'Fin',
	'On completion preserve' => 'Ao completar manter',

	// Sequences (PostgreSQL)
	'Sequences' => 'Secuencias',
	'Create sequence' => 'Crear secuencias',
	'Sequence has been dropped.' => 'Eliminouse a secuencia.',
	'Sequence has been created.' => 'Creouse a secuencia.',
	'Sequence has been altered.' => 'Modificaouse a secuencia.',
	'Alter sequence' => 'Modificar secuencia',

	// User-defined types (PostgreSQL)
	'User types' => 'Tipos definidos polo usuario',
	'Create type' => 'Crear tipo',
	'Type has been dropped.' => 'Eliminouse o tipo.',
	'Type has been created.' => 'Creouse o tipo.',
	'Alter type' => 'Modificar tipo',

	// Triggers
	'Triggers' => 'Disparadores',
	'Add trigger' => 'Engadir disparador',
	'Trigger has been dropped.' => 'Eliminouse o disparador.',
	'Trigger has been altered.' => 'Modificouse o disparador.',
	'Trigger has been created.' => 'Creouse o disparador.',
	'Alter trigger' => 'Modificar Disparador',
	'Create trigger' => 'Crear Disparador',

	// Table check constraints
	'Checks' => 'Comprobacións', // by Claude Fable 5
	'Create check' => 'Crear comprobación', // by Claude Fable 5
	'Alter check' => 'Modificar comprobación', // by Claude Fable 5
	'Check has been created.' => 'Creouse a comprobación.', // by Claude Fable 5
	'Check has been altered.' => 'Modificouse a comprobación.', // by Claude Fable 5
	'Check has been dropped.' => 'Eliminouse a comprobación.', // by Claude Fable 5

	// Selection
	'Select data' => 'Seleccionar datos',
	'Select' => 'Seleccionar',
	'Functions' => 'Funcións',
	'Aggregation' => 'Agregados',
	'Search' => 'Buscar',
	'anywhere' => 'onde sexa',
	'Sort' => 'Ordenar',
	'descending' => 'descendente',
	'Limit' => 'Límite',
	'Limit rows' => 'Limitar filas',
	'Text length' => 'Lonxitude do texto', // by Claude Opus 5
	'Action' => 'Acción',
	'Full table scan' => 'Escaneo completo da táboa',
	'Unable to select the table' => 'Non é posible seleccionar a táboa', // by Claude Opus 5
	'Search data in tables' => 'Buscar datos en táboas',
	'No rows.' => 'Nengún resultado.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d fila',
		'%d filas',
	],
	'Page' => 'Páxina',
	'last' => 'último',
	'Load more data' => 'Cargar máis datos',
	'Loading' => 'Cargando',
	'Whole result' => 'Resultado completo',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Modificar',
	'Ctrl+click on a value to modify it.' => 'Ctrl+clic sobre o valor para editalo.',
	'Use edit link to modify this value.' => 'Use a ligazón de edición para modificar este valor.',

	// Editing
	'New item' => 'Novo elemento',
	'Edit' => 'Editar',
	'original' => 'orixinal',
	'empty' => 'baleiro', // label for value '' in enum data type
	'Insert' => 'Inserir',
	'Save' => 'Gardar',
	'Save and continue edit' => 'Gardar e seguir editando', // by Claude Opus 5
	'Save and insert next' => 'Guardar e inserir seguinte',
	'Saving' => 'Gardando',
	'Selected' => 'Selección',
	'Clone' => 'Clonar',
	'Delete' => 'Borrar',
	'Item%s has been inserted.' => 'Inseríuse o elemento%s.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Eliminouse o elemento.',
	'Item has been updated.' => 'Modificouse o elemento.',
	'%d item(s) have been affected.' => [
		'%d elemento afectado.',
		'%d elementos afectados.',
	],
	'You have no privileges to update this table.' => 'Non tes privilexios para actualizar esta táboa.',

	// Data type descriptions
	'Numbers' => 'Números',
	'Date and time' => 'Data e hora',
	'Strings' => 'Cadea',
	'Binary' => 'Binario',
	'Lists' => 'Listas',
	'Network' => 'Rede',
	'Geometry' => 'Xeometría',
	'Relations' => 'Relacións', // by Claude Opus 5

	// Editor - data values
	'now' => 'agora',
	'yes' => 'si',
	'no' => 'non',

	// Settings
	'Settings' => 'Configuración', // by Claude Opus 5
	'Default' => 'Predeterminado', // by Claude Opus 5
	'Color scheme' => 'Esquema de cores', // by Claude Opus 5
	'By system' => 'Segundo o sistema', // by Claude Opus 5
	'Light' => 'Claro', // by Claude Opus 5
	'Dark' => 'Escuro', // by Claude Opus 5
	'Navigation mode' => 'Modo de navegación', // by Claude Opus 5
	'Simple' => 'Simple', // by Claude Opus 5
	'Dual' => 'Dual', // by Claude Opus 5
	'Reversed' => 'Invertido', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Disposición da navegación principal coas ligazóns das táboas.', // by Claude Opus 5
	'Table links' => 'Ligazóns das táboas', // by Claude Opus 5
	'Primary action for all table links.' => 'Acción principal para todas as ligazóns das táboas.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Ligazóns ás táboas que referencian a fila actual.', // by Claude Opus 5
	'Display' => 'Amosar', // by Claude Opus 5
	'Hide' => 'Agochar', // by Claude Opus 5
	'Records per page' => 'Rexistros por páxina', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Número de rexistros amosados por defecto na táboa de datos.', // by Claude Opus 5
	'Enum as select' => 'Enum como selección', // by Claude Opus 5
	'Never' => 'Nunca', // by Claude Opus 5
	'Always' => 'Sempre', // by Claude Opus 5
	'More values than %d' => 'Máis de %d valores', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Límite para amosar un menú de selección nos campos enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Contrasinal de un só uso', // by Claude Opus 5
	'Enter OTP code.' => 'Introduza o código OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'Código OTP inválido.', // by Claude Opus 5
	'Access denied.' => 'Acceso denegado.', // by Claude Opus 5
	'JSON previews' => 'Vistas previas de JSON', // by Claude Opus 5
	'Data table' => 'Táboa de datos', // by Claude Opus 5
	'Edit form' => 'Formulario de edición', // by Claude Opus 5
	'Ask %s' => 'Preguntar a %s', // by Claude Opus 5
];
