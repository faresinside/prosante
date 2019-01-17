<?php
session_start();
require_once"../classes/Data_Base.class.php";
require_once"../include/connexion.conf.inc.php";

$db = new Data_Base(SGBD,HOST,DBNAME,USER,PASSWORD);

// S'il n'y a pas de session alors on ne va pas sur cette page
    if (!isset($_SESSION['id'])){
        header('Location: ../authentification/connexion.php');
        exit;
    }
    // Récupération de l'id de la catégorie
$get_id_forum = (int) trim(htmlentities($_GET['id_forum']));
  // Récupération de l'id du topic
$get_id_topic = (int) trim(htmlentities($_GET['id_topic']));


  // Si l'une des variables est vide alors on redirige vers la page forum
if(empty($get_id_forum) || empty($get_id_topic)){
  header('Location: /forum');
  exit;
}

$req = $db->prepare("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y ') as date_c, U.prenom
        FROM sujet T
        LEFT JOIN professionnels U ON U.id = T.id_user
        WHERE t.id = ? AND t.id_forum = ?
        ORDER BY t.date_creation DESC");
$params = array($get_id_topic,
                $get_id_forum);
$req->execute($params);
$req = $req->fetch();





if(!isset($req['id'])){
       header('Location: /forum/' . $get_id_forum);
       exit;
   }


   $req_commentaire = $db->prepare("SELECT TC.*, DATE_FORMAT(TC.date_creation, 'Le %d/%m/%Y ') as date_c, U.specialite,U.prenom, U.nom
           FROM commentaire TC
           LEFT JOIN professionnels U ON U.id = TC.id_user
           WHERE id_sujet = ?
           ORDER BY date_creation DESC");
           $params2 = array($get_id_topic);
           $req_commentaire->execute($params2);

       $req_commentaire = $req_commentaire->fetchAll();

       if(!empty($_POST)){
        extract($_POST);
        $valid = true;

        // On se positionne sur le formulaire d'ajout d'un commentaire
        if (isset($_POST['ajout-commentaire'])){

            // On récupère le contenu du commentaire
            $text  = (String) trim($text);

            // On fait quelques vérifications
            if(empty($text)){
                $valid = false;
                $er_commentaire = "Il faut mettre un commentaire";
            }elseif(iconv_strlen($text, 'UTF-8') <= 3){
                $valid = false;
                $er_commentaire = "Il faut mettre plus de 10 caractères";
            }
            // Par précaution on sécurise notre commentaire
            $text = htmlentities($text);

            if($valid){

                $date_creation = date('Y-m-d H:i:s');

                // On insètre le commentaire dans la base de données
                $req_addcom=$db->prepare("INSERT INTO commentaire (id_sujet, id_user, contenu, date_creation) VALUES (?, ?, ?, ?)");
                $params3 = array($get_id_topic, $_SESSION['id'], $text, $date_creation);
                $req_addcom->execute($params3);
                header('Location: ' . $get_id_topic);
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
        <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css" >
        <link rel="stylesheet" href="../../style/styleForum.css">
        <title>topico</title>
    </head>

    <body>
      <?php
      require_once"../include/menu.php";
       ?>
  <div class="container">
          <div class="row">

              <div class="col-sm-0 col-md-0 col-lg-0"></div>
              <div class="col-sm-12 col-md-12 col-lg-12">
                  <h1 style="text-align: center">Topic : <?= $req['titre'] ?></h1>

                  <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px">
                      <h3>Contenu</h3>
                      <div style="border-top: 2px solid #eee; padding: 10px 0"><?= $req['contenu'] ?></div>
                      <img src="../<?=  $req['photo']; ?>"  class="photo">
                    
                      <div style="color: #CCC; font-size: 10px; text-align: right">
                          <?= $req['date_c'] ?>
                          par
                          <?= $req['prenom'] ?>
                      </div>
                  </div>



                  <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
                      <h3>Commentaires</h3>
                          <?php
                              foreach($req_commentaire as $rc){
                              ?>
                                  <div style="border-top: 2px solid #eee; padding: 10px 0"><?= $rc['contenu'] ?></div>
                                  <div style="color: #CCC; font-size: 10px; text-align: right">
                                      <?= $rc['date_c'] ?>
                                      par
                                      <?= $rc['prenom']." ".$rc['nom']  ?>
                                  </div>
                                  <div style="color: #CCC; font-size: 10px; text-align: right">
                                      Docteur en
                                      <?= $rc['specialite']  ?>
                                  </div>
                              <?php
                              }
                          ?>

                  </div>

                  <?php

                                         if(isset($_SESSION['id'])){
                                     ?>

                  <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
                      <h3>Ecrire un Commentaire</h3>
                      <?php
                            // S'il y a une erreur sur le nom alors on affiche
                            if (isset($er_commentaire)){
                            ?>
                                <div class="er-msg"><?= $er_commentaire ?></div>
                            <?php
                            }
                        ?>

                          <form method="post">
                              <div class="form-group">
                                   <textarea class="form-control" name="text" rows="3"></textarea>
                               </div>
                               <div class="form-group">
                                   <button class="btn btn-primary" type="submit" name="ajout-commentaire">Envoyer</button>
                               </div>
                           </form>

                  </div>

                  <?php
                       }
                   ?>
              </div>
          </div>
      </div>







            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
            <script src="../bootstrap/js/bootstrap.min.js" ></script>
    </body>
</html>
