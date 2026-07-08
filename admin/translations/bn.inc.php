<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '০১২৩৪৫৬৭৮৯',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$6.$4.$1',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'T.M.JJJJ',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => 'সিস্টেম',
	'Server' => 'সার্ভার',
	'Username' => 'ইউজারের নাম',
	'Password' => 'পাসওয়ার্ড',
	'Permanent login' => 'স্থায়ী লগইন',
	'Login' => 'লগইন',
	'Logout' => 'লগআউট',
	'Logged as: %s' => '%s হিসাবে লগড',
	'Logout successful.' => 'সফলভাবে লগআউট হয়েছে।',
	'There is a space in the input password which might be the cause.' => 'ইনপুট পাসওয়ার্ডে একটি স্পেস রয়েছে যা এর কারণ হতে পারে।',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo পাসওয়ার্ড ছাড়া ডাটাবেস অ্যাক্সেস সমর্থন করে না, <a href="https://www.adminneo.org/password"%s>আরও তথ্য</a>।',
	'Database does not support password.' => 'ডাটাবেস পাসওয়ার্ড সমর্থন করে না।',
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'অনেকগুলি ব্যর্থ লগইন প্রচেষ্টা, %d মিনিট পরে আবার চেষ্টা করুন।',
	],
	'Invalid CSRF token. Send the form again.' => 'অবৈধ CSRF টোকেন। ফর্মটি আবার পাঠান।',
	'If you did not send this request from AdminNeo then close this page.' => 'আপনি যদি AdminNeo থেকে এই অনুরোধ না করে থাকেন তবে এই পৃষ্ঠাটি বন্ধ করুন।',
	'The action will be performed after successful login with the same credentials.' => 'একই ক্রেডেনশিয়ালস দিয়ে সফলভাবে লগইন করার পরে এই কর্মটি সম্পাদন করা হবে।',

	// Connection.
	'No extension' => 'কোন এক্সটেনশান নাই',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'কোন PHP সমর্থিত এক্সটেনশন (%s) পাওয়া যায় নাই।',
	'Connecting to privileged ports is not allowed.' => 'প্রিভিলেজড পোর্টে সংযোগ করা অনুমোদিত নয়।',
	'Session support must be enabled.' => 'সেশন সমর্থন সক্রিয় করা আবশ্যক।',
	'Session expired, please login again.' => 'সেশনের মেয়াদ শেষ হয়েছে, আবার লগইন করুন।',
	'%s version: %s through PHP extension %s' => 'ভার্সন %s: %s, %s PHP এক্সটেনশনের মধ্য দিয়ে',

	// Settings.
	'Language' => 'ভাষা',

	'Refresh' => 'রিফ্রেশ',

	// Privileges.
	'Privileges' => 'প্রিভিলেজেস',
	'Create user' => 'ব্যবহারকারি তৈরী করুন',
	'User has been dropped.' => 'ব্যবহারকারি মুছে ফেলা হয়েছে।',
	'User has been altered.' => 'ব্যবহারকারি সম্পাদনা করা হয়েছে।',
	'User has been created.' => 'ব্যবহারকারি তৈরী করা হয়েছে।',
	'Hashed' => 'হ্যাশড',

	// Server.
	'Process list' => 'প্রসেস তালিকা',
	'%d process(es) have been killed.' => [
		'%d টি প্রসেস(সমূহ) বিনষ্ট করা হয়েছে।',
		'%d টি প্রসেস(সমূহ) বিনষ্ট করা হয়েছে।',
	],
	'Kill' => 'বিনষ্ট করো',
	'Variables' => 'চলকসমূহ',
	'Status' => 'অবস্থা',

	// Structure.
	'Column' => 'কলাম',
	'Routine' => 'রুটিন',
	'Grant' => 'অনুমতি',
	'Revoke' => 'প্রত্যাহার',

	// Queries.
	'SQL command' => 'SQL-কমান্ড',
	'%d query(s) executed OK.' => [
		'%d SQL-অনুসন্ধান সফলভাবে সম্পন্ন হয়েছে।',
		'%d SQL-অনুসন্ধানসমূহ সফলভাবে সম্পন্ন হয়েছে।',
	],
	'Query executed OK, %d row(s) affected.' => [
		'কোয়্যারী সম্পাদন হয়েছে, %d সারি প্রভাবিত হয়েছে।',
		'কোয়্যারী সম্পাদন হয়েছে, %d সারি প্রভাবিত হয়েছে।',
	],
	'No commands to execute.' => 'সম্পাদন করার মত কোন নির্দেশ নেই।',
	'Error in query' => 'অনুসন্ধানে ভুল আছে',
	'Unknown error.' => 'অজানা ত্রুটি।',
	'Warnings' => 'সতর্কতা',
	'%s queries are not supported.' => '%s কোয়েরি সমর্থিত নয়।',
	'Execute' => 'সম্পাদন করো',
	'Stop on error' => 'ত্রুটি পেলে থেমে যান',
	'Show only errors' => 'শুধুমাত্র ত্রুটিগুলো দেখান',
	'Time' => 'সময়',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f s',
	'History' => 'ইতিহাস',
	'Clear' => 'সাফ করো',
	'Edit all' => 'সবগুলো সম্পাদনা করুন',

	// Import.
	'Import' => 'ইমপোর্ট',
	'File upload' => 'ফাইল আপলোড',
	'From server' => 'সার্ভার থেকে',
	'Webserver file %s' => 'ওয়েবসার্ভার ফাইল %s',
	'Run file' => 'ফাইল চালাও',
	'File does not exist.' => 'ফাইলটির কোন অস্তিত্ব নেই।',
	'File uploads are disabled.' => 'ফাইল আপলোড নিষ্ক্রিয় করা আছে।',
	'Unable to upload a file.' => 'ফাইল আপলোড করা সম্ভব হচ্ছে না।',
	'Maximum allowed file size is %sB.' => 'সর্বাধিক অনুমোদিত ফাইল সাইজ %sB।',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'খুব বড় POST ডাটা। ডাটা সংক্ষিপ্ত করো অথবা %s কনফিগারেশন নির্দেশ বৃদ্ধি করো।',
	'You can upload a big SQL file via FTP and import it from server.' => 'আপনি FTP এর মাধ্যমে একটি বড় SQL ফাইল আপলোড করতে পারেন এবং সার্ভার থেকে এটি ইম্পোর্ট করতে পারেন।',
	'File must be in UTF-8 encoding.' => 'ফাইলটি UTF-8 এনকোডিংয়ে হতে হবে।',
	'You are offline.' => 'আপনি অফলাইনে আছেন।',
	'%d row(s) have been imported.' => [
		'%d টি সারি(সমূহ) ইমপোর্ট করা হয়েছে।',
		'%d টি সারি(সমূহ) ইমপোর্ট করা হয়েছে।',
	],

	// Export.
	'Export' => 'এক্সপোর্ট',
	'Output' => 'আউটপুট',
	'open' => 'খোলা',
	'save' => 'সংরক্ষণ',
	'Format' => 'বিন্যাস',
	'Data' => 'ডাটা',

	// Databases.
	'Database' => 'ডাটাবেজ',
	'DB' => 'ডিবি',
	'Use' => 'ব্যবহার',
	'Invalid database.' => 'অকার্যকর ডাটাবেজ।',
	'Alter database' => 'ডাটাবেজ পরিবর্তন করুন',
	'Create database' => 'ডাটাবেজ তৈরী করুন',
	'Database schema' => 'ডাটাবেজ স্কিমা',
	'Permanent link' => 'স্থায়ী লিংক',
	'Database has been dropped.' => 'ডাটাবেজ মুছে ফেলা হয়েছে।',
	'Databases have been dropped.' => 'ডাটাবেজসমূহ মুছে ফেলা হয়েছে।',
	'Database has been created.' => 'ডাটাবেজ তৈরী করা হয়েছে।',
	'Database has been renamed.' => 'ডাটাবেজের নতুন নামকরণ করা হয়েছে।',
	'Database has been altered.' => 'ডাটাবেজ পরিবর্তন করা হয়েছে।',
	// SQLite errors.
	'File exists.' => 'ফাইল রয়েছে।',
	'Please use one of the extensions %s.' => 'কোন একটা এক্সটেনশন %s ব্যবহার করুন।',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'স্কিমা',
	'Alter schema' => 'স্কিমা পরিবর্তন করো',
	'Create schema' => 'স্কিমা তৈরী করো',
	'Schema has been dropped.' => 'স্কিমা মুছে ফেলা হয়েছে।',
	'Schema has been created.' => 'স্কিমা তৈরি করা হয়েছে।',
	'Schema has been altered.' => 'স্কিমা সম্পাদনা করা হয়েছে।',
	'Invalid schema.' => 'অবৈধ স্কিমা।',

	// Table list.
	'Engine' => 'ইঞ্জিন',
	'engine' => 'ইন্জিন',
	'Collation' => 'কলোকেশন',
	'collation' => 'সমষ্টি',
	'Data Length' => 'ডাটার দৈর্ঘ্য',
	'Index Length' => 'ইনডেক্স এর দৈর্ঘ্য',
	'Data Free' => 'তথ্য মুক্ত',
	'Rows' => 'সারিসমূহ',
	'%d in total' => 'সর্বমোটঃ %d টি',
	'Analyze' => 'বিশ্লেষণ',
	'Optimize' => 'অপটিমাইজ',
	'Vacuum' => 'ভ্যাকুয়াম',
	'Check' => 'পরীক্ষা',
	'Repair' => 'মেরামত',
	'Truncate' => 'ছাঁটাই',
	'Tables have been truncated.' => 'টেবিল ছাঁটাই করা হয়েছে।',
	'Move to other database' => 'অন্য ডাটাবেজে স্থানান্তর করুন',
	'Move' => 'স্থানান্তর করুন',
	'Tables have been moved.' => 'টেবিল স্থানান্তর করা হয়েছে।',
	'Copy' => 'কপি',
	'Tables have been copied.' => 'টেবিলগুলো কপি করা হয়েছে।',
	'overwrite' => 'ওভাররাইট',

	// Tables.
	'Tables' => 'টেবিলসমূহ',
	'Tables and views' => 'টেবিল এবং ভিউ সমূহ',
	'Table' => 'টেবিল',
	'No tables.' => 'কোন টেবিল নাই।',
	'Alter table' => 'টেবিল পরিবর্তন করুন',
	'Create table' => 'টেবিল তৈরী করুন',
	'Table has been dropped.' => 'টেবিল মুছে ফেলা হয়েছে।',
	'Tables have been dropped.' => 'টেবিলসমূহ মুছে ফেলা হয়েছে।',
	'Tables have been optimized.' => 'টেবিলগুলি অপ্টিমাইজ করা হয়েছে।',
	'Table has been altered.' => 'টেবিল পরিবর্তন করা হয়েছে।',
	'Table has been created.' => 'টেবিল তৈরী করা হয়েছে।',
	'Table name' => 'টেবিলের নাম',
	'Name' => 'নাম',
	'Show structure' => 'গঠন দেখান',
	'Column name' => 'কলামের নাম',
	'Type' => 'ধরণ',
	'Length' => 'দৈর্ঘ্য',
	'Auto Increment' => 'স্বয়ংক্রিয় বৃদ্ধি',
	'Options' => 'বিকল্পসমূহ',
	'Comment' => 'মন্তব্য',
	'Default value' => 'ডিফল্ট মান',
	'Drop' => 'মুছে ফেলো',
	'Drop %s?' => '%s ড্রপ করবেন?',
	'Are you sure?' => 'আপনি কি নিশ্চিত?',
	'Size' => 'আকার',
	'Compute' => 'কম্পিউট',
	'Move up' => 'উপরে স্থানান্তর',
	'Move down' => 'নীচে স্থানান্তর',
	'Remove' => 'মুছে ফেলুন',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'অনুমোদিত ফিল্ড এর সর্বাধিক সংখ্যা অতিক্রম করে গেছে। অনুগ্রহপূর্বক %s বৃদ্ধি করুন।',

	// Views.
	'View' => 'ভিউ',
	'Materialized view' => 'মেটেরিয়ালাইজড ভিউ',
	'View has been dropped.' => 'ভিউ মুছে ফেলা হয়েছে।',
	'View has been altered.' => 'ভিউ পরিবর্তন করা হয়েছে।',
	'View has been created.' => 'ভিউ তৈরী করা হয়েছে।',
	'Alter view' => 'ভিউ পরিবর্তন করুন',
	'Create view' => 'ভিউ তৈরী করুন',

	// Partitions.
	'Partition by' => 'পার্টিশন যার মাধ্যমে',
	'Partitions' => 'পার্টিশন',
	'Partition name' => 'পার্টিশনের নাম',
	'Values' => 'মানসমূহ',

	// Indexes.
	'Indexes' => 'সূচীসমূহ',
	'Indexes have been altered.' => 'সূচীসমূহ সম্পাদনা করা হয়েছে।',
	'Alter indexes' => 'সূচীসমূহ পরিবর্তন করুন',
	'Add next' => 'পরবর্তী সংযোজন করুন',
	'Index Type' => 'সূচী-ধরণ',
	'length' => 'দৈর্ঘ্য',

	// Foreign keys.
	'Foreign keys' => 'ফরেন কী',
	'Foreign key' => 'ফরেন কী ',
	'Foreign key has been dropped.' => 'ফরেন কী মুছে ফেলা হয়েছে।',
	'Foreign key has been altered.' => 'ফরেন কী পরিবর্তন করা হয়েছে।',
	'Foreign key has been created.' => 'ফরেন কী তৈরী করা হয়েছে।',
	'Target table' => 'টার্গেট টেবিল',
	'Change' => 'পরিবর্তন',
	'Source' => 'উৎস',
	'Target' => 'লক্ষ্য',
	'Add column' => 'কলাম সংযোজন করুন',
	'Alter' => 'পরিবর্তন',
	'Add foreign key' => 'ফরেন কী সংযোজন করুন',
	'ON DELETE' => 'অন ডিলিট',
	'ON UPDATE' => 'অন আপডেট',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'সোর্স এবং টার্গেট কলামে একই ডাটা টাইপ থাকতে হবে, টার্গেট কলামসমূহে একটি সূচী এবং রেফারেন্সড ডেটার উপস্থিতি থাকা আবশ্যক।',

	// Routines.
	'Routines' => 'রুটিনসমূহ',
	'Routine has been called, %d row(s) affected.' => [
		'রুটিন কল করা হয়েছে, %d টি সারি(সমূহ) প্রভাবিত হয়েছে।',
		'রুটিন কল করা হয়েছে, %d টি সারি(সমূহ) প্রভাবিত হয়েছে।',
	],
	'Call' => 'কল',
	'Parameter name' => 'প্যারামিটারের নাম',
	'Create procedure' => 'কার্যপ্রণালী তৈরী করুন',
	'Create function' => 'ফাংশন তৈরী করুন',
	'Routine has been dropped.' => 'রুটিন মুছে ফেলা হয়েছে।',
	'Routine has been altered.' => 'রুটিন পরিবর্তন করা হয়েছে।',
	'Routine has been created.' => 'রুটিন তৈরী করা হয়েছে।',
	'Alter function' => 'ফাংশন পরিবর্তন করুন',
	'Alter procedure' => 'কার্যপ্রণালী পরিবর্তন করুন',
	'Return type' => 'রিটার্ন টাইপ',

	// Events.
	'Events' => 'ইভেন্টসমূহ',
	'Event' => 'ইভেন্ট',
	'Event has been dropped.' => 'ইভেন্ট মুছে ফেলা হয়েছে।',
	'Event has been altered.' => 'ইভেন্ট সম্পাদনা করা হয়েছে।',
	'Event has been created.' => 'ইভেন্ট তৈরী করা হয়েছে।',
	'Alter event' => 'ইভেন্ট সম্পাদনা করো',
	'Create event' => 'ইভেন্ট তৈরী করো',
	'At given time' => 'প্রদত্ত সময়ে',
	'Every' => 'প্রত্যেক',
	'Schedule' => 'সময়সূচি',
	'Start' => 'শুরু',
	'End' => 'সমাপ্তি',
	'On completion preserve' => 'সমাপ্ত হওয়ার পর সংরক্ষন করুন',

	// Sequences (PostgreSQL).
	'Sequences' => 'অনুক্রম',
	'Create sequence' => 'অনুক্রম তৈরি করো',
	'Sequence has been dropped.' => 'অনুক্রম মুছে ফেলা হয়েছে।',
	'Sequence has been created.' => 'অনুক্রম তৈরি করা হয়েছে।',
	'Sequence has been altered.' => 'অনুক্রম সম্পাদনা করা হয়েছে।',
	'Alter sequence' => 'অনুক্রম সম্পাদনা করো',

	// User types (PostgreSQL)
	'User types' => 'ব্যবহারকারির ধরণ',
	'Create type' => 'ধরণ তৈরী করুন',
	'Type has been dropped.' => 'ধরণ মুছে ফেলা হয়েছে।',
	'Type has been created.' => 'ধরণ তৈরি করা হয়েছে।',
	'Alter type' => 'ধরণ পরিবর্তন করুন',

	// Triggers.
	'Triggers' => 'ট্রিগার',
	'Add trigger' => 'ট্রিগার সংযোজন করুন',
	'Trigger has been dropped.' => 'ট্রিগার মুছে ফেলা হয়েছে।',
	'Trigger has been altered.' => 'ট্রিগার পরিবর্তন করা হয়েছে।',
	'Trigger has been created.' => 'ট্রিগার তৈরী করা হয়েছে।',
	'Alter trigger' => 'ট্রিগার পরিবর্তন করুন',
	'Create trigger' => 'ট্রিগার তৈরী করুন',

	// Table check constraints.
	'Checks' => 'চেকস',
	'Create check' => 'চেক তৈরি করুন',
	'Alter check' => 'চেক পরিবর্তন করুন',
	'Check has been created.' => 'চেক তৈরি করা হয়েছে।',
	'Check has been altered.' => 'চেক পরিবর্তন করা হয়েছে।',
	'Check has been dropped.' => 'চেক ড্রপ করা হয়েছে।',

	// Selection.
	'Select data' => 'তথ্য নির্বাচন করো',
	'Select' => 'নির্বাচন',
	'Functions' => 'ফাংশন সমূহ',
	'Aggregation' => 'সমষ্টি',
	'Search' => 'খোঁজ',
	'anywhere' => 'যে কোন স্থানে',
	'Sort' => 'সাজানো',
	'descending' => 'ক্রমহ্রাস',
	'Limit' => 'সীমা',
	'Limit rows' => 'সারি সীমিত করুন',
	'Text length' => 'টেক্সট দৈর্ঘ্য',
	'Action' => 'ক্রিয়া',
	'Full table scan' => 'সম্পূর্ণ টেবিল স্ক্যান',
	'Unable to select the table' => 'টেবিল নির্বাচন করতে অক্ষম',
	'Search data in tables' => 'টেবিলে তথ্য খুঁজুন',
	'No rows.' => 'কোন সারি নাই।',
	'%d / ' => [
		'%d / ',
	],
	'%d row(s)' => [
		'%d সারি',
		'%d সারি সমূহ',
	],
	'Page' => 'পৃষ্ঠা',
	'last' => 'সর্বশেষ',
	'Load more data' => 'আরও ডেটা লোড করুন',
	'Loading' => 'লোড হচ্ছে',
	'Whole result' => 'সম্পূর্ণ ফলাফল',
	'%d byte(s)' => [
		'%d বাইট',
		'%d বাইটসমূহ',
	],

	// In-place editing in selection.
	'Modify' => 'পরিবর্তন করুন',
	'Ctrl+click on a value to modify it.' => 'একটি মান পরিবর্তন করতে Ctrl+ক্লিক করুন।',
	'Use edit link to modify this value.' => 'এই মানটি পরিবর্তনের জন্য সম্পাদনা লিঙ্ক ব্যবহার করুন।',

	// Editing.
	'New item' => 'নতুন বিষয়বস্তু',
	'Edit' => 'সম্পাদনা',
	'original' => 'প্রকৃত',
	// label for value '' in enum data type
	'empty' => 'খালি',
	'Insert' => 'সংযোজন',
	'Save' => 'সংরক্ষণ করুন',
	'Save and continue edit' => 'সংরক্ষণ করুন এবং সম্পাদনা চালিয়ে যান',
	'Save and insert next' => 'সংরক্ষন ও পরবর্তী সংযোজন করুন',
	'Saving' => 'সংরক্ষণ করা হচ্ছে',
	'Selected' => 'নির্বাচিত',
	'Clone' => 'ক্লোন',
	'Delete' => 'মুছে ফেলুন',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => 'বিষয়বস্তুসমূহ%s সংযোজন করা হয়েছে।',
	'Item has been deleted.' => 'বিষয়বস্তু মুছে ফেলা হয়েছে।',
	'Item has been updated.' => 'বিষয়বস্তু হালনাগাদ করা হয়েছে।',
	'%d item(s) have been affected.' => '%d টি বিষয়বস্তু প্রভাবিত হয়েছে।',
	'You have no privileges to update this table.' => 'এই টেবিল আপডেট করার জন্য আপনার কোন অনুমতি নেই।',

	// Data type descriptions.
	'Numbers' => 'সংখ্যা',
	'Date and time' => 'তারিখ এবং সময়',
	'Strings' => 'স্ট্রিং',
	'Binary' => 'বাইনারি',
	'Lists' => 'তালিকা',
	'Network' => 'নেটওয়ার্ক',
	'Geometry' => 'জ্যামিতি',
	'Relations' => 'সম্পর্ক',

	// Editor - data values.
	'now' => 'এখন',
	'yes' => 'হ্যাঁ',
	'no' => 'না',

	// Plugins.
];
