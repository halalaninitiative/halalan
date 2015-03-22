<h1>Manage parties <small>Event: <?php echo $this->session->userdata('manage_event_event'); ?></small></h1>
<ul class="nav nav-pills nav-admin">
  <li class="active"><?php echo anchor('admin/parties', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li><?php echo anchor('admin/parties/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Party</th>
      <th>Alias</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($parties as $i => $party): ?>
    <tr>
      <td class="text-center"><?php echo $i + 1; ?></td>
      <td><?php echo $party['party']; ?></td>
      <td><?php echo $party['alias']; ?></td>
      <td><?php echo $party['description']; ?></td>
      <td>
        <?php echo anchor('admin/parties/edit/' . $party['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/parties/delete/' . $party['id'], '<span class="glyphicon glyphicon-trash"></span> Delete', 'class="btn btn-danger"'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
