<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '०१२३४५६७८९',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1-$3-$5',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'YYYY-MM-DD',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'सिस्टम',
	'Server' => 'सर्वर',
	'Username' => 'उपयोगकर्ता नाम',
	'Password' => 'पासवर्ड',
	'Permanent login' => 'स्थायी लॉगिन',
	'Login' => 'लॉगिन',
	'Logout' => 'लॉगआउट',
	'Logged as: %s' => '%s के रूप में लॉगिन',
	'Logout successful.' => 'सफलतापूर्वक लॉगआउट हो गया।',
	'There is a space in the input password which might be the cause.' => 'इनपुट पासवर्ड में एक स्पेस है जो कारण हो सकता है।',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'एडमिनर बिना पासवर्ड के डेटाबेस एक्सेस करने का समर्थन नहीं करता, <a href="https://www.adminneo.org/password"%s>अधिक जानकारी</a>।',
	'Database does not support password.' => 'डेटाबेस पासवर्ड का समर्थन नहीं करता।',
	'Too many unsuccessful logins, try again in %d minute(s).' => 'बहुत अधिक असफल लॉगिन प्रयास, %d मिनट बाद पुनः प्रयास करें।',
	'Invalid CSRF token. Send the form again.' => 'अमान्य CSRF टोकन। फॉर्म फिर से भेजें।',
	'If you did not send this request from AdminNeo then close this page.' => 'अगर आपने यह अनुरोध एडमिनर से नहीं भेजा है तो इस पेज को बंद करें।',
	'The action will be performed after successful login with the same credentials.' => 'यह क्रिया उसी क्रेडेंशियल्स से सफल लॉगिन के बाद की जाएगी।',

	// Connection.
	'No extension' => 'कोई एक्सटेंशन नहीं',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'कोई समर्थित PHP एक्सटेंशन (%s) उपलब्ध नहीं है।',
	'Connecting to privileged ports is not allowed.' => 'प्रिविलेज्ड पोर्ट्स से कनेक्ट करने की अनुमति नहीं है।',
	'Session support must be enabled.' => 'सेशन सपोर्ट सक्षम होना चाहिए।',
	'Session expired, please login again.' => 'सेशन समाप्त, कृपया फिर से लॉगिन करें।',
	'%s version: %s through PHP extension %s' => 'संस्करण %s: %s, PHP एक्सटेंशन %s के माध्यम से',

	// Settings.
	'Language' => 'भाषा',

	'Refresh' => 'ताज़ा करें',

	// Privileges.
	'Privileges' => 'विशेषाधिकार',
	'Create user' => 'उपयोगकर्ता बनाएं',
	'User has been dropped.' => 'उपयोगकर्ता हटा दिया गया है।',
	'User has been altered.' => 'उपयोगकर्ता बदल दिया गया है।',
	'User has been created.' => 'उपयोगकर्ता बनाया गया है।',
	'Hashed' => 'हैश्ड',

	// Server.
	'Process list' => 'प्रक्रिया सूची',
	'%d process(es) have been killed.' => [
		'%d प्रक्रिया समाप्त की गई है।',
		'%d प्रक्रियाएं समाप्त की गई हैं।',
	],
	'Kill' => 'समाप्त करें',
	'Variables' => 'चर',
	'Status' => 'स्थिति',

	// Structure.
	'Column' => 'कॉलम',
	'Routine' => 'रूटीन',
	'Grant' => 'अनुदान',
	'Revoke' => 'रद्द करें',

	// Queries.
	'SQL command' => 'SQL कमांड',
	'%d query(s) executed OK.' => [
		'%d क्वेरी सफलतापूर्वक निष्पादित।',
		'%d क्वेरीज़ सफलतापूर्वक निष्पादित।',
	],
	'Query executed OK, %d row(s) affected.' => [
		'क्वेरी सफलतापूर्वक निष्पादित, %d पंक्ति प्रभावित।',
		'क्वेरी सफलतापूर्वक निष्पादित, %d पंक्तियां प्रभावित।',
	],
	'No commands to execute.' => 'निष्पादित करने के लिए कोई कमांड नहीं।',
	'Error in query' => 'क्वेरी में त्रुटि',
	'Unknown error.' => 'अज्ञात त्रुटि।',
	'Warnings' => 'चेतावनियाँ',
	'%s queries are not supported.' => '%s क्वेरीज़ समर्थित नहीं हैं।',
	'Execute' => 'निष्पादित करें',
	'Stop on error' => 'त्रुटि पर रुकें',
	'Show only errors' => 'केवल त्रुटियां दिखाएं',
	'Time' => 'समय',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f सेकंड',
	'History' => 'इतिहास',
	'Clear' => 'साफ़ करें',
	'Edit all' => 'सभी संपादित करें',

	// Import.
	'Import' => 'आयात',
	'File upload' => 'फाइल अपलोड',
	'From server' => 'सर्वर से',
	'Webserver file %s' => 'वेबसर्वर फाइल %s',
	'Run file' => 'फाइल चलाएं',
	'File does not exist.' => 'फाइल मौजूद नहीं है।',
	'File uploads are disabled.' => 'फाइल अपलोड अक्षम हैं।',
	'Unable to upload a file.' => 'फाइल अपलोड करने में असमर्थ।',
	'Maximum allowed file size is %sB.' => 'अधिकतम अनुमत फाइल आकार %sB है।',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'बहुत बड़ा POST डेटा। डेटा कम करें या %s कॉन्फ़िगरेशन निर्देश बढ़ाएं।',
	'You can upload a big SQL file via FTP and import it from server.' => 'आप एक बड़ी SQL फ़ाइल FTP के माध्यम से अपलोड कर सकते हैं और सर्वर से इम्पोर्ट कर सकते हैं।',
	'File must be in UTF-8 encoding.' => 'फ़ाइल UTF-8 एन्कोडिंग में होनी चाहिए।',
	'You are offline.' => 'आप ऑफ़लाइन हैं।',
	'%d row(s) have been imported.' => [
		'%d पंक्ति आयात की गई है।',
		'%d पंक्तियां आयात की गई हैं।',
	],

	// Export.
	'Export' => 'निर्यात',
	'Output' => 'आउटपुट',
	'open' => 'खोलें',
	'save' => 'सहेजें',
	'Format' => 'प्रारूप',
	'Data' => 'डेटा',

	// Databases.
	'Database' => 'डेटाबेस',
	'DB' => 'डेटाबेस',
	'Use' => 'उपयोग करें',
	'Invalid database.' => 'अमान्य डेटाबेस।',
	'Alter database' => 'डेटाबेस बदलें',
	'Create database' => 'डेटाबेस बनाएं',
	'Database schema' => 'डेटाबेस स्कीमा',
	'Permanent link' => 'स्थायी लिंक',
	'Database has been dropped.' => 'डेटाबेस हटा दिया गया है।',
	'Databases have been dropped.' => 'डेटाबेस हटा दिए गए हैं।',
	'Database has been created.' => 'डेटाबेस बनाया गया है।',
	'Database has been renamed.' => 'डेटाबेस का नाम बदल दिया गया है।',
	'Database has been altered.' => 'डेटाबेस बदल दिया गया है।',
	// SQLite errors.
	'File exists.' => 'फाइल मौजूद है।',
	'Please use one of the extensions %s.' => 'कृपया %s एक्सटेंशन्स में से एक का उपयोग करें।',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'स्कीमा',
	'Alter schema' => 'स्कीमा बदलें',
	'Create schema' => 'स्कीमा बनाएं',
	'Schema has been dropped.' => 'स्कीमा हटा दी गई है।',
	'Schema has been created.' => 'स्कीमा बनाई गई है।',
	'Schema has been altered.' => 'स्कीमा बदल दी गई है।',
	'Invalid schema.' => 'अमान्य स्कीमा।',

	// Table list.
	'Engine' => 'इंजन',
	'engine' => 'इंजन',
	'Collation' => 'कॉलेशन',
	'collation' => 'कॉलेशन',
	'Data Length' => 'डेटा लंबाई',
	'Index Length' => 'इंडेक्स लंबाई',
	'Data Free' => 'डेटा मुक्त',
	'Rows' => 'पंक्तियां',
	'%d in total' => 'कुल %d',
	'Analyze' => 'विश्लेषण',
	'Optimize' => 'अनुकूलित',
	'Vacuum' => 'वैक्यूम',
	'Check' => 'जांच',
	'Repair' => 'मरम्मत',
	'Truncate' => 'ट्रंकेट',
	'Tables have been truncated.' => 'टेबल्स ट्रंकेट कर दिए गए हैं।',
	'Move to other database' => 'अन्य डेटाबेस में स्थानांतरित करें',
	'Move' => 'स्थानांतरित करें',
	'Tables have been moved.' => 'टेबल्स स्थानांतरित कर दिए गए हैं।',
	'Copy' => 'कॉपी',
	'Tables have been copied.' => 'टेबल्स कॉपी कर दिए गए हैं।',
	'overwrite' => 'ओवरराइट',

	// Tables.
	'Tables' => 'टेबल्स',
	'Tables and views' => 'टेबल्स और व्यूज',
	'Table' => 'टेबल',
	'No tables.' => 'कोई टेबल नहीं।',
	'Alter table' => 'टेबल बदलें',
	'Create table' => 'टेबल बनाएं',
	'Table has been dropped.' => 'टेबल हटा दिया गया है।',
	'Tables have been dropped.' => 'टेबल्स हटा दिए गए हैं।',
	'Tables have been optimized.' => 'टेबल्स को ऑप्टिमाइज़ कर दिया गया है।',
	'Table has been altered.' => 'टेबल बदल दिया गया है।',
	'Table has been created.' => 'टेबल बनाया गया है।',
	'Table name' => 'टेबल का नाम',
	'Name' => 'नाम',
	'Show structure' => 'संरचना दिखाएं',
	'Column name' => 'कॉलम का नाम',
	'Type' => 'प्रकार',
	'Length' => 'लंबाई',
	'Auto Increment' => 'ऑटो इंक्रीमेंट',
	'Options' => 'विकल्प',
	'Comment' => 'टिप्पणी',
	'Default value' => 'डिफ़ॉल्ट मान',
	'Drop' => 'हटाएं',
	'Drop %s?' => '%s हटाएँ?',
	'Are you sure?' => 'क्या आप सुनिश्चित हैं?',
	'Size' => 'आकार',
	'Compute' => 'कम्प्यूट',
	'Move up' => 'ऊपर ले जाएं',
	'Move down' => 'नीचे ले जाएं',
	'Remove' => 'हटाएं',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'अनुमत फील्ड्स की अधिकतम संख्या पार हो गई। कृपया %s बढ़ाएं।',

	// Views.
	'View' => 'व्यू',
	'Materialized view' => 'मटेरियलाइज़्ड व्यू',
	'View has been dropped.' => 'व्यू हटा दिया गया है।',
	'View has been altered.' => 'व्यू बदल दिया गया है।',
	'View has been created.' => 'व्यू बनाया गया है।',
	'Alter view' => 'व्यू बदलें',
	'Create view' => 'व्यू बनाएं',

	// Partitions.
	'Partition by' => 'द्वारा विभाजन',
	'Partitions' => 'पार्टीशन्स',
	'Partition name' => 'पार्टीशन नाम',
	'Values' => 'मान',

	// Indexes.
	'Indexes' => 'इंडेक्स',
	'Indexes have been altered.' => 'इंडेक्स बदल दिए गए हैं।',
	'Alter indexes' => 'इंडेक्स बदलें',
	'Add next' => 'अगला जोड़ें',
	'Index Type' => 'इंडेक्स प्रकार',
	'length' => 'लंबाई',

	// Foreign keys.
	'Foreign keys' => 'फॉरेन की',
	'Foreign key' => 'फॉरेन की',
	'Foreign key has been dropped.' => 'फॉरेन की हटा दी गई है।',
	'Foreign key has been altered.' => 'फॉरेन की बदल दी गई है।',
	'Foreign key has been created.' => 'फॉरेन की बनाई गई है।',
	'Target table' => 'लक्ष्य टेबल',
	'Change' => 'बदलें',
	'Source' => 'स्रोत',
	'Target' => 'लक्ष्य',
	'Add column' => 'कॉलम जोड़ें',
	'Alter' => 'बदलें',
	'Add foreign key' => 'फॉरेन की जोड़ें',
	'ON DELETE' => 'ऑन डिलीट',
	'ON UPDATE' => 'ऑन अपडेट',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'स्रोत और लक्ष्य कॉलम्स का डेटा प्रकार समान होना चाहिए, लक्ष्य कॉलम्स पर एक इंडेक्स होना चाहिए और संदर्भित डेटा मौजूद होना चाहिए।',

	// Routines.
	'Routines' => 'रूटीन्स',
	'Routine has been called, %d row(s) affected.' => [
		'रूटीन कॉल किया गया, %d पंक्ति प्रभावित।',
		'रूटीन कॉल किया गया, %d पंक्तियां प्रभावित।',
	],
	'Call' => 'कॉल',
	'Parameter name' => 'पैरामीटर नाम',
	'Create procedure' => 'प्रक्रिया बनाएं',
	'Create function' => 'फंक्शन बनाएं',
	'Routine has been dropped.' => 'रूटीन हटा दिया गया है।',
	'Routine has been altered.' => 'रूटीन बदल दिया गया है।',
	'Routine has been created.' => 'रूटीन बनाया गया है।',
	'Alter function' => 'फंक्शन बदलें',
	'Alter procedure' => 'प्रक्रिया बदलें',
	'Return type' => 'वापसी प्रकार',

	// Events.
	'Events' => 'घटनाएं',
	'Event' => 'घटना',
	'Event has been dropped.' => 'घटना हटा दी गई है।',
	'Event has been altered.' => 'घटना बदल दी गई है।',
	'Event has been created.' => 'घटना बनाई गई है।',
	'Alter event' => 'घटना बदलें',
	'Create event' => 'घटना बनाएं',
	'At given time' => 'निर्धारित समय पर',
	'Every' => 'हर',
	'Schedule' => 'अनुसूची',
	'Start' => 'शुरू',
	'End' => 'समाप्त',
	'On completion preserve' => 'पूरा होने पर संरक्षित करें',

	// Sequences (PostgreSQL).
	'Sequences' => 'अनुक्रम',
	'Create sequence' => 'अनुक्रम बनाएं',
	'Sequence has been dropped.' => 'अनुक्रम हटा दिया गया है।',
	'Sequence has been created.' => 'अनुक्रम बनाया गया है।',
	'Sequence has been altered.' => 'अनुक्रम बदल दिया गया है।',
	'Alter sequence' => 'अनुक्रम बदलें',

	// User types (PostgreSQL)
	'User types' => 'उपयोगकर्ता प्रकार',
	'Create type' => 'प्रकार बनाएं',
	'Type has been dropped.' => 'प्रकार हटा दिया गया है।',
	'Type has been created.' => 'प्रकार बनाया गया है।',
	'Alter type' => 'प्रकार बदलें',

	// Triggers.
	'Triggers' => 'ट्रिगर्स',
	'Add trigger' => 'ट्रिगर जोड़ें',
	'Trigger has been dropped.' => 'ट्रिगर हटा दिया गया है।',
	'Trigger has been altered.' => 'ट्रिगर बदल दिया गया है।',
	'Trigger has been created.' => 'ट्रिगर बनाया गया है।',
	'Alter trigger' => 'ट्रिगर बदलें',
	'Create trigger' => 'ट्रिगर बनाएं',

	// Table check constraints.
	'Checks' => 'चेक्स',
	'Create check' => 'चेक बनाएँ',
	'Alter check' => 'चेक बदलें',
	'Check has been created.' => 'चेक बनाया गया है।',
	'Check has been altered.' => 'चेक को बदल दिया गया है।',
	'Check has been dropped.' => 'चेक हटा दिया गया है।',

	// Selection.
	'Select data' => 'डेटा चुनें',
	'Select' => 'चुनें',
	'Functions' => 'फंक्शन्स',
	'Aggregation' => 'एग्रीगेशन',
	'Search' => 'खोजें',
	'anywhere' => 'कहीं भी',
	'Sort' => 'क्रमबद्ध करें',
	'descending' => 'अवरोही',
	'Limit' => 'सीमा',
	'Limit rows' => 'पंक्तियाँ सीमित करें',
	'Text length' => 'टेक्स्ट लंबाई',
	'Action' => 'कार्रवाई',
	'Full table scan' => 'पूरी टेबल स्कैन',
	'Unable to select the table' => 'टेबल चुनने में असमर्थ',
	'Search data in tables' => 'टेबल्स में डेटा खोजें',
	'No rows.' => 'कोई पंक्ति नहीं।',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d पंक्ति',
		'%d पंक्तियां',
	],
	'Page' => 'पृष्ठ',
	'last' => 'अंतिम',
	'Load more data' => 'और डेटा लोड करें',
	'Loading' => 'लोड हो रहा है',
	'Whole result' => 'पूरा परिणाम',
	'%d byte(s)' => [
		'%d बाइट',
		'%d बाइट्स',
	],

	// In-place editing in selection.
	'Modify' => 'संशोधित करें',
	'Ctrl+click on a value to modify it.' => 'किसी मान को संशोधित करने के लिए Ctrl+क्लिक करें।',
	'Use edit link to modify this value.' => 'इस मान को संशोधित करने के लिए संपादन लिंक का उपयोग करें।',

	// Editing.
	'New item' => 'नया आइटम',
	'Edit' => 'संपादित करें',
	'original' => 'मूल',
	// label for value '' in enum data type
	'empty' => 'खाली',
	'Insert' => 'डालें',
	'Save' => 'सहेजें',
	'Save and continue edit' => 'सहेजें और संपादन जारी रखें',
	'Save and insert next' => 'सहेजें और अगला डालें',
	'Saving' => 'सेव हो रहा है',
	'Selected' => 'चयनित',
	'Clone' => 'क्लोन',
	'Delete' => 'हटाएं',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'आइटम%s डाला गया है।',
	'Item has been deleted.' => 'आइटम हटा दिया गया है।',
	'Item has been updated.' => 'आइटम अपडेट किया गया है।',
	'%d item(s) have been affected.' => '%d आइटम प्रभावित हुए हैं।',
	'You have no privileges to update this table.' => 'आपके पास इस टेबल को अपडेट करने की अनुमति नहीं है।',

	// Data type descriptions.
	'Numbers' => 'संख्याएं',
	'Date and time' => 'तिथि और समय',
	'Strings' => 'स्ट्रिंग्स',
	'Binary' => 'बाइनरी',
	'Lists' => 'सूचियां',
	'Network' => 'नेटवर्क',
	'Geometry' => 'ज्यामिति',
	'Relations' => 'संबंध',

	// Editor - data values.
	'now' => 'अब',
	'yes' => 'हाँ',
	'no' => 'नहीं',

	// Plugins.
];
