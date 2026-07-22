<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1.$3.$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY.MM.DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s 必须返回一个数组。', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s 和 %s 必须返回由 %s 方法创建的对象。', // by Claude Opus 5

	// Login
	'System' => '系统',
	'Server' => '服务器',
	'Username' => '用户名',
	'Password' => '密码',
	'Permanent login' => '保持登录',
	'Login' => '登录',
	'Logout' => '登出',
	'Logged as: %s' => '登录用户：%s',
	'Logout successful.' => '成功登出。',
	'hostname[:port] or :socket' => 'hostname[:port] 或 :socket', // by Claude Fable 5
	'Invalid server or credentials.' => '无效的服务器或登录凭据。', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => '您输入的密码中有一个空格，这可能是导致问题的原因。',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo默认不支持访问没有密码的数据库，<a href="https://www.adminneo.org/password"%s>详情见这里</a>。',
	'Database does not support password.' => '数据库不支持密码。',
	'Too many unsuccessful logins, try again in %d minute(s).' => '登录失败次数过多，请 %d 分钟后重试。',
	'Invalid permanent login, please login again.' => '保持登录无效，请重新登录。', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => '无效 CSRF 令牌。请重新发送表单。',
	'If you did not send this request from AdminNeo then close this page.' => '如果您并没有从 AdminNeo 发送请求，请关闭此页面。', // by Claude Opus 5
	'The action will be performed after successful login with the same credentials.' => '此操作将在成功使用相同的凭据登录后执行。',

	// Connection
	'No extension' => '没有扩展',
	'None of the supported PHP extensions (%s) are available.' => '没有支持的 PHP 扩展可用（%s）。', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => '不允许连接到特权端口。',
	'Session support must be enabled.' => '必须启用会话支持。',
	'Session expired, please login again.' => '会话已过期，请重新登录。',
	'%s version: %s through PHP extension %s' => '%s 版本：%s， 使用PHP扩展 %s',

	// Settings
	'Language' => '语言',

	'Home' => '首页', // by Claude Opus 5
	'Refresh' => '刷新',
	'Info' => '信息', // by Claude Opus 5
	'More information.' => '更多信息。', // by Claude Opus 5

	// Privileges
	'Privileges' => '权限',
	'Create user' => '创建用户',
	'User has been dropped.' => '已删除用户。',
	'User has been altered.' => '已修改用户。',
	'User has been created.' => '已创建用户。',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => '进程列表',
	'%d process(es) have been killed.' => '%d 个进程被终止。',
	'Kill' => '终止',
	'Variables' => '变量',
	'Status' => '状态',

	// Structure
	'Column' => '列',
	'Columns' => '列', // by Claude Fable 5
	'Routine' => '子程序',
	'Grant' => '授权',
	'Revoke' => '废除',

	// Queries
	'SQL command' => 'SQL命令',
	'HTTP request' => 'HTTP请求', // by Claude Opus 5
	'%d query(s) executed OK.' => '%d 条查询已成功执行。',
	'Query executed OK, %d row(s) affected.' => '查询执行完毕，%d 行受影响。',
	'No commands to execute.' => '没有命令被执行。',
	'Error in query' => '查询出错',
	'Unknown error.' => '未知错误。',
	'Warnings' => '警告',
	'%s queries are not supported.' => '不支持%s查询。',
	'Execute' => '执行',
	'Stop on error' => '出错时停止',
	'Show only errors' => '仅显示错误',
	'Time' => '时间',
	'%.3f s' => '%.3f 秒', // sprintf() format for time of the command
	'History' => '历史',
	'Clear' => '清除',
	'Edit all' => '编辑全部',

	// Import
	'Import' => '导入',
	'File upload' => '文件上传',
	'From server' => '来自服务器',
	'Webserver file %s' => 'Web服务器文件 %s',
	'Run file' => '运行文件',
	'File does not exist.' => '文件不存在。',
	'File uploads are disabled.' => '文件上传被禁用。',
	'Unable to upload a file.' => '不能上传文件。',
	'Maximum allowed file size is %sB.' => '最多允许的文件大小为 %sB。',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => '最多允许的文件数量为 %d。请减少所选文件或者增加 %s 配置命令。', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => '文件总大小最多为 %s。请选择更小的文件或者增加 %s 配置命令。', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST 数据太大。请减少数据或者增加 %s 配置命令。',
	'You can upload a big SQL file via FTP and import it from server.' => '您可以通过FTP上传大型SQL文件并从服务器导入。',
	'File must be in UTF-8 encoding.' => '文件必须使用UTF-8编码。',
	'You are offline.' => '您离线了。',
	'%d row(s) have been imported.' => '%d 行已导入。',

	// Export
	'Export' => '导出',
	'Output' => '输出',
	'open' => '打开',
	'save' => '保存',
	'Format' => '格式',
	'Data' => '数据',

	// Databases
	'Database' => '数据库',
	'database' => '数据库', // by Claude Opus 5
	'DB' => '数据库',
	'Use' => '使用',
	'Invalid database.' => '无效数据库。',
	'Alter database' => '修改数据库',
	'Create database' => '创建数据库',
	'Database schema' => '数据库概要',
	'Permanent link' => '固定链接',
	'Database has been dropped.' => '已删除数据库。',
	'Databases have been dropped.' => '已删除数据库。',
	'Database has been created.' => '已创建数据库。',
	'Database has been renamed.' => '已重命名数据库。',
	'Database has been altered.' => '已修改数据库。',

	// SQLite errors
	'File exists.' => '文件已存在。',
	'Please use one of the extensions %s.' => '请使用其中一个扩展：%s。',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => '模式',
	'schema' => '模式', // by Claude Opus 5
	'Schemas' => '模式', // by Claude Opus 5
	'No schemas.' => '没有模式。', // by Claude Opus 5
	'Show schema' => '显示模式', // by Claude Opus 5
	'Alter schema' => '修改模式',
	'Create schema' => '创建模式',
	'Schema has been dropped.' => '已删除模式。',
	'Schema has been created.' => '已创建模式。',
	'Schema has been altered.' => '已修改模式。',
	'Invalid schema.' => '非法模式。',

	// Table list
	'Engine' => '引擎',
	'engine' => '引擎',
	'Collation' => '校对',
	'collation' => '校对',
	'Data Length' => '数据长度',
	'Index Length' => '索引长度',
	'Data Free' => '数据空闲',
	'Rows' => '行数',
	'%d in total' => '共计 %d',
	'Analyze' => '分析',
	'Optimize' => '优化',
	'Vacuum' => '整理（Vacuum）',
	'Check' => '检查',
	'Repair' => '修复',
	'Truncate' => '清空',
	'Truncate Cascade' => '级联清空', // by Claude Fable 5
	'Tables have been truncated.' => '已清空表。',
	'Move to other database' => '转移到其它数据库',
	'Move' => '转移',
	'Tables have been moved.' => '已转移表。',
	'Copy' => '复制',
	'Tables have been copied.' => '已复制表。',
	'overwrite' => '覆盖',

	// Tables
	'Tables' => '表',
	'Tables and views' => '表和视图',
	'Table' => '表',
	'No tables.' => '没有表。',
	'Alter table' => '修改表',
	'Create table' => '创建表',
	'Table has been dropped.' => '已删除表。',
	'Tables have been dropped.' => '已删除表。',
	'Tables have been optimized.' => '已优化表。',
	'Table has been altered.' => '已修改表。',
	'Table has been created.' => '已创建表。',
	'Table name' => '表名',
	'Name' => '名称',
	'Show structure' => '显示结构',
	'Column name' => '字段名',
	'Type' => '类型',
	'Length' => '长度',
	'Auto Increment' => '自动增量',
	'Options' => '选项',
	'Comment' => '注释',
	'Default value' => '默认值',
	'Drop' => '删除',
	'Drop %s?' => '删除 %s?',
	'Are you sure?' => '您确定吗？',
	'Size' => '大小',
	'Compute' => '计算',
	'Move up' => '上移',
	'Move down' => '下移',
	'Remove' => '移除',
	'Maximum number of allowed fields exceeded. Please increase %s.' => '超过最多允许的字段数量。请增加 %s。',

	// Views
	'View' => '视图',
	'Materialized view' => '物化视图',
	'View has been dropped.' => '已删除视图。',
	'View has been altered.' => '已修改视图。',
	'View has been created.' => '已创建视图。',
	'Alter view' => '修改视图',
	'Create view' => '创建视图',

	// Partitions
	'Partition by' => '分区类型',
	'Partition' => '分区', // by Claude Opus 5
	'Partitions' => '分区',
	'Partition name' => '分区名',
	'Values' => '值',
	'Inherited tables' => '继承的表', // by Claude Opus 5
	'Inherited from' => '继承自', // by Claude Opus 5

	// Indexes
	'Indexes' => '索引',
	'Indexes have been altered.' => '已修改索引。',
	'Alter indexes' => '修改索引',
	'Add next' => '下一行插入',
	'Index Type' => '索引类型',
	'length' => '长度', // by Claude Fable 5
	'operator class' => '运算符类', // by Claude Fable 5
	'Algorithm' => '算法', // by Claude Fable 5
	'Condition' => '条件', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => '外键',
	'Foreign key' => '外键',
	'Foreign key has been dropped.' => '已删除外键。',
	'Foreign key has been altered.' => '已修改外键。',
	'Foreign key has been created.' => '已创建外键。',
	'Target table' => '目标表',
	'Change' => '修改',
	'Source' => '源',
	'Target' => '目标',
	'Add column' => '增加列',
	'Alter' => '修改',
	'Add foreign key' => '添加外键',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => '源列和目标列必须具有相同的数据类型，在目标列上必须有一个索引并且引用的数据必须存在。',

	// Routines
	'Routines' => '子程序',
	'Routine has been called, %d row(s) affected.' => '子程序被调用，%d 行被影响。',
	'Call' => '调用',
	'Parameter name' => '参数名',
	'Create procedure' => '创建过程',
	'Create function' => '创建函数',
	'Routine has been dropped.' => '已删除子程序。',
	'Routine has been altered.' => '已修改子程序。',
	'Routine has been created.' => '已创建子程序。',
	'Alter function' => '修改函数',
	'Alter procedure' => '修改过程',
	'Return type' => '返回类型',

	// Events
	'Events' => '事件',
	'Event' => '事件',
	'Event has been dropped.' => '已删除事件。',
	'Event has been altered.' => '已修改事件。',
	'Event has been created.' => '已创建事件。',
	'Alter event' => '修改事件',
	'Create event' => '创建事件',
	'At given time' => '在指定时间',
	'Every' => '每',
	'Schedule' => '调度',
	'Start' => '开始',
	'End' => '结束',
	'On completion preserve' => '完成后仍保留',

	// Sequences (PostgreSQL)
	'Sequences' => '序列',
	'Create sequence' => '创建序列',
	'Sequence has been dropped.' => '已删除序列。',
	'Sequence has been created.' => '已创建序列。',
	'Sequence has been altered.' => '已修改序列。',
	'Alter sequence' => '修改序列',

	// User-defined types (PostgreSQL)
	'User types' => '用户定义类型', // by Claude Fable 5
	'Create type' => '创建类型',
	'Type has been dropped.' => '已删除类型。',
	'Type has been created.' => '已创建类型。',
	'Alter type' => '修改类型',

	// Triggers
	'Triggers' => '触发器',
	'Add trigger' => '创建触发器',
	'Trigger has been dropped.' => '已删除触发器。',
	'Trigger has been altered.' => '已修改触发器。',
	'Trigger has been created.' => '已创建触发器。',
	'Alter trigger' => '修改触发器',
	'Create trigger' => '创建触发器',

	// Table check constraints
	'Checks' => '检查约束', // by Claude Fable 5
	'Create check' => '创建检查约束', // by Claude Fable 5
	'Alter check' => '修改检查约束', // by Claude Fable 5
	'Check has been created.' => '已创建检查约束。', // by Claude Fable 5
	'Check has been altered.' => '已修改检查约束。', // by Claude Fable 5
	'Check has been dropped.' => '已删除检查约束。', // by Claude Fable 5

	// Selection
	'Select data' => '选择数据',
	'Select' => '选择',
	'Functions' => '函数',
	'Aggregation' => '集合',
	'Search' => '搜索',
	'anywhere' => '任意位置',
	'Sort' => '排序',
	'descending' => '降序',
	'Limit' => '范围',
	'Limit rows' => '限制行数',
	'Text length' => '文本显示限制',
	'Action' => '动作',
	'Full table scan' => '全表扫描',
	'Unable to select the table' => '不能选择该表',
	'Search data in tables' => '在表中搜索数据',
	'No rows.' => '无数据。',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d 行',
	'Page' => '页面',
	'last' => '最后',
	'Load more data' => '加载更多数据',
	'Loading' => '加载中',
	'Whole result' => '所有结果',
	'%d byte(s)' => '%d 字节',

	// In-place editing in selection
	'Modify' => '修改',
	'Ctrl+click on a value to modify it.' => '按住Ctrl并单击某个值进行修改。',
	'Use edit link to modify this value.' => '使用编辑链接修改该值。',

	// Editing
	'New item' => '新建数据',
	'Edit' => '编辑',
	'original' => '原始',
	'empty' => '空', // label for value '' in enum data type
	'Insert' => '插入',
	'Save' => '保存',
	'Save and continue edit' => '保存并继续编辑',
	'Save and insert next' => '保存并插入下一个',
	'Saving' => '保存中',
	'Selected' => '已选中',
	'Clone' => '复制',
	'Delete' => '删除',
	'Item%s has been inserted.' => '已插入项目%s。', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => '已删除项目。',
	'Item has been updated.' => '已更新项目。',
	'%d item(s) have been affected.' => '%d 个项目受到影响。',
	'You have no privileges to update this table.' => '您没有权限更新这个表。',

	// Data type descriptions
	'Numbers' => '数字',
	'Date and time' => '日期时间',
	'Strings' => '字符串',
	'Binary' => '二进制',
	'Lists' => '列表',
	'Network' => '网络',
	'Geometry' => '几何图形',
	'Relations' => '关联信息',

	// Editor - data values
	'now' => '现在',
	'yes' => '是',
	'no' => '否',

	// Settings
	'Settings' => '设置', // by Claude Opus 5
	'Default' => '默认', // by Claude Opus 5
	'Color scheme' => '配色方案', // by Claude Opus 5
	'By system' => '跟随系统', // by Claude Opus 5
	'Light' => '浅色', // by Claude Opus 5
	'Dark' => '深色', // by Claude Opus 5
	'Navigation mode' => '导航模式', // by Claude Opus 5
	'Simple' => '简单', // by Claude Opus 5
	'Dual' => '双栏', // by Claude Opus 5
	'Reversed' => '反向', // by Claude Opus 5
	'Layout of main navigation with table links.' => '带有表链接的主导航布局。', // by Claude Opus 5
	'Table links' => '表链接', // by Claude Opus 5
	'Primary action for all table links.' => '所有表链接的主要动作。', // by Claude Opus 5
	'Links to tables referencing the current row.' => '指向引用当前行的表的链接。', // by Claude Opus 5
	'Display' => '显示', // by Claude Opus 5
	'Hide' => '隐藏', // by Claude Opus 5
	'Records per page' => '每页记录数', // by Claude Opus 5
	'Default number of records displayed in data table.' => '数据表中默认显示的记录数量。', // by Claude Opus 5
	'Enum as select' => '枚举显示为选择列表', // by Claude Opus 5
	'Never' => '从不', // by Claude Opus 5
	'Always' => '总是', // by Claude Opus 5
	'More values than %d' => '值多于 %d 个', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => '枚举字段显示选择列表的阈值。', // by Claude Opus 5

	// Plugins
	'One Time Password' => '一次性密码', // by Claude Opus 5
	'Enter OTP code.' => '请输入 OTP 验证码。', // by Claude Opus 5
	'Invalid OTP code.' => '无效的 OTP 验证码。', // by Claude Opus 5
	'Access denied.' => '拒绝访问。', // by Claude Opus 5
	'JSON previews' => 'JSON 预览', // by Claude Opus 5
	'Data table' => '数据表', // by Claude Opus 5
	'Edit form' => '编辑表单', // by Claude Opus 5
	'Ask %s' => '询问 %s', // by Claude Opus 5
];
