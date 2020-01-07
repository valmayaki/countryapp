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
<!-- <section class="app-content"> -->
<div class="table-responsive">
  <table class="table table-striped table-sm">
      <thead>
        <tr>
            <th>#</th>
            <th>Firstname</th>
            <th>lastname</th>
            <th>Email</th>
            <th>Account Status</th>
            <th>Actions</th>
        </tr>
      </thead>
      <tbody>
          <?php if ($users && count($users) > 0) : ?>
            <?php foreach($users as $key => $user):?>
            <tr>
                <td><?php echo $key + 1; ?></td>
                <td><?php echo $user->firstname ?></td>
                <td><?php echo $user->lastname ?></td>
                <td><?php echo $user->email ?></td>
                <td><?php echo $user->enable? 'Enabled' : 'Disabled' ?></td>
                <td><a href="/dashboard/users/<?php echo $user->id; ?>"><i class="fas fa-edit"></i>Edit</a></td>
            </tr>
            <?php endforeach;?>
        <?php else: ?>
            <tr><td colspan="4">No Users Available</td></tr>
        <?php endif; ?>
      </tbody>
  </table>
</div>
<!-- </section> -->
<?php include_view('/dashboard/common/header.php') ?>