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
	'YYYY-MM-DD' => 'ДД.ММ.ГГГГ',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'ЧЧ:ММ:СС',

	// Bootstrap.

	// Login.
	'System' => 'Движок',
	'Server' => 'Сервер',
	'Username' => 'Имя пользователя',
	'Password' => 'Пароль',
	'Permanent login' => 'Оставаться в системе',
	'Login' => 'Войти',
	'Logout' => 'Выйти',
	'Logged as: %s' => 'Вы вошли как: %s',
	'Logout successful.' => 'Вы успешно покинули систему.',
	'There is a space in the input password which might be the cause.' => 'В введеном пароле есть пробел, это может быть причиною.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo не поддерживает доступ к базе данных без пароля, <a href="https://www.adminneo.org/password"%s>больше информации</a>.',
	'Database does not support password.' => 'База данных не поддерживает пароль.',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Слишком много неудачных попыток входа. Попробуйте снова через %d минуту.',
		'Слишком много неудачных попыток входа. Попробуйте снова через %d минуты.',
		'Слишком много неудачных попыток входа. Попробуйте снова через %d минут.',
	],
	'Invalid CSRF token. Send the form again.' => 'Недействительный CSRF-токен. Отправите форму ещё раз.',
	'If you did not send this request from AdminNeo then close this page.' => 'Если вы не посылали этот запрос из AdminNeo, закройте эту страницу.',
	'The action will be performed after successful login with the same credentials.' => 'Действие будет выполнено после успешного входа в систему с теми же учетными данными.',

	// Connection.
	'No extension' => 'Нет расширений',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'Недоступно ни одного расширения из поддерживаемых (%s).',
	'Connecting to privileged ports is not allowed.' => 'Подключение к привилегированным портам не допускается.',
	'Session support must be enabled.' => 'Сессии должны быть включены.',
	'Session expired, please login again.' => 'Срок действия сессии истёк, нужно снова войти в систему.',
	'%s version: %s through PHP extension %s' => 'Версия %s: %s с PHP-расширением %s',

	// Settings.
	'Language' => 'Язык',

	'Refresh' => 'Обновить',

	// Privileges.
	'Privileges' => 'Полномочия',
	'Create user' => 'Создать пользователя',
	'User has been dropped.' => 'Пользователь был удалён.',
	'User has been altered.' => 'Пользователь был изменён.',
	'User has been created.' => 'Пользователь был создан.',
	'Hashed' => 'Хешировано',

	// Server.
	'Process list' => 'Список процессов',
	'%d process(es) have been killed.' => [
		'Был завершён %d процесс.',
		'Было завершено %d процесса.',
		'Было завершено %d процессов.',
	],
	'Kill' => 'Завершить',
	'Variables' => 'Переменные',
	'Status' => 'Состояние',

	// Structure.
	'Column' => 'поле',
	'Routine' => 'Процедура',
	'Grant' => 'Позволить',
	'Revoke' => 'Запретить',

	// Queries.
	'SQL command' => 'SQL-запрос',
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
	'Error in query' => 'Ошибка в запросe',
	'Unknown error.' => 'Неизвестная ошибка.',
	'Warnings' => 'Предупреждения',
	'%s queries are not supported.' => '%s-запросы не поддерживаются.',
	'Execute' => 'Выполнить',
	'Stop on error' => 'Остановить при ошибке',
	'Show only errors' => 'Только ошибки',
	'Time' => 'Время',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'История',
	'Clear' => 'Очистить',
	'Edit all' => 'Редактировать всё',

	// Import.
	'Import' => 'Импорт',
	'File upload' => 'Загрузить файл на сервер',
	'From server' => 'С сервера',
	'Webserver file %s' => 'Файл %s на вебсервере',
	'Run file' => 'Запустить файл',
	'File does not exist.' => 'Такого файла не существует.',
	'File uploads are disabled.' => 'Загрузка файлов на сервер запрещена.',
	'Unable to upload a file.' => 'Не удалось загрузить файл на сервер.',
	'Maximum allowed file size is %sB.' => 'Максимальный разрешённый размер файла — %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Слишком большой объем POST-данных. Пошлите меньший объём данных или увеличьте параметр конфигурационной директивы %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Вы можете закачать большой SQL-файл по FTP и затем импортировать его с сервера.',
	'File must be in UTF-8 encoding.' => 'Файл должен быть в кодировке UTF-8.',
	'You are offline.' => 'Вы не выполнили вход.',
	'%d row(s) have been imported.' => [
		'Импортирована %d строка.',
		'Импортировано %d строки.',
		'Импортировано %d строк.',
	],

	// Export.
	'Export' => 'Экспорт',
	'Output' => 'Выходные данные',
	'open' => 'открыть',
	'save' => 'сохранить',
	'Format' => 'Формат',
	'Data' => 'Данные',

	// Databases.
	'Database' => 'База данных',
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
	// SQLite errors.
	'File exists.' => 'Файл уже существует.',
	'Please use one of the extensions %s.' => 'Используйте одно из этих расширений %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'Схема',
	'Alter schema' => 'Изменить схему',
	'Create schema' => 'Новая схема',
	'Schema has been dropped.' => 'Схема удалена.',
	'Schema has been created.' => 'Создана новая схема.',
	'Schema has been altered.' => 'Схема изменена.',
	'Invalid schema.' => 'Неправильная схема.',

	// Table list.
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

	// Tables.
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

	// Views.
	'View' => 'Представление',
	'Materialized view' => 'Материализованное представление',
	'View has been dropped.' => 'Представление было удалено.',
	'View has been altered.' => 'Представление было изменено.',
	'View has been created.' => 'Представление было создано.',
	'Alter view' => 'Изменить представление',
	'Create view' => 'Создать представление',

	// Partitions.
	'Partition by' => 'Разделить по',
	'Partitions' => 'Разделы',
	'Partition name' => 'Название раздела',
	'Values' => 'Параметры',

	// Indexes.
	'Indexes' => 'Индексы',
	'Indexes have been altered.' => 'Индексы изменены.',
	'Alter indexes' => 'Изменить индексы',
	'Add next' => 'Добавить ещё',
	'Index Type' => 'Тип индекса',
	'length' => 'длина',

	// Foreign keys.
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

	// Routines.
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

	// Events.
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

	// Sequences (PostgreSQL).
	'Sequences' => '«Последовательности»',
	'Create sequence' => 'Создать «последовательность»',
	'Sequence has been dropped.' => '«Последовательность» удалена.',
	'Sequence has been created.' => 'Создана новая «последовательность».',
	'Sequence has been altered.' => '«Последовательность» изменена.',
	'Alter sequence' => 'Изменить «последовательность»',

	// User types (PostgreSQL)
	'User types' => 'Типы пользователей',
	'Create type' => 'Создать тип',
	'Type has been dropped.' => 'Тип удален.',
	'Type has been created.' => 'Создан новый тип.',
	'Alter type' => 'Изменить тип',

	// Triggers.
	'Triggers' => 'Триггеры',
	'Add trigger' => 'Добавить триггер',
	'Trigger has been dropped.' => 'Триггер был удалён.',
	'Trigger has been altered.' => 'Триггер был изменён.',
	'Trigger has been created.' => 'Триггер был создан.',
	'Alter trigger' => 'Изменить триггер',
	'Create trigger' => 'Создать триггер',

	// Table check constraints.
	'Checks' => 'Проверки',
	'Create check' => 'Создать проверку',
	'Alter check' => 'Изменить проверку',
	'Check has been created.' => 'Проверка создана.',
	'Check has been altered.' => 'Проверка изменена.',
	'Check has been dropped.' => 'Проверка удалена.',

	// Selection.
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

	// In-place editing in selection.
	'Modify' => 'Изменить',
	'Ctrl+click on a value to modify it.' => 'Выполните Ctrl+Щелчок мышью по значению, чтобы его изменить.',
	'Use edit link to modify this value.' => 'Изменить это значение можно с помощью ссылки «изменить».',

	// Editing.
	'New item' => 'Новая запись',
	'Edit' => 'Редактировать',
	'original' => 'исходный',
	// label for value '' in enum data type
	'empty' => 'пусто',
	'Insert' => 'Вставить',
	'Save' => 'Сохранить',
	'Save and continue edit' => 'Сохранить и продолжить редактирование',
	'Save and insert next' => 'Сохранить и вставить ещё',
	'Saving' => 'Сохранение',
	'Selected' => 'Выбранные',
	'Clone' => 'Клонировать',
	'Delete' => 'Стереть',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'Запись%s была вставлена.',
	'Item has been deleted.' => 'Запись удалена.',
	'Item has been updated.' => 'Запись обновлена.',
	'%d item(s) have been affected.' => [
		'Была изменена %d запись.',
		'Были изменены %d записи.',
		'Было изменено %d записей.',
	],
	'You have no privileges to update this table.' => 'У вас нет прав на обновление этой таблицы.',

	// Data type descriptions.
	'Numbers' => 'Числа',
	'Date and time' => 'Дата и время',
	'Strings' => 'Строки',
	'Binary' => 'Двоичный тип',
	'Lists' => 'Списки',
	'Network' => 'Сеть',
	'Geometry' => 'Геометрия',
	'Relations' => 'Отношения',

	// Editor - data values.
	'now' => 'сейчас',
	'yes' => 'да',
	'no' => 'нет',

	// Plugins.
];
