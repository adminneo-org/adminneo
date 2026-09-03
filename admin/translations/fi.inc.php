<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5.$3.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'PP.KK.VVVV', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s:n täytyy palauttaa taulukko.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s:n ja %s:n täytyy palauttaa olio, joka on luotu metodilla %s.', // by Claude Fable 5.1

	// Login
	'System' => 'Järjestelmä',
	'Server' => 'Palvelin',
	'Username' => 'Käyttäjänimi',
	'Password' => 'Salasana',
	'Permanent login' => 'Haluan pysyä kirjautuneena',
	'Login' => 'Kirjaudu',
	'Logout' => 'Kirjaudu ulos',
	'Logged as: %s' => 'Olet kirjautunut käyttäjänä: %s',
	'Logout successful.' => 'Uloskirjautuminen onnistui.',
	'hostname[:port] or :socket' => 'hostname[:port] tai :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Virheellinen palvelin tai tunnukset.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Syynä voi olla syötetyssä salasanassa oleva välilyönti.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ei tue pääsyä tietokantaan ilman salasanaa, katso tarkemmin <a href="https://www.adminneo.org/password"%s>täältä</a>.',
	'Database does not support password.' => 'Tietokanta ei tue salasanaa.',
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Liian monta epäonnistunutta sisäänkirjautumisyritystä, kokeile uudestaan %d minuutin kuluttua.',
	'Invalid permanent login, please login again.' => 'Virheellinen pysyvä kirjautuminen, kirjaudu uudelleen.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Virheellinen CSRF-vastamerkki. Lähetä lomake uudelleen.',
	'If you did not send this request from AdminNeo then close this page.' => 'Jollet lähettänyt tämä pyyntö AdminNeo, sulje tämä sivu.',
	'The action will be performed after successful login with the same credentials.' => 'Toiminto suoritetaan sen jälkeen, kun on onnistuttu kirjautumaan samoilla käyttäjätunnuksilla uudestaan.',

	// Connection
	'No extension' => 'Ei laajennusta',
	'None of the supported PHP extensions (%s) are available.' => 'Mitään tuetuista PHP-laajennuksista (%s) ei ole käytettävissä.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Yhteydet etuoikeutettuihin portteihin eivät ole sallittuja.',
	'Session support must be enabled.' => 'Istuntotuki on oltava päällä.',
	'Session expired, please login again.' => 'Istunto vanhentunut, kirjaudu uudelleen.',
	'%s version: %s through PHP extension %s' => '%s versio: %s PHP-laajennuksella %s',

	// Settings
	'Language' => 'Kieli',

	'Menu' => 'Valikko', // by Claude Opus 5
	'Home' => 'Etusivu', // by Claude Opus 5
	'Refresh' => 'Virkistä',
	'Info' => 'Tiedot', // by Claude Opus 5
	'More information.' => 'Lisätietoja.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Oikeudet',
	'Create user' => 'Luo käyttäjä',
	'User has been dropped.' => 'Käyttäjä poistettiin.',
	'User has been altered.' => 'Käyttäjää muutettiin.',
	'User has been created.' => 'Käyttäjä luotiin.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Prosessilista',
	'%d process(es) have been killed.' => [
		'%d prosessi lopetettu.',
		'%d prosessia lopetettu..',
	],
	'Kill' => 'Lopeta',
	'Variables' => 'Muuttujat',
	'Status' => 'Tila',

	// Structure
	'Column' => 'Sarake',
	'Columns' => 'Sarakkeet', // by Claude Fable 5
	'Routine' => 'Rutiini',
	'Grant' => 'Myönnä',
	'Revoke' => 'Kiellä',

	// Queries
	'SQL command' => 'SQL-komento',
	'HTTP request' => 'HTTP-pyyntö', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d kysely onnistui.',
		'%d kyselyä onnistui.',
	],
	'Query executed OK, %d row(s) affected.' => 'Kysely onnistui, kohdistui %d riviin.',
	'No commands to execute.' => 'Ei komentoja suoritettavana.',
	'Error in query' => 'Virhe kyselyssä',
	'Unknown error.' => 'Tuntematon virhe.',
	'Warnings' => 'Varoitukset',
	'%s queries are not supported.' => '%s-komennolla tehtyjä kyselyjä ei tueta.',
	'Execute' => 'Suorita',
	'Stop on error' => 'Pysähdy virheeseen',
	'Show only errors' => 'Näytä vain virheet',
	'Time' => 'Aika',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Historia',
	'Clear' => 'Tyhjennä',
	'Edit all' => 'Muokkaa kaikkia',

	// Import
	'Import' => 'Tuonti',
	'File upload' => 'Tiedoston lataus palvelimelle',
	'From server' => 'Verkkopalvelimella Adminer-kansiossa oleva tiedosto',
	'Webserver file %s' => 'Verkkopalvelintiedosto %s',
	'Run file' => 'Suorita tämä',
	'File does not exist.' => 'Tiedostoa ei ole.',
	'File uploads are disabled.' => 'Tiedostojen lataaminen palvelimelle on estetty.',
	'Unable to upload a file.' => 'Tiedostoa ei voida ladata palvelimelle.',
	'Maximum allowed file size is %sB.' => 'Suurin sallittu tiedostokoko on %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Tiedostojen enimmäismäärä on %d. Valitse vähemmän tiedostoja tai kasvata arvoa %s konfigurointitiedostossa.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Tiedostojen suurin yhteiskoko on %s. Valitse pienempiä tiedostoja tai kasvata arvoa %s konfigurointitiedostossa.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Liian suuri POST-datamäärä. Pienennä dataa tai kasvata arvoa %s konfigurointitiedostossa.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Voit ladata suuren SQL-tiedoston FTP:n kautta ja tuoda sen sitten palvelimelta.',
	'File must be in UTF-8 encoding.' => 'Tiedoston täytyy olla UTF-8-muodossa.',
	'You are offline.' => 'Olet offline-tilassa.',
	'%d row(s) have been imported.' => [
		'%d rivi tuotiin.',
		'%d riviä tuotiin.',
	],

	// Export
	'Export' => 'Vienti',
	'Output' => 'Tulos',
	'open' => 'avaa',
	'save' => 'tallenna',
	'Format' => 'Muoto',
	'Data' => 'Data',

	// Databases
	'Database' => 'Tietokanta',
	'database' => 'tietokanta', // by Claude Opus 5
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

	// SQLite errors
	'File exists.' => 'Tiedosto on olemassa.',
	'Please use one of the extensions %s.' => 'Käytä jotain %s-laajennuksista.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Kaava',
	'schema' => 'kaava', // by Claude Opus 5
	'Schemas' => 'Kaavat', // by Claude Opus 5
	'No schemas.' => 'Ei kaavoja.', // by Claude Opus 5
	'Show schema' => 'Näytä kaava', // by Claude Opus 5
	'Alter schema' => 'Muuta kaavaa',
	'Create schema' => 'Luo kaava',
	'Schema has been dropped.' => 'Kaava poistettiin.',
	'Schema has been created.' => 'Kaava luotiin.',
	'Schema has been altered.' => 'Kaavaa muutettiin.',
	'Invalid schema.' => 'Kaava ei kelpaa.',

	// Table list
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
	'Truncate Cascade' => 'Tyhjennä (cascade)', // by Claude Fable 5.1
	'Tables have been truncated.' => 'Taulujen sisältö on tyhjennetty.',
	'Move to other database' => 'Siirrä toiseen tietokantaan',
	'Move' => 'Siirrä',
	'Tables have been moved.' => 'Taulut on siirretty.',
	'Copy' => 'Kopioi',
	'Tables have been copied.' => 'Taulut on kopioitu.',
	'overwrite' => 'kirjoittaen päälle',

	// Tables
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

	// Views
	'View' => 'Näkymä',
	'Materialized view' => 'Materialisoitunut näkymä',
	'View has been dropped.' => 'Näkymä on poistettu.',
	'View has been altered.' => 'Näkymää on muutettu.',
	'View has been created.' => 'Näkymä on luotu.',
	'Alter view' => 'Muuta näkymää',
	'Create view' => 'Luo näkymä',

	// Partitions
	'Partition by' => 'Osioi arvolla',
	'Partition' => 'Osio', // by Claude Opus 5
	'Partitions' => 'Osiot',
	'Partition name' => 'Osion nimi',
	'Values' => 'Arvot',
	'Inherited tables' => 'Perityt taulut', // by Claude Opus 5
	'Inherited from' => 'Peritty taulusta', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Indeksit',
	'Indexes have been altered.' => 'Indeksejä on muutettu.',
	'Alter indexes' => 'Muuta indeksejä',
	'Add next' => 'Lisää seuraava',
	'Index Type' => 'Indeksityyppi',
	'length' => 'pituus',
	'operator class' => 'operaattoriluokka', // by Claude Fable 5
	'Algorithm' => 'Algoritmi', // by Claude Fable 5
	'Condition' => 'Ehto', // by Claude Fable 5

	// Foreign keys
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

	// Routines
	'Routines' => 'Rutiinit',
	'Routine has been called, %d row(s) affected.' => 'Rutiini kutsuttu, kohdistui %d riviin.',
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

	// Events
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

	// Sequences (PostgreSQL)
	'Sequences' => 'Sekvenssit',
	'Create sequence' => 'Luo sekvenssi',
	'Sequence has been dropped.' => 'Sekvenssi on poistettu.',
	'Sequence has been created.' => 'Sekvenssi on luotu.',
	'Sequence has been altered.' => 'Sekvenssiä on muutettu.',
	'Alter sequence' => 'Muuta sekvenssiä',

	// User-defined types (PostgreSQL)
	'User types' => 'Käyttäjän tyypit',
	'Create type' => 'Luo tyyppi',
	'Type has been dropped.' => 'Tyyppi poistettiin.',
	'Type has been created.' => 'Tyyppi luotiin.',
	'Alter type' => 'Muuta tyyppiä',

	// Triggers
	'Triggers' => 'Liipaisimet',
	'Add trigger' => 'Lisää liipaisin',
	'Trigger has been dropped.' => 'Liipaisin on poistettu.',
	'Trigger has been altered.' => 'Liipaisinta on muutettu.',
	'Trigger has been created.' => 'Liipaisin on luotu.',
	'Alter trigger' => 'Muuta liipaisinta',
	'Create trigger' => 'Luo liipaisin',

	// Table check constraints
	'Checks' => 'Tarkistukset', // by Claude Fable 5
	'Create check' => 'Luo tarkistus', // by Claude Fable 5
	'Alter check' => 'Muuta tarkistusta', // by Claude Fable 5
	'Check has been created.' => 'Tarkistus on luotu.', // by Claude Fable 5
	'Check has been altered.' => 'Tarkistusta on muutettu.', // by Claude Fable 5
	'Check has been dropped.' => 'Tarkistus on poistettu.', // by Claude Fable 5

	// Selection
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

	// In-place editing in selection
	'Modify' => 'Muuta',
	'Ctrl+click on a value to modify it.' => 'Ctrl+napsauta arvoa muuttaaksesi.',
	'Use edit link to modify this value.' => 'Käytä muokkaa-linkkiä muuttaaksesi tätä arvoa.',

	// Editing
	'New item' => 'Uusi tietue',
	'Edit' => 'Muokkaa',
	'original' => 'alkuperäinen',
	'empty' => 'tyhjä', // label for value '' in enum data type
	'Insert' => 'Lisää',
	'Save' => 'Tallenna',
	'Save and continue edit' => 'Tallenna ja jatka muokkaamista',
	'Save and insert next' => 'Tallenna ja lisää seuraava',
	'Saving' => 'Tallennetaan',
	'Selected' => 'Valitut',
	'Clone' => 'Kloonaa',
	'Delete' => 'Poista',
	'Item%s has been inserted.' => 'Tietue%s lisättiin.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Tietue poistettiin.',
	'Item has been updated.' => 'Tietue päivitettiin.',
	'%d item(s) have been affected.' => 'Kohdistui %d tietueeseen.',
	'You have no privileges to update this table.' => 'Sinulla ei ole oikeutta päivittää tätä taulua.',

	// Data type descriptions
	'Numbers' => 'Numerot',
	'Date and time' => 'Päiväys ja aika',
	'Strings' => 'Merkkijonot',
	'Binary' => 'Binäärinen',
	'Lists' => 'Luettelot',
	'Network' => 'Verkko',
	'Geometry' => 'Geometria',
	'Relations' => 'Suhteet',

	// Editor - data values
	'now' => 'nyt',
	'yes' => 'kyllä',
	'no' => 'ei',

	// Settings
	'Settings' => 'Asetukset', // by Claude Opus 5
	'Default' => 'Oletus', // by Claude Opus 5
	'Color scheme' => 'Väriteema', // by Claude Opus 5
	'By system' => 'Järjestelmän mukaan', // by Claude Opus 5
	'Light' => 'Vaalea', // by Claude Opus 5
	'Dark' => 'Tumma', // by Claude Opus 5
	'Navigation mode' => 'Navigointitila', // by Claude Opus 5
	'Simple' => 'Yksinkertainen', // by Claude Opus 5
	'Dual' => 'Kaksiosainen', // by Claude Opus 5
	'Dual on hover' => 'Kaksiosainen osoitettaessa', // by Claude Opus 5
	'Reversed' => 'Käänteinen', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Päänavigoinnin asettelu taulujen linkkien kanssa.', // by Claude Opus 5
	'Table links' => 'Taulujen linkit', // by Claude Opus 5
	'Primary action for all table links.' => 'Ensisijainen toiminto kaikille taulujen linkeille.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Linkit tauluihin, jotka viittaavat nykyiseen riviin.', // by Claude Opus 5
	'Display' => 'Näytä', // by Claude Opus 5
	'Hide' => 'Piilota', // by Claude Opus 5
	'Records per page' => 'Tietueita sivulla', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Datataulussa näytettävien tietueiden oletusmäärä.', // by Claude Opus 5
	'Enum as select' => 'Enum valintalistana', // by Claude Opus 5
	'Never' => 'Ei koskaan', // by Claude Opus 5
	'Always' => 'Aina', // by Claude Opus 5
	'More values than %d' => 'Enemmän kuin %d arvoa', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Raja valintalistan näyttämiselle enum-kentissä.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Kertakäyttösalasana', // by Claude Opus 5
	'Enter OTP code.' => 'Syötä OTP-koodi.', // by Claude Opus 5
	'Invalid OTP code.' => 'Virheellinen OTP-koodi.', // by Claude Opus 5
	'Access denied.' => 'Pääsy estetty.', // by Claude Opus 5
	'JSON previews' => 'JSON-esikatselut', // by Claude Opus 5
	'Data table' => 'Datataulu', // by Claude Opus 5
	'Edit form' => 'Muokkauslomake', // by Claude Opus 5
	'Ask %s' => 'Kysy %s:ltä', // by Claude Opus 5
];
