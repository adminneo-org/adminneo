<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD/MM/AAAA', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts // by Claude Fable 5.1

	// Bootstrap
	'%s must return an array.' => '%s deve devolver um array.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s e %s devem devolver um objeto criado pelo método %s.', // by Claude Fable 5.1

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
	'hostname[:port] or :socket' => 'hostname[:port] ou :socket', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'Servidor ou credenciais inválidos.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'Existe um espaço na senha introduzida que pode ser a causa.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'O AdminNeo não suporta aceder a uma base de dados sem senha, <a href="https://www.adminneo.org/password"%s>mais informações</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'A base de dados não suporta senha.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Demasiadas tentativas de início de sessão falhadas, tente novamente em %d minuto.',
		'Demasiadas tentativas de início de sessão falhadas, tente novamente em %d minutos.',
	], // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => 'Sessão memorizada inválida, por favor entre de novo.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'Token CSRF inválido. Enviar o formulario novamente.',
	'If you did not send this request from AdminNeo then close this page.' => 'Se não enviou este pedido a partir do AdminNeo, feche esta página.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'A ação será realizada após iniciar sessão com êxito com as mesmas credenciais.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'Não há extensão',
	'None of the supported PHP extensions (%s) are available.' => 'Nenhuma das extensões PHP suportadas (%s) está disponivel.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Não é permitido ligar a portos privilegiados.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'As sessões devem estar ativas.',
	'Session expired, please login again.' => 'Sessão expirada, por favor entre de novo.',
	'%s version: %s through PHP extension %s' => 'Versão %s: %s através da extensão PHP %s',

	// Settings
	'Language' => 'Idioma',

	'Menu' => 'Menu', // by Claude Fable 5.1
	'Home' => 'Início', // by Claude Fable 5.1
	'Refresh' => 'Atualizar',
	'Info' => 'Informação', // by Claude Fable 5.1
	'More information.' => 'Mais informação.', // by Claude Fable 5.1

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
	'Columns' => 'Colunas', // by Claude Fable 5.1
	'Routine' => 'Rotina',
	'Grant' => 'Conceder',
	'Revoke' => 'Impedir',

	// Queries
	'SQL command' => 'Comando SQL',
	'HTTP request' => 'Pedido HTTP', // by Claude Fable 5.1
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
	'Unknown error.' => 'Erro desconhecido.', // by Claude Fable 5.1
	'Warnings' => 'Avisos', // by Claude Fable 5.1
	'%s queries are not supported.' => 'As consultas %s não são suportadas.', // by Claude Fable 5.1
	'Execute' => 'Executar',
	'Stop on error' => 'Parar em caso de erro',
	'Show only errors' => 'Mostrar somente erros',
	'Time' => 'Tempo',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Histórico',
	'Clear' => 'Limpar',
	'Edit all' => 'Editar tudo', // by Claude Fable 5.1

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
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'O número máximo de ficheiros é %d. Selecione menos ficheiros ou aumente a diretiva de configuração %s.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'O tamanho total máximo dos ficheiros é %s. Selecione ficheiros mais pequenos ou aumente a diretiva de configuração %s.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST data demasiado grande. Reduza o tamanho ou aumente a diretiva de configuração %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Pode enviar um ficheiro SQL grande por FTP e importá-lo a partir do servidor.', // by Claude Fable 5.1
	'File must be in UTF-8 encoding.' => 'O ficheiro deve estar codificado em UTF-8.', // by Claude Fable 5.1
	'You are offline.' => 'Está offline.', // by Claude Fable 5.1
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
	'database' => 'base de dados', // by Claude Fable 5.1
	'DB' => 'BD', // by Claude Fable 5.1
	'Use' => 'Usar',
	'Invalid database.' => 'Base de dados inválida.',
	'Alter database' => 'Modificar Base de dados',
	'Create database' => 'Criar Base de dados',
	'Database schema' => 'Esquema de Base de dados',
	'Permanent link' => 'Ligação permanente', // by Claude Fable 5.1
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
	'schema' => 'esquema', // by Claude Fable 5.1
	'Schemas' => 'Esquemas', // by Claude Fable 5.1
	'No schemas.' => 'Não existem esquemas.', // by Claude Fable 5.1
	'Show schema' => 'Mostrar esquema', // by Claude Fable 5.1
	'Alter schema' => 'Modificar esquema',
	'Create schema' => 'Criar esquema',
	'Schema has been dropped.' => 'Esquema eliminado.',
	'Schema has been created.' => 'Esquema criado.',
	'Schema has been altered.' => 'Esquema modificado.',
	'Invalid schema.' => 'Esquema inválido.',

	// Table list
	'All' => 'Tudo', // checkbox selecting all tables and views // by Claude Fable 5.1
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Colação',
	'collation' => 'collation',
	'Data Length' => 'Tamanho de dados',
	'Index Length' => 'Tamanho de índice',
	'Data Free' => 'Espaço Livre',
	'Rows' => 'Registos',
	'%d in total' => '%d no total',
	'Analyze' => 'Analisar',
	'Optimize' => 'Otimizar',
	'Vacuum' => 'Limpar', // by Claude Fable 5.1
	'Check' => 'Verificar',
	'Repair' => 'Reparar',
	'Truncate' => 'Truncar',
	'Truncate Cascade' => 'Truncar em cascata', // by Claude Fable 5.1
	'Tables have been truncated.' => 'Tabelas truncadas (truncate).',
	'Move to other database' => 'Mover para outra Base de dados',
	'Move' => 'Mover',
	'Tables have been moved.' => 'As Tabelas foram movidas.',
	'Copy' => 'Copiar', // by Claude Fable 5.1
	'Tables have been copied.' => 'As tabelas foram copiadas.', // by Claude Fable 5.1
	'overwrite' => 'sobrescrever', // by Claude Fable 5.1

	// Tables
	'Tables' => 'Tabelas',
	'Tables and views' => 'Tabelas e vistas',
	'Table' => 'Tabela',
	'No tables.' => 'Não existem tabelas.',
	'Alter table' => 'Modificar estrutura',
	'Create table' => 'Criar tabela',
	'Table has been dropped.' => 'Tabela eliminada.',
	'Tables have been dropped.' => 'As tabelas foram eliminadas.',
	'Tables have been optimized.' => 'As tabelas foram otimizadas.', // by Claude Fable 5.1
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
	'Default value' => 'Valor predefinido', // by Claude Fable 5.1
	'Drop' => 'Remover',
	'Drop %s?' => 'Remover %s?', // by Claude Fable 5.1
	'Are you sure?' => 'Tem a certeza?',
	'Size' => 'Tamanho', // by Claude Fable 5.1
	'Compute' => 'Calcular', // by Claude Fable 5.1
	'Move up' => 'Mover para cima',
	'Move down' => 'Mover para baixo',
	'Remove' => 'Remover',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Quantidade máxima de campos permitidos excedidos. Por favor aumente %s.',

	// Views
	'View' => 'Visualizar',
	'Materialized view' => 'Vista materializada', // by Claude Fable 5.1
	'View has been dropped.' => 'Vista eliminada.',
	'View has been altered.' => 'Vista modificada.',
	'View has been created.' => 'Vista criada.',
	'Alter view' => 'Modificar vista',
	'Create view' => 'Criar vista',

	// Partitions
	'Partition by' => 'Particionar por',
	'Partition' => 'Partição', // by Claude Fable 5.1
	'Partitions' => 'Partições',
	'Partition name' => 'Nome da Partição',
	'Values' => 'Valores',
	'Inherited tables' => 'Tabelas herdadas', // by Claude Fable 5.1
	'Inherited from' => 'Herdada de', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'Índices',
	'Indexes have been altered.' => 'Índices modificados.',
	'Alter indexes' => 'Modificar índices',
	'Add next' => 'Adicionar próximo',
	'Index Type' => 'Tipo de índice',
	'length' => 'tamanho',
	'operator class' => 'classe de operadores', // by Claude Fable 5.1
	'Algorithm' => 'Algoritmo', // by Claude Fable 5.1
	'Condition' => 'Condição', // by Claude Fable 5.1

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
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'As colunas de origem e destino devem ser do mesmo tipo, deve existir um índice entre as colunas de destino e o registo referenciado deve existir.',

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

	// User-defined types (PostgreSQL)
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
	'Checks' => 'Verificações', // by Claude Fable 5.1
	'Create check' => 'Criar verificação', // by Claude Fable 5.1
	'Alter check' => 'Modificar verificação', // by Claude Fable 5.1
	'Check has been created.' => 'A verificação foi criada.', // by Claude Fable 5.1
	'Check has been altered.' => 'A verificação foi modificada.', // by Claude Fable 5.1
	'Check has been dropped.' => 'A verificação foi removida.', // by Claude Fable 5.1

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
	'Limit rows' => 'Limite de registos', // by Claude Fable 5.1
	'Text length' => 'Tamanho do texto',
	'Action' => 'Ação',
	'Full table scan' => 'Varrimento completo da tabela', // by Claude Fable 5.1
	'Unable to select the table' => 'Não é possivel selecionar a Tabela',
	'Search data in tables' => 'Pesquisar dados nas Tabelas',
	'All rows on this page' => 'Todas as linhas desta página', // by Claude Fable 5.1
	'No rows.' => 'Não existem registos.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => [
		'%d registo',
		'%d registos',
	],
	'Page' => 'Página',
	'last' => 'último',
	'Load more data' => 'Carregar mais dados', // by Claude Fable 5.1
	'Loading…' => 'A carregar…', // by Claude Fable 5.1
	'Whole result' => 'Resultado completo',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Modificar', // by Claude Fable 5.1
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
	'Saving…' => 'A guardar…', // by Claude Fable 5.1
	'Selected' => 'Selecionados', // by Claude Fable 5.1
	'Clone' => 'Clonar',
	'Delete' => 'Eliminar',
	'Item%s has been inserted.' => 'Registo%s inserido.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Registo eliminado.',
	'Item has been updated.' => 'Registo modificado.',
	'%d item(s) have been affected.' => [
		'%d item afetado.',
		'%d itens afetados.',
	],
	'You have no privileges to update this table.' => 'Não tem privilégios para atualizar esta tabela.', // by Claude Fable 5.1

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
	'yes' => 'sim', // by Claude Fable 5.1
	'no' => 'não', // by Claude Fable 5.1

	// Settings
	'Settings' => 'Definições', // by Claude Fable 5.1
	'Default' => 'Predefinido', // by Claude Fable 5.1
	'Color scheme' => 'Esquema de cores', // by Claude Fable 5.1
	'By system' => 'Conforme o sistema', // by Claude Fable 5.1
	'Light' => 'Claro', // by Claude Fable 5.1
	'Dark' => 'Escuro', // by Claude Fable 5.1
	'Navigation mode' => 'Modo de navegação', // by Claude Fable 5.1
	'Simple' => 'Simples', // by Claude Fable 5.1
	'Dual' => 'Duplo', // by Claude Fable 5.1
	'Dual on hover' => 'Duplo ao passar o cursor', // by Claude Fable 5.1
	'Reversed' => 'Invertido', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'Disposição da navegação principal com as ligações das tabelas.', // by Claude Fable 5.1
	'Table links' => 'Ligações das tabelas', // by Claude Fable 5.1
	'Primary action for all table links.' => 'Ação principal para todas as ligações das tabelas.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'Ligações para as tabelas que referenciam o registo atual.', // by Claude Fable 5.1
	'Display' => 'Mostrar', // by Claude Fable 5.1
	'Hide' => 'Ocultar', // by Claude Fable 5.1
	'Records per page' => 'Registos por página', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'Número predefinido de registos mostrados na tabela de dados.', // by Claude Fable 5.1
	'Enum as select' => 'Enum como seleção', // by Claude Fable 5.1
	'Never' => 'Nunca', // by Claude Fable 5.1
	'Always' => 'Sempre', // by Claude Fable 5.1
	'More values than %d' => 'Mais de %d valores', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'Limite para mostrar um menu de seleção nos campos enum.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'Senha de uso único', // by Claude Fable 5.1
	'Enter OTP code.' => 'Introduza o código OTP.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'Código OTP inválido.', // by Claude Fable 5.1
	'Access denied.' => 'Acesso negado.', // by Claude Fable 5.1
	'JSON previews' => 'Pré-visualizações JSON', // by Claude Fable 5.1
	'Data table' => 'Tabela de dados', // by Claude Fable 5.1
	'Edit form' => 'Formulário de edição', // by Claude Fable 5.1
	'Ask %s' => 'Perguntar a %s', // by Claude Fable 5.1
];
