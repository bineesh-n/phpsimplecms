<?php
include_once '../mysql.php';
session_start();
/*
 * Manages the password recovery
 */
if(array_key_exists('mail', $_GET) && !isset($_SESSION['code'])) {
    
    /*fetching email from database*/
    $mql = new query();
    $query = 'SELECT EMAIL FROM ADMIN';
    $res = $mql->getExecute($query);
    $mail = mysql_fetch_array($res);
    $mail = $mail['EMAIL'];
    /*generating random key*/
    $gen_key = mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);
    /*sending mail*/
    $subject = "Password reset code from nss gec sreekrishnapuram";
    $message = "Your password reset secret code is: ".$gen_key;
    $headers='From: ofegecskp@gmail.com' . "\r\n" .
                'Reply-To: ofegecskp@gmail.com' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
    mail($mail, $subject, $message, $headers) or die("Error sending mail");
    /*storing the code as session variable*/
    $gen_key = md5($gen_key);
    session_register('code');
    $_SESSION['code'] = $gen_key;
    /*redirecting*/
    header('Location: ./recovery.php');
}
else if(array_key_exists('code', $_POST)) {
    
    if($_SESSION['code'] == md5($_POST['code'])) {
        unset($_SESSION['code']);
        session_destroy();
        reset_password();
    }
    else {
        echo "Sorry, Code mismatch";
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <head>
        <title>NSS | GEC Palakkad </title>
                <link rel="shortcut icon" href="favicon.ico" />
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta name="discription" content="National Service Scheme Unit 185 GEC Palakkad" />
        <meta name="keywords" content="nss, gecskp, sreekrishnapuram, national service sheme, nss activities, nss gallery, contact gec skp" />
        <link rel="stylesheet" href="/nss/content/css/header-content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/res/content.css" type="text/css" />
        <link rel="stylesheet" href="/nss/res/admin.css" type="text/css" />
        <link rel="stylesheet" href="/nss/content/css/footer-content.css" type="text/css" />
        <script src="/nss/scripts/jquery.min.js"></script>
        <script src="/nss/scripts/content.js"></script>
        <title>National Service Scheme GEC Palakkad | Password Reset</title>
    </head>
    <body>
          <div id="page">
        <?php
        include_once '../header.php';
        ?>
              <div id="content">
                  <?php
                    if(isset($_SESSION['code'])){
                          rec_code();
                    }
                    else if(isset ($_GET['success'])) {
                        ?>
                  <div id="login-tab">
                  <form>
                      <span>Your password has reset successfully.</span>
                      <p>New password sent to your email id. Go <a href="../admin">login page</a></p>
                  </form>
                  </div>
                        <?php
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

function rec_code() {
    ?>
    <div id="login-tab">
        <form action="./recovery.php" method="post" >
          <span>Welcome to password recovery </span>
           <p>
             <label for="code">Enter the code you received to mail:</label>
             <input type="number" name="code" /><br/>
           </p>
          <input type="submit" value="submit" />
       </form>
    </div>
<?php
}

function reset_password() {
    $mql = new query();
    $new_pwd = mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9).mt_rand(0, 9);
    $query = 'SELECT EMAIL FROM ADMIN';
    $res = $mql->getExecute($query);
    $mail = mysql_fetch_array($res);
    $mail = $mail['EMAIL'];
    /*sending mail*/
    $subject = "New Password Request | NSS GEC Palakkad";
    $message = "Your password has been reset and the new password is: ".$new_pwd."\r\n Thank You";
    $headers='From: ofegecskp@gmail.com' . "\r\n" .
                'Reply-To: ofegecskp@gmail.com' . "\r\n" .
                'MIME-Version: 1.0' . "\r\n" .
                'Content-type: text/html; charset=iso-8859-1' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
    mail($mail, $subject, $message, $headers) or die("Error sending mail:reset");
    /*Saving password*/
   $pwd = md5($new_pwd);
    $query = "UPDATE ADMIN SET PASSWORD='$pwd'";
    $mql->getExecute($query);
    header('Location: ./recovery.php?success');
}
?>