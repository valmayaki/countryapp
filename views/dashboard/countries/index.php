<?php include_view('dashboard/common/header.php'); ?>
    <section>
      <table>
          <thead>
            <tr>
                <th>Name</th>
                <th>code</th>
                <th>Email</th>
                <th>Account Status</th>
            </tr>
          </thead>
          <tbody>
              <?php if ($countries && count($countries) > 0) : ?>
              <?php foreach($countries as $country):?>
              <tr>
                  <td><?php echo $country->name ?></td>
                  <td><?php echo $country->sortname ?></td>
                  <td><?php echo $country->phonecode ?></td>
              </tr>
            <?php endforeach;?>
            <?php else: ?>
                <tr><td colspan="4">No country available</td></tr>
            <?php endif; ?>
          </tbody>
      </table>
    </section>
<?php include_view('dashboard/common/footer.php') ?>