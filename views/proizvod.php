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

    $getProizvod = "select *, p.id as proizvodId from proizvod p inner join slika s on p.id = s.proizvod_id where p.id = $proizvodId";
    $proizvod = $konekcija->query($getProizvod)->fetch();


    $getComm = "select * from komentar k inner join korisnik t on k.korisnik_id = t.id where proizvod_id = $proizvodId";
    $komentari = $konekcija->query($getComm)->fetchAll();


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
                <div class="card-footer">
                    <span class="float-left"><i class="fa fa-eye" aria-hidden="true"></i><?=" ".$proizvod->pregledano?></span>
                    <span class="float-right">Created at: <?php $time = $proizvod->datum; echo date('d-m-Y', $time)?></span>
                </div>
            </div>


            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>
                <div class="card-body">
                    <?php
                        if($komentari == "" || empty($komentari)):
                        echo "There are currently no product reviews.";
                        else:
                            foreach ($komentari as $item):
                    ?>
                    <p><?= $item->text ?></p>
                    <small class="text-muted">
                        Posted by <?=$item->ime.' '.$item->prezime?> on
                        <?php
                            $comVreme = $item->datum;
                            echo date('d-m-Y', $comVreme);
                        ?>
                    </small>
                    <hr>
                    <?php endforeach; endif; ?>
                    <hr>
                    <?php
                        if(isset($_SESSION['korisnik'])):
                    ?>
                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#exampleModal2">Leave a Review</a>
                    <?php
                        else:
                    ?>
                    You want to leave a comment? <a href="<?=$_SERVER['PHP_SELF'].'?page=login'?>"> Sing in!</a>
                    <?php
                        endif;
                    ?>
                </div>
            </div>


        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>

<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Your review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="modules/insertKomentar.php" method="post">
                    <p></p>
                    <div class="form-group">
                        <textarea rows="6" class="form-control" name="comm" required="required"> </textarea>
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="proizvodId" required="required" value="<?=$proizvod->proizvodId?>">
                        <input type="hidden" class="form-control" name="korisnikId" required="required" value="<?=$_SESSION['korisnik']->id?>">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="inComm">Send comment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>