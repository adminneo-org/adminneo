<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5.$3.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'ДД.ММ.ГГГГ', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'ЧЧ:ММ:СС', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s должен возвращать массив.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s и %s должны возвращать объект, созданный методом %s.', // by Claude Opus 5

	// Login
	'System' => 'Движок',
	'Server' => 'Сервер',
	'Username' => 'Имя пользователя',
	'Password' => 'Пароль',
	'Permanent login' => 'Оставаться в системе',
	'Login' => 'Войти',
	'Logout' => 'Выйти',
	'Logged as: %s' => 'Вы вошли как: %s',
	'Logout successful.' => 'Вы успешно покинули систему.',
	'hostname[:port] or :socket' => 'hostname[:port] или :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Неверный сервер или учётные данные.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Во введённом пароле есть пробел, это может быть причиной.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo не поддерживает доступ к базе данных без пароля, <a href="https://www.adminneo.org/password"%s>больше информации</a>.',
	'Database does not support password.' => 'База данных не поддерживает пароль.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Слишком много неудачных попыток входа. Попробуйте снова через %d минуту.',
		'Слишком много неудачных попыток входа. Попробуйте снова через %d минуты.',
		'Слишком много неудачных попыток входа. Попробуйте снова через %d минут.',
	],
	'Invalid permanent login, please login again.' => 'Недействительный постоянный вход, нужно снова войти в систему.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Недействительный CSRF-токен. Отправьте форму ещё раз.',
	'If you did not send this request from AdminNeo then close this page.' => 'Если вы не посылали этот запрос из AdminNeo, закройте эту страницу.',
	'The action will be performed after successful login with the same credentials.' => 'Действие будет выполнено после успешного входа в систему с теми же учетными данными.',

	// Connection
	'No driver' => 'Нет драйвера', // by Claude Opus 5
	'Database driver not found.' => 'Драйвер базы данных не найден.', // by Claude Opus 5
	'No extension' => 'Нет расширений',
	'None of the supported PHP extensions (%s) are available.' => 'Недоступно ни одного расширения из поддерживаемых (%s).', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Подключение к привилегированным портам не допускается.',
	'Session support must be enabled.' => 'Сессии должны быть включены.',
	'Session expired, please login again.' => 'Срок действия сессии истёк, нужно снова войти в систему.',
	'%s version: %s through PHP extension %s' => 'Версия %s: %s с PHP-расширением %s',

	// Settings
	'Language' => 'Язык',

	'Home' => 'Главная', // by Claude Opus 5
	'Refresh' => 'Обновить',
	'Info' => 'Сведения', // by Claude Opus 5
	'More information.' => 'Подробнее.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Полномочия',
	'Create user' => 'Создать пользователя',
	'User has been dropped.' => 'Пользователь был удалён.',
	'User has been altered.' => 'Пользователь был изменён.',
	'User has been created.' => 'Пользователь был создан.',
	'Hashed' => 'Хешировано',

	// Server
	'Process list' => 'Список процессов',
	'%d process(es) have been killed.' => [
		'Был завершён %d процесс.',
		'Было завершено %d процесса.',
		'Было завершено %d процессов.',
	],
	'Kill' => 'Завершить',
	'Variables' => 'Переменные',
	'Status' => 'Состояние',

	// Structure
	'Column' => 'поле',
	'Columns' => 'Поля', // by Claude Fable 5
	'Routine' => 'Процедура',
	'Grant' => 'Позволить',
	'Revoke' => 'Запретить',

	// Queries
	'SQL command' => 'SQL-запрос',
	'HTTP request' => 'HTTP-запрос', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d запрос выполнен успешно.',
		'%d запроса выполнено успешно.',
		'%d запросов выполнено успешно.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Запрос завершён, изменена %d запись.',
		'Запрос завершён, изменены %d записи.',
		'Запрос завершён, изменено %d записей.',
	],
	'No commands to execute.' => 'Нет команд для выполнения.',
	'Error in query' => 'Ошибка в запросе',
	'Unknown error.' => 'Неизвестная ошибка.',
	'Warnings' => 'Предупреждения',
	'%s queries are not supported.' => '%s-запросы не поддерживаются.',
	'Execute' => 'Выполнить',
	'Stop on error' => 'Остановить при ошибке',
	'Show only errors' => 'Только ошибки',
	'Time' => 'Время',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'История',
	'Clear' => 'Очистить',
	'Edit all' => 'Редактировать всё',

	// Import
	'Import' => 'Импорт',
	'File upload' => 'Загрузить файл на сервер',
	'From server' => 'С сервера',
	'Webserver file %s' => 'Файл %s на вебсервере',
	'Run file' => 'Запустить файл',
	'File does not exist.' => 'Такого файла не существует.',
	'File uploads are disabled.' => 'Загрузка файлов на сервер запрещена.',
	'Unable to upload a file.' => 'Не удалось загрузить файл на сервер.',
	'Maximum allowed file size is %sB.' => 'Максимальный разрешённый размер файла — %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Максимальное количество файлов — %d. Выберите меньше файлов или увеличьте параметр конфигурационной директивы %s.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Максимальный суммарный размер файлов — %s. Выберите файлы поменьше или увеличьте параметр конфигурационной директивы %s.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Слишком большой объем POST-данных. Пошлите меньший объём данных или увеличьте параметр конфигурационной директивы %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Вы можете закачать большой SQL-файл по FTP и затем импортировать его с сервера.',
	'File must be in UTF-8 encoding.' => 'Файл должен быть в кодировке UTF-8.',
	'You are offline.' => 'Вы не в сети.', // by Claude Fable 5
	'%d row(s) have been imported.' => [
		'Импортирована %d строка.',
		'Импортировано %d строки.',
		'Импортировано %d строк.',
	],

	// Export
	'Export' => 'Экспорт',
	'Output' => 'Выходные данные',
	'open' => 'открыть',
	'save' => 'сохранить',
	'Format' => 'Формат',
	'Data' => 'Данные',

	// Databases
	'Database' => 'База данных',
	'database' => 'база данных', // by Claude Opus 5
	'DB' => 'DB',
	'Use' => 'Выбрать',
	'Invalid database.' => 'Неверная база данных.',
	'Alter database' => 'Изменить базу данных',
	'Create database' => 'Создать базу данных',
	'Database schema' => 'Схема базы данных',
	'Permanent link' => 'Постоянная ссылка',
	'Database has been dropped.' => 'База данных была удалена.',
	'Databases have been dropped.' => 'Базы данных удалены.',
	'Database has been created.' => 'База данных была создана.',
	'Database has been renamed.' => 'База данных была переименована.',
	'Database has been altered.' => 'База данных была изменена.',

	// SQLite errors
	'File exists.' => 'Файл уже существует.',
	'Please use one of the extensions %s.' => 'Используйте одно из этих расширений %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Схема',
	'schema' => 'схема', // by Claude Opus 5
	'Schemas' => 'Схемы', // by Claude Opus 5
	'No schemas.' => 'Нет схем.', // by Claude Opus 5
	'Show schema' => 'Показать схему', // by Claude Opus 5
	'Alter schema' => 'Изменить схему',
	'Create schema' => 'Новая схема',
	'Schema has been dropped.' => 'Схема удалена.',
	'Schema has been created.' => 'Создана новая схема.',
	'Schema has been altered.' => 'Схема изменена.',
	'Invalid schema.' => 'Неправильная схема.',

	// Table list
	'Engine' => 'Тип таблиц',
	'engine' => 'Тип таблицы',
	'Collation' => 'Режим сопоставления',
	'collation' => 'режим сопоставления',
	'Data Length' => 'Объём данных',
	'Index Length' => 'Объём индексов',
	'Data Free' => 'Свободное место',
	'Rows' => 'Строк',
	'%d in total' => 'Всего %d',
	'Analyze' => 'Анализировать',
	'Optimize' => 'Оптимизировать',
	'Vacuum' => 'Вакуум',
	'Check' => 'Проверить',
	'Repair' => 'Исправить',
	'Truncate' => 'Очистить',
	'Tables have been truncated.' => 'Таблицы были очищены.',
	'Move to other database' => 'Переместить в другую базу данных',
	'Move' => 'Переместить',
	'Tables have been moved.' => 'Таблицы были перемещены.',
	'Copy' => 'Копировать',
	'Tables have been copied.' => 'Таблицы скопированы.',
	'overwrite' => 'перезаписать',

	// Tables
	'Tables' => 'Таблицы',
	'Tables and views' => 'Таблицы и представления',
	'Table' => 'Таблица',
	'No tables.' => 'В базе данных нет таблиц.',
	'Alter table' => 'Изменить таблицу',
	'Create table' => 'Создать таблицу',
	'Table has been dropped.' => 'Таблица была удалена.',
	'Tables have been dropped.' => 'Таблицы были удалены.',
	'Tables have been optimized.' => 'Таблицы оптимизированы.',
	'Table has been altered.' => 'Таблица была изменена.',
	'Table has been created.' => 'Таблица была создана.',
	'Table name' => 'Название таблицы',
	'Name' => 'Название',
	'Show structure' => 'Показать структуру',
	'Column name' => 'Название поля',
	'Type' => 'Тип',
	'Length' => 'Длина',
	'Auto Increment' => 'Автоматическое приращение',
	'Options' => 'Действие',
	'Comment' => 'Комментарий',
	'Default value' => 'Значение по умолчанию',
	'Drop' => 'Удалить',
	'Drop %s?' => 'Удалить %s?',
	'Are you sure?' => 'Вы уверены?',
	'Size' => 'Размер',
	'Compute' => 'Вычислить',
	'Move up' => 'Переместить вверх',
	'Move down' => 'Переместить вниз',
	'Remove' => 'Удалить',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Достигнуто максимальное значение количества доступных полей. Увеличьте %s.',

	// Views
	'View' => 'Представление',
	'Materialized view' => 'Материализованное представление',
	'View has been dropped.' => 'Представление было удалено.',
	'View has been altered.' => 'Представление было изменено.',
	'View has been created.' => 'Представление было создано.',
	'Alter view' => 'Изменить представление',
	'Create view' => 'Создать представление',

	// Partitions
	'Partition by' => 'Разделить по',
	'Partition' => 'Раздел', // by Claude Opus 5
	'Partitions' => 'Разделы',
	'Partition name' => 'Название раздела',
	'Values' => 'Параметры',
	'Inherited tables' => 'Унаследованные таблицы', // by Claude Opus 5
	'Inherited from' => 'Унаследована от', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Индексы',
	'Indexes have been altered.' => 'Индексы изменены.',
	'Alter indexes' => 'Изменить индексы',
	'Add next' => 'Добавить ещё',
	'Index Type' => 'Тип индекса',
	'length' => 'длина',
	'Algorithm' => 'Алгоритм', // by Claude Fable 5
	'Condition' => 'Условие', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Внешние ключи',
	'Foreign key' => 'Внешний ключ',
	'Foreign key has been dropped.' => 'Внешний ключ был удалён.',
	'Foreign key has been altered.' => 'Внешний ключ был изменён.',
	'Foreign key has been created.' => 'Внешний ключ был создан.',
	'Target table' => 'Результирующая таблица',
	'Change' => 'Изменить',
	'Source' => 'Источник',
	'Target' => 'Цель',
	'Add column' => 'Добавить поле',
	'Alter' => 'Изменить',
	'Add foreign key' => 'Добавить внешний ключ',
	'ON DELETE' => 'При стирании',
	'ON UPDATE' => 'При обновлении',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Поля должны иметь одинаковые типы данных, в результирующем поле должен быть индекс, данные для импорта должны существовать.',

	// Routines
	'Routines' => 'Хранимые процедуры и функции',
	'Routine has been called, %d row(s) affected.' => [
		'Была вызвана процедура, %d запись была изменена.',
		'Была вызвана процедура, %d записи было изменено.',
		'Была вызвана процедура, %d записей было изменено.',
	],
	'Call' => 'Вызвать',
	'Parameter name' => 'Название параметра',
	'Create procedure' => 'Создать процедуру',
	'Create function' => 'Создать функцию',
	'Routine has been dropped.' => 'Процедура была удалена.',
	'Routine has been altered.' => 'Процедура была изменена.',
	'Routine has been created.' => 'Процедура была создана.',
	'Alter function' => 'Изменить функцию',
	'Alter procedure' => 'Изменить процедуру',
	'Return type' => 'Возвращаемый тип',

	// Events
	'Events' => 'События',
	'Event' => 'Событие',
	'Event has been dropped.' => 'Событие было удалено.',
	'Event has been altered.' => 'Событие было изменено.',
	'Event has been created.' => 'Событие было создано.',
	'Alter event' => 'Изменить событие',
	'Create event' => 'Создать событие',
	'At given time' => 'В данное время',
	'Every' => 'Каждые',
	'Schedule' => 'Расписание',
	'Start' => 'Начало',
	'End' => 'Конец',
	'On completion preserve' => 'После завершения сохранить',

	// Sequences (PostgreSQL)
	'Sequences' => '«Последовательности»',
	'Create sequence' => 'Создать «последовательность»',
	'Sequence has been dropped.' => '«Последовательность» удалена.',
	'Sequence has been created.' => 'Создана новая «последовательность».',
	'Sequence has been altered.' => '«Последовательность» изменена.',
	'Alter sequence' => 'Изменить «последовательность»',

	// User-defined types (PostgreSQL)
	'User types' => 'Пользовательские типы', // by Claude Fable 5
	'Create type' => 'Создать тип',
	'Type has been dropped.' => 'Тип удален.',
	'Type has been created.' => 'Создан новый тип.',
	'Alter type' => 'Изменить тип',

	// Triggers
	'Triggers' => 'Триггеры',
	'Add trigger' => 'Добавить триггер',
	'Trigger has been dropped.' => 'Триггер был удалён.',
	'Trigger has been altered.' => 'Триггер был изменён.',
	'Trigger has been created.' => 'Триггер был создан.',
	'Alter trigger' => 'Изменить триггер',
	'Create trigger' => 'Создать триггер',

	// Table check constraints
	'Checks' => 'Проверки',
	'Create check' => 'Создать проверку',
	'Alter check' => 'Изменить проверку',
	'Check has been created.' => 'Проверка создана.',
	'Check has been altered.' => 'Проверка изменена.',
	'Check has been dropped.' => 'Проверка удалена.',

	// Selection
	'Select data' => 'Выбрать',
	'Select' => 'Выбрать',
	'Functions' => 'Функции',
	'Aggregation' => 'Агрегация',
	'Search' => 'Поиск',
	'anywhere' => 'в любом месте',
	'Sort' => 'Сортировать',
	'descending' => 'по убыванию',
	'Limit' => 'Лимит',
	'Limit rows' => 'Лимит строк',
	'Text length' => 'Длина текста',
	'Action' => 'Действие',
	'Full table scan' => 'Анализ полной таблицы',
	'Unable to select the table' => 'Не удалось получить данные из таблицы',
	'Search data in tables' => 'Поиск в таблицах',
	'No rows.' => 'Нет записей.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d строка',
		'%d строки',
		'%d строк',
	],
	'Page' => 'Страница',
	'last' => 'последняя',
	'Load more data' => 'Загрузить ещё данные',
	'Loading' => 'Загрузка',
	'Whole result' => 'Весь результат',
	'%d byte(s)' => [
		'%d байт',
		'%d байта',
		'%d байтов',
	],

	// In-place editing in selection
	'Modify' => 'Изменить',
	'Ctrl+click on a value to modify it.' => 'Выполните Ctrl+Щелчок мышью по значению, чтобы его изменить.',
	'Use edit link to modify this value.' => 'Изменить это значение можно с помощью ссылки «изменить».',

	// Editing
	'New item' => 'Новая запись',
	'Edit' => 'Редактировать',
	'original' => 'исходный',
	'empty' => 'пусто', // label for value '' in enum data type
	'Insert' => 'Вставить',
	'Save' => 'Сохранить',
	'Save and continue edit' => 'Сохранить и продолжить редактирование',
	'Save and insert next' => 'Сохранить и вставить ещё',
	'Saving' => 'Сохранение',
	'Selected' => 'Выбранные',
	'Clone' => 'Клонировать',
	'Delete' => 'Стереть',
	'Item%s has been inserted.' => 'Запись%s была вставлена.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Запись удалена.',
	'Item has been updated.' => 'Запись обновлена.',
	'%d item(s) have been affected.' => [
		'Была изменена %d запись.',
		'Были изменены %d записи.',
		'Было изменено %d записей.',
	],
	'You have no privileges to update this table.' => 'У вас нет прав на обновление этой таблицы.',

	// Data type descriptions
	'Numbers' => 'Числа',
	'Date and time' => 'Дата и время',
	'Strings' => 'Строки',
	'Binary' => 'Двоичный тип',
	'Lists' => 'Списки',
	'Network' => 'Сеть',
	'Geometry' => 'Геометрия',
	'Relations' => 'Отношения',

	// Editor - data values
	'now' => 'сейчас',
	'yes' => 'да',
	'no' => 'нет',

	// Settings
	'Settings' => 'Настройки', // by Claude Opus 5
	'Default' => 'По умолчанию', // by Claude Opus 5
	'Color scheme' => 'Цветовая схема', // by Claude Opus 5
	'By system' => 'Как в системе', // by Claude Opus 5
	'Light' => 'Светлая', // by Claude Opus 5
	'Dark' => 'Тёмная', // by Claude Opus 5
	'Navigation mode' => 'Режим навигации', // by Claude Opus 5
	'Simple' => 'Простой', // by Claude Opus 5
	'Dual' => 'Двойной', // by Claude Opus 5
	'Reversed' => 'Обратный', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Расположение главной навигации со ссылками таблиц.', // by Claude Opus 5
	'Table links' => 'Ссылки таблиц', // by Claude Opus 5
	'Primary action for all table links.' => 'Основное действие для всех ссылок таблиц.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Ссылки на таблицы, ссылающиеся на текущую запись.', // by Claude Opus 5
	'Display' => 'Показывать', // by Claude Opus 5
	'Hide' => 'Скрыть', // by Claude Opus 5
	'Records per page' => 'Записей на странице', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Количество записей, отображаемых в таблице данных по умолчанию.', // by Claude Opus 5
	'Enum as select' => 'Enum как список', // by Claude Opus 5
	'Never' => 'Никогда', // by Claude Opus 5
	'Always' => 'Всегда', // by Claude Opus 5
	'More values than %d' => 'Больше %d значений', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Порог отображения списка выбора для полей типа enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Одноразовый пароль', // by Claude Opus 5
	'Enter OTP code.' => 'Введите код OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'Неверный код OTP.', // by Claude Opus 5
	'Access denied.' => 'Доступ запрещён.', // by Claude Opus 5
	'JSON previews' => 'Предпросмотр JSON', // by Claude Opus 5
	'Data table' => 'Таблица данных', // by Claude Opus 5
	'Edit form' => 'Форма редактирования', // by Claude Opus 5
	'Ask %s' => 'Спросить %s', // by Claude Opus 5
];
