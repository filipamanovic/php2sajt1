<!-- Page Content -->
<?php
require_once 'modules/konekcija.php';
$upitKategorije = "select * from kategorija";
$rezKategorije = $konekcija->query($upitKategorije)->fetchAll();

$upitProizvodjaci = "select * from proizvodjac";
$rezProizvodjaci = $konekcija->query($upitProizvodjaci)->fetchAll();
?>
<div class="container">

    <div class="row">


        <div class="col-lg-3 signup-form">
            <?php
                if (isset($_SESSION['addGreske'])):
                    $greska = $_SESSION['addGreske'];
                    foreach ($greska as $item):
            ?>
                    <p class="hint-text" style="color: #b21f2d"><?=$item?></p>
            <?php
                    endforeach;
                unset($_SESSION['addGreske']);
                endif;
            ?>
            <?php
                if (isset($_SESSION['addSuccess'])):
                    $addSuccess = $_SESSION['addSuccess'];
                    foreach ($addSuccess as $success):
            ?>
                    <p class="hint-text"><?=$success?></p>
            <?php
                    endforeach;
                unset($_SESSION['addSuccess']);
                endif;
            ?>

            <form action="modules/addProduct.php" method="post" enctype="multipart/form-data">
                <h3>Add product</h3>
                <p></p>
                <div class="form-group">
                    <label class="formaUnos">Product name:</label>
                    <input type="text" class="form-control" name="addName" required="required">
                </div>
                <div class="form-group">
                    <label class="formaUnos">Product description:</label>
                    <textarea rows="6" class="form-control" name="addDesc" required="required"> </textarea>
                </div>
                <div class="form-group">
                    <label class="formaUnos">Product price in &euro;:</label>
                    <input type="text" class="form-control" name="addPrice" required="required">
                </div>
                <div class="form-group">
                    <label class="formaUnos">Product picture:</label>
                    <input type="file" class="form-control" name="addSlika" required="required">
                </div>
                <div class="form-group">
                    <label class="formaUnos">Product category:</label>
                    <select class="form-control" name="addCat">
                <?php
                    foreach ($rezKategorije as $item):

                ?>
                    <option value="<?=$item->id?>"><?=$item->naziv?></option>
                <?php
                    endforeach;
                ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="formaUnos">Product manufacturer:</label>
                    <select class="form-control" name="addManu">
                        <?php
                        foreach ($rezProizvodjaci as $item):

                            ?>
                            <option value="<?=$item->id?>"><?=$item->naziv?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-lg btn-block" name="addProduct">Add product</button>
                </div>
            </form>

        </div>
        <!-- /.col-lg-3 -->
<?php
    $korID = $_SESSION['korisnik']->id;
    $upitProizvodi = "SELECT *, p.id as proizvodID FROM `proizvod` p INNER JOIN slika s on p.id = s.proizvod_id where p.korisnik_id = $korID";
    $rezProizvodi = $konekcija->query($upitProizvodi)->fetchAll();
?>

        <div class="col-lg-9">
            <h4>My products:</h4>
            <?php
                if(count($rezProizvodi) == 0):
            ?>
            <h5>Currently you do not have any advertisement.</h5>
            <?php
                else:
            ?>
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
                            <button class="btn btn-outline-warning updateAd" data-id="<?=$item->proizvodID?>" data-toggle="modal" data-target="#exampleModal">Update</button>
                            <a class="btn btn-outline-danger deleteAd" href="<?=$_SERVER['PHP_SELF'].'?page=korisnik'?>" data-id="<?=$item->proizvodID?>">Delete</a>
<!--                            <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>-->
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
            <!-- /.row -->
             <?php endif; ?>

        </div>
        <!-- /.col-lg-9 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="modules/upProduct.php" method="post">
                    <p></p>
                    <div class="form-group">
                        <label class="formaUnos">Product name:</label>
                        <input type="text" class="form-control" name="upName" id="upName" required="required">
                    </div>
                    <div class="form-group">
                        <label class="formaUnos">Product description:</label>
                        <textarea rows="6" class="form-control" name="upDesc" id="upDesc" required="required"> </textarea>
                    </div>
                    <div class="form-group">
                        <label class="formaUnos">Product price in &euro;:</label>
                        <input type="text" class="form-control" name="upPrice" id="upPrice" required="required">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="proizvodId" id="upProizvod" required="required">
                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success" name="upProduct">Update product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>