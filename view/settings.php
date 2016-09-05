<div class="row">
    <div class="col-md-8 col-md-offset-3">
        <?php if(!empty($info)):?>
            <div class="alert alert-success"><?php echo $info;?></div>
        <?php endif;?>
        <form class="form-horizontal" action="" method="post">
            <div class="form-group">
                <label for="background" class="col-md-3 control-label">Background color</label>
                <div class="col-md-7">
                    <input type="text" name="background" id="background" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="textcolor" class="col-md-3 control-label">Text color</label>
                <div class="col-md-7">
                    <input type="text" name="textcolor" id="textcolor" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label for="textsize" class="col-md-3 control-label">Text size</label>
                <div class="col-md-7">
                    <input type="text" name="textsize" id="textsize" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                    <button class="btn btn-success" name="settings_form">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>