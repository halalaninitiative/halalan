<h1>Manage administrators</h1>
<ul class="nav nav-pills nav-admin">
  <li class="active"><?php echo anchor('admin/admins', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li><?php echo anchor('admin/admins/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
</ul>
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Username</th>
      <th>Last Name</th>
      <th>First Name</th>
      <th>Type</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($admins as $i => $admin): ?>
    <tr>
      <td class="text-center"><?php echo $i + 1; ?></td>
      <td><?php echo $admin['username']; ?></td>
      <td><?php echo $admin['last_name']; ?></td>
      <td><?php echo $admin['first_name']; ?></td>
      <td><?php echo ucfirst($admin['type']); ?></td>
      <td>
        <?php echo anchor('admin/admins/edit/' . $admin['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/admins/delete/' . $admin['id'], '<span class="glyphicon glyphicon-trash"></span> Delete', 'class="btn btn-danger"'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
