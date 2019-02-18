<?php

session_start();
if(isset($_POST['upProduct'])):
    require_once 'konekcija.php';
    $productId = $_POST['proizvodId'];
    $name = $_POST['upName'];
    $desc = $_POST['upDesc'];
    $price = $_POST['upPrice'];
    $datum = time();
    $upit = "UPDATE proizvod p SET p.naziv= '$name', p.opis = '$desc', p.cena = '$price', p.datum = '$datum'
     WHERE p.id = $productId";
    $rezultat = $konekcija->query($upit);
    if($rezultat):
        $_SESSION['addSuccess'] = ['Successfully updated product!'];
        header('Location: ../index.php?page=korisnik');
    else:
        $_SESSION['addGreske'] = ["Update product error!"];
        header('Location: ../index.php?page=korisnik');
    endif;


endif;