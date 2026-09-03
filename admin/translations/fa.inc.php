<?php

namespace AdminNeo;

return [
	'ltr' => 'rtl', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '۰۱۲۳۴۵۶۷۸۹',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s بایستی یک آرایه برگرداند.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s و %s بایستی یک شیء ایجاد شده توسط متد %s برگردانند.', // by Claude Fable 5.1

	// Login
	'System' => 'سیستم',
	'Server' => 'سرور',
	'Username' => 'نام کاربری',
	'Password' => 'کلمه عبور',
	'Permanent login' => 'ورود دائم',
	'Login' => 'ورود',
	'Logout' => 'خروج',
	'Logged as: %s' => 'ورود به عنوان: %s',
	'Logout successful.' => 'با موفقیت خارج شدید.',
	'hostname[:port] or :socket' => 'نام میزبان[:پورت] یا :سوکت', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'سرور یا اطلاعات ورود نامعتبر است.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'در کلمه عبور وارد شده فاصله وجود دارد که ممکن است دلیل آن باشد.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo از دسترسی به پایگاه داده بدون کلمه عبور پشتیبانی نمی کند، <a href="https://www.adminneo.org/password"%s>اطلاعات بیشتر</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'پایگاه داده از کلمه عبور پشتیبانی نمی کند.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => 'ورودهای ناموفق بیش از حد، %d دقیقه دیگر تلاش نمایید.',
	'Invalid permanent login, please login again.' => 'ورود دائم نامعتبر است، لطفا دوباره وارد شوید.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'CSRF token نامعتبر است. دوباره سعی کنید.',
	'If you did not send this request from AdminNeo then close this page.' => 'اگر این درخواست را از AdminNeo ارسال نکرده اید، این صفحه را ببندید.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'این عملیات پس از ورود موفق با همان اطلاعات انجام خواهد شد.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'پسوند نامعتبر',
	'None of the supported PHP extensions (%s) are available.' => 'هیچ کدام از افزونه های PHP پشتیبانی شده (%s) موجود نمی باشند.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'اتصال به پورتهای ممتاز مجاز نیست.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'پشتیبانی از نشست بایستی فعال گردد.',
	'Session expired, please login again.' => 'نشست پایان یافته، لطفا دوباره وارد شوید.',
	'%s version: %s through PHP extension %s' => 'نسخه %s : %s توسعه پی اچ پی %s',

	// Settings
	'Language' => 'زبان',

	'Menu' => 'منو', // by Claude Fable 5.1
	'Home' => 'خانه', // by Claude Fable 5.1
	'Refresh' => 'بازیابی',
	'Info' => 'اطلاعات', // by Claude Fable 5.1
	'More information.' => 'اطلاعات بیشتر.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'امتیازات',
	'Create user' => 'ایجاد کاربر',
	'User has been dropped.' => 'کاربر حذف شد.',
	'User has been altered.' => 'کاربر ویرایش گردید.',
	'User has been created.' => 'کاربر ایجاد شد.',
	'Hashed' => 'به هم ریخته',

	// Server
	'Process list' => 'لیست فرآیند',
	'%d process(es) have been killed.' => '%d فرآیند متوقف شد.',
	'Kill' => 'حذف فرآیند',
	'Variables' => 'متغیرها',
	'Status' => 'وضعیت',

	// Structure
	'Column' => 'ستون',
	'Columns' => 'ستونها', // by Claude Fable 5.1
	'Routine' => 'روتین',
	'Grant' => 'اعطا',
	'Revoke' => 'لغو کردن',

	// Queries
	'SQL command' => 'دستور SQL',
	'HTTP request' => 'درخواست HTTP', // by Claude Fable 5.1
	'%d query(s) executed OK.' => '%d کوئری اجرا شد.',
	'Query executed OK, %d row(s) affected.' => 'کوئری اجرا شد. %d سطر تغیر کرد.',
	'No commands to execute.' => 'دستوری برای اجرا وجود ندارد.',
	'Error in query' => 'خطا در کوئری',
	'Unknown error.' => 'خطای ناشناخته.', // by Claude Fable 5.1
	'Warnings' => 'هشدارها', // by Claude Fable 5.1
	'%s queries are not supported.' => 'کوئری های %s پشتیبانی نمی شوند.', // by Claude Fable 5.1
	'Execute' => 'اجرا',
	'Stop on error' => 'توقف بر روی خطا',
	'Show only errors' => 'فقط نمایش خطاها',
	'Time' => 'زمان',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'تاریخچه', // by Claude Fable 5.1
	'Clear' => 'پاک کردن',
	'Edit all' => 'ویرایش همه',

	// Import
	'Import' => 'وارد کردن',
	'File upload' => 'بارگذاری فایل',
	'From server' => 'از سرور',
	'Webserver file %s' => '%s فایل وب سرور',
	'Run file' => 'اجرای فایل',
	'File does not exist.' => 'فایل وجود ندارد.',
	'File uploads are disabled.' => 'بارگذاری غیر فعال است.',
	'Unable to upload a file.' => 'قادر به بارگذاری فایل نیستید.',
	'Maximum allowed file size is %sB.' => ' %sB حداکثر اندازه فایل.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'حداکثر تعداد فایل %d است. فایل کمتری انتخاب کنید و یا مقدار %s را در پیکربندی افزایش دهید.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'حداکثر حجم کل فایلها %s است. فایلهای کوچکتری انتخاب کنید و یا مقدار %s را در پیکربندی افزایش دهید.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'حجم داده ارسالی برزگ است. حجم داده کاهش دهید و یا مقدار %s را در پیکربندی افزایش دهید.',
	'You can upload a big SQL file via FTP and import it from server.' => 'شما می توانید فایل SQL حجیم را از طریق FTP بارگزاری و از روی سرور وارد نمایید.',
	'File must be in UTF-8 encoding.' => 'فرمت فایل باید UTF-8 باشید.',
	'You are offline.' => 'شما آفلاین می باشید.',
	'%d row(s) have been imported.' => '%d سطر وارد شد.',

	// Export
	'Export' => 'استخراج',
	'Output' => 'خروجی',
	'open' => 'بازکردن',
	'save' => 'ذخیره',
	'Format' => 'قالب', // by Claude Fable 5.1
	'Data' => 'داده',

	// Databases
	'Database' => 'پایگاه داده',
	'database' => 'پایگاه داده', // by Claude Fable 5.1
	'DB' => 'پایگاه', // by Claude Fable 5.1
	'Use' => 'استفاده',
	'Invalid database.' => 'پایگاه داده نامعتبر.',
	'Alter database' => 'ویرایش پایگاه داده',
	'Create database' => 'ایجاد پایگاه داده',
	'Database schema' => 'ساختار پایگاه داده',
	'Permanent link' => 'ارتباط دائم',
	'Database has been dropped.' => 'پایگاه داده حذف شد.',
	'Databases have been dropped.' => 'پایگاه های داده حذف شدند.',
	'Database has been created.' => 'پایگاه داده ایجاد شد.',
	'Database has been renamed.' => 'نام پایگاه داده تغیر کرد.',
	'Database has been altered.' => 'پایگاه داده ویرایش شد.',

	// SQLite errors
	'File exists.' => 'فایل موجود است.',
	'Please use one of the extensions %s.' => 'لطفا یکی از پسوندها را انتخاب نمائید %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'ساختار',
	'schema' => 'ساختار', // by Claude Fable 5.1
	'Schemas' => 'ساختارها', // by Claude Fable 5.1
	'No schemas.' => 'ساختاری وجود ندارد.', // by Claude Fable 5.1
	'Show schema' => 'نمایش ساختار', // by Claude Fable 5.1
	'Alter schema' => 'ویرایش ساختار',
	'Create schema' => 'ایجاد ساختار',
	'Schema has been dropped.' => 'ساختار حذف شد.',
	'Schema has been created.' => 'ساختار ایجاد شد.',
	'Schema has been altered.' => 'ساختار ویرایش شد.',
	'Invalid schema.' => 'ساختار نامعتبر.',

	// Table list
	'Engine' => 'موتور',
	'engine' => 'موتور',
	'Collation' => 'تطبیق',
	'collation' => 'تطبیق',
	'Data Length' => 'طول داده',
	'Index Length' => 'طول ایندکس',
	'Data Free' => 'داده اختیاری',
	'Rows' => 'سطرها',
	'%d in total' => ' به طور کل %d ',
	'Analyze' => 'تحلیل',
	'Optimize' => 'بهینه سازی',
	'Vacuum' => 'پاک سازی',
	'Check' => 'بررسی',
	'Repair' => 'تعمیر',
	'Truncate' => 'کوتاه کردن',
	'Truncate Cascade' => 'کوتاه کردن آبشاری', // by Claude Fable 5.1
	'Tables have been truncated.' => 'جدولها بریده شدند.',
	'Move to other database' => 'انتقال به یک پایگاه داده دیگر',
	'Move' => 'انتقال',
	'Tables have been moved.' => 'جدولها انتقال داده شدند.',
	'Copy' => 'کپی کردن',
	'Tables have been copied.' => 'جدولها کپی شدند.',
	'overwrite' => 'بازنویسی', // by Claude Fable 5.1

	// Tables
	'Tables' => 'جدولها',
	'Tables and views' => 'جدولها و نمایه ها',
	'Table' => 'جدول',
	'No tables.' => 'جدولی وجود ندارد.',
	'Alter table' => 'ویرایش جدول',
	'Create table' => 'ایجاد جدول',
	'Table has been dropped.' => 'جدول حذف شد.',
	'Tables have been dropped.' => 'جدولها حذف شدند.',
	'Tables have been optimized.' => 'جدولها بهینه شدند.',
	'Table has been altered.' => 'جدول ویرایش شد.',
	'Table has been created.' => 'جدول ایجاد شد.',
	'Table name' => 'نام جدول',
	'Name' => 'نام',
	'Show structure' => 'نمایش ساختار',
	'Column name' => 'نام ستون',
	'Type' => 'نوع',
	'Length' => 'طول',
	'Auto Increment' => 'افزایش خودکار',
	'Options' => 'اختیارات',
	'Comment' => 'توضیح',
	'Default value' => 'مقدار پیش فرض',
	'Drop' => 'حذف',
	'Drop %s?' => '%s حذف شود؟', // by Claude Fable 5.1
	'Are you sure?' => 'مطمئن هستید؟',
	'Size' => 'حجم',
	'Compute' => 'محاسبه',
	'Move up' => 'انتقال به بالا',
	'Move down' => 'انتقال به پایین',
	'Remove' => 'حذف',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'حداکثر تعداد فیلدهای مجاز اشباع شد. لطفا %s را افزایش دهید.',

	// Views
	'View' => 'نمایش',
	'Materialized view' => 'نمایه مادی',
	'View has been dropped.' => 'نمایش حذف شد.',
	'View has been altered.' => 'نمایش ویرایش شد.',
	'View has been created.' => 'نمایش ایجاد شد.',
	'Alter view' => 'ویرایش نمایش', // by Claude Fable 5.1
	'Create view' => 'ایجاد نمایش',

	// Partitions
	'Partition by' => 'بخشبندی توسط',
	'Partition' => 'بخش', // by Claude Fable 5.1
	'Partitions' => 'بخشبندیها',
	'Partition name' => 'نام بخش',
	'Values' => 'مقادیر',
	'Inherited tables' => 'جدولهای ارث بری شده', // by Claude Fable 5.1
	'Inherited from' => 'ارث بری از', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'ایندکسها',
	'Indexes have been altered.' => 'ایندکسها ویرایش شدند.',
	'Alter indexes' => 'ویرایش ایندکسها',
	'Add next' => 'افرودن بعدی',
	'Index Type' => 'نوع ایندکس',
	'length' => 'طول',
	'operator class' => 'کلاس عملگر', // by Claude Fable 5.1
	'Algorithm' => 'الگوریتم', // by Claude Fable 5.1
	'Condition' => 'شرط', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'کلیدهای خارجی',
	'Foreign key' => 'کلید خارجی',
	'Foreign key has been dropped.' => 'کلید خارجی حذف شد.',
	'Foreign key has been altered.' => 'کلید خارجی ویرایش شد.',
	'Foreign key has been created.' => 'کلید خارجی ایجاد شد.',
	'Target table' => 'جدول هدف',
	'Change' => 'تغییر',
	'Source' => 'منبع',
	'Target' => 'هدف',
	'Add column' => 'افزودن ستون',
	'Alter' => 'ویرایش',
	'Add foreign key' => 'افزودن کلید خارجی',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'داده مبدا و مقصد ستونها بایستی شبیه هم باشند.',

	// Routines
	'Routines' => 'روالها',
	'Routine has been called, %d row(s) affected.' => 'روال فراخوانی شد %d سطر متاثر شد.',
	'Call' => 'صدا زدن',
	'Parameter name' => 'نام پارامتر',
	'Create procedure' => 'ایجاد زیربرنامه',
	'Create function' => 'ایجاد تابع',
	'Routine has been dropped.' => 'روال حذف شد.',
	'Routine has been altered.' => 'روال ویرایش شد.',
	'Routine has been created.' => 'روال ایجاد شد.',
	'Alter function' => 'ویرایش تابع',
	'Alter procedure' => 'ویرایش زیربرنامه',
	'Return type' => 'برگرداندن نوع',

	// Events
	'Events' => 'رویدادها',
	'Event' => 'رویداد',
	'Event has been dropped.' => 'رویداد حذف شد.',
	'Event has been altered.' => 'رویداد ویرایش شد.',
	'Event has been created.' => 'رویداد ایجاد شد.',
	'Alter event' => 'ویرایش رویداد',
	'Create event' => 'ایجاد رویداد',
	'At given time' => 'زمان معین',
	'Every' => 'هر', // by Claude Fable 5.1
	'Schedule' => 'زمانبندی',
	'Start' => 'آغاز',
	'End' => 'پایان',
	'On completion preserve' => 'تکمیل حفاظت فعال است',

	// Sequences (PostgreSQL)
	'Sequences' => 'صف ها',
	'Create sequence' => 'ایجاد صف',
	'Sequence has been dropped.' => 'صف حذف شد.',
	'Sequence has been created.' => 'صف ایجاد شد.',
	'Sequence has been altered.' => 'صف ویرایش شد.',
	'Alter sequence' => 'ویرایش صف',

	// User-defined types (PostgreSQL)
	'User types' => 'انواع کاربر',
	'Create type' => 'ایجاد نوع',
	'Type has been dropped.' => 'نوع حذف شد.',
	'Type has been created.' => 'نوع ایجاد شد.',
	'Alter type' => 'ویرایش نوع',

	// Triggers
	'Triggers' => 'تریگرها',
	'Add trigger' => 'افزودن تریگر',
	'Trigger has been dropped.' => 'تریگر حذف شد.',
	'Trigger has been altered.' => 'تریگر ویرایش شد.',
	'Trigger has been created.' => 'تریگر ایجاد شد.',
	'Alter trigger' => 'ویرایش تریگر',
	'Create trigger' => 'ایجاد تریگر',

	// Table check constraints
	'Checks' => 'بررسیها', // by Claude Fable 5.1
	'Create check' => 'ایجاد بررسی', // by Claude Fable 5.1
	'Alter check' => 'ویرایش بررسی', // by Claude Fable 5.1
	'Check has been created.' => 'بررسی ایجاد شد.', // by Claude Fable 5.1
	'Check has been altered.' => 'بررسی ویرایش شد.', // by Claude Fable 5.1
	'Check has been dropped.' => 'بررسی حذف شد.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'انتخاب داده',
	'Select' => 'انتخاب',
	'Functions' => 'توابع',
	'Aggregation' => 'تجمع',
	'Search' => 'جستجو',
	'anywhere' => 'هرکجا',
	'Sort' => 'مرتب کردن',
	'descending' => 'نزولی',
	'Limit' => 'محدودیت',
	'Limit rows' => 'محدودیت سطرها',
	'Text length' => 'طول متن',
	'Action' => 'عملیات',
	'Full table scan' => 'اسکن کامل جدول',
	'Unable to select the table' => 'قادر به انتخاب جدول نیستید',
	'Search data in tables' => 'جستجوی داده در جدول',
	'No rows.' => 'سطری وجود ندارد.',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d سطر',
	'Page' => 'صفحه',
	'last' => 'آخری',
	'Load more data' => 'بارگزاری اطلاعات بیشتر',
	'Loading' => 'در حال بارگزاری',
	'Whole result' => 'همه نتایج',
	'%d byte(s)' => '%d بایت',

	// In-place editing in selection
	'Modify' => 'ویرایش',
	'Ctrl+click on a value to modify it.' => 'برای ویرایش بر روی مقدار ctrl+click کنید.',
	'Use edit link to modify this value.' => 'از لینک ویرایش برای ویرایش این مقدار استفاده کنید.',

	// Editing
	'New item' => 'آیتم جدید',
	'Edit' => 'ویرایش',
	'original' => 'اصلی',
	'empty' => 'خالی', // label for value '' in enum data type
	'Insert' => 'درج',
	'Save' => 'ذخیره',
	'Save and continue edit' => 'ذخیره و ادامه ویرایش',
	'Save and insert next' => 'ذخیره و درج بعدی',
	'Saving' => 'در حال ذخیره', // by Claude Fable 5.1
	'Selected' => 'انتخاب شده',
	'Clone' => 'تکثیر',
	'Delete' => 'حذف',
	'Item%s has been inserted.' => '%s آیتم درج شد.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'آیتم حذف شد.',
	'Item has been updated.' => 'آیتم بروز رسانی شد.',
	'%d item(s) have been affected.' => '%d آیتم متاثر شد.',
	'You have no privileges to update this table.' => 'شما اختیار ویرایش این جدول را ندارید.',

	// Data type descriptions
	'Numbers' => 'اعداد',
	'Date and time' => 'تاریخ و زمان',
	'Strings' => 'رشته ها',
	'Binary' => 'دودویی',
	'Lists' => 'لیستها',
	'Network' => 'شبکه',
	'Geometry' => 'هندسه',
	'Relations' => 'رابطه ها',

	// Editor - data values
	'now' => 'اکنون',
	'yes' => 'بله',
	'no' => 'خیر',

	// Settings
	'Settings' => 'تنظیمات', // by Claude Fable 5.1
	'Default' => 'پیش فرض', // by Claude Fable 5.1
	'Color scheme' => 'طرح رنگ', // by Claude Fable 5.1
	'By system' => 'بر اساس سیستم', // by Claude Fable 5.1
	'Light' => 'روشن', // by Claude Fable 5.1
	'Dark' => 'تیره', // by Claude Fable 5.1
	'Navigation mode' => 'حالت پیمایش', // by Claude Fable 5.1
	'Simple' => 'ساده', // by Claude Fable 5.1
	'Dual' => 'دوگانه', // by Claude Fable 5.1
	'Dual on hover' => 'دوگانه هنگام اشاره', // by Claude Fable 5.1
	'Reversed' => 'معکوس', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'چیدمان پیمایش اصلی به همراه لینکهای جدول.', // by Claude Fable 5.1
	'Table links' => 'لینکهای جدول', // by Claude Fable 5.1
	'Primary action for all table links.' => 'عملیات اصلی برای همه لینکهای جدول.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'لینک به جدولهایی که به سطر جاری ارجاع می دهند.', // by Claude Fable 5.1
	'Display' => 'نمایش', // by Claude Fable 5.1
	'Hide' => 'پنهان کردن', // by Claude Fable 5.1
	'Records per page' => 'رکورد در هر صفحه', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'تعداد پیش فرض رکوردهای نمایش داده شده در جدول داده.', // by Claude Fable 5.1
	'Enum as select' => 'Enum به صورت لیست انتخاب', // by Claude Fable 5.1
	'Never' => 'هرگز', // by Claude Fable 5.1
	'Always' => 'همیشه', // by Claude Fable 5.1
	'More values than %d' => 'بیش از %d مقدار', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'آستانه نمایش لیست انتخاب برای ستونهای enum.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'کلمه عبور یکبار مصرف', // by Claude Fable 5.1
	'Enter OTP code.' => 'کد OTP را وارد کنید.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'کد OTP نامعتبر است.', // by Claude Fable 5.1
	'Access denied.' => 'دسترسی رد شد.', // by Claude Fable 5.1
	'JSON previews' => 'پیش نمایش JSON', // by Claude Fable 5.1
	'Data table' => 'جدول داده', // by Claude Fable 5.1
	'Edit form' => 'فرم ویرایش', // by Claude Fable 5.1
	'Ask %s' => 'از %s بپرسید', // by Claude Fable 5.1
];
