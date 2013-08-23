<?php
include_once 'chead.php';
?>
<div class="dropdown" id="4">
    <?php
    $result = header::listActivities();
    while ($act = mysql_fetch_array($result)) {
        ?>
    <div id="dr-h" >
        <div id="dr-ht" >
            <a href="/nss/article/?activity=<?php echo $act['ID']; ?>">
        <?php
        echo $act['NAME'];
        ?>
            </a>
        </div>
        <div id="dr-hs">
        <?php
        echo $act['DESCRIPTION']
        ?>
        </div>
    </div>
    <?php
        
    }
    
    ?>
</div>
<div class="dropdown" id="5">
    <?php
    $result = header::listGalleryItems();
    while ($act = mysql_fetch_array($result)) {
        ?>
    <div id="dr-h">
        <div id="dr-ht">
            <a href="/nss/gallery/?gid=<?php echo $act['ID']; ?>">
        <?php
        echo $act['ITEM'];
        ?>
            </a>
        </div>
        <div id="dr-hs">
        <?php
        if($act['DESCRIPTION'] != "") {
            echo $act['DESCRIPTION'];
        }
        else {
            echo 'No description';
        }
        ?>
        </div>
    </div>
    <?php
        
    }
    
    ?>
</div>
<div class="dropdown" id="6">
    <?php
    $result = header::listContacts();
    while ($act = mysql_fetch_array($result)) {
        ?>
    <div id="dr-hc">
        <div id="dr-ht">
            <?php echo $act['NAME']; ?>
         </div>
        <div id="dr-hd">
        <?php
        echo $act['DEPARTMENT'];
        ?>
        </div>
        <div id="dr-hs">CALL:
        <?php
        echo $act['NO']
        ?>
        </div>
    </div>
    <?php
        
    }
    
    ?>
</div>
<div id="head" onClick="goHome()">
    <div id="login-notify"><?php
    if(!isset($_SESSION['AUTHENTICATED'])||!$_SESSION['AUTHENTICATED']) {
        ?>
        <a href="/nss/content/admin">log in</a>
        <?php
    }
    else {
        ?>
        <a href="/nss/content/admin/?logout">administrator-log out</a>
        <?php
    }
    ?></div>
    <img class="logo" src="images/logo.gif" alt="nss logo" title="our logo" />
    <div id="title">
        NATIONAL SERVICE SCHEME  <br/>
        GOVT. ENGINEERING COLLEGE SREEKRISHNAPURAM, PALAKKAD<br/>
        <font style="font-size: 15px;">NOT ME BUT YOU</font>
    </div>
</div>
<div id="menu">
    <div class="menu-items" id="1" >
        ACTIVITIES
    </div>
    <div class="menu-items" id="2">
        GALLERY
    </div>
    <div class="menu-items" id="3">
        CONTACT
    </div>
</div>
