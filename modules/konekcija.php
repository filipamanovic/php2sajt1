<?php

include "config.php";

try{
    $konekcija = new PDO("mysql:server=".SERVER.";dbname=".DATABASE.";charset=utf8",USERNAME,PASSWORD);
    $konekcija->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $konekcija->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
//    echo "Uspesna konekcija.";

}catch (PDOException $e){
    echo "Greska u konekciji sa bazom: ".$e->getMessage();
}
?>