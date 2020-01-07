<?php include_view('dashboard/common/header.php'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
  <h1 class="h2">Users</h1>
  <div class="btn-toolbar mb-2 mb-md-0">
    <!-- <div class="btn-group mr-2">
      <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
      <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
    </div> -->
    <!-- <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
      This week
    </button> -->
  </div>
</div>
<section class="">
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
                        <p><?php echo $user->email; ?></p>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <p><?php echo array_filter($roles, function($role)use($user){ return $role->id == $user->role;})[0]->name;?></p>
                    </div>
                    <div class="form-group">
                        <label>Account Status</label>
                        <p><?php echo $user->enable? 'Enabled' : 'Disabled';?></p>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                    <a href="/dashboard" class="btn btn-outline-secondary" role="button">Cancel</a>
                </form>
            </div>
        </section>
<?php include_view('/dashboard/common/header.php') ?>