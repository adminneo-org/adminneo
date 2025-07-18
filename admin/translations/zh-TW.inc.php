<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1.$3.$5',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'YYYY.MM.DD',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => 'HH:MM:SS',

	// Bootstrap.

	// Login.
	'System' => '資料庫系統',
	'Server' => '伺服器',
	'Username' => '帳號',
	'Password' => '密碼',
	'Permanent login' => '永久登入',
	'Login' => '登入',
	'Logout' => '登出',
	'Logged as: %s' => '登錄為： %s',
	'Logout successful.' => '成功登出。',
	'There is a space in the input password which might be the cause.' => '您輸入的密碼中有一個空格，這可能是導致問題的原因。',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo預設不支援訪問沒有密碼的資料庫，<a href="https://www.adminneo.org/password"%s>詳情見這裡</a>。',
	'Database does not support password.' => '資料庫不支援密碼。',
	'Too many unsuccessful logins, try again in %d minute(s).' => '登錄失敗次數過多，請 %d 分鐘後重試。',
	'Invalid CSRF token. Send the form again.' => '無效的 CSRF token。請重新發送表單。',
	'If you did not send this request from AdminNeo then close this page.' => '如果您並沒有從AdminNeo發送請求，請關閉此頁面。',
	'The action will be performed after successful login with the same credentials.' => '此操作將在成功使用相同的憑據登錄後執行。',

	// Connection.
	'No extension' => '無擴充模組',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => '沒有任何支援的 PHP 擴充模組（%s）。',
	'Connecting to privileged ports is not allowed.' => '不允許連接到特權埠。',
	'Session support must be enabled.' => 'Session 必須被啟用。',
	'Session expired, please login again.' => 'Session 已過期，請重新登入。',
	'%s version: %s through PHP extension %s' => '%s 版本：%s 透過 PHP 擴充模組 %s',

	// Settings.
	'Language' => '語言',

	'Refresh' => '重新載入',

	// Privileges.
	'Privileges' => '權限',
	'Create user' => '建立使用者',
	'User has been dropped.' => '已刪除使用者。',
	'User has been altered.' => '已修改使用者。',
	'User has been created.' => '已建立使用者。',
	'Hashed' => 'Hashed',

	// Server.
	'Process list' => '處理程序列表',
	'%d process(es) have been killed.' => '%d 個 Process(es) 被終止。',
	'Kill' => '終止',
	'Variables' => '變數',
	'Status' => '狀態',

	// Structure.
	'Column' => '欄位',
	'Routine' => '程序',
	'Grant' => '授權',
	'Revoke' => '廢除',

	// Queries.
	'SQL command' => 'SQL 命令',
	'%d query(s) executed OK.' => '已順利執行 %d 個查詢。',
	'Query executed OK, %d row(s) affected.' => '執行查詢 OK，%d 行受影響。',
	'No commands to execute.' => '沒有命令可執行。',
	'Error in query' => '查詢發生錯誤',
	'Unknown error.' => '未知錯誤。',
	'Warnings' => '警告',
	'ATTACH queries are not supported.' => '不支援ATTACH查詢。',
	'Execute' => '執行',
	'Stop on error' => '出錯時停止',
	'Show only errors' => '僅顯示錯誤訊息',
	'Time' => '時間',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f 秒',
	'History' => '紀錄',
	'Clear' => '清除',
	'Edit all' => '編輯全部',

	// Import.
	'Import' => '匯入',
	'File upload' => '檔案上傳',
	'From server' => '從伺服器',
	'Webserver file %s' => '網頁伺服器檔案 %s',
	'Run file' => '執行檔案',
	'File does not exist.' => '檔案不存在。',
	'File uploads are disabled.' => '檔案上傳已經被停用。',
	'Unable to upload a file.' => '無法上傳檔案。',
	'Maximum allowed file size is %sB.' => '允許的檔案上限大小為 %sB。',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST 資料太大。減少資料或者增加 %s 的設定值。',
	'You can upload a big SQL file via FTP and import it from server.' => '您可以通過FTP上傳大型SQL檔並從伺服器導入。',
	'File must be in UTF-8 encoding.' => '檔必須使用UTF-8編碼。',
	'You are offline.' => '您離線了。',
	'%d row(s) have been imported.' => '已匯入 %d 行。',

	// Export.
	'Export' => '匯出',
	'Output' => '輸出',
	'open' => '打開',
	'save' => '儲存',
	'Format' => '格式',
	'Data' => '資料',

	// Databases.
	'Database' => '資料庫',
	'DB' => '資料庫',
	'Use' => '使用',
	'Invalid database.' => '無效的資料庫。',
	'Alter database' => '修改資料庫',
	'Create database' => '建立資料庫',
	'Database schema' => '資料庫結構',
	'Permanent link' => '永久連結',
	'Database has been dropped.' => '資料庫已刪除。',
	'Databases have been dropped.' => '資料庫已刪除。',
	'Database has been created.' => '已建立資料庫。',
	'Database has been renamed.' => '已重新命名資料庫。',
	'Database has been altered.' => '已修改資料庫。',
	// SQLite errors.
	'File exists.' => '檔案已存在。',
	'Please use one of the extensions %s.' => '請使用下列其中一個擴充模組 %s。',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => '資料表結構',
	'Alter schema' => '修改資料表結構',
	'Create schema' => '建立資料表結構',
	'Schema has been dropped.' => '已刪除資料表結構。',
	'Schema has been created.' => '已建立資料表結構。',
	'Schema has been altered.' => '已修改資料表結構。',
	'Invalid schema.' => '無效的資料表結構。',

	// Table list.
	'Engine' => '引擎',
	'engine' => '引擎',
	'Collation' => '校對',
	'collation' => '校對',
	'Data Length' => '資料長度',
	'Index Length' => '索引長度',
	'Data Free' => '資料空閒',
	'Rows' => '行數',
	'%d in total' => '總共 %d 個',
	'Analyze' => '分析',
	'Optimize' => '最佳化',
	'Vacuum' => '整理（Vacuum）',
	'Check' => '檢查',
	'Repair' => '修復',
	'Truncate' => '清空',
	'Tables have been truncated.' => '已清空資料表。',
	'Move to other database' => '轉移到其它資料庫',
	'Move' => '轉移',
	'Tables have been moved.' => '已轉移資料表。',
	'Copy' => '複製',
	'Tables have been copied.' => '資料表已經複製。',
	'overwrite' => '覆蓋',

	// Tables.
	'Tables' => '資料表',
	'Tables and views' => '資料表和檢視表',
	'Table' => '資料表',
	'No tables.' => '沒有資料表。',
	'Alter table' => '修改資料表',
	'Create table' => '建立資料表',
	'Table has been dropped.' => '已經刪除資料表。',
	'Tables have been dropped.' => '已經將資料表刪除。',
	'Tables have been optimized.' => '已優化資料表。',
	'Table has been altered.' => '資料表已修改。',
	'Table has been created.' => '資料表已建立。',
	'Table name' => '資料表名稱',
	'Name' => '名稱',
	'Show structure' => '顯示結構',
	'Column name' => '欄位名稱',
	'Type' => '類型',
	'Length' => '長度',
	'Auto Increment' => '自動遞增',
	'Options' => '選項',
	'Comment' => '註解',
	'Default value' => '預設值',
	'Drop' => '刪除',
	'Drop %s?' => '刪除 %s?',
	'Are you sure?' => '你確定嗎？',
	'Size' => '大小',
	'Compute' => '計算',
	'Move up' => '上移',
	'Move down' => '下移',
	'Remove' => '移除',
	'Maximum number of allowed fields exceeded. Please increase %s.' => '超過允許的字段數量的最大值。請增加 %s。',

	// Views.
	'View' => '檢視表',
	'Materialized view' => '物化視圖',
	'View has been dropped.' => '已刪除檢視表。',
	'View has been altered.' => '已修改檢視表。',
	'View has been created.' => '已建立檢視表。',
	'Alter view' => '修改檢視表',
	'Create view' => '建立檢視表',

	// Partitions.
	'Partition by' => '分區類型',
	'Partitions' => '分區',
	'Partition name' => '分區名稱',
	'Values' => '值',

	// Indexes.
	'Indexes' => '索引',
	'Indexes have been altered.' => '已修改索引。',
	'Alter indexes' => '修改索引',
	'Add next' => '新增下一筆',
	'Index Type' => '索引類型',
	'length' => '長度',

	// Foreign keys.
	'Foreign keys' => '外來鍵',
	'Foreign key' => '外來鍵',
	'Foreign key has been dropped.' => '已刪除外來鍵。',
	'Foreign key has been altered.' => '已修改外來鍵。',
	'Foreign key has been created.' => '已建立外來鍵。',
	'Target table' => '目標資料表',
	'Change' => '變更',
	'Source' => '來源',
	'Target' => '目標',
	'Add column' => '新增欄位',
	'Alter' => '修改',
	'Add foreign key' => '新增外來鍵',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => '來源列和目標列必須具有相同的資料類型，在目標列上必須有一個索引並且引用的資料必須存在。',

	// Routines.
	'Routines' => '程序',
	'Routine has been called, %d row(s) affected.' => '程序已被執行，%d 行被影響。',
	'Call' => '呼叫',
	'Parameter name' => '參數名稱',
	'Create procedure' => '建立預存程序',
	'Create function' => '建立函式',
	'Routine has been dropped.' => '已刪除程序。',
	'Routine has been altered.' => '已修改子程序。',
	'Routine has been created.' => '已建立子程序。',
	'Alter function' => '修改函式',
	'Alter procedure' => '修改預存程序',
	'Return type' => '回傳類型',

	// Events.
	'Events' => '事件',
	'Event' => '事件',
	'Event has been dropped.' => '已刪除事件。',
	'Event has been altered.' => '已修改事件。',
	'Event has been created.' => '已建立事件。',
	'Alter event' => '修改事件',
	'Create event' => '建立事件',
	'At given time' => '在指定時間',
	'Every' => '每',
	'Schedule' => '排程',
	'Start' => '開始',
	'End' => '結束',
	'On completion preserve' => '在完成後儲存',

	// Sequences (PostgreSQL).
	'Sequences' => '序列',
	'Create sequence' => '建立序列',
	'Sequence has been dropped.' => '已刪除序列。',
	'Sequence has been created.' => '已建立序列。',
	'Sequence has been altered.' => '已修改序列。',
	'Alter sequence' => '修改序列',

	// User types (PostgreSQL)
	'User types' => '使用者類型',
	'Create type' => '建立類型',
	'Type has been dropped.' => '已刪除類型。',
	'Type has been created.' => '已建立類型。',
	'Alter type' => '修改類型',

	// Triggers.
	'Triggers' => '觸發器',
	'Add trigger' => '建立觸發器',
	'Trigger has been dropped.' => '已刪除觸發器。',
	'Trigger has been altered.' => '已修改觸發器。',
	'Trigger has been created.' => '已建立觸發器。',
	'Alter trigger' => '修改觸發器',
	'Create trigger' => '建立觸發器',

	// Table check constraints.

	// Selection.
	'Select data' => '選擇資料',
	'Select' => '選擇',
	'Functions' => '函式',
	'Aggregation' => '集合',
	'Search' => '搜尋',
	'anywhere' => '任意位置',
	'Sort' => '排序',
	'descending' => '降冪 (遞減)',
	'Limit' => '限定',
	'Limit rows' => '限制行數',
	'Text length' => 'Text 長度',
	'Action' => '動作',
	'Full table scan' => '全資料表掃描',
	'Unable to select the table' => '無法選擇該資料表',
	'Search data in tables' => '在資料庫搜尋',
	'No rows.' => '沒有資料行。',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d 行',
	'Page' => '頁',
	'last' => '最後一頁',
	'Load more data' => '載入更多資料',
	'Loading' => '載入中',
	'Whole result' => '所有結果',
	'%d byte(s)' => '%d byte(s)',

	// In-place editing in selection.
	'Modify' => '修改',
	'Ctrl+click on a value to modify it.' => '按住Ctrl並按一下某個值進行修改。',
	'Use edit link to modify this value.' => '使用編輯連結來修改。',

	// Editing.
	'New item' => '新增項目',
	'Edit' => '編輯',
	'original' => '原始',
	// label for value '' in enum data type
	'empty' => '空值',
	'Insert' => '新增',
	'Save' => '儲存',
	'Save and continue edit' => '儲存並繼續編輯',
	'Save and insert next' => '儲存並新增下一筆',
	'Saving' => '保存中',
	'Selected' => '已選中',
	'Clone' => '複製',
	'Delete' => '刪除',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => '已新增項目 %s。',
	'Item has been deleted.' => '該項目已被刪除。',
	'Item has been updated.' => '已更新項目。',
	'%d item(s) have been affected.' => '%d 個項目受到影響。',
	'You have no privileges to update this table.' => '您沒有許可權更新這個資料表。',

	// Data type descriptions.
	'Numbers' => '數字',
	'Date and time' => '日期時間',
	'Strings' => '字串',
	'Binary' => '二進位',
	'Lists' => '列表',
	'Network' => '網路',
	'Geometry' => '幾何',
	'Relations' => '關聯',

	// Editor - data values.
	'now' => '現在',
	'yes' => '是',
	'no' => '否',

	// Plugins.
];
