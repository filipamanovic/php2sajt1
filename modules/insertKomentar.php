<?php

if(isset($_POST['inComm'])):
    $comm = $_POST['comm'];
    $user = $_POST['korisnikId'];
    $pro = $_POST['proizvodId'];
    $vreme = time();

    require_once "konekcija.php";
    $upit = "INSERT INTO `komentar`(`id`, `text`, `datum`, `proizvod_id`, `korisnik_id`) 
              VALUES ('', '$comm', '$vreme', '$pro', '$user')";
    $konekcija->query($upit);
    header('Location: ../index.php?page=proizvod&&proizvodID='.$pro);

endif;



?>