<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 6/20/2018
 * Time: 1:50 PM
 */


header("Content-type: application/json");
$code = 404;
$data = null;
if(isset($_POST['uspesno'])):
    require_once "../../../modules/konekcija.php";
    $idKor = $_POST['idKor'];
    $upit = "DELETE FROM korisnik WHERE id = '$idKor'";
    $rezultat = $konekcija->query($upit);
    if($rezultat == true):
        $code = 200;
        $data = "Korisik uspesno obrisan.";
        else:
        $code = 501;
        $data = "Greska u upitu.";
    endif;
endif;
http_response_code($code);
echo json_encode($data);

?>