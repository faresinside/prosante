<?php
    session_start();
    require_once"../classes/Data_Base.class.php";
    require_once"../include/connexion.conf.inc.php";
    require '../include/recaptchalib.php';
    $siteKey = '6Lcz838UAAAAAOij2RS3nB5nyXrBovK3nXI9OBqX'; // votre clé publique
    $secret = '6Lcz838UAAAAAFIPKDoBj9cWdnIE9_1ftLL6Uc5v'; // votre clé privée
    $db = new Data_Base(SGBD,HOST,DBNAME,USER,PASSWORD);

    $authenticate_error = null;

    function authenticate()
    {
        global $db,$authenticate_error;
        $query = $db->query("SELECT mot_de_passe,confirme,id,nom,prenom,mail,photo FROM professionnels WHERE mail ='".$_SESSION['username']."'");
        if ($query->rowCount()>0){
            $row = $query->fetch();
            if($row[1]==0){
                if(password_verify($_SESSION['password'],$row[0])){
                          $_SESSION['id'] = $row['id']; // id de l'utilisateur unique pour les requêtes futures
                          $_SESSION['nom'] = $row['nom'];
                          $_SESSION['prenom'] = $row['prenom'];
                          $_SESSION['email'] = $row['mail'];
                          $_SESSION['avatar'] = $row['photo'];
                        header('location: ../profil/profil.php');
                    exit();
                }else{
                    $authenticate_error = "<p class='error_msg'>Nom d'utilisateur ou mot de passe incorrect.</p>";
                }
            }else{
                $authenticate_error = "<p class='error_msg'>Votre compte n'est pas encore confirmé, merci de consulter votre mail.</p>";
            }
        }else{
            $authenticate_error = "<p class='error_msg'>Nom d'utilisateur ou mot de passe incorrect.</p>";
        }
    }


$reCaptcha = new ReCaptcha($secret);
if(isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
        );
    if ($resp != null && $resp->success) {
    if(isset($_POST['LOGIN']) && !empty($_POST['username']) && !empty($_POST['password'])){
        $_SESSION['username']=$_POST['username'];
        $_SESSION['password']=$_POST['password'];
        authenticate();
    }elseif(isset($_SESSION['username']) && isset($_SESSION['password'])){
        authenticate();
    }

}
    else {$authenticate_error = "<p class='error_msg'>ReCaptcha Invalide</p>";}
    }

    $urerr = "",
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Connexion</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
        <link rel="stylesheet" href="../style/style1.css">
        <script src="https://www.google.com/recaptcha/api.js"></script>
<style>
        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
</style>
    </head>
    <body>


                <form id="register_form" action="./connexion.php" method="post">
                  <div class="container">
                      <div class="inner">

                          <div class="title">
                              <h3>Connexion</h3>
                          </div>
                          <img src="../style/images/user.png" class="photo" >
                          <div class="content">
                              <div class="txt">
                                <input type="text" placeholder="Entrez votre mail" id="mail" name="username" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" maxlength="30" required/>
                                <span id="c1" class="glyphicon glyphicon-envelope"></span>
                              </div>
                                 <span id="span"><?php echo $urerr; ?></span>
                              <div class="txt1">
                                <input type="password" placeholder=" mot de passe" name="password" minlength="5" maxlength="20" required>
                                  <span id="c2" class="glyphicon glyphicon-lock"></span>
                              </div>
                            <div class="registration">
                              <a href="Registration.php">S'inscrire</a>
                            </div>
                              <?php
                                  if($authenticate_error != null){
                                      echo($authenticate_error);
                                  }
                              ?>
                          </div>

                          <div class="g-recaptcha" data-sitekey="6Lcz838UAAAAAOij2RS3nB5nyXrBovK3nXI9OBqX" ></div>


                          <div class="btnsub">
                              <input type="submit" name="LOGIN" id="btnsub" value="se connecter">
                          </div>

                      </div>

                  </div>

                </form>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
        <script src="../bootstrap/js/bootstrap.min.js" ></script>
        <script type="text/javascript">

             $(document).ready(function () {
                 $('#menu_btn').on('click', function () {
                     $('#sidebar').toggleClass('active');
                 });
             });
        </script>
        <?php
            $db->close_connection();
        ?>
    </body>
</html>
