<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 6/20/2018
 * Time: 3:37 PM
 */
session_start();
if(isset($_POST)):
    require_once "../../../modules/konekcija.php";
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $pass = $_POST['pass'];
    $email = $_POST['email'];
    $kontakt = $_POST['kontakt'];
    $grad = $_POST['grad'];
    $aktivan = (isset($_POST['aktivan']))? 1 : 0;
    $uloga = $_POST['uloga'];

    if(empty($ime) || empty($prezime) || empty($pass) || empty($email) || empty($kontakt) || empty($grad)):
        $_SESSION['greskaInsert'] = "Nisu uneti svi podaci";
        header("Location: ../../korisnici.php?page=insert");
        else:
            $pass = md5($pass);
            $vreme = time();
            $token = md5(time().rand().$email);
            $upit = "INSERT INTO korisnik VALUES ('', '$ime', '$prezime', '$email', 
                      '$pass', '$kontakt', '$grad', '$vreme', '$aktivan', '$token', '$uloga')";
            $rezultat = $konekcija->query($upit);
            if($rezultat):
                $_SESSION['insertUspesan'] = "Uspesno ste uneli korisnika.";
                header("Location: ../../korisnici.php?page=insert");
                else:
                    $_SESSION['greskaInsert'] = "Greska sa upitom";
                    header("Location: ../../korisnici.php?page=insert");
            endif;
    endif;

endif;


?>