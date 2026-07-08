<?php

namespace AdminNeo;

return [
	// text direction - 'ltr' or 'rtl'
	'ltr' => 'ltr',
	// thousands separator - must contain single byte
	',' => ',',
	'0123456789' => '0123456789',
	// Editor - date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'$1-$3-$5' => '$1/$3/$5',
	// Editor - hint for date format - use language equivalents for day, month and year shortcuts
	'YYYY-MM-DD' => 'YYYY/MM/DD',
	// Editor - hint for time format - use language equivalents for hour, minute and second shortcuts
	'HH:MM:SS' => '時:分:秒',

	// Bootstrap.
	'%s must return an array.' => '%s は配列を返す必要があります。',
	'%s and %s must return an object created by %s method.' => '%s と %s は %s メソッドで作成されたオブジェクトを返す必要があります。',

	// Login.
	'System' => 'データベース種類',
	'Server' => 'サーバー',
	'Username' => 'ユーザー名',
	'Password' => 'パスワード',
	'Permanent login' => '永続的にログイン',
	'Login' => 'ログイン',
	'Logout' => 'ログアウト',
	'Logged as: %s' => 'ログ：%s',
	'Logout successful.' => 'ログアウトしました。',
	'Invalid server or credentials.' => 'サーバーまたは認証情報が無効です。',
	'There is a space in the input password which might be the cause.' => '入力されたパスワードに空白が含まれているので、それが原因かもしれません。',
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo はパスワードのないデータベースへの接続には対応していません。(<a href="https://www.adminneo.org/password"%s>詳細</a>)',
	'Database does not support password.' => 'データベースがパスワードに対応していません。',
	'Too many unsuccessful logins, try again in %d minute(s).' => 'ログインの失敗数が多すぎます。%d分後に再試行してください。',
	'Invalid permanent login, please login again.' => '永続的ログインが無効です。再度ログインしてください。',
	'Invalid CSRF token. Send the form again.' => '不正なCSRFトークンです。再送信してください。',
	'If you did not send this request from AdminNeo then close this page.' => 'AdminNeoリクエストでない場合はこのページを閉じてください。',
	'The action will be performed after successful login with the same credentials.' => '同じアカウントで正しくログインすると作業を実行します。',

	// Connection.
	'No driver' => 'ドライバーがありません',
	'Database driver not found.' => 'データベースドライバーが見つかりません。',
	'No extension' => '拡張機能がありません',
	// %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'None of the supported PHP extensions (%s) are available.' => 'PHPの拡張機能（%s）がセットアップされていません。',
	'Connecting to privileged ports is not allowed.' => '特権ポートへの接続は許可されていません。',
	'Session support must be enabled.' => 'セッションを有効にしてください。',
	'Session expired, please login again.' => 'セッションの期限切れ。ログインし直してください。',
	'%s version: %s through PHP extension %s' => '%sバージョン：%s、 PHP拡張機能 %s',

	// Settings.
	'Language' => '言語',

	'Home' => 'ホーム',
	'Refresh' => 'リフレッシュ',
	'Info' => '情報',
	'More information.' => '詳細情報。',

	// Privileges.
	'Privileges' => '権限',
	'Create user' => 'ユーザを作成',
	'User has been dropped.' => 'ユーザを削除しました。',
	'User has been altered.' => 'ユーザを変更しました。',
	'User has been created.' => 'ユーザを作成しました。',
	'Hashed' => 'Hashed',

	// Server.
	'Process list' => 'プロセス一覧',
	'%d process(es) have been killed.' => '%d プロセスを終了しました。',
	'Kill' => 'プロセスを終了',
	'Variables' => '変数',
	'Status' => '状態',

	// Structure.
	'Column' => 'カラム',
	'Columns' => 'カラム',
	'Routine' => 'ルーチン',
	'Grant' => '権限を付与',
	'Revoke' => '権限を取り消す',

	// Queries.
	'SQL command' => 'SQLコマンド',
	'HTTP request' => 'HTTP リクエスト',
	'%d query(s) executed OK.' => '%d クエリーを実行しました。',
	'Query executed OK, %d row(s) affected.' => 'クエリーを実行しました。%d 行を変更しました。',
	'No commands to execute.' => '実行するコマンドがありません。',
	'Error in query' => 'クエリーのエラー',
	'Unknown error.' => '不明なエラーです。',
	'Warnings' => '警告',
	'%s queries are not supported.' => '%s クエリーは対応していません。',
	'Execute' => '実行',
	'Stop on error' => 'エラーの場合は停止',
	'Show only errors' => 'エラーのみ表示',
	'Time' => 'タイミング',
	// sprintf() format for time of the command
	'%.3f s' => '%.3f 秒',
	'History' => '履歴',
	'Clear' => '消去',
	'Edit all' => '一括編集',

	// Import.
	'Import' => 'インポート',
	'File upload' => 'アップロード',
	'From server' => 'サーバー上のファイル',
	'Webserver file %s' => 'サーバ上のファイル名 %s',
	'Run file' => '実行',
	'File does not exist.' => 'ファイルは存在しません。',
	'File uploads are disabled.' => 'ファイルのアップロードが無効です。',
	'Unable to upload a file.' => 'ファイルをアップロードできません。',
	'Maximum allowed file size is %sB.' => '最大ファイルサイズは %sB です。',
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POSTデータが大きすぎます。データサイズを小さくするか %s 設定を大きくしてください。',
	'You can upload a big SQL file via FTP and import it from server.' => '大きなSQLファイルは、FTP経由でアップロードしてサーバからインポートしてください。',
	'File must be in UTF-8 encoding.' => 'ファイルをUTF-8で保存してください。',
	'You are offline.' => 'オフライン状態です。',
	'%d row(s) have been imported.' => '%d 行をインポートしました。',

	// Export.
	'Export' => 'エクスポート',
	'Output' => '出力',
	'open' => 'ブラウザに表示',
	'save' => '保存',
	'Format' => '形式',
	'Data' => 'データ',

	// Databases.
	'Database' => 'データベース',
	'database' => 'データベース',
	'DB' => 'DB',
	'Use' => '使用',
	'Invalid database.' => '不正なデータベースです。',
	'Alter database' => 'データベースの設定を変更',
	'Create database' => 'データベースを作成',
	'Database schema' => 'スキーマ',
	'Permanent link' => '固定リンク',
	'Database has been dropped.' => 'データベースを削除しました。',
	'Databases have been dropped.' => 'データベースを削除しました。',
	'Database has been created.' => 'データベースを作成しました。',
	'Database has been renamed.' => 'データベースの名前を変えました。',
	'Database has been altered.' => 'データベースの設定を変更しました。',
	// SQLite errors.
	'File exists.' => 'ファイルが既に存在します。',
	'Please use one of the extensions %s.' => '%s のいずれかの拡張機能を使ってください。',

	// Schemas (PostgreSQL, MS SQL).
	'Schema' => 'スキーマ',
	'schema' => 'スキーマ',
	'Schemas' => 'スキーマ一覧',
	'No schemas.' => 'スキーマがありません。',
	'Show schema' => 'スキーマを表示',
	'Alter schema' => 'スキーマ変更',
	'Create schema' => 'スキーマ追加',
	'Schema has been dropped.' => 'スキーマを削除しました。',
	'Schema has been created.' => 'スキーマを追加しました。',
	'Schema has been altered.' => 'スキーマを変更しました。',
	'Invalid schema.' => '無効なスキーマです。',

	// Table list.
	'Engine' => 'エンジン',
	'engine' => 'エンジン',
	'Collation' => 'コレーション',
	'collation' => 'コレーション',
	'Data Length' => 'データ長',
	'Index Length' => 'インデックス長',
	'Data Free' => '空き',
	'Rows' => '行数',
	'%d in total' => '合計 %d',
	'Analyze' => '分析',
	'Optimize' => '最適化',
	'Vacuum' => '不要領域を回収(Vacuum)',
	'Check' => '検査',
	'Repair' => '修復',
	'Truncate' => '空にする',
	'Tables have been truncated.' => 'テーブルを空にしました。',
	'Move to other database' => '他のデータベースへ移動',
	'Move' => '移動',
	'Tables have been moved.' => 'テーブルを移動しました。',
	'Copy' => 'コピー',
	'Tables have been copied.' => 'テーブルをコピーしました。',
	'overwrite' => '上書き',

	// Tables.
	'Tables' => 'テーブル',
	'Tables and views' => 'テーブルとビュー',
	'Table' => 'テーブル',
	'No tables.' => 'テーブルがありません。',
	'Alter table' => 'テーブルの設定を変更',
	'Create table' => 'テーブルを作成',
	'Table has been dropped.' => 'テーブルを削除しました。',
	'Tables have been dropped.' => 'テーブルを削除しました。',
	'Tables have been optimized.' => 'テーブルを最適化しました。',
	'Table has been altered.' => 'テーブルの設定を変更しました。',
	'Table has been created.' => 'テーブルを作成しました。',
	'Table name' => 'テーブル名',
	'Name' => '名称',
	'Show structure' => 'スキーマ',
	'Column name' => 'カラム名',
	'Type' => '型',
	'Length' => '長さ',
	'Auto Increment' => '連番',
	'Options' => '設定',
	'Comment' => 'コメント',
	'Default value' => '既定値',
	'Drop' => '削除',
	'Drop %s?' => '%s を削除しますか？',
	'Are you sure?' => '実行しますか？',
	'Size' => 'サイズ',
	'Compute' => '再計算',
	'Move up' => '上',
	'Move down' => '下',
	'Remove' => '除外',
	'Maximum number of allowed fields exceeded. Please increase %s.' => '定義可能な最大フィールド数を越えました。%s を増やしてください。',

	// Views.
	'View' => 'ビュー',
	'Materialized view' => 'マテリアライズドビュー',
	'View has been dropped.' => 'ビューを削除しました。',
	'View has been altered.' => 'ビューの設定を変更しました。',
	'View has been created.' => 'ビューを作成しました。',
	'Alter view' => 'ビューの設定を変更',
	'Create view' => 'ビューを作成',

	// Partitions.
	'Partition by' => 'パーティション',
	'Partition' => 'パーティション',
	'Partitions' => 'パーティション',
	'Partition name' => 'パーティション名',
	'Values' => '値',

	// Indexes.
	'Indexes' => 'インデックス',
	'Indexes have been altered.' => 'インデックスを変更しました。',
	'Alter indexes' => 'インデックスを変更',
	'Add next' => '追加',
	'Index Type' => 'インデックスの型',
	'length' => '長さ',
	'Algorithm' => 'アルゴリズム',
	'Condition' => '条件',

	// Foreign keys.
	'Foreign keys' => '外部キー',
	'Foreign key' => '外部キー',
	'Foreign key has been dropped.' => '外部キーを削除しました。',
	'Foreign key has been altered.' => '外部キーを変更しました。',
	'Foreign key has been created.' => '外部キーを作成しました。',
	'Target table' => '対象テーブル',
	'Change' => '変更',
	'Source' => 'ソース',
	'Target' => 'ターゲット',
	'Add column' => 'カラムを追加',
	'Alter' => '変更',
	'Add foreign key' => '外部キーを追加',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'ソースとターゲットのカラムは同じデータ型でなければなりません。ターゲットカラムにインデックスがあり、データが存在しなければなりません。',

	// Routines.
	'Routines' => 'ルーチン',
	'Routine has been called, %d row(s) affected.' => 'ルーチンを呼びました。%d 行を変更しました。',
	'Call' => '呼出し',
	'Parameter name' => 'パラメータ名',
	'Create procedure' => 'プロシージャを作成',
	'Create function' => '関数を作成',
	'Routine has been dropped.' => 'ルーチンを削除しました。',
	'Routine has been altered.' => 'ルーチンを変更しました。',
	'Routine has been created.' => 'ルーチンを作成しました。',
	'Alter function' => '関数を変更',
	'Alter procedure' => 'プロシージャを変更',
	'Return type' => '戻り値の型',

	// Events.
	'Events' => 'イベント',
	'Event' => 'イベント',
	'Event has been dropped.' => 'イベントを削除しました。',
	'Event has been altered.' => 'イベントを変更しました。',
	'Event has been created.' => 'イベントを作成しました。',
	'Alter event' => 'イベントを変更',
	'Create event' => 'イベントを作成',
	'At given time' => '指定時刻',
	'Every' => '毎回',
	'Schedule' => 'スケジュール',
	'Start' => '開始',
	'End' => '終了',
	'On completion preserve' => '完成後に保存',

	// Sequences (PostgreSQL).
	'Sequences' => 'シーケンス',
	'Create sequence' => 'シーケンス作成',
	'Sequence has been dropped.' => 'シーケンスを削除しました。',
	'Sequence has been created.' => 'シーケンスを追加しました。',
	'Sequence has been altered.' => 'シーケンスを変更しました。',
	'Alter sequence' => 'シーケンス変更',

	// User types (PostgreSQL)
	'User types' => 'ユーザー定義型',
	'Create type' => 'ユーザー定義型作成',
	'Type has been dropped.' => 'ユーザー定義型を削除しました。',
	'Type has been created.' => 'ユーザー定義型を追加しました。',
	'Alter type' => 'ユーザー定義型変更',

	// Triggers.
	'Triggers' => 'トリガー',
	'Add trigger' => 'トリガーを追加',
	'Trigger has been dropped.' => 'トリガーを削除しました。',
	'Trigger has been altered.' => 'トリガーを変更しました。',
	'Trigger has been created.' => 'トリガーを追加しました。',
	'Alter trigger' => 'トリガーを変更',
	'Create trigger' => 'トリガーを作成',

	// Table check constraints.
	'Checks' => 'CHECK制約',
	'Create check' => 'CHECK制約を作成',
	'Alter check' => 'CHECK制約を変更',
	'Check has been created.' => 'CHECK制約を作成しました。',
	'Check has been altered.' => 'CHECK制約を変更しました。',
	'Check has been dropped.' => 'CHECK制約を削除しました。',

	// Selection.
	'Select data' => 'データ',
	'Select' => '選択',
	'Functions' => '関数',
	'Aggregation' => '集約関数',
	'Search' => '検索',
	'anywhere' => '任意',
	'Sort' => 'ソート',
	'descending' => '降順',
	'Limit' => '制約',
	'Limit rows' => '表示行数を制限',
	'Text length' => '文字数を丸める',
	'Action' => '動作',
	'Full table scan' => 'テーブルを全スキャン',
	'Unable to select the table' => 'テーブルを選択できません',
	'Search data in tables' => 'データを検索する',
	'No rows.' => '行がありません。',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d 行',
	'Page' => 'ページ',
	'last' => '最終',
	'Load more data' => 'さらにデータを表示',
	'Loading' => '読み込み中',
	'Whole result' => '全結果',
	'%d byte(s)' => '%d バイト',

	// In-place editing in selection.
	'Modify' => '編集',
	'Ctrl+click on a value to modify it.' => 'Ctrl+クリックで値を修正します。',
	'Use edit link to modify this value.' => 'この値を修正するにはリンクを使用してください。',

	// Editing.
	'New item' => '新規レコードを挿入',
	'Edit' => '編集',
	'original' => '元',
	// label for value '' in enum data type
	'empty' => '空',
	'Insert' => '挿入',
	'Save' => '保存',
	'Save and continue edit' => '保存して継続',
	'Save and insert next' => '保存／追加',
	'Saving' => '保存しています',
	'Selected' => '選択対象',
	'Clone' => 'クローン',
	'Delete' => '削除',
	// %s can contain auto-increment value, e.g. ' 123'
	'Item%s has been inserted.' => '%sレコードを挿入しました。',
	'Item has been deleted.' => 'レコードを削除しました。',
	'Item has been updated.' => 'レコードを更新しました。',
	'%d item(s) have been affected.' => '%d レコードを更新しました。',
	'You have no privileges to update this table.' => 'このテーブルを更新する権限がありません。',

	// Data type descriptions.
	'Numbers' => '数字',
	'Date and time' => '日時',
	'Strings' => '文字列',
	'Binary' => 'バイナリ',
	'Lists' => 'リスト',
	'Network' => 'ネットワーク型',
	'Geometry' => 'ジオメトリ型',
	'Relations' => '関係',

	// Editor - data values.
	'now' => '現在の日時',
	'yes' => 'はい',
	'no' => 'いいえ',

	// Plugins.
	'One Time Password' => 'ワンタイムパスワード(OTP)',
	'Enter OTP code.' => 'OTPコードを入力してください。',
	'Invalid OTP code.' => '無効なOTPコードです。',
	'Access denied.' => 'アクセスが拒否されました。',
	// Use the phrases from https://gemini.google.com/
	'Ask %s' => '%s に聞く',
	'Just a sec...' => 'しばらくお待ち下さい...',
];
