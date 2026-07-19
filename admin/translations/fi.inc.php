<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5.$3.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'PP.KK.VVVV',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'Järjestelmä',
	'Server' => 'Palvelin',
	'Username' => 'Käyttäjänimi',
	'Password' => 'Salasana',
	'Permanent login' => 'Haluan pysyä kirjautuneena',
	'Login' => 'Kirjaudu',
	'Logout' => 'Kirjaudu ulos',
	'Logged as: %s' => 'Olet kirjautunut käyttäjänä: %s',
	'Logout successful.' => 'Uloskirjautuminen onnistui.',
	'There is a space in the input password which might be the cause.' => 'Syynä voi olla syötetyssä salasanassa oleva välilyönti.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ei tue pääsyä tietokantaan ilman salasanaa, katso tarkemmin <a href="https://www.adminneo.org/password"%s>täältä</a>.',
	'Database does not support password.' => 'Tietokanta ei tue salasanaa.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Liian monta epäonnistunutta sisäänkirjautumisyritystä, kokeile uudestaan %d minuutin kuluttua.',
		'Liian monta epäonnistunutta sisäänkirjautumisyritystä, kokeile uudestaan %d minuutin kuluttua.',
	],
	'Invalid CSRF token. Send the form again.' => 'Virheellinen CSRF-vastamerkki. Lähetä lomake uudelleen.',
	'If you did not send this request from AdminNeo then close this page.' => 'Jollet lähettänyt tämä pyyntö AdminNeo, sulje tämä sivu.',
	'The action will be performed after successful login with the same credentials.' => 'Toiminto suoritetaan sen jälkeen, kun on onnistuttu kirjautumaan samoilla käyttäjätunnuksilla uudestaan.',

	// Connection.
	'No extension' => 'Ei laajennusta',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Mitään tuetuista PHP-laajennuksista (%s) ei ole käytettävissä.',
	'Connecting to privileged ports is not allowed.' => 'Yhteydet etuoikeutettuihin portteihin eivät ole sallittuja.',
	'Session support must be enabled.' => 'Istuntotuki on oltava päällä.',
	'Session expired, please login again.' => 'Istunto vanhentunut, kirjaudu uudelleen.',
	'%s version: %s through PHP extension %s' => '%s versio: %s PHP-laajennuksella %s',

	// Settings.
	'Language' => 'Kieli',

	'Refresh' => 'Virkistä',

	// Privileges.
	'Privileges' => 'Oikeudet',
	'Create user' => 'Luo käyttäjä',
	'User has been dropped.' => 'Käyttäjä poistettiin.',
	'User has been altered.' => 'Käyttäjää muutettiin.',
	'User has been created.' => 'Käyttäjä luotiin.',
	'Hashed' => 'Hashed',

	// Server.
	'Process list' => 'Prosessilista',
	'%d process(es) have been killed.' => [
		'%d prosessi lopetettu.',
		'%d prosessia lopetettu..',
	],
	'Kill' => 'Lopeta',
	'Variables' => 'Muuttujat',
	'Status' => 'Tila',

	// Structure.
	'Column' => 'Sarake',
	'Routine' => 'Rutiini',
	'Grant' => 'Myönnä',
	'Revoke' => 'Kiellä',

	// Queries.
	'SQL command' => 'SQL-komento',
	'%d query(s) executed OK.' => [
		'%d kysely onnistui.',
		'%d kyselyä onnistui.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Kysely onnistui, kohdistui %d riviin.',
		'Kysely onnistui, kohdistui %d riviin.',
	],
	'No commands to execute.' => 'Ei komentoja suoritettavana.',
	'Error in query' => 'Virhe kyselyssä',
	'Unknown error.' => 'Tuntematon virhe.',
	'Warnings' => 'Varoitukset',
	'%s queries are not supported.' => '%s-komennolla tehtyjä kyselyjä ei tueta.',
	'Execute' => 'Suorita',
	'Stop on error' => 'Pysähdy virheeseen',
	'Show only errors' => 'Näytä vain virheet',
	'Time' => 'Aika',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Historia',
	'Clear' => 'Tyhjennä',
	'Edit all' => 'Muokkaa kaikkia',

	// Import.
	'Import' => 'Tuonti',
	'File upload' => 'Tiedoston lataus palvelimelle',
	'From server' => 'Verkkopalvelimella Adminer-kansiossa oleva tiedosto',
	'Webserver file %s' => 'Verkkopalvelintiedosto %s',
	'Run file' => 'Suorita tämä',
	'File does not exist.' => 'Tiedostoa ei ole.',
	'File uploads are disabled.' => 'Tiedostojen lataaminen palvelimelle on estetty.',
	'Unable to upload a file.' => 'Tiedostoa ei voida ladata palvelimelle.',
	'Maximum allowed file size is %sB.' => 'Suurin sallittu tiedostokoko on %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Liian suuri POST-datamäärä. Pienennä dataa tai kasvata arvoa %s konfigurointitiedostossa.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Voit ladata suuren SQL-tiedoston FTP:n kautta ja tuoda sen sitten palvelimelta.',
	'File must be in UTF-8 encoding.' => 'Tiedoston täytyy olla UTF-8-muodossa.',
	'You are offline.' => 'Olet offline-tilassa.',
	'%d row(s) have been imported.' => [
		'%d rivi tuotiin.',
		'%d riviä tuotiin.',
	],

	// Export.
	'Export' => 'Vienti',
	'Output' => 'Tulos',
	'open' => 'avaa',
	'save' => 'tallenna',
	'Format' => 'Muoto',
	'Data' => 'Data',

	// Databases.
	'Database' => 'Tietokanta',
	'DB' => 'TK',
	'Use' => 'Käytä',
	'Invalid database.' => 'Tietokanta ei kelpaa.',
	'Alter database' => 'Muuta tietokantaa',
	'Create database' => 'Luo tietokanta',
	'Database schema' => 'Tietokantakaava',
	'Permanent link' => 'Pysyvä linkki',
	'Database has been dropped.' => 'Tietokanta on poistettu.',
	'Databases have been dropped.' => 'Tietokannat on poistettu.',
	'Database has been created.' => 'Tietokanta on luotu.',
	'Database has been renamed.' => 'Tietokanta on nimetty uudelleen.',
	'Database has been altered.' => 'Tietokantaa on muutettu.',
	// SQLite errors.
	'File exists.' => 'Tiedosto on olemassa.',
	'Please use one of the extensions %s.' => 'Käytä jotain %s-laajennuksista.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Kaava',
	'Alter schema' => 'Muuta kaavaa',
	'Create schema' => 'Luo kaava',
	'Schema has been dropped.' => 'Kaava poistettiin.',
	'Schema has been created.' => 'Kaava luotiin.',
	'Schema has been altered.' => 'Kaavaa muutettiin.',
	'Invalid schema.' => 'Kaava ei kelpaa.',

	// Table list.
	'Engine' => 'Moottori',
	'engine' => 'moottori',
	'Collation' => 'Kollaatio',
	'collation' => 'kollaatio',
	'Data Length' => 'Datan pituus',
	'Index Length' => 'Indeksin pituus',
	'Data Free' => 'Vapaa tila',
	'Rows' => 'Riviä',
	'%d in total' => '%d kaikkiaan',
	'Analyze' => 'Analysoi',
	'Optimize' => 'Optimoi',
	'Vacuum' => 'Siivoa',
	'Check' => 'Tarkista',
	'Repair' => 'Korjaa',
	'Truncate' => 'Tyhjennä',
	'Tables have been truncated.' => 'Taulujen sisältö on tyhjennetty.',
	'Move to other database' => 'Siirrä toiseen tietokantaan',
	'Move' => 'Siirrä',
	'Tables have been moved.' => 'Taulut on siirretty.',
	'Copy' => 'Kopioi',
	'Tables have been copied.' => 'Taulut on kopioitu.',
	'overwrite' => 'kirjoittaen päälle',

	// Tables.
	'Tables' => 'Taulut',
	'Tables and views' => 'Taulut ja näkymät',
	'Table' => 'Taulu',
	'No tables.' => 'Ei tauluja.',
	'Alter table' => 'Muuta taulua',
	'Create table' => 'Luo taulu',
	'Table has been dropped.' => 'Taulu on poistettu.',
	'Tables have been dropped.' => 'Tauluja on poistettu.',
	'Tables have been optimized.' => 'Taulut on optimoitu.',
	'Table has been altered.' => 'Taulua on muutettu.',
	'Table has been created.' => 'Taulu on luotu.',
	'Table name' => 'Taulun nimi',
	'Name' => 'Nimi',
	'Show structure' => 'Näytä rakenne',
	'Column name' => 'Sarakkeen nimi',
	'Type' => 'Tyyppi',
	'Length' => 'Pituus',
	'Auto Increment' => 'Automaattinen lisäys',
	'Options' => 'Asetukset',
	'Comment' => 'Kommentit',
	'Default value' => 'Oletusarvo',
	'Drop' => 'Poista',
	'Drop %s?' => 'Poistetaanko %s?',
	'Are you sure?' => 'Oletko varma?',
	'Size' => 'Koko',
	'Compute' => 'Laske',
	'Move up' => 'Siirrä ylös',
	'Move down' => 'Siirrä alas',
	'Remove' => 'Poista',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Kenttien sallittu enimmäismäärä ylitetty. Kasvata arvoa %s.',

	// Views.
	'View' => 'Näkymä',
	'Materialized view' => 'Materialisoitunut näkymä',
	'View has been dropped.' => 'Näkymä on poistettu.',
	'View has been altered.' => 'Näkymää on muutettu.',
	'View has been created.' => 'Näkymä on luotu.',
	'Alter view' => 'Muuta näkymää',
	'Create view' => 'Luo näkymä',

	// Partitions.
	'Partition by' => 'Osioi arvolla',
	'Partitions' => 'Osiot',
	'Partition name' => 'Osion nimi',
	'Values' => 'Arvot',

	// Indexes.
	'Indexes' => 'Indeksit',
	'Indexes have been altered.' => 'Indeksejä on muutettu.',
	'Alter indexes' => 'Muuta indeksejä',
	'Add next' => 'Lisää seuraava',
	'Index Type' => 'Indeksityyppi',
	'length' => 'pituus',

	// Foreign keys.
	'Foreign keys' => 'Vieraat avaimet',
	'Foreign key' => 'Vieras avain',
	'Foreign key has been dropped.' => 'Vieras avain on poistettu.',
	'Foreign key has been altered.' => 'Vierasta avainta on muutettu.',
	'Foreign key has been created.' => 'Vieras avain on luotu.',
	'Target table' => 'Kohdetaulu',
	'Change' => 'Muuta',
	'Source' => 'Lähde',
	'Target' => 'Kohde',
	'Add column' => 'Lisää sarake',
	'Alter' => 'Muuta',
	'Add foreign key' => 'Lisää vieras avain',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Lähde- ja kohdesarakkeiden tulee olla samaa tietotyyppiä, kohdesarakkeisiin tulee olla indeksi ja dataa, johon viitataan, täytyy olla.',

	// Routines.
	'Routines' => 'Rutiinit',
	'Routine has been called, %d row(s) affected.' => [
		'Rutiini kutsuttu, kohdistui %d riviin.',
		'Rutiini kutsuttu, kohdistui %d riviin.',
	],
	'Call' => 'Kutsua',
	'Parameter name' => 'Parametrin nimi',
	'Create procedure' => 'Luo proseduuri',
	'Create function' => 'Luo funktio',
	'Routine has been dropped.' => 'Rutiini on poistettu.',
	'Routine has been altered.' => 'Rutiinia on muutettu.',
	'Routine has been created.' => 'Rutiini on luotu.',
	'Alter function' => 'Muuta funktiota',
	'Alter procedure' => 'Muuta proseduuria',
	'Return type' => 'Palautustyyppi',

	// Events.
	'Events' => 'Tapahtumat',
	'Event' => 'Tapahtuma',
	'Event has been dropped.' => 'Tapahtuma on poistettu.',
	'Event has been altered.' => 'Tapahtumaa on muutettu.',
	'Event has been created.' => 'Tapahtuma on luotu.',
	'Alter event' => 'Muuta tapahtumaa',
	'Create event' => 'Luo tapahtuma',
	'At given time' => 'Tiettynä aikana',
	'Every' => 'Joka',
	'Schedule' => 'Aikataulu',
	'Start' => 'Aloitus',
	'End' => 'Lopetus',
	'On completion preserve' => 'Säilytä, kun valmis',

	// Sequences (PostgreSQL).
	'Sequences' => 'Sekvenssit',
	'Create sequence' => 'Luo sekvenssi',
	'Sequence has been dropped.' => 'Sekvenssi on poistettu.',
	'Sequence has been created.' => 'Sekvenssi on luotu.',
	'Sequence has been altered.' => 'Sekvenssiä on muutettu.',
	'Alter sequence' => 'Muuta sekvenssiä',

	// User types (PostgreSQL)
	'User types' => 'Käyttäjän tyypit',
	'Create type' => 'Luo tyyppi',
	'Type has been dropped.' => 'Tyyppi poistettiin.',
	'Type has been created.' => 'Tyyppi luotiin.',
	'Alter type' => 'Muuta tyyppiä',

	// Triggers.
	'Triggers' => 'Liipaisimet',
	'Add trigger' => 'Lisää liipaisin',
	'Trigger has been dropped.' => 'Liipaisin on poistettu.',
	'Trigger has been altered.' => 'Liipaisinta on muutettu.',
	'Trigger has been created.' => 'Liipaisin on luotu.',
	'Alter trigger' => 'Muuta liipaisinta',
	'Create trigger' => 'Luo liipaisin',

	// Table check constraints.

	// Selection.
	'Select data' => 'Valitse data',
	'Select' => 'Valitse',
	'Functions' => 'Funktiot',
	'Aggregation' => 'Aggregaatiot',
	'Search' => 'Hae',
	'anywhere' => 'kaikkialta',
	'Sort' => 'Lajittele',
	'descending' => 'alenevasti',
	'Limit' => 'Raja',
	'Limit rows' => 'Rajoita rivimäärää',
	'Text length' => 'Tekstin pituus',
	'Action' => 'Toimenpide',
	'Full table scan' => 'Koko taulun läpikäynti',
	'Unable to select the table' => 'Taulua ei voitu valita',
	'Search data in tables' => 'Hae dataa tauluista',
	'No rows.' => 'Ei rivejä.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d rivi',
		'%d riviä',
	],
	'Page' => 'Sivu',
	'last' => 'viimeinen',
	'Load more data' => 'Lataa lisää dataa',
	'Loading' => 'Ladataan',
	'Whole result' => 'Koko tulos',
	'%d byte(s)' => [
		'%d tavu',
		'%d tavua',
	],

	// In-place editing in selection.
	'Modify' => 'Muuta',
	'Ctrl+click on a value to modify it.' => 'Ctrl+napsauta arvoa muuttaaksesi.',
	'Use edit link to modify this value.' => 'Käytä muokkaa-linkkiä muuttaaksesi tätä arvoa.',

	// Editing.
	'New item' => 'Uusi tietue',
	'Edit' => 'Muokkaa',
	'original' => 'alkuperäinen',
	// label for value '' in enum data type
	'empty' => 'tyhjä',
	'Insert' => 'Lisää',
	'Save' => 'Tallenna',
	'Save and continue edit' => 'Tallenna ja jatka muokkaamista',
	'Save and insert next' => 'Tallenna ja lisää seuraava',
	'Saving' => 'Tallennetaan',
	'Selected' => 'Valitut',
	'Clone' => 'Kloonaa',
	'Delete' => 'Poista',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Tietue%s lisättiin.',
	'Item has been deleted.' => 'Tietue poistettiin.',
	'Item has been updated.' => 'Tietue päivitettiin.',
	'%d item(s) have been affected.' => [
		'Kohdistui %d tietueeseen.',
		'Kohdistui %d tietueeseen.',
	],
	'You have no privileges to update this table.' => 'Sinulla ei ole oikeutta päivittää tätä taulua.',

	// Data type descriptions.
	'Numbers' => 'Numerot',
	'Date and time' => 'Päiväys ja aika',
	'Strings' => 'Merkkijonot',
	'Binary' => 'Binäärinen',
	'Lists' => 'Luettelot',
	'Network' => 'Verkko',
	'Geometry' => 'Geometria',
	'Relations' => 'Suhteet',

	// Editor - data values.
	'now' => 'nyt',
	'yes' => 'kyllä',
	'no' => 'ei',

	// Plugins.
];
