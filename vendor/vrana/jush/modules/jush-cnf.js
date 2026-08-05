jush.tr.cnf = { quo_one: /"/, one: /#/, cnf_http: /((?:^|\n)\s*)(RequestHeader|Header|CacheIgnoreHeaders)([ \t]+|$)/i, cnf_php: /((?:^|\n)\s*)(PHPIniDir)([ \t]+|$)/i, cnf_phpini: /((?:^|\n)\s*)(php_value|php_flag|php_admin_value|php_admin_flag)([ \t]+|$)/i };
jush.tr.quo_one = { esc: /\\/, _1: /"|(?=\n)/ };
jush.tr.cnf_http = { apo: /'/, quo: /"/, _1: /(?=\n)/ };
jush.tr.cnf_php = { _1: /()/ };
jush.tr.cnf_phpini = { cnf_phpini_val: /[ \t]/ };
jush.tr.cnf_phpini_val = { apo: /'/, quo: /"/, _2: /(?=\n)/ };

jush.urls.cnf_http = 'https://httpd.apache.org/docs/current/mod/$key.html#$val';
jush.urls.cnf_php = 'https://www.php.net/$key';
jush.urls.cnf_phpini = 'https://www.php.net/configuration.changes#$key';

jush.slugs.cnf = name => name.toLowerCase();

jush.links.cnf_http = { 'mod_cache': /CacheIgnoreHeaders/i, 'mod_headers': /.+/ };
jush.links.cnf_php = { 'configuration.file': /.+/ };
jush.links.cnf_phpini = { 'configuration.changes.apache': /.+/ };

jush.build_links2('cnf', 'https://httpd.apache.org/docs/current/mod/$key.html#$1', /((?:^|\n)\s*(?:&lt;)?)/, /(\b)/gi, {
	'beos': /(MaxRequestsPerThread)/,
	'core': /(AcceptFilter|AcceptPathInfo|AccessFileName|AddDefaultCharset|AddOutputFilterByType|AllowEncodedSlashes|AllowOverride|AuthName|AuthType|CGIMapExtension|ContentDigest|DefaultType|Directory|DirectoryMatch|DocumentRoot|EnableMMAP|EnableSendfile|ErrorDocument|ErrorLog|FileETag|Files|FilesMatch|ForceType|HostnameLookups|IfDefine|IfModule|Include|KeepAlive|KeepAliveTimeout|Limit|LimitExcept|LimitInternalRecursion|LimitRequestBody|LimitRequestFields|LimitRequestFieldSize|LimitRequestLine|LimitXMLRequestBody|Location|LocationMatch|LogLevel|MaxKeepAliveRequests|NameVirtualHost|Options|Require|RLimitCPU|RLimitMEM|RLimitNPROC|Satisfy|ScriptInterpreterSource|ServerAdmin|ServerAlias|ServerName|ServerPath|ServerRoot|ServerSignature|ServerTokens|SetHandler|SetInputFilter|SetOutputFilter|TimeOut|TraceEnable|UseCanonicalName|UseCanonicalPhysicalPort|VirtualHost)/,
	'mod_actions': /(Action|Script)/,
	'mod_alias': /(Alias|AliasMatch|Redirect|RedirectMatch|RedirectPermanent|RedirectTemp|ScriptAlias|ScriptAliasMatch)/,
	'mod_auth_basic': /(AuthBasicAuthoritative|AuthBasicProvider)/,
	'mod_auth_digest': /(AuthDigestAlgorithm|AuthDigestDomain|AuthDigestNcCheck|AuthDigestNonceFormat|AuthDigestNonceLifetime|AuthDigestProvider|AuthDigestQop|AuthDigestShmemSize)/,
	'mod_authn_alias': /(AuthnProviderAlias)/,
	'mod_authn_anon': /(Anonymous|Anonymous_LogEmail|Anonymous_MustGiveEmail|Anonymous_NoUserID|Anonymous_VerifyEmail)/,
	'mod_authn_dbd': /(AuthDBDUserPWQuery|AuthDBDUserRealmQuery)/,
	'mod_authn_dbm': /(AuthDBMType|AuthDBMUserFile)/,
	'mod_authn_default': /(AuthDefaultAuthoritative)/,
	'mod_authn_file': /(AuthUserFile)/,
	'mod_authnz_ldap': /(AuthLDAPBindDN|AuthLDAPBindPassword|AuthLDAPCharsetConfig|AuthLDAPCompareDNOnServer|AuthLDAPDereferenceAliases|AuthLDAPGroupAttribute|AuthLDAPGroupAttributeIsDN|AuthLDAPRemoteUserAttribute|AuthLDAPRemoteUserIsDN|AuthLDAPUrl|AuthzLDAPAuthoritative)/,
	'mod_authz_dbm': /(AuthDBMGroupFile|AuthzDBMAuthoritative|AuthzDBMType)/,
	'mod_authz_default': /(AuthzDefaultAuthoritative)/,
	'mod_authz_groupfile': /(AuthGroupFile|AuthzGroupFileAuthoritative)/,
	'mod_authz_host': /(Allow|Deny|Order)/,
	'mod_authz_owner': /(AuthzOwnerAuthoritative)/,
	'mod_authz_user': /(AuthzUserAuthoritative)/,
	'mod_autoindex': /(AddAlt|AddAltByEncoding|AddAltByType|AddDescription|AddIcon|AddIconByEncoding|AddIconByType|DefaultIcon|HeaderName|IndexHeadInsert|IndexIgnore|IndexOptions|IndexOrderDefault|IndexStyleSheet|ReadmeName)/,
	'mod_cache': /(CacheDefaultExpire|CacheDisable|CacheEnable|CacheIgnoreCacheControl|CacheIgnoreNoLastMod|CacheIgnoreQueryString|CacheLastModifiedFactor|CacheMaxExpire|CacheStoreNoStore|CacheStorePrivate)/,
	'mod_cern_meta': /(MetaDir|MetaFiles|MetaSuffix)/,
	'mod_cgi': /(ScriptLog|ScriptLogBuffer|ScriptLogLength)/,
	'mod_cgid': /(ScriptSock)/,
	'mod_dav': /(Dav|DavDepthInfinity|DavMinTimeout)/,
	'mod_dav_fs': /(DavLockDB)/,
	'mod_dav_lock': /(DavGenericLockDB)/,
	'mod_dbd': /(DBDExptime|DBDKeep|DBDMax|DBDMin|DBDParams|DBDPersist|DBDPrepareSQL|DBDriver)/,
	'mod_deflate': /(DeflateBufferSize|DeflateCompressionLevel|DeflateFilterNote|DeflateMemLevel|DeflateWindowSize)/,
	'mod_dir': /(DirectoryIndex|DirectorySlash)/,
	'mod_disk_cache': /(CacheDirLength|CacheDirLevels|CacheMaxFileSize|CacheMinFileSize|CacheRoot)/,
	'mod_dumpio': /(DumpIOInput|DumpIOLogLevel|DumpIOOutput)/,
	'mod_echo': /(ProtocolEcho)/,
	'mod_env': /(PassEnv|SetEnv|UnsetEnv)/,
	'mod_example': /(Example)/,
	'mod_expires': /(ExpiresActive|ExpiresByType|ExpiresDefault)/,
	'mod_ext_filter': /(ExtFilterDefine|ExtFilterOptions)/,
	'mod_file_cache': /(CacheFile|MMapFile)/,
	'mod_filter': /(FilterChain|FilterDeclare|FilterProtocol|FilterProvider|FilterTrace)/,
	'mod_charset_lite': /(CharsetDefault|CharsetOptions|CharsetSourceEnc)/,
	'mod_ident': /(IdentityCheck|IdentityCheckTimeout)/,
	'mod_imagemap': /(ImapBase|ImapDefault|ImapMenu)/,
	'mod_include': /(SSIEnableAccess|SSIEndTag|SSIErrorMsg|SSIStartTag|SSITimeFormat|SSIUndefinedEcho|XBitHack)/,
	'mod_info': /(AddModuleInfo)/,
	'mod_isapi': /(ISAPIAppendLogToErrors|ISAPIAppendLogToQuery|ISAPICacheFile|ISAPIFakeAsync|ISAPILogNotSupported|ISAPIReadAheadBuffer)/,
	'mod_ldap': /(LDAPCacheEntries|LDAPCacheTTL|LDAPConnectionTimeout|LDAPOpCacheEntries|LDAPOpCacheTTL|LDAPSharedCacheFile|LDAPSharedCacheSize|LDAPTrustedClientCert|LDAPTrustedGlobalCert|LDAPTrustedMode|LDAPVerifyServerCert)/,
	'mod_log_config': /(BufferedLogs|CookieLog|CustomLog|LogFormat|TransferLog)/,
	'mod_log_forensic': /(ForensicLog)/,
	'mod_mem_cache': /(MCacheMaxObjectCount|MCacheMaxObjectSize|MCacheMaxStreamingBuffer|MCacheMinObjectSize|MCacheRemovalAlgorithm|MCacheSize)/,
	'mod_mime': /(AddCharset|AddEncoding|AddHandler|AddInputFilter|AddLanguage|AddOutputFilter|AddType|DefaultLanguage|ModMimeUsePathInfo|MultiviewsMatch|RemoveCharset|RemoveEncoding|RemoveHandler|RemoveInputFilter|RemoveLanguage|RemoveOutputFilter|RemoveType|TypesConfig)/,
	'mod_mime_magic': /(MimeMagicFile)/,
	'mod_negotiation': /(CacheNegotiatedDocs|ForceLanguagePriority|LanguagePriority)/,
	'mod_nw_ssl': /(NWSSLTrustedCerts|NWSSLUpgradeable|SecureListen)/,
	'mod_proxy': /(AllowCONNECT|BalancerMember|NoProxy|Proxy|ProxyBadHeader|ProxyBlock|ProxyDomain|ProxyErrorOverride|ProxyFtpDirCharset|ProxyIOBufferSize|ProxyMatch|ProxyMaxForwards|ProxyPass|ProxyPassInterpolateEnv|ProxyPassMatch|ProxyPassReverse|ProxyPassReverseCookieDomain|ProxyPassReverseCookiePath|ProxyPreserveHost|ProxyReceiveBufferSize|ProxyRemote|ProxyRemoteMatch|ProxyRequests|ProxySet|ProxyStatus|ProxyTimeout|ProxyVia)/,
	'mod_rewrite': /(RewriteBase|RewriteCond|RewriteEngine|RewriteLock|RewriteLog|RewriteLogLevel|RewriteMap|RewriteOptions|RewriteRule)/,
	'mod_setenvif': /(BrowserMatch|BrowserMatchNoCase|SetEnvIf|SetEnvIfNoCase)/,
	'mod_so': /(LoadFile|LoadModule)/,
	'mod_speling': /(CheckCaseOnly|CheckSpelling)/,
	'mod_ssl': /(SSLCACertificateFile|SSLCACertificatePath|SSLCADNRequestFile|SSLCADNRequestPath|SSLCARevocationFile|SSLCARevocationPath|SSLCertificateChainFile|SSLCertificateFile|SSLCertificateKeyFile|SSLCipherSuite|SSLCryptoDevice|SSLEngine|SSLHonorCipherOrder|SSLMutex|SSLOptions|SSLPassPhraseDialog|SSLProtocol|SSLProxyCACertificateFile|SSLProxyCACertificatePath|SSLProxyCARevocationFile|SSLProxyCARevocationPath|SSLProxyCipherSuite|SSLProxyEngine|SSLProxyMachineCertificateFile|SSLProxyMachineCertificatePath|SSLProxyProtocol|SSLProxyVerify|SSLProxyVerifyDepth|SSLRandomSeed|SSLRequire|SSLRequireSSL|SSLSessionCache|SSLSessionCacheTimeout|SSLUserName|SSLVerifyClient|SSLVerifyDepth)/,
	'mod_status': /(ExtendedStatus|SeeRequestTail)/,
	'mod_substitute': /(Substitute)/,
	'mod_suexec': /(SuexecUserGroup)/,
	'mod_userdir': /(UserDir)/,
	'mod_usertrack': /(CookieDomain|CookieExpires|CookieName|CookieStyle|CookieTracking)/,
	'mod_version': /(IfVersion)/,
	'mod_vhost_alias': /(VirtualDocumentRoot|VirtualDocumentRootIP|VirtualScriptAlias|VirtualScriptAliasIP)/,
	'mpm_common': /(AcceptMutex|ChrootDir|CoreDumpDirectory|EnableExceptionHook|GracefulShutdownTimeout|Group|Listen|ListenBackLog|LockFile|MaxClients|MaxMemFree|MaxRequestsPerChild|MaxSpareThreads|MinSpareThreads|PidFile|ReceiveBufferSize|ScoreBoardFile|SendBufferSize|ServerLimit|StartServers|StartThreads|ThreadLimit|ThreadsPerChild|ThreadStackSize|User)/,
	'mpm_netware': /(MaxThreads)/,
	'mpm_winnt': /(Win32DisableAcceptEx)/,
	'prefork': /(MaxSpareServers|MinSpareServers)/,
});
