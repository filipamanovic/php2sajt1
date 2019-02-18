<?php
/**
 * Created by PhpStorm.
 * User: win7
 * Date: 6/16/2018
 * Time: 12:48 PM
 */


session_start();
unset($_SESSION['korisnik']);
header("Location: ../index.php?page=pocetna");

?>