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
	'Invalid CSRF token. Send the form again.' => 'เครื่องหมาย CSRF ไม่ถูกต้อง ส่งข้อมูลใหม่อีกครั้ง.',

	// Connection
	'No extension' => 'ไม่พบส่วนเสริม',
	'None of the supported PHP extensions (%s) are available.' => 'ไม่มีส่วนเสริมของ PHP (%s) ที่สามารถใช้งานได้.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Session support must be enabled.' => 'ต้องเปิดใช้งาน Session.',
	'Session expired, please login again.' => 'Session หมดอายุแล้ว กรุณาเข้าสู่ระบบใหม่อีกครั้ง.',
	'%s version: %s through PHP extension %s' => '%s รุ่น: %s ผ่านส่วนขยาย PHP %s',

	// Settings
	'Language' => 'ภาษา',

	'Refresh' => 'โหลดใหม่',

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
	'Routine' => 'รูทีน',
	'Grant' => 'การอนุญาต',
	'Revoke' => 'ยกเลิก',

	// Queries
	'SQL command' => 'คำสั่ง SQL',
	'%d query(s) executed OK.' => '%d คำสั่งถูกดำเนินการแล้ว.',
	'Query executed OK, %d row(s) affected.' => 'ประมวลผลคำสั่งแล้ว มี %d ถูกดำเนินการ.',
	'No commands to execute.' => 'ไม่มีคำสั่งที่จะประมวลผล.',
	'Error in query' => 'คำสั่งไม่ถูกต้อง',
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
	'From server' => 'จากเซเวอร์',
	'Webserver file %s' => 'Webserver file %s',
	'Run file' => 'ทำงานจากไฟล์',
	'File does not exist.' => 'ไม่มีไฟล์.',
	'File uploads are disabled.' => 'การอัปโหลดไฟล์ถูกปิดการใช้งาน.',
	'Unable to upload a file.' => 'ไม่สามารถอัปโหลดไฟล์ได้.',
	'Maximum allowed file size is %sB.' => 'ขนาดไฟล์สูงสุดที่อนุญาตให้ใช้งานคือ %sB.',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'ข้อมูลที่ส่งเข้ามีขนาดใหญ่เกิน คุณสามารถ เพิ่ม-ลดขนาดได้ที่ %s คำสั่งการตั้งค่า.',
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
	'Check' => 'ตรวจสอบ',
	'Repair' => 'ซ่อมแซม',
	'Truncate' => 'ตัดทิ้ง',
	'Tables have been truncated.' => 'เคลียร์ตารางแล้ว (truncate).',
	'Move to other database' => 'ย้ายไปยังฐานข้อมูลอื่น',
	'Move' => 'ย้าย',
	'Tables have been moved.' => 'ตารางถูกย้ายแล้ว.',
	'Copy' => 'ทำซ้ำ',
	'Tables have been copied.' => 'ทำซ้ำตารางฐานข้อมูลแล้ว.',

	// Tables
	'Tables' => 'ตาราง',
	'Tables and views' => 'ตารางและวิว',
	'Table' => 'ตาราง',
	'No tables.' => 'ไม่พบตาราง.',
	'Alter table' => 'เปลี่ยนแปลงตารางแล้ว',
	'Create table' => 'สร้างตารางใหม่',
	'Table has been dropped.' => 'ลบตารางแล้ว.',
	'Tables have been dropped.' => 'ตารางถูกลบแล้ว.',
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
	'Drop' => 'ลบ',
	'Are you sure?' => 'คุณแน่ใจแล้วหรือ',
	'Move up' => 'ย้ายไปข้างบน',
	'Move down' => 'ย้ายลงล่าง',
	'Remove' => 'ลบ',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'จำนวนสูงสุดของฟิลด์อนุญาตให้เกิน กรุณาเพิ่มอีก %s.',

	// Views
	'View' => 'วิว',
	'View has been dropped.' => 'วิวถูกลบแล้ว.',
	'View has been altered.' => 'วิวถูกเปลี่ยนแปลงแล้ว.',
	'View has been created.' => 'วิวถูกสร้างแล้ว.',
	'Alter view' => 'เปลี่ยนแปลงวิว',
	'Create view' => 'เพิ่มวิว',

	// Partitions
	'Partition by' => 'พาร์ทิชันโดย',
	'Partitions' => 'พาร์ทิชัน',
	'Partition name' => 'ชื่อของพาร์ทิชัน',
	'Values' => 'ค่า',

	// Indexes
	'Indexes' => 'ดัชนี',
	'Indexes have been altered.' => 'เปลี่ยนแปลงดัชนีแล้ว.',
	'Alter indexes' => 'เปลี่ยนแปลงดัชนี',
	'Add next' => 'เพิ่มรายการถัดไป',
	'Index Type' => 'ชนิดของดัชนี',
	'length' => 'ความยาว',

	// Foreign keys
	'Foreign keys' => 'คีย์คู่แข่ง',
	'Foreign key' => 'คีย์คู่แข่ง',
	'Foreign key has been dropped.' => 'คีย์คู่แข่งถูกลบแล้ว.',
	'Foreign key has been altered.' => 'คีย์คู่แข่งถูกเปลี่ยนแปลงแล้ว.',
	'Foreign key has been created.' => 'คีย์คู่แข่งถูกสร้างแล้ว.',
	'Target table' => 'คารางเป้าหมาย',
	'Change' => 'แก้ไข',
	'Source' => 'แหล่งข้อมูล',
	'Target' => 'เป้าหมาย',
	'Add column' => 'เพิ่มคอลัมน์',
	'Alter' => 'เปลี่ยนแปลง',
	'Add foreign key' => 'เพิ่มคีย์คู่แข่ง',
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

	// User types (PostgreSQL)
	'User types' => 'ประเภทผู้ใช้งาน',
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
	'Text length' => 'ความยาวของอักษร',
	'Action' => 'ดำเนินการ',
	'Unable to select the table' => 'ไม่สามารถเลือกตารางได้',
	'Search data in tables' => 'ค้นหาในตาราง',
	'No rows.' => 'ไม่มีแถวของตาราง.',
	'%d row(s)' => '%d แถว',
	'Page' => 'หน้า',
	'last' => 'ล่าสุด',
	'Whole result' => 'รวมผล',
	'%d byte(s)' => '%d ไบท์',

	// In-place editing in selection
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
	'Clone' => 'ทำซ้ำ',
	'Delete' => 'ลบ',
	'Item%s has been inserted.' => 'มี%s รายการ ถูกเพิ่มแล้ว.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'รายการถูกลบแล้ว.',
	'Item has been updated.' => 'ปรับปรุงรายการแล้ว.',
	'%d item(s) have been affected.' => 'มี %d รายการถูกดำเนินการแล้ว.',

	// Data type descriptions
	'Numbers' => 'ตัวเลข',
	'Date and time' => 'วันและเวลา',
	'Strings' => 'ตัวอักษร',
	'Binary' => 'เลขฐานสอง',
	'Lists' => 'รายการ',
	'Network' => 'เครื่องข่าย',
	'Geometry' => 'เรขาคณิต',
	'Relations' => 'ความสำพันธ์',

	// Editor - data values
	'now' => 'ตอนนี้',

	// Settings

	// Plugins
];
