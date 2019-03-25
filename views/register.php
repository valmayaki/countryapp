<?php include_view('common/header.php'); ?>
    <form class="form-signin" action="/auth/register" method="post">
        <div class="text-center mb-4">          
            <h1 class="h3 mb-3 font-weight-normal">WELCOME</h1>
            <?php if($error = app()->get('request')->has('message')) : ?>
                <p class="<?php echo app()->get('request')->get('error')? 'error': 'success'?>"><?php echo app()->get('request')->get('message'); ?></p>
            <?php endif ?>
        </div>

        <div class="form-label-group">
            <input type="text" id="inputEmail" name="firstname" class="form-control" placeholder="First name" required="" autofocus="">
            <label for="inputEmail">First name</label>
        </div>
        <div class="form-label-group">
            <input type="text" id="inputEmail" name="lastname" class="form-control" placeholder="Last name" required="" autofocus="">
            <label for="inputEmail">Last name</label>
        </div>
        <div class="form-label-group">
            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
            <label for="inputEmail">Email address</label>
        </div>

        <div class="form-label-group">
            <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
            <label for="inputPassword">Password</label>
        </div>
        <p><a href="/" class="float-left">Login</a> <a class="float-right" href="/forgot-password">Forgot Password</a></p>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
    </form>
<?php include_view('/common/header.php') ?>