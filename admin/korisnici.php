<?php

require_once "../modules/konekcija.php";
require_once 'views/head.php';
require_once 'views/nav.php';

$page = isset($_GET['page']) ? $_GET['page'] : null;

switch ($page) {
    case 'insert':
        $upit = "SELECT * FROM uloga;";
        $uloga = $konekcija->query($upit)->fetchAll();
        require_once 'views/korisnici/insert.php';
        break;
    case 'azuriraj':
        $upit = "SELECT * FROM uloga;";
        $uloga = $konekcija->query($upit)->fetchAll();
        require_once 'views/korisnici/update.php';
        break;
    default:
        $upit = "SELECT COUNT(*) as br FROM korisnik";
        $obj = $konekcija->query($upit)->fetch();
        $perPage = 5;
        $linksNumber = ceil($obj->br/$perPage);
        $page = isset($_GET['page']) ? $_GET['page'] : 1;

        $from = $perPage * ($page - 1);
        $upit = "SELECT *,k.id as idKor FROM korisnik k INNER JOIN uloga u ON k.uloga_id = u.id 
                LIMIT $from, $perPage;";
        $korisnici = $konekcija->query($upit)->fetchAll();
        require_once 'views/korisnici/index.php';
        break;
}



require_once 'views/footer.php';



?>