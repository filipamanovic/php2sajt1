<?php

$data = null;
$status = 404;
header('Content-type: application/json');
if(isset($_POST['success'])):
    $proizvodId = $_POST['proizvodId'];
    require_once 'konekcija.php';
    $upitGetProizvod = "select * from proizvod where proizvod.id = $proizvodId";
    $rezultat = $konekcija->query($upitGetProizvod)->fetch();
    $data = $rezultat;
    $status = 200;
endif;
http_response_code($status);
echo json_encode($data);

