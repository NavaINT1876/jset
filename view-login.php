<div class=" col-sm-3 col-md-3 col-lg-4"></div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
    <?php
    session_start();
    if(isset($_SESSION['error'])){ ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php
        unset($_SESSION['error']);
    } ?>
    <form action="" method="post" class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
        <div class="form-group">
            <label for="inputLogin" class="sr-only">Login</label>
            <input name="login" type="text" id="inputLogin" class="form-control" placeholder="Login" required="" autofocus="">
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">Password</label>
            <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
        </div>
        <button name="submit" type="submit" class="btn btn-lg btn-primary btn-block">Sign in</button>
    </form>
</div>
<div class="col-sm-3 col-md-3 col-lg-4"></div>