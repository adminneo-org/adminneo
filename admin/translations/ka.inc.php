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
	'YYYY-MM-DD' => 'ᲓᲓ.ᲗᲗ.ᲬᲬᲬᲬ',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'სთ:წთ:წმ',

	// Bootstrap.

	// Login.
	'System' => 'სისტემა',
	'Server' => 'სერვერი',
	'Username' => 'მომხმარებელი',
	'Password' => 'პაროლი',
	'Permanent login' => 'სისტემაში დარჩენა',
	'Login' => 'შესვლა',
	'Logout' => 'გასვლა',
	'Logged as: %s' => 'შესული ხართ როგორც: %s',
	'Logout successful.' => 'გამოხვედით სისტემიდან.',
	'There is a space in the input password which might be the cause.' => 'პაროლში არის გამოტოვება, შეიძლება ეს ქმნის პრობლემას.',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'უპაროლო წვდომა ბაზასთან არაა დაშვებული AdminNeo-ში, მეტი ინფორმაციისთვის ეწვიეთ <a href="https://www.adminneo.org/password"%s>ბმულს</a>.',
	'Database does not support password.' => 'ბაზაში არაა მხარდაჭერილი პაროლი.',
	'Too many unsuccessful logins, try again in %d minute(s).' => 'ძალიან ბევრჯერ შეგეშალათ მომხმარებელი და პაროლი. სცადეთ %d წუთში.',
	'Invalid CSRF token. Send the form again.' => 'უმოქმედო CSRF-ტოკენი. ფორმის კიდევ ერთხელ გაგზავნა.',
	'If you did not send this request from AdminNeo then close this page.' => 'ეს მოთხოვნა თქვენ თუ არ გაგიგზავნაით AdminNeo-იდან, დახურეთ ეს ფანჯარა..',
	'The action will be performed after successful login with the same credentials.' => 'მოქმედება შესრულდება იგივე მომხმარებლით წარმატებული ავტორიზაციის შემდეგ.',

	// Connection.
	'No extension' => 'გაფართოება არაა',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'არც ერთი მხარდაჭერილი გაფართოება არ მოიძებნა (%s).',
	'Connecting to privileged ports is not allowed.' => 'პრივილეგირებულ პორტთან წვდომა დაუშვებელია.',
	'Session support must be enabled.' => 'ჩართული უნდა იყოს სესია.',
	'Session expired, please login again.' => 'სესიის მოქმედების დრო ამოიწურა, გაიარეთ ხელახალი ავტორიზაცია.',
	'%s version: %s through PHP extension %s' => 'ვერსია %s: %s PHP-გაფართოება %s',

	// Settings.
	'Language' => 'ენა',

	'Refresh' => 'განახლება',

	// Privileges.
	'Privileges' => 'უფლებამოსილება',
	'Create user' => 'მომხმარებლის შექმან',
	'User has been dropped.' => 'მომხმარებელი წაიშალა.',
	'User has been altered.' => 'მომხმარებელი შეიცვალა.',
	'User has been created.' => 'მომხმარებელი შეიქმნა.',
	'Hashed' => 'ჰეშირებული',

	// Server.
	'Process list' => 'პროცესების სია',
	'%d process(es) have been killed.' => 'გაითიშა %d პროცესი.',
	'Kill' => 'დასრულება',
	'Variables' => 'ცვლადები',
	'Status' => 'მდგომარეობა',

	// Structure.
	'Column' => 'ველი',
	'Routine' => 'პროცედურა',
	'Grant' => 'დაშვება',
	'Revoke' => 'შეზღუდვა',

	// Queries.
	'SQL command' => 'SQL-ბრძანება',
	'%d query(s) executed OK.' => '%d მოთხოვნა შესრულდა.',
	'Query executed OK, %d row(s) affected.' => 'მოთხოვდა შესრულდა, შეიცვალა %d ჩანაწერი.',
	'No commands to execute.' => 'შესასრულებელი ბრძანება არაა.',
	'Error in query' => 'შეცდომა მოთხოვნაში',
	'Unknown error.' => 'უცნობი შეცდომა.',
	'Warnings' => 'გაფრთხილება',
	'%s queries are not supported.' => '%s-მოთხოვნები არაა მხარდაჭერილი.',
	'Execute' => 'შესრულება',
	'Stop on error' => 'გაჩერება შეცდომისას',
	'Show only errors' => 'მხოლოდ შეცდომები',
	'Time' => 'დრო',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'ისტორია',
	'Clear' => 'გასუფთავება',
	'Edit all' => 'ყველას შეცვლა',

	// Import.
	'Import' => 'იმპორტი',
	'File upload' => 'ფაილის ატვირთვა სერვერზე',
	'From server' => 'სერვერიდან',
	'Webserver file %s' => 'ფაილი %s ვებსერვერზე',
	'Run file' => 'ფაილის გაშვება',
	'File does not exist.' => 'ასეთი ფაილი არ არსებობს.',
	'File uploads are disabled.' => 'ფაილის სერვერზე ატვირთვა გათიშულია.',
	'Unable to upload a file.' => 'ფაილი არ აიტვირთა სერვერზე.',
	'Maximum allowed file size is %sB.' => 'ფაილის მაქსიმალური ზომა - %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST ინფორმაცია ძალიან დიდია. შეამცირეთ ზომა ან გაზარდეს POST ინფორმაციის ზომა პარამეტრებიდან %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'დიდი ფაილი უნდა ატვირტოთ FTP-თი და შემდეგ გაუკეთოთ იმპორტი სერვერიდან.',
	'File must be in UTF-8 encoding.' => 'ფაილი უნდა იყოს კოდირებაში UTF-8.',
	'You are offline.' => 'არ გაგივლიათ ავტორიზაცია.',
	'%d row(s) have been imported.' => 'დაიმპორტდა %d რიგი.',

	// Export.
	'Export' => 'ექსპორტი',
	'Output' => 'გამომავალი ინფორმაცია',
	'open' => 'გახსნა',
	'save' => 'შენახვა',
	'Format' => 'ფორმატი',
	'Data' => 'ინფორმაცია',

	// Databases.
	'Database' => 'ბაზა',
	'DB' => 'ბაზა',
	'Use' => 'არჩევა',
	'Invalid database.' => 'არასწორი ბაზა.',
	'Alter database' => 'ბაზის შეცვლა',
	'Create database' => 'ბაზის შექმნა',
	'Database schema' => 'ბაზის სქემა',
	'Permanent link' => 'მუდმივი ბმული',
	'Database has been dropped.' => 'ბაზა წაიშალა.',
	'Databases have been dropped.' => 'ბაზა წაიშალა.',
	'Database has been created.' => 'ბაზა შეიქმნა.',
	'Database has been renamed.' => 'ბაზას გადაერქვა.',
	'Database has been altered.' => 'ბაზა შეიცვალა.',
	// SQLite errors.
	'File exists.' => 'ფაილი უკვე არსებობს.',
	'Please use one of the extensions %s.' => 'გამოიყენეთ ერთ-ერთი გაფართოება %s.',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'სქემა',
	'Alter schema' => 'სქემის შეცვლა',
	'Create schema' => 'ახალი სქემა',
	'Schema has been dropped.' => 'სქემა წაიშალა.',
	'Schema has been created.' => 'შეიქმნა ახალი სქემა.',
	'Schema has been altered.' => 'სქემა შეიცვალა.',
	'Invalid schema.' => 'არასწორი სქემა.',

	// Table list.
	'Engine' => 'ძრავი',
	'engine' => 'სახეობა',
	'Collation' => 'კოდირება',
	'collation' => 'კოდირება',
	'Data Length' => 'ინფორმაციის მოცულობა',
	'Index Length' => 'ინდექსების მოცულობა',
	'Data Free' => 'თავისუფალი სივრცე',
	'Rows' => 'რიგი',
	'%d in total' => 'სულ %d',
	'Analyze' => 'ანალიზი',
	'Optimize' => 'ოპტიმიზაცია',
	'Vacuum' => 'ვაკუუმი',
	'Check' => 'შემოწმება',
	'Repair' => 'გასწორება',
	'Truncate' => 'გასუფთავება',
	'Tables have been truncated.' => 'ცხრილი გასუფთავდა.',
	'Move to other database' => 'გადატანა სხვა ბაზაში',
	'Move' => 'გადატანა',
	'Tables have been moved.' => 'ცხრილი გადაადგილდა.',
	'Copy' => 'კოპირება',
	'Tables have been copied.' => 'ცხრილი დაკოპირდა.',

	// Tables.
	'Tables' => 'ცხრილები',
	'Tables and views' => 'ცხრილები და წარმოდგენები',
	'Table' => 'ცხრილი',
	'No tables.' => 'ბაზაში ცხრილი არაა.',
	'Alter table' => 'ცხრილის შეცვლა',
	'Create table' => 'ცხრილის შექმნა',
	'Table has been dropped.' => 'ცხრილი წაიშალა.',
	'Tables have been dropped.' => 'ცხრილები წაიშალა.',
	'Tables have been optimized.' => 'ცხრილებს გაუკეთდა ოპტიმიზაცია.',
	'Table has been altered.' => 'ცხრილი შეიცვალა.',
	'Table has been created.' => 'ცხრილი შეიქმნა.',
	'Table name' => 'სახელი',
	'Name' => 'სახელი',
	'Show structure' => 'სტრუქტურის ჩვენება',
	'Column name' => 'ველი',
	'Type' => 'სახეობა',
	'Length' => 'სიგრძე',
	'Auto Increment' => 'ავტომატურად გაზრდა',
	'Options' => 'მოქმედება',
	'Comment' => 'კომენტარები',
	'Default value' => 'სტანდარტული მნიშვნელობა',
	'Drop' => 'წაშლა',
	'Drop %s?' => 'წაიშალოს %s?',
	'Are you sure?' => 'ნამდვილად?',
	'Size' => 'ზომა',
	'Compute' => 'გამოთვლა',
	'Move up' => 'ზემოთ ატანა',
	'Move down' => 'ქვემოთ ჩატანა',
	'Remove' => 'წაშლა',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'მიღწეულია დაშვებული ველების მაქსიმალური რაოდენობა, გაზარდეთ %s.',

	// Views.
	'View' => 'ნახვა',
	'Materialized view' => 'მატერიალური ხედი',
	'View has been dropped.' => 'წარმოდგენა წაიშალა.',
	'View has been altered.' => 'წარმოდგენა შეიცვალა.',
	'View has been created.' => 'წარმოდგენა შეიქმნა.',
	'Alter view' => 'წარმოდგენის შეცვლა',
	'Create view' => 'წარმოდგენის შექმნა',

	// Partitions.
	'Partition by' => 'დაყოფა',
	'Partitions' => 'დანაყოფები',
	'Partition name' => 'დანაყოფის სახელი',
	'Values' => 'პარამეტრები',

	// Indexes.
	'Indexes' => 'ინდექსები',
	'Indexes have been altered.' => 'შეიცვალა ინდექსები.',
	'Alter indexes' => 'ინდექსის შეცვლა',
	'Add next' => 'კიდევ დამატება',
	'Index Type' => 'ინდექსის სახეობა',
	'length' => 'სიგრძე',

	// Foreign keys.
	'Foreign keys' => 'გარე გასაღები',
	'Foreign key' => 'გარე გასაღები',
	'Foreign key has been dropped.' => 'გარე გასაღები წაიშალა.',
	'Foreign key has been altered.' => 'გარე გასაღები შეიცვალა.',
	'Foreign key has been created.' => 'გარე გასაღები შეიქმნა.',
	'Target table' => 'მიზნობრივი ცხრილი',
	'Change' => 'შეცვლა',
	'Source' => 'წყარო',
	'Target' => 'სამიზნე',
	'Add column' => 'ველის დამატება',
	'Alter' => 'შეცვლა',
	'Add foreign key' => 'გარე გასაღები დამატება',
	'ON DELETE' => 'წაშლისას',
	'ON UPDATE' => 'განახლებისას',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'საწყისი და მიზნობრივი ველები უნდა იყოს ერთიდაიგივე სახეობის, მიზნობრივ ველზე უნდა იყოს ინდექსი და უნდა არსებობდეს შესაბამისი ინფორმაცია.',

	// Routines.
	'Routines' => 'რუტინები',
	'Routine has been called, %d row(s) affected.' => 'გამოძახებულია პროცედურა, შეიცვალა %d ჩანაწერი.',
	'Call' => 'გამოძახეება',
	'Parameter name' => 'პარამეტრი',
	'Create procedure' => 'პროცედურის შექმნა',
	'Create function' => 'ფუნქციის შექმნა',
	'Routine has been dropped.' => 'პროცედურა წაიშალა.',
	'Routine has been altered.' => 'პროცედურა შეიცვალა.',
	'Routine has been created.' => 'პროცედურა შეიქმნა.',
	'Alter function' => 'ფუნქციის შეცვლა',
	'Alter procedure' => 'პროცედურის შეცვლა',
	'Return type' => 'დაბრუნების სახეობა',

	// Events.
	'Events' => 'ღონისძიება',
	'Event' => 'ღონისძიება',
	'Event has been dropped.' => 'ღონისძიება წაიშალა.',
	'Event has been altered.' => 'ღონისძიება შეიცვალა.',
	'Event has been created.' => 'ღონისძიება შეიქმნა.',
	'Alter event' => 'ღონისძიების შეცვლა',
	'Create event' => 'ღონისძიების შექმნა',
	'At given time' => 'მოცემულ დროში',
	'Every' => 'ყოველ',
	'Schedule' => 'განრიგი',
	'Start' => 'დასაწყისი',
	'End' => 'დასასრული',
	'On completion preserve' => 'შენახვა დასრულებისას',

	// Sequences (PostgreSQL).
	'Sequences' => 'მიმდევრობა',
	'Create sequence' => 'მიმდევრობის შექმნა',
	'Sequence has been dropped.' => 'მიმდევრობა წაიშალა.',
	'Sequence has been created.' => 'მიმდევრობა შეიქმნა.',
	'Sequence has been altered.' => 'მიმდევრობა შეიცვალა.',
	'Alter sequence' => 'მიმდევრობის შეცვლა',

	// User types (PostgreSQL)
	'User types' => 'მომხმარებლის სახეობა',
	'Create type' => 'სახეობის შექმნა',
	'Type has been dropped.' => 'სახეობა წაიშალა.',
	'Type has been created.' => 'სახეობა შეიქმნა.',
	'Alter type' => 'სახეობის შეცვლა',

	// Triggers.
	'Triggers' => 'ტრიგერები',
	'Add trigger' => 'ტრიგერის დამატება',
	'Trigger has been dropped.' => 'ტრიგერი წაიშალა.',
	'Trigger has been altered.' => 'ტრიგერი შეიცვალა.',
	'Trigger has been created.' => 'ტრიგერი შეიქმნა.',
	'Alter trigger' => 'ტრიგერის შეცვლა',
	'Create trigger' => 'ტრიგერის შექმნა',

	// Table check constraints.

	// Selection.
	'Select data' => 'არჩევა',
	'Select' => 'არჩევა',
	'Functions' => 'ფუნქციები',
	'Aggregation' => 'აგრეგაცია',
	'Search' => 'ძებნა',
	'anywhere' => 'ნებისმიერ ადგილას',
	'Sort' => 'დალაგება',
	'descending' => 'კლებადობით',
	'Limit' => 'ზღვარი',
	'Limit rows' => 'რიგების შეზღუდვა',
	'Text length' => 'ტექსტის სიგრძე',
	'Action' => 'მოქმედება',
	'Full table scan' => 'სრული ცხრილის ანალიზი',
	'Unable to select the table' => 'ცხრილიდან ინფორმაცია ვერ მოვიპოვე',
	'Search data in tables' => 'ცხრილებში ძებნა',
	'No rows.' => 'ჩანაწერი არაა.',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d რიგი',
	'Page' => 'გვერდი',
	'last' => 'ბოლო',
	'Load more data' => 'მეტი ინფორმაციის ჩატვირთვა',
	'Loading' => 'ჩატვირთვა',
	'Whole result' => 'სრული შედეგი',
	'%d byte(s)' => '%d ბაიტი',

	// In-place editing in selection.
	'Modify' => 'შეცვლა',
	'Ctrl+click on a value to modify it.' => 'შესაცვლელად გამოიყენეთ Ctrl+თაგვის ღილაკი.',
	'Use edit link to modify this value.' => 'ამ მნიშვნელობის შესაცვლელად გამოიყენეთ ბმული «შეცვლა».',

	// Editing.
	'New item' => 'ახალი ჩანაწერი',
	'Edit' => 'შეცვლა',
	'original' => 'საწყისი',
	// label for value '' in enum data type
	'empty' => 'ცარიელი',
	'Insert' => 'ჩასმა',
	'Save' => 'შენახვა',
	'Save and continue edit' => 'შენახვა და ცვლილების გაგრძელება',
	'Save and insert next' => 'შენახვა და სხვის ჩასმა',
	'Saving' => 'შენახვა',
	'Selected' => 'არჩეული',
	'Clone' => 'კლონირება',
	'Delete' => 'წაშლა',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'ჩანაწერი%s ჩაჯდა.',
	'Item has been deleted.' => 'ჩანაწერი წაიშალა.',
	'Item has been updated.' => 'ჩანაწერი განახლდა.',
	'%d item(s) have been affected.' => 'შეიცვალა %d ჩანაწერი.',
	'You have no privileges to update this table.' => 'ამ ცხრილის განახლების უფლება არ გაქვთ.',

	// Data type descriptions.
	'Numbers' => 'ციფრები',
	'Date and time' => 'დრო და თარიღი',
	'Strings' => 'ველები',
	'Binary' => 'ორობითი',
	'Lists' => 'სია',
	'Network' => 'ქსელი',
	'Geometry' => 'გეომეტრია',
	'Relations' => 'ურთიერთობა',

	// Editor - data values.
	'now' => 'ახლა',
	'yes' => 'კი',
	'no' => 'არა',

	// Plugins.
];
