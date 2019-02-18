<!-- Page Content -->
<?php
    require_once 'modules/konekcija.php';
    $upitKategorije = "select * from kategorija";
    $rezKategorije = $konekcija->query($upitKategorije)->fetchAll();
    $upitProizvodjaci = "select * from proizvodjac";
    $rezProizvodjaci = $konekcija->query($upitProizvodjaci);
?>
<div class="container">

    <div class="row">

        <div class="col-lg-3">

            <h3 class="my-4">Sort products:</h3>
            <p class="hint-text">Choose category:</p>
            <select class="form-control" id="selectKat">
                <option value="null">All..</option>
                <?php
                    foreach ($rezKategorije as $item):
                ?>
                        <option value="<?=$item->id?>"><?=$item->naziv?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <hr>
            <p class="hint-text">Choose manufacturer:</p>
            <select class="form-control" id="selectPro">
                <option value="null">All..</option>
                <?php
                foreach ($rezProizvodjaci as $item):
                    ?>
                    <option value="<?=$item->id?>"><?=$item->naziv?></option>
                <?php
                endforeach;
                ?>
            </select>
            <hr>
            <p class="hint-text">Choose price range:</p>
            <div class="row">
                <div class="col-6">
                    <input type="number" class="form-control" id="sortMin" placeholder="min" required="required">
                </div>
                <div class="col-6">
                    <input type="number" class="form-control" id="sortMax" placeholder="max" required="required">
                </div>
            </div>
            <p></p>
            <p></p>
            <button class="btn btn-outline-info" id="btnSort">Search</button>
        </div>
        <!-- /.col-lg-3 -->

        <?php
        $rezProizvodi = "";
        $brojProizvoda = "";
        if(isset($_SESSION['sortPro'])):
                $rezProizvodi = $_SESSION['sortPro'][0];
                $brojProizvoda = $_SESSION['sortPro'][1];
                unset($_SESSION['sortPro']);
            elseif (isset($_SESSION['sortPag'])):
                $rezProizvodi = $_SESSION['sortPag'];
                $upitProizvodi2 = "select * from proizvod";
                $prepare2 = $konekcija->prepare($upitProizvodi2);
                $prepare2->execute();
                $brojProizvoda = $prepare2->rowCount();
                unset($_SESSION['sortPag']);
            else:
                $upitProizvodi2 = "select * from proizvod";
                $prepare2 = $konekcija->prepare($upitProizvodi2);
                $prepare2->execute();
                $brojProizvoda = $prepare2->rowCount();
                $upitProizvodi = "SELECT *, p.id as proizvodID FROM `proizvod` p INNER JOIN slika s on p.id = s.proizvod_id limit 0, 6";
                $prepare = $konekcija->prepare($upitProizvodi);
                $prepare->execute();
//                $brojProizvoda =  $prepare->rowCount();
                $rezProizvodi = $prepare->fetchAll();
        endif;
        $brojStrana = ceil($brojProizvoda / 6);
        ?>


        <?php
        if($rezProizvodi == false):
            echo "<h4>Currently there is no item for your search</h4>";
        else:
        ?>
        <div class="col-lg-9" style="margin-top: -24px;">

                <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php
                        $brojac = 0;
                        foreach ($rezProizvodi as $item):
                            if ($brojac == 0):
                                ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?=$brojac?>" class="active"></li>
                            <?php else: ?>
                                <li data-target="#carouselExampleIndicators" data-slide-to="<?=$brojac?>"></li>
                            <?php
                            endif;
                            $brojac ++;
                        endforeach;
                        ?>
                    </ol>
                    <div class="carousel-inner" role="listbox">
                        <?php
                        $brojac2 = 0;
                        foreach ($rezProizvodi as $item):
                            if($brojac2 == 0):
                                ?>
                                <div class="carousel-item active">
                                    <img class="d-block img-fluid" src="<?=$item->src?>" alt="First slide" style="height: 32vw; width: 100%;">
                                </div>
                            <?php else: ?>
                                <div class="carousel-item">
                                    <img class="img-fluid" src="<?=$item->src?>" alt="Second slide" style="height: 32vw; width: 100%;">
                                </div>
                            <?php endif; $brojac2++; endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>

                <div class="row">
                    <?php
                    foreach ($rezProizvodi as $item):
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <a href="<?=$_SERVER['PHP_SELF'].'?page=proizvod&&proizvodID='.$item->proizvodID?>">
                                    <img class="card-img-top" style="height: 160px;" src="<?=$item->src?>" alt="<?=$item->alt?>">
                                </a>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #138496;">
                                        <a href="<?=$_SERVER['PHP_SELF'].'?page=proizvod&&proizvodID='.$item->proizvodID?>">
                                            <?=$item->naziv?>
                                        </a>
                                    </h4>
                                    <h5>&euro;<?=$item->cena?></h5>
                                    <p class="card-text"><?=$item->opis?></p>
                                </div>
                                <div class="card-footer">
<!--                                    <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>


                </div>
                <!-- /.row -->
                <nav aria-label="Page navigation example" style="margin: 0px auto">
                    <ul class="pagination">
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                                <span class="sr-only">Previous</span>
                            </a>
                        </li>
                        <?php
                            for($i=1; $i<=$brojStrana; $i++):
                        ?>
                            <li class="page-item"><a class="page-link" href="modules/pagProizvodi.php?strana=<?=$i?>"><?=$i?></a></li>
                        <?php endfor; ?>
                        <li class="page-item">
                            <a class="page-link" href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                                <span class="sr-only">Next</span>
                            </a>
                        </li>
                    </ul>
                </nav>

        </div>
        <!-- /.col-lg-9 -->
        <?php endif; ?>
    </div>
    <!-- /.row -->
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->