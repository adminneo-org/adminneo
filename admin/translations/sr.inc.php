<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5.$3.$1.', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD.MM.YYYY.', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap

	// Login
	'System' => 'Систем',
	'Server' => 'Сервер',
	'Username' => 'Корисничко име',
	'Password' => 'Лозинка',
	'Permanent login' => 'Трајна пријава',
	'Login' => 'Пријава',
	'Logout' => 'Одјава',
	'Logged as: %s' => 'Пријави се као: %s',
	'Logout successful.' => 'Успешна одјава.',
	'Invalid CSRF token. Send the form again.' => 'Неважећи CSRF код. Проследите поново форму.',

	// Connection
	'No extension' => 'Без додатака',
	'None of the supported PHP extensions (%s) are available.' => 'Ниједан од подржаних PHP додатака (%s) није доступан.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'Морате омогућити подршку за сесије.',
	'Session expired, please login again.' => 'Ваша сесија је истекла, пријавите се поново.',
	'%s version: %s through PHP extension %s' => '%s верзија: %s помоћу PHP додатка је %s',

	// Settings
	'Language' => 'Језик',

	'Refresh' => 'Освежи',

	// Privileges
	'Privileges' => 'Дозволе',
	'Create user' => 'Направи корисника',
	'User has been dropped.' => 'Корисник је избрисан.',
	'User has been altered.' => 'Корисник је измењен.',
	'User has been created.' => 'корисник је креиран.',
	'Hashed' => 'Хеширано',

	// Server
	'Process list' => 'Списак процеса',
	'%d process(es) have been killed.' => [
		'%d процес је убијен.',
		'%d процеса су убијена.',
		'%d процеса је убијено.',
	],
	'Kill' => 'Убиј',
	'Variables' => 'Променљиве',
	'Status' => 'Статус',

	// Structure
	'Column' => 'Колона',
	'Routine' => 'Рутина',
	'Grant' => 'Дозволи',
	'Revoke' => 'Опозови',

	// Queries
	'SQL command' => 'SQL команда',
	'%d query(s) executed OK.' => [
		'%d упит је успешно извршен.',
		'%d упита су успешно извршена.',
		'%d упита је успешно извршено.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Упит је успешно извршен, %d ред је погођен.',
		'Упит је успешно извршен, %d реда су погођена.',
		'Упит је успешно извршен, %d редова је погођено.',
	],
	'No commands to execute.' => 'Без команди за извршавање.',
	'Error in query' => 'Грешка у упиту',
	'Execute' => 'Изврши',
	'Stop on error' => 'Заустави приликом грешке',
	'Show only errors' => 'Приказуј само грешке',
	'Time' => 'Време',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Историјат',
	'Clear' => 'Очисти',
	'Edit all' => 'Измени све',

	// Import
	'Import' => 'Увоз',
	'File upload' => 'Слање датотека',
	'From server' => 'Са сервера',
	'Webserver file %s' => 'Датотека %s са веб сервера',
	'Run file' => 'Покрени датотеку',
	'File does not exist.' => 'Датотека не постоји.',
	'File uploads are disabled.' => 'Онемогућено је слање датотека.',
	'Unable to upload a file.' => 'Слање датотеке није успело.',
	'Maximum allowed file size is %sB.' => 'Највећа дозвољена величина датотеке је %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Превелики POST податак. Морате да смањите податак или повећајте вредност конфигурационе директиве %s.',
	'%d row(s) have been imported.' => [
		'%d ред је увежен.',
		'%d реда су увежена.',
		'%d редова је увежено.',
	],

	// Export
	'Export' => 'Извоз',
	'Output' => 'Испис',
	'open' => 'отвори',
	'save' => 'сачувај',
	'Format' => 'Формат',
	'Data' => 'Податци',

	// Databases
	'Database' => 'База података',
	'Use' => 'Користи',
	'Invalid database.' => 'Неисправна база података.',
	'Alter database' => 'Уреди базу података',
	'Create database' => 'Формирај базу података',
	'Database schema' => 'Шема базе података',
	'Permanent link' => 'Трајна веза',
	'Database has been dropped.' => 'База података је избрисана.',
	'Databases have been dropped.' => 'Базњ података су избрисане.',
	'Database has been created.' => 'База података је креирана.',
	'Database has been renamed.' => 'База података је преименована.',
	'Database has been altered.' => 'База података је измењена.',

	// SQLite errors
	'File exists.' => 'Датотека већ постоји.',
	'Please use one of the extensions %s.' => 'Молим користите један од наставака %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Шема',
	'Alter schema' => 'Уреди шему',
	'Create schema' => 'Формирај шему',
	'Schema has been dropped.' => 'Шема је избрисана.',
	'Schema has been created.' => 'Шема је креирана.',
	'Schema has been altered.' => 'Шема је измењена.',
	'Invalid schema.' => 'Шема није исправна.',

	// Table list
	'Engine' => 'Механизам',
	'engine' => 'механизам',
	'Collation' => 'Сравњивање',
	'collation' => 'Сравњивање',
	'Data Length' => 'Дужина података',
	'Index Length' => 'Дужина индекса',
	'Data Free' => 'Слободно података',
	'Rows' => 'Редова',
	'%d in total' => 'укупно %d',
	'Analyze' => 'Анализирај',
	'Optimize' => 'Оптимизуј',
	'Check' => 'Провери',
	'Repair' => 'Поправи',
	'Truncate' => 'Испразни',
	'Tables have been truncated.' => 'Табеле су испражњене.',
	'Move to other database' => 'Премести у другу базу података',
	'Move' => 'Премести',
	'Tables have been moved.' => 'Табеле су премешћене.',
	'Copy' => 'Умножи',
	'Tables have been copied.' => 'Табеле су умножене.',

	// Tables
	'Tables' => 'Табеле',
	'Tables and views' => 'Табеле и погледи',
	'Table' => 'Табела',
	'No tables.' => 'Без табела.',
	'Alter table' => 'Уреди табелу',
	'Create table' => 'Направи табелу',
	'Table has been dropped.' => 'Табела је избрисана.',
	'Tables have been dropped.' => 'Табеле су избрисане.',
	'Tables have been optimized.' => 'Табеле су оптимизоване.',
	'Table has been altered.' => 'Табела је измењена.',
	'Table has been created.' => 'Табела је креирана.',
	'Table name' => 'Назив табеле',
	'Name' => 'Име',
	'Show structure' => 'Прикажи структуру',
	'Column name' => 'Назив колоне',
	'Type' => 'Тип',
	'Length' => 'Дужина',
	'Auto Increment' => 'Ауто-прираштај',
	'Options' => 'Опције',
	'Comment' => 'Коментар',
	'Drop' => 'Избриши',
	'Are you sure?' => 'Да ли сте сигурни?',
	'Move up' => 'Помери на горе',
	'Move down' => 'Помери на доле',
	'Remove' => 'Уклони',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Премашен је максимални број дозвољених поља. Молим увећајте %s.',

	// Views
	'View' => 'Поглед',
	'View has been dropped.' => 'Поглед је избрисан.',
	'View has been altered.' => 'Поглед је измењен.',
	'View has been created.' => 'Поглед је креиран.',
	'Alter view' => 'Уреди поглед',
	'Create view' => 'Направи поглед',

	// Partitions
	'Partition by' => 'Подели по',
	'Partitions' => 'Поделе',
	'Partition name' => 'Име поделе',
	'Values' => 'Вредности',

	// Indexes
	'Indexes' => 'Индекси',
	'Indexes have been altered.' => 'Индекси су измењени.',
	'Alter indexes' => 'Уреди индексе',
	'Add next' => 'Додај следећи',
	'Index Type' => 'Тип индекса',
	'length' => 'дужина',

	// Foreign keys
	'Foreign keys' => 'Страни кључеви',
	'Foreign key' => 'Страни кључ',
	'Foreign key has been dropped.' => 'Страни кључ је избрисан.',
	'Foreign key has been altered.' => 'Страни кључ је измењен.',
	'Foreign key has been created.' => 'Страни кључ је креиран.',
	'Target table' => 'Циљна табела',
	'Change' => 'Измени',
	'Source' => 'Извор',
	'Target' => 'Циљ',
	'Add column' => 'Додај колону',
	'Alter' => 'Уреди',
	'Add foreign key' => 'Додај страни кључ',
	'ON DELETE' => 'ON DELETE (приликом брисања)',
	'ON UPDATE' => 'ON UPDATE (приликом освежавања)',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Изворне и циљне колоне морају бити истог типа, циљна колона мора бити индексирана и изворна табела мора садржати податке из циљне.',

	// Routines
	'Routines' => 'Рутине',
	'Routine has been called, %d row(s) affected.' => [
		'Позвана је рутина, %d ред је погођен.',
		'Позвана је рутина, %d реда су погођена.',
		'Позвана је рутина, %d редова је погођено.',
	],
	'Call' => 'Позови',
	'Parameter name' => 'Назив параметра',
	'Create procedure' => 'Формирај процедуру',
	'Create function' => 'Формирај функцију',
	'Routine has been dropped.' => 'Рутина је избрисана.',
	'Routine has been altered.' => 'Рутина је измењена.',
	'Routine has been created.' => 'Рутина је креирана.',
	'Alter function' => 'Уреди функцију',
	'Alter procedure' => 'Уреди процедуру',
	'Return type' => 'Повратни тип',

	// Events
	'Events' => 'Догађаји',
	'Event' => 'Догађај',
	'Event has been dropped.' => 'Догађај је избрисан.',
	'Event has been altered.' => 'Догађај је измењен.',
	'Event has been created.' => 'Догађај је креиран.',
	'Alter event' => 'Уреди догађај',
	'Create event' => 'Направи догађај',
	'At given time' => 'У задато време',
	'Every' => 'Сваки',
	'Schedule' => 'Распоред',
	'Start' => 'Почетак',
	'End' => 'Крај',
	'On completion preserve' => 'Задржи по завршетку',

	// Sequences (PostgreSQL)
	'Sequences' => 'Низови',
	'Create sequence' => 'Направи низ',
	'Sequence has been dropped.' => 'Низ је избрисан.',
	'Sequence has been created.' => 'Низ је формиран.',
	'Sequence has been altered.' => 'Низ је измењен.',
	'Alter sequence' => 'Уреди низ',

	// User types (PostgreSQL)
	'User types' => 'Кориснички типови',
	'Create type' => 'Дефиниши тип',
	'Type has been dropped.' => 'Тип је избрисан.',
	'Type has been created.' => 'тип је креиран.',
	'Alter type' => 'Уреди тип',

	// Triggers
	'Triggers' => 'Окидачи',
	'Add trigger' => 'Додај окидач',
	'Trigger has been dropped.' => 'Окидач је избрисан.',
	'Trigger has been altered.' => 'Окидач је измењен.',
	'Trigger has been created.' => 'Окидач је креиран.',
	'Alter trigger' => 'Уреди окидач',
	'Create trigger' => 'Формирај окидач',

	// Table check constraints

	// Selection
	'Select data' => 'Изабери податке',
	'Select' => 'Изабери',
	'Functions' => 'Функције',
	'Aggregation' => 'Сакупљање',
	'Search' => 'Претрага',
	'anywhere' => 'било где',
	'Sort' => 'Поређај',
	'descending' => 'опадајуће',
	'Limit' => 'Граница',
	'Text length' => 'Дужина текста',
	'Action' => 'Акција',
	'Full table scan' => 'Скренирање комплетне табеле',
	'Unable to select the table' => 'Не могу да изаберем табелу',
	'Search data in tables' => 'Претражи податке у табелама',
	'No rows.' => 'Без редова.',
	'%d row(s)' => [
		'%d ред',
		'%d реда',
		'%d редова',
	],
	'Page' => 'Страна',
	'last' => 'последња',
	'Load more data' => 'Учитавам још података',
	'Loading' => 'Учитавам',
	'Whole result' => 'Цео резултат',
	'%d byte(s)' => [
		'%d бајт',
		'%d бајта',
		'%d бајтова',
	],

	// In-place editing in selection
	'Ctrl+click on a value to modify it.' => 'Ctrl+клик на вредност за измену.',
	'Use edit link to modify this value.' => 'Користи везу за измену ове вредности.',

	// Editing
	'New item' => 'Нова ставка',
	'Edit' => 'Измени',
	'original' => 'оригинал',
	'empty' => 'празно', // label for value '' in enum data type
	'Insert' => 'Уметни',
	'Save' => 'Сачувај',
	'Save and continue edit' => 'Сачувај и настави уређење',
	'Save and insert next' => 'Сачувај и уметни следеће',
	'Clone' => 'Дуплирај',
	'Delete' => 'Избриши',
	'Item%s has been inserted.' => 'Ставка%s је додата.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Ставка је избрисана.',
	'Item has been updated.' => 'Ставка је измењена.',
	'%d item(s) have been affected.' => [
		'%d ставка је погођена.',
		'%d ставке су погођене.',
		'%d ставки је погођено.',
	],

	// Data type descriptions
	'Numbers' => 'Број',
	'Date and time' => 'Датум и време',
	'Strings' => 'Текст',
	'Binary' => 'Бинарно',
	'Lists' => 'Листе',
	'Network' => 'Мрежа',
	'Geometry' => 'Геометрија',
	'Relations' => 'Односи',

	// Editor - data values
	'now' => 'сад',
	'yes' => 'да',
	'no' => 'не',

	// Settings

	// Plugins
];
