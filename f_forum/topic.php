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
        FROM topic T
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


   $req_commentaire = $db->prepare("SELECT TC.*, DATE_FORMAT(TC.date_creation, 'Le %d/%m/%Y ') as date_c, U.prenom, U.nom
           FROM topic_commentaire TC
           LEFT JOIN professionnels U ON U.id = TC.id_user
           WHERE id_topic = ?
           ORDER BY date_creation DESC");
           $params2 = array($get_id_topic);
           $req_commentaire->execute($params2);

       $req_commentaire = $req_commentaire->fetchAll();


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
                  <h1 style="text-align: center">Topic : <?= $req['titre'] ?></h1>

                  <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px">
                      <h3>Contenu</h3>
                      <div style="border-top: 2px solid #eee; padding: 10px 0"><?= $req['contenu'] ?></div>
                      <div style="color: #CCC; font-size: 10px; text-align: right">
                          <?= $req['date_c'] ?>
                          par
                          <?= $req['prenom'] ?>
                      </div>
                  </div>

                  <!-- On vient afficher les commentaire avec un foreach -->
                  <div style="background: white; box-shadow: 0 5px 15px rgba(0, 0, 0, .15); padding: 5px 10px; border-radius: 10px; margin-top: 20px">
                      <h3>Commentaires</h3>

                      <div class="table-responsive">
                          <table class="table table-striped">
                          <?php
                              foreach($req_commentaire as $rc){
                              ?>
                                  <tr>
                                      <td>
                                          <?= "De " . $rc['nom'] . " " . $rc['prenom'] ?></a>
                                      </td>
                                      <td>
                                          <?= $rc['text'] ?>
                                      </td>
                                      <td>
                                          <?= $rc['date_c'] ?>
                                      </td>
                                  </tr>
                              <?php
                              }
                          ?>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>







            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
            <script src="../bootstrap/js/bootstrap.min.js" ></script>
    </body>
</html>
