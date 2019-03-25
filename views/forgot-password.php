<?php include_view('common/header.php'); ?>

    <form class="form-signin" action="/auth/forgot-password" method="post">
        <div class="text-center mb-4">          
            <h1 class="h3 mb-3 font-weight-normal">Enter Email you used to create your account</h1>
            <?php if($error = app()->get('request')->has('message')) : ?>
                <p class="<?php echo app()->get('request')->get('error')? 'error': 'success'?>"><?php echo app()->get('request')->get('message'); ?></p>
            <?php endif ?>
        </div>
        <div class="form-label-group">
            <input type="email" id="inputEmail" class="form-control" name="email" placeholder="Email address" required="" autofocus="">
            <label for="inputEmail">Email address</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Request Reset</button>
    </form>
<?php include_view('/common/header.php') ?>