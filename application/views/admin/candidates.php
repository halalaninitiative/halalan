<h1>Manage candidates <small>Election: <?php echo $this->session->userdata('manage_election_election'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li class="active"><?php echo anchor('admin/candidates', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li><?php echo anchor('admin/candidates/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Position</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Alias</th>
      <th>Party</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($candidates as $i => $candidate): ?>
    <tr>
      <td class="text-center"><?php echo $i + 1; ?></td>
      <td><?php echo $candidate['position']; ?></td>
      <td><?php echo $candidate['last_name']; ?></td>
      <td><?php echo $candidate['first_name']; ?></td>
      <td><?php echo $candidate['alias']; ?></td>
      <td><?php echo $candidate['party']; ?></td>
      <td>
        <?php echo anchor('admin/candidates/manage/' . $candidate['id'], '<span class="glyphicon glyphicon-wrench"></span> Manage', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/candidates/edit/' . $candidate['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/candidates/delete/' . $candidate['id'], '<span class="glyphicon glyphicon-trash"></span> Delete', 'class="btn btn-danger"'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
