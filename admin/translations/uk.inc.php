<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ' ',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5.$3.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'ДД.ММ.РРРР',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'ГГ:ХХ:СС',

	// Bootstrap.

	// Login.
	'System' => 'Система Бази Даних',
	'Server' => 'Сервер',
	'Username' => 'Користувач',
	'Password' => 'Пароль',
	'Permanent login' => 'Пам\'ятати сесію',
	'Login' => 'Увійти',
	'Logout' => 'Вийти',
	'Logged as: %s' => 'Ви увійшли як: %s',
	'Logout successful.' => 'Ви вдало вийшли з системи.',
	'There is a space in the input password which might be the cause.' => 'У вхідному паролі є пробіл, який може бути причиною.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo не підтримує доступ до бази даних без пароля, <a href="https://www.adminneo.org/password"%s>більше інформації</a>.',
	'Database does not support password.' => 'База даних не підтримує пароль.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Занадто багато невдалих спроб входу. Спробуйте знову через %d хвилину.',
		'Занадто багато невдалих спроб входу. Спробуйте знову через %d хвилини.',
		'Занадто багато невдалих спроб входу. Спробуйте знову через %d хвилин.',
	],
	'Invalid CSRF token. Send the form again.' => 'Недійсний CSRF токен. Надішліть форму ще раз.',
	'If you did not send this request from AdminNeo then close this page.' => 'Якщо ви не посилали цей запит з AdminNeo, закрийте цю сторінку.',
	'The action will be performed after successful login with the same credentials.' => 'Дія буде виконуватися після успішного входу в систему з тими ж обліковими даними.',

	// Connection.
	'No extension' => 'Нема розширень',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Жодне з PHP-розширень (%s), що підтримуються, не доступне.',
	'Connecting to privileged ports is not allowed.' => 'Підключення до привілейованих портів заборонено.',
	'Session support must be enabled.' => 'Сесії повинні бути дозволені.',
	'Session expired, please login again.' => 'Сесія закінчилась, будь ласка, увійдіть в систему знову.',
	'%s version: %s through PHP extension %s' => 'Версія %s: %s з PHP-розширенням %s',

	// Settings.
	'Language' => 'Мова',

	'Refresh' => 'Оновити',

	// Privileges.
	'Privileges' => 'Привілеї',
	'Create user' => 'Створити користувача',
	'User has been dropped.' => 'Користувача було видалено.',
	'User has been altered.' => 'Користувача було змінено.',
	'User has been created.' => 'Користувача було створено.',
	'Hashed' => 'Хешовано',

	// Server.
	'Process list' => 'Перелік процесів',
	'%d process(es) have been killed.' => [
		'Було завершено %d процес.',
		'Було завершено %d процеси.',
		'Було завершёно %d процесів.',
	],
	'Kill' => 'Завершити процес',
	'Variables' => 'Змінні',
	'Status' => 'Статус',

	// Structure.
	'Column' => 'Колонка',
	'Routine' => 'Процедура',
	'Grant' => 'Дозволити',
	'Revoke' => 'Заборонити',

	// Queries.
	'SQL command' => 'SQL запит',
	'%d query(s) executed OK.' => [
		'%d запит виконано успішно.',
		'%d запити виконано успішно.',
		'%d запитів виконано успішно.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Запит виконано успішно, змінено %d рядок.',
		'Запит виконано успішно, змінено %d рядки.',
		'Запит виконано успішно, змінено %d рядків.',
	],
	'No commands to execute.' => 'Нема запитів до виконання.',
	'Error in query' => 'Помилка в запиті',
	'Unknown error.' => 'Невідома помилка.',
	'Warnings' => 'Попередження',
	'%s queries are not supported.' => '%s-запити не підтримуються.',
	'Execute' => 'Виконати',
	'Stop on error' => 'Зупинитись при помилці',
	'Show only errors' => 'Показувати тільки помилки',
	'Time' => 'Час',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Історія',
	'Clear' => 'Очистити',
	'Edit all' => 'Редагувати все',

	// Import.
	'Import' => 'Імпортувати',
	'File upload' => 'Завантажити файл',
	'From server' => 'З сервера',
	'Webserver file %s' => 'Файл %s на вебсервері',
	'Run file' => 'Запустити файл',
	'File does not exist.' => 'Файл не існує.',
	'File uploads are disabled.' => 'Завантаження файлів заборонене.',
	'Unable to upload a file.' => 'Неможливо завантажити файл.',
	'Maximum allowed file size is %sB.' => 'Максимально допустимий розмір файлу %sБ.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Занадто великий об\'єм POST-даних. Зменшіть об\'єм або збільшіть параметр директиви %s конфигурації.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Ви можете завантажити великий файл SQL через FTP та імпортувати його з сервера.',
	'File must be in UTF-8 encoding.' => 'Файл повинен бути в кодуванні UTF-8.',
	'You are offline.' => 'Ви офлайн.',
	'%d row(s) have been imported.' => [
		'%d рядок було імпортовано.',
		'%d рядки було імпортовано.',
		'%d рядків було імпортовано.',
	],

	// Export.
	'Export' => 'Експорт',
	'Output' => 'Вихідні дані',
	'open' => 'відкрити',
	'save' => 'зберегти',
	'Format' => 'Формат',
	'Data' => 'Дані',

	// Databases.
	'Database' => 'База даних',
	'DB' => 'DB',
	'Use' => 'Обрати',
	'Invalid database.' => 'Погана база даних.',
	'Alter database' => 'Змінити базу даних',
	'Create database' => 'Створити базу даних',
	'Database schema' => 'Схема бази даних',
	'Permanent link' => 'Постійне посилання',
	'Database has been dropped.' => 'Базу даних було видалено.',
	'Databases have been dropped.' => 'Бази даних були видалені.',
	'Database has been created.' => 'Базу даних було створено.',
	'Database has been renamed.' => 'Базу даних було переіменовано.',
	'Database has been altered.' => 'Базу даних було змінено.',
	// SQLite errors.
	'File exists.' => 'Файл існує.',
	'Please use one of the extensions %s.' => 'Будь ласка, використовуйте одне з розширень %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Схема',
	'Alter schema' => 'Змінити схему',
	'Create schema' => 'Створити схему',
	'Schema has been dropped.' => 'Схему було видалено.',
	'Schema has been created.' => 'Схему було створено.',
	'Schema has been altered.' => 'Схему було змінено.',
	'Invalid schema.' => 'Невірна схема.',

	// Table list.
	'Engine' => 'Рушій',
	'engine' => 'рушій',
	'Collation' => 'Співставлення',
	'collation' => 'співставлення',
	'Data Length' => 'Об\'єм даних',
	'Index Length' => 'Об\'єм індексів',
	'Data Free' => 'Вільне місце',
	'Rows' => 'Рядків',
	'%d in total' => '%d всього',
	'Analyze' => 'Аналізувати',
	'Optimize' => 'Оптимізувати',
	'Vacuum' => 'Вакуум',
	'Check' => 'Перевірити',
	'Repair' => 'Виправити',
	'Truncate' => 'Очистити',
	'Tables have been truncated.' => 'Таблиці було очищено.',
	'Move to other database' => 'Перенести до іншої бази даних',
	'Move' => 'Перенести',
	'Tables have been moved.' => 'Таблиці було перенесено.',
	'Copy' => 'копіювати',
	'Tables have been copied.' => 'Таблиці було зкопійовано.',
	'overwrite' => 'перезаписати',

	// Tables.
	'Tables' => 'Таблиці',
	'Tables and views' => 'Таблиці і вигляди',
	'Table' => 'Таблиця',
	'No tables.' => 'Нема таблиць.',
	'Alter table' => 'Змінити таблицю',
	'Create table' => 'Створити таблицю',
	'Table has been dropped.' => 'Таблицю було видалено.',
	'Tables have been dropped.' => 'Таблиці були видалені.',
	'Tables have been optimized.' => 'Таблиці були оптимізовані.',
	'Table has been altered.' => 'Таблица була змінена.',
	'Table has been created.' => 'Таблиця була створена.',
	'Table name' => 'Назва таблиці',
	'Name' => 'Назва',
	'Show structure' => 'Показати структуру',
	'Column name' => 'Назва стовпця',
	'Type' => 'Тип',
	'Length' => 'Довжина',
	'Auto Increment' => 'Автоматичне збільшення',
	'Options' => 'Опції',
	'Comment' => 'Коментарі',
	'Default value' => 'Значення за замовчуванням',
	'Drop' => 'Видалити',
	'Drop %s?' => 'Вилучити %s?',
	'Are you sure?' => 'Ви впевнені?',
	'Size' => 'Розмір',
	'Compute' => 'Обчислити',
	'Move up' => 'Пересунути вгору',
	'Move down' => 'Пересунути вниз',
	'Remove' => 'Видалити',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Досягнута максимальна кількість доступних полів. Будь ласка, збільшіть %s.',

	// Views.
	'View' => 'Вигляд',
	'Materialized view' => 'Матеріалізований вигляд',
	'View has been dropped.' => 'Вигляд було видалено.',
	'View has been altered.' => 'Вигляд було змінено.',
	'View has been created.' => 'Вигляд було створено.',
	'Alter view' => 'Змінити вигляд',
	'Create view' => 'Створити вигляд',

	// Partitions.
	'Partition by' => 'Розділити по',
	'Partitions' => 'Розділи',
	'Partition name' => 'Назва розділу',
	'Values' => 'Значення',

	// Indexes.
	'Indexes' => 'Індекси',
	'Indexes have been altered.' => 'Індексування було змінено.',
	'Alter indexes' => 'Змінити індексування',
	'Add next' => 'Додати ще',
	'Index Type' => 'Тип індексу',
	'length' => 'довжина',

	// Foreign keys.
	'Foreign keys' => 'Зовнішні ключі',
	'Foreign key' => 'Зовнішній ключ',
	'Foreign key has been dropped.' => 'Зовнішній ключ було видалено.',
	'Foreign key has been altered.' => 'Зовнішній ключ було змінено.',
	'Foreign key has been created.' => 'Зовнішній ключ було створено.',
	'Target table' => 'Цільова таблиця',
	'Change' => 'Змінити',
	'Source' => 'Джерело',
	'Target' => 'Ціль',
	'Add column' => 'Додати стовпець',
	'Alter' => 'Змінити',
	'Add foreign key' => 'Додати зовнішній ключ',
	'ON DELETE' => 'ПРИ ВИДАЛЕННІ',
	'ON UPDATE' => 'ПРИ ЗМІНІ',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Стовпці повинні мати той самий тип даних, цільові стовпці повинні бути проіндексовані і дані, на які посилаються повинні існувати.',

	// Routines.
	'Routines' => 'Збережені процедури',
	'Routine has been called, %d row(s) affected.' => [
		'Була викликана процедура, %d запис було змінено.',
		'Була викликана процедура, %d записи було змінено.',
		'Була викликана процедура, %d записів було змінено.',
	],
	'Call' => 'Викликати',
	'Parameter name' => 'Назва параметра',
	'Create procedure' => 'Створити процедуру',
	'Create function' => 'Створити функцію',
	'Routine has been dropped.' => 'Процедуру було видалено.',
	'Routine has been altered.' => 'Процедуру було змінено.',
	'Routine has been created.' => 'Процедуру було створено.',
	'Alter function' => 'Змінити функцію',
	'Alter procedure' => 'Змінити процедуру',
	'Return type' => 'Тип, що повернеться',

	// Events.
	'Events' => 'Події',
	'Event' => 'Подія',
	'Event has been dropped.' => 'Подію було видалено.',
	'Event has been altered.' => 'Подію було змінено.',
	'Event has been created.' => 'Подію було створено.',
	'Alter event' => 'Змінити подію',
	'Create event' => 'Створити подію',
	'At given time' => 'В даний час',
	'Every' => 'Кожного',
	'Schedule' => 'Розклад',
	'Start' => 'Початок',
	'End' => 'Кінець',
	'On completion preserve' => 'Після завершення зберегти',

	// Sequences (PostgreSQL).
	'Sequences' => 'Послідовності',
	'Create sequence' => 'Створити послідовність',
	'Sequence has been dropped.' => 'Послідовність було видалено.',
	'Sequence has been created.' => 'Послідовність було створено.',
	'Sequence has been altered.' => 'Послідовність було змінено.',
	'Alter sequence' => 'Змінити послідовність',

	// User types (PostgreSQL)
	'User types' => 'Типи користувачів',
	'Create type' => 'Створити тип',
	'Type has been dropped.' => 'Тип було видалено.',
	'Type has been created.' => 'Тип було створено.',
	'Alter type' => 'Змінити тип',

	// Triggers.
	'Triggers' => 'Тригери',
	'Add trigger' => 'Додати тригер',
	'Trigger has been dropped.' => 'Тригер було видалено.',
	'Trigger has been altered.' => 'Тригер було змінено.',
	'Trigger has been created.' => 'Тригер було створено.',
	'Alter trigger' => 'Змінити тригер',
	'Create trigger' => 'Створити тригер',

	// Table check constraints.
	'Checks' => 'Перевірки',
	'Create check' => 'Створити перевірку',
	'Alter check' => 'Змінити перевірку',
	'Check has been created.' => 'Перевірку створено.',
	'Check has been altered.' => 'Перевірка змінена.',
	'Check has been dropped.' => 'Перевірку видалено.',

	// Selection.
	'Select data' => 'Вибрати дані',
	'Select' => 'Вибрати',
	'Functions' => 'Функції',
	'Aggregation' => 'Агрегація',
	'Search' => 'Пошук',
	'anywhere' => 'будь-де',
	'Sort' => 'Сортувати',
	'descending' => 'по спаданню',
	'Limit' => 'Обмеження',
	'Limit rows' => 'Обмеження рядків',
	'Text length' => 'Довжина тексту',
	'Action' => 'Дія',
	'Full table scan' => 'Повне сканування таблиці',
	'Unable to select the table' => 'Неможливо вибрати таблицю',
	'Search data in tables' => 'Шукати дані в таблицях',
	'No rows.' => 'Нема рядків.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d рядок',
		'%d рядки',
		'%d рядків',
	],
	'Page' => 'Сторінка',
	'last' => 'остання',
	'Load more data' => 'Завантажити ще дані',
	'Loading' => 'Завантаження',
	'Whole result' => 'Весь результат',
	'%d byte(s)' => [
		'%d байт',
		'%d байта',
		'%d байтів',
	],

	// In-place editing in selection.
	'Modify' => 'Змінити',
	'Ctrl+click on a value to modify it.' => 'Ctrl+клікніть на значенні щоб змінити його.',
	'Use edit link to modify this value.' => 'Використовуйте посилання щоб змінити це значення.',

	// Editing.
	'New item' => 'Новий запис',
	'Edit' => 'Редагувати',
	'original' => 'початковий',
	// label for value '' in enum data type
	'empty' => 'порожньо',
	'Insert' => 'Вставити',
	'Save' => 'Зберегти',
	'Save and continue edit' => 'Зберегти і продовжити редагування',
	'Save and insert next' => 'Зберегти і вставити знову',
	'Saving' => 'Збереження',
	'Selected' => 'Вибрані',
	'Clone' => 'Клонувати',
	'Delete' => 'Видалити',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Запис%s було вставлено.',
	'Item has been deleted.' => 'Запис було видалено.',
	'Item has been updated.' => 'Запис було змінено.',
	'%d item(s) have been affected.' => [
		'Було змінено %d запис.',
		'Було змінено %d записи.',
		'Було змінено %d записів.',
	],
	'You have no privileges to update this table.' => 'Ви не маєте привілеїв для оновлення цієї таблиці.',

	// Data type descriptions.
	'Numbers' => 'Числа',
	'Date and time' => 'Дата і час',
	'Strings' => 'Рядки',
	'Binary' => 'Двійкові',
	'Lists' => 'Списки',
	'Network' => 'Мережа',
	'Geometry' => 'Геометрія',
	'Relations' => 'Зв\'язки',

	// Editor - data values.
	'now' => 'зараз',
	'yes' => 'так',
	'no' => 'ні',

	// Plugins.
];
