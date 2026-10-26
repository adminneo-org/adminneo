<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'DD/MM/YYYY', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s ஒரு அணியை (array) திருப்பி அளிக்க வேண்டும்.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s மற்றும் %s, %s முறையால் உருவாக்கப்பட்ட ஒரு பொருளை (object) திருப்பி அளிக்க வேண்டும்.', // by Claude Fable 5.1

	// Accessibility
	'Skip to main content' => 'முதன்மை உள்ளடக்கத்திற்குச் செல்', // by Claude Fable 5.1
	'Skip to menu' => 'பட்டிக்குச் செல்', // by Claude Fable 5.1
	'Skip to table list' => 'அட்டவணைப் பட்டியலுக்குச் செல்', // by Claude Fable 5.1

	// Login
	'System' => 'சிஸ்டம் (System)',
	'Server' => 'வழங்கி (Server)',
	'Username' => 'பயனாளர் (User)',
	'Password' => 'கடவுச்சொல்',
	'Permanent login' => 'நிரந்தரமாக நுழையவும்',
	'Login' => 'நுழை',
	'Logout' => 'வெளியேறு',
	'Logged as: %s' => 'பயனாளர்: %s',
	'Logout successful.' => 'வெற்றிகரமாய் வெளியேறியாயிற்று.',
	'hostname[:port] or :socket' => 'வழங்கி பெயர்[:போர்ட்] அல்லது :சாக்கெட்', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'வழங்கி அல்லது நுழைவுத் தகவல் சரியானதல்ல.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'உள்ளிட்ட கடவுச்சொல்லில் ஒரு இடைவெளி உள்ளது, அதுவே காரணமாக இருக்கலாம்.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'கடவுச்சொல் இல்லாமல் தகவல்தளத்தை அணுகுவதை AdminNeo ஆதரிப்பதில்லை, <a href="https://www.adminneo.org/password"%s>மேலும் தகவல்</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'தகவல்தளம் கடவுச்சொல்லை ஆதரிப்பதில்லை.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'மிக அதிகமான தவறான நுழைவு முயற்சிகள். %d நிமிடத்தில் மீண்டும் முயற்சிக்கவும்.',
		'மிக அதிகமான தவறான நுழைவு முயற்சிகள். %d நிமிடங்களில் மீண்டும் முயற்சிக்கவும்.',
	], // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => 'நிரந்தர நுழைவு சரியானதல்ல. மீண்டும் நுழையவும்.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'CSRF டோக்கன் செல்லாது. படிவத்தை மீண்டும் அனுப்பவும்.',
	'If you did not send this request from AdminNeo then close this page.' => 'இந்த கோரிக்கையை நீங்கள் AdminNeo இலிருந்து அனுப்பவில்லை என்றால், இந்த பக்கத்தை மூடவும்.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'அதே நுழைவுத் தகவலுடன் வெற்றிகரமாக நுழைந்த பிறகு இந்த செயல் நடைபெறும்.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'விரிவு (extensஇஒன்) இல்லை ',
	'None of the supported PHP extensions (%s) are available.' => 'PHP ஆதரவு விரிவுகள் (%s) இல்லை.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'சிறப்புரிமை போர்ட்டுகளுக்கு இணைப்பது அனுமதிக்கப்படவில்லை.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'செஷன் ஆதரவு இயக்கப்பட வேண்டும்.',
	'Session expired, please login again.' => 'செஷன் காலாவதியாகி விட்டது. மீண்டும் நுழையவும்.',
	'%s version: %s through PHP extension %s' => '%s பதிப்பு: %s through PHP extension %s',
	'%s requires at least %s.' => '%s-க்கு குறைந்தது %s தேவை.', // e.g. 'AdminNeo requires at least Elasticsearch 7.' // by Claude Fable 5.1

	// Settings
	'Language' => 'மொழி',

	'Menu' => 'பட்டி', // by Claude Fable 5.1
	'Home' => 'முதற் பக்கம்', // by Claude Fable 5.1
	'Refresh' => 'புதுப்பி (Refresh)',
	'Info' => 'தகவல்', // by Claude Fable 5.1
	'More information.' => 'மேலும் தகவல்.', // by Claude Fable 5.1
	'Close' => 'மூடு', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'சலுகைகள் / சிறப்புரிமைகள்',
	'Create user' => 'பயனாளரை உருவாக்கு',
	'User has been dropped.' => 'பயனீட்டாளர் நீக்கப்பட்டார்.',
	'User has been altered.' => 'பயனீட்டாளர் மாற்றப்பட்டார்.',
	'User has been created.' => 'பயனீட்டாளர் உருவாக்கப்பட்டது.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'வேலைகளின் பட்டி',
	'%d process(es) have been killed.' => [
		'%d வேலை வலுவில் நிறுத்தபட்டது.',
		'%d வேலைகள் வலுவில் நிறுத்தபட்டன.',
	],
	'Kill' => 'வலுவில் நிறுத்து',
	'Variables' => 'மாறிலிகள் (Variables)',
	'Status' => 'நிகழ்நிலை (Status)',

	// Structure
	'Column' => 'நெடுவரிசை',
	'Columns' => 'நெடுவரிசைகள்', // by Claude Fable 5.1
	'Routine' => 'ரொட்டீன்',
	'Grant' => 'அனுமதியளி',
	'Revoke' => 'இரத்துச்செய்',

	// Queries
	'SQL command' => 'SQL கட்டளை',
	'HTTP request' => 'HTTP கோரிக்கை', // by Claude Fable 5.1
	'%d query(s) executed OK.' => [
		'%d வினவல் செயல்படுத்தப்பட்டது.',
		'%d வினவல்கள் செயல்படுத்தப்பட்டன.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'வினவல் செயல்படுத்தப்பட்டது, %d வரிசை மாற்றப்பட்டது.',
		'வினவல் செயல்படுத்தப்பட்டது, %d வரிசைகள் மாற்றப்பட்டன.',
	],
	'No commands to execute.' => 'செயல் படுத்த எந்த கட்டளைகளும் இல்லை.',
	'Error in query' => 'வினவலில் தவறுள்ளது',
	'Unknown error.' => 'தெரியாத பிழை.', // by Claude Fable 5.1
	'Warnings' => 'எச்சரிக்கைகள்', // by Claude Fable 5.1
	'%s queries are not supported.' => '%s வினவல்கள் ஆதரிக்கப்படவில்லை.', // by Claude Fable 5.1
	'Execute' => 'செயல்படுத்து',
	'Stop on error' => 'பிழை ஏற்படின் நிற்க',
	'Show only errors' => 'பிழைகளை மட்டும் காண்பிக்கவும்',
	'Time' => 'நேரம்',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'வரலாறு',
	'Clear' => 'துடை (Clear)',
	'Edit all' => 'அனைத்தையும் தொகு',

	// Import
	'Import' => 'இறக்குமதி (Import)',
	'File upload' => 'கோப்பை மேலேற்று (upload) ',
	'From server' => 'செர்வரில் இருந்து',
	'Webserver file %s' => 'வெப் சர்வர் கோப்பு %s',
	'Run file' => 'கோப்பினை இயக்கவும்',
	'File does not exist.' => 'கோப்பு இல்லை.',
	'File uploads are disabled.' => 'கோப்புகள் மேலேற்றம் (upload)முடக்கப்பட்டுள்ளன.',
	'Unable to upload a file.' => 'கோப்பை மேலேற்றம் (upload) செய்ய இயலவில்லை.',
	'Maximum allowed file size is %sB.' => 'கோப்பின் அதிகபட்ச அளவு %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'கோப்புகளின் அதிகபட்ச எண்ணிக்கை %d. குறைவான கோப்புகளை தேர்வு செய்யவும் அல்லது %s வடிவமைப்பை (configuration directive) அதிகரிக்கவும்.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'கோப்புகளின் அதிகபட்ச மொத்த அளவு %s. சிறிய கோப்புகளை தேர்வு செய்யவும் அல்லது %s வடிவமைப்பை (configuration directive) அதிகரிக்கவும்.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'மிக அதிகமான POST தகவல். தகவலை குறைக்கவும் அல்லது %s வடிவமைப்பை (configuration directive) மாற்றவும்.',
	'You can upload a big SQL file via FTP and import it from server.' => 'பெரிய SQL கோப்பை FTP வழியாக மேலேற்றி, சர்வரிலிருந்து இறக்குமதி செய்யலாம்.', // by Claude Fable 5.1
	'File must be in UTF-8 encoding.' => 'கோப்பு UTF-8 குறியாக்கத்தில் இருக்க வேண்டும்.', // by Claude Fable 5.1
	'You are offline.' => 'நீங்கள் இணையத்தில் இல்லை.', // by Claude Fable 5.1
	'%d row(s) have been imported.' => [
		'%d வரிசை இறக்குமதி (Import) செய்யப்பட்டது.',
		'%d வரிசைகள் இறக்குமதி (Import) செய்யப்பட்டன.',
	],

	// Export
	'Export' => 'ஏற்றுமதி',
	'Output' => 'வெளியீடு',
	'open' => 'திற',
	'save' => 'சேமி',
	'Format' => 'ஃபார்மட் (Format)',
	'Data' => 'தகவல்',
	'Copy as <span>%s</span>' => '<span>%s</span> வடிவில் நகலெடு', // by Claude Fable 5.1

	// Databases
	'Database' => 'தகவல்தளம்',
	'database' => 'தகவல்தளம்', // by Claude Fable 5.1
	'DB' => 'த.த', // by Claude Fable 5.1
	'Use' => 'உபயோகி',
	'Invalid database.' => 'தகவல்தளம் சரியானதல்ல.',
	'Alter database' => 'தகவல்தளத்தை மாற்று',
	'Create database' => 'தகவல்தளத்தை உருவாக்கு',
	'Database schema' => 'தகவல்தள அமைப்பு முறைகள்',
	'Permanent link' => 'நிரந்தர இணைப்பு',
	'Database has been dropped.' => 'தகவல்தளம் நீக்கப்பட்டது.',
	'Databases have been dropped.' => 'தகவல் தளங்கள் நீக்கப்பட்டன.',
	'Database has been created.' => 'தகவல்தளம் உருவாக்கப்பட்டது.',
	'Database has been renamed.' => 'தகவல்தளம் பெயர் மாற்றப்பட்டது.',
	'Database has been altered.' => 'தகவல்தளம் மாற்றப்பட்டது.',

	// SQLite errors
	'File exists.' => 'கோப்பு உள்ளது.',
	'Please use one of the extensions %s.' => 'தயவு செய்து ஒரு விரிவினை %s (extension) உபயோகிக்கவும்.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'அமைப்புமுறை',
	'schema' => 'அமைப்புமுறை', // by Claude Fable 5.1
	'Schemas' => 'அமைப்புமுறைகள்', // by Claude Fable 5.1
	'No schemas.' => 'அமைப்புமுறை இல்லை.', // by Claude Fable 5.1
	'Show schema' => 'அமைப்புமுறையை காண்பிக்கவும்', // by Claude Fable 5.1
	'Alter schema' => 'அமைப்புமுறையை மாற்று',
	'Create schema' => 'அமைப்புமுறையை உருவாக்கு',
	'Schema has been dropped.' => 'அமைப்புமுறை நீக்கப்பட்டது.',
	'Schema has been created.' => 'அமைப்புமுறை உருவாக்கப்பட்டது.',
	'Schema has been altered.' => 'அமைப்புமுறை மாற்றப்பட்டது.',
	'Invalid schema.' => 'அமைப்புமுறை சரியானதல்ல (Invalid Schema).',

	// Table list
	'All' => 'அனைத்தும்', // checkbox selecting all tables and views // by Claude Fable 5.1
	'Engine' => 'எஞ்சின் (Engine)',
	'engine' => 'எஞ்சின்',
	'Collation' => 'கொலேசன்',
	'collation' => 'கொலேசன்',
	'Data Length' => 'தகவல் நீளம்',
	'Index Length' => 'Index நீளம்',
	'Data Free' => 'Data Free',
	'Rows' => 'வரிசைகள்',
	'%d in total' => 'மொத்தம் %d ',
	'Analyze' => 'நுணுகி ஆராயவும்',
	'Optimize' => 'உகப்பாக்கு (Optimize)',
	'Vacuum' => 'சுத்தம் செய் (Vacuum)', // by Claude Fable 5.1
	'Check' => 'பரிசோதி',
	'Repair' => 'பழுது பார்',
	'Truncate' => 'குறை (Truncate)',
	'Tables have been truncated.' => 'அட்டவணை குறைக்கப்பட்டது (truncated).',
	'Move to other database' => 'மற்ற தகவல் தளத்திற்க்கு நகர்த்து',
	'Move' => 'நகர்த்து',
	'Tables have been moved.' => 'அட்டவணை நகர்த்தப்பட்டது.',
	'Copy' => 'நகல்',
	'Tables have been copied.' => 'அட்டவணைகள் நகலெடுக்கப் பட்டது.',
	'overwrite' => 'மேலெழுது', // by Claude Fable 5.1

	// Tables
	'Tables' => 'அட்டவணை',
	'Tables and views' => 'அட்டவணைகளும் பார்வைகளும்',
	'Table' => 'அட்டவணை',
	'No tables.' => 'அட்டவணை இல்லை.',
	'Alter table' => 'அட்டவணையை மாற்று',
	'Create table' => 'அட்டவணையை உருவாக்கு',
	'Table has been dropped.' => 'அட்டவணை நீக்கப்பட்டது.',
	'Tables have been dropped.' => 'அட்டவணை நீக்கப்பட்டது.',
	'Tables have been optimized.' => 'அட்டவணைகள் உகப்பாக்கப்பட்டன.', // by Claude Fable 5.1
	'Table has been altered.' => 'அட்டவணை மாற்றப்பட்டது.',
	'Table has been created.' => 'அட்டவணை உருவாக்கப்பட்டது.',
	'Table name' => 'அட்டவணைப் பெயர்',
	'Name' => 'பெயர்',
	'Show structure' => 'கட்டமைப்பை காண்பிக்கவும்',
	'Column name' => 'நெடுவரிசையின் பெயர்',
	'Type' => 'வகை',
	'Length' => 'நீளம்',
	'Auto Increment' => 'ஏறுமானம்',
	'Options' => 'வேண்டியவற்றை ',
	'Comment' => 'குறிப்பு',
	'Default value' => 'இயல்பு மதிப்பு', // by Claude Fable 5.1
	'default value' => 'இயல்பு மதிப்பு', // by Claude Opus 5.5
	'Drop' => 'நீக்கு',
	'Drop %s?' => '%s நீக்கவா?', // by Claude Fable 5.1
	'Are you sure?' => 'நிச்சயமாக ?',
	'Size' => 'அளவு', // by Claude Fable 5.1
	'Compute' => 'கணி', // by Claude Fable 5.1
	'Move up' => 'மேலே நகர்த்து',
	'Move down' => 'கீழே நகர்த்து',
	'Remove' => 'நீக்கு',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'அனுமதிக்கப்பட்ட அதிகபட்ச புலங்களின் எண்ணிக்கை மீறப்பட்டது. தயவு செய்து %s யை அதிகரிக்கவும்.', // by Claude Fable 5.1

	// Views
	'View' => 'தோற்றம்',
	'Materialized view' => 'சேமிக்கப்பட்ட தோற்றம் (Materialized view)', // by Claude Fable 5.1
	'View has been dropped.' => 'தோற்றம் நீக்கப்பட்டது.',
	'View has been altered.' => 'தோற்றம் மாற்றப்பட்டது.',
	'View has been created.' => 'தோற்றம் உருவாக்கப்பட்டது.',
	'Alter view' => 'தோற்றத்தை மாற்று',
	'Create view' => 'தோற்றத்தை உருவாக்கு',

	// Partitions
	'Partition by' => 'பிரித்தது',
	'Partition' => 'பிரிவு', // by Claude Fable 5.1
	'Partitions' => 'பிரிவுகள்',
	'Partition name' => 'பிரிவின் பெயர்',
	'Values' => 'மதிப்புகள்',
	'Inherited tables' => 'மரபு வழி அட்டவணைகள்', // by Claude Fable 5.1
	'Inherited from' => 'மரபு வழி வந்தது', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'அகவரிசைகள் (Index) ',
	'Indexes have been altered.' => 'அகவரிசைகள் (Indexes) மாற்றப்பட்டது.',
	'Alter indexes' => 'அகவரிசையை (Index) மாற்று',
	'Add next' => 'அடுத்ததை சேர்க்கவும்',
	'Index Type' => 'அகவரிசை வகை (Index Type)',
	'length' => 'நீளம்',
	'operator class' => 'செயற்குறி வகுப்பு', // by Claude Fable 5.1
	'Algorithm' => 'நெறிமுறை (Algorithm)', // by Claude Fable 5.1
	'Condition' => 'நிபந்தனை', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'வேற்று விசைகள்',
	'Foreign key has been dropped.' => 'வேற்று விசை நீக்கப்பட்டது.',
	'Foreign key has been altered.' => 'வேற்று விசை மாற்றப்பட்டது.',
	'Foreign key has been created.' => 'வேற்று விசை உருவாக்கப்பட்டது.',
	'Target table' => 'அட்டவணை இலக்கு',
	'Change' => 'மாற்று',
	'Source' => 'மூலம்',
	'Target' => 'இலக்கு',
	'Add column' => 'நெடு வரிசையை சேர்க்கவும்',
	'Alter' => 'மாற்று',
	'Alter foreign key' => 'வேற்று விசையை மாற்று', // by Claude Fable 5.1
	'Create foreign key' => 'வேற்று விசையை உருவாக்கு', // by Claude Fable 5.1
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'இலக்கு நெடுவரிசையில் அகவரிசை (Index) மற்றும் குறிக்கப்பட்ட தகவல் (Referenced DATA) கண்டிப்பாக இருத்தல் வேண்டும். மூல நெடுவரிசை மற்றும் இலக்கு நெடுவரிசையின் தகவல் வடிவம் (DATA TYPE) ஒன்றாக இருக்க வேண்டும்.',

	// Routines
	'Routines' => 'ரொட்டீன் ',
	'Routine has been called, %d row(s) affected.' => [
		'ரொட்டீன்கள் அழைக்கப்பட்டுள்ளன, %d வரிசை மாற்றம் அடைந்தது.',
		'ரொட்டீன்கள் அழைக்கப்பட்டுள்ளன, %d வரிசைகள் மாற்றம் அடைந்துள்ளன.',
	],
	'Call' => 'அழை',
	'Parameter name' => 'அளபுரு (Parameter) பெயர்',
	'Create procedure' => 'செய்முறையை உருவாக்கு',
	'Create function' => 'Function உருவாக்கு',
	'Routine has been dropped.' => 'ரொட்டீன் நீக்கப்பட்டது.',
	'Routine has been altered.' => 'ரொட்டீன் மாற்றப்பட்டது.',
	'Routine has been created.' => 'ரொட்டீன் உருவாக்கப்பட்டது.',
	'Alter function' => 'Function மாற்று',
	'Alter procedure' => 'செயல்முறையை மாற்று',
	'Return type' => 'திரும்பு வகை',

	// Events
	'Events' => 'நிகழ்ச்சிகள்',
	'Event' => 'நிகழ்ச்சி',
	'Event has been dropped.' => 'நிகழ்ச்சி (Event) நீக்கப்பட்டது.',
	'Event has been altered.' => 'நிகழ்ச்சி (Event) மாற்றப்பட்டது.',
	'Event has been created.' => 'நிகழ்ச்சி (Event) உருவாக்கப்பட்டது.',
	'Alter event' => 'நிகழ்ச்சியை (Event) மாற்று',
	'Create event' => 'நிகழ்ச்சியை (Event) உருவாக்கு',
	'At given time' => 'குறித்த நேரத்தில்',
	'Every' => 'ஒவ்வொரு',
	'Schedule' => 'கால அட்டவணை',
	'Start' => 'தொடங்கு',
	'End' => 'முடி (வு)',
	'On completion preserve' => 'முடிந்ததின் பின் பாதுகாக்கவும்',

	// Sequences (PostgreSQL)
	'Sequences' => 'வரிசைமுறை',
	'Create sequence' => 'வரிசைமுறையை உருவாக்கு',
	'Sequence has been dropped.' => 'வரிசைமுறை நீக்கப்பட்டது.',
	'Sequence has been created.' => 'வரிசைமுறை உருவாக்கப்பட்டது.',
	'Sequence has been altered.' => 'வரிசைமுறை மாற்றப்பட்டது.',
	'Alter sequence' => 'வரிசைமுறையை மாற்று',

	// User-defined types (PostgreSQL)
	'User types' => 'பயனாளர் வகைகள்',
	'Create type' => 'வகையை உருவாக்கு',
	'Type has been dropped.' => 'வகை (type) நீக்கப்பட்டது.',
	'Type has been created.' => 'வகை (type) உருவாக்கப்பட்டது.',
	'Type has been altered.' => 'வகை (type) மாற்றப்பட்டது.', // by Claude Opus 5.5
	'Alter type' => 'வகையினை (type) மாற்று',

	// Triggers
	'Triggers' => 'தூண்டுதல்கள்',
	'Trigger has been dropped.' => 'தூண்டு விசை நீக்கப்பட்டது.',
	'Trigger has been altered.' => 'தூண்டு விசை மாற்றப்பட்டது.',
	'Trigger has been created.' => 'தூண்டு விசை உருவாக்கப்பட்டது.',
	'Alter trigger' => 'தூண்டு விசையை மாற்று',
	'Create trigger' => 'தூண்டு விசையை உருவாக்கு',

	// Table check constraints
	'Checks' => 'பரிசோதனைகள்', // by Claude Fable 5.1
	'Create check' => 'பரிசோதனையை உருவாக்கு', // by Claude Fable 5.1
	'Alter check' => 'பரிசோதனையை மாற்று', // by Claude Fable 5.1
	'Check has been created.' => 'பரிசோதனை உருவாக்கப்பட்டது.', // by Claude Fable 5.1
	'Check has been altered.' => 'பரிசோதனை மாற்றப்பட்டது.', // by Claude Fable 5.1
	'Check has been dropped.' => 'பரிசோதனை நீக்கப்பட்டது.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'தகவலை தேர்வு செய்',
	'Select' => 'தேர்வு செய்',
	'Functions' => 'Functions',
	'Aggregation' => 'திரள்வு (Aggregation)',
	'Search' => 'தேடு',
	'anywhere' => 'எங்காயினும்',
	'Sort' => 'தரம் பிரி',
	'descending' => 'இறங்குமுகமான',
	'Limit' => 'வரம்பு',
	'Limit rows' => 'வரிசைகளை வரம்பிடு', // by Claude Fable 5.1
	'Text length' => 'உரை நீளம்',
	'Action' => 'செயல்',
	'Full table scan' => 'முழு அட்டவணை வருடல்', // by Claude Fable 5.1
	'Unable to select the table' => 'அட்டவணையை தேர்வு செய்ய முடியவில்லை',
	'Search data in tables' => 'தகவலை அட்டவணையில் தேடு',
	'All rows on this page' => 'இந்தப் பக்கத்தின் அனைத்து வரிசைகளும்', // by Claude Fable 5.1
	'No rows.' => 'வரிசை இல்லை.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => [
		'%d வரிசை',
		'%d வரிசைகள்',
	],
	'Page' => 'பக்கம்',
	'last' => 'கடைசி',
	'Load more data' => 'மேலும் தகவலை ஏற்று', // by Claude Fable 5.1
	'Loading…' => 'ஏற்றப்படுகிறது…', // by Claude Fable 5.1
	'Whole result' => 'முழுமையான முடிவு',
	'%d byte(s)' => [
		'%d பைட்',
		'%d பைட்டுகள்',
	],

	// In-place editing in selection
	'Modify' => 'மாற்று', // by Claude Fable 5.1
	'Ctrl+click on a value to modify it.' => 'மதிப்பை மாற்ற, அதன் மேல் Ctrl+சொடுக்கவும்.', // by Claude Fable 5.1
	'Use edit link to modify this value.' => 'இந்த மதிப்பினை மாற்ற, தொகுப்பு இணைப்பினை உபயோகிக்கவும்.',

	// Editing
	'New item' => 'புதிய உருப்படி',
	'Edit' => 'தொகு',
	'original' => 'அசல்',
	'empty' => 'வெறுமை (empty)', // label for value '' in enum data type
	'Insert' => 'புகுத்து',
	'Save' => 'சேமி',
	'Save and continue edit' => 'சேமித்த பிறகு தொகுப்பதை தொடரவும்',
	'Save and insert next' => 'சேமித்தப் பின் அடுத்ததை புகுத்து',
	'Saving…' => 'சேமிக்கப்படுகிறது…', // by Claude Fable 5.1
	'Selected' => 'தேர்வு செய்யப்பட்டவை', // by Claude Fable 5.1
	'Clone' => 'நகலி (Clone)',
	'Delete' => 'நீக்கு',
	'Item%s has been inserted.' => 'உருப்படி (Item%s) சேர்க்கப்பட்டது.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'உருப்படி நீக்கப்பட்டது.',
	'Item has been updated.' => 'உருப்படி புதுப்பிக்கப்பட்டது.',
	'%d item(s) have been affected.' => [
		'%d உருப்படி மாற்றமடைந்தது.',
		'%d உருப்படிகள் மாற்றமடைந்தன.',
	],
	'You have no privileges to update this table.' => 'இந்த அட்டவணையை புதுப்பிக்க உங்களுக்கு உரிமை இல்லை.', // by Claude Fable 5.1

	// Data type descriptions
	'Numbers' => 'எண்கள்',
	'Date and time' => 'தேதி மற்றும் நேரம்',
	'Strings' => 'சரம் (String)',
	'Binary' => 'பைனரி',
	'Lists' => 'பட்டியல்',
	'Network' => 'நெட்வொர்க்',
	'Geometry' => 'வடிவவியல் (Geometry)',
	'Ranges' => 'வரம்புகள் (Ranges)', // by Claude Fable 5.1
	'Relations' => 'உறவுகள் (Relations)',

	// Editor - data values
	'now' => 'இப்பொழுது',
	'yes' => 'ஆம்', // by Claude Fable 5.1
	'no' => 'இல்லை', // by Claude Fable 5.1

	// Settings
	'Settings' => 'அமைப்புகள்', // by Claude Fable 5.1
	'Default' => 'இயல்பு', // by Claude Fable 5.1
	'Theme' => 'தீம்', // by Claude Fable 5.1
	'Color scheme' => 'வண்ண அமைப்பு', // by Claude Fable 5.1
	'By system' => 'சிஸ்டம் படி', // by Claude Fable 5.1
	'Light' => 'வெளிர்', // by Claude Fable 5.1
	'Dark' => 'இருண்ட', // by Claude Fable 5.1
	'Navigation mode' => 'வழிசெலுத்தல் முறை', // by Claude Fable 5.1
	'Simple' => 'எளிமையான', // by Claude Fable 5.1
	'Dual' => 'இரட்டை', // by Claude Fable 5.1
	'Dual on hover' => 'சுட்டி மேல் வரும்போது இரட்டை', // by Claude Fable 5.1
	'Reversed' => 'தலைகீழ்', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'அட்டவணை இணைப்புகளுடன் கூடிய முதன்மை வழிசெலுத்தலின் அமைப்பு.', // by Claude Fable 5.1
	'Table links' => 'அட்டவணை இணைப்புகள்', // by Claude Fable 5.1
	'Primary action for all table links.' => 'அனைத்து அட்டவணை இணைப்புகளுக்குமான முதன்மை செயல்.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'தற்போதைய வரிசையை குறிப்பிடும் அட்டவணைகளுக்கான இணைப்புகள்.', // by Claude Fable 5.1
	'Display' => 'காண்பி', // by Claude Fable 5.1
	'Hide' => 'மறை', // by Claude Fable 5.1
	'Records per page' => 'ஒரு பக்கத்திற்கான பதிவுகள்', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'தகவல் அட்டவணையில் காண்பிக்கப்படும் பதிவுகளின் இயல்பு எண்ணிக்கை.', // by Claude Fable 5.1
	'Enum as select' => 'Enum ஐ தேர்வுப் பட்டியாக', // by Claude Fable 5.1
	'Never' => 'ஒருபோதும் இல்லை', // by Claude Fable 5.1
	'Always' => 'எப்போதும்', // by Claude Fable 5.1
	'More values than %d' => '%d ஐ விட அதிக மதிப்புகள்', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'enum நெடுவரிசைகளுக்கு தேர்வுப் பட்டியை காண்பிப்பதற்கான வரம்பு.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'ஒரு முறை கடவுச்சொல்', // by Claude Fable 5.1
	'Enter OTP code.' => 'OTP குறியீட்டை உள்ளிடவும்.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'OTP குறியீடு சரியானதல்ல.', // by Claude Fable 5.1
	'Access denied.' => 'அணுகல் மறுக்கப்பட்டது.', // by Claude Fable 5.1
	'JSON previews' => 'JSON முன்னோட்டங்கள்', // by Claude Fable 5.1
	'Data table' => 'தகவல் அட்டவணை', // by Claude Fable 5.1
	'Edit form' => 'தொகுப்புப் படிவம்', // by Claude Fable 5.1
	'Ask %s' => '%s இடம் கேளுங்கள்', // by Claude Fable 5.1
	'Views' => 'பார்வைகள்', // by Claude Opus 5.5
];
