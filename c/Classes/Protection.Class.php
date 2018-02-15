<?php
class Protection{
   
    public static function FilterRequest() {
        foreach ($_GET as $_GETKey => $_GETValue)
            $_GET[$_GETKey] = Protection::SQLInjectionFilter($_GETValue);
        foreach ($_POST as $_POSTKey => $_POSTValue)
            $_POST[$_POSTKey] = Protection::SQLInjectionFilter($_POSTValue);
        foreach ($_REQUEST as $_REQUESTKey => $_REQUESTValue)
            $_REQUEST[$_REQUESTKey] = Protection::SQLInjectionFilter($_REQUESTValue);
        foreach ($_SESSION as $_SESSIONKey => $_SESSIONValue)
            $_SESSION[$_SESSIONKey] = Protection::SQLInjectionFilter($_SESSIONValue);
        foreach ($_COOKIE as $_COOKIEKey => $_COOKIEValue)
            $_COOKIE[$_COOKIEKey] = Protection::SQLInjectionFilter($_COOKIEValue);
    }
    public static function SQLInjectionFilter($Value) {
		
        foreach (unserialize(SQL_BADWORDS) as $BadWord) {
            if (VersionCommon::IndexOf($Value, $BadWord) > -1) {
                ob_end_clean();
                die("Tentativa de SQLInjection detectada!Limpe seus dados e tente novamente mais tarde!" . $BadWord);
            }
        }
        return $Value;
    }
}
?>