<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD/MM/AAAA', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts // by Claude Fable 5

	// Bootstrap

	// Login
	'System' => 'Sistema',
	'Server' => 'Servidor',
	'Username' => 'Usuário',
	'Password' => 'Senha',
	'Permanent login' => 'Login permanente',
	'Login' => 'Entrar',
	'Logout' => 'Sair',
	'Logged as: %s' => 'Logado como: %s',
	'Logout successful.' => 'Saída bem sucedida.',
	'hostname[:port] or :socket' => 'hostname[:port] ou :socket', // by Claude Fable 5
	'There is a space in the input password which might be the cause.' => 'Há um espaço na senha digitada que pode ser a causa.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'O AdminNeo não suporta acessar uma base de dados sem senha, <a href="https://www.adminneo.org/password"%s>mais informações</a>.', // by Claude Fable 5
	'Database does not support password.' => 'A base de dados não suporta senha.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Muitas tentativas de login sem sucesso, tente novamente em %d minuto.',
		'Muitas tentativas de login sem sucesso, tente novamente em %d minutos.',
	], // by Claude Fable 5
	'Invalid CSRF token. Send the form again.' => 'Token CSRF inválido. Enviar o formulário novamente.',
	'If you did not send this request from AdminNeo then close this page.' => 'Se você não enviou esta requisição pelo AdminNeo, feche esta página.', // by Claude Fable 5
	'The action will be performed after successful login with the same credentials.' => 'A ação será realizada após o login bem-sucedido com as mesmas credenciais.', // by Claude Fable 5

	// Connection
	'No extension' => 'Não há extension',
	'None of the supported PHP extensions (%s) are available.' => 'Nenhuma das extensões PHP suportadas (%s) está disponível.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Não é permitido conectar a portas privilegiadas.', // by Claude Fable 5
	'Session support must be enabled.' => 'Suporte a sessões deve estar habilitado.',
	'Session expired, please login again.' => 'Sessão expirada, por favor logue-se novamente.',
	'%s version: %s through PHP extension %s' => 'Versão %s: %s através da extensão PHP %s',

	// Settings
	'Language' => 'Idioma',

	'Refresh' => 'Atualizar',

	// Privileges
	'Privileges' => 'Privilégios',
	'Create user' => 'Criar Usuário',
	'User has been dropped.' => 'O Usuário foi apagado.',
	'User has been altered.' => 'O Usuário foi alterado.',
	'User has been created.' => 'O Usuário foi criado.',
	'Hashed' => 'Hash',

	// Server
	'Process list' => 'Lista de processos',
	'%d process(es) have been killed.' => [
		'%d processo foi terminado.',
		'%d processos foram terminados.',
	],
	'Kill' => 'Parar',
	'Variables' => 'Variáveis',
	'Status' => 'Estado',

	// Structure
	'Column' => 'Coluna',
	'Columns' => 'Colunas', // by Claude Fable 5
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
		'Consulta executada, %d registro afetado.',
		'Consulta executada, %d registros afetados.',
	],
	'No commands to execute.' => 'Nenhum comando para executar.',
	'Error in query' => 'Erro na consulta',
	'Unknown error.' => 'Erro desconhecido.', // by Claude Fable 5
	'Warnings' => 'Avisos', // by Claude Fable 5
	'%s queries are not supported.' => 'Consultas %s não são suportadas.', // by Claude Fable 5
	'Execute' => 'Executar',
	'Stop on error' => 'Parar em caso de erro',
	'Show only errors' => 'Mostrar somente erros',
	'Time' => 'Tempo',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Histórico',
	'Clear' => 'Limpar',
	'Edit all' => 'Editar tudo', // by Claude Fable 5

	// Import
	'Import' => 'Importar',
	'File upload' => 'Importar arquivo',
	'From server' => 'A partir do servidor',
	'Webserver file %s' => 'Arquivo do servidor web %s',
	'Run file' => 'Executar Arquivo',
	'File does not exist.' => 'Arquivo não existe.',
	'File uploads are disabled.' => 'Importação de arquivos desabilitada.',
	'Unable to upload a file.' => 'Não é possível enviar o arquivo.',
	'Maximum allowed file size is %sB.' => 'Tamanho máximo do arquivo permitido é %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST data demasiado grande. Reduza o tamanho ou aumente a diretiva de configuração %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Você pode enviar um arquivo SQL grande via FTP e importá-lo do servidor.', // by Claude Fable 5
	'File must be in UTF-8 encoding.' => 'O arquivo deve estar codificado em UTF-8.', // by Claude Fable 5
	'You are offline.' => 'Você está offline.', // by Claude Fable 5
	'%d row(s) have been imported.' => [
		'%d registro foi importado.',
		'%d registros foram importados.',
	],

	// Export
	'Export' => 'Exportar',
	'Output' => 'Saída',
	'open' => 'abrir',
	'save' => 'salvar',
	'Format' => 'Formato',
	'Data' => 'Dados',

	// Databases
	'Database' => 'Base de dados',
	'DB' => 'BD', // by Claude Fable 5
	'Use' => 'Usar',
	'Invalid database.' => 'Base de dados inválida.',
	'Alter database' => 'Alterar Base de dados',
	'Create database' => 'Criar Base de dados',
	'Database schema' => 'Esquema de Base de dados',
	'Permanent link' => 'Link permanente', // by Claude Fable 5
	'Database has been dropped.' => 'A Base de dados foi apagada.',
	'Databases have been dropped.' => 'A Base de dados foi apagada.',
	'Database has been created.' => 'A Base de dados foi criada.',
	'Database has been renamed.' => 'A Base de dados foi renomeada.',
	'Database has been altered.' => 'A Base de dados foi alterada.',

	// SQLite errors
	'File exists.' => 'Arquivo já existe.',
	'Please use one of the extensions %s.' => 'Por favor use uma das extensões %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Esquema',
	'Alter schema' => 'Alterar esquema',
	'Create schema' => 'Criar esquema',
	'Schema has been dropped.' => 'O Esquema foi apagado.',
	'Schema has been created.' => 'O Esquema foi criado.',
	'Schema has been altered.' => 'O Esquema foi alterado.',
	'Invalid schema.' => 'Esquema inválido.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Colação',
	'collation' => 'collation',
	'Data Length' => 'Tamanho de dados',
	'Index Length' => 'Tamanho de índice',
	'Data Free' => 'Espaço Livre',
	'Rows' => 'Registros',
	'%d in total' => '%d no total',
	'Analyze' => 'Analisar',
	'Optimize' => 'Otimizar',
	'Vacuum' => 'Limpar', // by Claude Fable 5
	'Check' => 'Verificar',
	'Repair' => 'Reparar',
	'Truncate' => 'Truncar',
	'Tables have been truncated.' => 'As Tabelas foram truncadas.',
	'Move to other database' => 'Mover para outra Base de dados',
	'Move' => 'Mover',
	'Tables have been moved.' => 'As Tabelas foram movidas.',
	'Copy' => 'Copiar', // by Claude Fable 5
	'Tables have been copied.' => 'As tabelas foram copiadas.', // by Claude Fable 5
	'overwrite' => 'sobrescrever', // by Claude Fable 5

	// Tables
	'Tables' => 'Tabelas',
	'Tables and views' => 'Tabelas e Visões',
	'Table' => 'Tabela',
	'No tables.' => 'Não existem tabelas.',
	'Alter table' => 'Alterar estrutura',
	'Create table' => 'Criar tabela',
	'Table has been dropped.' => 'A Tabela foi eliminada.',
	'Tables have been dropped.' => 'As Tabelas foram eliminadas.',
	'Tables have been optimized.' => 'As tabelas foram otimizadas.', // by Claude Fable 5
	'Table has been altered.' => 'A Tabela foi alterada.',
	'Table has been created.' => 'A Tabela foi criada.',
	'Table name' => 'Nome da tabela',
	'Name' => 'Nome',
	'Show structure' => 'Mostrar estrutura',
	'Column name' => 'Nome da coluna',
	'Type' => 'Tipo',
	'Length' => 'Tamanho',
	'Auto Increment' => 'Incremento Automático',
	'Options' => 'Opções',
	'Comment' => 'Comentário',
	'Default value' => 'Valor padrão', // by Claude Fable 5
	'Drop' => 'Apagar',
	'Drop %s?' => 'Apagar %s?', // by Claude Fable 5
	'Are you sure?' => 'Você tem certeza?',
	'Size' => 'Tamanho', // by Claude Fable 5
	'Compute' => 'Calcular', // by Claude Fable 5
	'Move up' => 'Mover acima',
	'Move down' => 'Mover abaixo',
	'Remove' => 'Remover',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Quantidade máxima de campos permitidos excedidos. Por favor aumente %s.',

	// Views
	'View' => 'Visão',
	'Materialized view' => 'Visão materializada', // by Claude Fable 5
	'View has been dropped.' => 'A Visão foi apagada.',
	'View has been altered.' => 'A Visão foi alterada.',
	'View has been created.' => 'A Visão foi criada.',
	'Alter view' => 'Alterar visão',
	'Create view' => 'Criar visão',

	// Partitions
	'Partition by' => 'Particionar por',
	'Partitions' => 'Partições',
	'Partition name' => 'Nome da Partição',
	'Values' => 'Valores',

	// Indexes
	'Indexes' => 'Índices',
	'Indexes have been altered.' => 'Os Índices foram alterados.',
	'Alter indexes' => 'Alterar índices',
	'Add next' => 'Adicionar próximo',
	'Index Type' => 'Tipo de índice',
	'length' => 'tamanho',
	'Algorithm' => 'Algoritmo', // by Claude Fable 5
	'Condition' => 'Condição', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Chaves estrangeiras',
	'Foreign key' => 'Chave Estrangeira',
	'Foreign key has been dropped.' => 'A Chave Estrangeira foi apagada.',
	'Foreign key has been altered.' => 'A Chave Estrangeira foi alterada.',
	'Foreign key has been created.' => 'A Chave Estrangeira foi criada.',
	'Target table' => 'Tabela de destino',
	'Change' => 'Modificar',
	'Source' => 'Origem',
	'Target' => 'Destino',
	'Add column' => 'Adicionar coluna',
	'Alter' => 'Alterar',
	'Add foreign key' => 'Adicionar Chave Estrangeira',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'As colunas de origen e destino devem ser do mesmo tipo, deve existir um índice entre as colunas de destino e o registro referenciado deve existir.',

	// Routines
	'Routines' => 'Rotinas',
	'Routine has been called, %d row(s) affected.' => [
		'Rotina executada, %d registro afetado.',
		'Rotina executada, %d registros afetados.',
	],
	'Call' => 'Chamar',
	'Parameter name' => 'Nome de Parâmetro',
	'Create procedure' => 'Criar procedimento',
	'Create function' => 'Criar função',
	'Routine has been dropped.' => 'A Rotina foi apagada.',
	'Routine has been altered.' => 'A Rotina foi alterada.',
	'Routine has been created.' => 'A Rotina foi criada.',
	'Alter function' => 'Alterar função',
	'Alter procedure' => 'Alterar procedimento',
	'Return type' => 'Tipo de valor de retorno',

	// Events
	'Events' => 'Eventos',
	'Event' => 'Evento',
	'Event has been dropped.' => 'O Evento foi apagado.',
	'Event has been altered.' => 'O Evento foi alterado.',
	'Event has been created.' => 'O Evento foi criado.',
	'Alter event' => 'Modificar Evento',
	'Create event' => 'Criar Evento',
	'At given time' => 'A hora determinada',
	'Every' => 'Cada',
	'Schedule' => 'Agenda',
	'Start' => 'Início',
	'End' => 'Fim',
	'On completion preserve' => 'Ao completar preservar',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sequências',
	'Create sequence' => 'Criar sequência',
	'Sequence has been dropped.' => 'A Sequência foi apagada.',
	'Sequence has been created.' => 'A Sequência foi criada.',
	'Sequence has been altered.' => 'A Sequência foi alterada.',
	'Alter sequence' => 'Alterar sequência',

	// User types (PostgreSQL)
	'User types' => 'Tipos definidos pelo usuário',
	'Create type' => 'Criar tipo',
	'Type has been dropped.' => 'O Tipo foi apagado.',
	'Type has been created.' => 'O Tipo foi criado.',
	'Alter type' => 'Alterar tipo',

	// Triggers
	'Triggers' => 'Triggers',
	'Add trigger' => 'Adicionar trigger',
	'Trigger has been dropped.' => 'O Trigger foi apagado.',
	'Trigger has been altered.' => 'O Trigger foi alterado.',
	'Trigger has been created.' => 'O Trigger foi criado.',
	'Alter trigger' => 'Alterar Trigger',
	'Create trigger' => 'Adicionar Trigger',

	// Table check constraints
	'Checks' => 'Verificações', // by Claude Fable 5
	'Create check' => 'Criar verificação', // by Claude Fable 5
	'Alter check' => 'Alterar verificação', // by Claude Fable 5
	'Check has been created.' => 'A verificação foi criada.', // by Claude Fable 5
	'Check has been altered.' => 'A verificação foi alterada.', // by Claude Fable 5
	'Check has been dropped.' => 'A verificação foi apagada.', // by Claude Fable 5

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
	'Limit rows' => 'Limite de registros', // by Claude Fable 5
	'Text length' => 'Tamanho de texto',
	'Action' => 'Ação',
	'Full table scan' => 'Varredura completa da tabela', // by Claude Fable 5
	'Unable to select the table' => 'Não é possível selecionar a Tabela',
	'Search data in tables' => 'Buscar dados nas Tabelas',
	'No rows.' => 'Não existem registros.',
	'%d / ' => '%d / ', // by Claude Fable 5
	'%d row(s)' => [
		'%d registro',
		'%d registros',
	],
	'Page' => 'Página',
	'last' => 'último',
	'Load more data' => 'Carregar mais dados', // by Claude Fable 5
	'Loading' => 'Carregando', // by Claude Fable 5
	'Whole result' => 'Resultado completo',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Modificar', // by Claude Fable 5
	'Ctrl+click on a value to modify it.' => 'Ctrl+clique sobre o valor para edita-lo.',
	'Use edit link to modify this value.' => 'Utilize o link editar para modificar este valor.',

	// Editing
	'New item' => 'Novo Registro',
	'Edit' => 'Editar',
	'original' => 'original',
	'empty' => 'vazio', // label for value '' in enum data type
	'Insert' => 'Inserir',
	'Save' => 'Salvar',
	'Save and continue edit' => 'Salvar e continuar editando',
	'Save and insert next' => 'Salvar e inserir outro',
	'Saving' => 'Salvando', // by Claude Fable 5
	'Selected' => 'Selecionados', // by Claude Fable 5
	'Clone' => 'Clonar',
	'Delete' => 'Deletar',
	'Item%s has been inserted.' => 'O Registro%s foi inserido.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'O Registro foi deletado.',
	'Item has been updated.' => 'O Registro foi atualizado.',
	'%d item(s) have been affected.' => [
		'%d item foi afetado.',
		'%d itens foram afetados.',
	],
	'You have no privileges to update this table.' => 'Você não tem privilégios para atualizar esta tabela.', // by Claude Fable 5

	// Data type descriptions
	'Numbers' => 'Números',
	'Date and time' => 'Data e hora',
	'Strings' => 'Strings',
	'Binary' => 'Binário',
	'Lists' => 'Listas',
	'Network' => 'Rede',
	'Geometry' => 'Geometria',
	'Relations' => 'Relações',

	// Editor - data values
	'now' => 'agora',
	'yes' => 'sim', // by Claude Fable 5
	'no' => 'não', // by Claude Fable 5

	// Settings

	// Plugins
];
