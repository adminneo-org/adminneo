<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => '.', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'HH:MM:SS', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s harus mengembalikan larik.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s dan %s harus mengembalikan objek yang dibuat oleh metode %s.', // by Claude Fable 5.1

	// Login
	'System' => 'Sistem',
	'Server' => 'Server',
	'Username' => 'Pengguna',
	'Password' => 'Sandi',
	'Permanent login' => 'Masuk permanen',
	'Login' => 'Masuk',
	'Logout' => 'Keluar',
	'Logged as: %s' => 'Masuk sebagai: %s',
	'Logout successful.' => 'Berhasil keluar.',
	'hostname[:port] or :socket' => 'hostname[:port] atau :socket', // by Claude Fable 5.1
	'Invalid server or credentials.' => 'Server atau kredensial tidak sah.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => 'Ada spasi pada sandi yang dimasukkan yang mungkin menjadi penyebabnya.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo tidak mendukung akses basis data tanpa sandi, <a href="https://www.adminneo.org/password"%s>informasi lebih lanjut</a>.', // by Claude Fable 5.1
	'Database does not support password.' => 'Basis data tidak mendukung sandi.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Terlalu banyak upaya masuk yang gagal, coba lagi dalam %d menit.', // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => 'Masuk permanen tidak sah, silakan masuk lagi.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => 'Token CSRF tidak sah. Kirim ulang formulir.',
	'If you did not send this request from AdminNeo then close this page.' => 'Jika Anda tidak mengirim permintaan ini dari AdminNeo, tutup halaman ini.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => 'Tindakan akan dilakukan setelah berhasil masuk dengan kredensial yang sama.', // by Claude Fable 5.1

	// Connection
	'No extension' => 'Ekstensi tidak ada',
	'None of the supported PHP extensions (%s) are available.' => 'Ekstensi PHP yang didukung (%s) tidak ada.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Koneksi ke port istimewa tidak diizinkan.', // by Claude Fable 5.1
	'Session support must be enabled.' => 'Dukungan sesi harus aktif.',
	'Session expired, please login again.' => 'Sesi habis, silakan masuk lagi.',
	'%s version: %s through PHP extension %s' => 'Versi %s: %s dengan ekstensi PHP %s',

	// Settings
	'Language' => 'Bahasa',

	'Menu' => 'Menu', // by Claude Fable 5.1
	'Home' => 'Beranda', // by Claude Fable 5.1
	'Refresh' => 'Segarkan',
	'Info' => 'Info', // by Claude Fable 5.1
	'More information.' => 'Informasi selengkapnya.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => 'Privilese',
	'Create user' => 'Buat pengguna',
	'User has been dropped.' => 'Pengguna berhasil dihapus.',
	'User has been altered.' => 'Pengguna berhasil diubah.',
	'User has been created.' => 'Pengguna berhasil dibuat.',
	'Hashed' => 'Hashed*',

	// Server
	'Process list' => 'Daftar proses',
	'%d process(es) have been killed.' => '%d proses berhasil dihentikan.',
	'Kill' => 'Hentikan',
	'Variables' => 'Variabel',
	'Status' => 'Status',

	// Structure
	'Column' => 'Kolom',
	'Columns' => 'Kolom', // by Claude Fable 5.1
	'Routine' => 'Rutin',
	'Grant' => 'Beri',
	'Revoke' => 'Tarik',

	// Queries
	'SQL command' => 'Perintah SQL',
	'HTTP request' => 'Permintaan HTTP', // by Claude Fable 5.1
	'%d query(s) executed OK.' => '%d kueri berhasil dijalankan.',
	'Query executed OK, %d row(s) affected.' => 'Kueri berhasil, %d baris terpengaruh.',
	'No commands to execute.' => 'Tidak ada perintah untuk dijalankan.',
	'Error in query' => 'Galat dalam kueri',
	'Unknown error.' => 'Kesalahan tidak dikenal.', // by Claude Fable 5.1
	'Warnings' => 'Peringatan', // by Claude Fable 5.1
	'%s queries are not supported.' => 'Kueri %s tidak didukung.', // by Claude Fable 5.1
	'Execute' => 'Jalankan',
	'Stop on error' => 'Hentikan jika galat',
	'Show only errors' => 'Hanya tampilkan galat',
	'Time' => 'Waktu',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Riwayat',
	'Clear' => 'Bersihkan',
	'Edit all' => 'Sunting semua',

	// Import
	'Import' => 'Impor',
	'File upload' => 'Unggah berkas',
	'From server' => 'Dari server',
	'Webserver file %s' => 'Berkas server web %s',
	'Run file' => 'Jalankan berkas',
	'File does not exist.' => 'Berkas tidak ada.',
	'File uploads are disabled.' => 'Pengunggahan berkas dimatikan.',
	'Unable to upload a file.' => 'Tidak dapat mengunggah berkas.',
	'Maximum allowed file size is %sB.' => 'Besar berkas yang diizinkan adalah %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Jumlah berkas maksimum adalah %d. Pilih lebih sedikit berkas atau tingkatkan nilai direktif konfigurasi %s.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Ukuran total berkas maksimum adalah %s. Pilih berkas yang lebih kecil atau tingkatkan nilai direktif konfigurasi %s.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Data POST terlalu besar. Kurangi data atau perbesar direktif konfigurasi %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Anda dapat mengunggah berkas SQL besar melalui FTP dan mengimpornya dari server.', // by Claude Fable 5.1
	'File must be in UTF-8 encoding.' => 'Berkas harus dalam pengodean UTF-8.', // by Claude Fable 5.1
	'You are offline.' => 'Anda sedang luring.', // by Claude Fable 5.1
	'%d row(s) have been imported.' => '%d baris berhasil diimpor.',

	// Export
	'Export' => 'Ekspor',
	'Output' => 'Hasil',
	'open' => 'buka',
	'save' => 'simpan',
	'Format' => 'Format',
	'Data' => 'Data',

	// Databases
	'Database' => 'Basis data',
	'database' => 'basis data', // by Claude Fable 5.1
	'DB' => 'DB', // by Claude Fable 5.1
	'Use' => 'Gunakan',
	'Invalid database.' => 'Basis data tidak sah.',
	'Alter database' => 'Ubah basis data',
	'Create database' => 'Buat basis data',
	'Database schema' => 'Skema basis data',
	'Permanent link' => 'Pranala permanen',
	'Database has been dropped.' => 'Basis data berhasil dihapus.',
	'Databases have been dropped.' => 'Basis data berhasil dihapus.',
	'Database has been created.' => 'Basis data berhasil dibuat.',
	'Database has been renamed.' => 'Basis data berhasil diganti namanya.',
	'Database has been altered.' => 'Basis data berhasil diubah.',

	// SQLite errors
	'File exists.' => 'Berkas sudah ada.',
	'Please use one of the extensions %s.' => 'Harap gunakan salah satu ekstensi %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Skema',
	'schema' => 'skema', // by Claude Fable 5.1
	'Schemas' => 'Skema', // by Claude Fable 5.1
	'No schemas.' => 'Tidak ada skema.', // by Claude Fable 5.1
	'Show schema' => 'Lihat skema', // by Claude Fable 5.1
	'Alter schema' => 'Ubah skema',
	'Create schema' => 'Buat skema',
	'Schema has been dropped.' => 'Skema berhasil dihapus.',
	'Schema has been created.' => 'Skema berhasil dibuat.',
	'Schema has been altered.' => 'Skema berhasil diubah.',
	'Invalid schema.' => 'Skema tidak sah.',

	// Table list
	'All' => 'Semua', // checkbox selecting all tables and views // by Claude Fable 5.1
	'Engine' => 'Mesin',
	'engine' => 'mesin',
	'Collation' => 'Kolasi',
	'collation' => 'kolasi',
	'Data Length' => 'Panjang Data',
	'Index Length' => 'Panjang Indeks',
	'Data Free' => 'Data Bebas',
	'Rows' => 'Baris',
	'%d in total' => '%d total',
	'Analyze' => 'Analisis',
	'Optimize' => 'Optimalkan',
	'Vacuum' => 'Bersihkan', // by Claude Fable 5.1
	'Check' => 'Periksa',
	'Repair' => 'Perbaiki',
	'Truncate' => 'Kosongkan',
	'Truncate Cascade' => 'Kosongkan bertingkat', // by Claude Fable 5.1
	'Tables have been truncated.' => 'Tabel berhasil dikosongkan.',
	'Move to other database' => 'Pindahkan ke basis data lain',
	'Move' => 'Pindahkan',
	'Tables have been moved.' => 'Tabel berhasil dipindahkan.',
	'Copy' => 'Salin',
	'Tables have been copied.' => 'Tabel berhasil disalin.',
	'overwrite' => 'timpa', // by Claude Fable 5.1

	// Tables
	'Tables' => 'Tabel',
	'Tables and views' => 'Tabel dan tampilan',
	'Table' => 'Tabel',
	'No tables.' => 'Tidak ada tabel.',
	'Alter table' => 'Ubah tabel',
	'Create table' => 'Buat tabel',
	'Table has been dropped.' => 'Tabel berhasil dihapus.',
	'Tables have been dropped.' => 'Tabel berhasil dihapus.',
	'Tables have been optimized.' => 'Tabel berhasil dioptimalkan.',
	'Table has been altered.' => 'Tabel berhasil diubah.',
	'Table has been created.' => 'Tabel berhasil dibuat.',
	'Table name' => 'Nama tabel',
	'Name' => 'Nama',
	'Show structure' => 'Lihat struktur',
	'Column name' => 'Nama kolom',
	'Type' => 'Jenis',
	'Length' => 'Panjang',
	'Auto Increment' => 'Inkrementasi Otomatis',
	'Options' => 'Opsi',
	'Comment' => 'Komentar',
	'Default value' => 'Nilai bawaan', // by Claude Fable 5.1
	'Drop' => 'Hapus',
	'Drop %s?' => 'Hapus %s?', // by Claude Fable 5.1
	'Are you sure?' => 'Anda yakin?',
	'Size' => 'Ukuran', // by Claude Fable 5.1
	'Compute' => 'Hitung', // by Claude Fable 5.1
	'Move up' => 'Naik',
	'Move down' => 'Turun',
	'Remove' => 'Hapus',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Sudah lebih dumlah ruas maksimum yang diizinkan. Harap naikkan %s.',

	// Views
	'View' => 'Tampilan',
	'Materialized view' => 'Tampilan termaterialisasi', // by Claude Fable 5.1
	'View has been dropped.' => 'Tampilan berhasil dihapus.',
	'View has been altered.' => 'Tampilan berhasil diubah.',
	'View has been created.' => 'Tampilan berhasil dibuat.',
	'Alter view' => 'Ubah tampilan',
	'Create view' => 'Buat tampilan',

	// Partitions
	'Partition by' => 'Partisi menurut',
	'Partition' => 'Partisi', // by Claude Fable 5.1
	'Partitions' => 'Partisi',
	'Partition name' => 'Nama partisi',
	'Values' => 'Nilai',
	'Inherited tables' => 'Tabel turunan', // by Claude Fable 5.1
	'Inherited from' => 'Diwarisi dari', // by Claude Fable 5.1

	// Indexes
	'Indexes' => 'Indeks',
	'Indexes have been altered.' => 'Indeks berhasil diubah.',
	'Alter indexes' => 'Ubah indeks',
	'Add next' => 'Tambah setelahnya',
	'Index Type' => 'Jenis Indeks',
	'length' => 'panjang',
	'operator class' => 'kelas operator', // by Claude Fable 5.1
	'Algorithm' => 'Algoritme', // by Claude Fable 5.1
	'Condition' => 'Kondisi', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => 'Kunci asing',
	'Foreign key' => 'Kunci asing',
	'Foreign key has been dropped.' => 'Kunci asing berhasil dihapus.',
	'Foreign key has been altered.' => 'Kunci asing berhasil diubah.',
	'Foreign key has been created.' => 'Kunci asing berhasil dibuat.',
	'Target table' => 'Tabel sasaran',
	'Change' => 'Ubah',
	'Source' => 'Sumber',
	'Target' => 'Sasaran',
	'Add column' => 'Tambah kolom',
	'Alter' => 'Ubah',
	'Add foreign key' => 'Tambah kunci asing',
	'ON DELETE' => 'ON DELETE',
	'ON UPDATE' => 'ON UPDATE',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Kolom sumber dan sasaran harus memiliki jenis data yang sama. Kolom sasaran harus memiliki indeks dan data rujukan harus ada.',

	// Routines
	'Routines' => 'Rutin',
	'Routine has been called, %d row(s) affected.' => 'Rutin telah dipanggil, %d baris terpengaruh.',
	'Call' => 'Panggilan',
	'Parameter name' => 'Nama parameter',
	'Create procedure' => 'Buat prosedur',
	'Create function' => 'Buat fungsi',
	'Routine has been dropped.' => 'Rutin berhasil dihapus.',
	'Routine has been altered.' => 'Rutin berhasil diubah.',
	'Routine has been created.' => 'Rutin berhasil dibuat.',
	'Alter function' => 'Ubah fungsi',
	'Alter procedure' => 'Ubah prosedur',
	'Return type' => 'Jenis pengembalian',

	// Events
	'Events' => 'Even',
	'Event' => 'Even',
	'Event has been dropped.' => 'Even berhasil dihapus.',
	'Event has been altered.' => 'Even berhasil diubah.',
	'Event has been created.' => 'Even berhasil dibuat.',
	'Alter event' => 'Ubah even',
	'Create event' => 'Buat even',
	'At given time' => 'Pada waktu tertentu',
	'Every' => 'Setiap',
	'Schedule' => 'Jadwal',
	'Start' => 'Mulai',
	'End' => 'Selesai',
	'On completion preserve' => 'Pertahankan saat selesai',

	// Sequences (PostgreSQL)
	'Sequences' => 'Deret',
	'Create sequence' => 'Buat deret',
	'Sequence has been dropped.' => 'Deret berhasil dihapus.',
	'Sequence has been created.' => 'Deret berhasil dibuat.',
	'Sequence has been altered.' => 'Deret berhasil diubah.',
	'Alter sequence' => 'Ubah deret',

	// User-defined types (PostgreSQL)
	'User types' => 'Jenis pengguna',
	'Create type' => 'Buat jenis',
	'Type has been dropped.' => 'Jenis berhasil dihapus.',
	'Type has been created.' => 'Jenis berhasil dibuat.',
	'Alter type' => 'Ubah jenis',

	// Triggers
	'Triggers' => 'Pemicu',
	'Add trigger' => 'Tambah pemicu',
	'Trigger has been dropped.' => 'Pemicu berhasil dihapus.',
	'Trigger has been altered.' => 'Pemicu berhasil diubah.',
	'Trigger has been created.' => 'Pemicu berhasil dibuat.',
	'Alter trigger' => 'Ubah pemicu',
	'Create trigger' => 'Buat pemicu',

	// Table check constraints
	'Checks' => 'Pemeriksaan', // by Claude Fable 5.1
	'Create check' => 'Buat pemeriksaan', // by Claude Fable 5.1
	'Alter check' => 'Ubah pemeriksaan', // by Claude Fable 5.1
	'Check has been created.' => 'Pemeriksaan berhasil dibuat.', // by Claude Fable 5.1
	'Check has been altered.' => 'Pemeriksaan berhasil diubah.', // by Claude Fable 5.1
	'Check has been dropped.' => 'Pemeriksaan berhasil dihapus.', // by Claude Fable 5.1

	// Selection
	'Select data' => 'Pilih data',
	'Select' => 'Pilih',
	'Functions' => 'Fungsi',
	'Aggregation' => 'Agregasi',
	'Search' => 'Cari',
	'anywhere' => 'di mana pun',
	'Sort' => 'Urutkan',
	'descending' => 'menurun',
	'Limit' => 'Batas',
	'Limit rows' => 'Batas baris', // by Claude Fable 5.1
	'Text length' => 'Panjang teks',
	'Action' => 'Tindakan',
	'Full table scan' => 'Pindai tabel lengkap',
	'Unable to select the table' => 'Gagal memilih tabel',
	'Search data in tables' => 'Cari data dalam tabel',
	'All rows on this page' => 'Semua baris di halaman ini', // by Claude Fable 5.1
	'No rows.' => 'Tidak ada baris.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => '%d baris',
	'Page' => 'Halaman',
	'last' => 'terakhir',
	'Load more data' => 'Muat lebih banyak data', // by Claude Fable 5.1
	'Loading' => 'Memuat', // by Claude Fable 5.1
	'Whole result' => 'Seluruh hasil',
	'%d byte(s)' => '%d bita',

	// In-place editing in selection
	'Modify' => 'Ubah', // by Claude Fable 5.1
	'Ctrl+click on a value to modify it.' => 'Ctrl+klik pada nilai untuk mengubahnya.', // by Claude Fable 5.1
	'Use edit link to modify this value.' => 'Gunakan pranala suntingan untuk mengubah nilai ini.',

	// Editing
	'New item' => 'Entri baru',
	'Edit' => 'Sunting',
	'original' => 'asli',
	'empty' => 'kosong', // label for value '' in enum data type
	'Insert' => 'Sisipkan',
	'Save' => 'Simpan',
	'Save and continue edit' => 'Simpan dan lanjut menyunting',
	'Save and insert next' => 'Simpan dan sisipkan berikutnya',
	'Saving' => 'Menyimpan', // by Claude Fable 5.1
	'Selected' => 'Terpilih', // by Claude Fable 5.1
	'Clone' => 'Gandakan',
	'Delete' => 'Hapus',
	'Item%s has been inserted.' => 'Entri%s berhasil disisipkan.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Entri berhasil dihapus.',
	'Item has been updated.' => 'Entri berhasil diperbarui.',
	'%d item(s) have been affected.' => '%d entri terpengaruh.',
	'You have no privileges to update this table.' => 'Anda tidak memiliki hak istimewa untuk memperbarui tabel ini.', // by Claude Fable 5.1

	// Data type descriptions
	'Numbers' => 'Angka',
	'Date and time' => 'Tanggal dan waktu',
	'Strings' => 'String',
	'Binary' => 'Binari',
	'Lists' => 'Daftar',
	'Network' => 'Jaringan',
	'Geometry' => 'Geometri',
	'Relations' => 'Relasi',

	// Editor - data values
	'now' => 'sekarang', // by Claude Fable 5.1
	'yes' => 'yes',
	'no' => 'no',

	// Settings
	'Settings' => 'Pengaturan', // by Claude Fable 5.1
	'Default' => 'Bawaan', // by Claude Fable 5.1
	'Color scheme' => 'Skema warna', // by Claude Fable 5.1
	'By system' => 'Menurut sistem', // by Claude Fable 5.1
	'Light' => 'Terang', // by Claude Fable 5.1
	'Dark' => 'Gelap', // by Claude Fable 5.1
	'Navigation mode' => 'Mode navigasi', // by Claude Fable 5.1
	'Simple' => 'Sederhana', // by Claude Fable 5.1
	'Dual' => 'Ganda', // by Claude Fable 5.1
	'Dual on hover' => 'Ganda saat ditunjuk', // by Claude Fable 5.1
	'Reversed' => 'Terbalik', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => 'Tata letak navigasi utama dengan pranala tabel.', // by Claude Fable 5.1
	'Table links' => 'Pranala tabel', // by Claude Fable 5.1
	'Primary action for all table links.' => 'Tindakan utama untuk semua pranala tabel.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => 'Pranala ke tabel yang mereferensikan baris saat ini.', // by Claude Fable 5.1
	'Display' => 'Tampilkan', // by Claude Fable 5.1
	'Hide' => 'Sembunyikan', // by Claude Fable 5.1
	'Records per page' => 'Rekaman per halaman', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => 'Jumlah bawaan rekaman yang ditampilkan dalam tabel data.', // by Claude Fable 5.1
	'Enum as select' => 'Enum sebagai daftar pilihan', // by Claude Fable 5.1
	'Never' => 'Tidak pernah', // by Claude Fable 5.1
	'Always' => 'Selalu', // by Claude Fable 5.1
	'More values than %d' => 'Lebih dari %d nilai', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'Ambang batas untuk menampilkan daftar pilihan pada kolom enum.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => 'Sandi Sekali Pakai', // by Claude Fable 5.1
	'Enter OTP code.' => 'Masukkan kode OTP.', // by Claude Fable 5.1
	'Invalid OTP code.' => 'Kode OTP tidak sah.', // by Claude Fable 5.1
	'Access denied.' => 'Akses ditolak.', // by Claude Fable 5.1
	'JSON previews' => 'Pratinjau JSON', // by Claude Fable 5.1
	'Data table' => 'Tabel data', // by Claude Fable 5.1
	'Edit form' => 'Formulir suntingan', // by Claude Fable 5.1
	'Ask %s' => 'Tanya %s', // by Claude Fable 5.1
];
