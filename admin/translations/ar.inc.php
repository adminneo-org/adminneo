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
	'Invalid CSRF token. Send the form again.' => 'رمز CSRF غير صالح. المرجو إرسال الاستمارة مرة أخرى.',

	// Connection
	'No extension' => 'امتداد غير موجود',
	'None of the supported PHP extensions (%s) are available.' => 'إمتدادات php (%s) المدعومة غير موجودة.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'عليك تفعيل نظام الجلسات.',
	'Session expired, please login again.' => 'إنتهت الجلسة، من فضلك أعد تسجيل الدخول.',
	'%s version: %s through PHP extension %s' => 'النسخة %s : %s عن طريق إمتداد ال PHP %s',

	// Settings
	'Language' => 'اللغة',

	'Refresh' => 'تحديث',

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
	'Routine' => 'روتين',
	'Grant' => 'موافق',
	'Revoke' => 'إلغاء',

	// Queries
	'SQL command' => 'استعلام SQL',
	'%d query(s) executed OK.' => [
		'تم تنفيذ الاستعلام %d بنجاح.',
		'تم تنفيذ الاستعلامات %d بنجاح.',
	],
	'Query executed OK, %d row(s) affected.' => 'تم تنفسذ الاستعلام, %d عدد الأسطر المعدلة.',
	'No commands to execute.' => 'لا توجد أوامر للتنفيذ.',
	'Error in query' => 'هناك خطأ في الاستعلام',
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
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'معلومات POST كبيرة جدا. قم بتقليص حجم المعلومات أو قم بزيادة قيمة %s في خيارات ال PHP.',
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
	'Use' => 'استعمال',
	'Invalid database.' => 'قاعدة البيانات غير صالحة.',
	'Alter database' => 'تعديل قاعدة البيانات',
	'Create database' => 'إنشاء قاعدة بيانات',
	'Database schema' => 'مخطط فاعدة البيانات',
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
	'Check' => 'فحص',
	'Repair' => 'إصلاح',
	'Truncate' => 'قطع',
	'Tables have been truncated.' => 'تم قطع الجداول.',
	'Move to other database' => 'نقل إلى قاعدة بيانات أخرى',
	'Move' => 'نقل',
	'Tables have been moved.' => 'تم نقل الجداول.',
	'Copy' => 'نسخ',
	'Tables have been copied.' => 'تم نسخ الجداول.',

	// Tables
	'Tables' => 'جداول',
	'Tables and views' => 'الجداول و العروض',
	'Table' => 'جدول',
	'No tables.' => 'لا توجد جداول.',
	'Alter table' => 'تعديل الجدول',
	'Create table' => 'إنشاء جدول',
	'Table has been dropped.' => 'تم حذف الجدول.',
	'Tables have been dropped.' => 'تم حذف الجداول.',
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
	'Drop' => 'حذف',
	'Are you sure?' => 'هل أنت متأكد؟',
	'Move up' => 'نقل للأعلى',
	'Move down' => 'نقل للأسفل',
	'Remove' => 'مسح',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'لقد تجاوزت العدد الأقصى للحقول. يرجى الرفع من %s.',

	// Views
	'View' => 'عرض',
	'View has been dropped.' => 'تم مسح العرض.',
	'View has been altered.' => 'تم تعديل العرض.',
	'View has been created.' => 'تم إنشاء العرض.',
	'Alter view' => 'تعديل عرض',
	'Create view' => 'إنشاء عرض',

	// Partitions
	'Partition by' => 'مقسم بواسطة',
	'Partitions' => 'التقسيمات',
	'Partition name' => 'اسم التقسيم',
	'Values' => 'القيم',

	// Indexes
	'Indexes' => 'المؤشرات',
	'Indexes have been altered.' => 'تم تعديل المؤشر.',
	'Alter indexes' => 'تعديل المؤشرات',
	'Add next' => 'إضافة التالي',
	'Index Type' => 'نوع المؤشر',
	'length' => 'الطول',

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
	'Text length' => 'طول النص',
	'Action' => 'الإجراء',
	'Unable to select the table' => 'يتعذر اختيار الجدول',
	'Search data in tables' => 'بحث في الجداول',
	'No rows.' => 'لا توجد نتائج.',
	'%d row(s)' => '%d أسطر',
	'Page' => 'صفحة',
	'last' => 'الأخيرة',
	'Whole result' => 'نتيجة كاملة',
	'%d byte(s)' => '%d بايت',

	// In-place editing in selection
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
	'Clone' => 'نسخ',
	'Delete' => 'مسح',
	'Item%s has been inserted.' => '%sتم إدراج العنصر.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'تم حذف العنصر.',
	'Item has been updated.' => 'تم تعديل العنصر.',
	'%d item(s) have been affected.' => 'عدد العناصر المعدلة هو %d.',

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

	// Settings

	// Plugins
];
