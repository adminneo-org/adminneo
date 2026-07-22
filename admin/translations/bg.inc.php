<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'ГГГГ-ММ-ДД', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'ЧЧ:ММ:СС', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s трябва да върне масив.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s и %s трябва да върнат обект, създаден чрез метода %s.', // by Claude Opus 5

	// Login
	'System' => 'Система',
	'Server' => 'Сървър',
	'Username' => 'Потребител',
	'Password' => 'Парола',
	'Permanent login' => 'Запаметяване',
	'Login' => 'Вход',
	'Logout' => 'Изход',
	'Logged as: %s' => 'Текущ потребител: %s',
	'Logout successful.' => 'Излизането е успешно.',
	'hostname[:port] or :socket' => 'hostname[:port] или :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Невалиден сървър или данни за вход.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Има интервал във въведената парола, което може да е причината.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo не поддържа достъп до база данни без парола, <a href="https://www.adminneo.org/password"%s>повече информация</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Базата данни не поддържа парола.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Прекалено много неуспешни опити за вход, опитайте пак след %d минута.',
		'Прекалено много неуспешни опити за вход, опитайте пак след %d минути.',
	],
	'Invalid permanent login, please login again.' => 'Невалидно запаметено влизане; моля, влезте отново.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Невалиден шифроващ ключ. Попълнете и изпратете формуляра отново.',
	'If you did not send this request from AdminNeo then close this page.' => 'Ако не сте изпратили тази заявка през AdminNeo, затворете тази страница.',
	'The action will be performed after successful login with the same credentials.' => 'Действието ще бъде извършено след успешно влизане със същите данни.', // by Claude Fable 5

	// Connection
	'No extension' => 'Няма разширение',
	'None of the supported PHP extensions (%s) are available.' => 'Никое от поддържаните PHP разширения (%s) не е налично.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Свързването към привилегировани портове не е разрешено.', // by Claude Fable 5
	'Session support must be enabled.' => 'Поддръжката на сесии трябва да е разрешена.',
	'Session expired, please login again.' => 'Сесията е изтекла; моля, влезте отново.',
	'%s version: %s through PHP extension %s' => '%s версия: %s през PHP разширение %s',

	// Settings
	'Language' => 'Език',

	'Home' => 'Начало', // by Claude Opus 5
	'Refresh' => 'Обновяване',
	'Info' => 'Информация', // by Claude Opus 5
	'More information.' => 'Повече информация.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Права',
	'Create user' => 'Създаване на потребител',
	'User has been dropped.' => 'Потребителя беше премахнат.',
	'User has been altered.' => 'Потребителя беше променен.',
	'User has been created.' => 'Потребителя беше създаден.',
	'Hashed' => 'Хеширан',

	// Server
	'Process list' => 'Списък с процеси',
	'%d process(es) have been killed.' => [
		'%d процес беше прекъснат.',
		'%d процеса бяха прекъснати.',
	],
	'Kill' => 'Прекъсване',
	'Variables' => 'Променливи',
	'Status' => 'Състояние',

	// Structure
	'Column' => 'Колона',
	'Columns' => 'Колони', // by Claude Fable 5
	'Routine' => 'Процедура',
	'Grant' => 'Осигуряване',
	'Revoke' => 'Отнемане',

	// Queries
	'SQL command' => 'SQL команда',
	'HTTP request' => 'HTTP заявка', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d заявка е изпълнена.',
		'%d заявки са изпълнени.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Заявката е изпълнена, %d ред е засегнат.',
		'Заявката е изпълнена, %d редове са засегнати.',
	],
	'No commands to execute.' => 'Няма команди за изпълнение.',
	'Error in query' => 'Грешка в заявката',
	'Unknown error.' => 'Неизвестна грешка.', // by Claude Fable 5
	'Warnings' => 'Предупреждения', // by Claude Fable 5
	'%s queries are not supported.' => 'Заявките %s не се поддържат.', // by Claude Fable 5
	'Execute' => 'Изпълнение',
	'Stop on error' => 'Спиране при грешка',
	'Show only errors' => 'Показване само на грешките',
	'Time' => 'Време',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Хронология',
	'Clear' => 'Изчистване',
	'Edit all' => 'Редактиране на всички',

	// Import
	'Import' => 'Импорт',
	'File upload' => 'Прикачване на файл',
	'From server' => 'От сървър',
	'Webserver file %s' => 'Сървърен файл %s',
	'Run file' => 'Изпълнение на файл',
	'File does not exist.' => 'Файлът не съществува.',
	'File uploads are disabled.' => 'Прикачването на файлове е забранено.',
	'Unable to upload a file.' => 'Неуспешно прикачване на файл.',
	'Maximum allowed file size is %sB.' => 'Максимално разрешената големина на файл е %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Максималният брой файлове е %d. Изберете по-малко файлове или увеличете %s управляващата директива.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Максималната обща големина на файловете е %s. Изберете по-малки файлове или увеличете %s управляващата директива.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Изпратени са прекалено много данни. Намалете обема на данните или увеличете %s управляващата директива.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Можете да прикачите голям SQL файл чрез FTP и да го импортирате от сървъра.',
	'File must be in UTF-8 encoding.' => 'Файла трябва да е с UTF-8 кодировка.',
	'You are offline.' => 'Вие сте офлайн.',
	'%d row(s) have been imported.' => [
		'%d ред беше импортиран.',
		'%d реда бяха импортирани.',
	],

	// Export
	'Export' => 'Експорт',
	'Output' => 'Резултат',
	'open' => 'показване',
	'save' => 'запис',
	'Format' => 'Формат',
	'Data' => 'Данни',

	// Databases
	'Database' => 'База данни',
	'database' => 'база данни', // by Claude Opus 5
	'DB' => 'БД', // by Claude Fable 5
	'Use' => 'Избор',
	'Invalid database.' => 'Невалидна база данни.',
	'Alter database' => 'Промяна на база данни',
	'Create database' => 'Създаване на база данни',
	'Database schema' => 'Схема на базата данни',
	'Permanent link' => 'Постоянна препратка',
	'Database has been dropped.' => 'Базата данни беше премахната.',
	'Databases have been dropped.' => 'Базите данни бяха премехнати.',
	'Database has been created.' => 'Базата данни беше създадена.',
	'Database has been renamed.' => 'Базата данни беше преименувана.',
	'Database has been altered.' => 'Базата данни беше променена.',

	// SQLite errors
	'File exists.' => 'Файла вече съществува.',
	'Please use one of the extensions %s.' => 'Моля, използвайте някое от разширенията %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Схема',
	'schema' => 'схема', // by Claude Opus 5
	'Schemas' => 'Схеми', // by Claude Opus 5
	'No schemas.' => 'Няма схеми.', // by Claude Opus 5
	'Show schema' => 'Схема', // by Claude Opus 5
	'Alter schema' => 'Промяна на схемата',
	'Create schema' => 'Създаване на схема',
	'Schema has been dropped.' => 'Схемата беше премахната.',
	'Schema has been created.' => 'Схемата беше създадена.',
	'Schema has been altered.' => 'Схемата беше променена.',
	'Invalid schema.' => 'Невалидна схема.',

	// Table list
	'Engine' => 'Система',
	'engine' => 'система',
	'Collation' => 'Кодировка',
	'collation' => 'кодировка',
	'Data Length' => 'Големина на данните',
	'Index Length' => 'Големина на индекса',
	'Data Free' => 'Свободно място',
	'Rows' => 'Редове',
	'%d in total' => '%d всичко',
	'Analyze' => 'Анализиране',
	'Optimize' => 'Оптимизиране',
	'Vacuum' => 'Консолидиране',
	'Check' => 'Проверка',
	'Repair' => 'Поправка',
	'Truncate' => 'Изрязване',
	'Tables have been truncated.' => 'Таблиците бяха изрязани.',
	'Move to other database' => 'Преместване в друга база данни',
	'Move' => 'Преместване',
	'Tables have been moved.' => 'Таблиците бяха преместени.',
	'Copy' => 'Копиране',
	'Tables have been copied.' => 'Таблиците бяха копирани.',
	'overwrite' => 'презаписване', // by Claude Fable 5

	// Tables
	'Tables' => 'Таблици',
	'Tables and views' => 'Таблици и изгледи',
	'Table' => 'Таблица',
	'No tables.' => 'Няма таблици.',
	'Alter table' => 'Промяна на таблица',
	'Create table' => 'Създаване на таблица',
	'Table has been dropped.' => 'Таблицата беше премахната.',
	'Tables have been dropped.' => 'Таблиците бяха премахнати.',
	'Tables have been optimized.' => 'Таблиците бяха оптимизирани.',
	'Table has been altered.' => 'Таблицата беше променена.',
	'Table has been created.' => 'Таблицата беше създадена.',
	'Table name' => 'Име на таблица',
	'Name' => 'Име',
	'Show structure' => 'Структура',
	'Column name' => 'Име на колоната',
	'Type' => 'Вид',
	'Length' => 'Големина',
	'Auto Increment' => 'Автоматично увеличаване',
	'Options' => 'Опции',
	'Comment' => 'Коментар',
	'Default value' => 'Стойност по подразбиране',
	'Drop' => 'Премахване',
	'Drop %s?' => 'Премахване на %s?', // by Claude Fable 5
	'Are you sure?' => 'Сигурни ли сте?',
	'Size' => 'Големина',
	'Compute' => 'Изчисляване',
	'Move up' => 'Преместване нагоре',
	'Move down' => 'Преместване надолу',
	'Remove' => 'Премахване',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Максималния брой полета е превишен. Моля, увеличете %s.',

	// Views
	'View' => 'Изглед',
	'Materialized view' => 'Запаметен изглед',
	'View has been dropped.' => 'Изгледа беше премахнат.',
	'View has been altered.' => 'Изгледа беше променен.',
	'View has been created.' => 'Изгледа беше създаден.',
	'Alter view' => 'Промяна на изглед',
	'Create view' => 'Създаване на изглед',

	// Partitions
	'Partition by' => 'Разделяне на',
	'Partition' => 'Раздел', // by Claude Opus 5
	'Partitions' => 'Раздели',
	'Partition name' => 'Име на раздела',
	'Values' => 'Стойности',
	'Inherited tables' => 'Наследени таблици', // by Claude Opus 5
	'Inherited from' => 'Наследена от', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Индекси',
	'Indexes have been altered.' => 'Индексите бяха променени.',
	'Alter indexes' => 'Промяна на индекси',
	'Add next' => 'Добавяне на следващ',
	'Index Type' => 'Вид на индекса',
	'length' => 'дължина',
	'operator class' => 'клас оператори', // by Claude Fable 5
	'Algorithm' => 'Алгоритъм', // by Claude Fable 5
	'Condition' => 'Условие', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Препратки',
	'Foreign key' => 'Препратка',
	'Foreign key has been dropped.' => 'Препратката беше премахната.',
	'Foreign key has been altered.' => 'Препратката беше променена.',
	'Foreign key has been created.' => 'Препратката беше създадена.',
	'Target table' => 'Таблица приемник',
	'Change' => 'Промяна',
	'Source' => 'Източник',
	'Target' => 'Цел',
	'Add column' => 'Добавяне на колона',
	'Alter' => 'Промяна',
	'Add foreign key' => 'Добавяне на препратка',
	'ON DELETE' => 'При изтриване',
	'ON UPDATE' => 'При промяна',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Колоните източник и цел трябва да са от еднакъв вид, трябва да има индекс на колоните приемник и да има въведени данни.',

	// Routines
	'Routines' => 'Процедури',
	'Routine has been called, %d row(s) affected.' => [
		'Беше приложена процедура, %d ред е засегнат.',
		'Беше приложена процедура, %d редове са засегнати.',
	],
	'Call' => 'Прилагане',
	'Parameter name' => 'Име на параметъра',
	'Create procedure' => 'Създаване на процедура',
	'Create function' => 'Създаване на функция',
	'Routine has been dropped.' => 'Процедурата беше премахната.',
	'Routine has been altered.' => 'Процедурата беше променена.',
	'Routine has been created.' => 'Процедурата беше създадена.',
	'Alter function' => 'Промяна на функция',
	'Alter procedure' => 'Промяна на процедура',
	'Return type' => 'Резултат',

	// Events
	'Events' => 'Събития',
	'Event' => 'Събитие',
	'Event has been dropped.' => 'Събитието беше премахнато.',
	'Event has been altered.' => 'Събитието беше променено.',
	'Event has been created.' => 'Събитието беше създадено.',
	'Alter event' => 'Промяна на събитие',
	'Create event' => 'Създаване на събитие',
	'At given time' => 'В зададено време',
	'Every' => 'Всеки',
	'Schedule' => 'Насрочване',
	'Start' => 'Начало',
	'End' => 'Край',
	'On completion preserve' => 'Запазване след завършване',

	// Sequences (PostgreSQL)
	'Sequences' => 'Последователности',
	'Create sequence' => 'Създаване на последователност',
	'Sequence has been dropped.' => 'Последователността беше премахната.',
	'Sequence has been created.' => 'Последователността беше създадена.',
	'Sequence has been altered.' => 'Последователността беше променена.',
	'Alter sequence' => 'Промяна на последователност',

	// User-defined types (PostgreSQL)
	'User types' => 'Потребителски типове', // by Claude Fable 5
	'Create type' => 'Създаване на вид',
	'Type has been dropped.' => 'Вида беше пермахнат.',
	'Type has been created.' => 'Вида беше създаден.',
	'Alter type' => 'Промяна на вид',

	// Triggers
	'Triggers' => 'Тригери',
	'Add trigger' => 'Добавяне на тригер',
	'Trigger has been dropped.' => 'Тригера беше премахнат.',
	'Trigger has been altered.' => 'Тригера беше променен.',
	'Trigger has been created.' => 'Тригера беше създаден.',
	'Alter trigger' => 'Промяна на тригер',
	'Create trigger' => 'Създаване на тригер',

	// Table check constraints
	'Checks' => 'Проверки', // by Claude Fable 5
	'Create check' => 'Създаване на проверка', // by Claude Fable 5
	'Alter check' => 'Промяна на проверка', // by Claude Fable 5
	'Check has been created.' => 'Проверката беше създадена.', // by Claude Fable 5
	'Check has been altered.' => 'Проверката беше променена.', // by Claude Fable 5
	'Check has been dropped.' => 'Проверката беше премахната.', // by Claude Fable 5

	// Selection
	'Select data' => 'Показване на данни',
	'Select' => 'Показване',
	'Functions' => 'Функции',
	'Aggregation' => 'Съвкупност',
	'Search' => 'Търсене',
	'anywhere' => 'навсякъде',
	'Sort' => 'Сортиране',
	'descending' => 'низходящо',
	'Limit' => 'Редове',
	'Limit rows' => 'Лимит на редовете',
	'Text length' => 'Текст',
	'Action' => 'Действие',
	'Full table scan' => 'Пълно сканиране на таблицата',
	'Unable to select the table' => 'Неуспешно показване на таблицата',
	'Search data in tables' => 'Търсене на данни в таблиците',
	'No rows.' => 'Няма редове.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d ред',
		'%d реда',
	],
	'Page' => 'Страница',
	'last' => 'последен',
	'Load more data' => 'Зареждане на повече данни',
	'Loading' => 'Зареждане',
	'Whole result' => 'Пълен резултат',
	'%d byte(s)' => [
		'%d байт',
		'%d байта',
	],

	// In-place editing in selection
	'Modify' => 'Промяна',
	'Ctrl+click on a value to modify it.' => 'Ctrl+щракване в стойността, за да я промените.',
	'Use edit link to modify this value.' => 'Използвайте \'редакция\' за промяна на данните.',

	// Editing
	'New item' => 'Нов елемент',
	'Edit' => 'Редактиране',
	'original' => 'оригинал',
	'empty' => 'празно', // label for value '' in enum data type
	'Insert' => 'Вмъкване',
	'Save' => 'Запис',
	'Save and continue edit' => 'Запис и редакция',
	'Save and insert next' => 'Запис и нов',
	'Saving' => 'Записване',
	'Selected' => 'Избран',
	'Clone' => 'Клониране',
	'Delete' => 'Изтриване',
	'Item%s has been inserted.' => 'Елементи%s бяха вмъкнати.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Елемента беше изтрит.',
	'Item has been updated.' => 'Елемента беше обновен.',
	'%d item(s) have been affected.' => [
		'%d елемент беше засегнат.',
		'%d елемента бяха засегнати.',
	],
	'You have no privileges to update this table.' => 'Нямате праве за обновяване на таблицата.',

	// Data type descriptions
	'Numbers' => 'Числа',
	'Date and time' => 'Дата и час',
	'Strings' => 'Низове',
	'Binary' => 'Двоични',
	'Lists' => 'Списъци',
	'Network' => 'Мрежа',
	'Geometry' => 'Геометрия',
	'Relations' => 'Зависимости',

	// Editor - data values
	'now' => 'сега',
	'yes' => 'да',
	'no' => 'не',

	// Settings
	'Settings' => 'Настройки', // by Claude Opus 5
	'Default' => 'По подразбиране', // by Claude Opus 5
	'Color scheme' => 'Цветова схема', // by Claude Opus 5
	'By system' => 'Според системата', // by Claude Opus 5
	'Light' => 'Светла', // by Claude Opus 5
	'Dark' => 'Тъмна', // by Claude Opus 5
	'Navigation mode' => 'Режим на навигация', // by Claude Opus 5
	'Simple' => 'Опростен', // by Claude Opus 5
	'Dual' => 'Двоен', // by Claude Opus 5
	'Reversed' => 'Обърнат', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Подредба на основната навигация с препратките към таблиците.', // by Claude Opus 5
	'Table links' => 'Препратки към таблиците', // by Claude Opus 5
	'Primary action for all table links.' => 'Основно действие за всички препратки към таблиците.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Препратки към таблиците, сочещи към текущия ред.', // by Claude Opus 5
	'Display' => 'Показване', // by Claude Opus 5
	'Hide' => 'Скриване', // by Claude Opus 5
	'Records per page' => 'Записи на страница', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Брой записи, показвани по подразбиране в таблицата с данни.', // by Claude Opus 5
	'Enum as select' => 'Enum като списък', // by Claude Opus 5
	'Never' => 'Никога', // by Claude Opus 5
	'Always' => 'Винаги', // by Claude Opus 5
	'More values than %d' => 'Повече от %d стойности', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Праг за показване на списък с избор при полета от вид enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Еднократна парола', // by Claude Opus 5
	'Enter OTP code.' => 'Въведете OTP кода.', // by Claude Opus 5
	'Invalid OTP code.' => 'Невалиден OTP код.', // by Claude Opus 5
	'Access denied.' => 'Достъпът е отказан.', // by Claude Opus 5
	'JSON previews' => 'Преглед на JSON', // by Claude Opus 5
	'Data table' => 'Таблица с данни', // by Claude Opus 5
	'Edit form' => 'Формуляр за редактиране', // by Claude Opus 5
	'Ask %s' => 'Попитай %s', // by Claude Opus 5
];
