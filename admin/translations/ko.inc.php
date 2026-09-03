<?php

namespace AdminNeo;

return [
	'ltr' => 'ltr', // text direction - 'ltr' or 'rtl'
	',' => ',', // thousands separator - must contain single byte
	'0123456789' => '0123456789',

	// Editor
	'$1-$3-$5' => '$1-$3-$5', // date format: $1 yyyy, $2 yy, $3 mm, $4 m, $5 dd, $6 d
	'YYYY-MM-DD' => 'YYYY-MM-DD', // hint for date format - use language equivalents for day, month and year shortcuts
	'HH:MM:SS' => '시:분:초', // hint for time format - use language equivalents for hour, minute and second shortcuts

	// Bootstrap
	'%s must return an array.' => '%s은(는) 배열을 반환해야 합니다.', // by Claude Fable 5.1
	'%s and %s must return an object created by %s method.' => '%s과(와) %s은(는) %s 메서드로 만든 객체를 반환해야 합니다.', // by Claude Fable 5.1

	// Login
	'System' => '데이터베이스 형식',
	'Server' => '서버',
	'Username' => '사용자이름',
	'Password' => '비밀번호',
	'Permanent login' => '영구적으로 로그인',
	'Login' => '로그인',
	'Logout' => '로그아웃',
	'Logged as: %s' => '다음으로 로그인했습니다: %s',
	'Logout successful.' => '로그아웃을 성공했습니다.',
	'hostname[:port] or :socket' => 'hostname[:port] 또는 :socket', // by Claude Fable 5.1
	'Invalid server or credentials.' => '잘못된 서버 또는 인증 정보입니다.', // by Claude Fable 5.1
	'There is a space in the input password which might be the cause.' => '입력한 비밀번호에 공백이 있는데, 이것이 원인일 수 있습니다.', // by Claude Fable 5.1
	'AdminNeo does not support accessing a database without a password, <a href="https://www.adminneo.org/password"%s>more information</a>.' => 'AdminNeo는 비밀번호 없이 데이터베이스에 접근하는 것을 지원하지 않습니다(<a href="https://www.adminneo.org/password"%s>자세한 정보</a>).', // by Claude Fable 5.1
	'Database does not support password.' => '데이터베이스가 비밀번호를 지원하지 않습니다.', // by Claude Fable 5.1
	'Too many unsuccessful logins, try again in %d minute(s).' => '로그인 실패가 너무 많습니다. %d분 후에 다시 시도하세요.', // by Claude Fable 5.1
	'Invalid permanent login, please login again.' => '영구 로그인이 잘못되었습니다. 다시 로그인하십시오.', // by Claude Fable 5.1
	'Invalid CSRF token. Send the form again.' => '잘못된 CSRF 토큰입니다. 다시 보내주십시오.',
	'If you did not send this request from AdminNeo then close this page.' => '이 요청을 AdminNeo에서 보낸 것이 아니라면 이 페이지를 닫으세요.', // by Claude Fable 5.1
	'The action will be performed after successful login with the same credentials.' => '같은 자격 증명으로 로그인에 성공하면 작업이 수행됩니다.', // by Claude Fable 5.1

	// Connection
	'No extension' => '확장이 없습니다',
	'None of the supported PHP extensions (%s) are available.' => 'PHP 확장(%s)이 설치되어 있지 않습니다.', // %s contains the list of the extensions, e.g. 'mysqli, PDO_MySQL'
	'Connecting to privileged ports is not allowed.' => '권한이 필요한 포트로의 연결은 허용되지 않습니다.', // by Claude Fable 5.1
	'Session support must be enabled.' => '세션 지원을 사용해야만 합니다.',
	'Session expired, please login again.' => '세션이 만료되었습니다. 다시 로그인하십시오.',
	'%s version: %s through PHP extension %s' => '%s 버전 %s, PHP 확장 %s',

	// Settings
	'Language' => '언어',

	'Menu' => '메뉴', // by Claude Fable 5.1
	'Home' => '홈', // by Claude Fable 5.1
	'Refresh' => '새로 고침',
	'Info' => '정보', // by Claude Fable 5.1
	'More information.' => '자세한 정보.', // by Claude Fable 5.1

	// Privileges
	'Privileges' => '권한',
	'Create user' => '사용자 만들기',
	'User has been dropped.' => '사용자를 제거했습니다.',
	'User has been altered.' => '사용자를 변경했습니다.',
	'User has been created.' => '사용자를 만들었습니다.',
	'Hashed' => 'Hashed',

	// Server
	'Process list' => '프로세스 목록',
	'%d process(es) have been killed.' => '%d개 프로세스를 강제 종료하였습니다.',
	'Kill' => '강제 종료',
	'Variables' => '변수',
	'Status' => '상태',

	// Structure
	'Column' => '열',
	'Columns' => '열', // by Claude Fable 5.1
	'Routine' => '루틴',
	'Grant' => '권한 부여',
	'Revoke' => '권한 취소',

	// Queries
	'SQL command' => 'SQL 명령',
	'HTTP request' => 'HTTP 요청', // by Claude Fable 5.1
	'%d query(s) executed OK.' => '%d개 쿼리를 잘 실행했습니다.',
	'Query executed OK, %d row(s) affected.' => '쿼리를 잘 실행했습니다. %d행을 변경했습니다.',
	'No commands to execute.' => '실행할 수 있는 명령이 없습니다.',
	'Error in query' => '쿼리의 오류',
	'Unknown error.' => '알 수 없는 오류입니다.', // by Claude Fable 5.1
	'Warnings' => '경고',
	'%s queries are not supported.' => '%s 쿼리는 지원되지 않습니다.', // by Claude Fable 5.1
	'Execute' => '실행',
	'Stop on error' => '오류의 경우 중지',
	'Show only errors' => '오류 만 표시',
	'Time' => '시간',
	'%.3f s' => '%.3f 초', // sprintf() format for time of the command
	'History' => '이력',
	'Clear' => '삭제',
	'Edit all' => '모두 편집',

	// Import
	'Import' => '가져 오기',
	'File upload' => '파일 올리기',
	'From server' => '서버에서 실행',
	'Webserver file %s' => '웹서버 파일 %s',
	'Run file' => '파일을 실행',
	'File does not exist.' => '파일이 존재하지 않습니다.',
	'File uploads are disabled.' => '파일 업로드가 잘못되었습니다.',
	'Unable to upload a file.' => '파일을 업로드 할 수 없습니다.',
	'Maximum allowed file size is %sB.' => '파일의 최대 크기 %sB.',
	'The maximum number of files is %d. Select fewer files or increase the %s configuration directive.' => '파일의 최대 개수는 %d입니다. 파일을 더 적게 선택하거나 %s 설정을 늘리십시오.', // by Claude Fable 5.1
	'The maximum total size of files is %s. Select smaller files or increase the %s configuration directive.' => '파일의 최대 전체 크기는 %s입니다. 더 작은 파일을 선택하거나 %s 설정을 늘리십시오.', // by Claude Fable 5.1
	'Too big POST data. Reduce the data or increase the %s configuration directive.' => 'POST 데이터가 너무 큽니다. 데이터 크기를 줄이거나 %s 설정을 늘리십시오.',
	'You can upload a big SQL file via FTP and import it from server.' => '큰 SQL 파일은 FTP를 통하여 업로드하여 서버에서 가져올 수 있습니다.',
	'File must be in UTF-8 encoding.' => '파일은 UTF-8 인코딩이어야 합니다.', // by Claude Fable 5.1
	'You are offline.' => '오프라인입니다.',
	'%d row(s) have been imported.' => '%d개 행을 가져 왔습니다.',

	// Export
	'Export' => '내보내기',
	'Output' => '출력',
	'open' => '열기', // by Claude Fable 5.1
	'save' => '저장',
	'Format' => '형식',
	'Data' => '데이터',

	// Databases
	'Database' => '데이터베이스',
	'database' => '데이터베이스', // by Claude Fable 5.1
	'DB' => 'DB', // by Claude Fable 5.1
	'Use' => '사용',
	'Invalid database.' => '잘못된 데이터베이스입니다.',
	'Alter database' => '데이터베이스 변경',
	'Create database' => '데이터베이스 만들기',
	'Database schema' => '데이터베이스 구조',
	'Permanent link' => '영구적으로 링크',
	'Database has been dropped.' => '데이터베이스를 삭제했습니다.',
	'Databases have been dropped.' => '데이터베이스를 삭제했습니다.',
	'Database has been created.' => '데이터베이스를 만들었습니다.',
	'Database has been renamed.' => '데이터베이스의 이름을 바꾸었습니다.',
	'Database has been altered.' => '데이터베이스를 변경했습니다.',

	// SQLite errors
	'File exists.' => '파일이 이미 있습니다.',
	'Please use one of the extensions %s.' => '확장 %s 중 하나를 사용하십시오.',

	// Schemas (PostgreSQL, MS SQL)
	'Schema' => '스키마',
	'schema' => '스키마', // by Claude Fable 5.1
	'Schemas' => '스키마', // by Claude Fable 5.1
	'No schemas.' => '스키마가 없습니다.', // by Claude Fable 5.1
	'Show schema' => '스키마 표시', // by Claude Fable 5.1
	'Alter schema' => '스키마 변경',
	'Create schema' => '스키마 추가',
	'Schema has been dropped.' => '스키마를 삭제했습니다.',
	'Schema has been created.' => '스키마를 추가했습니다.',
	'Schema has been altered.' => '스키마를 변경했습니다.',
	'Invalid schema.' => '잘못된 스키마입니다.',

	// Table list
	'Engine' => '엔진',
	'engine' => '엔진',
	'Collation' => '정렬',
	'collation' => '정렬',
	'Data Length' => '데이터 길이',
	'Index Length' => '색인 길이',
	'Data Free' => '데이터 여유',
	'Rows' => '행',
	'%d in total' => '총 %d개',
	'Analyze' => '분석',
	'Optimize' => '최적화',
	'Vacuum' => '청소',
	'Check' => '확인',
	'Repair' => '복구',
	'Truncate' => '데이터 내용만 지우기',
	'Truncate Cascade' => '연쇄로 데이터 내용만 지우기', // by Claude Fable 5.1
	'Tables have been truncated.' => '테이블의 데이터 내용만 지웠습니다.',
	'Move to other database' => '다른 데이터베이스로 이동',
	'Move' => '이동',
	'Tables have been moved.' => '테이블을 옮겼습니다.',
	'Copy' => '복사',
	'Tables have been copied.' => '테이블을 복사했습니다.',
	'overwrite' => '덮어쓰기',

	// Tables
	'Tables' => '테이블',
	'Tables and views' => '테이블과 뷰',
	'Table' => '테이블',
	'No tables.' => '테이블이 없습니다.',
	'Alter table' => '테이블 변경',
	'Create table' => '테이블 만들기',
	'Table has been dropped.' => '테이블을 삭제했습니다.',
	'Tables have been dropped.' => '테이블을 삭제했습니다.',
	'Tables have been optimized.' => '테이블을 최적화했습니다.', // by Claude Fable 5.1
	'Table has been altered.' => '테이블을 변경했습니다.',
	'Table has been created.' => '테이블을 만들었습니다.',
	'Table name' => '테이블 이름',
	'Name' => '이름',
	'Show structure' => '구조 표시',
	'Column name' => '열 이름',
	'Type' => '형',
	'Length' => '길이',
	'Auto Increment' => '자동 증가',
	'Options' => '설정',
	'Comment' => '주석',
	'Default value' => '기본값', // by Claude Fable 5.1
	'Drop' => '삭제',
	'Drop %s?' => '%s을(를) 삭제하시겠습니까?', // by Claude Fable 5.1
	'Are you sure?' => '실행 하시겠습니까?',
	'Size' => '크기',
	'Compute' => '계산하기',
	'Move up' => '위로',
	'Move down' => '아래로',
	'Remove' => '제거',
	'Maximum number of allowed fields exceeded. Please increase %s.' => '정의 가능한 최대 필드 수를 초과했습니다. %s(을)를 늘리십시오.',

	// Views
	'View' => '보기',
	'Materialized view' => '구체화된 뷰', // by Claude Fable 5.1
	'View has been dropped.' => '보기를 삭제했습니다.',
	'View has been altered.' => '보기를 변경했습니다.',
	'View has been created.' => '보기를 만들었습니다.',
	'Alter view' => '보기 변경',
	'Create view' => '뷰 만들기',

	// Partitions
	'Partition by' => '파티션',
	'Partition' => '파티션', // by Claude Fable 5.1
	'Partitions' => '파티션',
	'Partition name' => '파티션 이름',
	'Values' => '값',
	'Inherited tables' => '상속된 테이블', // by Claude Fable 5.1
	'Inherited from' => '상속 원본', // by Claude Fable 5.1

	// Indexes
	'Indexes' => '색인',
	'Indexes have been altered.' => '색인을 변경했습니다.',
	'Alter indexes' => '색인 변경',
	'Add next' => '다음 추가',
	'Index Type' => '색인 형',
	'length' => '길이',
	'operator class' => '연산자 클래스', // by Claude Fable 5.1
	'Algorithm' => '알고리즘', // by Claude Fable 5.1
	'Condition' => '조건', // by Claude Fable 5.1

	// Foreign keys
	'Foreign keys' => '외부 키',
	'Foreign key' => '외부 키',
	'Foreign key has been dropped.' => '외부 키를 제거했습니다.',
	'Foreign key has been altered.' => '외부 키를 변경했습니다.',
	'Foreign key has been created.' => '외부 키를 만들었습니다.',
	'Target table' => '테이블',
	'Change' => '변경',
	'Source' => '소스',
	'Target' => '타겟',
	'Add column' => '열 추가',
	'Alter' => '변경',
	'Add foreign key' => '외부 키를 추가',
	'ON DELETE' => '지울 때',
	'ON UPDATE' => '업데이트할 때',
	'Source and target columns must have the same data type, there must be an index on the target columns and referenced data must exist.' => '원본과 대상 열은 동일한 데이터 형식이어야만 합니다. 목표 열에 색인과 데이터가 존재해야만 합니다.',

	// Routines
	'Routines' => '루틴',
	'Routine has been called, %d row(s) affected.' => '루틴을 호출했습니다. %d 행을 변경했습니다.',
	'Call' => '호출',
	'Parameter name' => '매개변수 이름',
	'Create procedure' => '시저 만들기',
	'Create function' => '함수 만들기',
	'Routine has been dropped.' => '루틴을 제거했습니다.',
	'Routine has been altered.' => '루틴을 변경했습니다.',
	'Routine has been created.' => '루틴을 추가했습니다.',
	'Alter function' => '함수 변경',
	'Alter procedure' => '시저 변경',
	'Return type' => '반환 형식',

	// Events
	'Events' => '이벤트',
	'Event' => '이벤트',
	'Event has been dropped.' => '삭제했습니다.',
	'Event has been altered.' => '변경했습니다.',
	'Event has been created.' => '만들었습니다.',
	'Alter event' => '이벤트 변경',
	'Create event' => '만들기',
	'At given time' => '지정 시간',
	'Every' => '매 번',
	'Schedule' => '예약',
	'Start' => '시작',
	'End' => '종료',
	'On completion preserve' => '완성 후 저장',

	// Sequences (PostgreSQL)
	'Sequences' => '시퀀스',
	'Create sequence' => '시퀀스 만들기',
	'Sequence has been dropped.' => '시퀀스를 제거했습니다.',
	'Sequence has been created.' => '시퀀스를 추가했습니다.',
	'Sequence has been altered.' => '시퀀스를 변경했습니다.',
	'Alter sequence' => '순서 변경',

	// User-defined types (PostgreSQL)
	'User types' => '사용자 정의 유형', // by Claude Fable 5.1
	'Create type' => '사용자 정의 형식 만들기',
	'Type has been dropped.' => '유형을 삭제했습니다.',
	'Type has been created.' => '유형을 추가했습니다.',
	'Alter type' => '형 변경',

	// Triggers
	'Triggers' => '트리거',
	'Add trigger' => '트리거 추가',
	'Trigger has been dropped.' => '트리거를 제거했습니다.',
	'Trigger has been altered.' => '트리거를 변경했습니다.',
	'Trigger has been created.' => '트리거를 추가했습니다.',
	'Alter trigger' => '트리거 변경',
	'Create trigger' => '트리거 만들기',

	// Table check constraints
	'Checks' => '체크 제약 조건', // by Claude Fable 5.1
	'Create check' => '체크 제약 조건 만들기', // by Claude Fable 5.1
	'Alter check' => '체크 제약 조건 변경', // by Claude Fable 5.1
	'Check has been created.' => '체크 제약 조건을 만들었습니다.', // by Claude Fable 5.1
	'Check has been altered.' => '체크 제약 조건을 변경했습니다.', // by Claude Fable 5.1
	'Check has been dropped.' => '체크 제약 조건을 삭제했습니다.', // by Claude Fable 5.1

	// Selection
	'Select data' => '데이터를 선택하십시오',
	'Select' => '선택',
	'Functions' => '함수',
	'Aggregation' => '집합',
	'Search' => '검색',
	'anywhere' => '모든',
	'Sort' => '정렬',
	'descending' => '역순',
	'Limit' => '제약',
	'Limit rows' => '행 제약',
	'Text length' => '문자열의 길이',
	'Action' => '실행',
	'Full table scan' => '전체 테이블 스캔', // by Claude Fable 5.1
	'Unable to select the table' => '테이블을 선택할 수 없습니다',
	'Search data in tables' => '테이블 내 데이터 검색',
	'No rows.' => '행이 없습니다.',
	'%d / ' => '%d / ', // by Claude Fable 5.1
	'%d row(s)' => '%d개 행',
	'Page' => '페이지',
	'last' => '마지막',
	'Load more data' => '더 많은 데이터 부르기',
	'Loading' => '부르는 중',
	'Whole result' => '모든 결과',
	'%d byte(s)' => '%d 바이트',

	// In-place editing in selection
	'Modify' => '수정',
	'Ctrl+click on a value to modify it.' => '값을 수정하려면 Ctrl+클릭하세요.', // by Claude Fable 5.1
	'Use edit link to modify this value.' => '이 값을 수정하려면 편집 링크를 사용하십시오.',

	// Editing
	'New item' => '항목 만들기',
	'Edit' => '편집',
	'original' => '원본',
	'empty' => '비어있음', // label for value '' in enum data type
	'Insert' => '삽입',
	'Save' => '저장',
	'Save and continue edit' => '저장하고 계속 편집하기',
	'Save and insert next' => '저장하고 다음에 추가',
	'Saving' => '저장 중', // by Claude Fable 5.1
	'Selected' => '선택됨',
	'Clone' => '복제',
	'Delete' => '삭제',
	'Item%s has been inserted.' => '%s 항목을 삽입했습니다.', // %s can contain auto-increment value, e.g. ' 123'
	'Item has been deleted.' => '항목을 삭제했습니다.',
	'Item has been updated.' => '항목을 갱신했습니다.',
	'%d item(s) have been affected.' => '%d개 항목을 갱신했습니다.',
	'You have no privileges to update this table.' => '이 테이블을 업데이트할 권한이 없습니다.',

	// Data type descriptions
	'Numbers' => '숫자',
	'Date and time' => '시간',
	'Strings' => '문자열',
	'Binary' => '이진',
	'Lists' => '목록',
	'Network' => '네트워크 형',
	'Geometry' => '기하 형',
	'Relations' => '관계',

	// Editor - data values
	'now' => '현재 시간',
	'yes' => '네',
	'no' => '아니요', // by Claude Fable 5.1

	// Settings
	'Settings' => '설정', // by Claude Fable 5.1
	'Default' => '기본값', // by Claude Fable 5.1
	'Color scheme' => '색상 테마', // by Claude Fable 5.1
	'By system' => '시스템 설정에 따름', // by Claude Fable 5.1
	'Light' => '밝게', // by Claude Fable 5.1
	'Dark' => '어둡게', // by Claude Fable 5.1
	'Navigation mode' => '탐색 방식', // by Claude Fable 5.1
	'Simple' => '단순', // by Claude Fable 5.1
	'Dual' => '이중', // by Claude Fable 5.1
	'Dual on hover' => '마우스 오버 시 이중', // by Claude Fable 5.1
	'Reversed' => '역방향', // by Claude Fable 5.1
	'Layout of main navigation with table links.' => '테이블 링크가 있는 기본 탐색 영역의 배치입니다.', // by Claude Fable 5.1
	'Table links' => '테이블 링크', // by Claude Fable 5.1
	'Primary action for all table links.' => '모든 테이블 링크의 기본 동작입니다.', // by Claude Fable 5.1
	'Links to tables referencing the current row.' => '현재 행을 참조하는 테이블로의 링크입니다.', // by Claude Fable 5.1
	'Display' => '표시', // by Claude Fable 5.1
	'Hide' => '숨김', // by Claude Fable 5.1
	'Records per page' => '페이지당 레코드 수', // by Claude Fable 5.1
	'Default number of records displayed in data table.' => '데이터 테이블에 표시되는 기본 레코드 수입니다.', // by Claude Fable 5.1
	'Enum as select' => 'Enum을 선택 목록으로', // by Claude Fable 5.1
	'Never' => '안 함', // by Claude Fable 5.1
	'Always' => '항상', // by Claude Fable 5.1
	'More values than %d' => '값이 %d개보다 많을 때', // by Claude Fable 5.1
	'Threshold for displaying a selection menu for enum fields.' => 'enum 열에 선택 목록을 표시하는 기준값입니다.', // by Claude Fable 5.1

	// Plugins
	'One Time Password' => '일회용 비밀번호', // by Claude Fable 5.1
	'Enter OTP code.' => 'OTP 코드를 입력하십시오.', // by Claude Fable 5.1
	'Invalid OTP code.' => '잘못된 OTP 코드입니다.', // by Claude Fable 5.1
	'Access denied.' => '접근이 거부되었습니다.', // by Claude Fable 5.1
	'JSON previews' => 'JSON 미리 보기', // by Claude Fable 5.1
	'Data table' => '데이터 테이블', // by Claude Fable 5.1
	'Edit form' => '편집 양식', // by Claude Fable 5.1
	'Ask %s' => '%s에게 질문하기', // by Claude Fable 5.1
];
