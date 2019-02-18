<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 6/20/2018
 * Time: 8:28 PM
 */

header("Content-type: application/json");
$code = 404;
$data = null;
if(isset($_POST['uspesno2'])):
    $idKor = $_POST['idKor'];
    require_once "../../../modules/konekcija.php";
    $upit = "SELECT * FROM korisnik WHERE id = '$idKor'";
    $result = $konekcija->query($upit)->fetch();
    if($result):
        $code = 200;
        $data = $result;
        else:
        $code = 505;
        $data = "Greska u upitu.";
    endif;

endif;

http_response_code($code);
echo json_encode($data);

?>