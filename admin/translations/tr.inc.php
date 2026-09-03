<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ' ', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$6.$4.$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'G.A.YYYY', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'SS:DD:ss', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s bir dizi döndürmelidir.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => '%s ve %s, %s yöntemiyle oluşturulmuş bir nesne döndürmelidir.', // by Claude Opus 5

	// Login
	'System' => 'Sistem',
	'Server' => 'Sunucu',
	'Username' => 'Kullanıcı',
	'Password' => 'Parola',
	'Permanent login' => 'Beni hatırla',
	'Login' => 'Giriş',
	'Logout' => 'Çıkış',
	'Logged as: %s' => '%s olarak giriş yapıldı',
	'Logout successful.' => 'Oturum başarıyla sonlandı.',
	'hostname[:port] or :socket' => 'hostname[:port] veya :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Geçersiz sunucu veya kimlik bilgileri.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Girilen parolada boşluk var, sorunun nedeni bu olabilir.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo parolasız bir veri tabanına erişimi desteklemez, <a href="https://www.adminneo.org/password"%s>daha fazla bilgi</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Veri tabanı parolayı desteklemez.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => 'Çok fazla başarısız giriş denemesi, %d dakika sonra tekrar deneyin.', // by Claude Opus 5
	'Invalid permanent login, please login again.' => 'Geçersiz kalıcı oturum, lütfen tekrar giriş yapın.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Geçersiz (CSRF) jetonu. Formu tekrar yolla.',
	'If you did not send this request from AdminNeo then close this page.' => 'Bu isteği AdminNeo\'den göndermediyseniz bu sayfayı kapatın.',
	'The action will be performed after successful login with the same credentials.' => 'İşlem, aynı kimlik bilgileriyle başarıyla oturum açıldıktan sonra gerçekleştirilecektir.',

	// Connection
	'No extension' => 'Uzantı yok',
	'None of the supported PHP extensions (%s) are available.' => 'Desteklenen PHP eklentilerinden (%s) hiçbiri mevcut değil.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Ayrıcalıklı bağlantı noktalarına bağlanmaya izin verilmiyor.',
	'Session support must be enabled.' => 'Oturum desteği etkin olmalıdır.',
	'Session expired, please login again.' => 'Oturum süresi doldu, lütfen tekrar giriş yapın.',
	'%s version: %s through PHP extension %s' => '%s sürüm: %s, %s PHP eklentisi ile',

	// Settings
	'Language' => 'Dil',

	'Menu' => 'Menü', // by Claude Opus 5
	'Home' => 'Ana sayfa', // by Claude Opus 5
	'Refresh' => 'Tazele',
	'Info' => 'Bilgi', // by Claude Opus 5
	'More information.' => 'Daha fazla bilgi.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'İzinler',
	'Create user' => 'Kullanıcı oluştur',
	'User has been dropped.' => 'Kullanıcı silindi.',
	'User has been altered.' => 'Kullanıcı değiştirildi.',
	'User has been created.' => 'Kullanıcı oluşturuldu.',
	'Hashed' => 'Harmanlandı',

	// Server
	'Process list' => 'İşlem listesi',
	'%d process(es) have been killed.' => [
		'%d işlem sonlandırıldı.',
		'%d adet işlem sonlandırıldı.',
	],
	'Kill' => 'Sonlandır',
	'Variables' => 'Değişkenler',
	'Status' => 'Durum',

	// Structure
	'Column' => 'Kolon',
	'Columns' => 'Kolonlar', // by Claude Fable 5
	'Routine' => 'Yordam',
	'Grant' => 'Yetki Ver',
	'Revoke' => 'Yetki Kaldır',

	// Queries
	'SQL command' => 'SQL komutu',
	'HTTP request' => 'HTTP isteği', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'%d sorgu başarıyla çalıştırıldı.',
		'%d adet sorgu başarıyla çalıştırıldı.',
	],
	'Query executed OK, %d row(s) affected.' => 'Sorgu başarıyla çalıştırıldı, %d adet kayıt etkilendi.',
	'No commands to execute.' => 'Çalıştırılacak komut yok.',
	'Error in query' => 'Sorguda hata',
	'Unknown error.' => 'Bilinmeyen hata.', // by Claude Fable 5
	'Warnings' => 'Uyarılar',
	'%s queries are not supported.' => '%s sorguları desteklenmiyor.',
	'Execute' => 'Çalıştır',
	'Stop on error' => 'Hata oluşursa dur',
	'Show only errors' => 'Sadece hataları göster',
	'Time' => 'Zaman',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Geçmiş',
	'Clear' => 'Temizle',
	'Edit all' => 'Tümünü düzenle',

	// Import
	'Import' => 'İçeri Aktar',
	'File upload' => 'Dosya gönder',
	'From server' => 'Sunucudan',
	'Webserver file %s' => '%s web sunucusu dosyası',
	'Run file' => 'Dosyayı çalıştır',
	'File does not exist.' => 'Dosya mevcut değil.',
	'File uploads are disabled.' => 'Dosya gönderimi etkin değil.',
	'Unable to upload a file.' => 'Dosya gönderilemiyor.',
	'Maximum allowed file size is %sB.' => 'İzin verilen dosya boyutu sınırı %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'En fazla dosya sayısı %d. Daha az dosya seçin ya da %s ayar yönergesini artırın.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Dosyaların toplam boyut sınırı %s. Daha küçük dosyalar seçin ya da %s ayar yönergesini artırın.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Çok büyük POST verisi, veriyi azaltın ya da %s ayar yönergesini uygun olarak yapılandırın.',
	'You can upload a big SQL file via FTP and import it from server.' => 'FTP yoluyla büyük bir SQL dosyası yükleyebilir ve sunucudan içe aktarabilirsiniz.',
	'File must be in UTF-8 encoding.' => 'Dosya UTF-8 kodlamasında olmalıdır.',
	'You are offline.' => 'Çevrimdışısınız.',
	'%d row(s) have been imported.' => [
		'%d kayıt içeri aktarıldı.',
		'%d adet kayıt içeri aktarıldı.',
	],

	// Export
	'Export' => 'Dışarı Aktar',
	'Output' => 'Çıktı',
	'open' => 'aç',
	'save' => 'kaydet',
	'Format' => 'Biçim',
	'Data' => 'Veri',

	// Databases
	'Database' => 'Veri Tabanı',
	'database' => 'veri tabanı', // by Claude Opus 5
	'DB' => 'DB',
	'Use' => 'Kullan',
	'Invalid database.' => 'Geçersiz veri tabanı.',
	'Alter database' => 'Veri tabanını değiştir',
	'Create database' => 'Veri tabanı oluştur',
	'Database schema' => 'Veri tabanı şeması',
	'Permanent link' => 'Kalıcı bağlantı',
	'Database has been dropped.' => 'Veri tabanı silindi.',
	'Databases have been dropped.' => 'Veritabanları silindi.',
	'Database has been created.' => 'Veri tabanı oluşturuldu.',
	'Database has been renamed.' => 'Veri tabanının ismi değiştirildi.',
	'Database has been altered.' => 'Veri tabanı değiştirildi.',

	// SQLite errors
	'File exists.' => 'Dosya zaten mevcut.',
	'Please use one of the extensions %s.' => '%s uzantılarından birini kullanın.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Şema',
	'schema' => 'şema', // by Claude Opus 5
	'Schemas' => 'Şemalar', // by Claude Opus 5
	'No schemas.' => 'Şema yok.', // by Claude Opus 5
	'Show schema' => 'Şemayı göster', // by Claude Opus 5
	'Alter schema' => 'Şemayı değiştir',
	'Create schema' => 'Şema oluştur',
	'Schema has been dropped.' => 'Şema silindi.',
	'Schema has been created.' => 'Şema oluşturuldu.',
	'Schema has been altered.' => 'Şema değiştirildi.',
	'Invalid schema.' => 'Geçersiz şema.',

	// Table list
	'Engine' => 'Motor',
	'engine' => 'motor',
	'Collation' => 'Karşılaştırma',
	'collation' => 'karşılaştırma',
	'Data Length' => 'Veri Uzunluğu',
	'Index Length' => 'İndex Uzunluğu',
	'Data Free' => 'Boş Veri',
	'Rows' => 'Kayıtlar',
	'%d in total' => 'toplam %d',
	'Analyze' => 'Çözümle',
	'Optimize' => 'Optimize Et',
	'Vacuum' => 'Vakumla',
	'Check' => 'Denetle',
	'Repair' => 'Tamir Et',
	'Truncate' => 'Boşalt',
	'Truncate Cascade' => 'Kademeli boşalt', // by Claude Fable 5
	'Tables have been truncated.' => 'Tablolar boşaltıldı.',
	'Move to other database' => 'Başka veri tabanına taşı',
	'Move' => 'Taşı',
	'Tables have been moved.' => 'Tablolar taşındı.',
	'Copy' => 'Kopyala',
	'Tables have been copied.' => 'Tablolar kopyalandı.',
	'overwrite' => 'üzerine yaz', // by Claude Fable 5

	// Tables
	'Tables' => 'Tablolar',
	'Tables and views' => 'Tablolar ve görünümler',
	'Table' => 'Tablo',
	'No tables.' => 'Tablo yok.',
	'Alter table' => 'Tabloyu değiştir',
	'Create table' => 'Tablo oluştur',
	'Table has been dropped.' => 'Tablo silindi.',
	'Tables have been dropped.' => 'Tablolar silindi.',
	'Tables have been optimized.' => 'Tablolar en uygun hale getirildi.',
	'Table has been altered.' => 'Tablo değiştirildi.',
	'Table has been created.' => 'Tablo oluşturuldu.',
	'Table name' => 'Tablo adı',
	'Name' => 'Ad',
	'Show structure' => 'Yapıyı göster',
	'Column name' => 'Kolon adı',
	'Type' => 'Tür',
	'Length' => 'Uzunluk',
	'Auto Increment' => 'Otomatik Artır',
	'Options' => 'Seçenekler',
	'Comment' => 'Yorum',
	'Default value' => 'Varsayılan değer',
	'Drop' => 'Sil',
	'Drop %s?' => 'Sil %s?',
	'Are you sure?' => 'Emin misiniz?',
	'Size' => 'Boyut',
	'Compute' => 'Hesapla',
	'Move up' => 'Yukarı taşı',
	'Move down' => 'Aşağı taşı',
	'Remove' => 'Sil',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'İzin verilen en fazla alan sayısı aşıldı. Lütfen %s değerlerini artırın.',

	// Views
	'View' => 'Görünüm',
	'Materialized view' => 'Materialized Görünüm',
	'View has been dropped.' => 'Görünüm silindi.',
	'View has been altered.' => 'Görünüm değiştirildi.',
	'View has been created.' => 'Görünüm oluşturuldu.',
	'Alter view' => 'Görünümü değiştir',
	'Create view' => 'Görünüm oluştur',

	// Partitions
	'Partition by' => 'Bununla bölümle',
	'Partition' => 'Bölüm', // by Claude Opus 5
	'Partitions' => 'Bölümler',
	'Partition name' => 'Bölüm adı',
	'Values' => 'Değerler',
	'Inherited tables' => 'Miras alınan tablolar', // by Claude Opus 5
	'Inherited from' => 'Miras alındığı tablo', // by Claude Opus 5

	// Indexes
	'Indexes' => 'İndeksler',
	'Indexes have been altered.' => 'İndeksler değiştirildi.',
	'Alter indexes' => 'İndeksleri değiştir',
	'Add next' => 'Bundan sonra ekle',
	'Index Type' => 'İndex Türü',
	'length' => 'uzunluğu',
	'operator class' => 'operatör sınıfı', // by Claude Fable 5
	'Algorithm' => 'Algoritma', // by Claude Fable 5
	'Condition' => 'Koşul', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Dış anahtarlar',
	'Foreign key' => 'Dış anahtar',
	'Foreign key has been dropped.' => 'Dış anahtar silindi.',
	'Foreign key has been altered.' => 'Dış anahtar değiştirildi.',
	'Foreign key has been created.' => 'Dış anahtar oluşturuldu.',
	'Target table' => 'Hedef tablo',
	'Change' => 'Değiştir',
	'Source' => 'Kaynak',
	'Target' => 'Hedef',
	'Add column' => 'Kolon ekle',
	'Alter' => 'Değiştir',
	'Add foreign key' => 'Dış anahtar ekle',
	'ON DELETE' => 'ON DELETE (Hedefteki Kayıt Silinirse)',
	'ON UPDATE' => 'ON UPDATE (Hedefteki Kayıt Değiştirilirse)',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Kaynak ve hedef kolonlar aynı veri türünde olmalı, hedef kolonlarda dizin bulunmalı ve başvurulan veri mevcut olmalı.',

	// Routines
	'Routines' => 'Yordamlar',
	'Routine has been called, %d row(s) affected.' => [
		'Yordam çağrıldı, %d adet kayıt etkilendi.',
		'Yordam çağrıldı, %d kayıt etkilendi.',
	],
	'Call' => 'Çağır',
	'Parameter name' => 'Parametre adı',
	'Create procedure' => 'Yöntem oluştur',
	'Create function' => 'Fonksiyon oluştur',
	'Routine has been dropped.' => 'Yordam silindi.',
	'Routine has been altered.' => 'Yordam değiştirildi.',
	'Routine has been created.' => 'Yordam oluşturuldu.',
	'Alter function' => 'Fonksyionu değiştir',
	'Alter procedure' => 'Yöntemi değiştir',
	'Return type' => 'Geri dönüş türü',

	// Events
	'Events' => 'Olaylar',
	'Event' => 'Olay',
	'Event has been dropped.' => 'Olay silindi.',
	'Event has been altered.' => 'Olay değiştirildi.',
	'Event has been created.' => 'Olay oluşturuldu.',
	'Alter event' => 'Olayı değiştir',
	'Create event' => 'Olay oluştur',
	'At given time' => 'Verilen zamanda',
	'Every' => 'Her zaman',
	'Schedule' => 'Takvimli',
	'Start' => 'Başla',
	'End' => 'Son',
	'On completion preserve' => 'Tamamlama koruması',

	// Sequences (PostgreSQL)
	'Sequences' => 'Diziler',
	'Create sequence' => 'Dizi oluştur',
	'Sequence has been dropped.' => 'Dizi silindi.',
	'Sequence has been created.' => 'Dizi oluşturuldu.',
	'Sequence has been altered.' => 'Dizi değiştirildi.',
	'Alter sequence' => 'Diziyi değiştir',

	// User-defined types (PostgreSQL)
	'User types' => 'Kullanıcı türleri',
	'Create type' => 'Tür oluştur',
	'Type has been dropped.' => 'Tür silindi.',
	'Type has been created.' => 'Tür oluşturuldu.',
	'Alter type' => 'Türü değiştir',

	// Triggers
	'Triggers' => 'Tetikler',
	'Add trigger' => 'Tetik ekle',
	'Trigger has been dropped.' => 'Tetik silindi.',
	'Trigger has been altered.' => 'Tetik değiştirildi.',
	'Trigger has been created.' => 'Tetik oluşturuldu.',
	'Alter trigger' => 'Tetiği değiştir',
	'Create trigger' => 'Tetik oluştur',

	// Table check constraints
	'Checks' => 'Kontroller', // by Claude Fable 5
	'Create check' => 'Kontrol oluştur', // by Claude Fable 5
	'Alter check' => 'Kontrolü değiştir', // by Claude Fable 5
	'Check has been created.' => 'Kontrol oluşturuldu.', // by Claude Fable 5
	'Check has been altered.' => 'Kontrol değiştirildi.', // by Claude Fable 5
	'Check has been dropped.' => 'Kontrol silindi.', // by Claude Fable 5

	// Selection
	'Select data' => 'Veri seç',
	'Select' => 'Seç',
	'Functions' => 'Fonksiyonlar',
	'Aggregation' => 'Kümeleme',
	'Search' => 'Ara',
	'anywhere' => 'herhangi bir yerde', // by Claude Opus 5
	'Sort' => 'Sırala',
	'descending' => 'Azalan',
	'Limit' => 'Limit',
	'Limit rows' => 'Satır Limiti',
	'Text length' => 'Metin Boyutu',
	'Action' => 'İşlem',
	'Full table scan' => 'Tam tablo taraması',
	'Unable to select the table' => 'Tablo seçilemedi',
	'Search data in tables' => 'Tablolarda veri ara',
	'No rows.' => 'Kayıt yok.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d kayıt',
		'%d adet kayıt',
	],
	'Page' => 'Sayfa',
	'last' => 'son',
	'Load more data' => 'Daha fazla veri yükle',
	'Loading' => 'Yükleniyor',
	'Whole result' => 'Tüm sonuç',
	'%d byte(s)' => '%d bayt',

	// In-place editing in selection
	'Modify' => 'Düzenle',
	'Ctrl+click on a value to modify it.' => 'Bir değeri değiştirmek için üzerine Ctrl+tıklayın.',
	'Use edit link to modify this value.' => 'Değeri değiştirmek için düzenleme bağlantısını kullanın.',

	// Editing
	'New item' => 'Yeni kayıt',
	'Edit' => 'Düzenle',
	'original' => 'orijinal',
	'empty' => 'boş', // label for value '' in enum data type
	'Insert' => 'Ekle',
	'Save' => 'Kaydet',
	'Save and continue edit' => 'Kaydet ve düzenlemeye devam et',
	'Save and insert next' => 'Kaydet ve sonrakini ekle',
	'Saving' => 'Saydediliyor',
	'Selected' => 'Seçildi',
	'Clone' => 'Kopyala',
	'Delete' => 'Sil',
	'Item%s has been inserted.' => 'Kayıt%s eklendi.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Kayıt silindi.',
	'Item has been updated.' => 'Kayıt güncellendi.',
	'%d item(s) have been affected.' => [
		'%d kayıt etkilendi.',
		'%d adet kayıt etkilendi.',
	],
	'You have no privileges to update this table.' => 'Bu tabloyu güncellemek için yetkiniz yok.',

	// Data type descriptions
	'Numbers' => 'Sayılar',
	'Date and time' => 'Tarih ve zaman',
	'Strings' => 'Dizge',
	'Binary' => 'İkili',
	'Lists' => 'Listeler',
	'Network' => 'Ağ',
	'Geometry' => 'Geometri',
	'Relations' => 'İlişkiler',

	// Editor - data values
	'now' => 'şimdi',
	'yes' => 'evet',
	'no' => 'hayır',

	// Settings
	'Settings' => 'Ayarlar', // by Claude Opus 5
	'Default' => 'Varsayılan', // by Claude Opus 5
	'Color scheme' => 'Renk şeması', // by Claude Opus 5
	'By system' => 'Sisteme göre', // by Claude Opus 5
	'Light' => 'Açık', // by Claude Opus 5
	'Dark' => 'Koyu', // by Claude Opus 5
	'Navigation mode' => 'Gezinme kipi', // by Claude Opus 5
	'Simple' => 'Basit', // by Claude Opus 5
	'Dual' => 'İkili', // by Claude Opus 5
	'Dual on hover' => 'İkili (üzerine gelince)', // by Claude Opus 5
	'Reversed' => 'Ters', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Tablo bağlantılarını içeren ana gezinme yerleşimi.', // by Claude Opus 5
	'Table links' => 'Tablo bağlantıları', // by Claude Opus 5
	'Primary action for all table links.' => 'Tüm tablo bağlantıları için birincil işlem.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Geçerli kaydı referans alan tablolara bağlantılar.', // by Claude Opus 5
	'Display' => 'Göster', // by Claude Opus 5
	'Hide' => 'Gizle', // by Claude Opus 5
	'Records per page' => 'Sayfa başına kayıt', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Veri tablosunda gösterilen varsayılan kayıt sayısı.', // by Claude Opus 5
	'Enum as select' => 'Enum seçim listesi olarak', // by Claude Opus 5
	'Never' => 'Asla', // by Claude Opus 5
	'Always' => 'Her zaman', // by Claude Opus 5
	'More values than %d' => '%d değerden fazlaysa', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Enum kolonları için seçim listesi gösterme eşiği.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Tek Kullanımlık Parola', // by Claude Opus 5
	'Enter OTP code.' => 'OTP kodunu girin.', // by Claude Opus 5
	'Invalid OTP code.' => 'Geçersiz OTP kodu.', // by Claude Opus 5
	'Access denied.' => 'Erişim reddedildi.', // by Claude Opus 5
	'JSON previews' => 'JSON önizlemeleri', // by Claude Opus 5
	'Data table' => 'Veri tablosu', // by Claude Opus 5
	'Edit form' => 'Düzenleme formu', // by Claude Opus 5
	'Ask %s' => '%s uygulamasına sor', // by Claude Opus 5
];
