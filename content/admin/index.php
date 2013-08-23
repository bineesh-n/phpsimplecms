<?php
session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb">
    <head>
        <title>NSS | GEC Palakkad </title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="/nss/content/css/header-content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/res/content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/res/admin.css" type="text/css" />
        <link rel="stylesheet" href="/nss/content/css/footer-content.css" type="text/css" />
        <script src="/nss/scripts/jquery.min.js"></script>
        <script src="/nss/scripts/content.js"></script>
        <script src="/nss/scripts/hlight.js"></script>
    </head>
    <body>
        <div id="page">
<?php
include_once '../header.php';
include_once 'login.php';
include_once '../chead.php';
include_once '/../../article/articles.php';
include_once '/../../gallery/gallery.php';

?>
            <div id="black">
                <div id="warn">
                    <img src="../../images/close_pop.png" class="close" onclick="closePopup()" title="close" />
                    <img src ="../../images/warning.png" class="warn-img" />
                    <div id="msg"></div>
                </div>
        </div>
            <div id="content">
                <div id="tab">
                    <?php
                    if(!isset($_SESSION['AUTHENTICATED'])||!$_SESSION['AUTHENTICATED']) {
                    ?>
                    <div class="tab-items" id="t1" >login</div>
                    <?php
                    }
                    else if($_SESSION['AUTHENTICATED']){
                    ?>
                    <div class="tab-items" id="t2" onclick="highlightElement('t2')">headers</div>
                    <div class="tab-items" id="t3" onclick="highlightElement('t3')">article</div>
                    <div class="tab-items" id="t5" onclick="highlightElement('t5')">delete</div>
                    <div class="tab-items" id="t4" onclick="highlightElement('t4')">Others</div>
                    <?php
                    }
                    ?>
                </div>
                <?php
                if(!isset($_SESSION['AUTHENTICATED'])||!$_SESSION['AUTHENTICATED']) {
                    login_form();
                }
                else if($_SESSION['AUTHENTICATED']){
                    main_forms();
                }
                
                ?>
                
            </div>
        <?php
        include_once '../footer.php';
        ?>
        </div>
    </body>
</html>

