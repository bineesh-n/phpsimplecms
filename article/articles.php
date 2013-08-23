<?php
include_once '/../content/mysql.php';
/*
 * Article class manages the article needs of the project
 * Article has no objects
 */
final class article {
    /*
     * @param $id the activity id of the articles to be returned
     * @returns the title and id of the articles in specified activity
     */
    public static function getArticleOnActivity($id) {
        $mql = new query();
        $query = 'SELECT TITLE,ID FROM ARTICLE WHERE ACTIVITY='.$id;
        $res=$mql->getExecute($query);
        return $res;
}
    /*
     * @param $id the id of article needed
     * @returns the article
     */
    public static function getArticleById($id) {
        $mql = new query();
        $query = 'SELECT * FROM ARTICLE WHERE ID='.$id;
        $result = $mql->getExecute($query);
        $res =  mysql_fetch_array($result);
        return $res;
    }
    /*
     * @param $id the article id
     * @returns the article preview of specified id
     */
    public static function getArticlePreview($id) {
        $result = self::getArticleById($id);
        $content = $result['CONTENT'];
        $img = $result['PHOTOURL'];
        //--- Checking if image uploaded or not. Adjusting line and letter limits --//
        if($img == 'images/null') {
            $LINE_LIMIT = 10;
            $LETTER_LIMIT = 1200;
        }
        else {
            $LINE_LIMIT = 4;
            $LETTER_LIMIT = 600;
        }
        //--- Only $LINE_LIMIT number of <br/>s allowed. --//
        $tmp = $content;
        $toff = 0;
        for($i = 0;$i<$LINE_LIMIT;$i++) {
                
            $off = strpos($tmp, '<br/>');
            if(!$off) {
                break;
            }
            $tmp = " ".substr($tmp,$off+5);
            $toff += $off+5;
        }
        
        $toff+=2;
        //--- Counting characters ---//
        if(strlen($content)>$LETTER_LIMIT||$i == $LINE_LIMIT) {
            $content = substr($content, 0, $LETTER_LIMIT);
            
            if($i == $LINE_LIMIT) {
                $content = substr($content,0, $toff);
            }
            $content = $content.'...';
            $result['CONTENT'] = $content;
            $result['trim'] = TRUE;
        }
        else {
            $result['trim'] = FALSE;
        }
        
        return $result;
    }
    /*
     * @param $page the page number client requested
     * @returns Latest article that can be displayed on page
     */
    public static function getLatestArticle($page) {
        $mql = new query();
        $lim_start = ($page-1)*3;
        $query = 'SELECT ID FROM ARTICLE ORDER BY ID DESC LIMIT '.$lim_start.',1';
        $result = $mql->getExecute($query);
        $res = mysql_fetch_array($result);
        return $res['ID'];
    }
    /*
     * Allows to add articles
     * @param $ar_cont Array with contents 
     * $param $file Files array
     */
    public static function addNewArticle($ar_cont,$file) {
        
        $error_state = 0;
        //--- Preventing xss ---//
        $title = addslashes(htmlentities($ar_cont['title']));
        $author = addslashes(htmlentities($ar_cont['author']));
        if($author == "") {
            $author = "Administrator";
        }
        $rel = $ar_cont['activity'];
        if($file['photo']['error']) {
            $error_state = 2;
            if(is_uploaded_file($file['photo']['tmp_name'])) {
                return $error_state;
            }
        }
        $photo = $file['photo']['tmp_name'];
        $pname = rawurldecode($file['photo']['name']);
        if($pname == "") {
            $pname = "null";
        }
        else {
            $img = 0;
            $img_temp = $pname;
            while(file_exists('../../article/images/'.$img_temp)) {
                $img_temp = $pname;
                $img_temp = 'img'.$img."_".$pname;
                $img++;
            }
            $pname = $img_temp;
            $r = move_uploaded_file($photo, '../../article/images/'.$pname);
            
            if(!$r) {
                $error_state = 1;
                return $error_state;
            }
        }
        $url = addslashes("images/".$pname);
        $content = addslashes($ar_cont['content']);
        
        $mql = new query();
        $query = "INSERT INTO ARTICLE(ACTIVITY,TITLE,AUTHOR,PHOTOURL,CONTENT) VALUES($rel,'$title','$author','$url','$content')";
        $mql->getExecute($query);
        
    }
    /*
     * @param $id deletes the article with this id
     */
    public static function deleteArticle($id) {
        $error_state = 0;
        //--- Deleting photo associated --//
        $mql = new query();
        $query = "SELECT PHOTOURL FROM ARTICLE WHERE ID = $id";
        $url = $mql->getExecute($query);
        $url = mysql_fetch_array($url);
        $url = $url['PHOTOURL'];
        $filename = "../../article/".$url;
        $query = "DELETE FROM ARTICLE WHERE ID = $id";
        $mql->getExecute($query);
        //--- Making the article ids to correct order ---//
        $query = 'SELECT COUNT(*) FROM ARTICLE';
        $res = $mql->getExecute($query);
        $cnt = mysql_fetch_array($res);
        $count = $cnt['COUNT(*)'];
        
        if($count != 0) {
            $query = "SELECT ID FROM ARTICLE ORDER BY ID ASC";
            $res = $mql->getExecute($query);
            $top = article::getLatestArticle(1);
            $i = 1;
            $flag = 1;
            while ($value = mysql_fetch_array($res)){
                if($value['ID'] != $i) {
                    for( $k = $i; $k < $top; $k++) {
                        $m = $k+1;
                        $query = "UPDATE ARTICLE SET ID = $k WHERE ID = $m";
                        $mql->getExecute($query);
                        $flag = 0;
                    }
                } 
                if($flag == 0) {
                    break;
                }
                $i++;
            }
        }
        else {
            $top = 1;
        }
        //--- Changing auto increment value ---//
        $query = "ALTER TABLE ARTICLE AUTO_INCREMENT = $top";
        $mql->getExecute($query);
        
    }
    /*
     * Deletes everything under the activity
     * @param $aid activity id
     */
    public static function deleteArticleUnderActivity($aid) {
        
        $mql = new query();
        $query = "SELECT ID FROM ARTICLE WHERE ACTIVITY=$aid";
        $res = $mql->getExecute($query);
        while( $result = mysql_fetch_array($res)) {
            article::deleteArticle($result['ID']);
        }
    }
    /*
     * Returs all articles
     */
    public static function getAllArticles() {
        
        $mql = new query();
        $query = 'SELECT ID,TITLE FROM ARTICLE';
        $res = $mql->getExecute($query);
        return $res;
    }

}
?>
