<?php

include_once 'mysql.php';
/*
 * This class manages the entire header jobs
 */
final class header {
    /*
     * Lists all activities
     */
    public static function listActivities() {
        $mql = new query();
        $query = 'SELECT * FROM ACTIVITY';
        $ar_act = $mql->getExecute($query);
        return $ar_act;
        
    }
    /*
     * Lists all gallery items
     */
    public static function listGalleryItems() {
        $mql = new query();
        $query = 'SELECT * FROM GALLERY';
        $ar_act = $mql->getExecute($query);
        return $ar_act;
    }
    /*
     * Lists all contacts
     */
    public static function listContacts() {
        $mql = new query();
        $query = 'SELECT * FROM CONTACT';
        $ar_act = $mql->getExecute($query);
        return $ar_act;
    }
    /*
     * Adds an activity
     * $param $ar_cont array contains the form data
     */
    public static function addActivity($ar_cont) {
        $error_state = 0;
        $name = addslashes(htmlentities($ar_cont['name']));
        $desc = addslashes(htmlentities($ar_cont['desc']));
        $mql = new query();
        $query = "INSERT INTO ACTIVITY(NAME,DESCRIPTION) VALUES('$name', '$desc')";
        $res = $mql->getExecute($query);
        if(!$res) {
            $error_state =1;
        }
        
        return $error_state;
    }
    
    public static function addGalleryItem($ar_cont) {
        $error_state = 0;
        $item = addslashes(htmlentities($ar_cont['item']));
        $desc = addslashes(htmlentities($ar_cont['desc']));
        $mql = new query();
        $query = "INSERT INTO GALLERY(ITEM,DESCRIPTION) VALUES('$item', '$desc')";
        $res = $mql->getExecute($query);
        if(!$res) {
            $error_state =1;
        }
        
        return $error_state;
    }
    
    public static function addContact($ar_cont) {
        $error_state = 0;
        $name = addslashes(htmlentities($ar_cont['name']));
        $dept = addslashes(htmlentities($ar_cont['dept']));
        $no = $ar_cont['no'];
        $mql = new query();
        $query = "INSERT INTO CONTACT(NAME,DEPARTMENT,NO) VALUES('$name', '$dept', '$no')";
        $res = $mql->getExecute($query);
        if(!$res) {
            $error_state =1;
        }
        
        return $error_state;
    }
    
    public static function deleteActivity($ar_id) {
        $id = $ar_id['id'];
        article::deleteArticleUnderActivity($id);
        $mql = new query();
        $query = "DELETE FROM ACTIVITY WHERE ID=$id";
        $mql->getExecute($query);
    }
    
    public static function deleteGalleryMenu($ar_cont) {
        $gid = $ar_cont['gid'];
        gallery::deletePicturesUnderMenu($gid);
        $mql = new query();
        $query = "DELETE FROM GALLERY WHERE ID = $gid";
        $mql->getExecute($query);
    }


    public static function deleteContact($ar_id) {
        $id = $ar_id['id'];
        $mql = new query();
        $query = "DELETE FROM CONTACT WHERE ID = $id";
        $mql->getExecute($query);
    }
}
?>
