

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
    <head>
        <title>NSS | GEC Palakkad </title>
                <link rel="shortcut icon" href="favicon.ico" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="discription" content="National Service Scheme Unit 185 GEC Palakkad" />
        <meta name="keywords" content="nss, gecskp, sreekrishnapuram, national service sheme, nss activities, nss gallery, contact gec skp" />
        <link rel="stylesheet" href="content/css/header-content.css" type="text/css" />
        <link rel="stylesheet" href="res/content.css" type="text/css" />
        <link rel="stylesheet" href="content/css/footer-content.css" type="text/css" />
        <link rel="stylesheet" type="text/css" href="css/style.css" />
	<script type="text/javascript" src="scripts/jquery.js"></script>
        <script src="scripts/content.js"></script>
        
    </head>
    <body>
        <div id="page">
<?php
 include_once 'content/header.php';
 include_once 'article/articles.php';
 include_once 'content/pages.php';
?>
            <div id="content">
            <div id="wowslider-container1">
	<div class="ws_images"><ul>
<li><img src="images/koala.jpg" alt="Save energy, save future" title="" id="wows1_0"/></li>
<li><img src="images/lighthouse.jpg" alt="Donate Blood that saves a life" title="" id="wows1_1"/></li>
<li><img src="images/penguins.jpg" alt="Avoid drugs, contribute to a powerful india" title="" id="wows1_2"/></li>
<li><img src="images/cleancity.jpg" alt="Keep your city clean" title="" id="wows1_3"/></li>
<li><img src="images/womenprotection.jpg" alt="poster against voilence against women" title="" id="wows1_4"/></li>
</ul></div>
<div class="ws_bullets"><div>
<a href="#" title=""><img src="images/tooltips/koala.jpg" alt="Koala"/>1</a>
<a href="#" title=""><img src="images/tooltips/lighthouse.jpg" alt="Lighthouse"/>2</a>
<a href="#" title="Penguins"><img src="images/tooltips/penguins.jpg" alt="Penguins"/>3</a>
<a href="#" title=""><img src="images/tooltips/cleancity.jpg" alt="Keep your city clean"/>4</a>
<a href="#" title=""><img src="images/tooltips/womenprotection.jpg" alt="women protection"/>4</a>
</div></div>
                <div class="ws_shadow"></div>
	</div>
	<script type="text/javascript" src="scripts/wowslider.js"></script>
	<script type="text/javascript" src="scripts/script.js"></script>
                <?php
                    if(array_key_exists('p', $_GET)) {
                        $lt = article::getLatestArticle($_GET['p']);
                    }
                    else {
                        $lt = article::getLatestArticle(1);
                    }
                    if($lt > 2) {
                        $i = 3;
                    }
                    else {
                        $i = $lt;
                    }
                    
                    for(; $i>0; $i--, $lt--) {
                        $r = article::getArticlePreview($lt);
                        ?>
                        <div id="ph-article">
                        <div id="h-arth">
                            <?php echo $r['TITLE']; ?>
                        </div>
                        <div id="h-arta">Author: <?php echo $r['AUTHOR']; ?></div>
                        <?php if( $r['PHOTOURL'] != 'images/null') {  ?>
                        <img src="article/<?php echo $r['PHOTOURL']; ?>" class="h-artp" alt="article image" />
                        <?php  } ?>
                        <div id="h-artc">
                            <?php echo $r['CONTENT'];
                            if($r['trim']) {
                                ?> 
                            <a href ="article/?id=<?php echo $r['ID']; ?>">read more..</a> 
                      <?php } ?>
                        </div>
                    </div>
                <?php
                    }
                ?>
        <div id="ctrls">
            <?php 
            if(array_key_exists('p', $_GET)) {
                $current = $_GET['p'];
            }
            else {
                $current = 1;
            }
            $page = pages::getHomePagesInfo($current);
            if($page['start']) {
            ?>
            <a href="?p=1" title="home">
                <img src="images/start.png" class="ctrl-button"/>
            </a>
            <?php
            } 
            if($page['prev']) {
            ?>
            <a href="?p=<?php echo $current-1; ?>">
                <img src="images/prev.png" class="ctrl-button"/>
            </a>
            <?php
            }
            ?>
            <input class="ctrl-button" value="<?php echo $current;  ?>" type="text" id="i" onchange="goPage()" title="total pages:<?php echo $page['pages']; ?>" />
            <script>
                function goPage() {
                    var r=document.getElementById('i').value;
                    if(r <= <?php echo $page['pages'];  ?>&&r!=="" &&r>0) {
                        window.location = '?p='+r;
                    }
                }
            </script>
            <?php
            if($page['next']){
            ?>
            <a href="?p=<?php echo $current+1  ?>" title="next page">
                <img src="images/next.png" class="ctrl-button"/>
            </a>
            <?php
            }
            if($page['end']){
            ?>
            <a href="?p=<?php echo $page['end']  ?>" title="end page">
                <img src="images/end.png" class="ctrl-button"/>
            </a>
            <?php
            }
            ?>
        </div>
            </div>
<?php
 require_once 'content/footer.php';
?>
        </div>
    </body>
</html>