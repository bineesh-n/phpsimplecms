<?php
/*
 * Manages the gallery needs
 */
include_once '/../content/mysql.php';
final class gallery {
    
    private static $path = '../../gallery/images/';
    private static $thumb_path = '../../gallery/images/thumbnails/';
    /*
     * @returns the picure details
     * @param $id the id
     */
    public static function getPicturesOnGalleryId($id) {
        $mql = new query();
        $query = 'SELECT * FROM GPICS WHERE GID='.$id.' ORDER BY ID DESC';
        $result = $mql->getExecute($query);
        return $result;
    }
    /*
     * Returns all pictures
     */
    public static function getAllPictures() {
        $mql = new query();
        $query = 'SELECT ID,TITLE FROM GPICS';
        $res = $mql->getExecute($query);
        return $res;
    }
    /*
     * Lists entire gallery
     */
    public static function listGallery() {
        $mql = new query();
        $query = 'SELECT * FROM GPICS ORDER BY ID DESC';
        $result = $mql->getExecute($query);
        return $result;
    }
    /*
     * Delete a picture with $id
     */
    public static function deletePicture($ar_cont) {
        
        if(array_key_exists('id', $ar_cont)){
            $id = $ar_cont['id'];
        }
        else {
            $id = $ar_cont['ID'];
        }
        
        $mql = new query();
        $query = "SELECT URL FROM GPICS WHERE ID=$id";
        $res = $mql->getExecute($query);
        $url = mysql_fetch_array($res);
        $url = $url['URL'];
        
        $filename_img = "../../gallery/images/".$url;
        if(file_exists($filename_img)) {
            unlink($filename_img);
        }
        $filename_thumb = "../../gallery/images/thumbnails/".$url;
        if(file_exists($filename_thumb)) {
            unlink($filename_thumb);
        }
        $query = "DELETE FROM GPICS WHERE ID=$id";
        $mql->getExecute($query);
    }
    /*
     * Deletes everything under a gallery menu
     */
    public static function deletePicturesUnderMenu($gid) {
        $mql = new query();
        $query = "SELECT ID FROM GPICS WHERE GID= $gid";
        $ans = $mql->getExecute($query);
        while ( $result = mysql_fetch_array($ans) ) {
            gallery::deletePicture($result);
        }
    }

    /*
     * Add an image to the gallery
     */
    public static function addImage($ar_cont, $file) {
        $error_state = 0;
        
        $title = addslashes(htmlentities($ar_cont['title']));
        $gid = $ar_cont['gid'];
        $image = rawurldecode($file['photo']['name']);
        $image_name = $file['photo']['tmp_name'];
        /*
         * Checking for uplaod errors
         */
        if($file['photo']['error']) {
            $error_state = 2;
            if(is_uploaded_file($file['photo']['tmp_name'])) {
                return $error_state;
            }
        }
        $img = 0;
        $img_temp = $image;
        while(file_exists(gallery::$path.$img_temp)) {
            $img_temp = $image;
            $img_temp = 'img'.$img."_".$image;
            $img++;
        }
        $image = $img_temp;
        move_uploaded_file($image_name, gallery::$path.$image);
        /*
         * Checking the image data
         */
        list($width,$height,$type) = getimagesize(gallery::$path.$image);
        if($width>500||$height>500||$type>3) {
            unlink(gallery::$path.$image);
            die("image not satisfies max resolution limitations or type. Program can only deal with jpg,png,gif files. Retry with another image");
        }
        /*
         * Generating thumbnails
         */
        switch ($type) {
            case 1: $src = @imagecreatefromgif(gallery::$path.$image);
                if(!$src) {
                    $error_state = 1;
                }
                break;
            case 2: $src = imagecreatefromjpeg(gallery::$path.$image);
                break;
            case 3: $src = imagecreatefrompng(gallery::$path.$image);
                break;
        }
        
        $thumb = imagecreatetruecolor(70, 70);
        imagecopyresampled($thumb, $src, 0, 0, 0, 0, 70, 70, $width, $height);
        
        switch ($type) {
            case 1:
                if(function_exists('imagegif')) {
                    $success = imagegif($thumb, gallery::$thumb_path.$image);
                }
                $success = FALSE;
                break;
            case 2:
                $success = imagejpeg($thumb,  gallery::$thumb_path.$image,75);
                break;
            case 3:
                $success = imagepng($thumb,  gallery::$thumb_path.$image);
        }
        if(!$success) {
            if(file_exists(gallery::$thumb_path.$image)) {
                unlink(gallery::$thumb_path.$image);
            }
        }
        
        imagedestroy($src);
        imagedestroy($thumb);
        
        $image_path = addslashes($image);
        $description = addslashes(htmlentities($ar_cont['desc']));
        
        $mql = new query();
        $query = "INSERT INTO GPICS(GID,URL,TITLE,DESCRIPTION) VALUES('$gid','$image_path','$title','$description')";
        $mql->getExecute($query);
        
        return $error_state;
    }
}
?>
