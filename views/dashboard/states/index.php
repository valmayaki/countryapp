<?php include_view('dashboard/common/header.php'); ?>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
  <h1 class="h2"><?php echo ucwords($country->name);?> States</h1>
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
<div class="table-responsive">
  <table class="table table-striped table-sm">
      <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
        </tr>
      </thead>
      <tbody>
          <?php if ($states && count($states) > 0) : ?>
          <?php foreach($states as $state):?>
          <tr>
              <td><?php echo $data['offset']++ ?></td>
              <td><?php echo $state->name ?></td>
          </tr>
        <?php endforeach;?>
        <?php else: ?>
            <tr><td colspan="3">No state available</td></tr>
        <?php endif; ?>
      </tbody>
      <tfoot>
        <tr>
          <?php if($countries && count($countries) > 0 ): ?>
            <td colspan="4">
              <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item <?php echo $data['page'] == 1? 'disabled' : '' ?>"><a class="page-link" href="<?php echo $data['previous_page']; ?>">Previous</a></li>
                    <li class="page-item <?php echo $data['page'] == 1 ? 'active': '';?>"><a class="page-link" href="?page=1">1</a></li>
                    <?php $start = abs(($data['page'] - 3)); $end=(($data['page'] + 3) + 1);?>
                    <?php for ($x = $start; $x < $end; $x++): ?> 
                    <?php if(($x > 0) && ($x <= $data['totalPages']) && $x !==1) : ?>
                        
                            <?php if($x == $data['page']) : ?>
                                <li class="page-item <?php echo $x== $data['page']? 'active': '';?>"><a class="page-link" href="#"><?php echo $x; ?></a></li>
                            <?php else: ?>
                                <li class="page-item "><a class="page-link" href="<?php echo sprintf('?page=%d', $x); ?>"><?php echo $x; ?></a></li>
                            <?php endif;?>
                        <?php endif;?>
                    <?php endfor; ?> 
                    <li class="page-item <?php echo $data['page'] == $data['totalPages']? 'disabled' : '' ?>"><a class="page-link" href="<?php echo $data['next_page'];?>">Next</a></li>
                    </ul>
                    <span class="float-right"><?php echo sprintf('%d of %d', $data['page'], $data['totalPages']); ?></span>
            </nav>
            </td>
          <?php endif; ?>
        </tr>
      </tfoot>
  </table>
</div>
  
<?php include_view('dashboard/common/footer.php') ?>