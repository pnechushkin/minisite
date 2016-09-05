<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h1>Feedback</h1>
        <?php if(!empty($info)):?>
        <div class="alert alert-success"><?php echo $info;?></div>
        <?php endif;?>
        <form class="form-horizontal" action="/?page=feedback" method="post">
            <?php if(!isGuest() && !empty($_SESSION['user'])):?>
            <input type="hidden" name="username" value="<?php echo $_SESSION['user'];?>"/>
            <?php else:?>
            <div class="form-group">
                <label for="username">User name</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo post('username', '');?>">
                <div class="has-error"><?php echo !empty($username_error) ? $username_error : '';?></div>
            </div>
            <?php endif;?>
            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" class="form-control" name="subject" id="subject" value="<?php echo post('subject', '');?>">
                <div class="has-error"><?php echo !empty($subject_error) ? $subject_error : '';?></div>
            </div>
            <div class="form-group">
                <label for="message">Message</label>
                <textarea name="message" id="message" class="form-control"><?php echo post('message', '');?></textarea>
                <div class="has-error"><?php echo !empty($message_error) ? $message_error : '';?></div>
            </div>
            <div class="form-group">
                <button class="btn btn-success" name="feedback_form">Sign In</button>
            </div>
        </form>
    </div>
</div>