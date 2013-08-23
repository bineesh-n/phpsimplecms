<?php
/*
 * This file is hidden from http and robots
 * installs the project under PHP 5.2+
 */
function install($db) {
    //--- parses ini file for username and password --//
    $data = parse_ini_file('/../config/nss.ini');
            $un = $data['un'];
            $pwd = $data['pwd'];
            
    $dbcq = 'CREATE DATABASE IF NOT EXISTS '.$db;
    $install_qry = file_get_contents('config/dbinit.sql');
    
    $conn = mysqli_connect('localhost', $un, $pwd) or die();
    
    mysqli_query($conn, $dbcq);
    //--- Executes initialization queries ---//
    mysqli_select_db($conn, $db);
    mysqli_multi_query($conn, $install_qry);
    
    echo $install_qry;
    exit;
}
?>
