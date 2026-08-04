<?php

namespace AdminNeo;

return [
	'ltr' => 'rtl', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'JJ/MM/AAAA', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => 'يجب أن يُرجع %s مصفوفة.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => 'يجب أن يُرجع %s و %s كائنا تم إنشاؤه بواسطة الدالة %s.', // by Claude Opus 5

	// Login
	'System' => 'النظام',
	'Server' => 'الخادم',
	'Username' => 'اسم المستخدم',
	'Password' => 'كلمة المرور',
	'Permanent login' => 'تسجيل دخول دائم',
	'Login' => 'تسجيل الدخول',
	'Logout' => 'تسجيل الخروج',
	'Logged as: %s' => 'تم تسجيل الدخول باسم %s',
	'Logout successful.' => 'تم تسجيل الخروج بنجاح.',
	'hostname[:port] or :socket' => 'اسم المضيف[:المنفذ] أو :المقبس', // by Claude Opus 5
	'Invalid server or credentials.' => 'الخادم أو بيانات الدخول غير صالحة.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'توجد مسافة في كلمة المرور المدخلة، وقد يكون هذا هو السبب.', // by Claude Opus 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'لا يدعم AdminNeo الدخول إلى قاعدة بيانات بدون كلمة مرور، <a href="https://www.adminneo.org/password"%s>مزيد من المعلومات</a>.', // by Claude Opus 5
	'Database does not support password.' => 'قاعدة البيانات لا تدعم كلمة المرور.', // by Claude Opus 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'عدد كبير جدا من محاولات الدخول الفاشلة، أعد المحاولة بعد %d دقيقة.',
		'عدد كبير جدا من محاولات الدخول الفاشلة، أعد المحاولة بعد %d دقائق.',
	], // by Claude Opus 5
	'Invalid permanent login, please login again.' => 'تسجيل الدخول الدائم غير صالح، من فضلك أعد تسجيل الدخول.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'رمز CSRF غير صالح. المرجو إرسال الاستمارة مرة أخرى.',
	'If you did not send this request from AdminNeo then close this page.' => 'إذا لم ترسل هذا الطلب من AdminNeo فأغلق هذه الصفحة.', // by Claude Opus 5
	'The action will be performed after successful login with the same credentials.' => 'سيتم تنفيذ الإجراء بعد تسجيل الدخول بنجاح بنفس بيانات الدخول.', // by Claude Opus 5

	// Connection
	'No driver' => 'لا يوجد مشغل', // by Claude Opus 5
	'Database driver not found.' => 'لم يتم العثور على مشغل قاعدة البيانات.', // by Claude Opus 5
	'No extension' => 'امتداد غير موجود',
	'None of the supported PHP extensions (%s) are available.' => 'إمتدادات php (%s) المدعومة غير موجودة.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'الاتصال بالمنافذ المحمية غير مسموح به.', // by Claude Opus 5
	'Session support must be enabled.' => 'عليك تفعيل نظام الجلسات.',
	'Session expired, please login again.' => 'إنتهت الجلسة، من فضلك أعد تسجيل الدخول.',
	'%s version: %s through PHP extension %s' => 'النسخة %s : %s عن طريق إمتداد ال PHP %s',

	// Settings
	'Language' => 'اللغة',

	'Home' => 'الرئيسية', // by Claude Opus 5
	'Refresh' => 'تحديث',
	'Info' => 'معلومات', // by Claude Opus 5
	'More information.' => 'مزيد من المعلومات.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'الإمتيازات',
	'Create user' => 'إنشاء مستخدم',
	'User has been dropped.' => 'تم حذف المستخدم.',
	'User has been altered.' => 'تم تعديل المستخدم.',
	'User has been created.' => 'تم إنشاء المستخدم.',
	'Hashed' => 'تلبيد',

	// Server
	'Process list' => 'قائمة الإجراءات',
	'%d process(es) have been killed.' => 'عدد الإجراءات التي تم إيقافها %d.',
	'Kill' => 'إيقاف',
	'Variables' => 'متغيرات',
	'Status' => 'حالة',

	// Structure
	'Column' => 'عمود',
	'Columns' => 'الأعمدة', // by Claude Opus 5
	'Routine' => 'روتين',
	'Grant' => 'موافق',
	'Revoke' => 'إلغاء',

	// Queries
	'SQL command' => 'استعلام SQL',
	'HTTP request' => 'طلب HTTP', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'تم تنفيذ الاستعلام %d بنجاح.',
		'تم تنفيذ الاستعلامات %d بنجاح.',
	],
	'Query executed OK, %d row(s) affected.' => 'تم تنفسذ الاستعلام, %d عدد الأسطر المعدلة.',
	'No commands to execute.' => 'لا توجد أوامر للتنفيذ.',
	'Error in query' => 'هناك خطأ في الاستعلام',
	'Unknown error.' => 'خطأ غير معروف.', // by Claude Opus 5
	'Warnings' => 'تحذيرات', // by Claude Opus 5
	'%s queries are not supported.' => 'استعلامات %s غير مدعومة.', // by Claude Opus 5
	'Execute' => 'تنفيذ',
	'Stop on error' => 'أوقف في حالة حدوث خطأ',
	'Show only errors' => 'إظهار الأخطاء فقط',
	'Time' => 'الوقت',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'تاريخ',
	'Clear' => 'مسح',
	'Edit all' => 'تعديل الكل',

	// Import
	'Import' => 'استيراد',
	'File upload' => 'رفع ملف',
	'From server' => 'من الخادم',
	'Webserver file %s' => 'ملف %s من خادم الويب',
	'Run file' => 'نفذ الملف',
	'File does not exist.' => 'الملف غير موجود.',
	'File uploads are disabled.' => 'رفع الملفات غير مشغل.',
	'Unable to upload a file.' => 'يتعذر رفع ملف ما.',
	'Maximum allowed file size is %sB.' => 'حجم الملف الأقصى هو %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'العدد الأقصى للملفات هو %d. اختر عددا أقل من الملفات أو قم بزيادة قيمة %s في خيارات ال PHP.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'الحجم الإجمالي الأقصى للملفات هو %s. اختر ملفات أصغر أو قم بزيادة قيمة %s في خيارات ال PHP.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'معلومات POST كبيرة جدا. قم بتقليص حجم المعلومات أو قم بزيادة قيمة %s في خيارات ال PHP.',
	'You can upload a big SQL file via FTP and import it from server.' => 'يمكنك رفع ملف SQL كبير عبر FTP ثم استيراده من الخادم.', // by Claude Opus 5
	'File must be in UTF-8 encoding.' => 'يجب أن يكون الملف بترميز UTF-8.', // by Claude Opus 5
	'You are offline.' => 'أنت غير متصل بالشبكة.', // by Claude Opus 5
	'%d row(s) have been imported.' => 'تم استيراد %d سطرا.',

	// Export
	'Export' => 'تصدير',
	'Output' => 'إخراج',
	'open' => 'فتح',
	'save' => 'حفظ',
	'Format' => 'الصيغة',
	'Data' => 'معلومات',

	// Databases
	'Database' => 'قاعدة بيانات',
	'database' => 'قاعدة بيانات', // by Claude Opus 5
	'DB' => 'ق.ب', // by Claude Opus 5
	'Use' => 'استعمال',
	'Invalid database.' => 'قاعدة البيانات غير صالحة.',
	'Alter database' => 'تعديل قاعدة البيانات',
	'Create database' => 'إنشاء قاعدة بيانات',
	'Database schema' => 'مخطط قاعدة البيانات', // by Claude Opus 5
	'Permanent link' => 'رابط دائم',
	'Database has been dropped.' => 'تم حذف قاعدة البيانات.',
	'Databases have been dropped.' => 'تم حذف قواعد البيانات.',
	'Database has been created.' => 'تم إنشاء قاعدة البيانات.',
	'Database has been renamed.' => 'تمت إعادة تسمية فاعدة البيانات.',
	'Database has been altered.' => 'تم تعديل قاعدة البيانات.',

	// SQLite errors
	'File exists.' => 'الملف موجود.',
	'Please use one of the extensions %s.' => 'المرجو استخدام إحدى الامتدادات %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'المخطط',
	'schema' => 'مخطط', // by Claude Opus 5
	'Schemas' => 'المخططات', // by Claude Opus 5
	'No schemas.' => 'لا توجد مخططات.', // by Claude Opus 5
	'Show schema' => 'عرض المخطط', // by Claude Opus 5
	'Alter schema' => 'تعديل المخطط',
	'Create schema' => 'إنشاء مخطط',
	'Schema has been dropped.' => 'تم حذف المخطط.',
	'Schema has been created.' => 'تم إنشاء المخطط.',
	'Schema has been altered.' => 'تم تعديل المخطط.',
	'Invalid schema.' => 'مخطط غير صالح.',

	// Table list
	'Engine' => 'المحرك',
	'engine' => 'المحرك',
	'Collation' => 'ترتيب',
	'collation' => 'الترتيب',
	'Data Length' => 'طول المعطيات',
	'Index Length' => 'طول المؤشر',
	'Data Free' => 'المساحة الحرة',
	'Rows' => 'الأسطر',
	'%d in total' => '%d في المجموع',
	'Analyze' => 'تحليل',
	'Optimize' => 'تحسين',
	'Vacuum' => 'تنظيف (Vacuum)', // by Claude Opus 5
	'Check' => 'فحص',
	'Repair' => 'إصلاح',
	'Truncate' => 'قطع',
	'Tables have been truncated.' => 'تم قطع الجداول.',
	'Move to other database' => 'نقل إلى قاعدة بيانات أخرى',
	'Move' => 'نقل',
	'Tables have been moved.' => 'تم نقل الجداول.',
	'Copy' => 'نسخ',
	'Tables have been copied.' => 'تم نسخ الجداول.',
	'overwrite' => 'استبدال', // by Claude Opus 5

	// Tables
	'Tables' => 'جداول',
	'Tables and views' => 'الجداول و العروض',
	'Table' => 'جدول',
	'No tables.' => 'لا توجد جداول.',
	'Alter table' => 'تعديل الجدول',
	'Create table' => 'إنشاء جدول',
	'Table has been dropped.' => 'تم حذف الجدول.',
	'Tables have been dropped.' => 'تم حذف الجداول.',
	'Tables have been optimized.' => 'تم تحسين الجداول.', // by Claude Opus 5
	'Table has been altered.' => 'تم تعديل الجدول.',
	'Table has been created.' => 'تم إنشاء الجدول.',
	'Table name' => 'اسم الجدول',
	'Name' => 'الاسم',
	'Show structure' => 'عرض التركيبة',
	'Column name' => 'اسم العمود',
	'Type' => 'النوع',
	'Length' => 'الطول',
	'Auto Increment' => 'تزايد تلقائي',
	'Options' => 'خيارات',
	'Comment' => 'تعليق',
	'Default value' => 'القيمة الافتراضية', // by Claude Opus 5
	'Drop' => 'حذف',
	'Drop %s?' => 'حذف %s؟', // by Claude Opus 5
	'Are you sure?' => 'هل أنت متأكد؟',
	'Size' => 'الحجم', // by Claude Opus 5
	'Compute' => 'حساب', // by Claude Opus 5
	'Move up' => 'نقل للأعلى',
	'Move down' => 'نقل للأسفل',
	'Remove' => 'مسح',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'لقد تجاوزت العدد الأقصى للحقول. يرجى الرفع من %s.',

	// Views
	'View' => 'عرض',
	'Materialized view' => 'عرض مُجسَّد', // by Claude Opus 5
	'View has been dropped.' => 'تم مسح العرض.',
	'View has been altered.' => 'تم تعديل العرض.',
	'View has been created.' => 'تم إنشاء العرض.',
	'Alter view' => 'تعديل عرض',
	'Create view' => 'إنشاء عرض',

	// Partitions
	'Partition by' => 'مقسم بواسطة',
	'Partition' => 'تقسيم', // by Claude Opus 5
	'Partitions' => 'التقسيمات',
	'Partition name' => 'اسم التقسيم',
	'Values' => 'القيم',
	'Inherited tables' => 'الجداول الموروثة', // by Claude Opus 5
	'Inherited from' => 'موروث من', // by Claude Opus 5

	// Indexes
	'Indexes' => 'المؤشرات',
	'Indexes have been altered.' => 'تم تعديل المؤشر.',
	'Alter indexes' => 'تعديل المؤشرات',
	'Add next' => 'إضافة التالي',
	'Index Type' => 'نوع المؤشر',
	'length' => 'الطول',
	'Algorithm' => 'الخوارزمية', // by Claude Opus 5
	'Condition' => 'الشرط', // by Claude Opus 5

	// Foreign keys
	'Foreign keys' => 'مفاتيح أجنبية',
	'Foreign key' => 'مفتاح أجنبي',
	'Foreign key has been dropped.' => 'تم مسح المفتاح الأجنبي.',
	'Foreign key has been altered.' => 'تم تعديل المفتاح الأجنبي.',
	'Foreign key has been created.' => 'تم إنشاء المفتاح الأجنبي.',
	'Target table' => 'الجدول المستهدف',
	'Change' => 'تعديل',
	'Source' => 'المصدر',
	'Target' => 'الهدف',
	'Add column' => 'إضافة عمودا',
	'Alter' => 'تعديل',
	'Add foreign key' => 'إضافة مفتاح أجنبي',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'أعمدة المصدر و الهدف يجب أن تكون بنفس النوع, يجب أن يكون هناك مؤشر في أعمدة الهدف و البيانات المرجعية يجب ان تكون موجودة.',

	// Routines
	'Routines' => 'الروتينات',
	'Routine has been called, %d row(s) affected.' => 'تم استدعاء الروتين, عدد الأسطر المعدلة %d.',
	'Call' => 'استدعاء',
	'Parameter name' => 'اسم المتغير',
	'Create procedure' => 'إنشاء إجراء',
	'Create function' => 'إنشاء دالة',
	'Routine has been dropped.' => 'تم حذف الروتين.',
	'Routine has been altered.' => 'تم تعديل الروتين.',
	'Routine has been created.' => 'تم إنشاء الروتين.',
	'Alter function' => 'تعديل الدالة',
	'Alter procedure' => 'تعديل الإجراء',
	'Return type' => 'نوع العودة',

	// Events
	'Events' => 'الأحداث',
	'Event' => 'الحدث',
	'Event has been dropped.' => 'تم مسح الحدث.',
	'Event has been altered.' => 'تم تعديل الحدث.',
	'Event has been created.' => 'تم إنشاء الحدث.',
	'Alter event' => 'تعديل حدث',
	'Create event' => 'إنشاء حدث',
	'At given time' => 'في وقت محدد',
	'Every' => 'كل',
	'Schedule' => 'مواعيد',
	'Start' => 'إبدأ',
	'End' => 'إنهاء',
	'On completion preserve' => 'حفظ عند الإنتهاء',

	// Sequences (PostgreSQL)
	'Sequences' => 'السلاسل',
	'Create sequence' => 'إنشاء سلسلة',
	'Sequence has been dropped.' => 'تم حذف السلسلة.',
	'Sequence has been created.' => 'تم إنشاء السلسلة.',
	'Sequence has been altered.' => 'تم تعديل السلسلة.',
	'Alter sequence' => 'تعديل سلسلة',

	// User types (PostgreSQL)
	'User types' => 'نوع المستخدم',
	'Create type' => 'إنشاء نوع',
	'Type has been dropped.' => 'تم حذف النوع.',
	'Type has been created.' => 'تم إنشاء النوع.',
	'Alter type' => 'تعديل نوع',

	// Triggers
	'Triggers' => 'الزنادات',
	'Add trigger' => 'إضافة زناد',
	'Trigger has been dropped.' => 'تم حذف الزناد.',
	'Trigger has been altered.' => 'تم تعديل الزناد.',
	'Trigger has been created.' => 'تم إنشاء الزناد.',
	'Alter trigger' => 'تعديل زناد',
	'Create trigger' => 'إنشاء زناد',

	// Table check constraints
	'Checks' => 'الفحوصات', // by Claude Opus 5
	'Create check' => 'إنشاء فحص', // by Claude Opus 5
	'Alter check' => 'تعديل فحص', // by Claude Opus 5
	'Check has been created.' => 'تم إنشاء الفحص.', // by Claude Opus 5
	'Check has been altered.' => 'تم تعديل الفحص.', // by Claude Opus 5
	'Check has been dropped.' => 'تم حذف الفحص.', // by Claude Opus 5

	// Selection
	'Select data' => 'عرض البيانات',
	'Select' => 'اختيار',
	'Functions' => 'الدوال',
	'Aggregation' => 'تجميع',
	'Search' => 'بحث',
	'anywhere' => 'في اي مكان',
	'Sort' => 'ترتيب',
	'descending' => 'تنازلي',
	'Limit' => 'حد',
	'Limit rows' => 'تحديد الأسطر', // by Claude Opus 5
	'Text length' => 'طول النص',
	'Action' => 'الإجراء',
	'Full table scan' => 'مسح كامل للجدول', // by Claude Opus 5
	'Unable to select the table' => 'يتعذر اختيار الجدول',
	'Search data in tables' => 'بحث في الجداول',
	'No rows.' => 'لا توجد نتائج.',
	'%d / ' => '%d / ', // by Claude Opus 5
	'%d row(s)' => '%d أسطر',
	'Page' => 'صفحة',
	'last' => 'الأخيرة',
	'Load more data' => 'تحميل المزيد من البيانات', // by Claude Opus 5
	'Loading' => 'جار التحميل', // by Claude Opus 5
	'Whole result' => 'نتيجة كاملة',
	'%d byte(s)' => '%d بايت',

	// In-place editing in selection
	'Modify' => 'تعديل', // by Claude Opus 5
	'Ctrl+click on a value to modify it.' => 'اضغط Ctrl مع النقر على القيمة لتعديلها.', // by Claude Opus 5
	'Use edit link to modify this value.' => 'استعمل الرابط "تعديل" لتعديل هذه القيمة.',

	// Editing
	'New item' => 'عنصر جديد',
	'Edit' => 'تعديل',
	'original' => 'الأصلي',
	'empty' => 'فارغ', // label for value '' in enum data type
	'Insert' => 'إنشاء',
	'Save' => 'حفظ',
	'Save and continue edit' => 'إحفظ و واصل التعديل',
	'Save and insert next' => 'جفظ و إنشاء التالي',
	'Saving' => 'جار الحفظ', // by Claude Opus 5
	'Selected' => 'المحدد', // by Claude Opus 5
	'Clone' => 'نسخ',
	'Delete' => 'مسح',
	'Item%s has been inserted.' => '%sتم إدراج العنصر.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'تم حذف العنصر.',
	'Item has been updated.' => 'تم تعديل العنصر.',
	'%d item(s) have been affected.' => 'عدد العناصر المعدلة هو %d.',
	'You have no privileges to update this table.' => 'ليس لديك صلاحيات لتعديل هذا الجدول.', // by Claude Opus 5

	// Data type descriptions
	'Numbers' => 'أعداد',
	'Date and time' => 'التاريخ و الوقت',
	'Strings' => 'سلاسل',
	'Binary' => 'ثنائية',
	'Lists' => 'قوائم',
	'Network' => 'شبكة',
	'Geometry' => 'هندسة',
	'Relations' => 'علاقات',

	// Editor - data values
	'now' => 'الآن',
	'yes' => 'نعم', // by Claude Opus 5
	'no' => 'لا', // by Claude Opus 5

	// Settings
	'Settings' => 'الإعدادات', // by Claude Opus 5
	'Default' => 'افتراضي', // by Claude Opus 5
	'Color scheme' => 'نظام الألوان', // by Claude Opus 5
	'By system' => 'حسب النظام', // by Claude Opus 5
	'Light' => 'فاتح', // by Claude Opus 5
	'Dark' => 'داكن', // by Claude Opus 5
	'Navigation mode' => 'نمط التصفح', // by Claude Opus 5
	'Simple' => 'بسيط', // by Claude Opus 5
	'Dual' => 'مزدوج', // by Claude Opus 5
	'Reversed' => 'معكوس', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'تخطيط التصفح الرئيسي مع روابط الجداول.', // by Claude Opus 5
	'Table links' => 'روابط الجداول', // by Claude Opus 5
	'Primary action for all table links.' => 'الإجراء الأساسي لجميع روابط الجداول.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'روابط للجداول التي تشير إلى السطر الحالي.', // by Claude Opus 5
	'Display' => 'إظهار', // by Claude Opus 5
	'Hide' => 'إخفاء', // by Claude Opus 5
	'Records per page' => 'عدد السجلات في الصفحة', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'العدد الافتراضي للسجلات المعروضة في جدول البيانات.', // by Claude Opus 5
	'Enum as select' => 'Enum كقائمة اختيار', // by Claude Opus 5
	'Never' => 'أبدا', // by Claude Opus 5
	'Always' => 'دائما', // by Claude Opus 5
	'More values than %d' => 'أكثر من %d قيمة', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'الحد الذي تظهر عنده قائمة اختيار لأعمدة enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'كلمة مرور لمرة واحدة', // by Claude Opus 5
	'Enter OTP code.' => 'أدخل رمز OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'رمز OTP غير صالح.', // by Claude Opus 5
	'Access denied.' => 'تم رفض الوصول.', // by Claude Opus 5
	'JSON previews' => 'معاينات JSON', // by Claude Opus 5
	'Data table' => 'جدول البيانات', // by Claude Opus 5
	'Edit form' => 'استمارة التعديل', // by Claude Opus 5
	'Ask %s' => null,
];
