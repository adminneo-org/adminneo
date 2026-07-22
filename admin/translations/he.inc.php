<?php

namespace AdminNeo;

return [
	'ltr' => 'rtl', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s חייב להחזיר מערך', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s ו-%s חייבים להחזיר אובייקט שנוצר על ידי המתודה %s', // by Claude Opus 5

	// Login
	'System' => 'מערכת',
	'Server' => 'שרת',
	'Username' => 'שם משתמש',
	'Password' => 'סיסמה',
	'Permanent login' => 'התחבר לצמיתות',
	'Login' => 'התחברות',
	'Logout' => 'התנתק',
	'Logged as: %s' => 'מחובר כ: %s',
	'Logout successful.' => 'ההתנתקות הצליחה', // by Claude Opus 5
	'hostname[:port] or :socket' => 'שם שרת[:פורט] או :סוקט', // by Claude Opus 5
	'Invalid server or credentials.' => 'שרת או פרטי התחברות שגויים', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'יש רווח בסיסמה שהוזנה, ייתכן שזו הסיבה', // by Claude Opus 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo אינו תומך בגישה למסד נתונים ללא סיסמה, <a href="https://www.adminneo.org/password"%s>מידע נוסף</a>', // by Claude Opus 5
	'Database does not support password.' => 'מסד הנתונים אינו תומך בסיסמה', // by Claude Opus 5
	'Too many unsuccessful logins, try again in %d minute(s).' => 'יותר מידי נסיונות כניסה נכשלו, אנא נסה עוד %d דקות',
	'Invalid permanent login, please login again.' => 'התחברות לצמיתות שגויה, אנא התחבר שוב', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'כשל באבטחת נתונים, שלח טופס שוב',
	'If you did not send this request from AdminNeo then close this page.' => 'אם לא אתה שלחת בקשה ל-AdminNeo הינך יכול לסגור חלון זה',
	'The action will be performed after successful login with the same credentials.' => 'הפעולה תתבצע לאחר התחברות מוצלחת עם אותם פרטי התחברות', // by Claude Opus 5

	// Connection
	'No extension' => 'אין תוסף',
	'None of the supported PHP extensions (%s) are available.' => 'שום תוסף PHP (%s) זמין', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'התחברות לפורטים מוגנים אינה מותרת', // by Claude Opus 5
	'Session support must be enabled.' => 'חובה להפעיל תמיכה בסשן',
	'Session expired, please login again.' => 'תם זמן ההפעלה, אנא התחבר שוב',
	'%s version: %s through PHP extension %s' => '%s גרסה: %s דרך תוסף PHP %s',

	// Settings
	'Language' => 'שפה',

	'Home' => 'דף הבית', // by Claude Opus 5
	'Refresh' => 'רענן',
	'Info' => 'מידע', // by Claude Opus 5
	'More information.' => 'מידע נוסף', // by Claude Opus 5

	// Privileges
	'Privileges' => 'פריווילגיות',
	'Create user' => 'צור משתמש',
	'User has been dropped.' => 'המשתמש הושלך',
	'User has been altered.' => 'המשתמש שונה',
	'User has been created.' => 'המשתמש נוצר',
	'Hashed' => 'הצפנה',

	// Server
	'Process list' => 'רשימת תהליכים',
	'%d process(es) have been killed.' => '%d תהליכים חוסלו',
	'Kill' => 'חסל',
	'Variables' => 'משתנים',
	'Status' => 'סטטוס',

	// Structure
	'Column' => 'עמודה',
	'Columns' => 'עמודות', // by Claude Opus 5
	'Routine' => 'רוטינה',
	'Grant' => 'הענק',
	'Revoke' => 'שלול',

	// Queries
	'SQL command' => 'שאילתת SQL',
	'HTTP request' => 'בקשת HTTP', // by Claude Opus 5
	'%d query(s) executed OK.' => '%d שאילתות בוצעו בהצלחה',
	'Query executed OK, %d row(s) affected.' => 'השאילתה בוצעה כהלכה, %d שורות הושפעו',
	'No commands to execute.' => 'לא נמצאו פקודות להרצה',
	'Error in query' => 'שגיאה בשאילתה',
	'Unknown error.' => 'שגיאה לא ידועה', // by Claude Opus 5
	'Warnings' => 'אזהרות', // by Claude Opus 5
	'%s queries are not supported.' => 'שאילתת %s אינה נתמכת',
	'Execute' => 'הרץ',
	'Stop on error' => 'עצור בעת שגיאה',
	'Show only errors' => 'הראה שגיאות בלבד',
	'Time' => 'זמן',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'היסטוריה',
	'Clear' => 'נקה',
	'Edit all' => 'ערוך הכל',

	// Import
	'Import' => 'יבא',
	'File upload' => 'העלה קובץ',
	'From server' => 'משרת',
	'Webserver file %s' => 'קובץ השרת %s',
	'Run file' => 'הרץ קובץ',
	'File does not exist.' => 'הקובץ אינו קיים',
	'File uploads are disabled.' => 'העלאת קבצים מבוטלת',
	'Unable to upload a file.' => 'העלאת הקובץ נכשלה',
	'Maximum allowed file size is %sB.' => 'גודל מקסימלאי להעלאה: %sB',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'מספר הקבצים המקסימלי הוא %d. בחר פחות קבצים או הגדל את הגדרות ה-%s', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'הגודל הכולל המקסימלי של הקבצים הוא %s. בחר קבצים קטנים יותר או הגדל את הגדרות ה-%s', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'מידע גדול מידי נשלח ב-POST. הקטן את את המידע הוא הגדלת את הגדרות ה-%s',
	'You can upload a big SQL file via FTP and import it from server.' => 'ניתן לעלות קבצים ב-FTP ואז למשוך אותם מהשרת',
	'File must be in UTF-8 encoding.' => 'על הקובץ להיות בקידוד utf-8',
	'You are offline.' => 'הינך לא מקוון',
	'%d row(s) have been imported.' => '%d שורות יובאו',

	// Export
	'Export' => 'יצא',
	'Output' => 'פלט',
	'open' => 'פתח',
	'save' => 'שמור',
	'Format' => 'פורמט',
	'Data' => 'נתונים',

	// Databases
	'Database' => 'מסד נתונים',
	'database' => 'מסד נתונים', // by Claude Opus 5
	'DB' => 'מסד', // by Claude Opus 5
	'Use' => 'השתמש',
	'Invalid database.' => 'מסד נתונים שגוי',
	'Alter database' => 'שנה מסד נתונים',
	'Create database' => 'צור מסד נתונים',
	'Database schema' => 'סכמת מסד נתונים',
	'Permanent link' => 'קישור סופי',
	'Database has been dropped.' => 'מסד הנתונים הושלך',
	'Databases have been dropped.' => 'מסד הנתונים הושלך',
	'Database has been created.' => 'מסד הנתונים נוצר',
	'Database has been renamed.' => 'שם מסד הנתונים שונה',
	'Database has been altered.' => 'מסד הנתונים שונה',

	// SQLite errors
	'File exists.' => 'קובץ קיים',
	'Please use one of the extensions %s.' => 'בבקשה השתמש באחד מהתוספים %s',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'סכמה',
	'schema' => 'סכמה', // by Claude Opus 5
	'Schemas' => 'סכמות', // by Claude Opus 5
	'No schemas.' => 'אין סכמות', // by Claude Opus 5
	'Show schema' => 'הראה סכמה', // by Claude Opus 5
	'Alter schema' => 'שנה סכמה',
	'Create schema' => 'צור סכמה',
	'Schema has been dropped.' => 'הסכמה הושלכה',
	'Schema has been created.' => 'הסכמה נוצרה',
	'Schema has been altered.' => 'הסכמה שונתה',
	'Invalid schema.' => 'סכמה שגויה',

	// Table list
	'Engine' => 'מנוע',
	'engine' => 'מנוע',
	'Collation' => 'קולקציה',
	'collation' => 'קולקציה',
	'Data Length' => 'אורך נתונים',
	'Index Length' => 'אורך אינדקס',
	'Data Free' => 'נתונים משוחררים',
	'Rows' => 'שורות',
	'%d in total' => '%d בסך הכל',
	'Analyze' => 'נתח',
	'Optimize' => 'יעל',
	'Vacuum' => 'וואקום',
	'Check' => 'בדוק',
	'Repair' => 'תקן',
	'Truncate' => 'קצר',
	'Tables have been truncated.' => 'הטבלה קוצרה',
	'Move to other database' => 'העבר למסד נתונים אחר',
	'Move' => 'העבר',
	'Tables have been moved.' => 'הטבלה הועברה',
	'Copy' => 'העתק',
	'Tables have been copied.' => 'הטבלה הועתקה',
	'overwrite' => 'שכתב', // by Claude Opus 5

	// Tables
	'Tables' => 'טבלאות',
	'Tables and views' => 'טבלאות ותצוגות',
	'Table' => 'טבלה',
	'No tables.' => 'אין טבלאות',
	'Alter table' => 'שנה טבלה',
	'Create table' => 'צור טבלה',
	'Table has been dropped.' => 'הטבלה הושלכה',
	'Tables have been dropped.' => 'הטבלה הושלכה',
	'Tables have been optimized.' => 'הטבלאות עברו אופטימיזציה',
	'Table has been altered.' => 'הטבלה שונתה',
	'Table has been created.' => 'הטבלה נוצרה',
	'Table name' => 'שם הטבלה',
	'Name' => 'שם',
	'Show structure' => 'הראה מבנה',
	'Column name' => 'שם עמודה',
	'Type' => 'סוג',
	'Length' => 'אורך',
	'Auto Increment' => 'הגדלה אוטומטית',
	'Options' => 'אפשרויות',
	'Comment' => 'הערה',
	'Default value' => 'ערך ברירת מחדל',
	'Drop' => 'השלך',
	'Drop %s?' => 'להשליך את %s?', // by Claude Opus 5
	'Are you sure?' => 'האם אתה בטוח?',
	'Size' => 'גודל',
	'Compute' => 'חישוב',
	'Move up' => 'הזז למעלה',
	'Move down' => 'הזז למטה',
	'Remove' => 'הסר',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'הגעת למספר השדות המרבי. בבקשה הגדל את %s',

	// Views
	'View' => 'הצג',
	'Materialized view' => 'תצוגת מימוש', // by Claude Opus 5
	'View has been dropped.' => 'התצוגה הושלכה',
	'View has been altered.' => 'התצוגה שונתה',
	'View has been created.' => 'התצוגה נוצרה',
	'Alter view' => 'שנה תצוגה',
	'Create view' => 'צור תצוגה',

	// Partitions
	'Partition by' => 'מחיצות ע"י',
	'Partition' => 'מחיצה', // by Claude Opus 5
	'Partitions' => 'מחיצות',
	'Partition name' => 'שם מחיצה',
	'Values' => 'ערכים',
	'Inherited tables' => 'טבלאות יורשות', // by Claude Opus 5
	'Inherited from' => 'יורשת מ', // by Claude Opus 5

	// Indexes
	'Indexes' => 'אינדקסים',
	'Indexes have been altered.' => 'האינדקסים שונו',
	'Alter indexes' => 'שנה אינדקסים',
	'Add next' => 'הוסף הבא',
	'Index Type' => 'סוג אינדקס',
	'length' => 'אורך',
	'operator class' => 'מחלקת אופרטורים', // by Claude Opus 5
	'Algorithm' => 'אלגוריתם', // by Claude Opus 5
	'Condition' => 'תנאי', // by Claude Opus 5

	// Foreign keys
	'Foreign keys' => 'מפתחות זרים',
	'Foreign key' => 'מפתח זר',
	'Foreign key has been dropped.' => 'המפתח הזר הושלך',
	'Foreign key has been altered.' => 'המפתח הזר שונה',
	'Foreign key has been created.' => 'המפתח הזר נוצר',
	'Target table' => 'טבלת יעד',
	'Change' => 'שנה',
	'Source' => 'מקור',
	'Target' => 'יעד',
	'Add column' => 'הוסף עמודה',
	'Alter' => 'שנה',
	'Add foreign key' => 'הוסף מפתח זר',
	'ON DELETE' => 'בעת מחיקה',
	'ON UPDATE' => 'בעת עידכון',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'על עמודות המקור והיעד להיות מאותו טיפוס נתונים, חובה שיהיה אינדקס בעמודת היעד ושהמידע המתאים יהיה קיים',

	// Routines
	'Routines' => 'רוטינות',
	'Routine has been called, %d row(s) affected.' => 'הרוטינה נקראה, %d שורות הושפעו',
	'Call' => 'קרא',
	'Parameter name' => 'שם הפרמטר',
	'Create procedure' => 'צור פרוצדורה',
	'Create function' => 'צור פונקציה',
	'Routine has been dropped.' => 'הרוטינה הושלכה',
	'Routine has been altered.' => 'הרוטינה שונתה',
	'Routine has been created.' => 'הרוטינה נוצרה',
	'Alter function' => 'שנה פונקציה',
	'Alter procedure' => 'שנה פרוצדורה',
	'Return type' => 'סוג ערך מוחזר',

	// Events
	'Events' => 'אירועים',
	'Event' => 'אירוע',
	'Event has been dropped.' => 'האירוע הושלך',
	'Event has been altered.' => 'האירוע שונה',
	'Event has been created.' => 'האירוע נוצר',
	'Alter event' => 'שנה אירוע',
	'Create event' => 'צור אירוע',
	'At given time' => 'לפי זמן נתון',
	'Every' => 'כל',
	'Schedule' => 'תזמן',
	'Start' => 'התחלה',
	'End' => 'סיום',
	'On completion preserve' => 'בעת סיום שמור',

	// Sequences (PostgreSQL)
	'Sequences' => 'סדרות',
	'Create sequence' => 'צור סדרה',
	'Sequence has been dropped.' => 'הסדרה הושלכה',
	'Sequence has been created.' => 'הסדרה נוצרה',
	'Sequence has been altered.' => 'הסדרה שונתה',
	'Alter sequence' => 'שנה סדרה',

	// User-defined types (PostgreSQL)
	'User types' => 'טיפוסים מוגדרי משתמש', // by Claude Fable 5
	'Create type' => 'צור סוג',
	'Type has been dropped.' => 'הסוג הושלך',
	'Type has been created.' => 'הסוג נוצר',
	'Alter type' => 'שנה סוג',

	// Triggers
	'Triggers' => 'מפעילים',
	'Add trigger' => 'הוסף טריגר',
	'Trigger has been dropped.' => 'הטריגר הושלך',
	'Trigger has been altered.' => 'הטריגר שונה',
	'Trigger has been created.' => 'הטריגר נוצר',
	'Alter trigger' => 'שנה טריגר',
	'Create trigger' => 'צור טריגר',

	// Table check constraints
	'Checks' => 'בדיקות', // by Claude Opus 5
	'Create check' => 'צור בדיקה', // by Claude Opus 5
	'Alter check' => 'שנה בדיקה', // by Claude Opus 5
	'Check has been created.' => 'הבדיקה נוצרה', // by Claude Opus 5
	'Check has been altered.' => 'הבדיקה שונתה', // by Claude Opus 5
	'Check has been dropped.' => 'הבדיקה הושלכה', // by Claude Opus 5

	// Selection
	'Select data' => 'בחר נתונים',
	'Select' => 'בחר',
	'Functions' => 'פונקציות',
	'Aggregation' => 'צבירה',
	'Search' => 'חפש',
	'anywhere' => 'בכל מקום',
	'Sort' => 'מיין',
	'descending' => 'סדר הפוך',
	'Limit' => 'הגבל',
	'Limit rows' => 'הגבל שורות',
	'Text length' => 'אורך הטקסט',
	'Action' => 'פעולות',
	'Full table scan' => 'סריקה טבלה מלאה',
	'Unable to select the table' => 'בחירת הטבלה נכשלה',
	'Search data in tables' => 'חפש מידע בטבלאות',
	'No rows.' => 'אין שורות',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d שורות',
	'Page' => 'עמוד',
	'last' => 'אחרון',
	'Load more data' => 'טען נתונים נוספים',
	'Loading' => 'טוען',
	'Whole result' => 'כל התוצאות',
	'%d byte(s)' => '%d בתים',

	// In-place editing in selection
	'Modify' => 'ערוך',
	'Ctrl+click on a value to modify it.' => 'לחץ ctrl + לחיצת עכבר לערוך ערך זה',
	'Use edit link to modify this value.' => 'השתמש בקישור העריכה בשביל לשנות את הערך',

	// Editing
	'New item' => 'פריט חדש',
	'Edit' => 'ערוך',
	'original' => 'מקורי',
	'empty' => 'ריק', // label for value '' in enum data type
	'Insert' => 'הכנס',
	'Save' => 'שמור',
	'Save and continue edit' => 'שמור והמשך לערוך',
	'Save and insert next' => 'שמור והמשך להכניס',
	'Saving' => 'שומר',
	'Selected' => 'נבחרים',
	'Clone' => 'שכפל',
	'Delete' => 'מחק',
	'Item%s has been inserted.' => 'הפריט %s הוזן בהצלחה', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'הפריט נמחק',
	'Item has been updated.' => 'הפריט עודכן',
	'%d item(s) have been affected.' => '%d פריטים הושפעו',
	'You have no privileges to update this table.' => 'אין לך ההרשאות המתאימות לעדכן טבלה זו',

	// Data type descriptions
	'Numbers' => 'מספרים',
	'Date and time' => 'תאריך ושעה',
	'Strings' => 'מחרוזות',
	'Binary' => 'בינארי',
	'Lists' => 'רשימות',
	'Network' => 'רשת',
	'Geometry' => 'גיאומטריה',
	'Relations' => 'הקשרים',

	// Editor - data values
	'now' => 'כעת',
	'yes' => 'כן',
	'no' => 'לא',

	// Settings
	'Settings' => 'הגדרות', // by Claude Opus 5
	'Default' => 'ברירת מחדל', // by Claude Opus 5
	'Color scheme' => 'ערכת צבעים', // by Claude Opus 5
	'By system' => 'לפי המערכת', // by Claude Opus 5
	'Light' => 'בהיר', // by Claude Opus 5
	'Dark' => 'כהה', // by Claude Opus 5
	'Navigation mode' => 'מצב ניווט', // by Claude Opus 5
	'Simple' => 'פשוט', // by Claude Opus 5
	'Dual' => 'כפול', // by Claude Opus 5
	'Reversed' => 'הפוך', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'פריסת הניווט הראשי עם קישורי הטבלאות', // by Claude Opus 5
	'Table links' => 'קישורי הטבלאות', // by Claude Opus 5
	'Primary action for all table links.' => 'הפעולה הראשית לכל קישורי הטבלאות', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'קישורים לטבלאות המפנות לשורה הנוכחית', // by Claude Opus 5
	'Display' => 'הצג', // by Claude Opus 5
	'Hide' => 'הסתר', // by Claude Opus 5
	'Records per page' => 'רשומות בעמוד', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'מספר הרשומות המוצגות כברירת מחדל בטבלת הנתונים', // by Claude Opus 5
	'Enum as select' => 'Enum כרשימת בחירה', // by Claude Opus 5
	'Never' => 'לעולם לא', // by Claude Opus 5
	'Always' => 'תמיד', // by Claude Opus 5
	'More values than %d' => 'יותר מ-%d ערכים', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'הסף להצגת רשימת בחירה עבור עמודות enum', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'סיסמה חד פעמית', // by Claude Opus 5
	'Enter OTP code.' => 'הזן את קוד ה-OTP', // by Claude Opus 5
	'Invalid OTP code.' => 'קוד OTP שגוי', // by Claude Opus 5
	'Access denied.' => 'הגישה נדחתה', // by Claude Opus 5
	'JSON previews' => 'תצוגות מקדימות של JSON', // by Claude Opus 5
	'Data table' => 'טבלת נתונים', // by Claude Opus 5
	'Edit form' => 'טופס עריכה', // by Claude Opus 5
	'Ask %s' => 'שאל את %s', // by Claude Opus 5
];
