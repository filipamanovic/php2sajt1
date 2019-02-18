<div class="signup-form">
    <div id="odgovorBaze" class="hint-text"></div>
    <form action="modules/login.php" method="post">
        <h2>Login</h2>
        <?php
            if(isset($_SESSION['greske'])):
                $greske = $_SESSION['greske'];
                foreach($greske as $item):
        ?>
        <p class="hint-text"><?=$item?></p>
        <?php endforeach; unset($_SESSION['greske']); endif; ?>
        <div class="form-group">
            <input type="email" class="form-control" name="emailLog" placeholder="Email" required="required">
            <label class="formaGreska" id="emailReg">Not allowed email format</label>
        </div>
        <div class="form-group">
            <input type="password" class="form-control" name="passLog" placeholder="Password" required="required">
            <label class="formaGreska" id="passReg">Requires min seven characters with one: lowercase letter, capital letter, number and special character</label>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block" name="login">Login now</button>
        </div>
    </form>
    <div class="text-center">You don't have account? Register here: <a href="<?=$_SERVER['PHP_SELF'].'?page=register'?>" style="color: #138496; text-decoration: none">Register</a></div>
</div>