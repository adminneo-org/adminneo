<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD/MM/AAAA', // hint for date format - use language equivalents for day, month and year shortcuts

	// Bootstrap

	// Login
	'System' => 'Motor de Base de dados',
	'Server' => 'Servidor',
	'Username' => 'Nome de utilizador',
	'Password' => 'Senha',
	'Permanent login' => 'Memorizar a senha',
	'Login' => 'Entrar',
	'Logout' => 'Terminar sessão',
	'Logged as: %s' => 'Ligado como: %s',
	'Logout successful.' => 'Sessão terminada com sucesso.',
	'Invalid CSRF token. Send the form again.' => 'Token CSRF inválido. Enviar o formulario novamente.',

	// Connection
	'No extension' => 'Não há extensão',
	'None of the supported PHP extensions (%s) are available.' => 'Nenhuma das extensões PHP suportadas (%s) está disponivel.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'As sessões devem estar ativas.',
	'Session expired, please login again.' => 'Sessão expirada, por favor entre de novo.',
	'%s version: %s through PHP extension %s' => 'Versão %s: %s através da extensão PHP %s',

	// Settings
	'Language' => 'Idioma',

	'Refresh' => 'Atualizar',

	// Privileges
	'Privileges' => 'Privilégios',
	'Create user' => 'Criar utilizador',
	'User has been dropped.' => 'Utilizador eliminado.',
	'User has been altered.' => 'Utilizador modificado.',
	'User has been created.' => 'Utilizador criado.',
	'Hashed' => 'Hash',

	// Server
	'Process list' => 'Lista de processos',
	'%d process(es) have been killed.' => [
		'%d processo terminado.',
		'%d processos terminados.',
	],
	'Kill' => 'Parar',
	'Variables' => 'Variáveis',
	'Status' => 'Estado',

	// Structure
	'Column' => 'Coluna',
	'Routine' => 'Rotina',
	'Grant' => 'Conceder',
	'Revoke' => 'Impedir',

	// Queries
	'SQL command' => 'Comando SQL',
	'%d query(s) executed OK.' => [
		'%d consulta sql executada corretamente.',
		'%d consultas sql executadas corretamente.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Consulta executada, %d registo afetado.',
		'Consulta executada, %d registos afetados.',
	],
	'No commands to execute.' => 'Nenhum comando para executar.',
	'Error in query' => 'Erro na consulta',
	'Execute' => 'Executar',
	'Stop on error' => 'Parar em caso de erro',
	'Show only errors' => 'Mostrar somente erros',
	'Time' => 'Tempo',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Histórico',
	'Clear' => 'Limpar',

	// Import
	'Import' => 'Importar',
	'File upload' => 'Importar ficheiro',
	'From server' => 'Do servidor',
	'Webserver file %s' => 'Ficheiro do servidor web %s',
	'Run file' => 'Executar ficheiro',
	'File does not exist.' => 'Ficheiro não existe.',
	'File uploads are disabled.' => 'Importação de ficheiros desativada.',
	'Unable to upload a file.' => 'Não é possível enviar o ficheiro.',
	'Maximum allowed file size is %sB.' => 'Tamanho máximo do ficheiro é %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST data demasiado grande. Reduza o tamanho ou aumente a diretiva de configuração %s.',
	'%d row(s) have been imported.' => [
		'%d registo importado.',
		'%d registos importados.',
	],

	// Export
	'Export' => 'Exportar',
	'Output' => 'Saída',
	'open' => 'abrir',
	'save' => 'guardar',
	'Format' => 'Formato',
	'Data' => 'Dados',

	// Databases
	'Database' => 'Base de dados',
	'Use' => 'Usar',
	'Invalid database.' => 'Base de dados inválida.',
	'Alter database' => 'Modificar Base de dados',
	'Create database' => 'Criar Base de dados',
	'Database schema' => 'Esquema de Base de dados',
	'Database has been dropped.' => 'Base de dados eliminada.',
	'Databases have been dropped.' => 'Bases de dados eliminadas.',
	'Database has been created.' => 'Base de dados criada.',
	'Database has been renamed.' => 'Base de dados renomeada.',
	'Database has been altered.' => 'Base de dados modificada.',

	// SQLite errors
	'File exists.' => 'Ficheiro já existe.',
	'Please use one of the extensions %s.' => 'Por favor use uma das extensões %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Esquema',
	'Alter schema' => 'Modificar esquema',
	'Create schema' => 'Criar esquema',
	'Schema has been dropped.' => 'Esquema eliminado.',
	'Schema has been created.' => 'Esquema criado.',
	'Schema has been altered.' => 'Esquema modificado.',
	'Invalid schema.' => 'Esquema inválido.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Colação',
	'collation' => 'collation',
	'Data Length' => 'Tamanho de dados',
	'Index Length' => 'Tamanho de índice',
	'Data Free' => 'Espaço Livre',
	'Rows' => 'Registos',
	'%d in total' => '%d no total',
	'Analyze' => 'Analizar',
	'Optimize' => 'Otimizar',
	'Check' => 'Verificar',
	'Repair' => 'Reparar',
	'Truncate' => 'Truncar',
	'Tables have been truncated.' => 'Tabelas truncadas (truncate).',
	'Move to other database' => 'Mover outra Base de dados',
	'Move' => 'Mover',
	'Tables have been moved.' => 'As Tabelas foram movidas.',

	// Tables
	'Tables' => 'Tabelas',
	'Tables and views' => 'Tabelas e vistas',
	'Table' => 'Tabela',
	'No tables.' => 'Não existem tabelas.',
	'Alter table' => 'Modificar estrutura',
	'Create table' => 'Criar tabela',
	'Table has been dropped.' => 'Tabela eliminada.',
	'Tables have been dropped.' => 'As tabelas foram eliminadas.',
	'Table has been altered.' => 'Tabela modificada.',
	'Table has been created.' => 'Tabela criada.',
	'Table name' => 'Nome da tabela',
	'Name' => 'Nome',
	'Show structure' => 'Mostrar estrutura',
	'Column name' => 'Nome da coluna',
	'Type' => 'Tipo',
	'Length' => 'Tamanho',
	'Auto Increment' => 'Incremento Automático',
	'Options' => 'Opções',
	'Comment' => 'Comentário',
	'Drop' => 'Remover',
	'Are you sure?' => 'Tem a certeza?',
	'Move up' => 'Mover para cima',
	'Move down' => 'Mover para baixo',
	'Remove' => 'Remover',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Quantidade máxima de campos permitidos excedidos. Por favor aumente %s.',

	// Views
	'View' => 'Visualizar',
	'View has been dropped.' => 'Vista eliminada.',
	'View has been altered.' => 'Vista modificada.',
	'View has been created.' => 'Vista criada.',
	'Alter view' => 'Modificar vista',
	'Create view' => 'Criar vista',

	// Partitions
	'Partition by' => 'Particionar por',
	'Partitions' => 'Partições',
	'Partition name' => 'Nome da Partição',
	'Values' => 'Valores',

	// Indexes
	'Indexes' => 'Índices',
	'Indexes have been altered.' => 'Índices modificados.',
	'Alter indexes' => 'Modificar índices',
	'Add next' => 'Adicionar próximo',
	'Index Type' => 'Tipo de índice',
	'length' => 'tamanho',

	// Foreign keys
	'Foreign keys' => 'Chaves estrangeiras',
	'Foreign key' => 'Chave estrangeira',
	'Foreign key has been dropped.' => 'Chave estrangeira eliminada.',
	'Foreign key has been altered.' => 'Chave estrangeira modificada.',
	'Foreign key has been created.' => 'Chave estrangeira criada.',
	'Target table' => 'Tabela de destino',
	'Change' => 'Modificar',
	'Source' => 'Origem',
	'Target' => 'Destino',
	'Add column' => 'Adicionar coluna',
	'Alter' => 'Modificar',
	'Add foreign key' => 'Adicionar Chave estrangeira',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'As colunas de origen e destino devem ser do mesmo tipo, deve existir um índice entre as colunas de destino e o registo referenciado deve existir.',

	// Routines
	'Routines' => 'Procedimentos',
	'Routine has been called, %d row(s) affected.' => [
		'Consulta executada, %d registo afetado.',
		'Consulta executada, %d registos afetados.',
	],
	'Call' => 'Chamar',
	'Parameter name' => 'Nome de Parâmetro',
	'Create procedure' => 'Criar procedimento',
	'Create function' => 'Criar função',
	'Routine has been dropped.' => 'Procedimento eliminado.',
	'Routine has been altered.' => 'Procedimento modificado.',
	'Routine has been created.' => 'Procedimento criado.',
	'Alter function' => 'Modificar Função',
	'Alter procedure' => 'Modificar procedimento',
	'Return type' => 'Tipo de valor de regresso',

	// Events
	'Events' => 'Eventos',
	'Event' => 'Evento',
	'Event has been dropped.' => 'Evento eliminado.',
	'Event has been altered.' => 'Evento modificado.',
	'Event has been created.' => 'Evento criado.',
	'Alter event' => 'Modificar Evento',
	'Create event' => 'Criar Evento',
	'At given time' => 'À hora determinada',
	'Every' => 'Cada',
	'Schedule' => 'Agenda',
	'Start' => 'Início',
	'End' => 'Fim',
	'On completion preserve' => 'Preservar ao completar',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sequências',
	'Create sequence' => 'Criar sequências',
	'Sequence has been dropped.' => 'Sequência eliminada.',
	'Sequence has been created.' => 'Sequência criada.',
	'Sequence has been altered.' => 'Sequência modificada.',
	'Alter sequence' => 'Modificar sequência',

	// User types (PostgreSQL)
	'User types' => 'Tipos definidos pelo utilizador',
	'Create type' => 'Criar tipo',
	'Type has been dropped.' => 'Tipo eliminado.',
	'Type has been created.' => 'Tipo criado.',
	'Alter type' => 'Modificar tipo',

	// Triggers
	'Triggers' => 'Triggers',
	'Add trigger' => 'Adicionar trigger',
	'Trigger has been dropped.' => 'Trigger eliminado.',
	'Trigger has been altered.' => 'Trigger modificado.',
	'Trigger has been created.' => 'Trigger criado.',
	'Alter trigger' => 'Modificar Trigger',
	'Create trigger' => 'Adicionar Trigger',

	// Table check constraints

	// Selection
	'Select data' => 'Selecionar dados',
	'Select' => 'Selecionar',
	'Functions' => 'Funções',
	'Aggregation' => 'Adições',
	'Search' => 'Procurar',
	'anywhere' => 'qualquer local',
	'Sort' => 'Ordenar',
	'descending' => 'decrescente',
	'Limit' => 'Limite',
	'Text length' => 'Tamanho do texto',
	'Action' => 'Ação',
	'Unable to select the table' => 'Não é possivel selecionar a Tabela',
	'Search data in tables' => 'Pesquisar dados nas Tabelas',
	'No rows.' => 'Não existem registos.',
	'%d row(s)' => [
		'%d registo',
		'%d registos',
	],
	'Page' => 'Página',
	'last' => 'último',
	'Whole result' => 'Resultado completo',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Ctrl+click on a value to modify it.' => 'Ctrl+clique vezes sobre o valor para edita-lo.',
	'Use edit link to modify this value.' => 'Utilize o link modificar para alterar.',

	// Editing
	'New item' => 'Novo Registo',
	'Edit' => 'Modificar',
	'original' => 'original',
	'empty' => 'vazio', // label for value '' in enum data type
	'Insert' => 'Inserir',
	'Save' => 'Guardar',
	'Save and continue edit' => 'Guardar e continuar a edição',
	'Save and insert next' => 'Guardar e inserir outro',
	'Clone' => 'Clonar',
	'Delete' => 'Eliminar',
	'Item%s has been inserted.' => 'Registo%s inserido.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Registo eliminado.',
	'Item has been updated.' => 'Registo modificado.',
	'%d item(s) have been affected.' => [
		'%d item afetado.',
		'%d itens afetados.',
	],

	// Data type descriptions
	'Numbers' => 'Números',
	'Date and time' => 'Data e hora',
	'Strings' => 'Cadeia',
	'Binary' => 'Binário',
	'Lists' => 'Listas',
	'Network' => 'Rede',
	'Geometry' => 'Geometria',
	'Relations' => 'Relações',

	// Editor - data values
	'now' => 'agora',

	// Settings

	// Plugins
];