<?php
    function login_form() {
        ?>
        <div id="login-tab">
            <?php
            if(isset($_SESSION['AUTHENTICATED'])) {
                if(!$_SESSION['AUTHENTICATED']) { ?>
            <font style="color: red">Your authentication failed</font>
                <?php }
                    unset($_SESSION['AUTHENTICATED']);
            }
            ?>
                    <form action="../admin/" method="post" name="login" onsubmit="return validate('login')">
                    <span>Login using your credentials</span>
                    <p>Enter Username:
                    <input type="text" name="un" />
                    </p>
                    <p>Enter Password:
                    <input type="password" name="pwd" />
                    </p>
                    <input type="submit" value="log in" />
                    <a href="recovery.php?mail">Forgot password ?</a>
                    </form>
         </div>
                
<?php
    }
    
    function main_forms() {
        include_once 'formhandler.php';
        ?>
                <div id="head-edit" >
                    <form action="../admin/" name="act" method="get" onsubmit="return validate('act')" >
                        <span>Add new activity</span>
                        <p>Enter Name(35 characters):*
                        <input type="text" name="name" />
                        </p>
                        <p>Enter Description(60 characters):*
                        <input type="text" name="desc" />
                        </p>
                        <input type="hidden" name="add" value="1"/>
                        <input type="submit" value="add"/>
                </form>
                <form action="../admin/" method="get" name="gal" onsubmit="return validate('gal')" >
                    <span>Add gallery item</span>
                    <p>Enter item(35 characters):*
                    <input type="text" name="item" />
                    </p>
                    <p>Enter Description(60 characters):
                    <input type="text" name="desc" />
                    </p>
                    <input type="hidden" name="add" value="2"/>
                    <input type="submit" value="add"/>
                </form>
                <form action="../admin/" method="get" name="cont" onsubmit="return validate('cont')">
                    <span>Add a contact information</span>
                    <p>Enter Name(50 characters):*
                    <input type="text" name="name" />
                    </p>
                    <p>Enter Department(80 characters):
                    <input type="text" name="dept" />
                    </p>
                    <p>Enter phone number:*
                    <input type="text" name="no" />
                    </p>
                    <input type="hidden" name="add" value="3" />
                    <input type="submit" value="add"/>
                </form>
                </div>
                <div id="act-edit">
                    <form action="../admin/" method="post" enctype="multipart/form-data" name="art" onsubmit="return validate('art')" >
                    <span>Write an article</span>
                    <p>Enter Title(80 characters):*
                    <input type="text" name="title" />
                    </p>
                    <p>Enter Author(50 characters):
                    <input type="text" name="author" />
                    </p>
                    <p>
                        Select relative Activity:*
                        <select name="activity">
                            <?php
                                    $res = header::listActivities();
                                    while($result = mysql_fetch_array($res)) {
                                        ?>
                            <option value="<?php echo $result['ID'];  ?>"><?php echo $result['NAME']  ?></option>
                                        <?php
                                    }
                            ?>
                        </select>
                    </p>
                    <p>Upload a photo:
                    <input type="file" name="photo" accept="image/gif,image/jpeg,image/x-png" />
                    </p>
                    <p>
                        Write your article code below. You can use your web design knowledge here. Do not add HTML structure elements.<br/>
                            <textarea name="content" rows="50" columns="50" placeholder="Do not make this complicated. Use simple elements only."></textarea>
                    </p>
                    <input type="hidden" name="add" value="4" />
                    <input type="submit" value="publish"/>
                </form>
                
                    
                </div>
                <div id="delete">
                    <form action="../admin/" method="get">
                        <span>Delete An Activity</span>
                        <br/>Warning: All the articles under the activity will be automatically deleted<br/>
                        <p>Select an activity:
                        <select name="id">
                            <?php
                                    $res = header::listActivities();
                                    while($result = mysql_fetch_array($res)) {
                                        ?>
                            <option value="<?php echo $result['ID'];  ?>"><?php echo $result['NAME']  ?></option>
                                        <?php
                                    }
                            ?>
                        </select>
                        </p>
                        <input type="hidden" name="add" value="-1" />
                        <input type="submit" value="Delete"/>
                    </form>
                    <form action="../admin/" method="get">
                        <span>Delete A Gallery Menu Item</span>
                        <br/>Warning: All the pictures under the item will be deleted<br/>
                        <p>Select an item:
                            <select name="gid">
                                <?php
                              $result = header::listGalleryItems();
                              while ($res = mysql_fetch_array($result)) {
                                  ?>
                            <option value="<?php echo $res['ID']  ?>"><?php echo $res['ITEM']  ?></option>
                            <?php
                              }
                            ?>
                            </select>
                        </p>
                        <input type="hidden" name="add" value="-2" />
                        <input type="submit" value="delete" />
                    </form>
                    <form action="../admin/" method="get">
                        <span>Delete A Contact</span>
                        <p>Select a contact:
                            <select name="id">
                                <?php
                              $result = header::listContacts();
                              while ($res = mysql_fetch_array($result)) {
                                  ?>
                            <option value="<?php echo $res['ID']  ?>"><?php echo $res['NAME']  ?></option>
                            <?php
                              }
                            ?>
                            </select>
                        </p>
                        <input type="hidden" name="add" value="-3" />
                        <input type="submit" value="delete" />
                    </form>
                    <form action="../admin/" method="get">
                        <span>Delete An Article</span>
                        <p>
                            Select An Article:
                            <select name="id">
                                <?php
                              $result = article::getAllArticles();
                              while ($res = mysql_fetch_array($result)) {
                                  ?>
                            <option value="<?php echo $res['ID']  ?>"><?php echo $res['ID'],"-",$res['TITLE'];  ?></option>
                            <?php
                              }
                            ?>
                            </select>
                        </p>
                        <input type="hidden" name="add" value="-4" />
                        <input type="submit" value="delete" />
                    </form>
                    <form action="../admin/" method="get">
                        <span>Delete A Picture</span>
                        <p>
                            Select A Picture:
                            <select name="id">
                                <?php
                              $result = gallery::getAllPictures();
                              while ($res = mysql_fetch_array($result)) {
                                  ?>
                            <option value="<?php echo $res['ID']  ?>"><?php echo $res['ID'],"-",$res['TITLE'];  ?></option>
                            <?php
                              }
                            ?>
                            </select>
                        </p>
                        <input type="hidden" name="add" value="-5" />
                        <input type="submit" value="delete" />
                    </form>
                </div>
                <div id="others">
                    
                <form action="../admin/" method="post" enctype="multipart/form-data" name="pic" onsubmit="return validate('pic')">
                    <span>Add A Gallery Picture</span>
                    <p>Enter title(40 Characters):*
                    <input type="text" name="title" />
                    </p>
                    <p>Select relative gallery item:*
                        <select name="gid">
                            <?php
                              $result = header::listGalleryItems();
                              while ($res = mysql_fetch_array($result)) {
                                  ?>
                            <option value="<?php echo $res['ID']  ?>"><?php echo $res['ITEM']  ?></option>
                            <?php
                              }
                            ?>
                        </select>
                    </p>
                    <p>Upload image(Max resolution:500x500):*
                    <input type="file" name="photo" accept="image/gif,image/jpeg,image/x-png" />
                    </p>
                    <p>Enter Description(255 Characters):
                    <input type="text" name="desc" />
                    </p>
                    <input type="hidden" name="add" value="5"/>
                    <input type="submit" value="add"/>
                </form>
                    <form action="../admin/" method="get" name="una" onsubmit="return validate('una')">
                        <span>Change username</span>
                        <p>Enter new username:*
                        <input type="text" name="un" />
                        </p>
                        <input type="hidden" name="add" value="6"/>
                        <input type="submit" value="change"/>
                    </form>
                    <form action="../admin/" method="get" name="ema" onsubmit="return validate('ema')">
                        <span>Change Email id</span>
                        <p>Enter new Email id:*
                        <input type="text" name="email" />
                        </p>
                        <input type="hidden" name="add" value="7"/>
                        <input type="submit" value="change"/>
                    </form>
                    <form action="../admin/" method="post" name="pwd" onsubmit="return validate('pwd')">
                        <span>Change password</span>
                        <p>Enter password(6 Chars minimum ):*
                        <input type="password" name="pwd" />
                        </p>
                        <p>Enter new password:*
                        <input type="password" name="pwd-verify" />
                        </p>
                        <input type="hidden" name="add" value="8"/>
                        <input type="submit" value="change" />
                    </form>
                </div>
<?php
    }
?>