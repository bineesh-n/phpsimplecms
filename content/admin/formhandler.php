<?php
/*
 * This file manages inputs to the index.php of admin
 */
if($_SESSION['AUTHENTICATED']) {
if(array_key_exists('add', $_GET)) {
    switch ($_GET['add']) {
        case 1: header::addActivity($_GET);break;
        case 2: header::addGalleryItem($_GET);break;
        case 3: header::addContact($_GET); break;
        case 6: login::change_un($_GET);break;
        case 7: login::change_email($_GET);break;
        case -1: header::deleteActivity($_GET);break;
        case -2: header::deleteGalleryMenu($_GET);break;
        case -3: header::deleteContact($_GET);break;
        case -4: article::deleteArticle($_GET['id']);break;
        case -5: gallery::deletePicture($_GET);break;
    }
    header('Location:/nss/content/admin');
}
else if(array_key_exists('add', $_POST)) {
    switch ($_POST['add']) {
        case 4: article::addNewArticle($_POST, $_FILES);            break;
        case 5: gallery::addImage($_POST, $_FILES);            break;
        case 8: login::change_password($_POST);
    }
    header('Location:/nss/content/admin');
}
}
?>
