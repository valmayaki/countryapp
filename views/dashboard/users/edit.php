<?php include_view('dashboard/common/header.php'); ?>
    <section class="app-content">
            <div class="form-container">
                <?php if($error = app()->get('request')->has('message')) : ?>
                    <p class="<?php echo app()->get('request')->get('error')? 'error': 'success'?>"><?php echo app()->get('request')->get('message'); ?></p>
                <?php endif ?>
                <form action="/dashboard/users/<?php echo $user->id?>/edit" method="post">
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" name="firstname" value="<?php echo $user->firstname?>" />
                    </div>
                    <div class="form-group">
                        <label>Last name</label>
                        <input type="text" name="lastname" value="<?php echo $user->lastname?>" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" value="<?php echo $user->email?>" />
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role_id">
                            <?php foreach($roles as $role): ?>
                                <option value="<?php echo $role->id?>" <?php echo $user->role_id == $role->id? 'selected' : '';?>><?php echo $role->name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Account Status</label>
                        <input type="radio" name="enable" value="1" <?php echo $user->enable? 'checked': '';?> /><span>Enable</span>
                        <input type="radio" name="enable" value="0" <?php echo !$user->enable? 'checked': '';?> /><span>Disable</span>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="/dashboard/users" class="btn btn-outline-secondary" role="button">Cancel</a>
                </form>
            </div>
        </section>
<?php include_view('/dashboard/common/footer.php') ?>