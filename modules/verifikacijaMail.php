<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 6/15/2018
 * Time: 10:28 PM
 */
session_start();
if(isset($_GET['abc'])):
    $token = $_GET['abc'];
    require_once "konekcija.php";
    $upit = "UPDATE korisnik SET aktivan = 1 WHERE token = :token";
    $prepare = $konekcija->prepare($upit);
    $prepare->bindParam(":token", $token);
    try{
        $prepare->execute();
        if($prepare->rowCount()):
            $upit2 = "SELECT *,k.id FROM korisnik k INNER JOIN uloga u ON k.uloga_id = u.id 
                       WHERE token = :token";
            $prepare2 = $konekcija->prepare($upit2);
            $prepare2->bindParam(":token",$token);
            $prepare2->execute();
            $korisnik = $prepare2->fetch();
            $_SESSION['korisnik'] = $korisnik;
            header("Location: ../index.php?page=pocetna");
        else:
            echo "Vas nalog je vec aktiviran.";
            header("Location:../index.php?page=pocetna");
        endif;

    }catch (PDOException $e){
        echo $e->getMessage();
    }
else:
    header("Location: ../index.php?paga=pocetna");
endif;
?>