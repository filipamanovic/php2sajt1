<?php
    require_once "modules/konekcija.php";
    $proizvodId = "";
    if(isset($_GET['proizvodID'])):
        $proizvodId = $_GET['proizvodID'];
    endif;
//    echo $proizvodId;
    $upitGetKorid = "select korisnik_id from proizvod where id = $proizvodId";
    $koriznikId = $konekcija->query($upitGetKorid)->fetch();
    $koriznikId = $koriznikId->korisnik_id;

    $getKorisnik = "select * from korisnik where id = $koriznikId";
    $korisnik = $konekcija->query($getKorisnik)->fetch();

    $getProizvod = "select * from proizvod p inner join slika s on p.id = s.proizvod_id where p.id = $proizvodId";
    $proizvod = $konekcija->query($getProizvod)->fetch();


?>
<div class="container">

    <div class="row">

        <div class="col-lg-3 signup-form">
            <p class="hint-text">Info about the owner</p>
            <ul class="list-group">
                <li class="list-group-item list-group-item-info">Name: <?=$korisnik->ime.' '.$korisnik->prezime?></li>
                <li class="list-group-item list-group-item-info">Contact: <?=$korisnik->kontakt?></li>
                <li class="list-group-item list-group-item-info">City: <?=$korisnik->grad?></li>
            </ul>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9" style="margin-top: -25px;">

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="<?=$proizvod->src?>" alt="<?=$proizvod->alt?>">
                <div class="card-body">
                    <h3 class="card-title"><?=$proizvod->naziv?></h3>
                    <h4>&euro; <?=$proizvod->cena?></h4>
                    <p class="card-text"><?=$proizvod->opis?></p>
<!--                    <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>-->
<!--                    4.0 stars-->
                </div>
            </div>
            <!-- /.card -->

<!--            <div class="card card-outline-secondary my-4">-->
<!--                <div class="card-header">-->
<!--                    Product Reviews-->
<!--                </div>-->
<!--                <div class="card-body">-->
<!--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>-->
<!--                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>-->
<!--                    <hr>-->
<!--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>-->
<!--                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>-->
<!--                    <hr>-->
<!--                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>-->
<!--                    <small class="text-muted">Posted by Anonymous on 3/1/17</small>-->
<!--                    <hr>-->
<!--                    <a href="#" class="btn btn-success">Leave a Review</a>-->
<!--                </div>-->
<!--            </div>-->
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>