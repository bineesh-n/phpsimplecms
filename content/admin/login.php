<?php
include_once '../mysql.php';
/*
 * Administration management
 */
final class login {
    /*
     * Authenticates the admin using the submitted credentials
     */
    public static function login_admin($ar_cred) {
        
        $un = $ar_cred['un'];
        $un_slashed = addslashes($un);
        if($un != $un_slashed) {
            return FALSE;
        }
        $pwd = md5($ar_cred['pwd']);
        $mql = new query();
        $query = 'SELECT PASSWORD FROM ADMIN WHERE UNAME=\''.$un.'\'';
        $result = $mql->getExecute($query);
        if(!$result) {
            return FALSE;
        }
        $res = mysql_fetch_array($result);
        if($res['PASSWORD'] == $pwd) {
            $_SESSION['AUTHENTICATED'] = TRUE;
            return TRUE;
        }
        else {
            return FALSE;
        }
        return FALSE;
    }
    
    public static function logout_admin() {
        if(isset($_SESSION['AUTHENTICATED'])) {
            unset($_SESSION['AUTHENTICATED']);
        }
    }
    
    public static function change_un($ar_content) {
        
        $new_un = $ar_content['un'];
        $str_slashed = addslashes($new_un);
        if($new_un != $str_slashed) {
            return 1;
        }
        $mql = new query();
        $query = "UPDATE ADMIN SET UNAME = '$new_un'";
        $mql->getExecute($query);
        
    }
    
    public static function change_email($ar_content) {
        
        $new_id = $ar_content['email'];
        $p = '/^[\w-]+(\.[\w-]+)*@[a-z0-9-]+'.'(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/i';
        if(!preg_match($p, $new_id)) {
            return 1;
        }
        $mql = new query();
        $query = "UPDATE ADMIN SET EMAIL = '$new_id'";
        $mql->getExecute($query);
        
    }
    
    public static function change_password($ar_content) {
        
        $new_pwd = $ar_content['pwd'];
        $pwd_ver = $ar_content['pwd-verify'];
        if($new_pwd != $pwd_ver || strlen($new_pwd) < 6) {
            return 1;
        }
        
        $new_pwd = md5($new_pwd);
        
        $mql = new query();
        $query = "UPDATE ADMIN SET PASSWORD = '$new_pwd'";
        $mql->getExecute($query);
        
    }
}

if(array_key_exists('un', $_POST)) {   
    $ret = login::login_admin($_POST);
    if($ret == FALSE) {
        $_SESSION['AUTHENTICATED'] = FALSE;
    }
    else {
        header('Location:../admin/');
    }
    
}
if(array_key_exists('logout', $_GET)) {
    login::logout_admin();
    header('Location:/nss/');
}
?>
