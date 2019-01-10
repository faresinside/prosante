<?php

    require_once"../classes/Data_Base.class.php";
    require_once"../include/connexion.conf.inc.php";
  //  require_once"../include/valid_form_functions.inc.php";
  //  require_once"../include/fonctions.inc.php";
    $succes  = false;
    function register()
    {
        global $succes;
        $db = new Data_Base(SGBD,HOST,DBNAME,USER,PASSWORD);
        $pdo = $db->get_PDO();
        $query = $pdo->prepare("INSERT INTO professionnels VALUES (?,?,?,?,?,?,?,?,?,?,?)");
        $hashedPassWord=password_hash($_POST['passwd'],PASSWORD_BCRYPT);
        $params = array(
                          '0',
                          $_POST['nom'],
                          $_POST['prenom'],
                          $_POST['adresse'],
                          $_POST['telephone'],
                          $_POST['email'],
                          $hashedPassWord,
                          $_POST['diplome'],
                          $_POST['specialite'],
                          1,
                          0
                    );

       $query->execute($params);
        $succes = true;
    }

    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['adresse']) && !empty($_POST['telephone']) && !empty($_POST['email']) && !empty($_POST['passwd'])){

        register();

        if($succes){
          echo "<script>
              alert ('Record Inserted Successfully...!');
          </script>";
        }
        else{
            echo "ERROR";
        }
    }


            $boolen  = false;


            if($_SERVER["REQUEST_METHOD"] == "POST"){



                if(empty($_POST["email"])){
                    $eerr = "Email Required...!";
                    $boolen  = false;
                }elseif(!filter_var($_POST["email"],FILTER_VALIDATE_EMAIL)){
                    $eerr = "Invalid Email...!";
                    $boolen  = false;
                }else{
                    $email = validate_input($_POST["email"]);
                    $boolen  = true;
                }

                $lenght = strlenght($_POST["passwd"]);

                if(empty($_POST["passwd"])){
                    $perr = "Password Field Required...!";
                    $boolen  = false;
                }elseif($lenght){
                    $perr = $lenght;
                    $boolen  = false;
                }else{
                        $passwd = validate_input($_POST["passwd"]);
                    $boolen  = true;
                }




                if(empty($_POST["nom"]) || empty($_POST["prenom"])){
                    $fnerr = "First & Last Name Required...!";
                    $boolen  = false;
                }else{
                    $name = validate_input($_POST["nom"]);
                    $boolen  = true;
                }


                if(isset($_POST["ck1"])){
                    $boolen  = true;
                }else{
                    $boolen  = false;
                }
         }
            function strlenght($str){
                $ln = strlen($str);
                if($ln > 15){
                    return "Passwod should less than 15 charecter";
                }elseif($ln < 5 && $ln >= 1){
                    return "Password should greater then 3 charecter";
                }
                return;
            }
            function validate_input($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }


            if($boolen){



                function NewUser(){
                    $sql = "INSERT INTO regi (urname,email,passwd,fname,gender) VALUES ('$_POST[urname]','$_POST[email]','$_POST[passwd]','$_POST[fname]','$_POST[gender]')";

                    $query = mysqli_query($GLOBALS['con'],$sql);

                    if($query){
                        echo "<script>
                            alert ('Record Inserted Successfully...!');
                        </script>";
                    }
                }

                function SignUP(){
                    $sql = "SELECT * FROM regi WHERE urname = '$_POST[urname]' AND email = '$_POST[email]'";

                    $result = mysqli_query($GLOBALS['con'],$sql);

                    if(!$row = mysqli_fetch_array($result)){
                        NewUser();
                    }else{
                        echo "<script>
                            alert ('You Are Already Registered User......!');
                        </script>";
                    }
                }

                if(isset($_POST["submit"])){

                    SignUp();
                    mysqli_close($GLOBALS["con"]);
                    $boolen = false;
                }
            }



?>
