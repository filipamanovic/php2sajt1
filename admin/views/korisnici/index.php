<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Blank Page
                    <small>Subheading</small>
                </h1>
                <ol class="breadcrumb">
                    <li>
                        <i class="fa fa-dashboard"></i>  <a href="index.php">Dashboard</a>
                    </li>
                    <li class="active">
                        <a href="<?= $_SERVER['PHP_SELF'].'?page=insert' ?>" class="btn btn-primary" >Dodaj novi</a>
                    </li>
                </ol>
                <?php
                    if(isset($_SESSION['updateUspesno'])):
                    echo $_SESSION['updateUspesno'];
                    endif;
                    unset($_SESSION['updateUspesno']);
                 ?>
                <div class="col-md-8">
                    <div id="odgovor"></div>
                    <table class="table table-striped table-condensed table-bordered tabe-responsive">
                        <tr>
                            <th>ID</th>
                            <th>Ime</th>
                            <th>Prezime</th>
                            <th>Email</th>
                            <th>Kontakt</th>
                            <th>Grad</th>
                            <th>Aktivan</th>
                            <th>Uloga</th>
                            <th>Brisanje</th>
                            <th>Ažuriranje</th>
                        </tr>
                        <?php foreach($korisnici as $korisnik): ?>
                            <tr>
                                <td>
                                    <?= $korisnik->idKor ?>
                                </td>
                                <td>
                                    <?= $korisnik->ime ?>
                                </td>
                                <td>
                                    <?= $korisnik->prezime ?>
                                </td>
                                <td>
                                    <?= $korisnik->email ?>
                                </td>
                                <td>
                                    <?= $korisnik->kontakt ?>
                                </td>
                                <td>
                                    <?= $korisnik->grad ?>
                                </td>
                                <td>
                                    <?= $korisnik->aktivan ?>
                                </td>
                                <td>
                                    <?= $korisnik->uloga ?>
                                </td>
                                <td>
                                    <a href="javascript:;" class="deleteKor btn btn-danger" data-id="<?= $korisnik->idKor ?>">Delete</a>
                                </td>
                                <td>
                                    <a href="<?= $_SERVER['PHP_SELF'].'?page=azuriraj&idKor='.$korisnik->idKor?>" class="updateKor btn btn-success">Update</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>

                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li>
                                <a href="korisnici.php" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for($i = 0; $i < $linksNumber; $i++): ?>
                                <li><a href="korisnici.php?page=<?= $i+1?>"><?= $i+1 ?></a></li>
                            <?php endfor;?>

                            <li>
                                <a href="korisnici.php?page=<?= $linksNumber ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->
</div>
<!-- /#page-wrapper -->