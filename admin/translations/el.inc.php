<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => '.', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$5/$3/$1', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'ΗΗ/ΜΜ/ΕΕΕΕ', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => 'ΩΩ:ΛΛ:ΔΔ', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => 'Η %s πρέπει να επιστρέφει πίνακα.', // by Claude Opus 5
	'%s and %s must return an object created by %s method.' => 'Οι %s και %s πρέπει να επιστρέφουν αντικείμενο που δημιουργήθηκε από τη μέθοδο %s.', // by Claude Opus 5

	// Login
	'System' => 'Σύστημα',
	'Server' => 'Διακομιστής',
	'Username' => 'Όνομα Χρήστη',
	'Password' => 'Κωδικός',
	'Permanent login' => 'Μόνιμη Σύνδεση',
	'Login' => 'Σύνδεση',
	'Logout' => 'Αποσύνδεση',
	'Logged as: %s' => 'Συνδεθήκατε ως %s',
	'Logout successful.' => 'Αποσυνδεθήκατε με επιτυχία.',
	'hostname[:port] or :socket' => 'hostname[:port] ή :socket', // by Claude Fable 5
	'Invalid server or credentials.' => 'Λανθασμένος διακομιστής ή στοιχεία σύνδεσης.', // by Claude Opus 5
	'There is a space in the input password which might be the cause.' => 'Υπάρχει ένα κενό στον κωδικό που εισαγάγατε, το οποίο μπορεί να είναι η αιτία.', // by Claude Fable 5
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'Το AdminNeo δεν υποστηρίζει πρόσβαση σε βάση δεδομένων χωρίς κωδικό, <a href="https://www.adminneo.org/password"%s>περισσότερες πληροφορίες</a>.', // by Claude Fable 5
	'Database does not support password.' => 'Η βάση δεδομένων δεν υποστηρίζει κωδικό.', // by Claude Fable 5
	'Too many unsuccessful logins, try again in %d minute(s).' => [
		'Επανειλημμένες ανεπιτυχείς προσπάθειες σύνδεσης, δοκιμάστε ξανά σε %d λεπτό.',
		'Επανειλημμένες ανεπιτυχείς προσπάθειες σύνδεσης, δοκιμάστε ξανά σε %d λεπτά.',
	],
	'Invalid permanent login, please login again.' => 'Άκυρη μόνιμη σύνδεση, παρακαλώ συνδεθείτε ξανά.', // by Claude Opus 5
	'Invalid CSRF token. Send the form again.' => 'Άκυρο κουπόνι CSRF. Στείλτε τη φόρμα ξανά.',
	'If you did not send this request from AdminNeo then close this page.' => 'Αν δε στείλατε αυτό το αίτημα από το AdminNeo, τότε κλείστε αυτή τη σελίδα.',
	'The action will be performed after successful login with the same credentials.' => 'Η ενέργεια θα εκτελεστεί μετά από επιτυχή σύνδεση με τα ίδια διαπιστευτήρια.', // by Claude Fable 5

	// Connection
	'No driver' => 'Κανένας οδηγός', // by Claude Opus 5
	'Database driver not found.' => 'Δεν βρέθηκε ο οδηγός της Β.Δ.', // by Claude Opus 5
	'No extension' => 'Καμία Επέκταση',
	'None of the supported PHP extensions (%s) are available.' => 'Καμία από τις υποστηριζόμενες επεκτάσεις PHP (%s) δεν είναι διαθέσιμη.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => 'Η σύνδεση σε προνομιούχες θύρες δεν επιτρέπεται.', // by Claude Fable 5
	'Session support must be enabled.' => 'Πρέπει να είναι ενεργοποιημένη η υποστήριξη συνεδριών.',
	'Session expired, please login again.' => 'Η συνεδρία έληξε, παρακαλώ συνδεθείτε ξανά.',
	'%s version: %s through PHP extension %s' => '%s έκδοση: %s μέσω επέκτασης PHP %s',

	// Settings
	'Language' => 'Γλώσσα',

	'Home' => 'Αρχική', // by Claude Opus 5
	'Refresh' => 'Ανανέωση',
	'Info' => 'Πληροφορίες', // by Claude Opus 5
	'More information.' => 'Περισσότερες πληροφορίες.', // by Claude Opus 5

	// Privileges
	'Privileges' => 'Δικαιώματα',
	'Create user' => 'Δημιουργία Χρήστη',
	'User has been dropped.' => 'Ο Χρήστης διαγράφηκε.',
	'User has been altered.' => 'Ο Χρήστης τροποποιήθηκε.',
	'User has been created.' => 'Ο Χρήστης δημιουργήθηκε.',
	'Hashed' => 'Κωδικοποιήθηκε',

	// Server
	'Process list' => 'Λίστα διεργασιών',
	'%d process(es) have been killed.' => [
		'Τερματίστηκε %d διεργασία.',
		'Τερματίστηκαν %d διεργασίες.',
	],
	'Kill' => 'Τερματισμός',
	'Variables' => 'Μεταβλητές',
	'Status' => 'Κατάσταση',

	// Structure
	'Column' => 'Στήλη',
	'Columns' => 'Στήλες', // by Claude Fable 5
	'Routine' => 'Ρουτίνα',
	'Grant' => 'Παραχώρηση',
	'Revoke' => 'Ανάκληση',

	// Queries
	'SQL command' => 'Εντολή SQL',
	'HTTP request' => 'Αίτημα HTTP', // by Claude Opus 5
	'%d query(s) executed OK.' => [
		'Το ερώτημα %d εκτελέστηκε ΟΚ.',
		'Τα ερώτηματα %d εκτελέστηκαν ΟΚ.',
	],
	'Query executed OK, %d row(s) affected.' => [
		'Το ερώτημα εκτελέστηκε ΟΚ, επηρεάστηκε %d σειρά.',
		'Το ερώτημα εκτελέστηκε ΟΚ, επηρεάστηκαν %d σειρές.',
	],
	'No commands to execute.' => 'Δεν υπάρχουν εντολές να εκτελεστούν.',
	'Error in query' => 'Σφάλμα στο ερώτημα',
	'Unknown error.' => 'Άγνωστο σφάλμα.', // by Claude Fable 5
	'Warnings' => 'Προειδοποιήσεις', // by Claude Fable 5
	'%s queries are not supported.' => 'Τα ερωτήματα %s δεν υποστηρίζονται.', // by Claude Fable 5
	'Execute' => 'Εκτέλεση',
	'Stop on error' => 'Διακοπή όταν υπάρχει σφάλμα',
	'Show only errors' => 'Να εμφανίζονται μόνο τα σφάλματα',
	'Time' => 'Ώρα',
	'%.3f s' => '%.3f s', // sprintf() format for time of the command
	'History' => 'Ιστορικό',
	'Clear' => 'Καθαρισμός',
	'Edit all' => 'Επεξεργασία όλων',

	// Import
	'Import' => 'Εισαγωγή',
	'File upload' => 'Μεταφόρτωση αρχείου',
	'From server' => 'Από διακομιστή',
	'Webserver file %s' => 'Αρχείο %s από διακομιστή web',
	'Run file' => 'Εκτέλεση αρχείου',
	'File does not exist.' => 'Το αρχείο δεν υπάρχει.',
	'File uploads are disabled.' => 'Έχει απενεργοποιηθεί η μεταφόρτωση αρχείων.',
	'Unable to upload a file.' => 'Αδυναμία μεταφόρτωσης αρχείου.',
	'Maximum allowed file size is %sB.' => 'Το μέγιστο επιτρεπόμενο μέγεθος αρχείου είναι %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => 'Ο μέγιστος αριθμός αρχείων είναι %d. Επιλέξτε λιγότερα αρχεία ή αυξήστε την σχετική ρύθμιση %s.', // by Claude Opus 5
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => 'Το μέγιστο συνολικό μέγεθος των αρχείων είναι %s. Επιλέξτε μικρότερα αρχεία ή αυξήστε την σχετική ρύθμιση %s.', // by Claude Opus 5
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'Πολλά δεδομένα POST. Μείωστε τα περιεχόμενα ή αυξήστε την σχετική ρύθμιση %s.',
	'You can upload a big SQL file via FTP and import it from server.' => 'Μπορείτε να μεταφορτώσετε ένα μεγάλο αρχείο SQL μέσω FTP και να το εισάγετε από το διακομιστή.',
	'File must be in UTF-8 encoding.' => 'Το αρχείο πρέπει να έχει κωδικοποίηση UTF-8.',
	'You are offline.' => 'Βρίσκεστε εκτός σύνδεσης.',
	'%d row(s) have been imported.' => [
		'%d σειρά εισήχθη.',
		'%d σειρές εισήχθησαν.',
	],

	// Export
	'Export' => 'Εξαγωγή',
	'Output' => 'Αποτέλεσμα',
	'open' => 'άνοιγμα',
	'save' => 'αποθήκευση',
	'Format' => 'Μορφή',
	'Data' => 'Δεδομένα',

	// Databases
	'Database' => 'Β. Δεδομένων',
	'database' => 'β. δεδομένων', // by Claude Opus 5
	'DB' => 'ΒΔ', // by Claude Fable 5
	'Use' => 'χρήση',
	'Invalid database.' => 'Λανθασμένη Β.Δ.',
	'Alter database' => 'Τροποποίηση Β.Δ.',
	'Create database' => 'Δημιουργία Β.Δ.',
	'Database schema' => 'Σχήμα Β.Δ.',
	'Permanent link' => 'Μόνιμος Σύνδεσμος',
	'Database has been dropped.' => 'Η Β.Δ. διαγράφηκε.',
	'Databases have been dropped.' => 'Οι Β.Δ. διαγράφηκαν.',
	'Database has been created.' => 'Η Β.Δ. δημιουργήθηκε.',
	'Database has been renamed.' => 'Η. Β.Δ. μετονομάστηκε.',
	'Database has been altered.' => 'Η Β.Δ. τροποποιήθηκε.',

	// SQLite errors
	'File exists.' => 'Το αρχείο υπάρχει.',
	'Please use one of the extensions %s.' => 'Παρακαλώ χρησιμοποιείστε μια από τις επεκτάσεις %s.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => 'Σχήμα',
	'schema' => 'σχήμα', // by Claude Opus 5
	'Schemas' => 'Σχήματα', // by Claude Opus 5
	'No schemas.' => 'Χωρίς σχήματα.', // by Claude Opus 5
	'Show schema' => 'Προβολή σχήματος', // by Claude Opus 5
	'Alter schema' => 'Τροποποίηση σχήματος',
	'Create schema' => 'Δημιουργία σχήματος',
	'Schema has been dropped.' => 'Το σχήμα διαγράφηκε.',
	'Schema has been created.' => 'Το σχήμα δημιουργήθηκε.',
	'Schema has been altered.' => 'Το σχήμα τροποποιήθηκε.',
	'Invalid schema.' => 'Άκυρο σχήμα.',

	// Table list
	'Engine' => 'Μηχανή',
	'engine' => 'μηχανή',
	'Collation' => 'Collation',
	'collation' => 'collation',
	'Data Length' => 'Μήκος Δεδομένων',
	'Index Length' => 'Μήκος Δείκτη',
	'Data Free' => 'Δεδομένα Ελεύθερα',
	'Rows' => 'Σειρές',
	'%d in total' => '%d συνολικά',
	'Analyze' => 'Ανάλυση',
	'Optimize' => 'Βελτιστοποίηση',
	'Vacuum' => 'Καθαρισμός',
	'Check' => 'Έλεγχος',
	'Repair' => 'Επιδιόρθωση',
	'Truncate' => 'Περικοπή',
	'Tables have been truncated.' => 'Οι πίνακες περικόπηκαν.',
	'Move to other database' => 'Μεταφορά σε άλλη Β.Δ.',
	'Move' => 'Μεταφορά',
	'Tables have been moved.' => 'Οι πίνακες μεταφέρθηκαν.',
	'Copy' => 'Αντιγραφή',
	'Tables have been copied.' => 'Οι πίνακες αντιγράφηκαν.',
	'overwrite' => 'αντικατάσταση', // by Claude Fable 5

	// Tables
	'Tables' => 'Πίνακες',
	'Tables and views' => 'Πίνακες και Προβολές',
	'Table' => 'Πίνακας',
	'No tables.' => 'Χωρίς πίνακες.',
	'Alter table' => 'Τροποποίηση πίνακα',
	'Create table' => 'Δημιουργία πίνακα',
	'Table has been dropped.' => 'Ο πίνακας διαγράφηκε.',
	'Tables have been dropped.' => 'Οι πίνακες διαγράφηκαν.',
	'Tables have been optimized.' => 'Οι πίνακες βελτιστοποιήθηκαν.',
	'Table has been altered.' => 'Ο πίνακας τροποποιήθηκε.',
	'Table has been created.' => 'Ο πίνακας δημιουργήθηκε.',
	'Table name' => 'Όνομα πίνακα',
	'Name' => 'Όνομα',
	'Show structure' => 'Προβολή δομής',
	'Column name' => 'Όνομα στήλης',
	'Type' => 'Τύπος',
	'Length' => 'Μήκος',
	'Auto Increment' => 'Αυτόματη αρίθμηση',
	'Options' => 'Επιλογές',
	'Comment' => 'Σχόλιο',
	'Default value' => 'Προεπιλεγμένη τιμή',
	'Drop' => 'Διαγραφή',
	'Drop %s?' => 'Διαγραφή %s;', // by Claude Fable 5
	'Are you sure?' => 'Είστε σίγουρος;',
	'Size' => 'Μέγεθος',
	'Compute' => 'Υπολογισμός',
	'Move up' => 'Μετακίνηση προς τα επάνω',
	'Move down' => 'Μετακίνηση προς τα κάτω',
	'Remove' => 'Αφαίρεση',
	'Maximum number of allowed fields exceeded. Please increase %s.' => 'Υπέρβαση μέγιστου επιτρεπόμενου αριθμού πεδίων. Παρακαλώ αυξήστε %s.',

	// Views
	'View' => 'Προβολή',
	'Materialized view' => 'Υλοποιημένη προβολή',
	'View has been dropped.' => 'Η προβολή διαγράφηκε.',
	'View has been altered.' => 'Η προβολή τροποποιήθηκε.',
	'View has been created.' => 'Η προβολή δημιουργήθηκε.',
	'Alter view' => 'Τροποποίηση προβολής',
	'Create view' => 'Δημιουργία προβολής',

	// Partitions
	'Partition by' => 'Τμηματοποίηση ανά',
	'Partition' => 'Τμήμα', // by Claude Opus 5
	'Partitions' => 'Τμήματα',
	'Partition name' => 'Όνομα Τμήματος',
	'Values' => 'Τιμές',
	'Inherited tables' => 'Κληρονομημένοι πίνακες', // by Claude Opus 5
	'Inherited from' => 'Κληρονομήθηκε από', // by Claude Opus 5

	// Indexes
	'Indexes' => 'Δείκτες',
	'Indexes have been altered.' => 'Οι δείκτες τροποποιήθηκαν.',
	'Alter indexes' => 'Τροποποίηση δεικτών',
	'Add next' => 'Προσθήκη επόμενου',
	'Index Type' => 'Τύπος δείκτη',
	'length' => 'μήκος',
	'Algorithm' => 'Αλγόριθμος', // by Claude Fable 5
	'Condition' => 'Συνθήκη', // by Claude Fable 5

	// Foreign keys
	'Foreign keys' => 'Εξαρτημένα κλειδιά',
	'Foreign key' => 'Εξαρτημένο κλειδί',
	'Foreign key has been dropped.' => 'Το εξαρτημένο κλειδί διαγράφηκε.',
	'Foreign key has been altered.' => 'Το εξαρτημένο κλειδί τροποποιήθηκε.',
	'Foreign key has been created.' => 'Το εξαρτημένο κλειδί δημιουργήθηκε.',
	'Target table' => 'Πίνακας Στόχος',
	'Change' => 'Αλλαγή',
	'Source' => 'Πηγή',
	'Target' => 'Στόχος',
	'Add column' => 'Προσθήκη στήλης',
	'Alter' => 'Τροποποίηση',
	'Add foreign key' => 'Προσθήκη εξαρτημένου κλειδιού',
	'ON DELETE' => 'ΚΑΤΑ ΤΗ ΔΙΑΓΡΑΦΗ',
	'ON UPDATE' => 'ΚΑΤΑ ΤΗΝ ΑΛΛΑΓΗ',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => 'Οι στήλες στην πηγή και το στόχο πρέπει να έχουν τον ίδιο τύπο, πρέπει να υπάρχει δείκτης στη στήλη στόχο και να υπάρχουν εξαρτημένα δεδομένα.',

	// Routines
	'Routines' => 'Ρουτίνες',
	'Routine has been called, %d row(s) affected.' => [
		'Η ρουτίνα εκτελέστηκε, επηρεάστηκε %d σειρά.',
		'Η ρουτίνα εκτελέστηκε, επηρεάστηκαν %d σειρές.',
	],
	'Call' => 'Εκτέλεση',
	'Parameter name' => 'Όνομα παραμέτρου',
	'Create procedure' => 'Δημιουργία διαδικασίας',
	'Create function' => 'Δημιουργία Συνάρτησης',
	'Routine has been dropped.' => 'Η ρουτίνα διαγράφηκε.',
	'Routine has been altered.' => 'Η ρουτίνα τροποποιήθηκε.',
	'Routine has been created.' => 'Η ρουτίνα δημιουργήθηκε.',
	'Alter function' => 'Τροποποίηση λειτουργίας',
	'Alter procedure' => 'Τροποποίηση διαδικασίας',
	'Return type' => 'Επιστρεφόμενος τύπος',

	// Events
	'Events' => 'Γεγονός',
	'Event' => 'Γεγονός',
	'Event has been dropped.' => 'Το γεγονός διαγράφηκε.',
	'Event has been altered.' => 'Το γεγονός τροποποιήθηκε.',
	'Event has been created.' => 'Το γεγονός δημιουργήθηκε.',
	'Alter event' => 'Τροποποίηση γεγονότος',
	'Create event' => 'Δημιουργία γεγονότος',
	'At given time' => 'Σε προκαθορισμένο χρόνο',
	'Every' => 'Κάθε',
	'Schedule' => 'Προγραμματισμός',
	'Start' => 'Έναρξη',
	'End' => 'Λήξη',
	'On completion preserve' => 'Κατά την ολοκλήρωση διατήρησε',

	// Sequences (PostgreSQL)
	'Sequences' => 'Αλληλουχία',
	'Create sequence' => 'Δημιουργία αλληλουχίας',
	'Sequence has been dropped.' => 'Η αλληλουχία διαγράφηκε.',
	'Sequence has been created.' => 'Η αλληλουχία δημιουργήθηκε.',
	'Sequence has been altered.' => 'Η αλληλουχία τροποποιήθηκε.',
	'Alter sequence' => 'Τροποποίηση αλληλουχίας',

	// User types (PostgreSQL)
	'User types' => 'Τύποι χρήστη',
	'Create type' => 'Δημιουργία τύπου',
	'Type has been dropped.' => 'Ο τύπος διαγράφηκε.',
	'Type has been created.' => 'Ο τύπος δημιουργήθηκε.',
	'Alter type' => 'Τροποποίηση τύπου',

	// Triggers
	'Triggers' => 'Εναύσματα',
	'Add trigger' => 'Προσθήκη εναύσματος',
	'Trigger has been dropped.' => 'Το έναυσμα διαγράφηκε.',
	'Trigger has been altered.' => 'Το έναυσμα τροποποιήθηκε.',
	'Trigger has been created.' => 'Το έναυσμα δημιουργήθηκε.',
	'Alter trigger' => 'Τροποποίηση εναύσματος',
	'Create trigger' => 'Δημιουργία εναύσματος',

	// Table check constraints
	'Checks' => 'Έλεγχοι', // by Claude Fable 5
	'Create check' => 'Δημιουργία ελέγχου', // by Claude Fable 5
	'Alter check' => 'Τροποποίηση ελέγχου', // by Claude Fable 5
	'Check has been created.' => 'Ο έλεγχος δημιουργήθηκε.', // by Claude Fable 5
	'Check has been altered.' => 'Ο έλεγχος τροποποιήθηκε.', // by Claude Fable 5
	'Check has been dropped.' => 'Ο έλεγχος διαγράφηκε.', // by Claude Fable 5

	// Selection
	'Select data' => 'Επιλέξτε δεδομένα',
	'Select' => 'Επιλογή',
	'Functions' => 'Λειτουργίες',
	'Aggregation' => 'Άθροισμα',
	'Search' => 'Αναζήτηση',
	'anywhere' => 'παντού',
	'Sort' => 'Ταξινόμηση',
	'descending' => 'Φθίνουσα',
	'Limit' => 'Όριο',
	'Limit rows' => 'Περιορισμός σειρών',
	'Text length' => 'Μήκος κειμένου',
	'Action' => 'Ενέργεια',
	'Full table scan' => 'Πλήρης σάρωση πινάκων',
	'Unable to select the table' => 'Δεν είναι δυνατή η επιλογή πίνακα',
	'Search data in tables' => 'Αναζήτηση δεδομένων στους πίνακες',
	'No rows.' => 'Χωρίς σειρές.',
	'%d / ' => '%d / ',
	'%d row(s)' => [
		'%d σειρά',
		'%d σειρές',
	],
	'Page' => 'Σελίδα',
	'last' => 'τελευταία',
	'Load more data' => 'Φόρτωση κι άλλων δεδομένων',
	'Loading' => 'Φορτώνει',
	'Whole result' => 'Όλο το αποτέλεσμα',
	'%d byte(s)' => [
		'%d byte',
		'%d bytes',
	],

	// In-place editing in selection
	'Modify' => 'Τροποποίηση',
	'Ctrl+click on a value to modify it.' => 'Πιέστε Ctrl+click σε μια τιμή για να την τροποποιήσετε.',
	'Use edit link to modify this value.' => 'Χρησιμοποιήστε το σύνδεσμο επεξεργασία για να τροποποιήσετε την τιμή.',

	// Editing
	'New item' => 'Νέα εγγραφή',
	'Edit' => 'Επεξεργασία',
	'original' => 'πρωτότυπο',
	'empty' => 'κενό', // label for value '' in enum data type
	'Insert' => 'Εισαγωγή',
	'Save' => 'Αποθήκευση',
	'Save and continue edit' => 'Αποθήκευση και συνέχεια επεξεργασίας',
	'Save and insert next' => 'Αποθήκευση και εισαγωγή επόμενου',
	'Saving' => 'Γίνεται Αποθήκευση',
	'Selected' => 'Επιλεγμένα',
	'Clone' => 'Κλωνοποίηση',
	'Delete' => 'Διαγραφή',
	'Item%s has been inserted.' => 'Η εγγραφή%s εισήχθη.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => 'Η εγγραφή διαγράφηκε.',
	'Item has been updated.' => 'Η εγγραφή ενημερώθηκε.',
	'%d item(s) have been affected.' => [
		'Επηρεάστηκε %d εγγραφή.',
		'Επηρεάστηκαν %d εγγραφές.',
	],
	'You have no privileges to update this table.' => 'Δεν έχετε δικαίωμα να τροποποιήσετε αυτό τον πίνακα.',

	// Data type descriptions
	'Numbers' => 'Αριθμοί',
	'Date and time' => 'Ημερομηνία και ώρα',
	'Strings' => 'Κείμενο',
	'Binary' => 'Δυαδικό',
	'Lists' => 'Λίστες',
	'Network' => 'Δίκτυο',
	'Geometry' => 'Γεωμετρία',
	'Relations' => 'Συσχετήσεις',

	// Editor - data values
	'now' => 'τώρα',
	'yes' => 'ναι',
	'no' => 'όχι',

	// Settings
	'Settings' => 'Ρυθμίσεις', // by Claude Opus 5
	'Default' => 'Προεπιλογή', // by Claude Opus 5
	'Color scheme' => 'Συνδυασμός χρωμάτων', // by Claude Opus 5
	'By system' => 'Κατά το σύστημα', // by Claude Opus 5
	'Light' => 'Φωτεινό', // by Claude Opus 5
	'Dark' => 'Σκοτεινό', // by Claude Opus 5
	'Navigation mode' => 'Λειτουργία πλοήγησης', // by Claude Opus 5
	'Simple' => 'Απλή', // by Claude Opus 5
	'Dual' => 'Διπλή', // by Claude Opus 5
	'Reversed' => 'Αντίστροφη', // by Claude Opus 5
	'Layout of main navigation with table links.' => 'Διάταξη της κύριας πλοήγησης με τους συνδέσμους των πινάκων.', // by Claude Opus 5
	'Table links' => 'Σύνδεσμοι πινάκων', // by Claude Opus 5
	'Primary action for all table links.' => 'Κύρια ενέργεια για όλους τους συνδέσμους των πινάκων.', // by Claude Opus 5
	'Links to tables referencing the current row.' => 'Σύνδεσμοι προς τους πίνακες που αναφέρονται στην τρέχουσα σειρά.', // by Claude Opus 5
	'Display' => 'Εμφάνιση', // by Claude Opus 5
	'Hide' => 'Απόκρυψη', // by Claude Opus 5
	'Records per page' => 'Εγγραφές ανά σελίδα', // by Claude Opus 5
	'Default number of records displayed in data table.' => 'Προεπιλεγμένος αριθμός εγγραφών που εμφανίζονται στον πίνακα δεδομένων.', // by Claude Opus 5
	'Enum as select' => 'Enum ως λίστα επιλογής', // by Claude Opus 5
	'Never' => 'Ποτέ', // by Claude Opus 5
	'Always' => 'Πάντα', // by Claude Opus 5
	'More values than %d' => 'Περισσότερες από %d τιμές', // by Claude Opus 5
	'Threshold for displaying a selection menu for enum fields.' => 'Όριο για την εμφάνιση λίστας επιλογής στα πεδία enum.', // by Claude Opus 5

	// Plugins
	'One Time Password' => 'Κωδικός μιας χρήσης', // by Claude Opus 5
	'Enter OTP code.' => 'Εισάγετε τον κωδικό OTP.', // by Claude Opus 5
	'Invalid OTP code.' => 'Άκυρος κωδικός OTP.', // by Claude Opus 5
	'Access denied.' => 'Άρνηση πρόσβασης.', // by Claude Opus 5
	'JSON previews' => 'Προεπισκοπήσεις JSON', // by Claude Opus 5
	'Data table' => 'Πίνακας δεδομένων', // by Claude Opus 5
	'Edit form' => 'Φόρμα επεξεργασίας', // by Claude Opus 5
	'Ask %s' => null,
];
