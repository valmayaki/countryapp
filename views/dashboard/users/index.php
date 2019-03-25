<?php include_view('dashboard/common/header.php'); ?>
<section class="app-content">
    <div class="">
      <table class="table table-striped">
          <thead>
            <tr>
                <th>Firstname</th>
                <th>lastname</th>
                <th>Email</th>
                <th>Account Status</th>
                <th>Actions</th>
            </tr>
          </thead>
          <tbody>
              <?php if ($users && count($users) > 0) : ?>
                <?php foreach($users as $user):?>
                <tr>
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
</section>
<?php include_view('/dashboard/common/header.php') ?>