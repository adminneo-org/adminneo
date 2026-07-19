<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => '.',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5/$3/$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'DD/MM/YYYY',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'Sistema',
	'Server' => 'Server',
	'Username' => 'Utente',
	'Password' => 'Password',
	'Permanent login' => 'Login permanente',
	'Login' => 'Autenticazione',
	'Logout' => 'Esci',
	'Logged as: %s' => 'Autenticato come: %s',
	'Logout successful.' => 'Uscita effettuata con successo.',
	'Invalid server or credentials.' => 'Server o credenziali non valide.',
	'There is a space in the input password which might be the cause.' => 'Esiste uno spazio nella passoword inserita che potrebbe essere la causa.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo non supporta accesso a databse senza password, <a href="https://www.adminneo.org/password"%s>piú informazioni</a>.',
	'Database does not support password.' => 'Il database non supporta password.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Troppi tentativi infruttuosi di login, si prega di riprovare in %d minuto.',
		'Troppi tentativi infruttuosi di login, si prega di riprovare in %d minuti.',
	],
	'Invalid CSRF token. Send the form again.' => 'Token CSRF non valido. Reinvia la richiesta.',
	'If you did not send this request from AdminNeo then close this page.' => 'Se non hai inviato tu la richiesta tramite AdminNeo puoi chiudere la pagina.',
	'The action will be performed after successful login with the same credentials.' => 'La azione verrá eseguita dopo un login valido con le stesse credenziali.',

	// Connection.
	'No extension' => 'Estensioni non presenti',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Nessuna delle estensioni PHP supportate (%s) disponibile.',
	'Connecting to privileged ports is not allowed.' => 'LA connessione a porte privilegiate non é permessa.',
	'Session support must be enabled.' => 'Le sessioni devono essere abilitate.',
	'Session expired, please login again.' => 'Sessione scaduta, autenticarsi di nuovo.',
	'%s version: %s through PHP extension %s' => 'Versione %s: %s via estensione PHP %s',

	// Settings.
	'Language' => 'Lingua',

	'Refresh' => 'Aggiorna',

	// Privileges.
	'Privileges' => 'Privilegi',
	'Create user' => 'Crea utente',
	'User has been dropped.' => 'Utente eliminato.',
	'User has been altered.' => 'Utente modificato.',
	'User has been created.' => 'Utente creato.',
	'Hashed' => 'Hashed',

	// Server.
	'Process list' => 'Elenco processi',
	'%d process(es) have been killed.' => [
		'%d processo interrotto.',
		'%d processi interrotti.',
	],
	'Kill' => 'Interrompi',
	'Variables' => 'Variabili',
	'Status' => 'Stato',

	// Structure.
	'Column' => 'Colonna',
	'Columns' => 'Colonne',
	'Routine' => 'Routine',
	'Grant' => 'Permetti',
	'Revoke' => 'Revoca',

	// Queries.
	'SQL command' => 'Comando SQL',
	'%d query(s) executed OK.' => [
		'%d query eseguita con successo.',
		'%d query eseguite con successo.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Esecuzione della query OK, %d riga interessata.',
		'Esecuzione della query OK, %d righe interessate.',
	],
	'No commands to execute.' => 'Nessun commando da eseguire.',
	'Error in query' => 'Errore nella query',
	'Unknown error.' => 'Errore sconosciuto.',
	'Warnings' => 'Attenzione',
	'%s queries are not supported.' => '%s queries non sono supportate.',
	'Execute' => 'Esegui',
	'Stop on error' => 'Stop su errore',
	'Show only errors' => 'Mostra solo gli errori',
	'Time' => 'Orario',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Storico',
	'Clear' => 'Pulisci',
	'Edit all' => 'Modifica tutto',

	// Import.
	'Import' => 'Importa',
	'File upload' => 'Caricamento file',
	'From server' => 'Dal server',
	'Webserver file %s' => 'Webserver file %s',
	'Run file' => 'Esegui file',
	'File does not exist.' => 'Il file non esiste.',
	'File uploads are disabled.' => 'Caricamento file disabilitato.',
	'Unable to upload a file.' => 'Caricamento del file non riuscito.',
	'Maximum allowed file size is %sB.' => 'La dimensione massima del file è %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Troppi dati via POST. Ridurre i dati o aumentare la direttiva di configurazione %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Puoi caricare un grande file SQL tramite FTP ed impirtarlo dal server.',
	'File must be in UTF-8 encoding.' => 'Il file deve avere codifica UTF-8.',
	'You are offline.' => 'Sei disconnesso.',
	'%d row(s) have been imported.' => [
		'%d riga importata.',
		'%d righe importate.',
	],

	// Export.
	'Export' => 'Esporta',
	'Output' => 'Risultato',
	'open' => 'apri',
	'save' => 'salva',
	'Format' => 'Formato',
	'Data' => 'Dati',

	// Databases.
	'Database' => 'Database',
	'database' => 'Database',
	'DB' => 'DB',
	'Use' => 'Usa',
	'Invalid database.' => 'Database non valido.',
	'Alter database' => 'Modifica database',
	'Create database' => 'Crea database',
	'Database schema' => 'Schema database',
	'Permanent link' => 'Link permanente',
	'Database has been dropped.' => 'Database eliminato.',
	'Databases have been dropped.' => 'Database eliminati.',
	'Database has been created.' => 'Database creato.',
	'Database has been renamed.' => 'Database rinominato.',
	'Database has been altered.' => 'Database modificato.',
	// SQLite errors.
	'File exists.' => 'Il file esiste già.',
	'Please use one of the extensions %s.' => 'Usa una delle estensioni %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Schema',
	'schema' => 'Schema',
	'Alter schema' => 'Modifica schema',
	'Create schema' => 'Crea schema',
	'Schema has been dropped.' => 'Schema eliminato.',
	'Schema has been created.' => 'Schema creato.',
	'Schema has been altered.' => 'Schema modificato.',
	'Invalid schema.' => 'Schema non valido.',

	// Table list.
	'Engine' => 'Motore',
	'engine' => 'motore',
	'Collation' => 'Collazione',
	'collation' => 'collazione',
	'Data Length' => 'Lunghezza dato',
	'Index Length' => 'Lunghezza indice',
	'Data Free' => 'Dati liberi',
	'Rows' => 'Righe',
	'%d in total' => '%d in totale',
	'Analyze' => 'Analizza',
	'Optimize' => 'Ottimizza',
	'Vacuum' => 'Aspira',
	'Check' => 'Controlla',
	'Repair' => 'Ripara',
	'Truncate' => 'Svuota',
	'Tables have been truncated.' => 'Le tabelle sono state svuotate.',
	'Move to other database' => 'Sposta in altro database',
	'Move' => 'Sposta',
	'Tables have been moved.' => 'Le tabelle sono state spostate.',
	'Copy' => 'Copia',
	'Tables have been copied.' => 'Le tabelle sono state copiate.',
	'overwrite' => 'sovrascrivi',

	// Tables.
	'Tables' => 'Tabelle',
	'Tables and views' => 'Tabelle e viste',
	'Table' => 'Tabella',
	'No tables.' => 'No tabelle.',
	'Alter table' => 'Modifica tabella',
	'Create table' => 'Crea tabella',
	'Table has been dropped.' => 'Tabella eliminata.',
	'Tables have been dropped.' => 'Le tabelle sono state eliminate.',
	'Tables have been optimized.' => 'Le tabelle sono state ottimizzate.',
	'Table has been altered.' => 'Tabella modificata.',
	'Table has been created.' => 'Tabella creata.',
	'Table name' => 'Nome tabella',
	'Name' => 'Nome',
	'Show structure' => 'Visualizza struttura',
	'Column name' => 'Nome colonna',
	'Type' => 'Tipo',
	'Length' => 'Lunghezza',
	'Auto Increment' => 'Auto incremento',
	'Options' => 'Opzioni',
	'Comment' => 'Commento',
	'Default value' => 'Valore predefinito',
	'Drop' => 'Elimina',
	'Drop %s?' => 'Scartare %s?',
	'Are you sure?' => 'Sicuro?',
	'Size' => 'Taglia',
	'Compute' => 'Elabora',
	'Move up' => 'Sposta su',
	'Move down' => 'Sposta giu',
	'Remove' => 'Rimuovi',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Troppi campi. Per favore aumentare %s.',

	// Views.
	'View' => 'Vedi',
	'Materialized view' => 'Vista materializzata',
	'View has been dropped.' => 'Vista eliminata.',
	'View has been altered.' => 'Vista modificata.',
	'View has been created.' => 'Vista creata.',
	'Alter view' => 'Modifica vista',
	'Create view' => 'Crea vista',

	// Partitions.
	'Partition by' => 'Partiziona per',
	'Partitions' => 'Partizioni',
	'Partition name' => 'Nome partizione',
	'Values' => 'Valori',

	// Indexes.
	'Indexes' => 'Indici',
	'Indexes have been altered.' => 'Indici modificati.',
	'Alter indexes' => 'Modifica indici',
	'Add next' => 'Aggiungi altro',
	'Index Type' => 'Tipo indice',
	'length' => 'lunghezza',

	// Foreign keys.
	'Foreign keys' => 'Chiavi esterne',
	'Foreign key' => 'Foreign key',
	'Foreign key has been dropped.' => 'Foreign key eliminata.',
	'Foreign key has been altered.' => 'Foreign key modificata.',
	'Foreign key has been created.' => 'Foreign key creata.',
	'Target table' => 'Tabella obiettivo',
	'Change' => 'Cambia',
	'Source' => 'Sorgente',
	'Target' => 'Obiettivo',
	'Add column' => 'Aggiungi colonna',
	'Alter' => 'Modifica',
	'Add foreign key' => 'Aggiungi foreign key',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Le colonne sorgente e destinazione devono essere dello stesso tipo e ci deve essere un indice sulla colonna di destinazione e sui dati referenziati.',

	// Routines.
	'Routines' => 'Routine',
	'Routine has been called, %d row(s) affected.' => [
		'Routine chiamata, %d riga interessata.',
		'Routine chiamata, %d righe interessate.',
	],
	'Call' => 'Chiama',
	'Parameter name' => 'Nome parametro',
	'Create procedure' => 'Crea procedura',
	'Create function' => 'Crea funzione',
	'Routine has been dropped.' => 'Routine eliminata.',
	'Routine has been altered.' => 'Routine modificata.',
	'Routine has been created.' => 'Routine creata.',
	'Alter function' => 'Modifica funzione',
	'Alter procedure' => 'Modifica procedura',
	'Return type' => 'Return type',

	// Events.
	'Events' => 'Eventi',
	'Event' => 'Evento',
	'Event has been dropped.' => 'Evento eliminato.',
	'Event has been altered.' => 'Evento modificato.',
	'Event has been created.' => 'Evento creato.',
	'Alter event' => 'Modifica evento',
	'Create event' => 'Crea evento',
	'At given time' => 'A tempo prestabilito',
	'Every' => 'Ogni',
	'Schedule' => 'Pianifica',
	'Start' => 'Inizio',
	'End' => 'Fine',
	'On completion preserve' => 'Al termine preservare',

	// Sequences (PostgreSQL).
	'Sequences' => 'Sequenza',
	'Create sequence' => 'Crea sequenza',
	'Sequence has been dropped.' => 'Sequenza eliminata.',
	'Sequence has been created.' => 'Sequenza creata.',
	'Sequence has been altered.' => 'Sequenza modificata.',
	'Alter sequence' => 'Modifica sequenza',

	// User types (PostgreSQL)
	'User types' => 'Tipi definiti dall\'utente',
	'Create type' => 'Crea tipo definito dall\'utente',
	'Type has been dropped.' => 'Tipo definito dall\'utente eliminato.',
	'Type has been created.' => 'Tipo definito dall\'utente creato.',
	'Alter type' => 'Modifica tipo definito dall\'utente',

	// Triggers.
	'Triggers' => 'Trigger',
	'Add trigger' => 'Aggiungi trigger',
	'Trigger has been dropped.' => 'Trigger eliminato.',
	'Trigger has been altered.' => 'Trigger modificato.',
	'Trigger has been created.' => 'Trigger creato.',
	'Alter trigger' => 'Modifica trigger',
	'Create trigger' => 'Crea trigger',

	// Table check constraints.

	// Selection.
	'Select data' => 'Visualizza dati',
	'Select' => 'Seleziona',
	'Functions' => 'Funzioni',
	'Aggregation' => 'Aggregazione',
	'Search' => 'Cerca',
	'anywhere' => 'ovunque',
	'Sort' => 'Ordina',
	'descending' => 'discendente',
	'Limit' => 'Limite',
	'Limit rows' => 'Limite righe',
	'Text length' => 'Lunghezza testo',
	'Action' => 'Azione',
	'Full table scan' => 'Analizza intera tabella',
	'Unable to select the table' => 'Selezione della tabella non riuscita',
	'Search data in tables' => 'Cerca nelle tabelle',
	'No rows.' => 'Nessuna riga.',
	'%d / ' => [
		'%d / ',
	],
	'%d row(s)' => [
		'%d riga',
		'%d righe',
	],
	'Page' => 'Pagina',
	'last' => 'ultima',
	'Load more data' => 'Carica piú dati',
	'Loading' => 'Caricamento',
	'Whole result' => 'Intero risultato',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection.
	'Modify' => 'Modifica',
	'Ctrl+click on a value to modify it.' => 'Fai Ctrl+click su un valore per modificarlo.',
	'Use edit link to modify this value.' => 'Usa il link modifica per modificare questo valore.',

	// Editing.
	'New item' => 'Nuovo elemento',
	'Edit' => 'Modifica',
	'original' => 'originale',
	// label for value '' in enum data type
	'empty' => 'vuoto',
	'Insert' => 'Inserisci',
	'Save' => 'Salva',
	'Save and continue edit' => 'Salva e continua',
	'Save and insert next' => 'Salva e inserisci un altro',
	'Saving' => 'Salvataggio',
	'Selected' => 'Selezionato',
	'Clone' => 'Clona',
	'Delete' => 'Elimina',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Elemento%s inserito.',
	'Item has been deleted.' => 'Elemento eliminato.',
	'Item has been updated.' => 'Elemento aggiornato.',
	'%d item(s) have been affected.' => [
		'Il risultato consiste in %d elemento.',
		'Il risultato consiste in %d elementi.',
	],
	'You have no privileges to update this table.' => 'Non hai i privilegi per aggiornare questa tabella.',

	// Data type descriptions.
	'Numbers' => 'Numeri',
	'Date and time' => 'Data e ora',
	'Strings' => 'Stringhe',
	'Binary' => 'Binari',
	'Lists' => 'Liste',
	'Network' => 'Rete',
	'Geometry' => 'Geometria',
	'Relations' => 'Relazioni',

	// Editor - data values.
	'now' => 'adesso',
	'yes' => 'si',
	'no' => 'no',

	// Plugins.
];
