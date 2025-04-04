<?php

namespace AdminNeo;

$translations = [
	// label for database system selection (MySQL, SQLite, ...)
	'Home' => null,
	'System' => 'Систем',
	'Server' => 'Сервер',
	'Username' => 'Корисничко име',
	'Password' => 'Лозинка',
	'Permanent login' => 'Трајна пријава',
	'Login' => 'Пријава',
	'Logout' => 'Одјава',
	'Logged as: %s' => 'Пријави се као: %s',
	'Logout successful.' => 'Успешна одјава.',
	'Invalid server or credentials.' => null,
	'Language' => 'Језик',
	'Invalid CSRF token. Send the form again.' => 'Неважећи CSRF код. Проследите поново форму.',
	'No extension' => 'Без додатака',
	'None of the supported PHP extensions (%s) are available.' => 'Ниједан од подржаних PHP додатака није доступан.',
	'Session support must be enabled.' => 'Морате омогућити подршку за сесије.',
	'Session expired, please login again.' => 'Ваша сесија је истекла, пријавите се поново.',
	'%s version: %s through PHP extension %s' => '%s верзија: %s помоћу PHP додатка је %s',
	'Refresh' => 'Освежи',

	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',

	'Privileges' => 'Дозволе',
	'Create user' => 'Направи корисника',
	'User has been dropped.' => 'Корисник је избрисан.',
	'User has been altered.' => 'Корисник је измењен.',
	'User has been created.' => 'корисник је креиран.',
	'Hashed' => 'Хеширано',
	'Column' => 'Колона',
	'Routine' => 'Рутина',
	'Grant' => 'Дозволи',
	'Revoke' => 'Опозови',

	'Process list' => 'Списак процеса',
	'%d process(es) have been killed.' => ['%d процес је убијен.', '%d процеса су убијена.', '%d процеса је убијено.'],
	'Kill' => 'Убиј',

	'Variables' => 'Променљиве',
	'Status' => 'Статус',

	'SQL command' => 'SQL команда',
	'%d query(s) executed OK.' => ['%d упит је успешно извршен.', '%d упита су успешно извршена.', '%d упита је успешно извршено.'],
	'Query executed OK, %d row(s) affected.' => ['Упит је успешно извршен, %d ред је погођен.', 'Упит је успешно извршен, %d реда су погођена.', 'Упит је успешно извршен, %d редова је погођено.'],
	'No commands to execute.' => 'Без команди за извршавање.',
	'Error in query' => 'Грешка у упиту',
	'Execute' => 'Изврши',
	'Stop on error' => 'Заустави приликом грешке',
	'Show only errors' => 'Приказуј само грешке',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'Историјат',
	'Clear' => 'Очисти',
	'Edit all' => 'Измени све',

	'File upload' => 'Слање датотека',
	'From server' => 'Са сервера',
	'Webserver file %s' => 'Датотека %s са веб сервера',
	'Run file' => 'Покрени датотеку',
	'File does not exist.' => 'Датотека не постоји.',
	'File uploads are disabled.' => 'Онемогућено је слање датотека.',
	'Unable to upload a file.' => 'Слање датотеке није успело.',
	'Maximum allowed file size is %sB.' => 'Највећа дозвољена величина датотеке је %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Превелики POST податак. Морате да смањите податак или повећајте вредност конфигурационе директиве %s.',

	'Export' => 'Извоз',
	'Output' => 'Испис',
	'open' => 'отвори',
	'save' => 'сачувај',
	'Format' => 'Формат',
	'Data' => 'Податци',

	'Database' => 'База података',
	'Use' => 'Користи',
	'Invalid database.' => 'Неисправна база података.',
	'Database has been dropped.' => 'База података је избрисана.',
	'Databases have been dropped.' => 'Базњ података су избрисане.',
	'Database has been created.' => 'База података је креирана.',
	'Database has been renamed.' => 'База података је преименована.',
	'Database has been altered.' => 'База података је измењена.',
	'Alter database' => 'Уреди базу података',
	'Create database' => 'Формирај базу података',
	'Database schema' => 'Шема базе података',

	// link to current database schema layout
	'Permanent link' => 'Трајна веза',

	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	'Engine' => 'Механизам',
	'Collation' => 'Сравњивање',
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

	'Routines' => 'Рутине',
	'Routine has been called, %d row(s) affected.' => ['Позвана је рутина, %d ред је погођен.', 'Позвана је рутина, %d реда су погођена.', 'Позвана је рутина, %d редова је погођено.'],
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

	'Events' => 'Догађаји',
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
	'Show structure' => 'Прикажи структуру',
	'engine' => 'механизам',
	'collation' => 'Сравњивање',
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

	'Partition by' => 'Подели по',
	'Partition' => null,
	'Partitions' => 'Поделе',
	'Partition name' => 'Име поделе',
	'Values' => 'Вредности',

	'View' => 'Поглед',
	'View has been dropped.' => 'Поглед је избрисан.',
	'View has been altered.' => 'Поглед је измењен.',
	'View has been created.' => 'Поглед је креиран.',
	'Alter view' => 'Уреди поглед',
	'Create view' => 'Направи поглед',

	'Indexes' => 'Индекси',
	'Indexes have been altered.' => 'Индекси су измењени.',
	'Alter indexes' => 'Уреди индексе',
	'Add next' => 'Додај следећи',
	'Index Type' => 'Тип индекса',
	'length' => 'дужина',

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

	'Triggers' => 'Окидачи',
	'Add trigger' => 'Додај окидач',
	'Trigger has been dropped.' => 'Окидач је избрисан.',
	'Trigger has been altered.' => 'Окидач је измењен.',
	'Trigger has been created.' => 'Окидач је креиран.',
	'Alter trigger' => 'Уреди окидач',
	'Create trigger' => 'Формирај окидач',
	'Time' => 'Време',
	'Event' => 'Догађај',
	'Name' => 'Име',
	'Select' => 'Изабери',
	'Select data' => 'Изабери податке',
	'Functions' => 'Функције',
	'Aggregation' => 'Сакупљање',
	'Search' => 'Претрага',
	'anywhere' => 'било где',
	'Search data in tables' => 'Претражи податке у табелама',
	'as a regular expression' => null,
	'Sort' => 'Поређај',
	'descending' => 'опадајуће',
	'Limit' => 'Граница',
	'Text length' => 'Дужина текста',
	'Action' => 'Акција',
	'Full table scan' => 'Скренирање комплетне табеле',
	'Unable to select the table' => 'Не могу да изаберем табелу',
	'No rows.' => 'Без редова.',
	'%d row(s)' => ['%d ред', '%d реда', '%d редова'],
	'Page' => 'Страна',
	'last' => 'последња',
	'Loading' => 'Учитавам',
	'Load more data' => 'Учитавам још података',
	'Whole result' => 'Цео резултат',
	'%d byte(s)' => ['%d бајт', '%d бајта', '%d бајтова'],

	'Import' => 'Увоз',
	'%d row(s) have been imported.' => ['%d ред је увежен.', '%d реда су увежена.', '%d редова је увежено.'],

	// in-place editing in select
	'Ctrl+click on a value to modify it.' => 'Ctrl+клик на вредност за измену.',
	'Use edit link to modify this value.' => 'Користи везу за измену ове вредности.',

	// %s can contain auto-increment value
	'Item%s has been inserted.' => 'Ставка%s је додата.',
	'Item has been deleted.' => 'Ставка је избрисана.',
	'Item has been updated.' => 'Ставка је измењена.',
	'%d item(s) have been affected.' => ['%d ставка је погођена.', '%d ставке су погођене.', '%d ставки је погођено.'],
	'New item' => 'Нова ставка',
	'original' => 'оригинал',
	// label for value '' in enum data type
	'empty' => 'празно',
	'Edit' => 'Измени',
	'Insert' => 'Уметни',
	'Save' => 'Сачувај',
	'Save and continue edit' => 'Сачувај и настави уређење',
	'Save and insert next' => 'Сачувај и уметни следеће',
	'Clone' => 'Дуплирај',
	'Delete' => 'Избриши',

	// data type descriptions
	'Numbers' => 'Број',
	'Date and time' => 'Датум и време',
	'Strings' => 'Текст',
	'Binary' => 'Бинарно',
	'Lists' => 'Листе',
	'Network' => 'Мрежа',
	'Geometry' => 'Геометрија',
	'Relations' => 'Односи',
	// date format in Editor: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$5.$3.$1.',
	// hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'DD.MM.YYYY.',
	// hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',
	'now' => 'сад',
	'yes' => 'да',
	'no' => 'не',

	// general SQLite error in create, drop or rename database
	'File exists.' => 'Датотека већ постоји.',
	'Please use one of the extensions %s.' => 'Молим користите један од наставака %s.',

	// PostgreSQL and MS SQL schema support
	'Alter schema' => 'Уреди шему',
	'Create schema' => 'Формирај шему',
	'Schema has been dropped.' => 'Шема је избрисана.',
	'Schema has been created.' => 'Шема је креирана.',
	'Schema has been altered.' => 'Шема је измењена.',
	'Schema' => 'Шема',
	'Invalid schema.' => 'Шема није исправна.',

	// PostgreSQL sequences support
	'Sequences' => 'Низови',
	'Create sequence' => 'Направи низ',
	'Sequence has been dropped.' => 'Низ је избрисан.',
	'Sequence has been created.' => 'Низ је формиран.',
	'Sequence has been altered.' => 'Низ је измењен.',
	'Alter sequence' => 'Уреди низ',

	// PostgreSQL user types support
	'User types' => 'Кориснички типови',
	'Create type' => 'Дефиниши тип',
	'Type has been dropped.' => 'Тип је избрисан.',
	'Type has been created.' => 'тип је креиран.',
	'Alter type' => 'Уреди тип',

	'Drop %s?' => null,
	'Materialized view' => null,
	'Vacuum' => null,
	'Selected' => null,
	'overwrite' => null,
	'DB' => null,
	'File must be in UTF-8 encoding.' => null,
	'Modify' => null,
	'ATTACH queries are not supported.' => null,
	'Warnings' => null,
	'%d / ' => [],
	'Limit rows' => null,
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminer.org/en/password/"%s>more information</a>.' => null,
	'Default value' => null,
	'Too many unsuccessful logins, try again in %d minute(s).' => [],
	'The action will be performed after successful login with the same credentials.' => null,
	'Connecting to privileged ports is not allowed.' => null,
	'There is a space in the input password which might be the cause.' => null,
	'If you did not send this request from AdminNeo then close this page.' => null,
	'You can upload a big SQL file via FTP and import it from server.' => null,
	'Size' => null,
	'Compute' => null,
	'You are offline.' => null,
	'You have no privileges to update this table.' => null,
	'Saving' => null,
	'Unknown error.' => null,
	'Database does not support password.' => null,
	'One Time Password' => null,
	'Invalid OTP code.' => null,

	'Schemas' => null,
	'No schemas.' => null,
	'Show schema' => null,
	'No driver' => null,
	'Database driver not found.' => null,

	'Check has been dropped.' => null,
	'Check has been altered.' => null,
	'Check has been created.' => null,
	'Alter check' => null,
	'Create check' => null,
	'Checks' => null,
	'Invalid permanent login, please login again.' => null,

	'Access denied.' => null,
	'Enter OTP code.' => null,
];
