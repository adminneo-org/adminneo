<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s mesti memulangkan array.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s dan %s mesti memulangkan objek yang dibina oleh kaedah %s.', // by Claude Fable 5.1

	// Login
	'System' => 'Sistem',
	'Server' => 'Pelayan',
	'Username' => 'Nama pengguna',
	'Password' => 'Kata laluan',
	'Permanent login' => 'Log masuk kekal',
	'Login' => 'Log masuk',
	'Logout' => 'Log keluar',
	'Logged as: %s' => 'Log masuk sebagai: %s',
	'Logout successful.' => 'Log keluar berjaya.',
	'hostname[:port] or :socket' => 'nama hos[:port] atau :soket', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'Pelayan atau kelayakan tidak sah.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'Terdapat ruang kosong dalam kata laluan yang dimasukkan, mungkin itu puncanya.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo tidak menyokong capaian ke pangkalan data tanpa kata laluan, <a href="https://www.adminneo.org/password"%s>maklumat lanjut</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'Pangkalan data tidak menyokong kata laluan.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Terlalu banyak percubaan log masuk yang gagal, sila cuba lagi dalam masa %d minit.',
	'Invalid permanent login, please login again.' => 'Log masuk kekal tidak sah, sila log masuk kembali.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'Token CSRF tidak sah. Sila hantar borang sekali lagi.',
	'If you did not send this request from AdminNeo then close this page.' => 'Jika anda tidak menghantar permintaan ini dari AdminNeo sila tutup halaman ini.',
	'The action will be performed after successful login with the same credentials.' => 'Tindakan ini akan dilaksanakan selepas log masuk berjaya dengan kelayakan yang sama.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'Tiada sambungan',
	'None of the supported PHP extensions (%s) are available.' => 'Sambungan PHP yang (%s) disokong tidak wujud.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Penyambungan ke port yang istimewa tidak dibenarkan.',
	'Session support must be enabled.' => 'Sokongan sesi perlu diaktifkan.',
	'Session expired, please login again.' => 'Sesi telah luput, sila log masuk kembali.',
	'%s version: %s through PHP extension %s' => 'Versi %s: %s melalui sambungan PHP %s',

	// Settings
	'Language' => 'Bahasa',

	'Menu' => 'Menu', // by Claude Fable 5.1
	'Home' => 'Utama', // by Claude Fable 5.1
	'Refresh' => 'Segar kembali',
	'Info' => 'Info', // by Claude Fable 5.1
	'More information.' => 'Maklumat lanjut.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'Keistimewaan',
	'Create user' => 'Bina pengguna',
	'User has been dropped.' => 'Pengguna telah dijatuhkan.',
	'User has been altered.' => 'Pengguna telah diubah.',
	'User has been created.' => 'Pengguna telah dibuat.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => 'Senarai proses',
	'%d process(es) have been killed.' => '%d proses telah dihentikan.',
	'Kill' => 'Henti',
	'Variables' => 'Pembolehubah',
	'Status' => 'Status',

	// Structure
	'Column' => 'Kolum',
	'Columns' => 'Kolum', // by Claude Fable 5.1
	'Routine' => 'Rutin',
	'Grant' => 'Beri',
	'Revoke' => 'Batal',

	// Queries
	'SQL command' => 'Arahan SQL',
	'HTTP request' => 'Permintaan HTTP', // by Claude Fable 5.1
	'%d query(s) executed OK.' => '%d query berjaya dilaksanakan.',
	'Query executed OK, %d row(s) affected.' => 'Query berjaya dilaksanakan, %d baris terjejas.',
	'No commands to execute.' => 'Tiada arahan untuk dilaksanakan.',
	'Error in query' => 'Ralat pada query',
	'Unknown error.' => 'Ralat tidak diketahui.', // by Claude Fable 5.1
	'Warnings' => 'Amaran', // by Claude Fable 5.1
	'%s queries are not supported.' => 'Query %s tidak disokong.',
	'Execute' => 'Laksana',
	'Stop on error' => 'Berhenti jika ralat',
	'Show only errors' => 'Paparkan jika ralat',
	'Time' => 'Masa',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Sejarah',
	'Clear' => 'Bersih',
	'Edit all' => 'Ubah semua',

	// Import
	'Import' => 'Import',
	'File upload' => 'Muat naik fail',
	'From server' => 'Dari pelayan',
	'Webserver file %s' => 'Fail pelayan sesawang %s',
	'Run file' => 'Jalankan fail',
	'File does not exist.' => 'Fail tidak wujud.',
	'File uploads are disabled.' => 'Muat naik fail dihalang.',
	'Unable to upload a file.' => 'Muat naik fail gagal.',
	'Maximum allowed file size is %sB.' => 'Saiz fail maksimum yang dibenarkan adalah %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Bilangan fail maksimum adalah %d. Pilih fail yang lebih sedikit atau tingkatkan tetapan %s.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Jumlah saiz fail maksimum adalah %s. Pilih fail yang lebih kecil atau tingkatkan tetapan %s.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Data POST terlalu besar. Kecilkan data atau tingkatkan tetapan %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Anda boleh muat naik fail SQL yang besar melalui FTP dan import melalui pelayan.',
	'File must be in UTF-8 encoding.' => 'Fail mesti dalam pengekodan UTF-8.',
	'You are offline.' => 'Anda sedang offline.',
	'%d row(s) have been imported.' => '%d baris telah diimport.',

	// Export
	'Export' => 'Eksport',
	'Output' => 'Pengeluaran',
	'open' => 'buka',
	'save' => 'simpan',
	'Format' => 'Format',
	'Data' => 'Data',

	// Databases
	'Database' => 'Pangkalan data',
	'database' => 'pangkalan data', // by Claude Fable 5.1
	'DB' => 'PD', // by Claude Fable 5.1
	'Use' => 'Guna',
	'Invalid database.' => 'Pangkalan data tidak sah.',
	'Alter database' => 'Ubah pangkalan data',
	'Create database' => 'Bina pangkalan data',
	'Database schema' => 'Skema pangkalan data',
	'Permanent link' => 'Pautan kekal',
	'Database has been dropped.' => 'Pangkalan data telah dijatuhkan.',
	'Databases have been dropped.' => 'Pangkalan data telah dijatuhkan.',
	'Database has been created.' => 'Pangkalan data telah dibuat.',
	'Database has been renamed.' => 'Pangkalan data telah ditukar nama.',
	'Database has been altered.' => 'Pangkalan data telah diubah.',

	// SQLite errors
	'File exists.' => 'Fail wujud.',
	'Please use one of the extensions %s.' => 'Sila guna salah satu sambungan %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Skema',
	'schema' => 'skema', // by Claude Fable 5.1
	'Schemas' => 'Skema', // by Claude Fable 5.1
	'No schemas.' => 'Tiada skema.', // by Claude Fable 5.1
	'Show schema' => 'Paparkan skema', // by Claude Fable 5.1
	'Alter schema' => 'Ubah skema',
	'Create schema' => 'Buat skema',
	'Schema has been dropped.' => 'Skema telah dijatuhkan.',
	'Schema has been created.' => 'Skema telah dibuat.',
	'Schema has been altered.' => 'Skema telah diubah.',
	'Invalid schema.' => 'Skema tidak sah.',

	// Table list
	'Engine' => 'Enjin',
	'engine' => 'enjin',
	'Collation' => 'Collation',
	'collation' => 'collation',
	'Data Length' => 'Panjang Data',
	'Index Length' => 'Panjang Indeks',
	'Data Free' => 'Data Free',
	'Rows' => 'Baris',
	'%d in total' => '%d secara keseluruhan',
	'Analyze' => 'Menganalisis',
	'Optimize' => 'Mengoptimum',
	'Vacuum' => 'Vacuum',
	'Check' => 'Periksa',
	'Repair' => 'Baiki',
	'Truncate' => 'Memangkas',
	'Truncate Cascade' => 'Memangkas secara lata', // by Claude Fable 5.1
	'Tables have been truncated.' => 'Jadual telah dimangkaskan.',
	'Move to other database' => 'Pindahkan ke pangkalan data yang lain',
	'Move' => 'Pindah',
	'Tables have been moved.' => 'Jadual telah dipindahkan.',
	'Copy' => 'Salin',
	'Tables have been copied.' => 'Jadual telah disalin.',
	'overwrite' => 'tulis ganti', // by Claude Fable 5.1

	// Tables
	'Tables' => 'Jadual',
	'Tables and views' => 'Jadual dan pandangan',
	'Table' => 'Jadual',
	'No tables.' => 'Tiada jadual.',
	'Alter table' => 'Ubah jadual',
	'Create table' => 'Bina jadual',
	'Table has been dropped.' => 'Jadual telah dijatuhkan.',
	'Tables have been dropped.' => 'Jadual telah dijatuhkan.',
	'Tables have been optimized.' => 'Jadual telah dioptimumkan.',
	'Table has been altered.' => 'Jadual telah diubah.',
	'Table has been created.' => 'Jadual telah dibuat.',
	'Table name' => 'Nama jadual',
	'Name' => 'Nama',
	'Show structure' => 'Paparkan struktur',
	'Column name' => 'Nama kolum',
	'Type' => 'Jenis',
	'Length' => 'Kepanjangan',
	'Auto Increment' => 'Kenaikan Auto',
	'Options' => 'Pilihan',
	'Comment' => 'Komen',
	'Default value' => 'Nilai lalai',
	'Drop' => 'Jatuh',
	'Drop %s?' => 'Jatuhkan %s?',
	'Are you sure?' => 'Anda pasti?',
	'Size' => 'Saiz',
	'Compute' => 'Kira',
	'Move up' => 'Gerak ke atas',
	'Move down' => 'Gerak ke bawah',
	'Remove' => 'Buang',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Bilangan medan telah melebihi had yang dibenarkan. Sila tingkatkan %s.',

	// Views
	'View' => 'Papar',
	'Materialized view' => 'Paparan termaterialisasi', // by Claude Fable 5.1
	'View has been dropped.' => 'Paparan telah dijatuhkan.',
	'View has been altered.' => 'Paparan telah diubah.',
	'View has been created.' => 'Paparan telah dibuat.',
	'Alter view' => 'Ubah paparan',
	'Create view' => 'Bina paparan',

	// Partitions
	'Partition by' => 'Partition mengikut',
	'Partition' => 'Partition', // by Claude Fable 5.1
	'Partitions' => 'Partition',
	'Partition name' => 'Nama partition',
	'Values' => 'Nilai',
	'Inherited tables' => 'Jadual terbitan', // by Claude Fable 5.1
	'Inherited from' => 'Diwarisi daripada', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'Indeks',
	'Indexes have been altered.' => 'Indeks telah diubah.',
	'Alter indexes' => 'Ubah indeks',
	'Add next' => 'Tambah yang seterusnya',
	'Index Type' => 'Jenis Indeks',
	'length' => 'kepanjangan',
	'operator class' => 'kelas operator', // by Claude Fable 5.1
	'Algorithm' => 'Algoritma', // by Claude Fable 5.1
	'Condition' => 'Syarat', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'Kunci asing',
	'Foreign key' => 'Kunci asing',
	'Foreign key has been dropped.' => 'Kunci asing telah dijatuhkan.',
	'Foreign key has been altered.' => 'Kunci asing telah diubah.',
	'Foreign key has been created.' => 'Kunci asing telah dibuat.',
	'Target table' => 'Jadual sasaran',
	'Change' => 'Tukar',
	'Source' => 'Sumber',
	'Target' => 'Sasaran',
	'Add column' => 'Tambah kolum',
	'Alter' => 'Ubah',
	'Add foreign key' => 'Tambah kunci asing',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Kolum sumber dan sasaran perlu mempunyai jenis data yang sama, indeks diperlukan pada kolum sasaran dan data yang dirujuk wujud.',

	// Routines
	'Routines' => 'Rutin',
	'Routine has been called, %d row(s) affected.' => 'Rutin telah dipanggil, %d baris terjejas.',
	'Call' => 'Panggil',
	'Parameter name' => 'Nama pembolehubah',
	'Create procedure' => 'Bina prosedur',
	'Create function' => 'Bina fungsi',
	'Routine has been dropped.' => 'Rutin telah dijatuhkan.',
	'Routine has been altered.' => 'Rutin telah diubah.',
	'Routine has been created.' => 'Rutin telah dibuat.',
	'Alter function' => 'Ubah fungsi',
	'Alter procedure' => 'Ubah prosedur',
	'Return type' => 'Jenis Return',

	// Events
	'Events' => 'Peristiwa',
	'Event' => 'Peristiwa',
	'Event has been dropped.' => 'Peristiwa telah dijatuhkan.',
	'Event has been altered.' => 'Peristiwa telah diubah.',
	'Event has been created.' => 'Peristiwa telah dibuat.',
	'Alter event' => 'Ubah peristiwa',
	'Create event' => 'Bina peristiwa',
	'At given time' => 'Pada masa tersebut',
	'Every' => 'Setiap',
	'Schedule' => 'Jadual',
	'Start' => 'Mula',
	'End' => 'Habis',
	'On completion preserve' => 'Dalam melestarikan penyelesaian',

	// Sequences (PostgreSQL)
	'Sequences' => 'Turutan',
	'Create sequence' => 'Buat turutan',
	'Sequence has been dropped.' => 'Turutan telah dijatuhkan.',
	'Sequence has been created.' => 'Turutan telah dibuat.',
	'Sequence has been altered.' => 'Turutan telah diubah.',
	'Alter sequence' => 'Ubah turutan',

	// User-defined types (PostgreSQL)
	'User types' => 'Jenis pengguna',
	'Create type' => 'Buat jenis',
	'Type has been dropped.' => 'Jenis telah dijatuhkan.',
	'Type has been created.' => 'Jenis telah dibuat.',
	'Alter type' => 'Ubah jenis',

	// Triggers
	'Triggers' => 'Pencetus', // by Claude Fable 5.1
	'Add trigger' => 'Tambah pencetus',
	'Trigger has been dropped.' => 'Pencetus telah dijatuhkan.',
	'Trigger has been altered.' => 'Pencetus telah diubah.',
	'Trigger has been created.' => 'Pencetus telah dibuat.',
	'Alter trigger' => 'Ubah pencetus',
	'Create trigger' => 'Buat pencetus',

	// Table check constraints
	'Checks' => 'Pemeriksaan', // by Claude Fable 5.1
	'Create check' => 'Bina pemeriksaan', // by Claude Fable 5.1
	'Alter check' => 'Ubah pemeriksaan', // by Claude Fable 5.1
	'Check has been created.' => 'Pemeriksaan telah dibina.', // by Claude Fable 5.1
	'Check has been altered.' => 'Pemeriksaan telah diubah.', // by Claude Fable 5.1
	'Check has been dropped.' => 'Pemeriksaan telah dijatuhkan.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'Pilih data',
	'Select' => 'Pilih',
	'Functions' => 'Fungsi',
	'Aggregation' => 'Pengagregatan',
	'Search' => 'Cari',
	'anywhere' => 'di mana-mana',
	'Sort' => 'Susun',
	'descending' => 'menurun',
	'Limit' => 'Had',
	'Limit rows' => 'Had baris',
	'Text length' => 'Kepanjangan teks',
	'Action' => 'Aksi',
	'Full table scan' => 'Imbasan penuh jadual',
	'Unable to select the table' => 'Pemilihan jadual tidak berjaya',
	'Search data in tables' => 'Cari data dalam jadual',
	'No rows.' => 'Tiada baris.',
	'%d / ' => '%d / ',
	'%d row(s)' => '%d baris',
	'Page' => 'Halaman',
	'last' => 'akhir',
	'Load more data' => 'Load lebih data',
	'Loading' => 'Loading',
	'Whole result' => 'Keputusan keseluruhan',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Pinda',
	'Ctrl+click on a value to modify it.' => 'Ctrl+click pada nilai untuk meminda.',
	'Use edit link to modify this value.' => 'Guna pautan ubah untuk meminda nilai ini.',

	// Editing
	'New item' => 'Item baru',
	'Edit' => 'Ubah',
	'original' => 'asli',
	'empty' => 'kosong', // label for value '' in enum data type
	'Insert' => 'Masukkan',
	'Save' => 'Simpan',
	'Save and continue edit' => 'Simpan dan sambung ubah',
	'Save and insert next' => 'Simpan dan masukkan seterusnya',
	'Saving' => 'Menyimpan',
	'Selected' => 'Terpilih',
	'Clone' => 'Klon',
	'Delete' => 'Padam',
	'Item%s has been inserted.' => 'Item%s telah dimasukkan.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Item telah dipadamkan.',
	'Item has been updated.' => 'Item telah dikemaskini.',
	'%d item(s) have been affected.' => '%d item telah terjejas.',
	'You have no privileges to update this table.' => 'Anda tidak mempunyai keistimewaan untuk mengemaskini jadual ini.',

	// Data type descriptions
	'Numbers' => 'Nombor',
	'Date and time' => 'Tarikh dan masa',
	'Strings' => 'String',
	'Binary' => 'Binari',
	'Lists' => 'Senarai',
	'Network' => 'Rangkaian',
	'Geometry' => 'Geometri',
	'Relations' => 'Hubungan',

	// Editor - data values
	'now' => 'sekarang',
	'yes' => 'ya',
	'no' => 'tidak',

	// Settings
	'Settings' => 'Tetapan', // by Claude Fable 5.1
	'Default' => 'Lalai', // by Claude Fable 5.1
	'Color scheme' => 'Skema warna', // by Claude Fable 5.1
	'By system' => 'Mengikut sistem', // by Claude Fable 5.1
	'Light' => 'Cerah', // by Claude Fable 5.1
	'Dark' => 'Gelap', // by Claude Fable 5.1
	'Navigation mode' => 'Mod navigasi', // by Claude Fable 5.1
	'Simple' => 'Ringkas', // by Claude Fable 5.1
	'Dual' => 'Ganda', // by Claude Fable 5.1
	'Dual on hover' => 'Ganda semasa tuding tetikus', // by Claude Fable 5.1
	'Reversed' => 'Terbalik', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'Susun atur navigasi utama dengan pautan jadual.', // by Claude Fable 5.1
	'Table links' => 'Pautan jadual', // by Claude Fable 5.1
	'Primary action for all table links.' => 'Tindakan utama untuk semua pautan jadual.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'Pautan ke jadual yang merujuk baris semasa.', // by Claude Fable 5.1
	'Display' => 'Paparkan', // by Claude Fable 5.1
	'Hide' => 'Sembunyikan', // by Claude Fable 5.1
	'Records per page' => 'Rekod setiap halaman', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'Bilangan lalai rekod yang dipaparkan dalam jadual data.', // by Claude Fable 5.1
	'Enum as select' => 'Enum sebagai senarai pilihan', // by Claude Fable 5.1
	'Never' => 'Tidak pernah', // by Claude Fable 5.1
	'Always' => 'Sentiasa', // by Claude Fable 5.1
	'More values than %d' => 'Lebih daripada %d nilai', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'Ambang untuk memaparkan senarai pilihan bagi kolum enum.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'Kata Laluan Sekali Guna', // by Claude Fable 5.1
	'Enter OTP code.' => 'Masukkan kod OTP.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'Kod OTP tidak sah.', // by Claude Fable 5.1
	'Access denied.' => 'Capaian dihalang.', // by Claude Fable 5.1
	'JSON previews' => 'Pratonton JSON', // by Claude Fable 5.1
	'Data table' => 'Jadual data', // by Claude Fable 5.1
	'Edit form' => 'Borang ubah', // by Claude Fable 5.1
	'Ask %s' => 'Tanya %s', // by Claude Fable 5.1
];
