<?php

 require_once"class.auth.php";
 require_once"../classes/Data_Base.class.php";
 require_once"../include/connexion.conf.inc.php";
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <title>Registration</title>

    <style>
        @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro');
    </style>

    <link rel="stylesheet" media="all" type="text/css" href="../Cs/bootstrap-3.3.7-dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" media="all" type="text/css" href="../style/Style.css" />



</head>

<body>


    <form id="register_form" method="post" enctype="multipart/form-data" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

        <div class="container">
            <div class="inner">

                <div class="title">
                    <h3>Registration Form</h3>
                </div>

                <div class="content">
                    <div class="txt">
                      <input type="text" id="txtemail" name="email" placeholder="Email Address">
                      <span id="c1" class="glyphicon glyphicon-envelope"></span>
                    </div>
                       <span id="span"><?php echo $urerr; ?></span>
                    <div class="txt1">
                        <input type="text" id="txtadresse" name="adresse" placeholder="Addresse">
                        <span id="c2" class="glyphicon glyphicon-home"></span>
                    </div>
                        <span id="span"><?php echo $eerr; ?></span>
                    <div class="txt1">
                        <input type="txt1" id="txtphone" name="telephone" placeholder="Telephone">
                        <span id="c3" class="glyphicon glyphicon-phone"></span>
                    </div>
                        <span id="span"><?php echo $perr; ?></span>
                    <div class="txt1">
                        <input type="password" id="txtcpass" name="passwd" placeholder="Password">
                        <span id="c4" class="glyphicon glyphicon-lock"></span>
                    </div>
                        <span id="span"><?php echo $cperr; ?></span>
                </div>

                 <div class="content2">
                    <input type="text" id="txtfname" name="nom" placeholder="Nom">
                    <input type="text" id="txtlname" name="prenom" placeholder="Prenom">
                </div>

                <div class="content2">
                   <input type="text" id="txtfname" name="specialite" placeholder="Specialite">
                   <input type="text" id="txtlname" name="diplome" placeholder="Diplome">
                </div>

                   <span id="span"><?php echo $fnerr; ?></span>

                <div class="ckbox">
                    <input type="checkbox" id="ckbox1" name="ck1">
                    <span>I Agree to Teams and Service</span>
                    <div id="register_status"></div>
                </div>

                <div class="btnsub">
                    <input type="submit" name="submit" id="btnsub" value="Submit">
                </div>

            </div>

        </div>
    </form>
<p id = "message"><?= $message?:'' ?></p>

 <script src="../js/ajax_inscription.js"></script>
    <script>
        $(document).ready(function() {
            var icon = "";
            var $txt1 = $("#txtuser");
            var $txt2 = $("#txtemail");
            var $txt3 = $("#txtpass");
            var $txt4 = $("#txtcpass");

            $("input").focus(function() {
                var id = document.activeElement.id;
                if (id == "txtuser") {
                    $("#c1").css("color", "green");
                    icon = "#c1";
                }
                if (id == "txtemail") {
                    $("#c2").css("color", "green");
                    icon = "#c2";
                }
                if (id == "txtpass") {
                    $("#c3").css("color", "green");
                    icon = "#c3";
                }
                if (id == "txtcpass") {
                    $("#c4").css("color", "green");
                    icon = "#c4";
                }
            });
            $("input").blur(function() {

                $(icon).css("color", "#b2b2b2");

                if ($txt1.val() != "")
                    $("#c1").css("color", "green");

                if ($txt2.val() != "")
                    $("#c2").css("color", "green");

                if ($txt3.val() != "")
                    $("#c3").css("color", "green");

                if ($txt4.val() != "")
                    $("#c4").css("color", "green");
            });
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" ></script>
    <script src="../bootstrap/js/bootstrap.min.js" ></script>
</body>
</html>
