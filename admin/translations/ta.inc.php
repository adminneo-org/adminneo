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

	// Login
	'System' => 'சிஸ்ட‌ம் (System)',
	'Server' => 'வ‌ழ‌ங்கி (Server)',
	'Username' => 'ப‌ய‌னாள‌ர் (User)',
	'Password' => 'க‌ட‌வுச்சொல்',
	'Permanent login' => 'நிர‌ந்த‌ர‌மாக‌ நுழைய‌வும்',
	'Login' => 'நுழை',
	'Logout' => 'வெளியேறு',
	'Logged as: %s' => 'ப‌ய‌னாளர்: %s',
	'Logout successful.' => 'வெற்றிக‌ர‌மாய் வெளியேறியாயிற்று.',
	'Invalid CSRF token. Send the form again.' => 'CSRF டோக்க‌ன் செல்லாது. ப‌டிவ‌த்தை மீண்டும் அனுப்ப‌வும்.',

	// Connection
	'No extension' => 'விரிவு (extensஇஒன்) இல்லை ',
	'None of the supported PHP extensions (%s) are available.' => 'PHP ஆத‌ர‌வு விரிவுக‌ள் (%s) இல்லை.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'செஷ‌ன் ஆத‌ர‌வு இய‌க்க‌ப்ப‌ட‌ வேண்டும்.',
	'Session expired, please login again.' => 'செஷ‌ன் காலாவ‌தியாகி விட்ட‌து. மீண்டும் நுழைய‌வும்.',
	'%s version: %s through PHP extension %s' => '%s ப‌திப்பு: %s through PHP extension %s',

	// Settings
	'Language' => 'மொழி',

	'Refresh' => 'புதுப்பி (Refresh)',

	// Privileges
	'Privileges' => 'ச‌லுகைக‌ள் / சிற‌ப்புரிமைக‌ள்',
	'Create user' => 'ப‌ய‌னாள‌ரை உருவாக்கு',
	'User has been dropped.' => 'ப‌யனீட்டாள‌ர் நீக்க‌ப்ப‌ட்டார்.',
	'User has been altered.' => 'ப‌யனீட்டாள‌ர் மாற்றப்ப‌ட்டார்.',
	'User has been created.' => 'ப‌ய‌னீட்டாள‌ர் உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'வேலைக‌ளின் ப‌ட்டி',
	'%d process(es) have been killed.' => [
		'%d வேலை வ‌லுவில் நிறுத்த‌ப‌ட்ட‌து.',
		'%d வேலைக‌ள் வ‌லுவில் நிறுத்த‌ப‌ட்ட‌ன‌.',
	],
	'Kill' => 'வ‌லுவில் நிறுத்து',
	'Variables' => 'மாறிலிக‌ள் (Variables)',
	'Status' => 'நிக‌ழ்நிலை (Status)',

	// Structure
	'Column' => 'நெடுவ‌ரிசை',
	'Routine' => 'ரொட்டீன்',
	'Grant' => 'அனும‌திய‌ளி',
	'Revoke' => 'இர‌த்துச்செய்',

	// Queries
	'SQL command' => 'SQL க‌ட்ட‌ளை',
	'%d query(s) executed OK.' => [
		'%d வின‌வ‌ல் செய‌ல்ப‌டுத்த‌ப்ப‌ட்ட‌து.',
		'%d வின‌வ‌ல்க‌ள் செய‌ல்ப‌டுத்த‌ப்ப‌ட்ட‌ன‌.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'வின‌வ‌ல் செய‌ல்ப‌டுத்த‌ப்ப‌ட்ட‌து, %d வ‌ரிசை மாற்ற‌ப்ப‌ட்ட‌து.',
		'வின‌வ‌ல் செய‌ல்ப‌டுத்த‌ப்ப‌ட்ட‌து, %d வ‌ரிசைக‌ள் மாற்றப்ப‌ட்ட‌ன‌.',
	],
	'No commands to execute.' => 'செய‌ல் ப‌டுத்த‌ எந்த‌ க‌ட்ட‌ளைக‌ளும் இல்லை.',
	'Error in query' => 'வின‌வ‌லில் த‌வ‌றுள்ள‌து',
	'Execute' => 'செய‌ல்ப‌டுத்து',
	'Stop on error' => 'பிழை ஏற்ப‌டின் நிற்க‌',
	'Show only errors' => 'பிழைக‌ளை ம‌ட்டும் காண்பிக்க‌வும்',
	'Time' => 'நேர‌ம்',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'வ‌ர‌லாறு',
	'Clear' => 'துடை (Clear)',
	'Edit all' => 'அனைத்தையும் தொகு',

	// Import
	'Import' => 'இற‌க்கும‌தி (Import)',
	'File upload' => 'கோப்பை மேலேற்று (upload) ',
	'From server' => 'செர்வ‌ரில் இருந்து',
	'Webserver file %s' => 'வெப் ச‌ர்வ‌ர் கோப்பு %s',
	'Run file' => 'கோப்பினை இய‌க்க‌வும்',
	'File does not exist.' => 'கோப்பு இல்லை.',
	'File uploads are disabled.' => 'கோப்புக‌ள் மேலேற்றம் (upload)முட‌க்க‌ப்ப‌ட்டுள்ள‌ன‌.',
	'Unable to upload a file.' => 'கோப்பை மேலேற்ற‌ம் (upload) செய்ய‌ இயல‌வில்லை.',
	'Maximum allowed file size is %sB.' => 'கோப்பின் அதிக‌ப‌ட்ச‌ அள‌வு %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'மிக‌ அதிக‌மான‌ POST த‌க‌வ‌ல். த‌க‌வ‌லை குறைக்க‌வும் அல்ல‌து %s வ‌டிவ‌மைப்பை (configuration directive) மாற்ற‌வும்.',
	'%d row(s) have been imported.' => [
		'%d வ‌ரிசை இற‌க்கும‌தி (Import) செய்ய‌ப்ப‌ட்ட‌து.',
		'%d வ‌ரிசைக‌ள் இற‌க்கும‌தி (Import) செய்ய‌ப்ப‌ட்டன‌.',
	],

	// Export
	'Export' => 'ஏற்றும‌தி',
	'Output' => 'வெளியீடு',
	'open' => 'திற‌',
	'save' => 'சேமி',
	'Format' => 'ஃபார்ம‌ட் (Format)',
	'Data' => 'த‌க‌வ‌ல்',

	// Databases
	'Database' => 'த‌க‌வ‌ல்த‌ள‌ம்',
	'Use' => 'உப‌யோகி',
	'Invalid database.' => 'த‌க‌வ‌ல்த‌ள‌ம் ச‌ரியானதல்ல‌.',
	'Alter database' => 'த‌க‌வ‌ல்த‌ள‌த்தை மாற்று',
	'Create database' => 'த‌க‌வ‌ல்த‌ள‌த்தை உருவாக்கு',
	'Database schema' => 'த‌க‌வ‌ல்த‌ள‌ அமைப்பு முறைக‌ள்',
	'Permanent link' => 'நிரந்தர இணைப்பு',
	'Database has been dropped.' => 'த‌க‌வ‌ல்த‌ள‌ம் நீக்க‌ப்ப‌ட்ட‌து.',
	'Databases have been dropped.' => 'த‌க‌வ‌ல் த‌ள‌ங்க‌ள் நீக்க‌ப்ப‌ட்டன‌.',
	'Database has been created.' => 'த‌க‌வ‌ல்த‌ள‌ம் உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Database has been renamed.' => 'த‌க‌வ‌ல்த‌ள‌ம் பெய‌ர் மாற்ற‌ப்ப‌ட்ட‌து.',
	'Database has been altered.' => 'த‌க‌வ‌ல்த‌ள‌ம் மாற்ற‌ப்ப‌ட்ட‌து.',

	// SQLite errors
	'File exists.' => 'கோப்பு உள்ள‌து.',
	'Please use one of the extensions %s.' => 'த‌ய‌வு செய்து ஒரு விரிவினை %s (extension) உப‌யோகிக்க‌வும்.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'அமைப்புமுறை',
	'Alter schema' => 'அமைப்புமுறையை மாற்று',
	'Create schema' => 'அமைப்புமுறையை உருவாக்கு',
	'Schema has been dropped.' => 'அமைப்புமுறை நீக்க‌ப்ப‌ட்ட‌து.',
	'Schema has been created.' => 'அமைப்புமுறை உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Schema has been altered.' => 'அமைப்புமுறை மாற்ற‌ப்ப‌ட்ட‌து.',
	'Invalid schema.' => 'அமைப்புமுறை ச‌ரியான‌த‌ல்ல‌ (Invalid Schema).',

	// Table list
	'Engine' => 'எஞ்சின் (Engine)',
	'engine' => 'எஞ்சின்',
	'Collation' => 'கொலேச‌ன்',
	'collation' => 'கொலேச‌ன்',
	'Data Length' => 'த‌க‌வ‌ல் நீள‌ம்',
	'Index Length' => 'Index நீள‌ம்',
	'Data Free' => 'Data Free',
	'Rows' => 'வ‌ரிசைக‌ள்',
	'%d in total' => 'மொத்தம் %d ',
	'Analyze' => 'நுணுகி ஆராய‌வும்',
	'Optimize' => 'உக‌ப்பாக்கு (Optimize)',
	'Check' => 'ப‌ரிசோதி',
	'Repair' => 'ப‌ழுது பார்',
	'Truncate' => 'குறை (Truncate)',
	'Tables have been truncated.' => 'அட்ட‌வ‌ணை குறைக்க‌ப்ப‌ட்ட‌து (truncated).',
	'Move to other database' => 'ம‌ற்ற‌ த‌க‌வ‌ல் தள‌த்திற்க்கு ந‌க‌ர்த்து',
	'Move' => 'ந‌க‌ர்த்து',
	'Tables have been moved.' => 'அட்ட‌வ‌ணை ந‌க‌ர்த்த‌ப்ப‌ட்ட‌து.',
	'Copy' => 'நகல்',
	'Tables have been copied.' => 'அட்டவணைகள் நகலெடுக்கப் பட்டது.',

	// Tables
	'Tables' => 'அட்ட‌வ‌ணை',
	'Tables and views' => 'அட்ட‌வ‌ணைக‌ளும் பார்வைக‌ளும்',
	'Table' => 'அட்ட‌வ‌ணை',
	'No tables.' => 'அட்ட‌வ‌ணை இல்லை.',
	'Alter table' => 'அட்ட‌வ‌ணையை மாற்று',
	'Create table' => 'அட்ட‌வ‌ணையை உருவாக்கு',
	'Table has been dropped.' => 'அட்ட‌வ‌ணை நீக்க‌ப்ப‌ட்ட‌து.',
	'Tables have been dropped.' => 'அட்ட‌வ‌ணை நீக்க‌ப்ப‌ட்ட‌து.',
	'Table has been altered.' => 'அட்ட‌வணை மாற்ற‌ப்ப‌ட்ட‌து.',
	'Table has been created.' => 'அட்ட‌வ‌ணை உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Table name' => 'அட்ட‌வ‌ணைப் பெய‌ர்',
	'Name' => 'பெய‌ர்',
	'Show structure' => 'க‌ட்ட‌மைப்பை காண்பிக்க‌வும்',
	'Column name' => 'நெடுவ‌ரிசையின் பெய‌ர்',
	'Type' => 'வ‌கை',
	'Length' => 'நீளம்',
	'Auto Increment' => 'ஏறுமான‌ம்',
	'Options' => 'வேண்டிய‌வ‌ற்றை ',
	'Comment' => 'குறிப்பு',
	'Drop' => 'நீக்கு',
	'Are you sure?' => 'நிச்ச‌ய‌மாக‌ ?',
	'Move up' => 'மேலே ந‌க‌ர்த்து',
	'Move down' => 'கீழே நக‌ர்த்து',
	'Remove' => 'நீக்கு',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'அனும‌திக்க‌ப்ப‌ட்ட‌ அதிக‌ப‌ட்ச‌ கோப்புக‌ளின் எண்ணிக்கை மீற‌ப்ப‌ட்ட‌து. த‌ய‌வு செய்து %s ம‌ற்றும் %s யை அதிக‌ரிக்க‌வும்.',

	// Views
	'View' => 'தோற்றம்',
	'View has been dropped.' => 'தோற்ற‌ம் நீக்க‌ப்ப‌ட்ட‌து.',
	'View has been altered.' => 'தோற்றம் மாற்றப்ப‌ட்ட‌து.',
	'View has been created.' => 'தோற்ற‌ம் உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Alter view' => 'தோற்ற‌த்தை மாற்று',
	'Create view' => 'தோற்றத்தை உருவாக்கு',

	// Partitions
	'Partition by' => 'பிரித்த‌து',
	'Partitions' => 'பிரிவுக‌ள்',
	'Partition name' => 'பிரிவின் பெய‌ர்',
	'Values' => 'ம‌திப்புக‌ள்',

	// Indexes
	'Indexes' => 'அக‌வ‌ரிசைக‌ள் (Index) ',
	'Indexes have been altered.' => 'அக‌வ‌ரிசைக‌ள் (Indexes) மாற்ற‌ப்பட்ட‌து.',
	'Alter indexes' => 'அக‌வ‌ரிசையை (Index) மாற்று',
	'Add next' => 'அடுத்த‌தை சேர்க்க‌வும்',
	'Index Type' => 'அக‌வ‌ரிசை வ‌கை (Index Type)',
	'length' => 'நீள‌ம்',

	// Foreign keys
	'Foreign keys' => 'வேற்று விசைக‌ள்',
	'Foreign key' => 'வேற்று விசை',
	'Foreign key has been dropped.' => 'வேற்று விசை நீக்க‌ப்ப‌ட்ட‌து.',
	'Foreign key has been altered.' => 'வேற்று விசை மாற்ற‌ப்ப‌ட்ட‌து.',
	'Foreign key has been created.' => 'வேற்று விசை உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Target table' => 'அட்ட‌வ‌ணை இல‌க்கு',
	'Change' => 'மாற்று',
	'Source' => 'மூல‌ம்',
	'Target' => 'இல‌க்கு',
	'Add column' => 'நெடு வ‌ரிசையை சேர்க்க‌வும்',
	'Alter' => 'மாற்று',
	'Add foreign key' => 'வேற்று விசை சேர்க்க‌வும்',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'இல‌க்கு நெடுவ‌ரிசையில் அக‌வ‌ரிசை (Index) ம‌ற்றும் குறிக்க‌ப்ப‌ட்ட‌ த‌க‌வல் (Referenced DATA) க‌ண்டிப்பாக‌ இருத்த‌ல் வேண்டும். மூல‌ நெடுவ‌ரிசை ம‌ற்றும் இலக்கு நெடுவ‌ரிசையின் த‌க‌வ‌ல் வ‌டிவ‌ம் (DATA TYPE) ஒன்றாக‌ இருக்க‌ வேண்டும்.',

	// Routines
	'Routines' => 'ரொட்டீன் ',
	'Routine has been called, %d row(s) affected.' => [
		'ரொட்டீன்க‌ள் அழைக்க‌ப்பட்டுள்ள‌ன‌, %d வ‌ரிசை மாற்ற‌ம் அடைந்த‌து.',
		'ரொட்டீன்க‌ள் அழைக்க‌ப்ப‌ட்டுள்ள‌ன‌, %d வ‌ரிசைக‌ள் மாற்றம் அடைந்துள்ள‌ன‌.',
	],
	'Call' => 'அழை',
	'Parameter name' => 'அள‌புரு (Parameter) பெய‌ர்',
	'Create procedure' => 'செய்முறையை உருவாக்கு',
	'Create function' => 'Function உருவாக்கு',
	'Routine has been dropped.' => 'ரொட்டீன் நீக்க‌ப்ப‌ட்ட‌து.',
	'Routine has been altered.' => 'ரொட்டீன் மாற்ற‌ப்ப‌ட்டது.',
	'Routine has been created.' => 'ரொட்டீன் உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Alter function' => 'Function மாற்று',
	'Alter procedure' => 'செய‌ல்முறையை மாற்று',
	'Return type' => 'திரும்பு வ‌கை',

	// Events
	'Events' => 'நிக‌ழ்ச்சிக‌ள்',
	'Event' => 'நிக‌ழ்ச்சி',
	'Event has been dropped.' => 'நிக‌ழ்ச்சி (Event) நீக்க‌ப்ப‌ட்ட‌து.',
	'Event has been altered.' => 'நிக‌ழ்ச்சி (Event) மாற்றப்ப‌ட்ட‌து.',
	'Event has been created.' => 'நிக‌ழ்ச்சி (Event) உருவாக்க‌‌ப்ப‌ட்ட‌து.',
	'Alter event' => 'நிக‌ழ்ச்சியை (Event) மாற்று',
	'Create event' => 'நிக‌ழ்ச்சியை (Event) உருவாக்கு',
	'At given time' => 'குறித்த‌ நேர‌த்தில்',
	'Every' => 'ஒவ்வொரு',
	'Schedule' => 'கால‌ அட்ட‌வ‌ணை',
	'Start' => 'தொட‌ங்கு',
	'End' => 'முடி (வு)',
	'On completion preserve' => 'முடிந்த‌தின் பின் பாதுகாக்க‌வும்',

	// Sequences (PostgreSQL)
	'Sequences' => 'வ‌ரிசைமுறை',
	'Create sequence' => 'வ‌ரிசைமுறையை உருவாக்கு',
	'Sequence has been dropped.' => 'வ‌ரிசைமுறை நீக்க‌ப்ப‌ட்ட‌து.',
	'Sequence has been created.' => 'வ‌ரிசைமுறை உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Sequence has been altered.' => 'வ‌ரிசைமுறை மாற்ற‌ப்ப‌ட்ட‌து.',
	'Alter sequence' => 'வ‌ரிசைமுறையை மாற்று',

	// User types (PostgreSQL)
	'User types' => 'ப‌ய‌னாள‌ர் வ‌கைக‌ள்',
	'Create type' => 'வ‌கையை உருவாக்கு',
	'Type has been dropped.' => 'வ‌கை (type) நீக்க‌ப்ப‌ட்ட‌து.',
	'Type has been created.' => 'வ‌கை (type) உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Alter type' => 'வ‌கையினை (type) மாற்று',

	// Triggers
	'Triggers' => 'தூண்டுத‌ல்க‌ள்',
	'Add trigger' => 'தூண்டு விசையை சேர்',
	'Trigger has been dropped.' => 'தூண்டு விசை நீக்க‌ப்ப‌ட்ட‌து.',
	'Trigger has been altered.' => 'தூண்டு விசை மாற்ற‌ப்ப‌ட்ட‌து.',
	'Trigger has been created.' => 'தூண்டு விசை உருவாக்க‌ப்ப‌ட்ட‌து.',
	'Alter trigger' => 'தூண்டு விசையை மாற்று',
	'Create trigger' => 'தூண்டு விசையை உருவாக்கு',

	// Table check constraints

	// Selection
	'Select data' => 'த‌க‌வ‌லை தேர்வு செய்',
	'Select' => 'தேர்வு செய்',
	'Functions' => 'Functions',
	'Aggregation' => 'திர‌ள்வு (Aggregation)',
	'Search' => 'தேடு',
	'anywhere' => 'எங்காயினும்',
	'Sort' => 'த‌ர‌ம் பிரி',
	'descending' => 'இற‌ங்குமுக‌மான‌',
	'Limit' => 'வ‌ர‌ம்பு',
	'Text length' => 'உரை நீள‌ம்',
	'Action' => 'செய‌ல்',
	'Unable to select the table' => 'அட்ட‌வ‌ணையை தேர்வு செய்ய‌ முடிய‌வில்லை',
	'Search data in tables' => 'த‌க‌வ‌லை அட்ட‌வ‌ணையில் தேடு',
	'No rows.' => 'வ‌ரிசை இல்லை.',
	'%d row(s)' => [
		'%d வ‌ரிசை',
		'%d வ‌ரிசைக‌ள்',
	],
	'Page' => 'ப‌க்க‌ம்',
	'last' => 'க‌டைசி',
	'Whole result' => 'முழுமையான‌ முடிவு',
	'%d byte(s)' => [
		'%d பைட்',
		'%d பைட்டுக‌ள்',
	],

	// In-place editing in selection
	'Use edit link to modify this value.' => 'இந்த‌ ம‌திப்பினை மாற்ற‌, தொகுப்பு இணைப்பினை உப‌யோகிக்க‌வும்.',

	// Editing
	'New item' => 'புதிய‌ உருப்ப‌டி',
	'Edit' => 'தொகு',
	'original' => 'அச‌ல்',
	'empty' => 'வெறுமை (empty)', // label for value '' in enum data type
	'Insert' => 'புகுத்து',
	'Save' => 'சேமி',
	'Save and continue edit' => 'சேமித்த‌ பிற‌கு தொகுப்ப‌தை தொட‌ர‌வும்',
	'Save and insert next' => 'சேமித்த‌ப் பின் அடுத்த‌தை புகுத்து',
	'Clone' => 'ந‌க‌லி (Clone)',
	'Delete' => 'நீக்கு',
	'Item%s has been inserted.' => 'உருப்ப‌டி (Item%s) சேர்க்க‌ப்ப‌ட்ட‌து.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'உருப்படி நீக்க‌ப்ப‌ட்ட‌து.',
	'Item has been updated.' => 'உருப்ப‌டி புதுப்பிக்க‌ப்ப‌ட்ட‌து.',
	'%d item(s) have been affected.' => [
		'%d உருப்ப‌டி மாற்ற‌ம‌டைந்தது.',
		'%d உருப்ப‌டிக‌ள் மாற்ற‌ம‌டைந்த‌ன‌.',
	],

	// Data type descriptions
	'Numbers' => 'எண்க‌ள்',
	'Date and time' => 'தேதி ம‌ற்றும் நேர‌ம்',
	'Strings' => 'ச‌ர‌ம் (String)',
	'Binary' => 'பைன‌ரி',
	'Lists' => 'ப‌ட்டிய‌ல்',
	'Network' => 'நெட்வொர்க்',
	'Geometry' => 'வ‌டிவ‌விய‌ல் (Geometry)',
	'Relations' => 'உற‌வுக‌ள் (Relations)',

	// Editor - data values
	'now' => 'இப்பொழுது',

	// Settings

	// Plugins
];
