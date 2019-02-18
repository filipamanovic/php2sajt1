<?php
session_start();
if(isset($_POST['addProduct'])):
    $nizGreske = [];
    $name = $_POST['addName'];
    $desc = $_POST['addDesc'];
    $price = $_POST['addPrice'];
    $cat = $_POST['addCat'];
    $manu = $_POST['addManu'];
    $slika = $_FILES['addSlika'];
    $slikaName = $slika['name'];
    $slikaTmp = $slika['tmp_name'];
    $slikaType = $slika['type'];
    $slikaSize = $slika['size'];

    $regPrice = "/^[1-9][\d]{0,3}$/";
    if(!preg_match($regPrice, $price)):
        array_push($nizGreske, "Price is out of range");
    endif;


    $nizTypeSlika = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];
    if(!in_array($slikaType, $nizTypeSlika)):
        array_push($nizGreske, "Not allowed image format");
    endif;

    if($slikaSize > 5000000):
        array_push($nizGreske, "Not allowed image size.(Max 5MB)");
    endif;

    if (count($nizGreske) == 0):
        $slikaNaziv = $slikaName.time();
        $novaPutanja = "../uploads/pictures/".$slikaNaziv;
        $putanjaBaza = "uploads/pictures/".$slikaNaziv;
        if (move_uploaded_file($slikaTmp, $novaPutanja)):
            require_once 'konekcija.php';
            $upitProizvod = "INSERT INTO `proizvod`(`id`, `naziv`, `opis`, `cena`, `datum`, `korisnik_id`, `kategorija_id`, `proizvodjac_id`) 
            VALUES ('', :naziv, :opis, :cena, :datum, :korisnik, :kategorija, :proizvodjac)";
            $prepare = $konekcija->prepare($upitProizvod);
            $prepare->bindParam(':naziv', $name);
            $prepare->bindParam(':opis', $desc);
            $prepare->bindParam(':cena', $price);
            $datum = time();
            $prepare->bindParam(':datum', $datum);
            $korisnik = $_SESSION['korisnik']->id;
            $prepare->bindParam(':korisnik', $korisnik);
            $prepare->bindParam(':kategorija', $cat);
            $prepare->bindParam(':proizvodjac', $manu);
            $rezultat = $prepare->execute();

            if ($rezultat):
                $proizvodId = $konekcija->lastInsertId();
                $upitSlika = "INSERT INTO `slika`(`id`, `src`, `alt`, `proizvod_id`)
                              VALUES ( '', ':src', ':alt', $proizvodId)";
                $prepareSlika = $konekcija->prepare($upitSlika);
                $prepareSlika->bindParam(':src', $putanjaBaza);
                $prepareSlika->bindParam(':alt', $slikaName);
//                $prepareSlika->bindParam(':proizvod', $proizvodId);
                $rezultat2 = $prepareSlika->execute();

                if($rezultat2):
                    $slikaID = $konekcija->lastInsertId();
                    $upitUpdate = "UPDATE `slika` SET `src`= :src, `alt`= :alt WHERE id = $slikaID";
                    $prepareUpdate = $konekcija->prepare($upitUpdate);
                    $prepareUpdate->bindParam(':src', $putanjaBaza);
                    $prepareUpdate->bindParam(':alt', $slikaName);
                    $prepareUpdate->execute();
                    $_SESSION['addSuccess'] = ['Successfully added product!'];
                    header('Location: ../index.php?page=korisnik');
                endif;
            endif;
        endif;
        else:
        $_SESSION['addGreske'] = $nizGreske;
        header('Location: ../index.php?page=korisnik');
    endif;

endif;

?>