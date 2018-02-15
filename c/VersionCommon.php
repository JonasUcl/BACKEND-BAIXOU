<?php
class VersionCommon{
	public static function Init()
	{
		VersionCommon::InitDefines();
		VersionCommon::InitIncludes();
		Protection::FilterRequest();
		setlocale( LC_ALL, 'pt_BR', 'pt_BR.iso-8859-1', 'pt_BR.utf-8', 'portuguese' );
		date_default_timezone_set("America/Sao_Paulo");
	}
	static function InitDefines()
	{
		define("SERVER","localhost");
		define("USER", "root");
        define("PASS", "");
        define("DB","local");
        define("ZIP_FILE","http://testedev.baixou.com.br/processo/zip");
		define("DESTINO_DOWNLOAD","Download");
		define("NOME_ARQUIVO_DOWNLOAD","0303.zip");
		define("XML_FILE_NAME","0303.xml");
        define("DESTINO_EXTRAIR","XML");
        define("SQL_BADWORDS",serialize(array("'", "union", "$", "delete ", "select ", "create ", "DEL", "insert", "show table", "drop table", "UPDATE", "update", "drop database", "sele", "warehouse ", "Dexterity", "WHERE", "--", 'chr(', 'chr=', 'chr%20', '%20chr', 'wget%20', '%20wget', 'wget', '%20cmd', 'cmd%20', 'rush=', '%20rush', 'rush%20', 'union%20', '%20union', 'union(', 'union=', 'echr(', '%20echr', 'echr%20', 'echr=', 'esystem(', 'esystem%20', 'cp%20', '%20cp', 'cp(', 'mdir%20', '%20mdir', 'mdir(', 'mcd%20', 'mrd%20', 'rm%20', '%20mcd', '%20mrd', '%20rm', 'mcd(', 'mrd(', 'rm(', 'mcd=', 'mrd=', 'mv%20', 'rmdir%20', 'mv(', 'rmdir(', 'chmod(', 'chmod%20', '%20chmod', 'chmod(', 'chmod=', 'chown%20', 'chgrp%20', 'chown(', 'chgrp(', 'locate%20', 'grep%20', 'locate(', 'grep(', 'diff%20', 'kill%20', 'kill(', 'killall', 'passwd%20', '%20passwd', 'passwd(', 'telnet%20', 'vi(', 'vi%20', 'insert%20into', 'select%20', 'fopen', 'fwrite', '$_request', '$_get', '$request', '$get', '.system', 'HTTP_PHP', '&aim', '%20getenv', 'getenv%20', 'new_password', '&icq', '/etc/password', '/etc/shadow', '/etc/groups', '/etc/gshadow', 'HTTP_USER_AGENT', 'HTTP_HOST', '/bin/ps', 'wget%20', 'uname\x20-a', '/usr/bin/id', '/bin/echo', '/bin/kill', '/bin/', '/chgrp', '/chown', '/usr/bin', 'g\+\+', 'bin/python', 'bin/tclsh', 'bin/nasm', 'perl%20', 'traceroute%20', 'ping%20', '.pl', 'lsof%20', '/bin/mail', '.conf', 'motd%20', 'HTTP/1.', '.inc.php', 'config.php', 'cgi-', '.eml', 'file\://', 'window.open', '<script>', 'javascript\://', 'img src', 'img%20src', '.jsp', 'ftp.exe', 'xp_enumdsn', 'xp_availablemedia', 'xp_filelist', 'xp_cmdshell', 'nc.exe', '.htpasswd', 'servlet', '/etc/passwd', 'wwwacl', '~root', '~ftp', '.js', '.jsp', 'admin_', '.history', 'bash_history', '.bash_history', '~nobody', 'server-info', 'server-status', 'reboot%20', 'halt%20', 'powerdown%20', '/home/ftp', '/home/www', 'secure_site, ok', 'chunked', 'org.apache', '/servlet/con', '<script', 'UPDATE', 'SELECT', 'DROP', '/robot.txt', '/perl', 'mod_gzip_status', 'db_mysql.inc', '.inc', 'select%20from', 'select from', 'drop%20', 'getenv', 'http_', '_php', 'php_', 'phpinfo()', '<?php', '?>', 'sql=', 'ConnectStatusDB', '--', '"', '*', '--', '"', '*',)));
	}
	static function InitIncludes()
	{
		include_once("Classes/Conexao.Class.php");
		include_once("Classes/Protection.Class.php");
		include_once("Classes/Dados.Class.php");
	}
	public function IS_NULL($Variable){
		if($Variable == "" || $Variable == null)
			return true;
		else return false;
    }
    public static function IndexOf($haystack, $needle) {
        $pos = strpos($haystack, $needle);
        if ($pos !== false) {
            return $pos;
        } else {
            return -1;
        }
    }
	
}
?>