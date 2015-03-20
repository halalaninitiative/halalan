<h1>Manage events</h1>
<ul class="nav nav-pills nav-admin">
  <li class="active"><?php echo anchor('admin/events', '<span class="glyphicon glyphicon-list"></span> List all'); ?></li>
  <li><?php echo anchor('admin/events/add', '<span class="glyphicon glyphicon-plus"></span> Add new'); ?></li>
</ul>
<?php echo alert(validation_errors('&nbsp;', '<br />'), $this->session->flashdata('messages')); ?>
<table class="table table-bordered table-striped table-hover">
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>Event</th>
      <th>Slug</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($events as $i => $event): ?>
    <tr>
      <td class="text-center"><?php echo $i + 1; ?></td>
      <td><?php echo $event['event']; ?></td>
      <td><?php echo $event['slug']; ?></td>
      <td>
        <?php echo anchor('admin/events/manage/' . $event['id'], '<span class="glyphicon glyphicon-wrench"></span> Manage', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/events/edit/' . $event['id'], '<span class="glyphicon glyphicon-pencil"></span> Edit', 'class="btn btn-default"'); ?>
        <?php echo anchor('admin/events/delete/' . $event['id'], '<span class="glyphicon glyphicon-trash"></span> Delete', 'class="btn btn-danger"'); ?>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
