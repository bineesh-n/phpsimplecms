<?php

/**
 * Description of pages
 *
 * @author Bineesh
 */

include_once 'mysql.php';
/*
 * Pages management.
 * Adding next, last, previous, start buttons to every home page
 */
final class pages {
    
    public static function getHomePagesInfo($current) {
        
        $mql = new query();
        $query = 'SELECT COUNT(*) FROM ARTICLE';
        $result = $mql->getExecute($query);
        $res = mysql_fetch_array($result);
        $count = $res['COUNT(*)'];
        
        if($current == 1) {
            $prev = 0;
            $start = 0;
        }
        else if($current > 1){
            $prev = 1;
            $start = 1;
        }
        
        $pages = $count/3;
        $pages = $pages-(($count%3)/3);
        $next = 0;
        $end = 0;
        if($count%3 > 0) {
            $pages++;
        }
        
        if($current < $pages) {
            $next = 1;
            $end = $pages;
        }
        
        $page = array( 
                        'prev'=>$prev,
                        'start'=>$start,
                        'next' =>$next,
                        'end' => $end,
                        'pages' => $pages
                    );
        return $page;
    }
}

?>
