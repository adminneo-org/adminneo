<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'วันที่/เดือน/ปี', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s ต้องคืนค่าเป็นอาร์เรย์.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s และ %s ต้องคืนค่าเป็นอ็อบเจกต์ที่สร้างโดยเมธอด %s.', // by Claude Fable 5.1

	// Login
	'System' => 'ระบบ',
	'Server' => 'เซอเวอร์',
	'Username' => 'ชื่อผู้ใช้งาน',
	'Password' => 'รหัสผ่าน',
	'Permanent login' => 'จดจำการเข้าสู่ระบบตลอดไป',
	'Login' => 'เข้าสู่ระบบ',
	'Logout' => 'ออกจากระบบ',
	'Logged as: %s' => 'สวัสดีคุณ: %s',
	'Logout successful.' => 'ออกจากระบบเรียบร้อยแล้ว.',
	'hostname[:port] or :socket' => 'ชื่อโฮสต์[:พอร์ต] หรือ :ซ็อกเก็ต', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'เซอเวอร์หรือข้อมูลเข้าสู่ระบบไม่ถูกต้อง.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'มีช่องว่างในรหัสผ่านที่กรอก ซึ่งอาจเป็นสาเหตุ.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo ไม่รองรับการเข้าถึงฐานข้อมูลโดยไม่มีรหัสผ่าน <a href="https://www.adminneo.org/password"%s>ข้อมูลเพิ่มเติม</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'ฐานข้อมูลไม่รองรับรหัสผ่าน.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => 'เข้าสู่ระบบไม่สำเร็จหลายครั้งเกินไป กรุณาลองใหม่อีกครั้งใน %d นาที.', // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => 'การจดจำการเข้าสู่ระบบไม่ถูกต้อง กรุณาเข้าสู่ระบบใหม่อีกครั้ง.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'เครื่องหมาย CSRF ไม่ถูกต้อง ส่งข้อมูลใหม่อีกครั้ง.',
	'If you did not send this request from AdminNeo then close this page.' => 'หากคุณไม่ได้ส่งคำขอนี้จาก AdminNeo กรุณาปิดหน้านี้.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'การดำเนินการจะทำงานหลังจากเข้าสู่ระบบสำเร็จด้วยข้อมูลเดิม.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'ไม่พบส่วนเสริม',
	'None of the supported PHP extensions (%s) are available.' => 'ไม่มีส่วนเสริมของ PHP (%s) ที่สามารถใช้งานได้.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'ไม่อนุญาตให้เชื่อมต่อกับพอร์ตที่สงวนไว้.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'ต้องเปิดใช้งาน Session.',
	'Session expired, please login again.' => 'Session หมดอายุแล้ว กรุณาเข้าสู่ระบบใหม่อีกครั้ง.',
	'%s version: %s through PHP extension %s' => '%s รุ่น: %s ผ่านส่วนขยาย PHP %s',

	// Settings
	'Language' => 'ภาษา',

	'Menu' => 'เมนู', // by Claude Fable 5.1
	'Home' => 'หน้าแรก', // by Claude Fable 5.1
	'Refresh' => 'โหลดใหม่',
	'Info' => 'ข้อมูล', // by Claude Fable 5.1
	'More information.' => 'ข้อมูลเพิ่มเติม.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'สิทธิ์',
	'Create user' => 'สร้างผู้ใช้งาน',
	'User has been dropped.' => 'ลบผู้ใช้งานแล้ว.',
	'User has been altered.' => 'เปลี่ยนแปลงผู้ใช้งานแล้ว.',
	'User has been created.' => 'สร้างผู้ใช้งานแล้ว.',
	'Hashed' => 'Hash',

	// Server
	'Process list' => 'รายการของกระบวนการ',
	'%d process(es) have been killed.' => 'มี %d กระบวนการถูกทำลายแล้ว.',
	'Kill' => 'ทำลาย',
	'Variables' => 'ตัวแปร',
	'Status' => 'สถานะ',

	// Structure
	'Column' => 'คอลัมน์',
	'Columns' => 'คอลัมน์', // by Claude Fable 5.1
	'Routine' => 'รูทีน',
	'Grant' => 'การอนุญาต',
	'Revoke' => 'ยกเลิก',

	// Queries
	'SQL command' => 'คำสั่ง SQL',
	'HTTP request' => 'คำขอ HTTP', // by Claude Fable 5.1
	'%d query(s) executed OK.' => '%d คำสั่งถูกดำเนินการแล้ว.',
	'Query executed OK, %d row(s) affected.' => 'ประมวลผลคำสั่งแล้ว มี %d ถูกดำเนินการ.',
	'No commands to execute.' => 'ไม่มีคำสั่งที่จะประมวลผล.',
	'Error in query' => 'คำสั่งไม่ถูกต้อง',
	'Unknown error.' => 'ข้อผิดพลาดที่ไม่รู้จัก.', // by Claude Fable 5.1
	'Warnings' => 'คำเตือน', // by Claude Fable 5.1
	'%s queries are not supported.' => 'ไม่รองรับคำสั่ง %s.', // by Claude Fable 5.1
	'Execute' => 'ประมวลผล',
	'Stop on error' => 'หยุดการทำงานเมื่อเออเรอ',
	'Show only errors' => 'แสดงเฉพาะเออเรอ',
	'Time' => 'เวลา',
	'%.3f s' => '%.3f วินาที', // sprintf() format for time of the command
	'History' => 'ประวัติ',
	'Clear' => 'เคลียร์',
	'Edit all' => 'แก้ไขทั้งหมด',

	// Import
	'Import' => 'นำเข้า',
	'File upload' => 'อัปโหลดไฟล์',
	'From server' => 'จากเซอเวอร์', // by Claude Fable 5.1
	'Webserver file %s' => 'Webserver file %s',
	'Run file' => 'ทำงานจากไฟล์',
	'File does not exist.' => 'ไม่มีไฟล์.',
	'File uploads are disabled.' => 'การอัปโหลดไฟล์ถูกปิดการใช้งาน.',
	'Unable to upload a file.' => 'ไม่สามารถอัปโหลดไฟล์ได้.',
	'Maximum allowed file size is %sB.' => 'ขนาดไฟล์สูงสุดที่อนุญาตให้ใช้งานคือ %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'จำนวนไฟล์สูงสุดคือ %d เลือกไฟล์ให้น้อยลงหรือเพิ่มค่าของคำสั่งการตั้งค่า %s.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'ขนาดรวมของไฟล์สูงสุดคือ %s เลือกไฟล์ที่เล็กลงหรือเพิ่มค่าของคำสั่งการตั้งค่า %s.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'ข้อมูลที่ส่งเข้ามีขนาดใหญ่เกิน คุณสามารถ เพิ่ม-ลดขนาดได้ที่ %s คำสั่งการตั้งค่า.',
	'You can upload a big SQL file via FTP and import it from server.' => 'คุณสามารถอัปโหลดไฟล์ SQL ขนาดใหญ่ผ่าน FTP แล้วนำเข้าจากเซอเวอร์.', // by Claude Fable 5.1
	'File must be in UTF-8 encoding.' => 'ไฟล์ต้องอยู่ในรูปแบบการเข้ารหัส UTF-8.', // by Claude Fable 5.1
	'You are offline.' => 'คุณออฟไลน์อยู่.', // by Claude Fable 5.1
	'%d row(s) have been imported.' => '%d แถวถูกนำเข้าแล้ว.',

	// Export
	'Export' => 'ส่งออก',
	'Output' => 'ข้อมูลที่ส่งออก',
	'open' => 'เปิด',
	'save' => 'บันทึก',
	'Format' => 'รูปแบบ',
	'Data' => 'ข้อมูล',

	// Databases
	'Database' => 'ฐานข้อมูล',
	'database' => 'ฐานข้อมูล', // by Claude Fable 5.1
	'DB' => 'ฐานข้อมูล', // by Claude Fable 5.1
	'Use' => 'ใช้งาน',
	'Invalid database.' => 'ฐานข้อมูลไม่ถูกต้อง.',
	'Alter database' => 'เปลี่ยนแปลงฐานข้อมูล',
	'Create database' => 'สร้างฐานข้อมูล',
	'Database schema' => 'Schema ของฐานข้อมูล',
	'Permanent link' => 'ลิงค์ถาวร',
	'Database has been dropped.' => 'ฐานข้อมูลถูกลบแล้ว.',
	'Databases have been dropped.' => 'ฐานข้อมูลถูกลบแล้ว.',
	'Database has been created.' => 'สร้างฐานข้อมูลใหม่แล้ว.',
	'Database has been renamed.' => 'เปลี่ยนชื่อฐานข้อมูลแล้ว.',
	'Database has been altered.' => 'เปลี่ยนแปลงฐานข้อมูลแล้ว.',

	// SQLite errors
	'File exists.' => 'มีไฟล์นี้อยู่แล้ว.',
	'Please use one of the extensions %s.' => 'กรุณาใช้ส่วนเสริมอย่างน้อย 1 ส่วนเสริมจากทั้งหมด %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Schema',
	'schema' => 'schema', // by Claude Fable 5.1
	'Schemas' => 'Schema', // by Claude Fable 5.1
	'No schemas.' => 'ไม่พบ schema.', // by Claude Fable 5.1
	'Show schema' => 'แสดง schema', // by Claude Fable 5.1
	'Alter schema' => 'เปลี่ยนแปลง schema',
	'Create schema' => 'สร้าง schema',
	'Schema has been dropped.' => 'Schema ถูกลบแล้ว.',
	'Schema has been created.' => 'Schema ถูกสร้างแล้ว.',
	'Schema has been altered.' => 'Schema ถูกเปลี่ยนแปลงแล้ว.',
	'Invalid schema.' => 'schema ไม่ถูกต้อง.',

	// Table list
	'Engine' => 'ชนิดของฐานข้อมูล',
	'engine' => 'ชนิดของฐานข้อมูล',
	'Collation' => 'การตรวจทาน',
	'collation' => 'การตรวจทาน',
	'Data Length' => 'ความยาวของข้อมูล',
	'Index Length' => 'ความยาวของดัชนี',
	'Data Free' => 'พื้นที่ว่าง',
	'Rows' => 'แถว',
	'%d in total' => '%d ของทั้งหมด',
	'Analyze' => 'วิเคราะห์',
	'Optimize' => 'เพิ่มประสิทธิภาพ',
	'Vacuum' => 'ล้างข้อมูล (VACUUM)', // by Claude Fable 5.1
	'Check' => 'ตรวจสอบ',
	'Repair' => 'ซ่อมแซม',
	'Truncate' => 'ตัดทิ้ง',
	'Truncate Cascade' => 'ตัดทิ้งแบบลูกโซ่', // by Claude Fable 5.1
	'Tables have been truncated.' => 'เคลียร์ตารางแล้ว (truncate).',
	'Move to other database' => 'ย้ายไปยังฐานข้อมูลอื่น',
	'Move' => 'ย้าย',
	'Tables have been moved.' => 'ตารางถูกย้ายแล้ว.',
	'Copy' => 'ทำซ้ำ',
	'Tables have been copied.' => 'ทำซ้ำตารางฐานข้อมูลแล้ว.',
	'overwrite' => 'เขียนทับ', // by Claude Fable 5.1

	// Tables
	'Tables' => 'ตาราง',
	'Tables and views' => 'ตารางและวิว',
	'Table' => 'ตาราง',
	'No tables.' => 'ไม่พบตาราง.',
	'Alter table' => 'เปลี่ยนแปลงตาราง', // by Claude Fable 5.1
	'Create table' => 'สร้างตารางใหม่',
	'Table has been dropped.' => 'ลบตารางแล้ว.',
	'Tables have been dropped.' => 'ตารางถูกลบแล้ว.',
	'Tables have been optimized.' => 'เพิ่มประสิทธิภาพตารางแล้ว.', // by Claude Fable 5.1
	'Table has been altered.' => 'แก้ไขตารางแล้ว.',
	'Table has been created.' => 'สร้างตารางใหม่แล้ว.',
	'Table name' => 'ชื่อตาราง',
	'Name' => 'ชื่อ',
	'Show structure' => 'แสดงโครงสร้าง',
	'Column name' => 'ชื่อคอลัมน์',
	'Type' => 'ชนิด',
	'Length' => 'ความยาว',
	'Auto Increment' => 'เพิ่มลำดับโดยอัตโนมัติ',
	'Options' => 'ตัวเลือก',
	'Comment' => 'หมายเหตุ',
	'Default value' => 'ค่าเริ่มต้น', // by Claude Fable 5.1
	'Drop' => 'ลบ',
	'Drop %s?' => 'ลบ %s หรือไม่?', // by Claude Fable 5.1
	'Are you sure?' => 'คุณแน่ใจแล้วหรือ',
	'Size' => 'ขนาด', // by Claude Fable 5.1
	'Compute' => 'คำนวณ', // by Claude Fable 5.1
	'Move up' => 'ย้ายไปข้างบน',
	'Move down' => 'ย้ายลงล่าง',
	'Remove' => 'ลบ',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'จำนวนสูงสุดของฟิลด์อนุญาตให้เกิน กรุณาเพิ่มอีก %s.',

	// Views
	'View' => 'วิว',
	'Materialized view' => 'วิวแบบเก็บข้อมูล', // by Claude Fable 5.1
	'View has been dropped.' => 'วิวถูกลบแล้ว.',
	'View has been altered.' => 'วิวถูกเปลี่ยนแปลงแล้ว.',
	'View has been created.' => 'วิวถูกสร้างแล้ว.',
	'Alter view' => 'เปลี่ยนแปลงวิว',
	'Create view' => 'เพิ่มวิว',

	// Partitions
	'Partition by' => 'พาร์ทิชันโดย',
	'Partition' => 'พาร์ทิชัน', // by Claude Fable 5.1
	'Partitions' => 'พาร์ทิชัน',
	'Partition name' => 'ชื่อของพาร์ทิชัน',
	'Values' => 'ค่า',
	'Inherited tables' => 'ตารางที่สืบทอด', // by Claude Fable 5.1
	'Inherited from' => 'สืบทอดจาก', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'ดัชนี',
	'Indexes have been altered.' => 'เปลี่ยนแปลงดัชนีแล้ว.',
	'Alter indexes' => 'เปลี่ยนแปลงดัชนี',
	'Add next' => 'เพิ่มรายการถัดไป',
	'Index Type' => 'ชนิดของดัชนี',
	'length' => 'ความยาว',
	'operator class' => 'คลาสตัวดำเนินการ', // by Claude Fable 5.1
	'Algorithm' => 'อัลกอริทึม', // by Claude Fable 5.1
	'Condition' => 'เงื่อนไข', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'คีย์นอก', // by Claude Fable 5.1
	'Foreign key' => 'คีย์นอก', // by Claude Fable 5.1
	'Foreign key has been dropped.' => 'คีย์นอกถูกลบแล้ว.', // by Claude Fable 5.1
	'Foreign key has been altered.' => 'คีย์นอกถูกเปลี่ยนแปลงแล้ว.', // by Claude Fable 5.1
	'Foreign key has been created.' => 'คีย์นอกถูกสร้างแล้ว.', // by Claude Fable 5.1
	'Target table' => 'ตารางเป้าหมาย', // by Claude Fable 5.1
	'Change' => 'แก้ไข',
	'Source' => 'แหล่งข้อมูล',
	'Target' => 'เป้าหมาย',
	'Add column' => 'เพิ่มคอลัมน์',
	'Alter' => 'เปลี่ยนแปลง',
	'Add foreign key' => 'เพิ่มคีย์นอก', // by Claude Fable 5.1
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'แหล่งที่มาและเป้าหมายของคอลมัน์ต้องมีชนิดข้อมูลเดียวกัน คือต้องมีดัชนีและข้อมูลอ้างอิงของคอลัมน์เป้าหมาย.',

	// Routines
	'Routines' => 'รูทีน',
	'Routine has been called, %d row(s) affected.' => 'รูทีนถูกเรียกใช้งาน มี %d แถวถูกดำเนินการ.',
	'Call' => 'เรียกใช้งาน',
	'Parameter name' => 'ชื่อพารามิเตอร์',
	'Create procedure' => 'สร้าง procedure',
	'Create function' => 'สร้าง Function',
	'Routine has been dropped.' => 'Routine ถูกลบแล้ว.',
	'Routine has been altered.' => 'Routine ถูกเปลี่ยนแปลงแล้ว.',
	'Routine has been created.' => 'Routine ถูกสร้างแล้ว.',
	'Alter function' => 'เปลี่ยนแปลง Function',
	'Alter procedure' => 'เปลี่ยนแปลง procedure',
	'Return type' => 'ประเภทของค่าที่คืนกลับ',

	// Events
	'Events' => 'เหตุการณ์',
	'Event' => 'เหตุการณ์',
	'Event has been dropped.' => 'เหตุการณ์ถูกลบแล้ว.',
	'Event has been altered.' => 'เหตุการณ์ถูกเปลี่ยนแปลงแล้ว.',
	'Event has been created.' => 'เหตุการณ์ถูกสร้างแล้ว.',
	'Alter event' => 'เปลี่ยนแปลงเหตุการณ์',
	'Create event' => 'สร้างเหตุการณ์',
	'At given time' => 'ในเวลาที่กำหนด',
	'Every' => 'ทุกๆ',
	'Schedule' => 'กำหนดการณ์',
	'Start' => 'เริ่มต้น',
	'End' => 'สิ้นสุด',
	'On completion preserve' => 'เมื่อเสร็จสิ้นการสงวน',

	// Sequences (PostgreSQL)
	'Sequences' => 'Sequences',
	'Create sequence' => 'Sequence ถูกสร้างแล้ว',
	'Sequence has been dropped.' => 'Sequence ถูกลบแล้ว.',
	'Sequence has been created.' => 'Sequence ถูกสร้างแล้ว.',
	'Sequence has been altered.' => 'Sequence ถูกเปลี่ยนแปลงแล้ว.',
	'Alter sequence' => 'Sequence ถูกเปลี่ยนแปลงแล้ว',

	// User-defined types (PostgreSQL)
	'User types' => 'ประเภทข้อมูลที่ผู้ใช้กำหนด', // by Claude Fable 5.1
	'Create type' => 'สร้างประเภทผู้ใช้งาน',
	'Type has been dropped.' => 'ประเภทถูกลบแล้ว.',
	'Type has been created.' => 'ประเภทถูกสร้างแล้ว.',
	'Alter type' => 'แก้ไขประเภท',

	// Triggers
	'Triggers' => 'ทริกเกอร์',
	'Add trigger' => 'เพิ่ม trigger',
	'Trigger has been dropped.' => 'Trigger ถูกลบแล้ว.',
	'Trigger has been altered.' => 'Trigger ถูกเปลี่ยนแปลงแล้ว.',
	'Trigger has been created.' => 'Trigger ถูกสร้างแล้ว.',
	'Alter trigger' => 'เปลี่ยนแปลง Trigger',
	'Create trigger' => 'สร้าง Trigger',

	// Table check constraints
	'Checks' => 'การตรวจสอบ', // by Claude Fable 5.1
	'Create check' => 'สร้างการตรวจสอบ', // by Claude Fable 5.1
	'Alter check' => 'เปลี่ยนแปลงการตรวจสอบ', // by Claude Fable 5.1
	'Check has been created.' => 'สร้างการตรวจสอบแล้ว.', // by Claude Fable 5.1
	'Check has been altered.' => 'เปลี่ยนแปลงการตรวจสอบแล้ว.', // by Claude Fable 5.1
	'Check has been dropped.' => 'ลบการตรวจสอบแล้ว.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'เลือกข้อมูล',
	'Select' => 'เลือก',
	'Functions' => 'ฟังก์ชั่น',
	'Aggregation' => 'รวบรวม',
	'Search' => 'ค้นหา',
	'anywhere' => 'ทุกแห่ง',
	'Sort' => 'เรียงลำดับ',
	'descending' => 'มากไปน้อย',
	'Limit' => 'จำกัด',
	'Limit rows' => 'จำกัดแถว', // by Claude Fable 5.1
	'Text length' => 'ความยาวของอักษร',
	'Action' => 'ดำเนินการ',
	'Full table scan' => 'การสแกนทั้งตาราง', // by Claude Fable 5.1
	'Unable to select the table' => 'ไม่สามารถเลือกตารางได้',
	'Search data in tables' => 'ค้นหาในตาราง',
	'No rows.' => 'ไม่มีแถวของตาราง.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => '%d แถว',
	'Page' => 'หน้า',
	'last' => 'ล่าสุด',
	'Load more data' => 'โหลดข้อมูลเพิ่ม', // by Claude Fable 5.1
	'Loading' => 'กำลังโหลด', // by Claude Fable 5.1
	'Whole result' => 'รวมผล',
	'%d byte(s)' => '%d ไบท์',

	// In-place editing in selection
	'Modify' => 'ปรับเปลี่ยน', // by Claude Fable 5.1
	'Ctrl+click on a value to modify it.' => 'กด Ctrl+click เพื่อแก้ไขค่า.',
	'Use edit link to modify this value.' => 'ใช้ลิงค์ แก้ไข เพื่อปรับเปลี่ยนค่านี้.',

	// Editing
	'New item' => 'รายการใหม่',
	'Edit' => 'แก้ไข',
	'original' => 'ต้นฉบับ',
	'empty' => 'ว่างเปล่า', // label for value '' in enum data type
	'Insert' => 'เพิ่ม',
	'Save' => 'บันทึก',
	'Save and continue edit' => 'บันทึกและแก้ไขข้อมูลอื่นๆต่อ',
	'Save and insert next' => 'บันทึกแล้วเพิ่มรายการถัดไป',
	'Saving' => 'กำลังบันทึก', // by Claude Fable 5.1
	'Selected' => 'ที่เลือก', // by Claude Fable 5.1
	'Clone' => 'ทำซ้ำ',
	'Delete' => 'ลบ',
	'Item%s has been inserted.' => 'มี%s รายการ ถูกเพิ่มแล้ว.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'รายการถูกลบแล้ว.',
	'Item has been updated.' => 'ปรับปรุงรายการแล้ว.',
	'%d item(s) have been affected.' => 'มี %d รายการถูกดำเนินการแล้ว.',
	'You have no privileges to update this table.' => 'คุณไม่มีสิทธิ์แก้ไขตารางนี้.', // by Claude Fable 5.1

	// Data type descriptions
	'Numbers' => 'ตัวเลข',
	'Date and time' => 'วันและเวลา',
	'Strings' => 'ตัวอักษร',
	'Binary' => 'เลขฐานสอง',
	'Lists' => 'รายการ',
	'Network' => 'เครือข่าย', // by Claude Fable 5.1
	'Geometry' => 'เรขาคณิต',
	'Relations' => 'ความสัมพันธ์', // by Claude Fable 5.1

	// Editor - data values
	'now' => 'ตอนนี้',
	'yes' => 'ใช่', // by Claude Fable 5.1
	'no' => 'ไม่ใช่', // by Claude Fable 5.1

	// Settings
	'Settings' => 'การตั้งค่า', // by Claude Fable 5.1
	'Default' => 'ค่าเริ่มต้น', // by Claude Fable 5.1
	'Color scheme' => 'ชุดสี', // by Claude Fable 5.1
	'By system' => 'ตามระบบ', // by Claude Fable 5.1
	'Light' => 'สว่าง', // by Claude Fable 5.1
	'Dark' => 'มืด', // by Claude Fable 5.1
	'Navigation mode' => 'รูปแบบการนำทาง', // by Claude Fable 5.1
	'Simple' => 'แบบง่าย', // by Claude Fable 5.1
	'Dual' => 'แบบคู่', // by Claude Fable 5.1
	'Dual on hover' => 'แบบคู่เมื่อชี้เมาส์', // by Claude Fable 5.1
	'Reversed' => 'แบบกลับด้าน', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'การจัดวางของการนำทางหลักพร้อมลิงค์ของตาราง.', // by Claude Fable 5.1
	'Table links' => 'ลิงค์ของตาราง', // by Claude Fable 5.1
	'Primary action for all table links.' => 'การดำเนินการหลักสำหรับลิงค์ของตารางทั้งหมด.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'ลิงค์ไปยังตารางที่อ้างอิงถึงแถวปัจจุบัน.', // by Claude Fable 5.1
	'Display' => 'แสดง', // by Claude Fable 5.1
	'Hide' => 'ซ่อน', // by Claude Fable 5.1
	'Records per page' => 'จำนวนรายการต่อหน้า', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'จำนวนรายการเริ่มต้นที่แสดงในตารางข้อมูล.', // by Claude Fable 5.1
	'Enum as select' => 'แสดง enum เป็นรายการให้เลือก', // by Claude Fable 5.1
	'Never' => 'ไม่แสดง', // by Claude Fable 5.1
	'Always' => 'แสดงเสมอ', // by Claude Fable 5.1
	'More values than %d' => 'มีค่ามากกว่า %d', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'เกณฑ์ในการแสดงรายการให้เลือกสำหรับคอลัมน์ enum.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'รหัสผ่านครั้งเดียว', // by Claude Fable 5.1
	'Enter OTP code.' => 'กรอกรหัส OTP.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'รหัส OTP ไม่ถูกต้อง.', // by Claude Fable 5.1
	'Access denied.' => 'ไม่มีสิทธิ์เข้าถึง.', // by Claude Fable 5.1
	'JSON previews' => 'ตัวอย่าง JSON', // by Claude Fable 5.1
	'Data table' => 'ตารางข้อมูล', // by Claude Fable 5.1
	'Edit form' => 'ฟอร์มแก้ไข', // by Claude Fable 5.1
	'Ask %s' => 'ถาม %s', // by Claude Fable 5.1
];
