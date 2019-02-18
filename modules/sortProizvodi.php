<?php
//
$data = null;
$status = 404;
header('Content-type: application/json');
session_start();
unset($_SESSION['sortPro']);
if(isset($_POST['successSort'])):
    require_once "konekcija.php";
    $kat = $_POST['kat'];
    $pro = $_POST['pro'];
    $min = $_POST['min'];
    $max = $_POST['max'];
    if($min == 'null'):
        $min = 0;
    endif;
    if($max == 'null'):
        $max = 99999;
    endif;
    $upit = "SELECT *, p.id as proizvodID FROM `proizvod` p INNER JOIN slika s on p.id = s.proizvod_id where 
p.proizvodjac_id = coalesce ($pro, p.proizvodjac_id) and p.kategorija_id = coalesce ($kat, p.kategorija_id)
and p.cena between $min and $max";
//    $rezultat = $konekcija->query($upit)->fetchAll();
    $prepare = $konekcija->prepare($upit);
    $prepare->execute();
    $brojProizvoda = $prepare->rowCount();
    $rezultat = $prepare->fetchAll();
    $niz = [$rezultat, $brojProizvoda];
    $_SESSION['sortPro'] = $niz;
    $status = 200;
//    $data = $rezultat;
endif;
//
echo json_encode($data);
http_response_code($status);

