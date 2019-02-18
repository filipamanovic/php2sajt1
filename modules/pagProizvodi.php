<?php
session_start();
unset($_SESSION['sortPag']);
if(isset($_GET['strana'])):
    require_once "konekcija.php";
    $brStrane = $_GET['strana'];
    $limit_levo = ($brStrane-1)*6;
    $limit_desno = 6;
    $upit = "SELECT *, p.id as proizvodID FROM `proizvod` p INNER JOIN slika s on p.id = s.proizvod_id 
              limit $limit_levo, $limit_desno";
    $prepare = $konekcija->prepare($upit);
    $prepare->execute();
    $rezultat = $prepare->fetchAll();
    $_SESSION['sortPag'] = $rezultat;
    header("Location: ../index.php?page=artikli");
else:
    header("Location: ../index.php?page=artikli");
endif;