<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ' ',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5/$3/$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'DD/MM/AAAA',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.
	'%s must return an array.' => '%s debe ser un array.',
	'%s and %s must return an object created by %s method.' => '%s y %s deben devolver un objeto creado mediante el método %s.',

	// Login.
	'System' => 'Motor de base de datos',
	'Server' => 'Servidor',
	'Username' => 'Usuario',
	'Password' => 'Contraseña',
	'Permanent login' => 'Mantener sesión iniciada',
	'Login' => 'Login',
	'Logout' => 'Cerrar sesión',
	'Logged as: %s' => 'Logueado como: %s',
	'Logout successful.' => 'Sesión finalizada con éxito.',
	'Invalid server or credentials.' => 'Servidor o credenciales no válidos.',
	'There is a space in the input password which might be the cause.' => 'Hay un espacio en la contraseña introducida, lo que puede ser la causa.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo no soporta el acceso a bases de datos sin contraseña, <a href="https://www.adminneo.org/password"%s>más informacion</a>.',
	'Database does not support password.' => 'La Base de Datos no soporta el uso de contraseña.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Demasiados intentos erróneos, intente de nuevo en %d minuto.',
		'Demasiados intentos erróneos, intente de nuevo en %d minutos.',
	],
	'Invalid permanent login, please login again.' => 'La sesión permanente no es válida, por favor inicia sesión de nuevo.',
	'Invalid CSRF token. Send the form again.' => 'Token CSRF inválido. Vuelva a enviar los datos del formulario.',
	'If you did not send this request from AdminNeo then close this page.' => 'Si no mandó ésta solicitud desde AdminNeo entonces cierre esta página.',
	'The action will be performed after successful login with the same credentials.' => 'La acción se realizará tras iniciar sesión de nuevo con las mismas credenciales.',

	// Connection.
	'No driver' => 'Sin driver',
	'Database driver not found.' => 'No se ha encontrado un driver para la base de datos.',
	'No extension' => 'No hay extensión',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Ninguna de las extensiones PHP soportadas (%s) está disponible.',
	'Connecting to privileged ports is not allowed.' => 'La conexion a puertos especiales no está permitida.',
	'Session support must be enabled.' => 'Deben estar habilitadas las sesiones.',
	'Session expired, please login again.' => 'Sesión caducada, por favor escriba su clave de nuevo.',
	'%s version: %s through PHP extension %s' => 'Versión %s: %s a través de la extensión de PHP %s',

	// Settings.
	'Language' => 'Idioma',

	'Home' => 'Inicio',
	'Refresh' => 'Actualizar',
	'Info' => 'Info',
	'More information.' => 'Más información.',

	// Privileges.
	'Privileges' => 'Privilegios',
	'Create user' => 'Crear Usuario',
	'User has been dropped.' => 'Usuario eliminado.',
	'User has been altered.' => 'Usuario modificado.',
	'User has been created.' => 'Usuario creado.',
	'Hashed' => 'Hash',

	// Server.
	'Process list' => 'Lista de procesos',
	'%d process(es) have been killed.' => [
		'%d proceso detenido.',
		'%d procesos detenidos.',
	],
	'Kill' => 'Detener',
	'Variables' => 'Variables',
	'Status' => 'Estado',

	// Structure.
	'Column' => 'Columna',
	'Routine' => 'Rutina',
	'Grant' => 'Conceder',
	'Revoke' => 'Impedir',

	// Queries.
	'SQL command' => 'Comando SQL',
	'HTTP request' => 'Petición HTTP',
	'%d query(s) executed OK.' => [
		'%d sentencia SQL ejecutada correctamente.',
		'%d sentencias SQL ejecutadas correctamente.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Consulta ejecutada, %d registro afectado.',
		'Consulta ejecutada, %d registros afectados.',
	],
	'No commands to execute.' => 'Ningún comando para ejecutar.',
	'Error in query' => 'Error al ejecutar consulta',
	'Unknown error.' => 'Error desconocido.',
	'Warnings' => 'Advertencias',
	'ATTACH queries are not supported.' => 'Consultas tipo ATTACH no soportadas.',
	'Execute' => 'Ejecutar',
	'Stop on error' => 'Detener en caso de error',
	'Show only errors' => 'Mostrar solamente errores',
	'Time' => 'Tiempo',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Historial',
	'Clear' => 'Limpiar',
	'Edit all' => 'Editar todos',

	// Import.
	'Import' => 'Importar',
	'File upload' => 'Importar archivo',
	'From server' => 'Desde servidor',
	'Webserver file %s' => 'Archivo de servidor web %s',
	'Run file' => 'Ejecutar Archivo',
	'File does not exist.' => 'Ese archivo no existe.',
	'File uploads are disabled.' => 'Importación de archivos deshablilitada.',
	'Unable to upload a file.' => 'No es posible cargar el archivo.',
	'Maximum allowed file size is %sB.' => 'El tamaño máximo de archivo es %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST data demasiado grande. Reduzca el tamaño o aumente la directiva de configuración %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Usted puede cargar un SQL grande mediante FTP e importarlo desde el servidor.',
	'File must be in UTF-8 encoding.' => 'El archivo tiene que ser codificacion UTF-8.',
	'You are offline.' => 'Usted no esta en linea.',
	'%d row(s) have been imported.' => [
		'%d registro importado.',
		'%d registros importados.',
	],

	// Export.
	'Export' => 'Exportar',
	'Output' => 'Salida',
	'open' => 'abrir',
	'save' => 'guardar',
	'Format' => 'Formato',
	'Data' => 'Datos',

	// Databases.
	'Database' => 'Base de datos',
	'DB' => 'BD',
	'Use' => 'Usar',
	'Invalid database.' => 'Base de datos incorrecta.',
	'Alter database' => 'Modificar Base de datos',
	'Create database' => 'Crear Base de datos',
	'Database schema' => 'Esquema de base de datos',
	'Permanent link' => 'Enlace permanente',
	'Database has been dropped.' => 'Base de datos eliminada.',
	'Databases have been dropped.' => 'Bases de datos eliminadas.',
	'Database has been created.' => 'Base de datos creada.',
	'Database has been renamed.' => 'Base de datos renombrada.',
	'Database has been altered.' => 'Base de datos modificada.',
	// SQLite errors.
	'File exists.' => 'Ese archivo ya existe.',
	'Please use one of the extensions %s.' => 'Por favor, use una de las extensiones %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Esquema',
	'Schemas' => 'Esquemas',
	'No schemas.' => 'Sin esquemas.',
	'Show schema' => 'Mostrar esquema',
	'Alter schema' => 'Modificar esquema',
	'Create schema' => 'Crear esquema',
	'Schema has been dropped.' => 'Esquema eliminado.',
	'Schema has been created.' => 'Esquema creado.',
	'Schema has been altered.' => 'Esquema modificado.',
	'Invalid schema.' => 'Esquema inválido.',

	// Table list.
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Codificación',
	'collation' => 'codificación',
	'Data Length' => 'Longitud de datos',
	'Index Length' => 'Longitud de índice',
	'Data Free' => 'Espacio libre',
	'Rows' => 'Registros',
	'%d in total' => '%d en total',
	'Analyze' => 'Analizar',
	'Optimize' => 'Optimizar',
	'Vacuum' => 'Vacio',
	'Check' => 'Comprobar',
	'Repair' => 'Reparar',
	'Truncate' => 'Vaciar',
	'Tables have been truncated.' => 'Las tablas han sido vaciadas.',
	'Move to other database' => 'Mover a otra base de datos',
	'Move' => 'Mover',
	'Tables have been moved.' => 'Se movieron las tablas.',
	'Copy' => 'Copiar',
	'Tables have been copied.' => 'Tablas copiadas.',
	'overwrite' => 'sobreescribir',

	// Tables.
	'Tables' => 'Tablas',
	'Tables and views' => 'Tablas y vistas',
	'Table' => 'Tabla',
	'No tables.' => 'No existen tablas.',
	'Alter table' => 'Modificar tabla',
	'Create table' => 'Crear tabla',
	'Table has been dropped.' => 'Tabla eliminada.',
	'Tables have been dropped.' => 'Tablas eliminadas.',
	'Tables have been optimized.' => 'Tablas optimizadas.',
	'Table has been altered.' => 'Tabla modificada.',
	'Table has been created.' => 'Tabla creada.',
	'Table name' => 'Nombre de la tabla',
	'Name' => 'Nombre',
	'Show structure' => 'Mostrar estructura',
	'Column name' => 'Nombre de columna',
	'Type' => 'Tipo',
	'Length' => 'Longitud',
	'Auto Increment' => 'Incremento automático',
	'Options' => 'Opciones',
	'Comment' => 'Comentario',
	'Default value' => 'Valor por defecto',
	'Drop' => 'Eliminar',
	'Drop %s?' => '¿Eliminar %s?',
	'Are you sure?' => '¿Está seguro?',
	'Size' => 'Tamaño',
	'Compute' => 'Procesar',
	'Move up' => 'Mover arriba',
	'Move down' => 'Mover abajo',
	'Remove' => 'Eliminar',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Excedida la cantidad máxima de campos permitidos. Por favor aumente %s.',

	// Views.
	'View' => 'Vista',
	'Materialized view' => 'Vista materializada',
	'View has been dropped.' => 'Vista eliminada.',
	'View has been altered.' => 'Vista modificada.',
	'View has been created.' => 'Vista creada.',
	'Alter view' => 'Modificar vista',
	'Create view' => 'Crear vista',

	// Partitions.
	'Partition by' => 'Particionar por',
	'Partition' => 'Partición',
	'Partitions' => 'Particiones',
	'Partition name' => 'Nombre de partición',
	'Values' => 'Valores',

	// Indexes.
	'Indexes' => 'Índices',
	'Indexes have been altered.' => 'Índices actualizados.',
	'Alter indexes' => 'Modificar índices',
	'Add next' => 'Agregar',
	'Index Type' => 'Tipo de índice',
	'length' => 'longitud',

	// Foreign keys.
	'Foreign keys' => 'Claves foráneas',
	'Foreign key' => 'Clave foránea',
	'Foreign key has been dropped.' => 'Clave foránea eliminada.',
	'Foreign key has been altered.' => 'Clave foránea modificada.',
	'Foreign key has been created.' => 'Clave foránea creada.',
	'Target table' => 'Tabla destino',
	'Change' => 'Modificar',
	'Source' => 'Origen',
	'Target' => 'Destino',
	'Add column' => 'Agregar columna',
	'Alter' => 'Modificar',
	'Add foreign key' => 'Agregar clave foránea',
	'ON DELETE' => 'AL BORRAR',
	'ON UPDATE' => 'AL ACTUALIZAR',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Las columnas de origen y destino deben ser del mismo tipo, debe existir un índice entre las columnas del destino y el registro referenciado debe existir también.',

	// Routines.
	'Routines' => 'Procedimientos',
	'Routine has been called, %d row(s) affected.' => [
		'Consulta ejecutada, %d registro afectado.',
		'Consulta ejecutada, %d registros afectados.',
	],
	'Call' => 'Llamar',
	'Parameter name' => 'Nombre de Parámetro',
	'Create procedure' => 'Crear procedimiento',
	'Create function' => 'Crear función',
	'Routine has been dropped.' => 'Procedimiento eliminado.',
	'Routine has been altered.' => 'Procedimiento modificado.',
	'Routine has been created.' => 'Procedimiento creado.',
	'Alter function' => 'Modificar función',
	'Alter procedure' => 'Modificar procedimiento',
	'Return type' => 'Tipo de valor de vuelta',

	// Events.
	'Events' => 'Eventos',
	'Event' => 'Evento',
	'Event has been dropped.' => 'Evento eliminado.',
	'Event has been altered.' => 'Evento modificado.',
	'Event has been created.' => 'Evento creado.',
	'Alter event' => 'Modificar Evento',
	'Create event' => 'Crear Evento',
	'At given time' => 'En el momento indicado',
	'Every' => 'Cada',
	'Schedule' => 'Agenda',
	'Start' => 'Inicio',
	'End' => 'Fin',
	'On completion preserve' => 'Al completar mantener',

	// Sequences (PostgreSQL).
	'Sequences' => 'Secuencias',
	'Create sequence' => 'Crear secuencias',
	'Sequence has been dropped.' => 'Secuencia eliminada.',
	'Sequence has been created.' => 'Secuencia creada.',
	'Sequence has been altered.' => 'Secuencia modificada.',
	'Alter sequence' => 'Modificar secuencia',

	// User types (PostgreSQL)
	'User types' => 'Tipos definidos por el usuario',
	'Create type' => 'Crear tipo',
	'Type has been dropped.' => 'Tipo eliminado.',
	'Type has been created.' => 'Tipo creado.',
	'Alter type' => 'Modificar tipo',

	// Triggers.
	'Triggers' => 'Disparadores',
	'Add trigger' => 'Agregar disparador',
	'Trigger has been dropped.' => 'Disparador eliminado.',
	'Trigger has been altered.' => 'Disparador modificado.',
	'Trigger has been created.' => 'Disparador creado.',
	'Alter trigger' => 'Modificar Disparador',
	'Create trigger' => 'Agregar Disparador',

	// Table check constraints.
	'Checks' => 'Chequeos',
	'Create check' => 'Crear chequeo',
	'Alter check' => 'Cambiar chequeo',
	'Check has been created.' => 'Chequeo creado.',
	'Check has been altered.' => 'Chequeo cambiado.',
	'Check has been dropped.' => 'Chequeo eliminado.',

	// Selection.
	'Select data' => 'Seleccionar datos',
	'Select' => 'Mostrar',
	'Functions' => 'Funciones',
	'Aggregation' => 'Agregados',
	'Search' => 'Condición',
	'anywhere' => 'donde sea',
	'Sort' => 'Ordenar',
	'descending' => 'descendiente',
	'Limit' => 'Limite',
	'Limit rows' => 'Limitar filas',
	'Text length' => 'Longitud de texto',
	'Action' => 'Acción',
	'Full table scan' => 'Escaneo total de la tabla',
	'Unable to select the table' => 'No es posible seleccionar la tabla',
	'Search data in tables' => 'Buscar datos en tablas',
	'as a regular expression' => 'como una expresión regular',
	'No rows.' => 'No existen registros.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d registro',
		'%d registros',
	],
	'Page' => 'Página',
	'last' => 'último',
	'Load more data' => 'Cargar más datos',
	'Loading' => 'Cargando',
	'Whole result' => 'Resultado completo',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection.
	'Modify' => 'Modificar',
	'Ctrl+click on a value to modify it.' => 'Ctrl+clic sobre el valor para editarlo.',
	'Use edit link to modify this value.' => 'Utilice el enlace de edición para realizar cambios.',

	// Editing.
	'New item' => 'Nuevo Registro',
	'Edit' => 'Modificar',
	'original' => 'original',
	// label for value '' in enum data type
	'empty' => 'ninguno',
	'Insert' => 'Insertar',
	'Save' => 'Guardar',
	'Save and continue edit' => 'Guardar y continuar editando',
	'Save and insert next' => 'Guardar e insertar siguiente',
	'Saving' => 'Guardando',
	'Selected' => 'Seleccionado',
	'Clone' => 'Clonar',
	'Delete' => 'Eliminar',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Registro%s insertado.',
	'Item has been deleted.' => 'Registro eliminado.',
	'Item has been updated.' => 'Registro modificado.',
	'%d item(s) have been affected.' => [
		'%d elemento afectado.',
		'%d elementos afectados.',
	],
	'You have no privileges to update this table.' => 'No tiene privilegios para actualizar esta tabla.',

	// Data type descriptions.
	'Numbers' => 'Números',
	'Date and time' => 'Fecha y hora',
	'Strings' => 'Cadena',
	'Binary' => 'Binario',
	'Lists' => 'Listas',
	'Network' => 'Red',
	'Geometry' => 'Geometría',
	'Relations' => 'Relaciones',

	// Editor - data values.
	'now' => 'ahora',
	'yes' => 'sí',
	'no' => 'no',

	// Settings.
	'Settings' => 'Ajustes',
	'Default' => 'Por defecto',
	'Color scheme' => 'Esquema de colores',
	'By system' => 'Desde el sistema',
	'Light' => 'Claro',
	'Dark' => 'Oscuro',
	'Navigation mode' => 'Modo de navegación',
	'Simple' => 'Simple',
	'Dual' => 'Dual',
	'Reversed' => 'Invertido',
	'Layout of main navigation with table links.' => 'Diseño de la navegación principal con enlaces de tabla.',
	'Table links' => 'Enlaces de tabla',
	'Primary action for all table links.' => 'Acción principal para todos los enlaces de tabla.',
	'Links to tables referencing the current row.' => 'Unir las tablas de referencia al registro actual',
	'Display' => 'Mostrar',
	'Hide' => 'Ocultar',
	'Records per page' => 'Registros por página',
	'Default number of records displayed in data table.' => 'Número predeterminado de registros mostrados en la tabla.',
	'Enum as select' => 'Enumerado como select',
	'Never' => 'Nunca',
	'Always' => 'Siempre',
	'More values than %d' => 'Valores mayores que %d',
	'Threshold for displaying a selection menu for enum fields.' => 'Límite para mostrar un menú de selección en campos de tipo \'enum\'.',

	// Plugins.
	'One Time Password' => 'Contraseña de un solo uso',
	'Enter OTP code.' => 'Introduce el código OTP.',
	'Invalid OTP code.' => 'Código OTP inválido.',
	'Access denied.' => 'Acceso denegado.',
	'JSON previews' => 'Previsualización de JSON',
	'Data table' => 'Tabla',
	'Edit form' => 'Editar formulario',
	// Use the phrases from https://gemini.google.com/
	'Ask Gemini' => 'Preguntar a Gemini',
	'Just a sec...' => 'Un segundo...',
];
