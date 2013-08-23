<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
    <head>
        <title>NSS | GEC Palakkad </title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="/nss/content/css/header-content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/res/content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/content/css/footer-content.css" type="text/css" />
        <script src="/nss/scripts/jquery.min.js"></script>
        <script src="/nss/scripts/content.js"></script>
    </head>
    <body>
        <div id="page">
<?php
 include_once 'articles.php';
 include_once '/../content/header.php';
?>
            <div id="content">
                <div id="art-act">
                <?php
                if(array_key_exists('activity', $_GET)){
                    ?>
                    <div id="art-hd">
                        Articles under this activity:
                    </div>
                    <?php
                    $result = article::getArticleOnActivity($_GET['activity']);
                    while($res = mysql_fetch_array($result)) {
                        ?>
                    <div id="art-lst">
                        <a href="/nss/article?id=<?php echo $res['ID'] ?>" >
                        <?php
                        echo $res['TITLE'];
                         ?>
                        </a>
                    </div>
                        <?php
                    }
                }
                elseif (array_key_exists('id', $_GET)) {
                    $res = article::getArticleById($_GET['id']);
                    ?>
                    <div id="art-hd">
                        Articles similar to this activity:
                    </div>
                    <?php
                    $result = article::getArticleOnActivity($res['ACTIVITY']);
                    while($reslt = mysql_fetch_array($result)) {
                        ?>
                    <div id="art-lst">
                        <a href="/nss/article?id=<?php echo $reslt['ID'] ?>" >
                        <?php
                        echo $reslt['TITLE'];
                         ?>
                        </a>
                    </div>
                    <?php
                    }
                    ?>
                    <div id="h-article">
                        <div id="h-arth">
                            <?php echo $res['TITLE']; ?>
                        </div>
                        <div id="h-arta">Author: <?php echo $res['AUTHOR']; ?></div>
                        <?php if($res['PHOTOURL'] != 'images/null') { ?>
                        <img src="<?php echo $res['PHOTOURL']; ?>" class="h-artp" alt="article image" />
                        <?php  } ?>
                        <div id="h-artc">
                            <?php echo $res['CONTENT'] ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                </div>
            </div>
            
            <?php
include_once '/../content/footer.php';
?>
        </div>
    </body>
</html>