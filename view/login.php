<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php if(!empty($error)):?>
            <div class="alert alert-danger"><?php echo $error;?></div>
        <?php endif;?>
        <form class="form-horizontal" action="/login.php" method="post">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" name="login" id="login">
            </div>
            <div class="form-group">
                <label for="passw">Password</label>
                <input type="password" class="form-control" name="passw" id="passw">
            </div>
            <div class="form-group">
                <button class="btn btn-success">Sign In</button>
            </div>
        </form>
    </div>
</div>