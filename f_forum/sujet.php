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
    $get_id = (int) trim(htmlentities($_GET['id'])); // On récupère l'id de la catégorie


    if(empty($get_id)){ // On vérifie qu'on a bien un id sinon on redirige vers la page forum
        header('Location: /forum');
        exit;
    }
   $req = $db->prepare("SELECT t.*, DATE_FORMAT(t.date_creation, 'Le %d/%m/%Y à ') as date_c, U.prenom
        FROM topic T
        LEFT JOIN professionnels U ON U.id = T.id_user
        WHERE t.id_forum = ?
        ORDER BY t.date_creation DESC");
   $params = array($get_id);
   $req->execute($params);
   $req = $req->fetchAll();

    $req3 = $db->query("SELECT titre FROM forum WHERE id = $get_id");
    $req3 = $req3->fetch();



?>
<!doctype html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
        <link rel="stylesheet" href="../style/styleForum.css">
        <title>Mon sujet</title>
    </head>

    <body>
      <?php
      require_once"../include/menu.php";
       ?>
  <div class="container">
            <div class="row">

                <div class="col-sm-0 col-md-0 col-lg-0"></div>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <h1 style="text-align: center"> <?= $req3[0]?></h1>



                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Date</th>
                                <th>Par </th>
                            </tr>
                        <?php
                            foreach($req as $r){  // Ici on va afficher tous nos enregistrements trouvés
                            ?>
                                <tr>
                                    <td>
                                        <?= $r['id'] ?>
                                    </td>
                                    <td>
                                        <!-- On met un lien pour afficher le topic en entier -->
                                        <a href="<?= $get_id?>/<?= $r['id']?>"><?= $r['titre'] ?></a>
                                    </td>
                                    <td>
                                        <?= $r['date_c'] ?>
                                    </td>
                                    <td>
                                        <?= $r['prenom'] ?>
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
