<?php

session_start();
if(isset($_POST['login'])):
    $nizGreske = [];
    $email = $_POST['emailLog'];
    $pass = $_POST['passLog'];

    $regPassord = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/";

    if(!preg_match($regPassord, $pass)):
        array_push($nizGreske, "Pssword incorect!");
    endif;

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)):
        array_push($nizGreske, "Email incorect!");
    endif;

    if(count($nizGreske) > 0):
        $_SESSION['greske'] = $nizGreske;
        header("Location: ../index.php?page=login");
    else:
        require_once "konekcija.php";
        $upit = "SELECT *,k.id FROM korisnik k INNER JOIN uloga u ON k.uloga_id = u.id WHERE email = :email and  
                password = :pass and aktivan = 1";
        $prepare = $konekcija->prepare($upit);
        $prepare->bindParam(":email", $email);
        $password = md5($pass);
        $prepare->bindParam(":pass", $password);
        try{
            $prepare->execute();
            $korisnik = $prepare->fetch();
            if($korisnik):
                $_SESSION['korisnik'] = $korisnik;
                header("Location: ../index.php?page=pocetna");
            else:
                $greske = ["Pogresni podaci ili niste aktivirali nalog."];
                $_SESSION['greske'] = $greske;
                header("Location: ../index.php?page=login");
            endif;

        }catch (PDOException $e){
            echo $e->getMessage();
        }
    endif;

endif;