<body>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="<?=$_SERVER['PHP_SELF']?>">PC & Equipment</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="<?=$_SERVER['PHP_SELF']?>">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <?php if(isset($_SESSION['korisnik'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$_SERVER['PHP_SELF'].'?page=korisnik'?>">My profile</a>
                </li>
                <?php endif; ?>
                <?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->uloga == "admin"): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/index.php">Admin panel</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$_SERVER['PHP_SELF'].'?page=autor'?>">Author
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php
                    if(isset($_SESSION['korisnik'])):
                ?>
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <?= $_SESSION['korisnik']->ime." ".$_SESSION['korisnik']->prezime  ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?=$_SERVER['PHP_SELF'].'?page=korisnik'?>" class="nav-link" style="color: #4e555b"><i class="fa fa-address-card"></i> My profile</a>
                        </li>
                        <li>
                            <a href="modules/logout.php" class="nav-link" style="color: #4e555b"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$_SERVER['PHP_SELF'].'?page=login'?>">
                        <span class="fa fa-user" aria-hidden="true"></span> Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?=$_SERVER['PHP_SELF'].'?page=register'?>">
                        <span class="fa fa-sign-in" aria-hidden="true"></span> Register
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>


