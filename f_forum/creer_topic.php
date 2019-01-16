<?php
session_start();
require_once"../classes/Data_Base.class.php";
require_once"../include/connexion.conf.inc.php";
require_once"../include/functions.inc.php";

$db = new Data_Base(SGBD,HOST,DBNAME,USER,PASSWORD);

// S'il n'y a pas de session alors on ne va pas sur cette page
    if (!isset($_SESSION['id'])){
        header('Location: ../authentification/connexion.php');
        exit;
    }
    if (!isset($_SESSION['id'])){
          header('Location: /forum');
          exit;
      }

      if(!empty($_POST)){
          extract($_POST);
          $valid = true;

          if (isset($_POST['creer-topic'])){

              // Récupération de nos différents champs
              $titre  = htmlentities(trim($titre));
              $contenu = htmlentities(trim($contenu));
              $categorie = (int) htmlentities(trim($categorie));

              if(empty($titre)){
                  $valid = false;
                  $er_titre = ("Il faut mettre un titre");
              }

              if(empty($contenu)){
                  $valid = false;
                  $er_contenu = ("Il faut mettre un contenu");
              }

              if(empty($categorie)){
                  $valid = false;
                  $er_categorie = "Le mail ne peut pas être vide";

              }else{
                  // On vérifit que la catégorie existe
                    $verif_cat = $db->prepare("SELECT id, titre FROM forum WHERE id = ?");
                    $params2 = array($categorie);

                    $verif_cat->execute($params2);
                    $verif_cat = $verif_cat->fetch();
                    echo $categorie;
                  echo "fares";
                  if (!isset($verif_cat['id'])){
                      $valid = false;
                      $er_categorie = "Cette catégorie n'existe pas";
                  }
              }

              if($valid){


                  if (isset($_FILES['file'])) {
                      $file = $_FILES['file'];
                      $file_name = $file['name'];
                      $file_tmp = $file['tmp_name'];
                      $file_size = $file['size'];
                      $file_error = $file['error'];

                      $file_ext = explode('.', $file_name);
                      $file_ext = strtolower(end($file_ext));
                      $random = random_str(15);
                      $file_name_new = strtoupper($random.'.'.$file_ext);
                      $file_destination = "../public/profilpic/".$file_name_new;

                      $date_creation = date('Y-m-d H:i:s');
                      $req4=$db->prepare("INSERT INTO sujet (id_forum, titre, contenu, date_creation, id_user,photo) VALUES (?, ?, ?, ?, ?,?)");
                      $params3 =  array($categorie, $titre, $contenu, $date_creation, $_SESSION['id'],$file_destination);
                      $req4->execute($params3);

                    //  echo $file_destination;
                    //  $db->query("UPDATE topic SET photo_topic='".$file_destination."' ");
                      upload_image($file_ext,$file_destination,$file_error,$file_size,$file_tmp);



                  }


                  header('Location: ../forum/' . $categorie);
                  exit;
              }
          }
      }



?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
        <link rel="stylesheet" href="../style/styleForum.css">
        <title>topico</title>
    </head>

    <body>
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">Accueil</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Profil <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Forum</a>
        </li>
      </ul>

      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>

      <ul class="navbar-nav ml-md-auto">
        <li class="nav-item">
          <a class="nav-link" href="../authentification/deconnexion.php">Déconnexion</a>
        </li>
      </ul>




    </div>
  </nav>
  <div class="container">
           <div class="row">

               <div class="col-sm-0 col-md-0 col-lg-0"></div>
               <div class="col-sm-12 col-md-12 col-lg-12">
                   <div class="cdr-ins">

                       <h1>Créer un sujet</h1>

                       <form method="post" enctype="multipart/form-data" >

                           <?php
                               // S'il y a une erreur sur la catégorie alors on affiche
                               if (isset($er_categorie)){
                               ?>
                                   <div class="er-msg"><?= $er_categorie ?></div>
                               <?php
                               }
                           ?>
                           <div class="form-group">
                               <div class="input-group mb-3">
                                   <select name="categorie" class="custom-select" id="inputGroupSelect01">

                                       <?php
                                           if(!isset($categorie)){
                                           ?>
                                           <option selected>Sélectionner votre catégorie</option>
                                           <?php
                                           }else{
                                           ?>
                                           <option value="<?= $categorie ?>"><?= $verif_cat['titre'] ?></option>
                                           <?php
                                           }
                                       ?>

                                       <?php
                                           $req_cat = $db->query("SELECT * FROM forum");

                                           $req_cat = $req_cat->fetchALL();

                                           foreach($req_cat as $rc){
                                           ?>
                                               <option value="<?= $rc['id'] ?>"><?= $rc['titre'] ?></option>
                                           <?php
                                           }
                                       ?>
                                   </select>
                               </div>
                           </div>
                           <?php
                               if (isset($er_titre)){
                               ?>
                                   <div class="er-msg"><?= $er_titre ?></div>
                               <?php
                               }
                           ?>
                           <div class="form-group">
                            <input class="form-control" type="text" placeholder="Votre titre" name="titre" value="<?php if(isset($titre)){ echo $titre; }?>">
                           </div>
                           <?php
                               if (isset($er_contenu)){
                               ?>
                                   <div class="er-msg"><?= $er_contenu ?></div>
                               <?php
                               }
                           ?>
                           <div class="form-group">
                               <textarea class="form-control" rows="3" placeholder="Décrivez votre sujet" name="contenu"><?php if(isset($contenu)){ echo $contenu; }?></textarea>
                           </div>


                           <div class="form-group">
                              <label for="file" style="margin-bottom: 0; margin-top: 5px; display: inline-flex">
                                 <input id="file" type="file" name="file" class="hide-upload" required/>
                                 <i class="fa fa-plus image-plus"></i>
                              </label>
                            </div>


                           <div class="form-group">
                               <button class="btn btn-primary" type="submit" name="creer-topic">Envoyer</button>
                           </div>

                       </form>
                   </div>
               </div>
           </div>
       </div>






            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
            <script src="../bootstrap/js/bootstrap.min.js" ></script>
    </body>
</html>
