<?php
include_once '/../config/install.php';
/*
 * Entire query execution class for project. Everything comes here
 */
  final  class query {
      
      public static $un=null,$pwd=null;
      CONST DB = 'NSS';
      CONST SERVER = 'localhost';
      
        function __construct() {
            $data = parse_ini_file('/../config/nss.ini');
            self::$un = $data['un'];
            self::$pwd = $data['pwd'];
    }
    /*
     * Executes the $query
     * If database not found, installs the system
     * If any errors found, Stops execution
     */
    public function getExecute($query) {
        mysql_connect(self::SERVER, self::$un, self::$pwd) or die();
        $dbc = mysql_select_db(self::DB);
        if(!$dbc) {
            echo 'Please wait while installing system...';
            install(self::DB);
            header('Location: ../');
        }
        
        $result = mysql_query($query);
        if(!$result) {
            $err_msg = <<<FORM
                    <div style='background-color: #ffeeee; border: 2px solid #ffdddd'>
                        Sorry for the trouble, we are unable to execute your request right now.<br/>
                        <ul>You may do:
                            <li>If the error came from a form submission, try the submission with different values</li>
                            <li>Try again later, too many requests to the server may causing the problem.</li>
                            <li>May be this is due to design error, in the case you directly contact designer or nss coordinators very soon.</li>
                        </ul>
                    </div>
                    
FORM;
            die($err_msg);
        }
        return $result;
    }
    
    
}
?>
