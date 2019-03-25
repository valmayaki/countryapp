<?php include_view('common/header.php'); ?>
    <form class="form-signin" action="/auth/reset-password" method="post">
        <div class="text-center mb-4">          
            <h1 class="h3 mb-3 font-weight-normal">Enter New Password</h1>
            <?php if($error = app()->get('request')->has('message')) : ?>
                <p class="<?php echo app()->get('request')->get('error')? 'error': 'success'?>"><?php echo app()->get('request')->get('message'); ?></p>
            <?php endif ?>
        </div>
        <input type="hidden" name="token" value="<?php echo $token;?>">
        <div class="form-label-group">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
            <label for="inputPassword">Password</label>
        </div>
        <div class="form-label-group">
            <input type="password" id="inputPassword" name="password_confirmation" class="form-control" placeholder="Password" required="">
            <label for="inputPassword">Retype Password</label>
        </div>
        <p><a href="/register" class="float-left">Register</a> <a class="float-right" href="/">Login</a></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Reset Password</button>
    </form>
<?php include_view('/common/header.php') ?>