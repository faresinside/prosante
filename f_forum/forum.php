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



  $req = $db->query("SELECT * FROM forum");
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
      <?php
      require_once"../include/menu.php";
       ?>
  <div class="container">
      <div class="row">

          <div class="col-sm-0 col-md-0 col-lg-0"></div>
          <div class="col-sm-12 col-md-12 col-lg-12">
              <h1 style="text-align: center">Forum</h1>
              <a href="creer-mon-topic" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Creer un sujet</a>
              <div class="table-responsive" style="margin-top: 10px">
                  <table class="table table-striped">
                      <tr>
                          <th>ID</th>
                          <th>Titre</th>
                          <th>nb sujets</th>
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
                              <td>
                                  <?= $r['nbSujets'] ?>
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






            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
            <script src="../bootstrap/js/bootstrap.min.js" ></script>
            <script>
    $(document).ready(function(){
        $('#search').keyup(function(){

            $('#result-search').html('');
            var titre = $(this).val();
            console.log(utilisateur);

            if(titre != ""){
                $.ajax({
                    type: 'GET',

                });
            }
        });
    });
</script>
    </body>
</html>
