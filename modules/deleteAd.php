<?php

$data = null;
$status = 404;
header('Content-type: application/json');

if (isset($_POST['success'])):
    $id = $_POST['id'];
    require_once 'konekcija.php';
    $upit3 = "select slika.src from slika where proizvod_id = $id";
    $slikaName = $konekcija->query($upit3)->fetch();
    $slikaname2 = substr($slikaName, 18);
    echo $slikaname2;
    unlink($_SERVER['DOCUMENT_ROOT'], 'uploads/pictures/'.$slikaname2);

    $obrisiSliku = "DELETE FROM `slika` WHERE proizvod_id = $id";
    $rezultat = $konekcija->query($obrisiSliku);

    if($rezultat):
        $obrisiProizvod = "DELETE FROM `proizvod` WHERE id = $id";
        $rezultat2 = $konekcija->query($obrisiProizvod);
        if($rezultat2):
            $data = "Successfully deleted product";
            $status = 200;
        endif;
    endif;
endif;
http_response_code($status);
echo json_encode($data);
?>