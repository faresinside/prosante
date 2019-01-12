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

    // On récupère les informations de l'utilisateur connecté
    //  $afficher_profil = $db->query("SELECT * FROM professionnels WHERE id ='".$_SESSION['id']."'");
    //$afficher_profil = $afficher_profil->fetch();

    $req = $db->query("SELECT * FROM forum ORDER BY ordre");

   $req = $req->fetchAll();

?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
        <link rel="stylesheet" href="../style/styleForum.css">
        <title>Mon profil</title>
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
              <h1 style="text-align: center">Forum</h1>

              <div class="table-responsive" style="margin-top: 10px">
                  <table class="table table-striped">
                      <tr>
                          <th>ID</th>
                          <th>Titre</th>
                      </tr>
                  <?php
                      foreach($req as $r){
                      ?>
                          <tr>
                              <td>
                                  <?= $r['id'] ?>
                              </td>
                              <td>
                                  <a href="<?= $r['id'] ?>"><?= $r['titre'] ?></a>
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







            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
            <script src="../bootstrap/js/bootstrap.min.js" ></script>
    </body>
</html>
