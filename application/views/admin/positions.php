<h1>Manage positions <small>Election: <?php echo $this->session->userdata('manage_election_election'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li class="active"><?php echo anchor('admin/positions', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li><?php echo anchor('admin/positions/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Position</th>
      <th>Maximum</th>
      <th>Abstain</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($positions as $i => $position): ?>
    <tr>
      <td class="text-center"><?php echo $i + 1; ?></td>
      <td><?php echo $position['position']; ?></td>
      <td><?php echo $position['maximum']; ?></td>
      <td><?php echo $position['abstain'] ? 'Yes' : 'No'; ?></td>
      <td>
        <?php echo anchor('admin/positions/edit/' . $position['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/positions/delete/' . $position['id'], '<span class="glyphicon glyphicon-trash"></span> Delete', 'class="btn btn-danger"'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
