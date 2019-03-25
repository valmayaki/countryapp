<?php include_view('common/header.php'); ?>
    <!-- <div class="content">
    <section>
            <div class="form-container"> -->
                
            <form class="form-signin" action="/auth/login" method="post">
                <div class="text-center mb-4">          
                    <h1 class="h3 mb-3 font-weight-normal">WELCOME</h1>
                    <?php if($error = app()->get('request')->has('message')) : ?>
                        <p class="<?php echo app()->get('request')->get('error')? 'error': 'success'?>"><?php echo app()->get('request')->get('message'); ?></p>
                    <?php endif ?>
                </div>

                <div class="form-label-group">
                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required="" autofocus="">
                    <label for="inputEmail">Email address</label>
                </div>

                <div class="form-label-group">
                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required="">
                    <label for="inputPassword">Password</label>
                </div>
                <p><a href="/register" class="float-left">Register</a> <a class="float-right" href="/forgot-password">Forgot Password</a></p>
                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>
        <!-- </section>
    </div> -->
<?php include_view('/common/header.php') ?>