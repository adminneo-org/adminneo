<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5/$3/$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'JJ/MM/AAAA',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.
	'%s must return an array.' => '%s doit retourner un tableau.',
	'%s and %s must return an object created by %s method.' => '%s et %s doivent retourner un objet créé par la méthode %s.',

	// Login.
	'System' => 'Système',
	'Server' => 'Serveur',
	'Username' => 'Utilisateur',
	'Password' => 'Mot de passe',
	'Permanent login' => 'Authentification permanente',
	'Login' => 'Authentification',
	'Logout' => 'Déconnexion',
	'Logged as: %s' => 'Authentifié en tant que : %s',
	'Logout successful.' => 'Déconnexion réussie.',
	'Invalid server or credentials.' => 'Serveur ou identifiants invalides.',
	'There is a space in the input password which might be the cause.' => 'Il y a un espace dans le mot de passe entré qui pourrait en être la cause.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ne supporte pas l\'accès aux bases de données sans mot de passe, <a href="https://www.adminneo.org/password"%s>plus d\'information</a>.',
	'Database does not support password.' => 'La base de données ne support pas les mots de passe.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Trop de connexions échouées, essayez à nouveau dans %d minute.',
		'Trop de connexions échouées, essayez à nouveau dans %d minutes.',
	],
	'Invalid permanent login, please login again.' => 'Authentification permanente invalide, veuillez vous reconnecter.',
	'Invalid CSRF token. Send the form again.' => 'Token CSRF invalide. Veuillez renvoyer le formulaire.',
	'If you did not send this request from AdminNeo then close this page.' => 'Si vous n\'avez pas envoyé cette requête depuis AdminNeo, alors fermez cette page.',
	'The action will be performed after successful login with the same credentials.' => 'Cette action sera exécutée après s\'être connecté avec les mêmes données de connexion.',

	// Connection.
	'No driver' => 'Aucun driver',
	'Database driver not found.' => 'Driver de base de données introuvable.',
	'No extension' => 'Extension introuvable',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Aucune des extensions PHP supportées (%s) n\'est disponible.',
	'Connecting to privileged ports is not allowed.' => 'La connexion aux ports privilégiés n\'est pas autorisée.',
	'Session support must be enabled.' => 'Veuillez activer les sessions.',
	'Session expired, please login again.' => 'Session expirée, veuillez vous authentifier à nouveau.',
	'%s version: %s through PHP extension %s' => 'Version de %s : %s via l\'extension PHP %s',

	// Settings.
	'Language' => 'Langue',

	'Home' => 'Accueil',
	'Refresh' => 'Rafraîchir',
	'Info' => 'Info',
	'More information.' => 'Plus d\'informations.',

	// Privileges.
	'Privileges' => 'Privilèges',
	'Create user' => 'Créer un utilisateur',
	'User has been dropped.' => 'L\'utilisateur a été effacé.',
	'User has been altered.' => 'L\'utilisateur a été modifié.',
	'User has been created.' => 'L\'utilisateur a été créé.',
	'Hashed' => 'Haché',

	// Server.
	'Process list' => 'Liste des processus',
	'%d process(es) have been killed.' => [
		'%d processus a été arrêté.',
		'%d processus ont été arrêtés.',
	],
	'Kill' => 'Arrêter',
	'Variables' => 'Variables',
	'Status' => 'Statut',

	// Structure.
	'Column' => 'Colonne',
	'Routine' => 'Routine',
	'Grant' => 'Grant',
	'Revoke' => 'Revoke',

	// Queries.
	'SQL command' => 'Requête SQL',
	'HTTP request' => 'Requête HTTP',
	'%d query(s) executed OK.' => [
		'%d requête exécutée avec succès.',
		'%d requêtes exécutées avec succès.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Requête exécutée avec succès, %d ligne modifiée.',
		'Requête exécutée avec succès, %d lignes modifiées.',
	],
	'No commands to execute.' => 'Aucune commande à exécuter.',
	'Error in query' => 'Erreur dans la requête',
	'Unknown error.' => 'Erreur inconnue.',
	'Warnings' => 'Avertissements',
	'ATTACH queries are not supported.' => 'Requêtes ATTACH ne sont pas supportées.',
	'Execute' => 'Exécuter',
	'Stop on error' => 'Arrêter en cas d\'erreur',
	'Show only errors' => 'Montrer seulement les erreurs',
	'Time' => 'Temps',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Historique',
	'Clear' => 'Effacer',
	'Edit all' => 'Tout modifier',

	// Import.
	'Import' => 'Importer',
	'File upload' => 'Importer un fichier',
	'From server' => 'Depuis le serveur',
	'Webserver file %s' => 'Fichier %s du serveur Web',
	'Run file' => 'Exécuter le fichier',
	'File does not exist.' => 'Le fichier est introuvable.',
	'File uploads are disabled.' => 'L\'importation de fichier est désactivée.',
	'Unable to upload a file.' => 'Impossible d\'importer le fichier.',
	'Maximum allowed file size is %sB.' => 'La taille maximale des fichiers est de %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Données POST trop grandes. Réduisez la taille des données ou augmentez la valeur de %s dans la configuration de PHP.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Vous pouvez uploader un gros fichier SQL par FTP et ensuite l\'importer depuis le serveur.',
	'File must be in UTF-8 encoding.' => 'Les fichiers doivent être encodés en UTF-8.',
	'You are offline.' => 'Vous êtes hors ligne.',
	'%d row(s) have been imported.' => [
		'%d ligne a été importée.',
		'%d lignes ont été importées.',
	],

	// Export.
	'Export' => 'Exporter',
	'Output' => 'Sortie',
	'open' => 'ouvrir',
	'save' => 'enregistrer',
	'Format' => 'Format',
	'Data' => 'Données',

	// Databases.
	'Database' => 'Base de données',
	'DB' => 'BD',
	'Use' => 'Utiliser',
	'Invalid database.' => 'Base de données invalide.',
	'Alter database' => 'Modifier la base de données',
	'Create database' => 'Créer une base de données',
	'Database schema' => 'Schéma de la base de données',
	'Permanent link' => 'Lien permanent',
	'Database has been dropped.' => 'La base de données a été supprimée.',
	'Databases have been dropped.' => 'Les bases de données ont été supprimées.',
	'Database has been created.' => 'La base de données a été créée.',
	'Database has been renamed.' => 'La base de données a été renommée.',
	'Database has been altered.' => 'La base de données a été modifiée.',
	// SQLite errors.
	'File exists.' => 'Le fichier existe.',
	'Please use one of the extensions %s.' => 'Veuillez utiliser l\'une des extensions %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Schéma',
	'Schemas' => 'Schémas',
	'No schemas.' => 'Aucun schéma.',
	'Show schema' => 'Afficher le schéma',
	'Alter schema' => 'Modifier le schéma',
	'Create schema' => 'Créer un schéma',
	'Schema has been dropped.' => 'Le schéma a été supprimé.',
	'Schema has been created.' => 'Le schéma a été créé.',
	'Schema has been altered.' => 'Le schéma a été modifié.',
	'Invalid schema.' => 'Schéma invalide.',

	// Table list.
	'Engine' => 'Moteur',
	'engine' => 'moteur',
	'Collation' => 'Interclassement',
	'collation' => 'interclassement',
	'Data Length' => 'Longueur des données',
	'Index Length' => 'Longueur de l\'index',
	'Data Free' => 'Espace inutilisé',
	'Rows' => 'Lignes',
	'%d in total' => '%d au total',
	'Analyze' => 'Analyser',
	'Optimize' => 'Optimiser',
	'Vacuum' => 'Vide',
	'Check' => 'Vérifier',
	'Repair' => 'Réparer',
	'Truncate' => 'Tronquer',
	'Tables have been truncated.' => 'Les tables ont été tronquées.',
	'Move to other database' => 'Déplacer vers une autre base de données',
	'Move' => 'Déplacer',
	'Tables have been moved.' => 'Les tables ont été déplacées.',
	'Copy' => 'Copier',
	'Tables have been copied.' => 'Les tables ont été copiées.',
	'overwrite' => 'écraser',

	// Tables.
	'Tables' => 'Tables',
	'Tables and views' => 'Tables et vues',
	'Table' => 'Table',
	'No tables.' => 'Aucune table.',
	'Alter table' => 'Modifier la table',
	'Create table' => 'Créer une table',
	'Table has been dropped.' => 'La table a été effacée.',
	'Tables have been dropped.' => 'Les tables ont été effacées.',
	'Tables have been optimized.' => 'Les tables ont bien été optimisées.',
	'Table has been altered.' => 'La table a été modifiée.',
	'Table has been created.' => 'La table a été créée.',
	'Table name' => 'Nom de la table',
	'Name' => 'Nom',
	'Show structure' => 'Afficher la structure',
	'Column name' => 'Nom de la colonne',
	'Type' => 'Type',
	'Length' => 'Longueur',
	'Auto Increment' => 'Incrément automatique',
	'Options' => 'Options',
	'Comment' => 'Commentaire',
	'Default value' => 'Valeur par défaut',
	'Drop' => 'Supprimer',
	'Drop %s?' => 'Supprimer %s?',
	'Are you sure?' => 'Êtes-vous certain(e) ?',
	'Size' => 'Taille',
	'Compute' => 'Calcul',
	'Move up' => 'Déplacer vers le haut',
	'Move down' => 'Déplacer vers le bas',
	'Remove' => 'Effacer',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Le nombre maximum de champs est dépassé. Veuillez augmenter %s.',

	// Views.
	'View' => 'Vue',
	'Materialized view' => 'Vue matérialisée',
	'View has been dropped.' => 'La vue a été effacée.',
	'View has been altered.' => 'La vue a été modifiée.',
	'View has been created.' => 'La vue a été créée.',
	'Alter view' => 'Modifier une vue',
	'Create view' => 'Créer une vue',

	// Partitions.
	'Partition by' => 'Partitionner par',
	'Partition' => 'Partition',
	'Partitions' => 'Partitions',
	'Partition name' => 'Nom de la partition',
	'Values' => 'Valeurs',

	// Indexes.
	'Indexes' => 'Index',
	'Indexes have been altered.' => 'Index modifiés.',
	'Alter indexes' => 'Modifier les index',
	'Add next' => 'Ajouter le prochain',
	'Index Type' => 'Type d\'index',
	'length' => 'longueur',

	// Foreign keys.
	'Foreign keys' => 'Clés étrangères',
	'Foreign key' => 'Clé étrangère',
	'Foreign key has been dropped.' => 'La clé étrangère a été effacée.',
	'Foreign key has been altered.' => 'La clé étrangère a été modifiée.',
	'Foreign key has been created.' => 'La clé étrangère a été créée.',
	'Target table' => 'Table visée',
	'Change' => 'Modifier',
	'Source' => 'Source',
	'Target' => 'Cible',
	'Add column' => 'Ajouter une colonne',
	'Alter' => 'Modifier',
	'Add foreign key' => 'Ajouter une clé étrangère',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Les colonnes de source et de destination doivent être du même type, il doit y avoir un index sur les colonnes de destination et les données référencées doivent exister.',

	// Routines.
	'Routines' => 'Routines',
	'Routine has been called, %d row(s) affected.' => [
		'La routine a été exécutée, %d ligne modifiée.',
		'La routine a été exécutée, %d lignes modifiées.',
	],
	'Call' => 'Appeler',
	'Parameter name' => 'Nom du paramètre',
	'Create procedure' => 'Créer une procédure',
	'Create function' => 'Créer une fonction',
	'Routine has been dropped.' => 'La routine a été supprimée.',
	'Routine has been altered.' => 'La routine a été modifiée.',
	'Routine has been created.' => 'La routine a été créée.',
	'Alter function' => 'Modifier la fonction',
	'Alter procedure' => 'Modifier la procédure',
	'Return type' => 'Type de retour',

	// Events.
	'Events' => 'Évènements',
	'Event' => 'Évènement',
	'Event has been dropped.' => 'L\'évènement a été supprimé.',
	'Event has been altered.' => 'L\'évènement a été modifié.',
	'Event has been created.' => 'L\'évènement a été créé.',
	'Alter event' => 'Modifier un évènement',
	'Create event' => 'Créer un évènement',
	'At given time' => 'À un moment précis',
	'Every' => 'Chaque',
	'Schedule' => 'Horaire',
	'Start' => 'Démarrer',
	'End' => 'Terminer',
	'On completion preserve' => 'Conserver quand complété',

	// Sequences (PostgreSQL).
	'Sequences' => 'Séquences',
	'Create sequence' => 'Créer une séquence',
	'Sequence has been dropped.' => 'La séquence a été supprimée.',
	'Sequence has been created.' => 'La séquence a été créée.',
	'Sequence has been altered.' => 'La séquence a été modifiée.',
	'Alter sequence' => 'Modifier la séquence',

	// User types (PostgreSQL)
	'User types' => 'Types utilisateur',
	'Create type' => 'Créer un type',
	'Type has been dropped.' => 'Le type a été supprimé.',
	'Type has been created.' => 'Le type a été créé.',
	'Alter type' => 'Modifier le type',

	// Triggers.
	'Triggers' => 'Déclencheurs',
	'Add trigger' => 'Ajouter un déclencheur',
	'Trigger has been dropped.' => 'Le déclencheur a été supprimé.',
	'Trigger has been altered.' => 'Le déclencheur a été modifié.',
	'Trigger has been created.' => 'Le déclencheur a été créé.',
	'Alter trigger' => 'Modifier un déclencheur',
	'Create trigger' => 'Ajouter un déclencheur',

	// Table check constraints.
	'Checks' => 'Checks',
	'Create check' => 'Créer un check',
	'Alter check' => 'Modifier le check',
	'Check has been created.' => 'Le check a été créé.',
	'Check has been altered.' => 'Le check a été modifié.',
	'Check has been dropped.' => 'Le check a été supprimé.',

	// Selection.
	'Select data' => 'Afficher les données',
	'Select' => 'Sélectionner',
	'Functions' => 'Fonctions',
	'Aggregation' => 'Agrégation',
	'Search' => 'Rechercher',
	'anywhere' => 'n\'importe où',
	'Sort' => 'Trier',
	'descending' => 'décroissant',
	'Limit' => 'Limite',
	'Limit rows' => 'Limiter les lignes',
	'Text length' => 'Longueur du texte',
	'Action' => 'Action',
	'Full table scan' => 'Scan de toute la table',
	'Unable to select the table' => 'Impossible de sélectionner la table',
	'Search data in tables' => 'Rechercher dans les tables',
	'as a regular expression' => 'sous forme d\'expression régulière',
	'No rows.' => 'Aucun résultat.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d ligne',
		'%d lignes',
	],
	'Page' => 'Page',
	'last' => 'dernière',
	'Load more data' => 'Charger plus de données',
	'Loading' => 'Chargement',
	'Whole result' => 'Résultat entier',
	'%d byte(s)' => [
		'%d octet',
		'%d octets',
	],

	// In-place editing in selection.
	'Modify' => 'Modifier',
	'Ctrl+click on a value to modify it.' => 'Ctrl+cliquez sur une valeur pour la modifier.',
	'Use edit link to modify this value.' => 'Utilisez le lien "modifier" pour modifier cette valeur.',

	// Editing.
	'New item' => 'Nouvel élément',
	'Edit' => 'Modifier',
	'original' => 'original',
	// label for value '' in enum data type
	'empty' => 'vide',
	'Insert' => 'Insérer',
	'Save' => 'Enregistrer',
	'Save and continue edit' => 'Enr. et continuer édition',
	'Save and insert next' => 'Enr. et insérer prochain',
	'Saving' => 'Enregistrement',
	'Selected' => 'Sélectionné(s)',
	'Clone' => 'Cloner',
	'Delete' => 'Effacer',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'L\'élément%s a été inséré.',
	'Item has been deleted.' => 'L\'élément a été supprimé.',
	'Item has been updated.' => 'L\'élément a été modifié.',
	'%d item(s) have been affected.' => [
		'%d élément a été modifié.',
		'%d éléments ont été modifiés.',
	],
	'You have no privileges to update this table.' => 'Vous n\'avez pas les droits pour mettre à jour cette table.',

	// Data type descriptions.
	'Numbers' => 'Nombres',
	'Date and time' => 'Date et heure',
	'Strings' => 'Chaînes',
	'Binary' => 'Binaires',
	'Lists' => 'Listes',
	'Network' => 'Réseau',
	'Geometry' => 'Géométrie',
	'Relations' => 'Relations',

	// Editor - data values.
	'now' => 'maintenant',
	'yes' => 'oui',
	'no' => 'non',

	// Settings.
	'Settings' => 'Paramètres',
	'Default' => 'Défaut',
	'Color scheme' => 'Schéma de couleurs',
	'By system' => 'Par le système',
	'Light' => 'Clair',
	'Dark' => 'Sombre',
	'Navigation mode' => 'Mode de navigation',
	'Simple' => 'Simple',
	'Dual' => 'Double',
	'Reversed' => 'Inversé',
	'Layout of main navigation with table links.' => 'Disposition de la navigation principale avec liens de la table.',
	'Table links' => 'Liens de la table',
	'Primary action for all table links.' => 'Action principale pour tous les liens de la table.',
	'Records per page' => 'Enregistrements par page',
	'Default number of records displayed in data table.' => 'Nombre d\'enregistrements affichés par défaut dans la table de données.',
	'Enum as select' => 'Enum comme liste de sélection',
	'Never' => 'Jamais',
	'Always' => 'Toujours',
	'More values than %d' => 'Plus de valeurs que %d',
	'Threshold for displaying a selection menu for enum fields.' => 'Seuil pour afficher un menu de sélection pour les champs enum.',

	// Plugins.
	'One Time Password' => 'Mot de passe à usage unique',
	'Enter OTP code.' => 'Saisissez le code OTP.',
	'Invalid OTP code.' => 'Code OTP invalide.',
	'Access denied.' => 'Accès refusé.',
	'JSON previews' => 'Aperçus JSON',
	'Data table' => 'Table de données',
	'Edit form' => 'Formulaire d\'édition',
];
