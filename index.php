<?php
/**
 * Created by PhpStorm.
 * User: fica
 * Date: 2/2/2019
 * Time: 10:51 AM
 */
session_start();
$page = "";
if(isset($_GET['page'])):
    $page = $_GET['page'];
endif;

include "views/head.php";
include "views/nav.php";

switch ($page):
    case 'pocetna':
        include "views/artikli.php";
    break;
    case 'korisnik':
        if(isset($_SESSION['korisnik'])):
        include 'views/korisnik.php';
        else:
            include "views/artikli.php";
        endif;
    break;

    case  'autor':
        include 'views/autor.php';
    break;

    case 'register':
        include 'views/register.php';
    break;
    case 'proizvod':
        include 'views/proizvod.php';
        break;
    case 'login':
        include 'views/login.php';
        break;
    default:
        include "views/artikli.php";
    break;
endswitch;

include "views/footer.php";



