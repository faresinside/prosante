<?php
session_start();
require_once"../classes/Data_Base.class.php";
require_once"../include/connexion.conf.inc.php";
require_once"../include/functions.inc.php";
$db = new Data_Base(SGBD,HOST,DBNAME,USER,PASSWORD);
    $pdo = $db->get_PDO();
    $query = $db->query("SELECT * FROM professionnels WHERE id ='".$_SESSION['id']."'");
    $row = $query->fetch();
    $afficher_profil = $db->query("SELECT * FROM professionnels WHERE id ='".$_SESSION['id']."'");

  $afficher_profil = $afficher_profil->fetch();

if (isset($_POST['upload'])) {
           if (isset($_FILES['file'])) {
               $file = $_FILES['file'];
               $file_name = $file['name'];
               $file_tmp = $file['tmp_name'];
               $file_size = $file['size'];
               $file_error = $file['error'];

               $file_ext = explode('.', $file_name);
               $file_ext = strtolower(end($file_ext));

               $file_name_new = strtoupper($row[nom])."_".$row[prenom].'.'.$file_ext;
               $file_destination = "../public/profilpic/".$file_name_new;
               $id = $_SESSION['id'];


               $db->query("UPDATE professionnels SET photo='".$file_destination."' WHERE id='".$id."'");

               upload_image($file_ext,$file_destination,$file_error,$file_size,$file_tmp);

               header("Location: ./profil.php");

           }
       }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="../style/style1.css">
    <title>Mon profil</title>
  </head>
  <body>
    <div class="container">
       <div class="row">
          <div class="col-sm-0 col-md-2 col-lg-1"></div>
          <div class="col-sm-12 col-md-8 col-lg-10">
            <div class="profilpic">

              <?php
                    if(file_exists($afficher_profil['photo']) && isset($_SESSION['avatar'])){

                 ?>

                    <img src="<?=  $afficher_profil['photo']; ?>"  class="photo">


                 <?php
                    }else{
                 ?>
                    <img src="../public/profilpic/default/user.png" class="photo" >

                 <?php
                    }
                 ?>



            </div>
             <span class="image-upload">
             <form method="post" enctype="multipart/form-data">
                <label for="file" style="margin-bottom: 0; margin-top: 5px; display: inline-flex">
                   <input id="file" type="file" name="file" class="hide-upload" required/>
                   <i class="fa fa-plus image-plus"></i>
                   <input type="submit" name="upload" value="Envoyer">
                </label>
             </form>
             </span>
          </div>
       </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
    <script src="../bootstrap/js/bootstrap.min.js" ></script>
  </body>
</html>
